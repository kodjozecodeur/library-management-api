<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register_successfully()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Assert the response is successful and contains user data
        $response->assertStatus(201); // Registration should return 201 Created
        $response->assertJsonStructure(['user', 'token']); // Should return user and token
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]); // User should be in the database
    }

    /** @test */
    public function registration_requires_all_fields()
    {
        $response = $this->postJson('/api/register', []);
        $response->assertStatus(422); // Should fail validation
        $response->assertJsonValidationErrors(['name', 'email', 'password']); // All fields required
    }

    /** @test */
    public function registration_fails_with_duplicate_email()
    {
        User::factory()->create(['email' => 'test@example.com']);
        $response = $this->postJson('/api/register', [
            'name' => 'Another User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(422); // Should fail validation
        $response->assertJsonValidationErrors(['email']); // Email must be unique
    }
}
