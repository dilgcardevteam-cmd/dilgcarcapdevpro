<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\Discussion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiscussionDeletionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    public function test_owner_can_delete_discussion_with_json_accepts(): void
    {
        $owner = User::factory()->create(['role' => 'trainee']);
        $course = Course::create(['name' => 'Room 101', 'description' => 'x']);
        $discussion = Discussion::create([
            'course_id' => $course->id,
            'user_id' => $owner->id,
            'title' => 't',
            'body' => 'body text here',
        ]);

        $res = $this->actingAs($owner)
            ->withHeaders(['Accept' => 'application/json'])
            ->delete(route('discussions.destroy', $discussion));

        $res->assertOk()->assertJson(['ok' => true]);
        $this->assertSoftDeleted('discussions', ['id' => $discussion->id]);
    }

    public function test_non_owner_gets_403_on_delete(): void
    {
        $owner = User::factory()->create(['role' => 'trainee']);
        $intruder = User::factory()->create(['role' => 'trainee']);
        $course = Course::create(['name' => 'Room 101', 'description' => 'x']);
        $discussion = Discussion::create([
            'course_id' => $course->id,
            'user_id' => $owner->id,
            'title' => 't',
            'body' => 'body text here',
        ]);

        $res = $this->actingAs($intruder)
            ->withHeaders(['Accept' => 'application/json'])
            ->delete(route('discussions.destroy', $discussion));

        $res->assertStatus(403)->assertJson(['ok' => false]);
        $this->assertDatabaseHas('discussions', ['id' => $discussion->id, 'deleted_at' => null]);
    }
}

