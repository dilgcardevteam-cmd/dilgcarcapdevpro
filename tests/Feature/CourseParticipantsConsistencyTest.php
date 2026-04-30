<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Course;

class CourseParticipantsConsistencyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function trainee_show_passes_coaches_and_classmates()
    {
        $course = Course::factory()->create(['is_published' => true]);
        $coach = User::factory()->create(['role' => 'coach']);
        $trainer = User::factory()->create(['role' => 'trainer']);
        $trainee = User::factory()->create(['role' => 'trainee', 'profile_completed' => true, 'status' => 'active']);
        $other = User::factory()->create(['role' => 'participant', 'profile_completed' => true, 'status' => 'active']);

        $course->users()->attach($coach->id, ['status' => 'active']);
        $course->users()->attach($trainer->id, ['status' => 'active']);
        $course->users()->attach($trainee->id, ['status' => 'active']);
        $course->users()->attach($other->id, ['status' => 'active']);

        $this->actingAs($trainee);
        $resp = $this->get(route('trainee.courses.show', $course));
        $resp->assertStatus(200);
        $resp->assertSee($coach->name);
        $resp->assertSee($trainer->name);
        $resp->assertSee($other->name);
        $resp->assertSee($trainee->name);
    }

    /** @test */
    public function trainer_landing_passes_coaches_and_classmates()
    {
        $course = Course::factory()->create();
        $trainer = User::factory()->create(['role' => 'trainer', 'profile_completed' => true, 'status' => 'active']);
        $trainee = User::factory()->create(['role' => 'trainee', 'profile_completed' => true, 'status' => 'active']);

        $course->users()->attach($trainer->id, ['status' => 'active']);
        $course->users()->attach($trainee->id, ['status' => 'active']);

        $this->actingAs($trainer);
        $resp = $this->get(route('trainer.courses.enter', $course));
        $resp->assertStatus(200);
        $resp->assertSee($trainer->name);
        $resp->assertSee($trainee->name);
    }
}
