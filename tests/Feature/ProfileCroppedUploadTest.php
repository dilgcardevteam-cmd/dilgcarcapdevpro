<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileCroppedUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        Storage::fake('public');
    }

    protected function login(): User
    {
        $user = User::factory()->create(['role' => 'trainee']);
        $this->actingAs($user);
        return $user;
    }

    public function test_accepts_cropped_base64_and_saves_file(): void
    {
        $user = $this->login();
        $dataUrl = 'data:image/jpeg;base64,' . base64_encode($this->tinyJpeg());

        $res = $this->put(route('profile.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'profile_picture_cropped' => $dataUrl,
        ]);

        $res->assertRedirect(route('dashboard', ['tab' => 'profile-section']));
        $user->refresh();
        $this->assertNotNull($user->profile_picture);
        Storage::disk('public')->assertExists($user->profile_picture);
    }

    public function test_fallback_to_file_upload_still_works(): void
    {
        $user = $this->login();

        $file = UploadedFile::fake()->create('avatar.jpg', 12, 'image/jpeg');
        $res = $this->put(route('profile.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'profile_picture' => $file,
        ]);
        $res->assertRedirect(route('dashboard', ['tab' => 'profile-section']));
        $user->refresh();
        $this->assertNotNull($user->profile_picture);
        Storage::disk('public')->assertExists($user->profile_picture);
    }

    public function test_png_base64_sets_png_extension(): void
    {
        $user = $this->login();
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAASsJTYQAAAAASUVORK5CYII=');
        $dataUrl = 'data:image/png;base64,' . base64_encode($png);

        $res = $this->put(route('profile.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'profile_picture_cropped' => $dataUrl,
        ]);
        $res->assertRedirect(route('dashboard', ['tab' => 'profile-section']));

        $user->refresh();
        $this->assertStringEndsWith('.png', $user->profile_picture);
        Storage::disk('public')->assertExists($user->profile_picture);
    }

    private function tinyJpeg(): string
    {
        // Minimal 1x1 JPEG, baseline
        return base64_decode('/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxISEhUQFRIVFhUVFRUVFRcXFRUVFRUWFxUVFRUYHSggGBolGxUVITEhJSkrLi4uFx8zODMsNygtLisBCgoKDg0OGxAQGy0lHyUtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLf/AABEIAAEAAQMBEQACEQEDEQH/xAAXAAEAAwAAAAAAAAAAAAAAAAABAgME/8QAFxABAQEBAAAAAAAAAAAAAAAAAQARAv/aAAwDAQACEAMQAAABfEAAAAA//8QAFxEAAwEAAAAAAAAAAAAAAAAAAAECEf/aAAgBAQABBQJdZ//EABYRAAMAAAAAAAAAAAAAAAAAAAABEv/aAAgBAwEBPwFf/8QAFhEAAwAAAAAAAAAAAAAAAAAAAAER/9oACAECAQE/AV//2Q==');
    }
}
