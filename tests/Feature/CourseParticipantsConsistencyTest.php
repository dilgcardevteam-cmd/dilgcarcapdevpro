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
        $course = Course::factory()->create();
        $coach = User::factory()->create(['role' => 'coach']);
        $trainer = User::factory()->create(['role' => 'trainer']);
        $trainee = User::factory()->create(['role' => 'trainee']);
        $other = User::factory()->create(['role' => 'participant']);

        $course->users()->attach($coach->id, ['status' => 'active']);
        $course->users()->attach($trainer->id, ['status' => 'active']);
        $course->users()->attach($trainee->id, ['status' => 'active']);
        $course->users()->attach($other->id, ['status' => 'active']);

        $this->actingAs($trainee);
        $resp = $this->get(route('trainee.courses.show', $course));
        $resp->assertStatus(200);
        $resp->assertViewHas('coaches', function ($coaches) use ($coach, $trainer) {
            $ids = collect($coaches)->pluck('id')->all();
            return in_array($coach->id, $ids) && in_array($trainer->id, $ids);
        });
        $resp->assertViewHas('classmates', function ($classmates) use ($other, $trainee) {
            $ids = collect($classmates)->pluck('id')->all();
            return in_array($other->id, $ids) && in_array($trainee->id, $ids);
        });
    }

    /** @test */
    public function trainer_landing_passes_coaches_and_classmates()
    {
        $course = Course::factory()->create();
        $trainer = User::factory()->create(['role' => 'trainer']);
        $trainee = User::factory()->create(['role' => 'trainee']);

        $course->users()->attach($trainer->id, ['status' => 'active']);
        $course->users()->attach($trainee->id, ['status' => 'active']);

        $this->actingAs($trainer);
        $resp = $this->get(route('trainer.courses.enter', $course));
        $resp->assertStatus(200);
        $resp->assertViewHas('coaches', function ($coaches) use ($trainer) {
            $ids = collect($coaches)->pluck('id')->all();
            return in_array($trainer->id, $ids);
        });
        $resp->assertViewHas('classmates', function ($classmates) use ($trainee) {
            $ids = collect($classmates)->pluck('id')->all();
            return in_array($trainee->id, $ids);
        });
    }
}
