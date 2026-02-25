<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use Tests\TestCase;

class DiscussionDeletionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh');
    }

    protected function createUser(string $role = 'trainee'): User
    {
        return User::create([
            'name' => 'User '.uniqid(),
            'email' => uniqid().'@example.com',
            'password' => bcrypt('password'),
            'role' => $role,
            'status' => 'active',
        ]);
    }

    protected function createCourse(): Course
    {
        return Course::create([
            'name' => 'Test Course '.uniqid(),
            'description' => 'Desc',
            'video_url' => 'https://example.com/v.mp4',
        ]);
    }

    public function test_author_can_delete_own_discussion_json(): void
    {
        $author = $this->createUser('trainee');
        $course = $this->createCourse();
        $discussion = Discussion::create([
            'course_id' => $course->id,
            'user_id' => $author->id,
            'title' => 'My Topic',
            'body' => 'Body',
        ]);

        $this->actingAs($author);
        $res = $this->withHeader('Accept','application/json')
            ->delete(route('discussions.destroy', $discussion));
        $res->assertStatus(200);
        $this->assertSoftDeleted('discussions', ['id' => $discussion->id]);
    }

    public function test_user_cannot_delete_others_discussion(): void
    {
        $author = $this->createUser('trainee');
        $other = $this->createUser('trainee');
        $course = $this->createCourse();
        $discussion = Discussion::create([
            'course_id' => $course->id,
            'user_id' => $author->id,
            'title' => 'Not yours',
            'body' => 'Body',
        ]);

        $this->actingAs($other);
        $res = $this->withHeader('Accept','application/json')
            ->delete(route('discussions.destroy', $discussion));
        $res->assertStatus(403);
        $this->assertDatabaseHas('discussions', ['id' => $discussion->id]);
    }

    public function test_author_can_delete_own_reply_json(): void
    {
        $author = $this->createUser();
        $course = $this->createCourse();
        $discussion = Discussion::create([
            'course_id' => $course->id,
            'user_id' => $author->id,
            'title' => 'Topic',
            'body' => 'Body',
        ]);
        $reply = DiscussionReply::create([
            'discussion_id' => $discussion->id,
            'user_id' => $author->id,
            'body' => 'Reply body',
        ]);
        $this->actingAs($author);
        $res = $this->withHeader('Accept','application/json')
            ->delete(route('discussions.replies.destroy', $reply));
        $res->assertStatus(200);
        $this->assertSoftDeleted('discussion_replies', ['id' => $reply->id]);
    }

    public function test_user_cannot_delete_others_reply(): void
    {
        $author = $this->createUser();
        $other = $this->createUser();
        $course = $this->createCourse();
        $discussion = Discussion::create([
            'course_id' => $course->id,
            'user_id' => $author->id,
            'title' => 'Topic',
            'body' => 'Body',
        ]);
        $reply = DiscussionReply::create([
            'discussion_id' => $discussion->id,
            'user_id' => $author->id,
            'body' => 'Reply body',
        ]);
        $this->actingAs($other);
        $res = $this->withHeader('Accept','application/json')
            ->delete(route('discussions.replies.destroy', $reply));
        $res->assertStatus(403);
        $this->assertDatabaseHas('discussion_replies', ['id' => $reply->id]);
    }

    public function test_trainer_cannot_delete_others_discussion(): void
    {
        $author = $this->createUser('trainee');
        $trainer = $this->createUser('trainer');
        $course = $this->createCourse();
        $discussion = Discussion::create([
            'course_id' => $course->id,
            'user_id' => $author->id,
            'title' => 'Topic',
            'body' => 'Body',
        ]);
        $this->actingAs($trainer);
        $res = $this->withHeader('Accept','application/json')
            ->delete(route('discussions.destroy', $discussion));
        $res->assertStatus(403);
    }

    public function test_admin_cannot_delete_others_reply(): void
    {
        $author = $this->createUser('trainee');
        $admin = $this->createUser('admin');
        $course = $this->createCourse();
        $discussion = Discussion::create([
            'course_id' => $course->id,
            'user_id' => $author->id,
            'title' => 'Topic',
            'body' => 'Body',
        ]);
        $reply = DiscussionReply::create([
            'discussion_id' => $discussion->id,
            'user_id' => $author->id,
            'body' => 'Reply body',
        ]);
        $this->actingAs($admin);
        $res = $this->withHeader('Accept','application/json')
            ->delete(route('discussions.replies.destroy', $reply));
        $res->assertStatus(403);
    }
}
