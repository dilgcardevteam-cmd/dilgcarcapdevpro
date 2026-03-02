<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AvatarSingleSourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        Storage::fake('public');
    }

    public function test_single_source_of_truth_column_exists(): void
    {
        $columns = \Schema::getColumnListing('users');
        $this->assertTrue(in_array('profile_picture', $columns));
        foreach (['avatar','profile_image','photo','picture_url'] as $legacy) {
            $this->assertFalse(in_array($legacy, $columns));
        }
    }

    public function test_setting_avatar_replaces_previous_and_propagates_url(): void
    {
        $user = User::factory()->create();
        Storage::disk('public')->put('profile_pictures/old.jpg', 'x');
        $user->profile_picture = 'profile_pictures/old.jpg';
        $user->save();

        $user->setAvatarFromDataUrl('data:image/jpeg;base64,'.base64_encode('newdata'));
        $user->save();

        $this->assertNotEquals('profile_pictures/old.jpg', $user->profile_picture);
        Storage::disk('public')->assertMissing('profile_pictures/old.jpg');
        Storage::disk('public')->assertExists($user->profile_picture);

        $url = $user->avatar_url;
        $this->assertStringContainsString('storage/', $url);
        $this->assertStringContainsString('?v=', $url);
    }
}

