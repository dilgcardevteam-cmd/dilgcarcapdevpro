<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseSelfEnrollmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_free_courses_can_be_joined_without_an_access_code(): void
    {
        $user = User::factory()->create([
            'role' => 'trainee',
            'profile_completed' => true,
            'status' => 'active',
        ]);
        $course = $this->publishedEnrollableCourse([
            'course_type' => 'free',
            'access_code' => null,
        ]);

        $this->actingAs($user)
            ->post(route('courses.join', $course))
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('success_join');

        $this->assertDatabaseHas('course_user', [
            'course_id' => $course->id,
            'user_id' => $user->id,
            'status' => 'active',
        ]);
    }

    public function test_controlled_courses_cannot_be_joined_through_the_free_join_route(): void
    {
        $user = User::factory()->create([
            'role' => 'trainee',
            'profile_completed' => true,
            'status' => 'active',
        ]);
        $course = $this->publishedEnrollableCourse([
            'course_type' => 'controlled',
            'access_code' => 'ACCESS42',
        ]);

        $this->actingAs($user)
            ->post(route('courses.join', $course))
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('error', 'This is a controlled course. Please enter the access code to enroll.');

        $this->assertDatabaseMissing('course_user', [
            'course_id' => $course->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_controlled_courses_enroll_with_the_saved_access_code(): void
    {
        $user = User::factory()->create([
            'role' => 'trainee',
            'profile_completed' => true,
            'status' => 'active',
        ]);
        $course = $this->publishedEnrollableCourse([
            'course_type' => 'controlled',
            'access_code' => 'ACCESS42',
        ]);

        $this->actingAs($user)
            ->postJson(route('courses.enroll.controlled', $course), [
                'access_code' => 'access42',
            ])
            ->assertOk()
            ->assertJson([
                'message' => 'Success! You have been enrolled.',
            ]);

        $this->assertDatabaseHas('course_user', [
            'course_id' => $course->id,
            'user_id' => $user->id,
            'status' => 'active',
        ]);
    }

    private function publishedEnrollableCourse(array $attributes = []): Course
    {
        return Course::factory()->create(array_merge([
            'is_published' => true,
            'course_expiration_date' => now()->addMonth()->toDateString(),
            'enrollment_start_date' => now()->subDay()->toDateString(),
            'enrollment_end_date' => now()->addWeek()->toDateString(),
        ], $attributes));
    }
}
