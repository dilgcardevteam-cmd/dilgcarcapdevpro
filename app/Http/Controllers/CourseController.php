<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\AcademicYear;
use App\Models\Assessment;
use App\Models\ExamEssayResponse;
use App\Models\Grade;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use App\Traits\HandlesCertification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Mail\IncompleteActivityReminder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    use HandlesCertification;

    private function allowedSubjectAreas(): array
    {
        $allowed = \App\Models\Course::subjectAreaOptions();
        $legacy = array_keys(\App\Models\Course::legacySubjectAreaMap());
        return array_values(array_unique(array_merge($allowed, $legacy)));
    }

    /**
     * Remove large inline media from rich HTML to keep JSON small and safe.
     * - Strips <img src="data:..."> and replaces with a small placeholder
     * - Strips <video>...</video> and <source src="blob:...">
     * - Trims excessive whitespace
     */
    protected function scrubHtml(?string $html): string
    {
        if (!$html) return '';
        // Remove <img> tags that embed base64 data
        $html = preg_replace('/<img[^>]*src="data:[^"]+"[^>]*>/i', '<p>[image removed]</p>', $html);
        // Remove <source> tags with blob URLs
        $html = preg_replace('/<source[^>]*src="blob:[^"]+"[^>]*>/i', '', $html);
        // Remove entire <video> blocks
        $html = preg_replace('/<video[^>]*>.*?<\/video>/is', '<p>[video removed]</p>', $html);
        // Remove known third-party image hosts that often return 403/hotlink failures.
        $html = preg_replace('/<(img|source|iframe)[^>]*(src|href)=["\']https?:\/\/[^"\']*googleusercontent\.com[^"\']*["\'][^>]*>/i', '', $html);
        $html = $this->normalizeRichHtmlMediaUrls($html);
        // Safety: collapse long spaces
        $html = preg_replace('/\s{2,}/', ' ', $html);
        // Optional safety cap to avoid oversized payloads
        if (strlen($html) > 50000) {
            $html = substr($html, 0, 50000) . '…';
        }
        return $html;
    }

    /**
     * Convert editor media URLs to this app's streaming media route.
     *
     * Hostinger/shared hosting deployments can fail to serve /storage symlinks,
     * and a stale APP_URL can save localhost/full-domain URLs into course HTML.
     * Keeping course content on relative /media URLs makes trainee display
     * independent from both issues without changing where files are stored.
     */
    protected function normalizeRichHtmlMediaUrls(?string $html): string
    {
        if (!$html) {
            return '';
        }

        return preg_replace_callback(
            '/\b(src|href)=([\'"])([^\'"]+)\2/i',
            function ($matches) {
                $attribute = $matches[1];
                $quote = $matches[2];
                $url = trim((string) $matches[3]);
                $mediaPath = $this->extractPublicMediaPath($url);

                if ($mediaPath === null) {
                    return $matches[0];
                }

                return $attribute . '=' . $quote . route('media.public', ['path' => $mediaPath], false) . $quote;
            },
            $html
        );
    }

    protected function extractPublicMediaPath(string $url): ?string
    {
        $url = trim($url);
        if ($url === '' || str_starts_with($url, 'data:') || str_starts_with($url, 'blob:')) {
            return null;
        }

        $path = $url;
        if (preg_match('#^https?://#i', $url)) {
            $parsedPath = parse_url($url, PHP_URL_PATH);
            $path = is_string($parsedPath) ? $parsedPath : '';
            if (!preg_match('#/(media|storage|public)/#i', $path)) {
                return null;
            }
        } elseif (!preg_match('#^(media|storage|public)/#i', ltrim($path, '/'))) {
            return null;
        }

        $path = ltrim($path, '/');
        foreach (['media/', 'storage/', 'public/'] as $prefix) {
            $position = stripos($path, $prefix);
            if ($position !== false) {
                $path = substr($path, $position + strlen($prefix));
                break;
            }
        }

        $path = ltrim($path, '/');
        if ($path === '' || str_contains($path, '..')) {
            return null;
        }

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'], true) ? $path : null;
    }

    protected function normalizeCourseMediaUrls(Course $course): void
    {
        $modules = $course->modules;
        if (is_string($modules)) {
            $modules = json_decode($modules, true) ?: [];
        }
        if (!is_array($modules)) {
            return;
        }

        $course->modules = $this->normalizeModuleMediaUrls($modules);
    }

    protected function normalizeModuleMediaUrls(array $value): array
    {
        foreach ($value as $key => $item) {
            if ($key === 'html' && is_string($item)) {
                $value[$key] = $this->normalizeRichHtmlMediaUrls($item);
            } elseif (is_array($item)) {
                $value[$key] = $this->normalizeModuleMediaUrls($item);
            }
        }

        return $value;
    }

    /**
     * Sanitize an array of field objects in-place.
     */
    protected function sanitizeFields(?array $fields): ?array
    {
        if (!$fields || !is_array($fields)) return $fields;
        foreach ($fields as &$f) {
            if (isset($f['type']) && $f['type'] === 'text') {
                $f['html'] = $this->scrubHtml($f['html'] ?? '');
            }
        }
        return $fields;
    }

    /**
     * Persist uploaded course-level materials to the canonical materials table.
     */
    protected function storeUploadedMaterials(Request $request, Course $course): void
    {
        if (!$request->hasFile('materials')) {
            return;
        }

        Storage::disk('public')->makeDirectory('materials');

        foreach (array_filter((array) $request->file('materials')) as $file) {
            if (!$file || !$file->isValid()) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'materials' => 'One of the uploaded materials is invalid or incomplete.',
                ]);
            }

            $storedPath = null;

            try {
                $storedPath = $file->store('materials', 'public');
                $originalName = $file->getClientOriginalName() ?: basename($storedPath);

                $material = $course->materials()->create([
                    'title' => $originalName,
                    'description' => null,
                    'file_path' => $storedPath,
                    'type' => 'file',
                ]);

                if ((int) ($material->course_id ?? 0) !== (int) $course->id) {
                    throw new \RuntimeException('Saved material is not linked to the expected course.');
                }
            } catch (\Throwable $e) {
                if ($storedPath) {
                    Storage::disk('public')->delete($storedPath);
                }

                \Log::error('Course material upload linkage failed', [
                    'course_id' => $course->id,
                    'original_name' => $file->getClientOriginalName(),
                    'error' => $e->getMessage(),
                ]);

                throw $e;
            }
        }
    }

    protected function normalizeExamQuestion(array $question): ?array
    {
        $type = (string) ($question['type'] ?? '');
        $text = trim((string) ($question['text'] ?? $question['title'] ?? ''));
        $points = $this->normalizeRequiredExamPoints($question['max_points'] ?? null);

        if ($text === '' || $points === null) {
            return null;
        }

        if ($type === 'multiple_choice') {
            $type = 'multiple_choice_single';
        }

        if ($type === 'multiple_choice_single' || $type === 'multiple_choice_multiple') {
            $choices = $question['choices'] ?? ($question['options'] ?? []);
            $choices = array_values(array_filter(array_map(fn ($value) => trim((string) $value), (array) $choices), fn ($value) => $value !== ''));
            $correctIndexes = $this->normalizeMultipleChoiceCorrectIndexes($question, $choices);

            if (count($choices) < 2) {
                return null;
            }
            $correctIndexes = array_values(array_filter($correctIndexes, fn ($index) => $index >= 0 && $index < count($choices)));
            $requiredCount = $type === 'multiple_choice_single' ? 1 : 1;
            if (count($correctIndexes) < $requiredCount || ($type === 'multiple_choice_single' && count($correctIndexes) !== 1)) {
                return null;
            }

            $correctAnswers = array_map(fn ($index) => $this->choiceIndexToLetter($index), $correctIndexes);

            $normalized = [
                'type' => $type,
                'text' => $text,
                'choices' => $choices,
                'correct_answers' => $correctAnswers,
                'max_points' => $points,
            ];
            if ($type === 'multiple_choice_single') {
                $normalized['answer_index'] = $correctIndexes[0];
            }

            return $normalized;
        }

        if ($type === 'identification') {
            return [
                'type' => 'identification',
                'text' => $text,
                'teacher_notes' => trim((string) ($question['teacher_notes'] ?? $question['answer'] ?? '')),
                'accepted_answers' => $this->normalizeEnumerationAnswers($question['accepted_answers'] ?? ($question['answers'] ?? [])),
                'max_points' => $points,
            ];
        }

        if ($type === 'true_false') {
            $rawAnswer = $question['answer'] ?? null;
            $answer = filter_var($rawAnswer, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($answer === null && is_bool($rawAnswer)) {
                $answer = $rawAnswer;
            }
            if ($answer === null) {
                return null;
            }

            return [
                'type' => 'true_false',
                'text' => $text,
                'answer' => $answer,
                'max_points' => $points,
            ];
        }

        if ($type === 'essay') {
            return [
                'type' => 'essay',
                'text' => $text,
                'instructions' => trim((string) ($question['instructions'] ?? $question['notes'] ?? '')),
                'max_points' => $points,
            ];
        }

        if ($type === 'enumeration') {
            $requiredAnswers = isset($question['required_answers_count']) && is_numeric($question['required_answers_count'])
                ? max(1, (int) $question['required_answers_count'])
                : max(1, count($this->normalizeEnumerationAnswers($question['answers'] ?? ($question['correct_answers'] ?? []))));
            return [
                'type' => 'enumeration',
                'text' => $text,
                'required_answers_count' => $requiredAnswers,
                'expected_guide' => trim((string) ($question['expected_guide'] ?? $question['teacher_notes'] ?? '')),
                'max_points' => $points,
            ];
        }

        return null;
    }

    protected function normalizeRequiredExamPoints($value): ?float
    {
        if ($value === null || $value === '' || !is_numeric($value)) {
            return null;
        }

        $points = (float) $value;
        return $points >= 1 ? round($points, 2) : null;
    }

    protected function normalizeComparableAnswer($value): string
    {
        $value = preg_replace('/\s+/u', ' ', trim((string) $value));
        return mb_strtolower($value, 'UTF-8');
    }

    protected function choiceIndexToLetter(int $index): string
    {
        return chr(65 + $index);
    }

    protected function choiceLetterToIndex(string $letter): ?int
    {
        $letter = strtoupper(trim($letter));
        if (!preg_match('/^[A-Z]$/', $letter)) {
            return null;
        }
        return ord($letter) - 65;
    }

    protected function normalizeMultipleChoiceCorrectIndexes(array $question, array $choices): array
    {
        $rawAnswers = $question['correct_answers'] ?? null;
        if (!is_array($rawAnswers)) {
            $rawAnswers = $rawAnswers === null || $rawAnswers === ''
                ? []
                : preg_split('/\s*,\s*/', (string) $rawAnswers, -1, PREG_SPLIT_NO_EMPTY);
        }
        if (empty($rawAnswers) && array_key_exists('correct_answer', $question)) {
            $rawAnswers = [$question['correct_answer']];
        }
        if (empty($rawAnswers) && isset($question['answer_index'])) {
            $rawAnswers = [$question['answer_index']];
        }

        $choiceLookup = [];
        foreach ($choices as $index => $choice) {
            $choiceLookup[$this->normalizeComparableAnswer($choice)] = $index;
        }

        $indexes = [];
        foreach ($rawAnswers as $rawAnswer) {
            if (is_numeric($rawAnswer)) {
                $indexes[] = (int) $rawAnswer;
                continue;
            }

            $stringAnswer = trim((string) $rawAnswer);
            $letterIndex = $this->choiceLetterToIndex($stringAnswer);
            if ($letterIndex !== null) {
                $indexes[] = $letterIndex;
                continue;
            }

            $key = $this->normalizeComparableAnswer($stringAnswer);
            if ($key !== '' && array_key_exists($key, $choiceLookup)) {
                $indexes[] = $choiceLookup[$key];
            }
        }

        return array_values(array_unique(array_filter($indexes, fn ($index) => is_int($index) && $index >= 0)));
    }

    protected function normalizeEnumerationAnswers($answers): array
    {
        if (!is_array($answers)) {
            $answers = is_string($answers)
                ? preg_split("/\r\n|\n|\r/", $answers)
                : [];
        }

        $normalized = [];
        $seen = [];

        foreach ((array) $answers as $answer) {
            $trimmed = trim((string) $answer);
            if ($trimmed === '') {
                continue;
            }

            $key = $this->normalizeComparableAnswer($trimmed);
            if ($key === '' || isset($seen[$key])) {
                continue;
            }

            $seen[$key] = true;
            $normalized[] = $trimmed;
        }

        return array_values($normalized);
    }

    protected function isManualExamQuestionType(string $type): bool
    {
        return in_array($type, ['essay', 'enumeration', 'identification'], true);
    }

    protected function isObjectiveExamQuestionType(string $type): bool
    {
        if ($type === 'multiple_choice') {
            $type = 'multiple_choice_single';
        }

        return in_array($type, ['multiple_choice_single', 'multiple_choice_multiple', 'true_false'], true);
    }

    protected function formatManualExamAnswerForStorage(string $type, $answer): string
    {
        if ($type === 'enumeration') {
            $answers = is_array($answer) ? $answer : [];
            return implode("\n", array_map(fn ($value) => trim((string) $value), $answers));
        }

        return trim((string) $answer);
    }

    protected function scoreObjectiveQuestion(array $question, $answer): array
    {
        $type = (string) ($question['type'] ?? 'multiple_choice');
        $maxPoints = 1.0;
        $score = 0.0;
        $isCorrect = false;
        $meta = [];

        if ($type === 'multiple_choice') {
            $type = 'multiple_choice_single';
        }

        if ($this->isManualExamQuestionType($type)) {
            $maxPoints = isset($question['max_points']) && is_numeric($question['max_points'])
                ? max(1, (float) $question['max_points'])
                : 1.0;

            return [
                'score' => 0,
                'max_points' => round($maxPoints, 2),
                'is_correct' => false,
                'meta' => ['manual_review_required' => true],
            ];
        }

        if ($type === 'multiple_choice_single' || $type === 'multiple_choice_multiple') {
            $maxPoints = isset($question['max_points']) && is_numeric($question['max_points'])
                ? max(1, (float) $question['max_points'])
                : 1.0;
            $choices = array_values((array) ($question['choices'] ?? $question['options'] ?? []));
            $correctIndexes = $this->normalizeMultipleChoiceCorrectIndexes($question, $choices);
            $submittedIndexes = is_array($answer) ? $answer : ($answer === null || $answer === '' ? [] : [$answer]);
            $submittedIndexes = $this->normalizeMultipleChoiceCorrectIndexes(['correct_answers' => $submittedIndexes], $choices);
            sort($correctIndexes);
            sort($submittedIndexes);
            $isCorrect = $correctIndexes === $submittedIndexes;
            $score = $isCorrect ? $maxPoints : 0.0;
            $meta = [
                'submitted_answers' => array_map(fn ($index) => $this->choiceIndexToLetter($index), $submittedIndexes),
                'correct_answers' => array_map(fn ($index) => $this->choiceIndexToLetter($index), $correctIndexes),
            ];
        } elseif ($type === 'true_false') {
            $maxPoints = isset($question['max_points']) && is_numeric($question['max_points'])
                ? max(1, (float) $question['max_points'])
                : 1.0;
            $expected = $question['answer'] === true ? 'true' : 'false';
            $isCorrect = $answer !== null && strtolower((string) $answer) === $expected;
            $score = $isCorrect ? $maxPoints : 0.0;
        }

        return [
            'score' => round($score, 2),
            'max_points' => round($maxPoints, 2),
            'is_correct' => $isCorrect,
            'meta' => $meta,
        ];
    }

    protected function getCourseModuleExam(Course $course, int $moduleIndex): ?array
    {
        $modules = is_array($course->modules) ? $course->modules : [];
        if (is_string($course->modules)) {
            $modules = json_decode($course->modules, true) ?: [];
        }

        $resolvedModuleIndex = $this->resolveExamModuleIndex($course, $moduleIndex);
        if ($resolvedModuleIndex === null) {
            return null;
        }

        $module = $modules[$resolvedModuleIndex] ?? null;
        $exam = is_array($module['exam'] ?? null) ? $module['exam'] : null;
        if (!$exam) {
            return null;
        }

        $questions = [];
        foreach ((array) ($exam['questions'] ?? []) as $question) {
            if (!is_array($question)) {
                continue;
            }
            $normalized = $this->normalizeExamQuestion($question);
            if ($normalized) {
                $questions[] = $normalized;
            }
        }

        $exam['questions'] = $questions;
        return $exam;
    }

    protected function resolveExamModuleIndex(Course $course, int $moduleIndex): ?int
    {
        $modules = $this->getNormalizedCourseModules($course);
        $module = $modules[$moduleIndex] ?? null;
        $examQuestions = is_array($module['exam']['questions'] ?? null) ? $module['exam']['questions'] : [];
        if (!empty($examQuestions)) {
            return $moduleIndex;
        }

        $nextModule = $modules[$moduleIndex + 1] ?? null;
        $nextTopics = isset($nextModule['topics']) && is_array($nextModule['topics']) ? $nextModule['topics'] : [];
        $nextExamQuestions = is_array($nextModule['exam']['questions'] ?? null) ? $nextModule['exam']['questions'] : [];
        if (!empty($nextExamQuestions) && empty($nextTopics)) {
            return $moduleIndex + 1;
        }

        return null;
    }

    protected function syncManualResponsesForSubmission(Course $course, User $trainee, int $moduleIndex, array $questions, array $answers, string $submittedAt, ?int $topicIndex = null, ?int $subIndex = null): array
    {
        $manualIndexes = [];

        foreach ($questions as $questionIndex => $question) {
            $type = (string) ($question['type'] ?? '');
            if (! $this->isManualExamQuestionType($type)) {
                continue;
            }

            $manualIndexes[] = $questionIndex;
            $answerText = $this->formatManualExamAnswerForStorage($type, $answers[$questionIndex] ?? null);

            ExamEssayResponse::updateOrCreate(
                [
                    'course_id' => $course->id,
                    'trainee_id' => $trainee->id,
                    'module_index' => $moduleIndex,
                    'topic_index' => $topicIndex,
                    'sub_index' => $subIndex,
                    'question_index' => $questionIndex,
                ],
                [
                    'question_text' => (string) ($question['text'] ?? ''),
                    'answer_text' => $answerText,
                    'max_points' => isset($question['max_points']) && is_numeric($question['max_points'])
                        ? max(1, (float) $question['max_points'])
                        : 1,
                    'score' => null,
                    'feedback' => null,
                    'checked_by_trainer' => null,
                    'checked_at' => null,
                    'status' => 'pending',
                    'submitted_at' => $submittedAt,
                ]
            );
        }

        if (!empty($manualIndexes)) {
            ExamEssayResponse::where('course_id', $course->id)
                ->where('trainee_id', $trainee->id)
                ->where('module_index', $moduleIndex)
                ->where('topic_index', $topicIndex)
                ->where('sub_index', $subIndex)
                ->whereNotIn('question_index', $manualIndexes)
                ->delete();
        } else {
            ExamEssayResponse::where('course_id', $course->id)
                ->where('trainee_id', $trainee->id)
                ->where('module_index', $moduleIndex)
                ->where('topic_index', $topicIndex)
                ->where('sub_index', $subIndex)
                ->delete();
        }

        return $manualIndexes;
    }

    protected function syncEssayResponsesForSubmission(Course $course, User $trainee, int $moduleIndex, array $questions, array $answers, string $submittedAt): array
    {
        return $this->syncManualResponsesForSubmission($course, $trainee, $moduleIndex, $questions, $answers, $submittedAt);
    }

    protected function buildModuleExamAttemptSummary(Course $course, int $moduleIndex, int $userId, ?array $submission = null): ?array
    {
        $mi = $moduleIndex;
        $ti = $submission['topic_index'] ?? null;
        $si = $submission['sub_index'] ?? null;
        $isTopicQuiz = ($ti !== null && $si !== null);

        if ($isTopicQuiz) {
            $exam = $this->getTopicQuizData($course, $mi, $ti, $si);
            $resolvedModuleIndex = $mi;
        } else {
            $exam = $this->getCourseModuleExam($course, $moduleIndex);
            $resolvedModuleIndex = $this->resolveExamModuleIndex($course, $moduleIndex);
        }

        if (!$exam || $resolvedModuleIndex === null) {
            return null;
        }

        if ($submission === null) {
            $filename = 'mi_'.$resolvedModuleIndex;
            if ($isTopicQuiz) {
                $filename .= '_ti_'.$ti.'_si_'.$si;
            }
            $filename .= '_u_'.$userId.'.json';
            
            $file = storage_path('app/exam_submissions/course_'.$course->id.DIRECTORY_SEPARATOR.$filename);
            if (!is_file($file)) {
                return $this->getLatestFinalExamSummaryFromGrade($course, $moduleIndex, $userId, $resolvedModuleIndex, $ti, $si);
            }
            $submission = json_decode((string) @file_get_contents($file), true) ?: null;
            
            // Check if the submission file is for a different assessment (title mismatch or missing title)
            $fileExamTitle = $submission['exam_title'] ?? null;
            $currentExamTitle = $exam['title'] ?? ($isTopicQuiz ? 'Topic Quiz' : 'Module Exam');
            if ($submission && $fileExamTitle !== $currentExamTitle) {
                @unlink($file); // Delete stale submission file
                return $this->getLatestFinalExamSummaryFromGrade($course, $moduleIndex, $userId, $resolvedModuleIndex, $ti, $si);
            }
        }

        if (!$submission) {
            return $this->getLatestFinalExamSummaryFromGrade($course, $moduleIndex, $userId, $resolvedModuleIndex, $ti, $si);
        }

        $questions = is_array($exam['questions'] ?? null) ? $exam['questions'] : [];
        $answers = is_array($submission['answers'] ?? null) ? $submission['answers'] : [];
        $manualRows = ExamEssayResponse::where('course_id', $course->id)
            ->where('trainee_id', $userId)
            ->where('module_index', $resolvedModuleIndex)
            ->where('topic_index', $ti)
            ->where('sub_index', $si)
            ->get()
            ->keyBy('question_index');

        $objectiveTotal = 0.0;
        $objectiveCorrect = 0.0;
        $manualTotal = 0.0;
        $manualCheckedScore = 0.0;
        $pendingManualCount = 0;
        $checkedManualCount = 0;
        $items = [];

        foreach ($questions as $questionIndex => $question) {
            $type = (string) ($question['type'] ?? 'multiple_choice');
            $answer = $answers[$questionIndex] ?? null;

            if ($this->isManualExamQuestionType($type)) {
                $row = $manualRows->get($questionIndex);
                $maxPoints = isset($question['max_points']) && is_numeric($question['max_points'])
                    ? max(1, (float) $question['max_points'])
                    : 1.0;
                $manualTotal += $maxPoints;

                $status = $row?->status ?? 'pending';
                if ($status === 'checked' && $row?->score !== null) {
                    $checkedManualCount++;
                    $manualCheckedScore += (float) $row->score;
                } else {
                    $pendingManualCount++;
                }

                $answerText = $row?->answer_text ?? $this->formatManualExamAnswerForStorage($type, $answer);
                $items[] = [
                    'question_index' => $questionIndex,
                    'type' => $type,
                    'text' => (string) ($question['text'] ?? ''),
                    'answer' => $type === 'enumeration'
                        ? preg_split("/\r\n|\n|\r/", (string) $answerText, -1, PREG_SPLIT_NO_EMPTY)
                        : $answerText,
                    'answer_text' => $answerText,
                    'required_answers_count' => $type === 'enumeration'
                        ? (isset($question['required_answers_count']) && is_numeric($question['required_answers_count'])
                            ? max(1, (int) $question['required_answers_count'])
                            : count(preg_split("/\r\n|\n|\r/", (string) $answerText, -1, PREG_SPLIT_NO_EMPTY)))
                        : null,
                    'score' => $row?->score !== null ? (float) $row->score : null,
                    'max_points' => $maxPoints,
                    'feedback' => $row?->feedback,
                    'status' => $status,
                    'checked_by_trainer' => $row?->checked_by_trainer,
                    'checked_at' => optional($row?->checked_at)->toIso8601String(),
                ];
                continue;
            }

            if (! $this->isObjectiveExamQuestionType($type)) {
                continue;
            }

            $scored = $this->scoreObjectiveQuestion($question, $answer);
            $objectiveTotal += (float) ($scored['max_points'] ?? 0);
            $objectiveCorrect += (float) ($scored['score'] ?? 0);

            $item = [
                'question_index' => $questionIndex,
                'type' => $type,
                'text' => (string) ($question['text'] ?? ''),
                'answer' => $answer,
                'is_correct' => (bool) ($scored['is_correct'] ?? false),
                'score' => (float) ($scored['score'] ?? 0),
                'max_points' => (float) ($scored['max_points'] ?? 1),
            ];
            $items[] = $item;
        }

        $objectivePct = $objectiveTotal > 0 ? (int) round(($objectiveCorrect / $objectiveTotal) * 100) : 0;
        $totalPossiblePoints = $objectiveTotal + $manualTotal;
        $earnedPoints = $objectiveCorrect + $manualCheckedScore;
        $finalPct = $totalPossiblePoints > 0 ? (int) round(($earnedPoints / $totalPossiblePoints) * 100) : 0;
        [$passingScore, $maxAttempts] = $this->getExamConfigValues($exam);
        $integrity = $this->normalizeExamIntegrityPayload($submission['exam_integrity'] ?? null);

        $status = 'completed';
        if ($pendingManualCount > 0 && $checkedManualCount === 0) {
            $status = 'pending_review';
        } elseif ($pendingManualCount > 0) {
            $status = 'partially_graded';
        }
        $passed = $status === 'completed' ? ($finalPct >= $passingScore) : null;

        return [
            'course_id' => $course->id,
            'user_id' => $userId,
            'module_index' => $moduleIndex,
            'submitted_at' => $submission['submitted_at'] ?? null,
            'objective_correct' => round($objectiveCorrect, 2),
            'objective_total' => round($objectiveTotal, 2),
            'objective_pct' => $objectivePct,
            'essay_checked_score' => round($manualCheckedScore, 2),
            'essay_total_points' => round($manualTotal, 2),
            'essay_pending_count' => $pendingManualCount,
            'essay_checked_count' => $checkedManualCount,
            'manual_checked_score' => round($manualCheckedScore, 2),
            'manual_total_points' => round($manualTotal, 2),
            'manual_pending_count' => $pendingManualCount,
            'manual_checked_count' => $checkedManualCount,
            'final_pct' => $finalPct,
            'status' => $status,
            'status_label' => match ($status) {
                'pending_review' => 'Pending Manual Review',
                'partially_graded' => 'Partially Graded',
                default => ($passed === false ? 'Failed' : 'Passed'),
            },
            'passing_score' => $passingScore,
            'max_attempts' => $maxAttempts,
            'passed' => $passed,
            'items' => $items,
            'contains_essay' => collect($items)->contains(fn ($item) => ($item['type'] ?? null) === 'essay'),
            'contains_manual_review' => ($pendingManualCount + $checkedManualCount) > 0,
            'exam_integrity' => $integrity,
            'violation_count' => (int) ($integrity['violations'] ?? 0),
            'auto_submitted' => (bool) ($integrity['auto_submitted'] ?? false),
        ];
    }

    protected function normalizeExamIntegrityPayload($integrity): array
    {
        if (!is_array($integrity)) {
            return [
                'violations' => 0,
                'warning_threshold' => 1,
                'auto_submit_threshold' => 3,
                'auto_submitted' => false,
                'last_reason' => null,
                'events' => [],
            ];
        }

        $events = [];
        foreach (($integrity['events'] ?? []) as $event) {
            if (!is_array($event)) {
                continue;
            }

            $type = trim((string) ($event['type'] ?? ''));
            if ($type === '') {
                continue;
            }

            $events[] = [
                'type' => $type,
                'at' => isset($event['at']) ? (string) $event['at'] : null,
                'count' => max(1, (int) ($event['count'] ?? 1)),
            ];
        }

        return [
            'violations' => max(0, (int) ($integrity['violations'] ?? count($events))),
            'warning_threshold' => max(1, (int) ($integrity['warning_threshold'] ?? 1)),
            'auto_submit_threshold' => max(1, (int) ($integrity['auto_submit_threshold'] ?? 3)),
            'auto_submitted' => (bool) ($integrity['auto_submitted'] ?? false),
            'last_reason' => (($reason = trim((string) ($integrity['last_reason'] ?? ''))) !== '') ? $reason : null,
            'events' => array_slice($events, -20),
        ];
    }

    protected function getLatestFinalExamSummaryFromGrade(Course $course, int $moduleIndex, int $userId, ?int $resolvedModuleIndex = null, ?int $topicIndex = null, ?int $subIndex = null): ?array
    {
        $isTopicQuiz = ($topicIndex !== null && $subIndex !== null);
        if ($isTopicQuiz) {
            $exam = $this->getTopicQuizData($course, $moduleIndex, $topicIndex, $subIndex);
        } else {
            $exam = $this->getCourseModuleExam($course, $moduleIndex);
        }
        
        if (!$exam) {
            return null;
        }

        if ($resolvedModuleIndex === null) {
            $resolvedModuleIndex = $isTopicQuiz ? $moduleIndex : $this->resolveExamModuleIndex($course, $moduleIndex);
        }

        [$passingScore, $maxAttempts] = $this->getExamConfigValues($exam);
        $assessment = $this->getOrCreateAssessment($course, $exam, $passingScore, $maxAttempts, $resolvedModuleIndex, $topicIndex, $subIndex);
        $grade = Grade::where('assessment_id', $assessment->id)
            ->where('user_id', $userId)
            ->latest('id')
            ->first();

        if (!$grade) {
            return null;
        }

        $meta = json_decode((string) ($grade->feedback ?? 'null'), true) ?: [];
        $summary = is_array($meta['summary'] ?? null) ? $meta['summary'] : null;
        if (!$summary) {
            return null;
        }

        $storedModuleIndex = isset($meta['module_index']) ? (int) $meta['module_index'] : null;
        $storedTopicIndex = isset($meta['topic_index']) ? (int) $meta['topic_index'] : null;
        $storedSubIndex = isset($meta['sub_index']) ? (int) $meta['sub_index'] : null;

        if ($resolvedModuleIndex !== null && ($storedModuleIndex === null || $storedModuleIndex !== $resolvedModuleIndex)) {
            return null;
        }
        if ($isTopicQuiz && ($storedTopicIndex !== $topicIndex || $storedSubIndex !== $subIndex)) {
            return null;
        }

        $summary['course_id'] = $course->id;
        $summary['user_id'] = $userId;
        $summary['module_index'] = $moduleIndex;
        $summary['topic_index'] = $topicIndex;
        $summary['sub_index'] = $subIndex;
        $summary['passing_score'] = $summary['passing_score'] ?? $passingScore;
        $summary['max_attempts'] = $summary['max_attempts'] ?? $maxAttempts;
        $summary['attempt_no'] = $summary['attempt_no'] ?? (int) ($grade->attempt_no ?? 0);
        $summary['passed'] = array_key_exists('passed', $summary)
            ? $summary['passed']
            : (($summary['status'] ?? null) === 'completed'
                ? ((float) ($summary['final_pct'] ?? 0) >= (float) ($summary['passing_score'] ?? $passingScore))
                : null);
        $summary['max_attempts_reached'] = ($summary['max_attempts_reached'] ?? false)
            ?? ($maxAttempts !== null && ($summary['passed'] === false) && ((int) ($summary['attempt_no'] ?? 0) >= $maxAttempts));
        $summary['restart_required'] = $summary['restart_required'] ?? false;
        $summary['status_label'] = $summary['status_label']
            ?? match ($summary['status'] ?? 'completed') {
                'pending_review' => 'Pending Manual Review',
                'partially_graded' => 'Partially Graded',
                default => (($summary['passed'] ?? null) === false ? 'Failed' : 'Passed'),
            };

        return $summary;
    }

    protected function getNormalizedCourseModules(Course $course): array
    {
        $modules = $course->modules;
        if (is_string($modules)) {
            $modules = json_decode($modules, true) ?: [];
        }

        return is_array($modules) ? array_values($modules) : [];
    }

    protected function getSequentialContentModuleIndexes(Course $course): array
    {
        $indexes = [];
        foreach ($this->getNormalizedCourseModules($course) as $index => $module) {
            $topics = isset($module['topics']) && is_array($module['topics']) ? $module['topics'] : [];
            if (!empty($topics)) {
                $indexes[] = $index;
            }
        }

        return $indexes;
    }

    protected function getFinalExamModuleIndex(Course $course): ?int
    {
        $modules = $this->getNormalizedCourseModules($course);
        foreach ($modules as $index => $module) {
            $topics = isset($module['topics']) && is_array($module['topics']) ? $module['topics'] : [];
            $examQuestions = is_array($module['exam']['questions'] ?? null) ? $module['exam']['questions'] : [];
            if (!empty($examQuestions)) {
                if (empty($topics) && $index > 0) {
                    $previousModule = $modules[$index - 1] ?? null;
                    $previousTopics = isset($previousModule['topics']) && is_array($previousModule['topics']) ? $previousModule['topics'] : [];
                    if (!empty($previousTopics)) {
                        return $index - 1;
                    }
                }

                return $index;
            }

            $nextModule = $modules[$index + 1] ?? null;
            $nextTopics = isset($nextModule['topics']) && is_array($nextModule['topics']) ? $nextModule['topics'] : [];
            $nextExamQuestions = is_array($nextModule['exam']['questions'] ?? null) ? $nextModule['exam']['questions'] : [];
            if (!empty($nextExamQuestions) && empty($nextTopics)) {
                return $index;
            }
        }

        return null;
    }

    protected function getCourseUserPivot(Course $course, int $userId)
    {
        return $course->users()->where('user_id', $userId)->first()?->pivot;
    }

    protected function getCurrentContentModulePosition(Course $course, int $userId): int
    {
        $pivot = $this->getCourseUserPivot($course, $userId);
        $current = max(1, (int) ($pivot?->current_module ?? 1));
        $count = count($this->getSequentialContentModuleIndexes($course));

        if ($count === 0) {
            return 1;
        }

        return min($current, $count);
    }

    protected function getAllowedModuleArrayIndex(Course $course, int $userId): ?int
    {
        $contentIndexes = $this->getSequentialContentModuleIndexes($course);
        if (empty($contentIndexes)) {
            return $this->getFinalExamModuleIndex($course);
        }

        $position = $this->getCurrentContentModulePosition($course, $userId);
        return $contentIndexes[$position - 1] ?? end($contentIndexes);
    }

    protected function isModuleFullyReflected(Course $course, int $userId, int $moduleIndex): bool
    {
        $modules = $this->getNormalizedCourseModules($course);
        $module = $modules[$moduleIndex] ?? null;
        if (!is_array($module)) {
            return false;
        }

        $topics = isset($module['topics']) && is_array($module['topics']) ? $module['topics'] : [];
        if (empty($topics)) {
            return true;
        }

        $responses = \App\Models\ReflectionResponse::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->where('module_index', $moduleIndex)
            ->get(['topic_index', 'sub_index']);

        $doneTopics = [];
        foreach ($responses as $response) {
            // Topic-level completion is marked by sub_index = -1 or any sub_index if we just want "any" progress.
            // But usually, it's the last subtopic or a specific topic reflection.
            // Based on ReflectionController, topic-level reflections use sub_index = 0 (after normalization from -1).
            $doneTopics[(int) $response->topic_index] = true;
        }

        foreach (array_keys($topics) as $topicIndex) {
            if (empty($doneTopics[$topicIndex])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if a trainee can access a Topic Quiz (subtopic level assessment).
     * Prerequisite: All previous subtopics in the same topic must be completed.
     */
    protected function canAccessTopicQuiz(Course $course, int $userId, int $moduleIndex, int $topicIndex, int $subIndex): bool
    {
        $modules = $this->getNormalizedCourseModules($course);
        $module = $modules[$moduleIndex] ?? null;
        if (!$module || !isset($module['topics'][$topicIndex]['subtopics'])) {
            return false;
        }

        $subtopics = $module['topics'][$topicIndex]['subtopics'];
        
        // Check all subtopics before the requested one
        for ($i = 0; $i < $subIndex; $i++) {
            if (!$this->isSubtopicCompleted($course, $userId, $moduleIndex, $topicIndex, $i)) {
                return false;
            }
        }
        
        return true;
    }

    protected function isSubtopicCompleted(Course $course, int $userId, int $moduleIndex, int $topicIndex, int $subIndex): bool
    {
        return \App\Models\ReflectionResponse::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->where('module_index', $moduleIndex)
            ->where('topic_index', $topicIndex)
            ->where('sub_index', $subIndex)
            ->exists();
    }

    /**
     * Check if a trainee can access a Module Exam (standalone or module-level assessment).
     * Prerequisite: All topics in the module must be completed.
     */
    protected function canAccessModuleExam(Course $course, int $userId, int $moduleIndex): bool
    {
        // For standalone exams (no topics), we usually require all previous modules to be completed.
        $modules = $this->getNormalizedCourseModules($course);
        $module = $modules[$moduleIndex] ?? null;
        $topics = isset($module['topics']) && is_array($module['topics']) ? $module['topics'] : [];
        
        if (empty($topics)) {
            // Standalone exam: Check if all previous modules with content are done
            foreach ($this->getSequentialContentModuleIndexes($course) as $idx) {
                if ($idx >= $moduleIndex) break;
                if (!$this->isModuleFullyReflected($course, $userId, $idx)) {
                    return false;
                }
            }
            return true;
        }

        // Module-level exam: All topics in this module must be reflected
        return $this->isModuleFullyReflected($course, $userId, $moduleIndex);
    }

    protected function areAllModulesCompleted(Course $course, int $userId): bool
    {
        foreach ($this->getSequentialContentModuleIndexes($course) as $moduleIndex) {
            if (!$this->isModuleFullyReflected($course, $userId, $moduleIndex)) {
                return false;
            }
        }

        return true;
    }

    protected function syncSequentialProgress(Course $course, int $userId): array
    {
        $contentIndexes = $this->getSequentialContentModuleIndexes($course);
        $totalModules = count($contentIndexes);
        $completedModules = 0;

        foreach ($contentIndexes as $position => $moduleIndex) {
            if ($this->isModuleFullyReflected($course, $userId, $moduleIndex)) {
                $completedModules = $position + 1;
                continue;
            }
            break;
        }

        $currentModule = $totalModules > 0
            ? min($completedModules + 1, $totalModules)
            : 1;
        $progress = $totalModules > 0
            ? round(($completedModules / $totalModules) * 100, 2)
            : 0.0;
        $existingStatus = (string) ($this->getCourseUserPivot($course, $userId)?->status ?? '');
        $finalExamModuleIndex = $this->getFinalExamModuleIndex($course);
        $latestExamSummary = $finalExamModuleIndex !== null
            ? $this->getLatestFinalExamSummaryFromGrade($course, $finalExamModuleIndex, $userId)
            : null;

        $status = $completedModules >= $totalModules && $totalModules > 0
            ? 'ready_for_exam'
            : 'in_progress';
        if (($latestExamSummary['max_attempts_reached'] ?? false) === true) {
            $status = 'attempts_exhausted';
        }
        if ($existingStatus === 'completed'
            || ($existingStatus === 'attempts_exhausted' && (($latestExamSummary['max_attempts_reached'] ?? false) === true))) {
            $status = $existingStatus;
        }

        $course->users()->updateExistingPivot($userId, [
            'current_module' => $currentModule,
            'progress_percentage' => $progress,
            'status' => $status,
        ]);

        return [
            'current_module' => $currentModule,
            'progress_percentage' => $progress,
            'status' => $status,
            'completed_modules' => $completedModules,
            'total_modules' => $totalModules,
        ];
    }

    protected function resetTraineeCourseProgress(Course $course, int $userId, int $moduleIndex, bool $examOnly = false): void
    {
        if (!$examOnly) {
            \App\Models\ReflectionResponse::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->delete();
        }

        ExamEssayResponse::where('course_id', $course->id)
            ->where('trainee_id', $userId)
            ->delete();

        $dir = storage_path('app/exam_submissions/course_'.$course->id);
        if (is_dir($dir)) {
            foreach (glob($dir.DIRECTORY_SEPARATOR.'mi_*_u_'.$userId.'.json') ?: [] as $path) {
                @unlink($path);
            }
        }

        if (!$examOnly) {
            $course->users()->updateExistingPivot($userId, [
                'current_module' => 1,
                'progress_percentage' => 0,
                'status' => 'in_progress',
            ]);
        } else {
            // If exam only, we just clear retake flags and keep progress
            $course->users()->updateExistingPivot($userId, [
                'retake_requested' => false,
                'retake_approved' => false,
                'status' => 'ready_for_exam', // Reset status so they can take it again
            ]);
        }
    }

    protected function markCourseCompleted(Course $course, int $userId): void
    {
        $totalModules = max(1, count($this->getSequentialContentModuleIndexes($course)));
        $course->users()->updateExistingPivot($userId, [
            'current_module' => $totalModules,
            'progress_percentage' => 100,
            'status' => 'completed',
        ]);
    }

    protected function getOrCreateAssessment(Course $course, array $exam, ?int $passingScore, ?int $maxAttempts, ?int $moduleIndex = null, ?int $topicIndex = null, ?int $subIndex = null): Assessment
    {
        $title = trim((string) ($exam['title'] ?? 'Assessment'));
        $searchTitle = $title;

        if ($moduleIndex !== null) {
            if ($topicIndex !== null && $subIndex !== null) {
                $searchTitle = $title . " (M" . ($moduleIndex + 1) . " T" . ($topicIndex + 1) . " S" . ($subIndex + 1) . ")";
            } else {
                $searchTitle = $title . " (Module " . ($moduleIndex + 1) . ")";
            }
        }

        $assessment = Assessment::firstOrNew([
            'course_id' => $course->id,
            'type' => 'exam',
            'title' => $searchTitle,
        ]);

        $assessment->description = (string) ($exam['description'] ?? $assessment->description);
        $assessment->questions_json = $exam['questions'] ?? [];
        $assessment->passing_score = $passingScore;
        $assessment->max_attempts = $maxAttempts;
        $assessment->save();

        return $assessment;
    }

    protected function getTopicQuizData(Course $course, int $mi, int $ti, int $si): ?array
    {
        $modules = $this->getNormalizedCourseModules($course);
        $module = $modules[$mi] ?? null;
        if (!$module || !isset($module['topics'][$ti]['subtopics'][$si])) {
            return null;
        }

        $subtopic = $module['topics'][$ti]['subtopics'][$si];
        $fields = is_string($subtopic['fields_json'] ?? null) 
            ? json_decode($subtopic['fields_json'], true) 
            : ($subtopic['fields'] ?? []);
            
        if (!is_array($fields)) return null;

        $questions = [];
        foreach ($fields as $f) {
            if (($f['type'] ?? '') === 'question' && isset($f['question'])) {
                $questions[] = $this->normalizeExamQuestion($f['question']);
            }
        }

        if (empty($questions)) return null;

        return [
            'title' => $subtopic['title'] ?? 'Topic Quiz',
            'description' => '',
            'timer_minutes' => 0,
            'timer_mode' => 'untimed',
            'passing_score' => 0,
            'max_attempts' => null,
            'questions' => $questions,
        ];
    }

    protected function getExamConfigValues(array $exam): array
    {
        $passingScore = isset($exam['passing_score']) && $exam['passing_score'] !== ''
            ? max(1, min(100, (int) $exam['passing_score']))
            : 75;
        $maxAttempts = isset($exam['max_attempts']) && $exam['max_attempts'] !== ''
            ? max(1, (int) $exam['max_attempts'])
            : (isset($exam['attempt_limit']) && $exam['attempt_limit'] !== '' ? max(1, (int) $exam['attempt_limit']) : null);

        return [$passingScore, $maxAttempts];
    }

    protected function evaluateFinalExamOutcome(Course $course, int $moduleIndex, int $userId, array $summary, array $exam, ?int $topicIndex = null, ?int $subIndex = null): array
    {
        [$passingScore, $maxAttempts] = $this->getExamConfigValues($exam);
        $assessment = $this->getOrCreateAssessment($course, $exam, $passingScore, $maxAttempts, $moduleIndex, $topicIndex, $subIndex);
        $latestGrade = Grade::where('assessment_id', $assessment->id)
            ->where('user_id', $userId)
            ->latest('id')
            ->first();
        $latestMeta = json_decode((string) ($latestGrade?->feedback ?? 'null'), true) ?: [];
        
        $isSameAssessment = (int) ($latestMeta['module_index'] ?? -1) === $moduleIndex
            && (isset($latestMeta['topic_index']) ? (int)$latestMeta['topic_index'] : null) === $topicIndex
            && (isset($latestMeta['sub_index']) ? (int)$latestMeta['sub_index'] : null) === $subIndex;

        $reusePendingAttempt = $latestGrade
            && in_array($latestMeta['status'] ?? null, ['pending_review', 'partially_graded'], true)
            && $isSameAssessment;

        $attemptNo = $reusePendingAttempt
            ? (int) $latestGrade->attempt_no
            : (Grade::where('assessment_id', $assessment->id)
                ->where('user_id', $userId)
                ->get()
                ->filter(function($g) use ($moduleIndex, $topicIndex, $subIndex) {
                    $m = json_decode((string)($g->feedback ?? 'null'), true);
                    return isset($m['module_index']) && (int)$m['module_index'] === $moduleIndex
                        && (isset($m['topic_index']) ? (int)$m['topic_index'] : null) === $topicIndex
                        && (isset($m['sub_index']) ? (int)$m['sub_index'] : null) === $subIndex;
                })
                ->count() + 1);

        // Ensure these are stored in the feedback summary
        $summary['passing_score'] = $passingScore;
        $summary['max_attempts'] = $maxAttempts;
        $summary['attempt_no'] = $attemptNo;
        $summary['passed'] = (($summary['status'] ?? 'completed') === 'completed')
            ? ((float) ($summary['final_pct'] ?? 0) >= $passingScore)
            : null;

        $gradePayload = [
            'score' => (float) ($summary['final_pct'] ?? 0),
            'feedback' => json_encode([
                'course_id' => $course->id,
                'module_index' => $moduleIndex,
                'topic_index' => $topicIndex,
                'sub_index' => $subIndex,
                'status' => $summary['status'] ?? 'completed',
                'summary' => $summary,
            ]),
            'attempt_no' => $attemptNo,
            'is_retake' => $attemptNo > 1,
        ];

        if ($reusePendingAttempt) {
            $latestGrade->update($gradePayload);
        } else {
            Grade::create(array_merge($gradePayload, [
                'assessment_id' => $assessment->id,
                'user_id' => $userId,
            ]));
        }

        if (($summary['status'] ?? null) !== 'completed') {
            return [
                'attempt_no' => $attemptNo,
                'passed' => null,
                'pending_review' => true,
                'passing_score' => $passingScore,
                'max_attempts' => $maxAttempts,
            ];
        }

        $passed = (float) ($summary['final_pct'] ?? 0) >= $passingScore;
        if ($passed) {
            $this->markCourseCompleted($course, $userId);
            return [
                'attempt_no' => $attemptNo,
                'passed' => true,
                'pending_review' => false,
                'passing_score' => $passingScore,
                'max_attempts' => $maxAttempts,
            ];
        }

        if ($maxAttempts !== null && $attemptNo >= $maxAttempts) {
            $course->users()->updateExistingPivot($userId, ['status' => 'attempts_exhausted']);
            return [
                'attempt_no' => $attemptNo,
                'passed' => false,
                'pending_review' => false,
                'max_attempts_reached' => true,
                'passing_score' => $passingScore,
                'max_attempts' => $maxAttempts,
            ];
        }

        // Controlled retake: no automatic reset. The participant must request a retake.
        $course->users()->updateExistingPivot($userId, ['status' => 'failed']);

        return [
            'attempt_no' => $attemptNo,
            'passed' => false,
            'pending_review' => false,
            'restart_required' => false,
            'passing_score' => $passingScore,
            'max_attempts' => $maxAttempts,
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $actorRole = strtolower((string) (auth()->user()->role ?? ''));
        $adminRoles = ['admin','super_admin','central_office_admin','regional_office_admin','provincial_office_admin'];
        $tmRoles = ['training_manager','central_office_training_manager','regional_office_training_manager','provincial_office_training_manager'];
        $registrarRoles = ['registrar'];
        if (!in_array($actorRole, array_merge($adminRoles, $tmRoles, $registrarRoles), true)) {
            abort(403);
        }
        $certifications = \App\Models\Certification::all();
        $libraryQuery = \App\Models\Course::where('is_published', true);
        if (in_array($actorRole, array_merge($tmRoles, $registrarRoles), true)) {
            $levelRoles = [];
            if ($actorRole === 'central_office_training_manager') {
                $levelRoles = ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants'];
            } elseif ($actorRole === 'regional_office_training_manager') {
                $levelRoles = ['regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants'];
            } elseif ($actorRole === 'provincial_office_training_manager') {
                $levelRoles = ['provincial_office_admin','provincial_office_training_manager','provincial_office_coach','provincial_office_participants'];
            } else {
                $levelRoles = ['admin','training_manager','coach','trainer','participant','trainee'];
            }
            $libraryQuery->whereHas('users', function ($q) use ($levelRoles) {
                $q->whereIn('role', $levelRoles);
            });
        }
        $libraryCourses = $libraryQuery->with('users')->orderByDesc('created_at')->take(60)->get();
        if (auth()->check() && auth()->user()->role === 'admin' && !$request->boolean('embedded')) {
            return redirect()->route('dashboard', [
                'tab' => 'course-create',
                'certifications' => $certifications,
            ]);
        }

        return view('admin.course-create', compact('certifications', 'libraryCourses'));
    }

    public function edit(Course $course)
    {
        $actorRole = strtolower((string) (auth()->user()->role ?? ''));
        $adminRoles = ['admin','super_admin','central_office_admin','regional_office_admin','provincial_office_admin'];
        $tmRoles = ['training_manager','central_office_training_manager','regional_office_training_manager','provincial_office_training_manager'];
        $registrarRoles = ['registrar'];
        if (!in_array($actorRole, array_merge($adminRoles, $tmRoles, $registrarRoles), true)) {
            abort(403);
        }
        $certifications = \App\Models\Certification::all();
        return view('admin.course-edit', compact('course', 'certifications'));
    }

    public function trainerCreate()
    {
        $forTrainer = true;
        $certifications = \App\Models\Certification::all();
        $actorRole = strtolower((string) (auth()->user()->role ?? ''));
        $adminRoles = ['admin','super_admin','central_office_admin','regional_office_admin','provincial_office_admin'];
        $tmRoles = ['training_manager','central_office_training_manager','regional_office_training_manager','provincial_office_training_manager'];
        $libraryQuery = \App\Models\Course::where('is_published', true);
        if (in_array($actorRole, $tmRoles, true)) {
            $levelRoles = [];
            if ($actorRole === 'central_office_training_manager') {
                $levelRoles = ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants'];
            } elseif ($actorRole === 'regional_office_training_manager') {
                $levelRoles = ['regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants'];
            } elseif ($actorRole === 'provincial_office_training_manager') {
                $levelRoles = ['provincial_office_admin','provincial_office_training_manager','provincial_office_coach','provincial_office_participants'];
            } else {
                $levelRoles = ['admin','training_manager','coach','trainer','participant','trainee'];
            }
            $libraryQuery->whereHas('users', function ($q) use ($levelRoles) {
                $q->whereIn('role', $levelRoles);
            });
        }
        $libraryCourses = $libraryQuery->with('users')->orderByDesc('created_at')->take(60)->get();
        return view('admin.course-create', compact('forTrainer', 'certifications', 'libraryCourses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $actorRole = strtolower((string) (auth()->user()->role ?? ''));
        $adminRoles = ['admin','super_admin','central_office_admin','regional_office_admin','provincial_office_admin'];
        $tmRoles = ['training_manager','central_office_training_manager','regional_office_training_manager','provincial_office_training_manager'];
        $registrarRoles = ['registrar'];
        if (!in_array($actorRole, array_merge($adminRoles, $tmRoles, $registrarRoles), true)) {
            abort(403);
        }
        // Ensure an active academic year exists
        $activeYear = \App\Models\AcademicYear::where('is_active', true)->first();
        if (!$activeYear) {
            return back()->withErrors(['academic_year' => 'No active academic year set. Please contact Superadmin.'], 'create_course')->withInput();
        }

        $allowedSubjectAreas = $this->allowedSubjectAreas();
        $validated = $request->validateWithBag('create_course', [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'subject_area' => 'required|array|min:1',
            'subject_area.*' => ['string', Rule::in($allowedSubjectAreas)],
            'academic_year' => 'nullable|string|max:20',
            'video_url' => 'nullable|url',
            'video' => 'nullable|mimetypes:video/mp4,video/webm,video/ogg|max:204800',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'image_draft_data' => 'nullable|string',
            'certification_id' => 'nullable|exists:certifications,id',
            'course_type' => 'required|in:free,controlled',
            'course_expiration_date' => 'nullable|date',
            'start_date' => 'nullable|date',
            'materials.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,mp4,webm,ogg',
        ]);

        $normalizedAreas = [];
        foreach (array_values(array_unique(array_filter(array_map('trim', $validated['subject_area'])))) as $area) {
            $label = \App\Models\Course::normalizeSubjectAreaLabel((string) $area);
            if ($label !== '' && in_array($label, \App\Models\Course::subjectAreaOptions(), true)) {
                $normalizedAreas[$label] = true;
            }
        }
        $validated['subject_area'] = json_encode(array_keys($normalizedAreas), JSON_UNESCAPED_UNICODE);

        // Automatically assign active academic year
        $validated['academic_year_id'] = $activeYear->id;
        $validated['academic_year'] = "{$activeYear->year_start}–{$activeYear->year_end}";

        // Ensure DB columns that may be NOT NULL receive safe defaults
        if (!$request->filled('video_url')) {
            $validated['video_url'] = '';
        }

        if ($request->hasFile('image')) {
            try {
                Storage::disk('public')->makeDirectory('course_images');
                $file = $request->file('image');
                if (!$file->isValid()) {
                    $code = $file->getError();
                    $map = [
                        UPLOAD_ERR_INI_SIZE => 'Image exceeds server limit.',
                        UPLOAD_ERR_FORM_SIZE => 'Image exceeds form limit.',
                        UPLOAD_ERR_PARTIAL => 'Image was only partially uploaded.',
                        UPLOAD_ERR_NO_FILE => 'No image was uploaded.',
                        UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder on server.',
                        UPLOAD_ERR_CANT_WRITE => 'Failed to write image to disk.',
                        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
                    ];
                    $msg = $map[$code] ?? 'Image upload error.';
                    return back()->withErrors(['image' => $msg], 'create_course')->withInput();
                }
                $imagePath = $file->store('course_images', 'public');
                $validated['image_path'] = $imagePath;
            } catch (\Throwable $e) {
                \Log::error('Course image upload failed', ['error' => $e->getMessage()]);
                return back()
                    ->withErrors(['image' => 'Image upload failed on server. Check storage permissions or disk space.'], 'create_course')
                    ->withInput();
            }
        } elseif ($request->filled('image_draft_data')) {
            try {
                $base64 = $request->input('image_draft_data');
                if (preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
                    $data = substr($base64, strpos($base64, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, etc.
                    if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png', 'webp', 'svg'])) {
                        throw new \Exception('Invalid image type');
                    }
                    $data = base64_decode($data);
                    if ($data === false) {
                        throw new \Exception('base64_decode failed');
                    }
                    $fileName = 'course_images/' . uniqid() . '.' . $type;
                    Storage::disk('public')->put($fileName, $data);
                    $validated['image_path'] = $fileName;
                }
            } catch (\Throwable $e) {
                \Log::error('Draft image restoration failed', ['error' => $e->getMessage()]);
            }
        }
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('course_videos', 'public');
            $validated['video_path'] = $videoPath;
        }

        $modulesInput = $request->input('modules', []);
        $modules = [];
        foreach ($modulesInput as $i => $module) {
            $topics = [];
            $topicInput = $module['topics'] ?? [];
            foreach ($topicInput as $j => $topic) {
                // Support nested subtopics with fields; fallback to legacy topic.fields
                $subtopics = [];
                if (!empty($topic['subtopics']) && is_array($topic['subtopics'])) {
                    foreach ($topic['subtopics'] as $s) {
                        $sFields = null;
                        if (isset($s['fields_json'])) {
                            $sFields = json_decode($s['fields_json'], true);
                            $sFields = $this->sanitizeFields($sFields);
                        }
                        $subtopics[] = [
                            'title' => $s['title'] ?? '',
                            'fields' => $sFields,
                        ];
                    }
                }
                if (!empty($subtopics)) {
                    $topics[] = [
                        'title' => $topic['title'] ?? '',
                        'subtopics' => $subtopics,
                    ];
                } else {
                    $fields = null;
                    if (isset($topic['fields_json'])) {
                        $fields = json_decode($topic['fields_json'], true);
                        $fields = $this->sanitizeFields($fields);
                    } else {
                        // Backward compatibility: map old materials/questions into fields
                        $fields = [];
                        if (!empty($topic['materials_html'])) {
                            $fields[] = ['type' => 'text', 'html' => $this->scrubHtml($topic['materials_html'])];
                        }
                        if (isset($topic['questions_json'])) {
                            $qs = json_decode($topic['questions_json'], true) ?: [];
                            foreach ($qs as $q) {
                                $fields[] = ['type' => 'question', 'question' => $q];
                            }
                        }
                        if (empty($fields)) $fields = null;
                    }
                    $topics[] = [
                        'title' => $topic['title'] ?? '',
                        'fields' => $fields,
                    ];
                }
            }
            $exam = null;
            if (isset($module['exam_json'])) {
                $e = json_decode($module['exam_json'], true);
                if (is_array($e)) {
                    if (trim((string)($e['title'] ?? '')) === '') {
                        return back()
                            ->withErrors(['create_course' => 'Exam title is required for exams.'], 'create_course')
                            ->withInput();
                    }
                    // Optional: strip essay types if present
                    $qs = array_values(array_filter(array_map(function($q){
                        return is_array($q) ? $this->normalizeExamQuestion($q) : null;
                    }, ($e['questions'] ?? []))));
                    $exam = [
                        'title' => (string) ($e['title'] ?? ''),
                        'description' => (string) ($e['description'] ?? ''),
                        'timer_minutes' => (int) ($e['timer_minutes'] ?? 0),
                        'timer_mode' => (string) ($e['timer_mode'] ?? 'timed'),
                        'passing_score' => (int) ($e['passing_score'] ?? 75),
                        'max_attempts' => isset($e['max_attempts']) || isset($e['attempt_limit'])
                            ? (int) ($e['max_attempts'] ?? $e['attempt_limit'])
                            : null,
                        'questions' => $qs,
                    ];
                }
            }
            $mArr = [
                'title' => $module['title'] ?? '',
                'topics' => $topics,
                'status' => 'unlocked',
            ];
            if ($exam) { $mArr['exam'] = $exam; }
            $modules[] = $mArr;
        }
        // Course-level exam handling: merge into Module 1 when modules exist; otherwise create a special tail module
        $cexam = $request->input('course_exam_json');
        if ($cexam) {
            $e = json_decode($cexam, true);
            if (is_array($e)) {
                if (trim((string)($e['title'] ?? '')) === '') {
                    return back()
                        ->withErrors(['create_course' => 'Course exam title is required.'], 'create_course')
                        ->withInput();
                }
                $qs = array_values(array_filter(array_map(function($q){
                    return is_array($q) ? $this->normalizeExamQuestion($q) : null;
                }, ($e['questions'] ?? []))));
                $examArr = [
                    'title' => (string) ($e['title'] ?? ''),
                    'description' => (string) ($e['description'] ?? ''),
                    'timer_minutes' => (int) ($e['timer_minutes'] ?? 0),
                    'timer_mode' => (string) ($e['timer_mode'] ?? 'timed'),
                    'passing_score' => (int) ($e['passing_score'] ?? 75),
                    'max_attempts' => isset($e['max_attempts']) || isset($e['attempt_limit'])
                        ? (int) ($e['max_attempts'] ?? $e['attempt_limit'])
                        : null,
                    'questions' => $qs,
                ];
                $hasModules = !empty($modules);
                $hasExamInModules = false;
                foreach ($modules as $m) {
                    if (isset($m['exam']) && is_array($m['exam'])) { $hasExamInModules = true; break; }
                }
                if ($hasModules) {
                    if (!$hasExamInModules) {
                        // Merge into first module to avoid creating "Module 2" for exam
                        $modules[0]['exam'] = $examArr;
                    }
                    // If modules already have an exam, do not append another exam module
                } else {
                    // No modules at all: create a dedicated Course Exam module
                    $modules[] = [
                        'title' => 'Module Exam',
                        'topics' => [],
                        'exam' => $examArr,
                    ];
                }
            }
        }
        if (!empty($modules)) {
            $validated['modules'] = $modules;
        }

        if (auth()->check()) {
            $validated['trainer_id'] = auth()->id();
            $validated['submitted_by_user_id'] = auth()->id();
        }

        if ($request->course_type === 'controlled') {
            $validated['access_code'] = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
        }

        try {
            $course = \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $request) {
                $course = Course::create($validated);

                // Link the creator to the course so we can display "Created by"
                if (auth()->check() && !$course->users()->where('user_id', auth()->id())->exists()) {
                    $course->users()->attach(auth()->id(), ['status' => 'active']);
                }

                $this->storeUploadedMaterials($request, $course);

                return $course;
            });
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error('Course creation failed', ['error' => $e->getMessage()]);
            return back()
                ->withErrors(['materials' => 'Course materials could not be saved. Please try again.'], 'create_course')
                ->withInput();
        }

        if ($request->boolean('embedded')) {
            $targetParams = ['tab' => 'course-management', 'clear_draft' => 'draft_course_create'];
            if (in_array($actorRole, $tmRoles, true)) {
                $targetParams['portal'] = 'tm';
            }
            $target = route('dashboard', $targetParams);
            $encodedTarget = json_encode($target, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
            return response(
                "<!doctype html><html><body><script>window.top.location.href={$encodedTarget};</script></body></html>",
                200,
                ['Content-Type' => 'text/html; charset=UTF-8']
            );
        }

        if (in_array($actorRole, $tmRoles, true)) {
            return redirect()->route('dashboard', ['portal' => 'tm', 'tab' => 'course-management'])
                ->with('success_course', 'Course created successfully.');
        }
        return redirect()->route('dashboard', ['tab' => 'course-management'])
            ->with('success_course', 'Course created successfully.');
    }

    public function trainerStore(Request $request)
    {
        $actorRole = strtolower((string) (auth()->user()->role ?? ''));
        $coachRoles = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
        if (!in_array($actorRole, $coachRoles, true)) {
            abort(403);
        }
        $allowedSubjectAreas = $this->allowedSubjectAreas();
        $validated = $request->validateWithBag('create_course', [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'subject_area' => 'required|array|min:1',
            'subject_area.*' => ['string', Rule::in($allowedSubjectAreas)],
            'academic_year_id' => 'required|exists:academic_years,id',
            'video_url' => 'nullable|url',
            'video' => 'nullable|mimetypes:video/mp4,video/webm,video/ogg|max:204800',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'image_draft_data' => 'nullable|string',
            'certification_id' => 'nullable|exists:certifications,id',
            'course_expiration_date' => 'nullable|date',
            'start_date' => 'nullable|date',
            'materials.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,mp4,webm,ogg',
        ]);

        $normalizedAreas = [];
        foreach (array_values(array_unique(array_filter(array_map('trim', $validated['subject_area'])))) as $area) {
            $label = \App\Models\Course::normalizeSubjectAreaLabel((string) $area);
            if ($label !== '' && in_array($label, \App\Models\Course::subjectAreaOptions(), true)) {
                $normalizedAreas[$label] = true;
            }
        }
        $validated['subject_area'] = json_encode(array_keys($normalizedAreas), JSON_UNESCAPED_UNICODE);

        if (!$request->filled('video_url')) {
            $validated['video_url'] = '';
        }
        if ($request->hasFile('image')) {
            try {
                Storage::disk('public')->makeDirectory('course_images');
                $file = $request->file('image');
                if (!$file->isValid()) {
                    $code = $file->getError();
                    $map = [
                        UPLOAD_ERR_INI_SIZE => 'Image exceeds server limit.',
                        UPLOAD_ERR_FORM_SIZE => 'Image exceeds form limit.',
                        UPLOAD_ERR_PARTIAL => 'Image was only partially uploaded.',
                        UPLOAD_ERR_NO_FILE => 'No image was uploaded.',
                        UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder on server.',
                        UPLOAD_ERR_CANT_WRITE => 'Failed to write image to disk.',
                        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
                    ];
                    $msg = $map[$code] ?? 'Image upload error.';
                    return back()->withErrors(['image' => $msg], 'create_course')->withInput();
                }
                $validated['image_path'] = $file->store('course_images', 'public');
            } catch (\Throwable $e) {
                \Log::error('Trainer course image upload failed', ['error' => $e->getMessage()]);
                return back()
                    ->withErrors(['image' => 'Image upload failed on server. Check storage permissions or disk space.'], 'create_course')
                    ->withInput();
            }
        } elseif ($request->filled('image_draft_data')) {
            try {
                $base64 = $request->input('image_draft_data');
                if (preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
                    $data = substr($base64, strpos($base64, ',') + 1);
                    $type = strtolower($type[1]);
                    if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png', 'webp', 'svg'])) {
                        throw new \Exception('Invalid image type');
                    }
                    $data = base64_decode($data);
                    if ($data === false) {
                        throw new \Exception('base64_decode failed');
                    }
                    $fileName = 'course_images/' . uniqid() . '.' . $type;
                    Storage::disk('public')->put($fileName, $data);
                    $validated['image_path'] = $fileName;
                }
            } catch (\Throwable $e) {
                \Log::error('Trainer draft image restoration failed', ['error' => $e->getMessage()]);
            }
        }
        if ($request->hasFile('video')) {
            $validated['video_path'] = $request->file('video')->store('course_videos', 'public');
        }

        $modulesInput = $request->input('modules', []);
        $modules = [];
        foreach ($modulesInput as $module) {
            $topics = [];
            $topicInput = $module['topics'] ?? [];
            foreach ($topicInput as $topic) {
                $subtopics = [];
                if (!empty($topic['subtopics']) && is_array($topic['subtopics'])) {
                    foreach ($topic['subtopics'] as $s) {
                        $sFields = null;
                        if (isset($s['fields_json'])) {
                            $sFields = json_decode($s['fields_json'], true);
                            $sFields = $this->sanitizeFields($sFields);
                        }
                        $subtopics[] = [
                            'title' => $s['title'] ?? '',
                            'fields' => $sFields,
                        ];
                    }
                }
                if (!empty($subtopics)) {
                    $topics[] = [
                        'title' => $topic['title'] ?? '',
                        'subtopics' => $subtopics,
                    ];
                } else {
                    $fields = null;
                    if (isset($topic['fields_json'])) {
                        $fields = json_decode($topic['fields_json'], true);
                        $fields = $this->sanitizeFields($fields);
                    } else {
                        $fields = [];
                        if (!empty($topic['materials_html'])) {
                            $fields[] = ['type' => 'text', 'html' => $this->scrubHtml($topic['materials_html'])];
                        }
                        if (isset($topic['questions_json'])) {
                            $qs = json_decode($topic['questions_json'], true) ?: [];
                            foreach ($qs as $q) {
                                $fields[] = ['type' => 'question', 'question' => $q];
                            }
                        }
                        if (empty($fields)) $fields = null;
                    }
                    $topics[] = [
                        'title' => $topic['title'] ?? '',
                        'fields' => $fields,
                    ];
                }
            }
            $exam = null;
            if (isset($module['exam_json'])) {
                $e = json_decode($module['exam_json'], true);
                if (is_array($e)) {
                    if (trim((string)($e['title'] ?? '')) === '') {
                        return back()
                            ->withErrors(['create_course' => 'Exam title is required for exams.'], 'create_course')
                            ->withInput();
                    }
                    $qs = array_values(array_filter(array_map(function($q){
                        return is_array($q) ? $this->normalizeExamQuestion($q) : null;
                    }, ($e['questions'] ?? []))));
                    $exam = [
                        'title' => (string) ($e['title'] ?? ''),
                        'description' => (string) ($e['description'] ?? ''),
                        'timer_minutes' => (int) ($e['timer_minutes'] ?? 0),
                        'passing_score' => (int) ($e['passing_score'] ?? 75),
                        'max_attempts' => isset($e['max_attempts']) || isset($e['attempt_limit'])
                            ? (int) ($e['max_attempts'] ?? $e['attempt_limit'])
                            : null,
                        'questions' => $qs,
                    ];
                }
            }
            $mArr = [
                'title' => $module['title'] ?? '',
                'topics' => $topics,
                'status' => 'unlocked',
            ];
            if ($exam) { $mArr['exam'] = $exam; }
            $modules[] = $mArr;
        }
        // Course-level exam on update: merge into Module 1 when modules exist; otherwise create/replace special tail module
        $cexam = $request->input('course_exam_json');
        if ($cexam) {
            $e = json_decode($cexam, true);
            if (is_array($e)) {
                if (trim((string)($e['title'] ?? '')) === '') {
                    return back()
                        ->withErrors(['create_course' => 'Course exam title is required.'], 'create_course')
                        ->withInput();
                }
                $qs = array_values(array_filter(array_map(function($q){
                    return is_array($q) ? $this->normalizeExamQuestion($q) : null;
                }, ($e['questions'] ?? []))));
                $examArr = [
                    'title' => (string) ($e['title'] ?? ''),
                    'description' => (string) ($e['description'] ?? ''),
                    'timer_minutes' => (int) ($e['timer_minutes'] ?? 0),
                    'passing_score' => (int) ($e['passing_score'] ?? 75),
                    'max_attempts' => isset($e['max_attempts']) || isset($e['attempt_limit'])
                        ? (int) ($e['max_attempts'] ?? $e['attempt_limit'])
                        : null,
                    'questions' => $qs,
                ];
                // Remove any previous dedicated 'Course Exam' module
                $modules = array_values(array_filter($modules, function($m){
                    return !(isset($m['exam']) && is_array($m['exam']) && isset($m['topics']) && empty($m['topics']));
                }));
                $hasModules = !empty($modules);
                $hasExamInModules = false;
                foreach ($modules as $m) {
                    if (isset($m['exam']) && is_array($m['exam'])) { $hasExamInModules = true; break; }
                }
                if ($hasModules) {
                    if (!$hasExamInModules) {
                        $modules[0]['exam'] = $examArr;
                    }
                    // If an exam already exists inside a module, don't create another
                } else {
                    $modules[] = [
                        'title' => 'Module Exam',
                        'topics' => [],
                        'exam' => $examArr,
                    ];
                }
            }
        }
        if (!empty($modules)) {
            $validated['modules'] = $modules;
        }

        if (auth()->check()) {
            $validated['trainer_id'] = auth()->id();
            if (Schema::hasColumn('courses', 'submitted_by_user_id')) {
                $validated['submitted_by_user_id'] = auth()->id();
            }
        }

        if ($request->course_type === 'controlled') {
            $validated['access_code'] = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
        }

        try {
            $course = \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $request) {
                $course = Course::create($validated);

                if (auth()->check() && !$course->users()->where('user_id', auth()->id())->exists()) {
                    $course->users()->attach(auth()->id(), ['status' => 'active']);
                }

                $this->storeUploadedMaterials($request, $course);

                // Soft-archive until training manager approval
                $course->delete();

                return $course;
            });
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error('Trainer course creation failed', ['error' => $e->getMessage()]);
            return back()
                ->withErrors(['materials' => 'Course materials could not be saved. Please try again.'], 'create_course')
                ->withInput();
        }

        $tmRoleTargets = ['training_manager'];
        if ($actorRole === 'central_office_coach') {
            $tmRoleTargets = ['central_office_training_manager'];
        } elseif ($actorRole === 'regional_office_coach') {
            $tmRoleTargets = ['regional_office_training_manager'];
        } elseif ($actorRole === 'provincial_office_coach') {
            $tmRoleTargets = ['provincial_office_training_manager'];
        }
        $trainingManagers = User::whereIn('role', $tmRoleTargets)->get();
        foreach ($trainingManagers as $tm) {
            Notification::create([
                'user_id' => $tm->id,
                'title' => 'New Course Submission',
                'message' => "Coach ".auth()->user()->name." submitted '{$course->name}' for approval.",
                'type' => 'course_submission',
                'related_id' => $course->id,
                'link' => route('dashboard', ['portal' => 'tm', 'tab' => 'pending-courses']),
            ]);
        }

        if ($request->boolean('embedded')) {
            $target = route('dashboard', [
                'portal' => 'coach',
                'tab' => 'course-utilities',
                'submission_tab' => 'pending',
            ]);
            $encodedTarget = json_encode($target, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
            return response(
                "<!doctype html><html><body><script>window.top.location.href={$encodedTarget};</script></body></html>",
                200,
                ['Content-Type' => 'text/html; charset=UTF-8']
            );
        }

        return redirect()->route('dashboard', [
                'portal' => 'coach',
                'tab' => 'course-utilities',
                'submission_tab' => 'pending',
            ])
            ->with('success', 'Course submitted to training manager for approval.');
    }

    public function adminShow($course)
    {
        $course = Course::withTrashed()->findOrFail($course);
        // Ensure a creator is recorded for legacy courses without any linked user
        if ($course->users()->count() === 0 && auth()->check()) {
            if (!$course->users()->where('user_id', auth()->id())->exists()) {
                $course->users()->attach(auth()->id(), ['status' => 'active']);
            }
            $course->load('users');
        }
        return view('admin.course-show', compact('course'));
    }

    public function traineeShow(Course $course)
    {
        \Illuminate\Support\Facades\Log::info('traineeShow: loading course users', ['course_id' => $course->id]);
        if (auth()->check() && in_array(auth()->user()->role ?? null, ['trainer','coach'], true)) {
            return redirect()->route('trainer.courses.enter', $course);
        }
        if (auth()->check()) {
            $role = auth()->user()->role ?? null;
            $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
            if (in_array($role, $participantRoles, true) && !$course->is_published) {
                return redirect()->route('dashboard')->with('info', 'This course is not yet open.');
            }
        }
        $course->load(['users', 'materials', 'assessments']);
        \Illuminate\Support\Facades\Log::info('traineeShow: loaded users', [
            'course_id' => $course->id,
            'user_count' => $course->users->count(),
            'roles' => $course->users->pluck('role')->all(),
        ]);
        $this->normalizeCourseMediaUrls($course);
        $announcements = \App\Models\ClassAnnouncement::with(['user','comments.user'])
            ->where('course_id', $course->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $discussions = \App\Models\Discussion::with([
                'user',
                'replies.user',
                'replies.children.user',
                'replies.reactions',
                'replies.children.reactions'
            ])
            ->withCount(['replies as replies_count' => function($q){
                $q->whereNull('deleted_at');
            }])
            ->where('course_id', $course->id)
            ->latest()
            ->get();
        $status = null;
        $allowedModuleIndex = null;
        $finalExamModuleIndex = $this->getFinalExamModuleIndex($course);
        $finalExamUnlocked = false;
        if (auth()->check()) {
            $pivot = $course->users()->where('user_id', auth()->id())->first();
            if ($pivot) {
                $this->syncSequentialProgress($course, auth()->id());
                $pivot = $course->users()->where('user_id', auth()->id())->first();
                $status = $pivot?->pivot->status ?? 'active';
                $allowedModuleIndex = $this->getAllowedModuleArrayIndex($course, auth()->id());
                $finalExamUnlocked = $this->areAllModulesCompleted($course, auth()->id());
                if ($status === 'completed') {
                    $this->issueCertificateIfCompleted(auth()->user(), $course);
                }
            }
        }
        $requestedMi = request()->query('mi');
        if ($requestedMi !== null && auth()->check() && $allowedModuleIndex !== null) {
            $requestedMi = max(0, (int) $requestedMi);
            if (($finalExamModuleIndex !== null && $requestedMi === $finalExamModuleIndex && !$finalExamUnlocked)
                || ($requestedMi > $allowedModuleIndex && $requestedMi !== $finalExamModuleIndex)) {
                return redirect()->route('trainee.courses.show', ['course' => $course, 'mi' => $allowedModuleIndex])
                    ->with('error', 'You can only access your current module.');
            }
        }
        // Compute overall completion for current user
        $completion = 0;
        if (auth()->check()) {
            $mods = is_array($course->modules) ? $course->modules : [];
            $rows = \App\Models\ReflectionResponse::where('user_id', auth()->id())
                ->where('course_id', $course->id)
                ->get(['module_index','topic_index','sub_index','answers_json']);
            $doneSet = [];
            foreach ($rows as $r) {
                $doneSet["{$r->module_index}_{$r->topic_index}_{$r->sub_index}"] = true;
            }
            $total=0; $done=0;
            foreach ($mods as $mi => $m) {
                $topics = isset($m['topics']) && is_array($m['topics']) ? $m['topics'] : [];
                foreach ($topics as $ti => $t) {
                    $subs = isset($t['subtopics']) && is_array($t['subtopics']) ? $t['subtopics'] : [];
                    $total += count($subs);
                    foreach ($subs as $si => $_) {
                        if (!empty($doneSet["{$mi}_{$ti}_{$si}"])) $done++;
                    }
                }
            }
            $completion = $total ? round(($done / $total) * 100) : 0;
        }
        $coachRoles = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
        $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
        $coaches = ($course->users ?? collect([]))->filter(function ($u) use ($coachRoles) {
            if (in_array($u->role ?? '', $coachRoles, true)) return true;
            return $u->hasPermission('view_courses_coach')
                || $u->hasPermission('view_classes')
                || $u->hasPermission('view_communication');
        })->values();
        $classmates = ($course->users ?? collect([]))->filter(function ($u) use ($participantRoles, $coachRoles) {
            $isCoach = in_array($u->role ?? '', $coachRoles, true)
                || $u->hasPermission('view_courses_coach')
                || $u->hasPermission('view_classes')
                || $u->hasPermission('view_communication');
            return !$isCoach && in_array($u->role ?? '', $participantRoles, true);
        })->values();
        \Illuminate\Support\Facades\Log::info('traineeShow: participants resolved', [
            'course_id' => $course->id,
            'coaches' => $coaches->pluck('id')->all(),
            'classmates' => $classmates->pluck('id')->all(),
        ]);
        if (auth()->check() && strtolower(auth()->user()->email ?? '') === 'ro_participant@gmail.com') {
            return view('roparticipant.course-landing', [
                'course' => $course,
                'status' => $status,
                'announcements' => $announcements,
                'discussions' => $discussions,
                'completion' => $completion,
                'coaches' => $coaches,
                'classmates' => $classmates,
                'allowedModuleIndex' => $allowedModuleIndex,
                'finalExamModuleIndex' => $finalExamModuleIndex,
                'finalExamUnlocked' => $finalExamUnlocked,
            ]);
        }
        return view('trainee.course-landing', [
            'course' => $course,
            'status' => $status,
            'announcements' => $announcements,
            'discussions' => $discussions,
            'completion' => $completion,
            'coaches' => $coaches,
            'classmates' => $classmates,
            'allowedModuleIndex' => $allowedModuleIndex,
            'finalExamModuleIndex' => $finalExamModuleIndex,
            'finalExamUnlocked' => $finalExamUnlocked,
        ]);
    }
    
    public function trainerView(Course $course)
    {
        $course->load(['users', 'materials', 'assessments']);
        $this->normalizeCourseMediaUrls($course);
        // Coach view normalization: split embedded exams into a dedicated module that follows the parent module
        $mods = $course->modules;
        if (is_string($mods)) { try { $mods = json_decode($mods, true); } catch (\Throwable $e) { $mods = []; } }
        if (is_array($mods) && !empty($mods)) {
            // Build a set of existing exam signatures (avoid duplicates) and only keep exams with questions
            $examKey = function($exam){
                try {
                    $title = (string)($exam['title'] ?? '');
                    $qs = is_array($exam['questions'] ?? null) ? $exam['questions'] : [];
                    return sha1($title.'|'.json_encode(array_map(function($q){
                        return ['t'=>$q['text'] ?? ($q['title'] ?? ''), 'type'=>$q['type'] ?? ''];
                    }, $qs)));
                } catch (\Throwable $e) { return null; }
            };
            $existingExamKeys = [];
            foreach ($mods as $m0) {
                $qs0 = is_array($m0['exam']['questions'] ?? null) ? $m0['exam']['questions'] : [];
                if (!empty($qs0) && (!isset($m0['topics']) || empty($m0['topics']))) {
                    $k = $examKey($m0['exam']);
                    if ($k) $existingExamKeys[$k] = true;
                }
            }
            $out = [];
            foreach ($mods as $m) {
                $topics = isset($m['topics']) && is_array($m['topics']) ? $m['topics'] : [];
                $hasTopics = count($topics) > 0;
                $exam = isset($m['exam']) && is_array($m['exam']) ? $m['exam'] : null;
                $examQs = is_array($exam['questions'] ?? null) ? $exam['questions'] : [];
                $hasExamWithQs = !empty($examQs);

                if ($hasTopics) {
                    // Always include the content module (without exam)
                    $copy = $m;
                    unset($copy['exam']);
                    $out[] = $copy;
                    // Only append a separate exam module if this exam has questions and not already present
                    if ($hasExamWithQs) {
                        $k = $examKey($exam);
                        if (!$k || !isset($existingExamKeys[$k])) {
                            $examTitle = (string) ($exam['title'] ?? '');
                            $computedTitle = $examTitle !== '' ? ('Module Exam: ' . $examTitle . ' Exam') : 'Module Exam';
                            $out[] = [
                                'title' => $computedTitle,
                                'topics' => [],
                                'exam' => $exam,
                            ];
                            if ($k) $existingExamKeys[$k] = true;
                        }
                    }
                } else {
                    // Exam-only or empty module
                    if ($hasExamWithQs) {
                        // Keep real exam modules with questions
                        if (!isset($m['title']) || trim((string)$m['title']) === '') {
                            $examTitle = (string) ($exam['title'] ?? '');
                            $m['title'] = $examTitle !== '' ? ('Module Exam: ' . $examTitle . ' Exam') : 'Module Exam';
                        }
                        $out[] = $m;
                    } else {
                        // Drop empty exam modules (no questions)
                        if (!isset($m['exam'])) {
                            // Plain empty module with no title -> keep but normalize
                            if (!isset($m['title']) || trim((string)$m['title']) === '') {
                                $m['title'] = 'Untitled';
                            }
                            $out[] = $m;
                        }
                    }
                }
            }
            $course->modules = $out;
        }
        return view('trainee.course-show', [
            'course' => $course,
            'status' => 'active',
            'viewOnly' => true,
        ]);
    }
    public function trainerLanding(Course $course)
    {
        \Illuminate\Support\Facades\Log::info('trainerLanding: loading course users', ['course_id' => $course->id]);
        $course->load(['users', 'materials', 'assessments']);
        \Illuminate\Support\Facades\Log::info('trainerLanding: loaded users', [
            'course_id' => $course->id,
            'user_count' => $course->users->count(),
            'roles' => $course->users->pluck('role')->all(),
        ]);
        $this->normalizeCourseMediaUrls($course);
        $announcements = \App\Models\ClassAnnouncement::with(['user','comments.user'])
            ->where('course_id', $course->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $discussions = \App\Models\Discussion::with([
                'user',
                'replies.user',
                'replies.children.user',
                'replies.reactions',
                'replies.children.reactions'
            ])
            ->withCount(['replies as replies_count' => function($q){
                $q->whereNull('deleted_at');
            }])
            ->where('course_id', $course->id)
            ->latest()
            ->get();
        // Compute overall completion for trainer view as well (uses current user)
        $completion = 0;
        if (auth()->check()) {
            $mods = is_array($course->modules) ? $course->modules : [];
            $rows = \App\Models\ReflectionResponse::where('user_id', auth()->id())
                ->where('course_id', $course->id)
                ->get(['module_index','topic_index','sub_index','answers_json']);
            $doneSet = [];
            foreach ($rows as $r) {
                $doneSet["{$r->module_index}_{$r->topic_index}_{$r->sub_index}"] = true;
            }
            $total=0; $done=0;
            foreach ($mods as $mi => $m) {
                $topics = isset($m['topics']) && is_array($m['topics']) ? $m['topics'] : [];
                foreach ($topics as $ti => $t) {
                    $subs = isset($t['subtopics']) && is_array($t['subtopics']) ? $t['subtopics'] : [];
                    $total += count($subs);
                    foreach ($subs as $si => $_) {
                        if (!empty($doneSet["{$mi}_{$ti}_{$si}"])) $done++;
                    }
                }
            }
            $completion = $total ? round(($done / $total) * 100) : 0;
        }
        $coachRoles = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
        $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
        $coaches = ($course->users ?? collect([]))->filter(function ($u) use ($coachRoles) {
            if (in_array($u->role ?? '', $coachRoles, true)) return true;
            return $u->hasPermission('view_courses_coach')
                || $u->hasPermission('view_classes')
                || $u->hasPermission('view_communication');
        })->values();
        $classmates = ($course->users ?? collect([]))->filter(function ($u) use ($participantRoles, $coachRoles) {
            $isCoach = in_array($u->role ?? '', $coachRoles, true)
                || $u->hasPermission('view_courses_coach')
                || $u->hasPermission('view_classes')
                || $u->hasPermission('view_communication');
            return !$isCoach && in_array($u->role ?? '', $participantRoles, true);
        })->values();
        \Illuminate\Support\Facades\Log::info('trainerLanding: participants resolved', [
            'course_id' => $course->id,
            'coaches' => $coaches->pluck('id')->all(),
            'classmates' => $classmates->pluck('id')->all(),
        ]);
        return view('trainee.course-landing', [
            'course' => $course,
            'status' => 'active',
            'announcements' => $announcements,
            'discussions' => $discussions,
            'asTrainer' => true,
            'completion' => $completion,
            'coaches' => $coaches,
            'classmates' => $classmates,
        ]);
    }
    public function traineeOutline(Course $course)
    {
        if (auth()->check() && in_array(auth()->user()->role ?? null, ['trainer','coach'], true)) {
            return redirect()->route('trainer.courses.view', $course);
        }
        if (auth()->check()) {
            $role = auth()->user()->role ?? null;
            $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
            if (in_array($role, $participantRoles, true) && !$course->is_published) {
                return redirect()->route('dashboard')->with('info', 'This course is not yet open.');
            }
        }
        $course->load(['users', 'materials', 'assessments']);
        $this->normalizeCourseMediaUrls($course);
        // Normalize modules for display for trainees as well
        $mods = $course->modules;
        if (is_string($mods)) { try { $mods = json_decode($mods, true); } catch (\Throwable $e) { $mods = []; } }
        if (is_array($mods) && !empty($mods)) {
            foreach ($mods as $i => $m) {
                if (isset($m['exam']) && is_array($m['exam']) && isset($m['topics']) && empty($m['topics'])) {
                    $target = ($i > 0) ? $i-1 : 0;
                    if (!isset($mods[$target]['exam'])) {
                        $mods[$target]['exam'] = $m['exam'];
                    }
                    unset($mods[$i]);
                    $mods = array_values($mods);
                    break;
                }
            }
            $course->modules = $mods;
        }
        $status = null;
        $allowedModuleIndex = null;
        $finalExamModuleIndex = $this->getFinalExamModuleIndex($course);
        $finalExamUnlocked = false;
        if (auth()->check()) {
            $pivot = $course->users()->where('user_id', auth()->id())->first();
            if ($pivot) {
                $this->syncSequentialProgress($course, auth()->id());
                $pivot = $course->users()->where('user_id', auth()->id())->first();
                $status = $pivot?->pivot->status ?? 'active';
                $allowedModuleIndex = $this->getAllowedModuleArrayIndex($course, auth()->id());
                $finalExamUnlocked = $this->areAllModulesCompleted($course, auth()->id());
                if ($status === 'completed') {
                    $this->issueCertificateIfCompleted(auth()->user(), $course);
                }
            }
        }
        $requestedMi = request()->query('mi');
        if ($requestedMi !== null && auth()->check() && $allowedModuleIndex !== null) {
            $requestedMi = max(0, (int) $requestedMi);
            if (($finalExamModuleIndex !== null && $requestedMi === $finalExamModuleIndex && !$finalExamUnlocked)
                || ($requestedMi > $allowedModuleIndex && $requestedMi !== $finalExamModuleIndex)) {
                $allowedModuleIndex = max(0, (int) $allowedModuleIndex);
            }
        }
        if (auth()->check() && strtolower(auth()->user()->email ?? '') === 'ro_participant@gmail.com') {
            return view('roparticipant.course-show', [
                'course' => $course,
                'status' => $status,
                'viewOnly' => !in_array($status, ['active', 'in_progress', 'ready_for_exam', 'completed', 'failed', 'attempts_exhausted'], true),
                'allowedModuleIndex' => $allowedModuleIndex,
                'finalExamModuleIndex' => $finalExamModuleIndex,
                'finalExamUnlocked' => $finalExamUnlocked,
            ]);
        }
        return view('trainee.course-show', [
            'course' => $course,
            'status' => $status,
            'viewOnly' => !in_array($status, ['active', 'in_progress', 'ready_for_exam', 'completed', 'failed', 'attempts_exhausted'], true),
            'allowedModuleIndex' => $allowedModuleIndex,
            'finalExamModuleIndex' => $finalExamModuleIndex,
            'finalExamUnlocked' => $finalExamUnlocked,
        ]);
    }
    public function setPublished(Request $request, Course $course)
    {
        $role = auth()->user()->role ?? null;
        $tmRoles = [
            'admin',
            'training_manager',
            'registrar',
            'central_office_training_manager',
            'regional_office_training_manager',
            'provincial_office_training_manager'
        ];
        if (!in_array($role, $tmRoles, true)) {
            abort(403);
        }
        $published = $request->boolean('published');
        if ($published) {
            $data = $request->validate([
                'trainer_id' => 'nullable|exists:users,id',
                'enrollment_start_date' => 'required|date',
                'enrollment_end_date' => 'required|date|after_or_equal:enrollment_start_date',
            ]);
            if (!empty($data['trainer_id'])) {
                $course->trainer_id = $data['trainer_id'];
                // Also attach to pivot table if not already linked
                if (!$course->users()->where('user_id', $data['trainer_id'])->exists()) {
                    $course->users()->attach($data['trainer_id'], ['status' => 'active']);
                }
            }
            $course->enrollment_start_date = $data['enrollment_start_date'];
            $course->enrollment_end_date = $data['enrollment_end_date'];
        }
        $course->is_published = $published;
        $course->save();
        if ($request->wantsJson()) {
            return response()->json([
                'ok'=>true,
                'is_published'=>$course->is_published,
            ]);
        }
        $tab = $request->input('return_tab', 'trainer-trainee-management');
        if ($published) {
            $url = route('dashboard', ['tab' => $tab]) . '#published-courses';
            return redirect()->to($url)->with('success_user', 'Course published.');
        }
        return redirect()->route('dashboard', ['tab' => $tab])
            ->with('success_user', 'Course closed.');
    }
    public function trainerClassworkCreate(Course $course)
    {
        return view('trainer.classwork-select', ['course' => $course]);
    }
    public function trainerMaterialCreate(Course $course)
    {
        return view('trainer.material-create', ['course' => $course]);
    }
    public function trainerAssessmentCreate(Course $course)
    {
        return view('trainer.assessment-create', ['course' => $course]);
    }
    public function pending()
    {
        return redirect()->route('dashboard', ['tab' => 'pending-courses']);
    }

    public function participants(Course $course)
    {
        $course->load('users');
        $actor = auth()->user();
        $tmRoles = ['training_manager','central_office_training_manager','regional_office_training_manager','provincial_office_training_manager'];
        $coachRoles = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
        $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
        $managedRoles = [];
        if ($actor) {
            if ($actor->role === 'central_office_training_manager') {
                $managedRoles = ['central_office_coach','central_office_participants'];
            } elseif ($actor->role === 'regional_office_training_manager') {
                $managedRoles = ['regional_office_coach','regional_office_participants'];
            } elseif ($actor->role === 'provincial_office_training_manager') {
                $managedRoles = ['provincial_office_coach','provincial_office_participants'];
            } else {
                $managedRoles = ['coach','trainer','participant','trainee'];
            }
        } else {
            $managedRoles = ['coach','trainer','participant','trainee'];
        }
        $managedCoachRoles = array_values(array_intersect($coachRoles, $managedRoles));
        $managedParticipantRoles = array_values(array_intersect($participantRoles, $managedRoles));
        $coachPermissionNames = ['view_courses_coach', 'view_classes', 'view_communication'];
        $coachPermissionRoleNames = Role::whereIn('name', $managedRoles)
            ->whereHas('permissions', function ($q) use ($coachPermissionNames) {
                $q->whereIn('name', $coachPermissionNames);
            })
            ->pluck('name')
            ->toArray();
        $coachCapableRoles = array_values(array_unique(array_merge($managedCoachRoles, $coachPermissionRoleNames)));
        $currentCourseTraineeIds = $course->users()->whereIn('role', $managedParticipantRoles)->pluck('users.id')->toArray();
        $potentialTrainers = User::whereIn('role', $coachCapableRoles)
            ->where('status', 'active')
            ->get();
        // Only trainees already enrolled (pivot exists) for this course
        $potentialTrainees = User::whereIn('role', $managedParticipantRoles)
            ->whereIn('id', $currentCourseTraineeIds)
            ->get();
        // For summary, show ALL active trainers with their courses (not only assigned)
        $assignedTrainers = User::whereIn('role', $coachCapableRoles)
            ->where('status', 'active')
            ->with('courses')
            ->get();
        // Trainees summary mirroring trainers summary
        $assignedTrainees = User::whereIn('role', $managedParticipantRoles)
            ->whereIn('id', $currentCourseTraineeIds)
            ->with('courses')
            ->get();
        // Header notifications to match registrar dashboard header
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        $unreadNotificationsCount = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();
        return view('registrar.course-participants', compact(
            'course',
            'potentialTrainers',
            'potentialTrainees',
            'assignedTrainers',
            'assignedTrainees',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $allowedSubjectAreas = $this->allowedSubjectAreas();
        $validated = $request->validateWithBag('update_course', [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'subject_area' => 'required|array|min:1',
            'subject_area.*' => ['string', Rule::in($allowedSubjectAreas)],
            'video_url' => 'nullable|url',
            'video' => 'nullable|mimetypes:video/mp4,video/webm,video/ogg|max:204800',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'certification_id' => 'nullable|exists:certifications,id',
            'course_expiration_date' => 'nullable|date',
            'start_date' => 'nullable|date',
            'materials.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,mp4,webm,ogg',
        ]);

        $normalizedAreas = [];
        foreach (array_values(array_unique(array_filter(array_map('trim', $validated['subject_area'])))) as $area) {
            $label = \App\Models\Course::normalizeSubjectAreaLabel((string) $area);
            if ($label !== '' && in_array($label, \App\Models\Course::subjectAreaOptions(), true)) {
                $normalizedAreas[$label] = true;
            }
        }
        $validated['subject_area'] = json_encode(array_keys($normalizedAreas), JSON_UNESCAPED_UNICODE);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($course->image_path) {
                Storage::disk('public')->delete($course->image_path);
            }
            try {
                Storage::disk('public')->makeDirectory('course_images');
                $file = $request->file('image');
                if (!$file->isValid()) {
                    $code = $file->getError();
                    $map = [
                        UPLOAD_ERR_INI_SIZE => 'Image exceeds server limit.',
                        UPLOAD_ERR_FORM_SIZE => 'Image exceeds form limit.',
                        UPLOAD_ERR_PARTIAL => 'Image was only partially uploaded.',
                        UPLOAD_ERR_NO_FILE => 'No image was uploaded.',
                        UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder on server.',
                        UPLOAD_ERR_CANT_WRITE => 'Failed to write image to disk.',
                        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
                    ];
                    $msg = $map[$code] ?? 'Image upload error.';
                    return back()->withErrors(['image' => $msg], 'update_course')->withInput();
                }
                $imagePath = $file->store('course_images', 'public');
                $validated['image_path'] = $imagePath;
            } catch (\Throwable $e) {
                return back()
                    ->withErrors(['image' => 'Image upload failed on server. Check storage permissions or disk space.'], 'update_course')
                    ->withInput();
            }
        }
        if ($request->hasFile('video')) {
            if ($course->video_path) {
                Storage::disk('public')->delete($course->video_path);
            }
            $videoPath = $request->file('video')->store('course_videos', 'public');
            $validated['video_path'] = $videoPath;
        }

        $modulesInput = $request->input('modules', []);
        $modules = [];
        foreach ($modulesInput as $i => $module) {
            $topics = [];
            $topicInput = $module['topics'] ?? [];
            foreach ($topicInput as $j => $topic) {
                $existingTopic = $course->modules[$i]['topics'][$j] ?? [];
                // Support nested subtopics like in store(); preserve existing when not provided
                if (!empty($topic['subtopics']) && is_array($topic['subtopics'])) {
                    $subtopics = [];
                    $existingSubs = isset($existingTopic['subtopics']) && is_array($existingTopic['subtopics']) ? $existingTopic['subtopics'] : [];
                    foreach ($topic['subtopics'] as $k => $s) {
                        $sFields = null;
                        if (isset($s['fields_json'])) {
                            $sFields = json_decode($s['fields_json'], true);
                        } else {
                            $sFields = $existingSubs[$k]['fields'] ?? null;
                        }
                        $subtopics[] = [
                            'title' => $s['title'] ?? ($existingSubs[$k]['title'] ?? ''),
                            'fields' => $sFields,
                        ];
                    }
                    $topics[] = [
                        'title' => $topic['title'] ?? ($existingTopic['title'] ?? ''),
                        'subtopics' => $subtopics,
                    ];
                } else {
                    $fields = null;
                    if (isset($topic['fields_json'])) {
                        $fields = json_decode($topic['fields_json'], true);
                    } else {
                        // Backward compatibility and preservation
                        if (isset($topic['questions_json']) || isset($topic['materials_html'])) {
                            $fields = [];
                            if (!empty($topic['materials_html'])) {
                                $fields[] = ['type' => 'text', 'html' => $topic['materials_html']];
                            }
                            if (isset($topic['questions_json'])) {
                                $qs = json_decode($topic['questions_json'], true) ?: [];
                                foreach ($qs as $q) {
                                    $fields[] = ['type' => 'question', 'question' => $q];
                                }
                            }
                        } else {
                            $fields = $existingTopic['fields'] ?? null;
                        }
                    }
                    $topics[] = [
                        'title' => $topic['title'] ?? ($existingTopic['title'] ?? ''),
                        'fields' => $fields,
                    ];
                }
            }
            $mArr = [
                'title' => $module['title'] ?? '',
                'topics' => $topics,
            ];
            // Preserve module status/exam if already present and not provided
            $existingModule = $course->modules[$i] ?? [];
            if (isset($existingModule['status']) && !isset($mArr['status'])) {
                $mArr['status'] = $existingModule['status'];
            }
            if (isset($module['exam_json'])) {
                $examRaw = is_string($module['exam_json']) ? trim($module['exam_json']) : '';
                if ($examRaw !== '') {
                    $examDecoded = json_decode($examRaw, true);
                    if (is_array($examDecoded)) {
                        $examQuestions = array_values(array_filter(array_map(function ($q) {
                            return is_array($q) ? $this->normalizeExamQuestion($q) : null;
                        }, ($examDecoded['questions'] ?? []))));
                        $mArr['exam'] = [
                            'title' => (string) ($examDecoded['title'] ?? ''),
                            'description' => (string) ($examDecoded['description'] ?? ''),
                            'timer_minutes' => (int) ($examDecoded['timer_minutes'] ?? 0),
                            'timer_mode' => (string) ($examDecoded['timer_mode'] ?? 'timed'),
                            'passing_score' => (int) ($examDecoded['passing_score'] ?? 75),
                            'max_attempts' => isset($examDecoded['max_attempts']) || isset($examDecoded['attempt_limit'])
                                ? (int) ($examDecoded['max_attempts'] ?? $examDecoded['attempt_limit'])
                                : null,
                            'questions' => $examQuestions,
                        ];
                    }
                }
            } elseif (isset($existingModule['exam']) && is_array($existingModule['exam'])) {
                $mArr['exam'] = $existingModule['exam'];
            }
            $modules[] = $mArr;
        }
        if (!empty($modules)) {
            $validated['modules'] = $modules;
        }

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($course, $validated, $request) {
                $course->update($validated);
                $this->storeUploadedMaterials($request, $course);
            });
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error('Course update failed', [
                'course_id' => $course->id,
                'error' => $e->getMessage(),
            ]);
            return back()
                ->withErrors(['materials' => 'Course materials could not be saved. Please try again.'], 'update_course')
                ->withInput();
        }

        return redirect()->route('dashboard', [
                'tab' => 'course-view-details',
                'course_id' => $course->id,
            ])
            ->with('success_course', 'Course updated successfully.');
    }

    /**
     * Trainer-only endpoint to update course banner image.
     * Accepts a single 'image' file (already client-cropped).
     * Returns JSON with the new image URL for immediate UI update.
     */
    public function trainerUpdateImage(Request $request, Course $course)
    {
        $user = auth()->user();
        if (!$user || !$user->hasPermission('update_courses_coach')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ]);
        try {
            if ($course->image_path) {
                Storage::disk('public')->delete($course->image_path);
            }
            Storage::disk('public')->makeDirectory('course_images');
            $path = $request->file('image')->store('course_images', 'public');
            $course->update(['image_path' => $path]);
            $ver = optional($course->updated_at)->timestamp ?? time();
            $url = route('media.public', ['path' => $path], false) . '?v=' . $ver;
            return response()->json(['ok' => true, 'url' => $url]);
        } catch (\Throwable $e) {
            \Log::error('trainerUpdateImage failed', ['course' => $course->id, 'error' => $e->getMessage()]);
            return response()->json(['error' => 'Upload failed'], 500);
        }
    }

    /**
     * Set the enrollment schedule for a course (Registrar/TM only).
     */
    public function setEnrollmentSchedule(\Illuminate\Http\Request $request, Course $course)
    {
        $user = auth()->user();
        $tmRoles = ['training_manager', 'registrar', 'central_office_training_manager', 'regional_office_training_manager', 'provincial_office_training_manager'];
        
        $isRegistrar = in_array($user->role, $tmRoles, true);

        if (!$user || !$isRegistrar) {
            return back()->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'enrollment_start_date' => 'required|date',
            'enrollment_end_date' => 'required|date|after_or_equal:enrollment_start_date',
        ]);

        $course->update([
            'enrollment_start_date' => $validated['enrollment_start_date'],
            'enrollment_end_date' => $validated['enrollment_end_date'],
        ]);

        return back()->with('success', 'Enrollment schedule has been set successfully.');
    }

    /**
     * Set the expiration date for a course (Admin only).
     */
    public function setExpirationDate(\Illuminate\Http\Request $request, Course $course)
    {
        $user = auth()->user();
        $adminRoles = ['admin','super_admin','central_office_admin','regional_office_admin','provincial_office_admin'];
        $tmRoles = ['training_manager','registrar','central_office_training_manager','regional_office_training_manager','provincial_office_training_manager'];
        
        if (!$user || !in_array($user->role, array_merge($adminRoles, $tmRoles), true)) {
            return back()->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'course_expiration_date' => 'required|date',
        ]);

        $course->update([
            'course_expiration_date' => $validated['course_expiration_date'],
        ]);

        return back()->with('success', 'Course expiration date has been set successfully.');
    }

    public function setModuleStatus(\Illuminate\Http\Request $request, \App\Models\Course $course, int $index)
    {
        $role = auth()->user()->role ?? null;
        $allowed = [
            'trainer','coach','super_admin','admin',
            'training_manager','registrar',
            'central_office_training_manager','regional_office_training_manager','provincial_office_training_manager',
        ];
        if (!in_array($role, $allowed, true)) {
            return response()->json(['ok' => false, 'error' => 'Unauthorized'], 403);
        }
        $status = $request->input('status');
        if (!in_array($status, ['locked','unlocked'], true)) {
            return response()->json(['ok' => false, 'error' => 'Invalid status'], 422);
        }
        $mods = is_array($course->modules) ? $course->modules : [];
        if (!array_key_exists($index, $mods)) {
            return response()->json(['ok' => false, 'error' => 'Module not found'], 404);
        }
        $mods[$index]['status'] = $status;
        $course->modules = $mods;
        $course->save();
        return response()->json(['ok' => true, 'status' => $status, 'module' => $mods[$index]]);
    }

    public function modulesStatus(\App\Models\Course $course)
    {
        $mods = is_array($course->modules) ? $course->modules : [];
        $out = [];
        foreach ($mods as $m) {
            $out[] = [
                'title' => (string)($m['title'] ?? ''),
                'status' => (string)($m['status'] ?? 'unlocked'),
            ];
        }
        return response()->json(['ok' => true, 'modules' => $out]);
    }

    /**
     * Receive trainee Module Exam submission (no DB migration; store to local disk).
     */
    public function submitModuleExam(\Illuminate\Http\Request $request, \App\Models\Course $course)
    {
        return $this->processAssessmentSubmission($request, $course, false);
    }

    public function submitTopicQuiz(\Illuminate\Http\Request $request, \App\Models\Course $course)
    {
        return $this->processAssessmentSubmission($request, $course, true);
    }

    protected function processAssessmentSubmission(\Illuminate\Http\Request $request, \App\Models\Course $course, bool $isTopicQuiz)
    {
        $user = auth()->user();
        if (!$user) return response()->json(['ok'=>false,'error'=>'Unauthorized'], 403);
        try {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'mi' => 'required|integer|min:0',
                'ti' => 'nullable|integer|min:0',
                'si' => 'nullable|integer|min:0',
                'answers' => 'nullable|array',
                'duration_ms' => 'nullable|integer|min:0',
                'exam_integrity' => 'nullable|array',
                'exam_integrity.violations' => 'nullable|integer|min:0',
                'exam_integrity.warning_threshold' => 'nullable|integer|min:1',
                'exam_integrity.auto_submit_threshold' => 'nullable|integer|min:1',
                'exam_integrity.auto_submitted' => 'nullable|boolean',
                'exam_integrity.last_reason' => 'nullable|string|max:120',
                'exam_integrity.events' => 'nullable|array',
                'exam_integrity.events.*.type' => 'nullable|string|max:60',
                'exam_integrity.events.*.at' => 'nullable|string|max:80',
                'exam_integrity.events.*.count' => 'nullable|integer|min:1',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'ok' => false,
                    'error' => $validator->errors()->first() ?: 'Invalid exam submission.',
                    'errors' => $validator->errors(),
                ]);
            }

            $data = $validator->validated();
            $requestedModuleIndex = (int) $data['mi'];
            $requestedTopicIndex = isset($data['ti']) ? (int) $data['ti'] : null;
            $requestedSubIndex = isset($data['si']) ? (int) $data['si'] : null;

            if ($isTopicQuiz) {
                if ($requestedTopicIndex === null || $requestedSubIndex === null) {
                    return response()->json(['ok' => false, 'error' => 'Topic and sub-index are required for topic quizzes.'], 422);
                }
                if (!$this->canAccessTopicQuiz($course, $user->id, $requestedModuleIndex, $requestedTopicIndex, $requestedSubIndex)) {
                    return response()->json(['ok' => false, 'error' => 'Please complete the previous lessons first.']);
                }
                $exam = $this->getTopicQuizData($course, $requestedModuleIndex, $requestedTopicIndex, $requestedSubIndex);
                if (!$exam) {
                    return response()->json(['ok' => false, 'error' => 'Topic quiz not found.']);
                }
                $resolvedModuleIndex = $requestedModuleIndex;
            } else {
                $resolvedModuleIndex = $this->resolveExamModuleIndex($course, $requestedModuleIndex);
                $exam = $this->getCourseModuleExam($course, $requestedModuleIndex);
                if (!$exam) {
                    return response()->json(['ok' => false, 'error' => 'Module exam not found.']);
                }
                if ($resolvedModuleIndex === null) {
                    return response()->json(['ok' => false, 'error' => 'Module exam mapping is invalid.']);
                }
                if (!$this->canAccessModuleExam($course, $user->id, $requestedModuleIndex)) {
                    return response()->json(['ok' => false, 'error' => 'Complete all module topics before taking the module exam.']);
                }
            }

            [$passingScore, $maxAttempts] = $this->getExamConfigValues($exam);
            $assessment = $this->getOrCreateAssessment($course, $exam, $passingScore, $maxAttempts, $resolvedModuleIndex, $requestedTopicIndex, $requestedSubIndex);

            $attemptsUsed = Grade::where('assessment_id', $assessment->id)
                ->where('user_id', $user->id)
                ->get()
                ->filter(function($g) use ($resolvedModuleIndex, $requestedTopicIndex, $requestedSubIndex) {
                    $m = json_decode((string)($g->feedback ?? 'null'), true);
                    return isset($m['module_index']) && (int)$m['module_index'] === $resolvedModuleIndex
                        && (isset($m['topic_index']) ? (int)$m['topic_index'] : null) === $requestedTopicIndex
                        && (isset($m['sub_index']) ? (int)$m['sub_index'] : null) === $requestedSubIndex;
                })
                ->count();

            if ($maxAttempts !== null && $attemptsUsed >= $maxAttempts) {
                if (!$isTopicQuiz) {
                    $course->users()->updateExistingPivot($user->id, ['status' => 'attempts_exhausted']);
                }
                return response()->json([
                    'ok' => false,
                    'error' => 'You have reached the maximum number of attempts.',
                    'max_attempts_reached' => true,
                ]);
            }

            $questions = is_array($exam['questions'] ?? null) ? $exam['questions'] : [];
            $answers = array_values($data['answers'] ?? []);
            foreach ($questions as $index => $question) {
                $type = (string) ($question['type'] ?? '');
                if (! $this->isManualExamQuestionType($type)) {
                    continue;
                }
                $answerText = $this->formatManualExamAnswerForStorage($type, $answers[$index] ?? null);
                if (trim($answerText) === '') {
                    return response()->json([
                        'ok' => false,
                        'error' => ucfirst(str_replace('_', ' ', $type)).' answers cannot be empty.',
                        'question_index' => $index,
                    ]);
                }
                if ($type === 'enumeration') {
                    $submittedAnswers = $this->normalizeEnumerationAnswers(is_array($answers[$index] ?? null)
                        ? $answers[$index]
                        : preg_split("/\r\n|\n|\r/", (string) ($answers[$index] ?? '')));
                    $requiredCount = isset($question['required_answers_count']) && is_numeric($question['required_answers_count'])
                        ? max(1, (int) $question['required_answers_count'])
                        : max(1, count($submittedAnswers));
                    if (count($submittedAnswers) > $requiredCount) {
                        return response()->json([
                            'ok' => false,
                            'error' => "Enumeration question #".($index + 1)." accepts at most {$requiredCount} answer".($requiredCount === 1 ? '' : 's').".",
                            'question_index' => $index,
                        ], 422);
                    }
                }
            }

            $objectiveTotal = 0.0;
            $objectiveCorrect = 0.0;
            foreach ($questions as $index => $question) {
                $type = (string) ($question['type'] ?? 'multiple_choice');
                $answer = $answers[$index] ?? null;
                if (! $this->isObjectiveExamQuestionType($type)) {
                    continue;
                }

                $scored = $this->scoreObjectiveQuestion($question, $answer);
                $objectiveTotal += (float) ($scored['max_points'] ?? 0);
                $objectiveCorrect += (float) ($scored['score'] ?? 0);
            }

            $submittedAt = now()->toIso8601String();
            $payload = [
                'course_id' => $course->id,
                'user_id' => $user->id,
                'module_index' => $resolvedModuleIndex,
                'topic_index' => $requestedTopicIndex,
                'sub_index' => $requestedSubIndex,
                'exam_title' => $exam['title'] ?? ($isTopicQuiz ? 'Topic Quiz' : 'Module Exam'),
                'correct' => round($objectiveCorrect, 2),
                'total' => round($objectiveTotal, 2),
                'pct' => $objectiveTotal > 0 ? (int) round(($objectiveCorrect / $objectiveTotal) * 100) : 0,
                'answers' => $answers,
                'duration_ms' => $data['duration_ms'] ?? null,
                'submitted_at' => $submittedAt,
                'exam_integrity' => $this->normalizeExamIntegrityPayload($data['exam_integrity'] ?? null),
            ];
            $dir = storage_path('app/exam_submissions/course_'.$course->id);
            if (!is_dir($dir)) @mkdir($dir, 0775, true);
            if (!is_dir($dir)) return response()->json(['ok' => false, 'error' => 'Unable to prepare exam submission storage.'], 500);
            
            $filename = 'mi_'.$resolvedModuleIndex;
            if ($isTopicQuiz) $filename .= '_ti_'.$requestedTopicIndex.'_si_'.$requestedSubIndex;
            $filename .= '_u_'.$user->id.'.json';
            
            if (file_put_contents($dir . DIRECTORY_SEPARATOR . $filename, json_encode($payload, JSON_PRETTY_PRINT)) === false) {
                return response()->json(['ok' => false, 'error' => 'Unable to save exam submission file.'], 500);
            }

            $this->syncManualResponsesForSubmission($course, $user, $resolvedModuleIndex, $questions, $answers, $submittedAt, $requestedTopicIndex, $requestedSubIndex);
            $summary = $this->buildModuleExamAttemptSummary($course, $requestedModuleIndex, $user->id, $payload);
            $evaluation = $this->evaluateFinalExamOutcome($course, $resolvedModuleIndex, $user->id, $summary, $exam, $requestedTopicIndex, $requestedSubIndex);
            
            if ($isTopicQuiz) {
                \App\Models\ReflectionResponse::updateOrCreate(
                    ['user_id' => $user->id, 'course_id' => $course->id, 'module_index' => $requestedModuleIndex, 'topic_index' => $requestedTopicIndex, 'sub_index' => $requestedSubIndex],
                    ['answers_json' => json_encode(['quiz_submitted' => true, 'pct' => $payload['pct']])]
                );
            }

            $completed = false;
            if (!$isTopicQuiz && ($evaluation['passed'] ?? false) === true) {
                $completed = $this->issueCertificateIfCompleted($user, $course);
            }

            return response()->json([
                'ok' => true,
                'completed' => $completed,
                'is_topic_quiz' => $isTopicQuiz,
                'summary' => array_merge($summary, [
                    'passing_score' => $evaluation['passing_score'] ?? $passingScore,
                    'max_attempts' => $evaluation['max_attempts'] ?? $maxAttempts,
                    'attempt_no' => $evaluation['attempt_no'] ?? ($attemptsUsed + 1),
                    'passed' => $evaluation['passed'] ?? null,
                    'restart_required' => $evaluation['restart_required'] ?? false,
                    'max_attempts_reached' => $evaluation['max_attempts_reached'] ?? false,
                ]),
            ]);
        } catch (\Throwable $e) {
            \Log::error('submitModuleExam failed', ['course_id' => $course->id, 'user_id' => $user->id, 'message' => $e->getMessage()]);
            return response()->json(['ok' => false, 'error' => 'Exam submission failed on the server.'], 500);
        }
    }

    /**
     * Return list of Module Exam submissions for a module index.
     */
    public function moduleExamResults(\Illuminate\Http\Request $request, \App\Models\Course $course)
    {
        $user = auth()->user();
        if (!$user || !in_array($user->role, ['trainer','coach','admin','super_admin','central_office_coach','regional_office_coach','provincial_office_coach'], true)) {
            return response()->json(['ok'=>false,'error'=>'Unauthorized'], 403);
        }
        $mi = (int)$request->query('mi', -1);
        if ($mi < 0) return response()->json(['ok'=>false,'error'=>'Missing module index']);
        $resolvedModuleIndex = $this->resolveExamModuleIndex($course, $mi);
        if ($resolvedModuleIndex === null) {
            return response()->json(['ok' => true, 'items' => []]);
        }
        $dir = storage_path('app/exam_submissions/course_'.$course->id);
        $items = [];
        if (is_dir($dir)) {
            foreach (glob($dir.DIRECTORY_SEPARATOR.'mi_'.$resolvedModuleIndex.'_u_*.json') as $p) {
                $j = json_decode(@file_get_contents($p), true) ?: [];
                if (!empty($j['user_id'])) {
                    $u = \App\Models\User::find($j['user_id']);
                    $summary = $this->buildModuleExamAttemptSummary($course, $mi, (int) $j['user_id'], $j);
                    $items[] = [
                        'user_id' => $j['user_id'],
                        'name' => $u?->name ?? 'User '.$j['user_id'],
                        'email' => $u?->email ?? null,
                        'pct' => (int) ($summary['final_pct'] ?? ($j['pct'] ?? 0)),
                        'correct' => round((float) ($summary['objective_correct'] ?? ($j['correct'] ?? 0)), 2),
                        'total' => round((float) ($summary['objective_total'] ?? ($j['total'] ?? 0)), 2),
                        'objective_pct' => (int) ($summary['objective_pct'] ?? ($j['pct'] ?? 0)),
                        'essay_pending_count' => (int) ($summary['essay_pending_count'] ?? 0),
                        'essay_checked_count' => (int) ($summary['essay_checked_count'] ?? 0),
                        'manual_pending_count' => (int) ($summary['manual_pending_count'] ?? ($summary['essay_pending_count'] ?? 0)),
                        'manual_checked_count' => (int) ($summary['manual_checked_count'] ?? ($summary['essay_checked_count'] ?? 0)),
                        'status' => (string) ($summary['status'] ?? 'completed'),
                        'status_label' => (string) ($summary['status_label'] ?? 'Completed'),
                        'violation_count' => (int) ($summary['violation_count'] ?? 0),
                        'auto_submitted' => (bool) ($summary['auto_submitted'] ?? false),
                        'submitted_at' => $j['submitted_at'] ?? null,
                    ];
                }
            }
        }
        // Sort latest first
        usort($items, fn($a,$b)=>strcmp($b['submitted_at']??'', $a['submitted_at']??''));
        return response()->json(['ok'=>true,'items'=>$items]);
    }

    public function moduleExamAttempt(Request $request, Course $course)
    {
        $user = auth()->user();
        if (!$user) return response()->json(['ok' => false, 'error' => 'Unauthorized'], 403);

        $moduleIndex = (int) $request->query('mi', -1);
        if ($moduleIndex < 0) return response()->json(['ok' => false, 'error' => 'Missing module index'], 422);

        if (!$this->canAccessModuleExam($course, $user->id, $moduleIndex)) {
            return response()->json(['ok' => false, 'error' => 'Complete all module topics before taking the module exam.']);
        }

        $summary = $this->buildModuleExamAttemptSummary($course, $moduleIndex, $user->id);
        if (!$summary) return response()->json(['ok' => true, 'attempt' => null]);

        $pivot = $this->getCourseUserPivot($course, $user->id);
        return response()->json([
            'ok' => true,
            'attempt' => $summary,
            'retake_requested' => (bool) ($pivot->retake_requested ?? false),
            'retake_approved' => (bool) ($pivot->retake_approved ?? false),
        ]);
    }

    public function topicQuizAttempt(Request $request, Course $course)
    {
        $user = auth()->user();
        if (!$user) return response()->json(['ok' => false, 'error' => 'Unauthorized'], 403);

        $mi = (int) $request->query('mi', -1);
        $ti = (int) $request->query('ti', -1);
        $si = (int) $request->query('si', -1);

        if ($mi < 0 || $ti < 0 || $si < 0) return response()->json(['ok' => false, 'error' => 'Missing indices'], 422);

        if (!$this->canAccessTopicQuiz($course, $user->id, $mi, $ti, $si)) {
            return response()->json(['ok' => false, 'error' => 'Please complete the previous lessons first.']);
        }

        $summary = $this->buildModuleExamAttemptSummary($course, $mi, $user->id, ['topic_index' => $ti, 'sub_index' => $si]);
        return response()->json([
            'ok' => true,
            'attempt' => $summary,
            'retake_requested' => false, // Topic quizzes don't usually need formal retake approval
            'retake_approved' => true,
        ]);
    }

    public function requestModuleExamRetake(Request $request, Course $course)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['ok' => false, 'error' => 'Unauthorized'], 403);
        }

        $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
        if (!in_array($user->role, $participantRoles, true)) {
            return response()->json(['ok' => false, 'error' => 'Unauthorized'], 403);
        }

        $moduleIndex = (int) $request->input('mi', $this->getFinalExamModuleIndex($course) ?? 0);
        $summary = $this->buildModuleExamAttemptSummary($course, $moduleIndex, $user->id);
        if (!$summary || ($summary['passed'] ?? null) !== false) {
            return response()->json(['ok' => false, 'error' => 'A failed exam attempt is required before requesting a retake.'], 422);
        }

        if (($summary['max_attempts_reached'] ?? false) === true) {
            return response()->json(['ok' => false, 'error' => 'You have reached the maximum number of attempts.'], 422);
        }

        $pivot = $this->getCourseUserPivot($course, $user->id);
        if (!$pivot) {
            return response()->json(['ok' => false, 'error' => 'Enrollment record not found.'], 404);
        }

        if ((bool) ($pivot->retake_approved ?? false)) {
            return response()->json(['ok' => true, 'retake_requested' => false, 'retake_approved' => true]);
        }

        $course->users()->updateExistingPivot($user->id, [
            'retake_requested' => true,
            'retake_approved' => false,
            'status' => 'failed',
        ]);

        return response()->json(['ok' => true, 'retake_requested' => true, 'retake_approved' => false]);
    }

    public function approveModuleExamRetake(Request $request, Course $course)
    {
        $user = auth()->user();
        if (!$user || !in_array($user->role, ['trainer','coach','admin','super_admin','central_office_coach','regional_office_coach','provincial_office_coach'], true)) {
            return response()->json(['ok' => false, 'error' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'user_id' => 'required|integer|min:1',
            'mi' => 'nullable|integer|min:0',
        ]);

        $userId = (int) $data['user_id'];
        $moduleIndex = array_key_exists('mi', $data)
            ? (int) $data['mi']
            : (int) ($this->getFinalExamModuleIndex($course) ?? 0);

        $summary = $this->buildModuleExamAttemptSummary($course, $moduleIndex, $userId);
        if (!$summary || ($summary['passed'] ?? null) !== false) {
            return response()->json(['ok' => false, 'error' => 'Only failed exam attempts can be approved for retake.'], 422);
        }

        if (($summary['max_attempts_reached'] ?? false) === true) {
            return response()->json(['ok' => false, 'error' => 'This participant has reached the maximum number of attempts.'], 422);
        }

        $pivot = $this->getCourseUserPivot($course, $userId);
        if (!$pivot) {
            return response()->json(['ok' => false, 'error' => 'Enrollment record not found.'], 404);
        }

        if (!(bool) ($pivot->retake_requested ?? false) && !(bool) ($pivot->retake_approved ?? false)) {
            return response()->json(['ok' => false, 'error' => 'This participant has not requested a retake yet.'], 422);
        }

        $course->users()->updateExistingPivot($userId, [
            'retake_requested' => false,
            'retake_approved' => true,
            'status' => 'failed',
        ]);

        return response()->json(['ok' => true, 'retake_requested' => false, 'retake_approved' => true]);
    }

    public function restartModuleExamProgress(Request $request, Course $course)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['ok' => false, 'error' => 'Unauthorized'], 403);
        }

        $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
        if (!in_array($user->role, $participantRoles, true)) {
            return response()->json(['ok' => false, 'error' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'mi' => 'nullable|integer|min:0',
        ]);

        $requestedModuleIndex = array_key_exists('mi', $data)
            ? (int) $data['mi']
            : (int) ($this->getFinalExamModuleIndex($course) ?? 0);

        $resolvedModuleIndex = $this->resolveExamModuleIndex($course, $requestedModuleIndex);
        $summary = $this->buildModuleExamAttemptSummary($course, $requestedModuleIndex, $user->id);
        if (!$summary) {
            return response()->json(['ok' => false, 'error' => 'No failed exam attempt found.'], 404);
        }

        if (($summary['max_attempts_reached'] ?? false) === true) {
            return response()->json([
                'ok' => false,
                'error' => 'You have reached the maximum number of attempts.',
                'max_attempts_reached' => true,
            ]);
        }

        // New retake logic: only allow if approved
        $pivot = $this->getCourseUserPivot($course, $user->id);
        if (!$pivot || !$pivot->retake_approved) {
            return response()->json(['ok' => false, 'error' => 'Your retake request has not been approved yet.'], 403);
        }

        // Only reset the exam, not the modules
        $this->resetTraineeCourseProgress($course, $user->id, $resolvedModuleIndex ?? $requestedModuleIndex, true);

        return response()->json([
            'ok' => true,
            'redirect_url' => route('trainee.courses.outline', ['course' => $course, 'mi' => $requestedModuleIndex]),
        ]);
    }

    public function reviewModuleExamEssay(Request $request, Course $course)
    {
        $user = auth()->user();
        if (!$user || !in_array($user->role, ['trainer','coach','admin','super_admin','central_office_coach','regional_office_coach','provincial_office_coach'], true)) {
            return response()->json(['ok' => false, 'error' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'mi' => 'required|integer|min:0',
            'user_id' => 'required|integer|min:1',
            'reviews' => 'required|array|min:1',
            'reviews.*.question_index' => 'required|integer|min:0',
            'reviews.*.score' => 'required|numeric|min:0',
            'reviews.*.feedback' => 'nullable|string',
        ]);

        $requestedModuleIndex = (int) $data['mi'];
        $resolvedModuleIndex = $this->resolveExamModuleIndex($course, $requestedModuleIndex);
        $exam = $this->getCourseModuleExam($course, $requestedModuleIndex);
        if (!$exam) {
            return response()->json(['ok' => false, 'error' => 'Module exam not found.'], 404);
        }
        if ($resolvedModuleIndex === null) {
            return response()->json(['ok' => false, 'error' => 'Module exam mapping is invalid.'], 422);
        }

        $questions = is_array($exam['questions'] ?? null) ? $exam['questions'] : [];
        $rows = ExamEssayResponse::where('course_id', $course->id)
            ->where('trainee_id', (int) $data['user_id'])
            ->where('module_index', $resolvedModuleIndex)
            ->get()
            ->keyBy('question_index');

        foreach ($data['reviews'] as $review) {
            $questionIndex = (int) $review['question_index'];
            $question = $questions[$questionIndex] ?? null;
            $type = (string) ($question['type'] ?? '');
            if (!is_array($question) || ! $this->isManualExamQuestionType($type)) {
                return response()->json(['ok' => false, 'error' => 'One of the selected items does not require manual checking.'], 422);
            }

            $row = $rows->get($questionIndex);
            if (!$row) {
                return response()->json(['ok' => false, 'error' => 'Manual response not found for one of the questions.'], 404);
            }

            $maxPoints = isset($question['max_points']) && is_numeric($question['max_points'])
                ? max(1, (float) $question['max_points'])
                : 1.0;
            $score = (float) $review['score'];
            if ($score > $maxPoints) {
                return response()->json([
                    'ok' => false,
                    'error' => 'Manual score cannot exceed the maximum points.',
                    'question_index' => $questionIndex,
                ], 422);
            }
        }

        foreach ($data['reviews'] as $review) {
            $questionIndex = (int) $review['question_index'];
            $row = $rows->get($questionIndex);
            $row->update([
                'score' => (float) $review['score'],
                'feedback' => isset($review['feedback']) ? trim((string) $review['feedback']) : null,
                'status' => 'checked',
                'checked_by_trainer' => $user->id,
                'checked_at' => now(),
            ]);
        }

        $summary = $this->buildModuleExamAttemptSummary($course, $requestedModuleIndex, (int) $data['user_id']);
        $completed = false;
        $trainee = User::find((int) $data['user_id']);
        $evaluation = $this->evaluateFinalExamOutcome($course, $resolvedModuleIndex, (int) $data['user_id'], $summary, $exam);
        if (($evaluation['passed'] ?? false) === true && $trainee) {
                $completed = $this->issueCertificateIfCompleted($trainee, $course);
        }
        return response()->json([
            'ok' => true,
            'attempt' => array_merge($summary, [
                'attempt_no' => $evaluation['attempt_no'] ?? null,
                'passed' => $evaluation['passed'] ?? null,
                'restart_required' => $evaluation['restart_required'] ?? false,
                'max_attempts_reached' => $evaluation['max_attempts_reached'] ?? false,
                'restart_message' => ($evaluation['restart_required'] ?? false)
                    ? 'You may request an exam retake from your trainer.'
                    : null,
                'max_attempts_message' => ($evaluation['max_attempts_reached'] ?? false)
                    ? 'You have reached the maximum number of attempts.'
                    : null,
                'redirect_url' => null,
            ]),
            'completed' => $completed,
        ]);
    }

    /**
     * Trainer-only: Aggregated participants' per-module progress and exam scores.
     */
    public function participantsProgress(\Illuminate\Http\Request $request, \App\Models\Course $course)
    {
        $user = auth()->user();
        if (!$user || !in_array($user->role, ['trainer','coach','admin','super_admin','central_office_coach','regional_office_coach','provincial_office_coach'], true)) {
            return response()->json(['ok'=>false,'error'=>'Unauthorized'], 403);
        }
        $mods = is_array($course->modules) ? $course->modules : [];
        if (!empty($mods)) {
            $normalized = [];
            foreach ($mods as $mi => $m) {
                $topics = isset($m['topics']) && is_array($m['topics']) ? $m['topics'] : [];
                $exam = isset($m['exam']) && is_array($m['exam']) ? $m['exam'] : null;
                $hasTopics = !empty($topics);
                $hasExam = $exam && !empty($exam['questions'] ?? []);

                if ($hasTopics) {
                    $normalized[] = $m;
                    continue;
                }

                if ($hasExam && !empty($normalized)) {
                    $prevIndex = count($normalized) - 1;
                    $prevTopics = isset($normalized[$prevIndex]['topics']) && is_array($normalized[$prevIndex]['topics'])
                        ? $normalized[$prevIndex]['topics']
                        : [];
                    $prevHasExam = !empty($normalized[$prevIndex]['exam']['questions'] ?? []);
                    if (!empty($prevTopics) && !$prevHasExam) {
                        $normalized[$prevIndex]['exam'] = $exam;
                        continue;
                    }
                }

                $normalized[] = $m;
            }
            $mods = array_values($normalized);
        }
        // Normalize modules meta and totals
        $modulesMeta = [];
        $totals = [];
        foreach ($mods as $mi => $m) {
            $topics = isset($m['topics']) && is_array($m['topics']) ? $m['topics'] : [];
            $totalSubs = 0;
            foreach ($topics as $t) {
                $subs = isset($t['subtopics']) && is_array($t['subtopics']) ? $t['subtopics'] : [];
                $totalSubs += count($subs);
            }
            $examTitle = '';
            $passPct = null;
            if (isset($m['exam']) && is_array($m['exam'])) {
                try { $examTitle = (string) ($m['exam']['title'] ?? ''); } catch (\Throwable $e) { $examTitle = ''; }
                $passRaw = $m['exam']['passing_score'] ?? null;
                if ($passRaw !== null && $passRaw !== '') {
                    $passPct = (int) $passRaw;
                }
            }
            $modulesMeta[] = [
                'index' => $mi,
                'title' => (string)($m['title'] ?? ('Module '.($mi+1))),
                'exam_title' => $examTitle,
                'passing_score' => $passPct,
                'total_subs' => $totalSubs,
            ];
            $totals[$mi] = $totalSubs;
        }
        // Participants (active only)
        $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
        $participants = $course->users()
            ->whereIn('role', $participantRoles)
            ->wherePivotIn('status', ['active', 'in_progress', 'ready_for_exam', 'completed', 'failed', 'attempts_exhausted'])
            ->get();
        $outUsers = [];
        foreach ($participants as $u) {
            $rows = \App\Models\ReflectionResponse::where('user_id', $u->id)
                ->where('course_id', $course->id)
                ->get(['module_index','topic_index','sub_index','answers_json']);
            $doneSetByModule = [];
            foreach ($rows as $r) {
                $doneSetByModule[$r->module_index] = ($doneSetByModule[$r->module_index] ?? 0) + 1;
            }
            $scores = [];
            foreach ($mods as $mi => $_) {
                $total = $totals[$mi] ?? 0;
                $done = $doneSetByModule[$mi] ?? 0;
                $modulePct = $total ? (int) round(($done / $total) * 100) : null;
                $hasExam = !empty($mods[$mi]['exam']['questions'] ?? []);
                $examSummary = $hasExam ? $this->buildModuleExamAttemptSummary($course, $mi, $u->id) : null;
                $scores[] = [
                    'module_pct' => $modulePct,
                    'exam_pct' => $examSummary['final_pct'] ?? null,
                    'exam_status' => $examSummary['status'] ?? null,
                    'essay_pending_count' => $examSummary['essay_pending_count'] ?? 0,
                    'manual_pending_count' => $examSummary['manual_pending_count'] ?? ($examSummary['essay_pending_count'] ?? 0),
                    'exam_passed' => $examSummary['passed'] ?? null,
                    'exam_status_label' => $examSummary['status_label'] ?? null,
                    'exam_has_submission' => $examSummary !== null,
                    'retake_requested' => (bool) ($u->pivot->retake_requested ?? false),
                    'retake_approved' => (bool) ($u->pivot->retake_approved ?? false),
                ];
            }
            $outUsers[] = [
                'user_id' => $u->id,
                'name' => $u->name,
                'scores' => $scores,
            ];
        }
        return response()->json([
            'ok' => true,
            'modules' => $modulesMeta,
            'users' => $outUsers,
        ]);
    }

    public function accessState(Course $course)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['ok' => false, 'error' => 'Unauthorized'], 403);
        }

        $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
        if (!in_array($user->role, $participantRoles, true)) {
            return response()->json(['ok' => false, 'error' => 'Unauthorized'], 403);
        }

        $sync = $this->syncSequentialProgress($course, $user->id);

        $completedModuleIndexes = \App\Models\ModuleProgress::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('is_completed', true)
            ->pluck('module_index')
            ->toArray();

        $modules = $this->getNormalizedCourseModules($course);
        $quizAccess = [];
        $examAccess = [];
        foreach ($modules as $mi => $m) {
            $topics = isset($m['topics']) && is_array($m['topics']) ? $m['topics'] : [];
            $hasTopics = !empty($topics);
            if ($hasTopics) {
                $quizAccess[$mi] = $this->canAccessModuleQuiz($course, $user->id, $mi);
            } else {
                $examAccess[$mi] = $this->canAccessModuleExam($course, $user->id, $mi);
            }
        }

        return response()->json([
            'ok' => true,
            'allowed_module_index' => $this->getAllowedModuleArrayIndex($course, $user->id),
            'final_exam_module_index' => $this->getFinalExamModuleIndex($course),
            'final_exam_unlocked' => $this->areAllModulesCompleted($course, $user->id),
            'current_module' => $sync['current_module'] ?? null,
            'progress_percentage' => $sync['progress_percentage'] ?? null,
            'status' => $sync['status'] ?? null,
            'completed_module_indexes' => $completedModuleIndexes,
            'quiz_access' => $quizAccess,
            'exam_access' => $examAccess,
        ]);
    }

    /**
     * Upload an inline content image for course editors.
     */
    public function uploadContentImage(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();
        $adminRoles = ['admin','super_admin','central_office_admin','regional_office_admin','provincial_office_admin'];
        $coachRoles = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
        $allowedRoles = array_merge($adminRoles, $coachRoles);

        if (!$user || !in_array($user->role, $allowedRoles, true)) {
            return response()->json(['ok' => false, 'error' => 'Unauthorized'], 403);
        }
        $request->validate([
            'image' => 'required|image|max:10240', // 10MB
        ]);
        try {
            $path = $request->file('image')->store('course_content', 'public');
            return response()->json([
                'ok' => true,
                'url' => route('media.public', ['path' => $path], false),
                'path' => $path,
            ]);
        } catch (\Throwable $e) {
            \Log::error('uploadContentImage failed', ['err' => $e->getMessage()]);
            return response()->json(['ok' => false, 'error' => 'Upload failed'], 500);
        }
    }

    public function uploadContentPDF(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();
        $adminRoles = ['admin','super_admin','central_office_admin','regional_office_admin','provincial_office_admin'];
        $coachRoles = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
        $allowedRoles = array_merge($adminRoles, $coachRoles);

        if (!$user || !in_array($user->role, $allowedRoles, true)) {
            return response()->json(['ok' => false, 'error' => 'Unauthorized'], 403);
        }
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:10240', // 10MB
        ]);
        try {
            $path = $request->file('pdf')->store('course_content/pdfs', 'public');
            return response()->json([
                'ok' => true,
                'url' => route('media.public', ['path' => $path], false),
                'path' => $path,
                'name' => $request->file('pdf')->getClientOriginalName()
            ]);
        } catch (\Throwable $e) {
            \Log::error('uploadContentPDF failed', ['err' => $e->getMessage()]);
            return response()->json(['ok' => false, 'error' => 'Upload failed'], 500);
        }
    }

    public function modulesJson(\App\Models\Course $course)
    {
        $mods = $course->modules;
        if (is_string($mods)) {
            try { $mods = json_decode($mods, true); } catch (\Throwable $e) { $mods = []; }
        }
        if (!is_array($mods)) $mods = [];
        return response()->json(['ok' => true, 'modules' => $mods]);
    }

    public function getCourseDetailsAjax(\App\Models\Course $course)
    {
        $course->load(['certification', 'assessments', 'materials']);
        $creator = \App\Models\User::find($course->created_by);
        
        $modules = is_array($course->modules) ? $course->modules : [];
        if (is_string($course->modules)) {
            $modules = json_decode($course->modules, true) ?: [];
        }

        // Add index to modules for easier rendering
        foreach ($modules as $idx => &$mod) {
            $mod['index'] = $idx;
        }

        $moduleExams = collect($modules)->map(function ($mod, $idx) {
            $exam = isset($mod['exam']) && is_array($mod['exam']) ? $mod['exam'] : null;
            $questions = is_array($exam['questions'] ?? null) ? $exam['questions'] : [];

            if (!$exam || empty($questions)) {
                return null;
            }

            $moduleTitle = trim((string) ($mod['title'] ?? '')) ?: ('Module ' . ($idx + 1));
            $examTitle = trim((string) ($exam['title'] ?? '')) ?: 'Module Exam';

            return [
                'id' => null,
                'title' => $examTitle,
                'type' => 'module_exam',
                'due_date' => 'No deadline',
                'question_count' => count($questions),
                'module_index' => $idx,
                'module_title' => $moduleTitle,
                'source' => 'module',
                'description' => (string) ($exam['description'] ?? ''),
                'questions' => $questions,
            ];
        })->filter()->values();

        $dbAssessments = $course->assessments->map(function($a) {
            $questions = is_array($a->questions_json)
                ? $a->questions_json
                : (json_decode($a->questions_json ?? '[]', true) ?: []);

            return [
                'id' => $a->id,
                'title' => $a->title,
                'type' => $a->type,
                'due_date' => $a->due_date ? $a->due_date->format('M d, Y') : 'No deadline',
                'question_count' => count($questions),
                'module_index' => null,
                'module_title' => null,
                'source' => 'assessment',
                'description' => (string) ($a->description ?? ''),
                'questions' => $questions,
            ];
        })->values();

        return response()->json([
            'ok' => true,
            'course' => [
                'id' => $course->id,
                'name' => $course->name,
                'description' => $course->description,
                'subject_area' => $course->subject_area,
                'course_type' => $course->course_type,
                'image_path' => $course->image_url,
                'video_url' => $course->video_url,
                'start_date' => $course->start_date ? $course->start_date->format('Y-m-d') : null,
                'course_expiration_date' => $course->course_expiration_date ? \Carbon\Carbon::parse($course->course_expiration_date)->format('Y-m-d') : null,
                'created_at' => optional($course->created_at)->format('M d, Y'),
                'creator_name' => $creator ? $creator->name : 'N/A',
                'certification' => $course->certification ? [
                    'id' => $course->certification->id,
                    'name' => $course->certification->name,
                    'category' => $course->certification->category,
                    'file_path' => $course->certification->file_path,
                    'file_url' => $course->certification->file_path
                        ? route('certifications.download', ['certification' => $course->certification->id, 'inline' => 1])
                        : null,
                ] : null,
                'modules' => $modules,
                'materials' => $course->materials->map(function ($material) {
                    return [
                        'id' => $material->id,
                        'title' => $material->title,
                        'description' => $material->description,
                        'file_path' => $material->file_path,
                        'file_name' => $material->file_path ? basename($material->file_path) : null,
                        'file_url' => $material->file_path ? asset('storage/' . $material->file_path) : null,
                        'type' => $material->type,
                    ];
                })->values(),
                'status' => $course->status,
                'is_published' => $course->is_published,
                'trashed' => $course->trashed(),
                'assessments' => $dbAssessments->concat($moduleExams)->values(),
            ]
        ]);
    }

    public function saveExamAjax(Request $request, \App\Models\Course $course)
    {
        $this->authorize('update', $course);
        $examJson = $request->input('exam_json');
        if (!is_string($examJson)) {
            return response()->json(['ok' => false, 'error' => 'Invalid payload'], 422);
        }
        try {
            $e = json_decode($examJson, true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $th) {
            return response()->json(['ok' => false, 'error' => 'Invalid JSON'], 422);
        }
        $title = trim((string) ($e['title'] ?? ''));
        $description = (string) ($e['description'] ?? '');
        $timer = (int) ($e['timer_minutes'] ?? 0);
        $passingScore = isset($e['passing_score']) && $e['passing_score'] !== ''
            ? max(1, min(100, (int) $e['passing_score']))
            : 75;
        $maxAttempts = isset($e['max_attempts']) && $e['max_attempts'] !== ''
            ? max(1, (int) $e['max_attempts'])
            : (isset($e['attempt_limit']) && $e['attempt_limit'] !== '' ? max(1, (int) $e['attempt_limit']) : null);
        $qs = is_array($e['questions'] ?? []) ? $e['questions'] : [];
        // Validation per requirements
        if ($title === '') {
            return response()->json(['ok' => false, 'error' => 'Exam title is required'], 422);
        }
        $errors = [];
        $norm = [];
        foreach ($qs as $i => $q) {
            $type = $q['type'] ?? '';
            $text = isset($q['text']) ? trim((string) $q['text']) : '';
            if ($text === '') {
                $errors[] = "Question #".($i+1)." text is required";
                continue;
            }
            $maxPoints = $this->normalizeRequiredExamPoints($q['max_points'] ?? null);
            if ($maxPoints === null) {
                $errors[] = empty($q['max_points'])
                    ? "Question #".($i+1).": Points is required."
                    : "Question #".($i+1).": Points must be at least 1.";
                continue;
            }
            if ($type === 'identification') {
                $norm[] = [
                    'type' => 'identification',
                    'text' => $text,
                    'teacher_notes' => trim((string) ($q['teacher_notes'] ?? $q['answer'] ?? '')),
                    'accepted_answers' => $this->normalizeEnumerationAnswers($q['accepted_answers'] ?? ($q['answers'] ?? [])),
                    'max_points' => $maxPoints,
                ];
            } elseif ($type === 'multiple_choice' || $type === 'multiple_choice_single' || $type === 'multiple_choice_multiple') {
                if ($type === 'multiple_choice') {
                    $type = 'multiple_choice_single';
                }
                $choices = $q['choices'] ?? ($q['options'] ?? []);
                $choices = array_values(array_filter(array_map(fn($v)=>trim((string)$v), (array) $choices), fn($v)=>$v!==''));
                $choiceKeys = array_map(fn($v)=>$this->normalizeComparableAnswer($v), $choices);
                $correctIndexes = $this->normalizeMultipleChoiceCorrectIndexes($q, $choices);
                if (count($choices) < 2) {
                    $errors[] = "Question #".($i+1)." must have at least two choices";
                    continue;
                }
                if (count($choiceKeys) !== count(array_unique($choiceKeys))) {
                    $errors[] = "Question #".($i+1)." has duplicate choices";
                    continue;
                }
                if ($type === 'multiple_choice_single' && count($correctIndexes) !== 1) {
                    $errors[] = "Question #".($i+1)." must have exactly one correct answer";
                    continue;
                }
                if ($type === 'multiple_choice_multiple' && count($correctIndexes) < 1) {
                    $errors[] = "Question #".($i+1)." must have at least one correct answer";
                    continue;
                }
                if (array_filter($correctIndexes, fn($index)=>$index < 0 || $index >= count($choices))) {
                    $errors[] = "Question #".($i+1)." must specify valid correct choices";
                    continue;
                }
                $item = [
                    'type'=>$type,
                    'text'=>$text,
                    'choices'=>$choices,
                    'correct_answers'=>array_map(fn($index)=>$this->choiceIndexToLetter($index), $correctIndexes),
                    'max_points'=>$maxPoints,
                ];
                if ($type === 'multiple_choice_single') {
                    $item['answer_index'] = $correctIndexes[0];
                }
                $norm[] = $item;
            } elseif ($type === 'true_false') {
                $ans = filter_var($q['answer'] ?? null, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                if ($ans === null && is_bool($q['answer'] ?? null)) {
                    $ans = $q['answer'];
                }
                if ($ans === null) {
                    $errors[] = "Question #".($i+1)." must specify True or False";
                    continue;
                }
                $norm[] = ['type'=>'true_false','text'=>$text,'answer'=>$ans===true,'max_points'=>$maxPoints];
            } elseif ($type === 'essay') {
                $norm[] = ['type'=>'essay','text'=>$text,'max_points'=>$maxPoints];
            } elseif ($type === 'enumeration') {
                $requiredAnswers = isset($q['required_answers_count']) && is_numeric($q['required_answers_count'])
                    ? (int) $q['required_answers_count']
                    : count($this->normalizeEnumerationAnswers($q['answers'] ?? ($q['correct_answers'] ?? [])));
                if ($requiredAnswers < 1) {
                    $errors[] = "Question #".($i+1)." required number of answers must be at least 1";
                    continue;
                }
                $norm[] = [
                    'type' => 'enumeration',
                    'text' => $text,
                    'required_answers_count' => $requiredAnswers,
                    'expected_guide' => trim((string) ($q['expected_guide'] ?? $q['teacher_notes'] ?? '')),
                    'max_points' => $maxPoints,
                ];
            } else {
                // Skip unsupported types
            }
        }
        if (!empty($errors)) {
            return response()->json(['ok'=>false,'error'=>implode('; ', $errors)], 422);
        }
        // Transaction to avoid partial updates
        \Illuminate\Support\Facades\DB::transaction(function() use ($course, $title, $description, $timer, $passingScore, $maxAttempts, $norm) {
            $mods = $course->modules;
            if (is_string($mods)) {
                try { $mods = json_decode($mods, true); } catch (\Throwable $th) { $mods = []; }
            }
            if (!is_array($mods)) $mods = [];
            // Remove previous dedicated course-level exam (module with exam and no topics)
            $mods = array_values(array_filter($mods, function($m){
                return !(isset($m['exam']) && is_array($m['exam']) && isset($m['topics']) && empty($m['topics']));
            }));
            $examArr = [
                'title' => $title,
                'description' => $description,
                'timer_minutes' => $timer,
                'passing_score' => $passingScore,
                'questions' => $norm,
            ];
            if ($maxAttempts !== null) {
                $examArr['max_attempts'] = $maxAttempts;
                $examArr['attempt_limit'] = $maxAttempts;
            }
            $hasModules = !empty($mods);
            $hasExamInModules = false;
            foreach ($mods as $m) {
                if (isset($m['exam']) && is_array($m['exam'])) { $hasExamInModules = true; break; }
            }
            if ($hasModules) {
                if (!$hasExamInModules) {
                    // Merge exam into first module
                    $mods[0]['exam'] = $examArr;
                } else {
                    // Update the first existing exam we find
                    foreach ($mods as $idx => $m) {
                        if (isset($m['exam']) && is_array($m['exam'])) {
                            $mods[$idx]['exam'] = $examArr;
                            break;
                        }
                    }
                }
            } else {
                // No modules: create dedicated Module Exam
                $mods[] = [
                    'title' => 'Module Exam',
                    'topics' => [],
                    'exam' => $examArr,
                ];
            }
            $course->modules = $mods;
            $course->save();
            $this->getOrCreateFinalExamAssessment($course, $examArr, $passingScore, $maxAttempts);
        });
        return response()->json(['ok' => true, 'version' => optional($course->fresh()->updated_at)->toISOString()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Course $course)
    {
        $actorRole = strtolower((string) (auth()->user()->role ?? ''));
        $adminRoles = ['admin','super_admin','central_office_admin','regional_office_admin','provincial_office_admin'];
        $tmRoles = ['training_manager','registrar','central_office_training_manager','regional_office_training_manager','provincial_office_training_manager'];
        if (!in_array($actorRole, array_merge($adminRoles, $tmRoles), true)) {
            abort(403);
        }
        // Don't delete image immediately as we are soft deleting
        // if ($course->image_path) {
        //    Storage::disk('public')->delete($course->image_path);
        // }
        
        $course->delete();

        if ($request->boolean('embedded')) {
            session()->flash('success_course', 'Course archived successfully.');
            $target = route('dashboard', ['tab' => 'course-management']);
            $encodedTarget = json_encode($target, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
            return response(
                "<!doctype html><html><body><script>
                    try {
                        if (window.top && window.top !== window) {
                            if (typeof window.top.closeViewCourseModal === 'function') {
                                window.top.closeViewCourseModal();
                            }
                            window.top.location.href = {$encodedTarget};
                        } else {
                            window.location.href = {$encodedTarget};
                        }
                    } catch (e) {
                        window.location.href = {$encodedTarget};
                    }
                </script></body></html>",
                200,
                ['Content-Type' => 'text/html; charset=UTF-8']
            );
        }

        return redirect()->route('dashboard', ['tab' => 'course-management'])
            ->with('success_course', 'Course archived successfully.');
    }

    public function restore(Request $request, $id)
    {
        $actorRole = strtolower((string) (auth()->user()->role ?? ''));
        $adminRoles = ['admin','super_admin','central_office_admin','regional_office_admin','provincial_office_admin'];
        $tmRoles = ['training_manager','central_office_training_manager','regional_office_training_manager','provincial_office_training_manager'];
        if (!in_array($actorRole, array_merge($adminRoles, $tmRoles), true)) {
            abort(403);
        }
        $course = Course::withTrashed()->findOrFail($id);
        $wasTrashed = $course->trashed();

        if ($wasTrashed) {
            $course->restore();
        }

        $course->is_published = true;
        $course->save();

        // Activate coach/trainer pivot so they can enter class after admin approval
        try {
            $coachIds = $course->users()
                ->whereIn('role', ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'])
                ->pluck('users.id')
                ->toArray();
            foreach ($coachIds as $uid) {
                $course->users()->updateExistingPivot($uid, ['status' => 'active']);
            }
        } catch (\Throwable $e) {
            \Log::warning('Failed to activate coach/trainer pivot on restore', [
                'course_id' => $course->id,
                'error' => $e->getMessage(),
            ]);
        }

        \Log::info('Course approved for publication.', [
            'course_id' => $course->id,
            'approved_by' => auth()->id(),
            'was_trashed' => $wasTrashed,
        ]);

        $returnTab = (string) $request->input('return_tab', 'course-management');
        if ($request->boolean('embedded')) {
            session()->flash('success_course', 'Course unarchived successfully.');
            $target = route('dashboard', ['tab' => $returnTab]);
            $encodedTarget = json_encode($target, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
            return response(
                "<!doctype html><html><body><script>
                    try {
                        if (window.top && window.top !== window) {
                            if (typeof window.top.closeViewCourseModal === 'function') {
                                window.top.closeViewCourseModal();
                            }
                            window.top.location.href = {$encodedTarget};
                        } else {
                            window.location.href = {$encodedTarget};
                        }
                    } catch (e) {
                        window.location.href = {$encodedTarget};
                    }
                </script></body></html>",
                200,
                ['Content-Type' => 'text/html; charset=UTF-8']
            );
        }

        if (in_array($actorRole, $tmRoles, true)) {
            return redirect()->route('dashboard', ['portal' => 'tm', 'tab' => $returnTab])
                ->with('success_course', 'Course approved successfully.');
        }
        return redirect()->route('dashboard', ['tab' => $returnTab])
            ->with('success_course', 'Course approved successfully.');
    }

    public function forceDelete(Request $request, $id)
    {
        $actorRole = strtolower((string) (auth()->user()->role ?? ''));
        $adminRoles = ['admin','super_admin','central_office_admin','regional_office_admin','provincial_office_admin'];
        $tmRoles = ['training_manager','registrar','central_office_training_manager','regional_office_training_manager','provincial_office_training_manager'];
        if (!in_array($actorRole, array_merge($adminRoles, $tmRoles), true)) {
            abort(403);
        }
        $course = Course::withTrashed()->findOrFail($id);

        try {
            \DB::transaction(function () use ($course) {
                if (! $course->trashed()) {
                    $course->delete();
                }

                // Detach users
                $course->users()->detach();
                // Remove assessments and grades
                $course->assessments()->each(function ($a) {
                    $a->grades()->delete();
                    $a->delete();
                });
                // Remove materials
                $course->materials()->delete();
                // Remove announcements and comments
                \App\Models\ClassAnnouncement::where('course_id', $course->id)->get()->each(function ($ann) {
                    \App\Models\ClassComment::where('class_announcement_id', $ann->id)->delete();
                    $ann->delete();
                });
                // Remove discussions (including soft-deleted)
                \App\Models\Discussion::withTrashed()->where('course_id', $course->id)->forceDelete();
                // Delete media files
                if ($course->image_path) {
                    Storage::disk('public')->delete($course->image_path);
                }
                if ($course->video_path) {
                    Storage::disk('public')->delete($course->video_path);
                }
                // Permanently delete course
                $course->forceDelete();
            });

            if ($request->boolean('embedded')) {
                session()->flash('success_course', 'Course permanently deleted.');
                $target = route('dashboard', ['tab' => 'course-management']);
                $encodedTarget = json_encode($target, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
                return response(
                    "<!doctype html><html><body><script>
                        try {
                            if (window.top && window.top !== window) {
                                if (typeof window.top.closeViewCourseModal === 'function') {
                                    window.top.closeViewCourseModal();
                                }
                                window.top.location.href = {$encodedTarget};
                            } else {
                                window.location.href = {$encodedTarget};
                            }
                        } catch (e) {
                            window.location.href = {$encodedTarget};
                        }
                    </script></body></html>",
                    200,
                    ['Content-Type' => 'text/html; charset=UTF-8']
                );
            }

            return redirect()->route('dashboard', ['tab' => 'course-management'])
                ->with('success_course', 'Course permanently deleted.');
        } catch (\Throwable $e) {
            \Log::error('Force delete course failed', ['course_id' => $course->id, 'error' => $e->getMessage()]);

            if ($request->boolean('embedded')) {
                session()->flash('error_course', 'Failed to permanently delete course. Some related records may prevent deletion.');
                $target = route('dashboard', ['tab' => 'course-management']);
                $encodedTarget = json_encode($target, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
                return response(
                    "<!doctype html><html><body><script>
                        try {
                            if (window.top && window.top !== window) {
                                if (typeof window.top.closeViewCourseModal === 'function') {
                                    window.top.closeViewCourseModal();
                                }
                                window.top.location.href = {$encodedTarget};
                            } else {
                                window.location.href = {$encodedTarget};
                            }
                        } catch (e) {
                            window.location.href = {$encodedTarget};
                        }
                    </script></body></html>",
                    200,
                    ['Content-Type' => 'text/html; charset=UTF-8']
                );
            }

            return redirect()->route('dashboard', ['tab' => 'course-management'])
                ->with('error_course', 'Failed to permanently delete course. Some related records may prevent deletion.');
        }
    }

    public function updateParticipants(Request $request, Course $course)
    {
        $request->validate([
            'trainer_ids' => 'nullable|array',
            'trainer_ids.*' => 'exists:users,id',
            'trainee_ids' => 'nullable|array',
            'trainee_ids.*' => 'exists:users,id',
        ]);
        $actor = auth()->user();
        $coachRoles = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
        $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
        $managedRoles = [];
        if ($actor) {
            if ($actor->role === 'central_office_training_manager') {
                $managedRoles = ['central_office_coach','central_office_participants'];
            } elseif ($actor->role === 'regional_office_training_manager') {
                $managedRoles = ['regional_office_coach','regional_office_participants'];
            } elseif ($actor->role === 'provincial_office_training_manager') {
                $managedRoles = ['provincial_office_coach','provincial_office_participants'];
            } else {
                $managedRoles = ['coach','trainer','participant','trainee'];
            }
        } else {
            $managedRoles = ['coach','trainer','participant','trainee'];
        }
        $managedCoachRoles = array_values(array_intersect($coachRoles, $managedRoles));
        $managedParticipantRoles = array_values(array_intersect($participantRoles, $managedRoles));
        $coachPermissionNames = ['view_courses_coach', 'view_classes', 'view_communication'];
        $coachPermissionRoleNames = Role::whereIn('name', $managedRoles)
            ->whereHas('permissions', function ($q) use ($coachPermissionNames) {
                $q->whereIn('name', $coachPermissionNames);
            })
            ->pluck('name')
            ->toArray();
        $coachCapableRoles = array_values(array_unique(array_merge($managedCoachRoles, $coachPermissionRoleNames)));

        // 1. Sync Trainers
        $currentTrainerIds = $course->users()->whereIn('role', $coachCapableRoles)->pluck('users.id')->toArray();
        
        $newTrainerIds = $request->trainer_ids
            ? User::whereIn('id', $request->trainer_ids)->whereIn('role', $coachCapableRoles)->pluck('id')->toArray()
            : [];

        $trainersToAttach = array_diff($newTrainerIds, $currentTrainerIds);
        $trainersToDetach = array_diff($currentTrainerIds, $newTrainerIds);

        if (!empty($trainersToAttach)) {
            $course->users()->attach($trainersToAttach, ['status' => 'active']);
            
            // Notify new coaches
            foreach ($trainersToAttach as $trainerId) {
                Notification::create([
                    'user_id' => $trainerId,
                    'title' => 'Course Assignment',
                    'message' => "You have been assigned as a coach for the course: {$course->name}.",
                    'type' => 'course_assignment',
                    'related_id' => $course->id,
                    'link' => route('dashboard'), // Trainers see their courses on dashboard
                ]);
            }
        }
        if (!empty($trainersToDetach)) {
            $course->users()->detach($trainersToDetach);
        }
        $trainersToUpdate = array_intersect($newTrainerIds, $currentTrainerIds);
        foreach ($trainersToUpdate as $id) {
            $pivot = $course->users()->where('user_id', $id)->first()->pivot;
            if (($pivot->status ?? null) !== 'active') {
                $course->users()->updateExistingPivot($id, ['status' => 'active']);
            }
        }

        // 2. Sync Trainees
        $currentTraineeIds = $course->users()->get()->filter(function($user) use ($managedParticipantRoles) {
            return in_array($user->role, $managedParticipantRoles);
        })->pluck('id')->toArray();
        
        $newTraineeIds = $request->trainee_ids ? User::whereIn('id', $request->trainee_ids)->whereIn('role', $managedParticipantRoles)->pluck('id')->toArray() : [];

        $traineesToAttach = array_diff($newTraineeIds, $currentTraineeIds);
        $traineesToDetach = array_diff($currentTraineeIds, $newTraineeIds);
        $traineesToActivate = array_filter($newTraineeIds, function ($id) use ($course) {
            $pivot = $course->users()->where('user_id', $id)->first()?->pivot;
            return $pivot && ($pivot->status ?? null) !== 'active';
        });

        if ((!empty($traineesToAttach) || !empty($traineesToActivate)) && !$course->isEnrollable()) {
            return redirect()->back()
                ->with('error_enroll', 'Participants cannot be enrolled until the course is published and the admin expiration date plus registrar enrollment dates are complete and open.');
        }

        if (!empty($traineesToAttach)) {
            // Attach new ones as active
            $payload = [];
            foreach ($traineesToAttach as $traineeId) {
                $payload[$traineeId] = [
                    'status' => 'active',
                    'current_module' => 1,
                    'progress_percentage' => 0,
                ];
            }
            $course->users()->attach($payload);
            
            // Notify new participants
            foreach ($traineesToAttach as $traineeId) {
                Notification::create([
                    'user_id' => $traineeId,
                    'title' => 'Course Enrollment',
                    'message' => "You have been enrolled as a participant in the course: {$course->name}.",
                    'type' => 'enrollment_approved',
                    'related_id' => $course->id,
                    'link' => route('dashboard'), // Trainees see their courses on dashboard
                ]);
            }
        }

        // Update existing ones to active (specifically those moving from pending to active)
        $traineesToUpdate = array_intersect($newTraineeIds, $currentTraineeIds);
        foreach ($traineesToUpdate as $id) {
            // Check if status was pending before updating (optional optimization but good for correct notification context)
            $pivot = $course->users()->where('user_id', $id)->first()->pivot;
            if ($pivot->status !== 'active') {
                $course->users()->updateExistingPivot($id, ['status' => 'active']);
                
                // Notify updated participants
                Notification::create([
                    'user_id' => $id,
                    'title' => 'Course Enrollment Approved',
                    'message' => "Your request to join the course {$course->name} has been approved.",
                    'type' => 'enrollment_approved',
                    'related_id' => $course->id,
                    'link' => route('dashboard'),
                ]);
            }
        }

        if (!empty($traineesToDetach)) {
            $course->users()->detach($traineesToDetach);
        }

        return redirect()->route('dashboard', ['tab' => 'trainer-trainee-management'])
            ->with('success_enroll', 'Participants updated successfully.');
    }

    public function enrollFree(Course $course)
    {
        if ($course->course_type !== 'free') {
            return redirect()->back()->with('error', 'This course is not available for free enrollment.');
        }

        if (!$course->isEnrollable()) {
            return redirect()->back()->with('error', 'Enrollment for this course is currently closed.');
        }

        $userId = auth()->id();
        if ($course->users()->where('user_id', $userId)->exists()) {
            return redirect()->back()->with('info', 'You are already enrolled in this course.');
        }

        $course->users()->attach($userId, [
            'status' => 'active',
            'current_module' => 1,
            'progress_percentage' => 0,
        ]);

        return redirect()->route('trainee.courses.show', $course)->with('success', 'You have successfully enrolled in the course.');
    }

    public function enrollControlled(Request $request, Course $course)
    {
        $request->validate([
            'access_code' => 'required|string',
        ]);

        if ($course->course_type !== 'controlled') {
            return response()->json(['message' => 'This course does not require an access code.'], 400);
        }

        if ($course->access_code !== $request->access_code) {
            return response()->json(['message' => 'Invalid code, please try again.'], 422);
        }

        if (!$course->isEnrollable()) {
            return response()->json(['message' => 'Enrollment for this course is currently closed.'], 403);
        }

        $userId = auth()->id();
        if ($course->users()->where('user_id', $userId)->exists()) {
            return response()->json(['message' => 'You are already enrolled in this course.'], 200);
        }

        $course->users()->attach($userId, [
            'status' => 'active',
            'current_module' => 1,
            'progress_percentage' => 0,
        ]);

        return response()->json(['message' => 'Success! You have been enrolled.', 'redirect' => route('trainee.courses.show', $course)]);
    }

    public function enrollUser(Request $request, Course $course)
    {
        $request->validate([
            'trainer_id' => 'nullable|exists:users,id',
            'trainee_ids' => 'nullable|array',
            'trainee_ids.*' => 'exists:users,id',
        ]);
        $actor = auth()->user();
        $coachRoles = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
        $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
        $managedRoles = [];
        if ($actor) {
            if ($actor->role === 'central_office_training_manager') {
                $managedRoles = ['central_office_coach','central_office_participants'];
            } elseif ($actor->role === 'regional_office_training_manager') {
                $managedRoles = ['regional_office_coach','regional_office_participants'];
            } elseif ($actor->role === 'provincial_office_training_manager') {
                $managedRoles = ['provincial_office_coach','provincial_office_participants'];
            } else {
                $managedRoles = ['coach','trainer','participant','trainee'];
            }
        } else {
            $managedRoles = ['coach','trainer','participant','trainee'];
        }
        $managedCoachRoles = array_values(array_intersect($coachRoles, $managedRoles));
        $managedParticipantRoles = array_values(array_intersect($participantRoles, $managedRoles));
        $coachPermissionNames = ['view_courses_coach', 'view_classes', 'view_communication'];
        $coachPermissionRoleNames = Role::whereIn('name', $managedRoles)
            ->whereHas('permissions', function ($q) use ($coachPermissionNames) {
                $q->whereIn('name', $coachPermissionNames);
            })
            ->pluck('name')
            ->toArray();
        $coachCapableRoles = array_values(array_unique(array_merge($managedCoachRoles, $coachPermissionRoleNames)));

        $count = 0;

        // Handle Coach
        if ($request->filled('trainer_id')) {
            $coachId = User::where('id', $request->trainer_id)->whereIn('role', $coachCapableRoles)->value('id');
            if ($coachId && !$course->users()->where('user_id', $coachId)->exists()) {
                $course->users()->attach($coachId, ['status' => 'active']);
                $count++;

                // Notify Coach
                Notification::create([
                    'user_id' => $coachId,
                    'title' => 'Course Assignment',
                    'message' => "You have been assigned as a coach for the course: {$course->name}.",
                    'type' => 'course_assignment',
                    'related_id' => $course->id,
                    'link' => route('dashboard'),
                ]);
            }
        }

        // Handle Trainees
        if ($request->filled('trainee_ids')) {
            if (!$course->isEnrollable()) {
                return redirect()->back()
                    ->with('error_enroll', 'Participants cannot be enrolled until the course is published and the admin expiration date plus registrar enrollment dates are complete and open.');
            }

            $validTrainees = User::whereIn('id', $request->trainee_ids)->whereIn('role', $managedParticipantRoles)->pluck('id')->toArray();
            foreach ($validTrainees as $id) {
                if (!$course->users()->where('user_id', $id)->exists()) {
                    $course->users()->attach($id, [
                        'status' => 'active',
                        'current_module' => 1,
                        'progress_percentage' => 0,
                    ]);
                    $count++;

                    // Notify Trainee
                    Notification::create([
                        'user_id' => $id,
                        'title' => 'Course Enrollment',
                        'message' => "You have been enrolled in the course: {$course->name}.",
                        'type' => 'enrollment_approved',
                        'related_id' => $course->id,
                        'link' => route('dashboard'),
                    ]);
                }
            }
        }

        if ($count > 0) {
            return redirect()->back()
                ->with('success_enroll', $count . ' participant(s) enrolled successfully.');
        }

        return redirect()->back()
            ->with('info', 'No new participants were added.');
    }

    public function enrollManual(Request $request, Course $course)
    {
        $request->validate([
            'account_id' => 'required|string',
            'name' => 'required|string',
        ]);

        $actor = auth()->user();
        $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
        
        $managedRoles = [];
        if ($actor->role === 'central_office_training_manager') {
            $managedRoles = ['central_office_participants'];
        } elseif ($actor->role === 'regional_office_training_manager') {
            $managedRoles = ['regional_office_participants'];
        } elseif ($actor->role === 'provincial_office_training_manager') {
            $managedRoles = ['provincial_office_participants'];
        } else {
            $managedRoles = ['participant','trainee'];
        }

        $user = User::where('account_id', $request->account_id)
            ->where('name', 'like', '%' . $request->name . '%')
            ->whereIn('role', $managedRoles)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error_enroll', 'Participant not found or unauthorized for your office level.');
        }

        if ($course->users()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error_enroll', 'Participant is already enrolled in this course.');
        }

        if (!$course->isEnrollable()) {
            return redirect()->back()
                ->with('error_enroll', 'Participants cannot be enrolled until the course is published and the admin expiration date plus registrar enrollment dates are complete and open.');
        }

        $course->users()->attach($user->id, [
            'status' => 'active',
            'current_module' => 1,
            'progress_percentage' => 0,
        ]);

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Manual Enrollment',
            'message' => "You have been manually enrolled in the course: {$course->name}.",
            'type' => 'enrollment_approved',
            'related_id' => $course->id,
            'link' => route('dashboard'),
        ]);

        return redirect()->back()->with('success_enroll', "{$user->name} has been enrolled successfully.");
    }

    public function detachUser(Course $course, User $user)
    {
        $course->users()->detach($user->id);
        return redirect()->route('dashboard', ['tab' => 'trainer-trainee-management'])
            ->with('success_detach', 'User removed from course successfully.');
    }

    public function join(Course $course)
    {
        $user = auth()->user();

        if (!$course->can_enroll) {
            return redirect()->route('dashboard')->with('error', 'Enrollment is not yet available for this course.');
        }

        // Check if already enrolled or pending
        if ($course->users()->where('user_id', $user->id)->exists()) {
            return redirect()->route('dashboard')->with('error', 'You have already requested to join or are enrolled in this course.');
        }

        // Attach with active status immediately (automatic enrollment)
        $course->users()->attach($user->id, [
            'status' => 'active',
            'current_module' => 1,
            'progress_percentage' => 0,
        ]);

        // Notify user of immediate enrollment
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Course Enrolled',
            'message' => "You have been automatically enrolled in the course: {$course->name}.",
            'type' => 'enrollment_approved',
            'related_id' => $course->id,
            'link' => route('dashboard'),
        ]);

        return redirect()->route('dashboard')->with('success_join', 'You have been successfully enrolled in the course.');
    }

    public function notifyIncompleteParticipants(Request $request, Course $course)
    {
        $userId = $request->input('user_id');
        $participantRoles = ['participant', 'trainee', 'central_office_participants', 'regional_office_participants', 'provincial_office_participants'];
        
        $query = $course->users()->whereIn('role', $participantRoles)->wherePivot('status', 'active');
        
        if ($userId) {
            $query->where('users.id', $userId);
        }
        
        $participants = $query->get();

        $modules = is_array($course->modules) ? $course->modules : [];

        $sentCount = 0;
        foreach ($participants as $participant) {
            $incompleteActivities = [];

            // Check module progress
            foreach ($modules as $moduleIndex => $module) {
                $totalSubs = 0;
                if (isset($module['topics']) && is_array($module['topics'])) {
                    foreach ($module['topics'] as $topic) {
                        if (isset($topic['subtopics']) && is_array($topic['subtopics'])) {
                            $totalSubs += count($topic['subtopics']);
                        }
                    }
                }

                if ($totalSubs > 0) {
                    $completedSubs = \App\Models\ReflectionResponse::where('user_id', $participant->id)
                        ->where('course_id', $course->id)
                        ->where('module_index', $moduleIndex)
                        ->count();

                    if ($completedSubs < $totalSubs) {
                        $incompleteActivities[] = (object)['title' => $module['title']];
                    }
                }

                // Check exam progress
                if (isset($module['exam'])) {
                    $submissionPath = storage_path('app/exam_submissions/course_' . $course->id . '/mi_' . $moduleIndex . '_u_' . $participant->id . '.json');

                    if (!file_exists($submissionPath)) {
                        $incompleteActivities[] = (object)['title' => $module['exam']['title']];
                    }
                }
            }

            if (!empty($incompleteActivities)) {
                Mail::to($participant->email)->send(new IncompleteActivityReminder($course, $participant, $incompleteActivities));
                $sentCount++;
            }
        }

        $message = $sentCount > 0 
            ? "Notifications sent successfully to {$sentCount} participant(s)." 
            : "No incomplete activities found. No notifications sent.";

        return response()->json(['message' => $message]);
    }

    /**
     * Clone an existing course to a new academic year.
     */
    public function clone(Request $request)
    {
        $actorRole = strtolower((string) (auth()->user()->role ?? ''));
        $adminRoles = ['admin','super_admin','central_office_admin','regional_office_admin','provincial_office_admin'];
        $tmRoles = ['training_manager','registrar','central_office_training_manager','regional_office_training_manager','provincial_office_training_manager'];
        if (!in_array($actorRole, array_merge($adminRoles, $tmRoles), true)) {
            abort(403);
        }
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'target_academic_year_id' => 'required|exists:academic_years,id',
            'copy_modules' => 'nullable',
            'copy_lessons' => 'nullable',
            'copy_assessments' => 'nullable',
            'set_active' => 'nullable',
        ]);

        $originalCourse = Course::findOrFail($request->course_id);
        $targetYearId = $request->target_academic_year_id;

        // Check if course already exists in target academic year
        $existingCourse = Course::where('name', $originalCourse->name)
            ->where('academic_year_id', $targetYearId)
            ->first();

        if ($existingCourse) {
            return redirect()->back()->with('error_course', 'This course already exists in the selected academic year.');
        }

        \DB::beginTransaction();
        try {
            // 1. Clone the Course record
            $newCourse = $originalCourse->replicate();
            $newCourse->academic_year_id = $targetYearId;
            $newCourse->is_published = $request->has('set_active') ? true : false;
            
            // If we don't copy modules, set modules to empty array
            if (!$request->has('copy_modules')) {
                $newCourse->modules = [];
            }
            
            $newCourse->save();

            // 2. Clone Materials (Lessons/Content)
            if ($request->has('copy_lessons')) {
                foreach ($originalCourse->materials as $material) {
                    $newMaterial = $material->replicate();
                    $newMaterial->course_id = $newCourse->id;
                    $newMaterial->save();
                }
            }

            // 3. Clone Assessments
            if ($request->has('copy_assessments')) {
                foreach ($originalCourse->assessments as $assessment) {
                    $newAssessment = $assessment->replicate();
                    $newAssessment->course_id = $newCourse->id;
                    $newAssessment->save();
                }
            }

            // 4. Copy Users relationship (Maintain creator/trainer)
            if ($originalCourse->trainer_id) {
                $newCourse->users()->attach($originalCourse->trainer_id, ['status' => 'active']);
            }

            \DB::commit();

            $targetYear = AcademicYear::find($targetYearId);
            $yearLabel = $targetYear->year_start . ' - ' . $targetYear->year_end;

            return redirect()->route('dashboard', ['tab' => 'course-library', 'academic_year_id' => $targetYearId])
                ->with('success_course', "Course successfully cloned to {$yearLabel}");

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Course cloning failed: ' . $e->getMessage());
            return redirect()->back()->with('error_course', 'An error occurred while cloning the course: ' . $e->getMessage());
        }
    }
}
