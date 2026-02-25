<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainerTestBankTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_store_without_authentication(): void
    {
        $payload = [
            'title' => 'Sample',
            'type' => 'seatwork',
            'questions_json' => json_encode([['type'=>'multiple_choice','text'=>'Q1']]),
        ];
        $response = $this->postJson(route('trainer.test-banks.store'), $payload);
        $response->assertStatus(401);
    }

    public function test_validation_errors_are_returned(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $payload = [
            'title' => '',
            'type' => 'invalid',
            'questions_json' => '',
        ];
        $response = $this->postJson(route('trainer.test-banks.store'), $payload);
        $response->assertStatus(422);
        $response->assertJsonStructure(['errors']);
    }

    public function test_store_template_successfully(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $payload = [
            'title' => 'My Quiz',
            'type' => 'quiz',
            'description' => 'Desc',
            'questions_json' => json_encode([['type'=>'multiple_choice','text'=>'Q1']]),
        ];
        $response = $this->postJson(route('trainer.test-banks.store'), $payload);
        $response->assertOk();
        $response->assertJson(['ok'=>true]);
        $this->assertDatabaseHas('assessment_templates', [
            'user_id' => $user->id,
            'title' => 'My Quiz',
            'type' => 'quiz',
        ]);
    }

    public function test_list_templates_returns_items(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $payload = [
            'title' => 'My Exam',
            'type' => 'exam',
            'questions_json' => json_encode([]),
        ];
        $this->postJson(route('trainer.test-banks.store'), $payload)->assertOk();
        $res = $this->getJson(route('trainer.test-banks.index'));
        $res->assertOk();
        $res->assertJsonStructure(['items']);
    }
}
