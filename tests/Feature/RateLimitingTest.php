<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class RateLimitingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_is_rate_limited_after_multiple_failed_attempts()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Simulate failed login attempts
        for ($i = 0; $i < 6; $i++) {
            $response = $this->postJson('/api/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        // Assert rate limiting is triggered
        $response->assertStatus(429); // Should return 429 Too Many Requests
        $response->assertSeeText('Too Many Attempts'); // Should show rate limit message
    }
}
