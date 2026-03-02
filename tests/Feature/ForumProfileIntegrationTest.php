<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ForumProfileIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        Storage::fake('public');
    }

    public function test_course_forum_lists_avatar_and_profile_link(): void
    {
        $trainee = User::factory()->create(['role'=>'trainee']);
        $course = Course::create(['name'=>'Test Course','description'=>'Desc']);
        $course->users()->attach($trainee->id, ['status'=>'active']);

        // Set avatar
        $trainee->setAvatarFromDataUrl('data:image/png;base64,'.base64_encode('x'));
        $trainee->save();

        $discussion = Discussion::create([
            'course_id' => $course->id,
            'user_id' => $trainee->id,
            'title' => 'Hello',
            'body' => 'World',
        ]);

        $this->actingAs($trainee);
        $resp = $this->get(route('trainee.courses.show', $course));
        $resp->assertStatus(200);
        $resp->assertSee($trainee->name, false);
        $resp->assertSee(route('users.profile', $trainee), false);
        $resp->assertSee($trainee->avatar_url, false);
    }

    public function test_discussion_show_renders_comment_avatars_and_profile_links(): void
    {
        $user = User::factory()->create(['role'=>'trainee']);
        $course = Course::create(['name'=>'Test Course','description'=>'Desc']);
        $course->users()->attach($user->id, ['status'=>'active']);
        $user->setAvatarFromDataUrl('data:image/jpeg;base64,'.base64_encode('img'));
        $user->save();

        $discussion = Discussion::create([
            'course_id' => $course->id,
            'user_id' => $user->id,
            'title' => 'Topic',
            'body' => 'Text',
        ]);
        $reply = DiscussionReply::create([
            'discussion_id' => $discussion->id,
            'user_id' => $user->id,
            'body' => 'Comment',
        ]);
        DiscussionReply::create([
            'discussion_id' => $discussion->id,
            'user_id' => $user->id,
            'body' => 'Child',
            'parent_id' => $reply->id,
        ]);

        $this->actingAs($user);
        $resp = $this->get(route('discussions.show', ['discussion'=>$discussion]));
        $resp->assertStatus(200);
        $resp->assertSee(route('users.profile', $user), false);
        $resp->assertSee($user->avatar_url, false);
    }
}
