<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'video_url' => fake()->url(),
            'image_path' => null,
            'subject_area' => 'Public Administrative & Financial',
            'modules' => [],
            'video_path' => null,
            'is_published' => false,
            'enrollment_start_date' => null,
            'enrollment_end_date' => null,
            'course_expiration_date' => null,
            'trainer_id' => null,
            'submitted_by_user_id' => null,
            'start_date' => null,
            'end_date' => null,
            'certification_id' => null,
            'course_type' => 'free',
            'access_code' => null,
            'academic_year_id' => null,
        ];
    }
}
