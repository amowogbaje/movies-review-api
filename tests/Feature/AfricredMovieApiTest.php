<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AfricredMovieApiTest extends TestCase
{
    use RefreshDatabase;

    // Authentication Tests
    public function test_user_registration()
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Registration successful. Awaiting admin approval.'
            ]);
    }

    public function test_registration_validation_errors()
    {
        $response = $this->postJson('/api/v1/register', []);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'status',
                'message',
                'errors' => ['name', 'email', 'password']
            ]);
    }

    public function test_user_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'is_approved' => true
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'token',
                'data' => ['user' => ['id', 'name', 'email', 'is_approved']]
            ]);
    }

    // Movies Tests
    public function test_get_movies_list()
    {
        Movie::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/movies');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'thumbnail',
                        'release_date',
                        'genre',
                        'rating'
                    ]
                ]
            ]);
    }

    public function test_get_movie_details()
    {
        $movie = Movie::factory()->create();

        $response = $this->getJson("/api/v1/movies/{$movie->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'movie' => [
                        'id',
                        'title',
                        'description',
                        'thumbnail',
                        'release_date',
                        'genre',
                        'rating'
                    ],
                    'reviews'
                ]
            ]);
    }

    // Admin Movie Management Tests
    public function test_admin_create_movie()
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $token = $admin->createToken('admin-token')->plainTextToken;

        $response = $this->withToken($token)->postJson('/api/v1/admin/movies', [
            'title' => 'New Movie',
            'description' => 'Movie description',
            'thumbnail' => 'http://example.com/image.jpg',
            'release_date' => '2024-01-01',
            'genre' => 'Action'
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'title',
                    'description',
                    'thumbnail',
                    'release_date',
                    'genre',
                    'rating'
                ]
            ]);
    }

    public function test_admin_update_movie()
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $movie = Movie::factory()->create();
        $token = $admin->createToken('admin-token')->plainTextToken;

        $response = $this->withToken($token)->putJson("/api/v1/admin/movies/{$movie->id}", [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'thumbnail' => 'http://example.com/new-image.jpg',
            'release_date' => '2024-01-01',
            'genre' => 'Comedy'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Movie updated successfully'
            ]);
    }

    // Negative Tests
    public function test_unauthenticated_access_protected_endpoints()
    {
        $movie = Movie::factory()->create();

        $endpoints = [
            ['method' => 'post', 'url' => '/api/v1/admin/movies'],
            ['method' => 'put', 'url' => "/api/v1/admin/movies/{$movie->id}"],
            ['method' => 'delete', 'url' => "/api/v1/admin/movies/{$movie->id}"],
            ['method' => 'post', 'url' => "/api/v1/movies/{$movie->id}/reviews"],
            ['method' => 'post', 'url' => '/api/v1/admin/users/1/approve'],
        ];

        foreach ($endpoints as $endpoint) {
            $response = $this->{"{$endpoint['method']}Json"}($endpoint['url']);
            $response->assertStatus(401);
        }
    }
}
