<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_user_can_register()
    {
        $response = $this->json('post', '/api/register', [
            'name' => 'JohnyzeDoe',
            'email' => 'jodsdssdss@example.com',
            'role_id' => 1, 
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Assert the response status is 201 (Created)
        $response->assertStatus(200);

        // Check that the user was added to the database
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);
    }

    // Test user login
    public function test_user_can_login()
    {
        // Create a user with a password
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);
    
        // Send a POST request to the login endpoint with correct credentials
        $response = $this->json('POST', '/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
    
        // Assert that the response status is 200 (OK)
        $response->assertStatus(200);
    
        // Assert that the response JSON contains 'access_token' and 'token_type'
        $response->assertJsonStructure([
            'status',
            'user' => [
                'id',
                'name',
                'email',
                'email_verified_at',
                'role_id',
                'created_at',
                'updated_at',
            ],
            'access_token',
            'token_type',
        ]);
    
        // Optionally, check that the 'access_token' is a non-empty string (JWT token)
        $response->assertJsonFragment([
            'access_token' => true,  // Ensure the token is present
        ]);
    }
    

    // Test login failure with invalid credentials
    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->json('POST', '/api/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);
        $response->assertStatus(401);
    }


}
