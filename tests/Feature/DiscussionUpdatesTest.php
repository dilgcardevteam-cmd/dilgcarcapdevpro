<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\Discussion;
use Tests\TestCase;

class DiscussionUpdatesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh');
    }

    protected function user(): User
    {
        return User::create([
            'name' => 'User '.uniqid(),
            'email' => uniqid().'@example.com',
            'password' => bcrypt('password'),
            'role' => 'trainee',
            'status' => 'active',
        ]);
    }

    protected function course(): Course
    {
        return Course::create([
            'name' => 'C '.uniqid(),
            'description' => 'D',
            'video_url' => 'https://example.com/v.mp4',
        ]);
    }

    public function test_updates_endpoint_lists_soft_deleted_discussion(): void
    {
        $u = $this->user();
        $c = $this->course();
        $d = Discussion::create([
            'course_id' => $c->id,
            'user_id' => $u->id,
            'title' => 'T',
            'body' => 'B',
        ]);
        $this->actingAs($u);
        $res = $this->delete(route('discussions.destroy', $d), [], ['Accept'=>'application/json']);
        $res->assertStatus(200);

        $updates = $this->getJson(route('courses.discussions.updates', $c))->json();
        $this->assertContains($d->id, $updates['discussions_soft_deleted'] ?? []);
    }
}
