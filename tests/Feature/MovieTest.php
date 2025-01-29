<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MovieTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_unauthenticated_user_cannot_create_movie()
    {
        $response = $this->postJson('/api/movies', []);
        $response->assertUnauthorized();
    }

    public function test_admin_can_create_movie()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)
            ->postJson('/api/movies', [
                'title' => 'Test Movie',
                'description' => 'Test Description',
                'thumbnail' => 'http://example.com/image.jpg',
                'release_date' => now()->format('Y-m-d'),
                'genre' => 'Action'
            ]);

        $response->assertCreated();
    }
}
