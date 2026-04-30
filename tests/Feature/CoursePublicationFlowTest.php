<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoursePublicationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_prefers_creator_for_coach_display_name(): void
    {
        $creator = User::factory()->create([
            'role' => 'central_office_coach',
            'region' => 'DILG Central Office',
            'status' => 'active',
        ]);
        $otherCoach = User::factory()->create([
            'role' => 'central_office_coach',
            'region' => 'DILG Central Office',
            'status' => 'active',
        ]);

        $course = Course::factory()->create([
            'trainer_id' => $creator->id,
            'submitted_by_user_id' => $creator->id,
        ]);

        $course->users()->attach($otherCoach->id, ['status' => 'active']);
        $course->refresh()->load(['trainer', 'submittedBy']);

        $this->assertSame($creator->name, $course->coach_display_name);
    }

    public function test_tm_approval_keeps_pending_course_unpublished_until_schedule_publish(): void
    {
        $tm = User::factory()->create([
            'role' => 'central_office_training_manager',
            'region' => 'DILG Central Office',
            'status' => 'active',
        ]);
        $coach = User::factory()->create([
            'role' => 'central_office_coach',
            'region' => 'DILG Central Office',
            'status' => 'active',
        ]);

        $course = Course::factory()->create([
            'trainer_id' => $coach->id,
            'submitted_by_user_id' => $coach->id,
            'course_expiration_date' => now()->addMonth()->toDateString(),
            'is_published' => false,
        ]);
        $course->delete();

        $this->actingAs($tm)
            ->post(route('courses.restore', ['id' => $course->id]), [
                'return_tab' => 'trainer-trainee-management',
            ]);

        $course->refresh();
        $this->assertFalse($course->trashed());
        $this->assertFalse($course->is_published);

        $this->actingAs($tm)
            ->post(route('courses.publish', $course), [
                'published' => 1,
                'trainer_id' => $coach->id,
                'enrollment_start_date' => now()->toDateString(),
                'enrollment_end_date' => now()->addDays(7)->toDateString(),
            ]);

        $course->refresh();
        $this->assertTrue($course->is_published);
        $this->assertSame($coach->id, $course->trainer_id);
        $this->assertSame(now()->toDateString(), optional($course->enrollment_start_date)->toDateString());
    }
}
