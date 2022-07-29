<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function test_redirect_if_not_auth()
    {
        $response = $this->get('/api/me');
        $response->assertStatus(500);
    }

    public function test_profile_route()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get('/api/me');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            "message" => "Data Loaded Successfully",
        ]);
    }

    public function test_create_new_account()
    {
        $response = $this->post('/api/create-account', [
            'name' => 'Username',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            "message" => "User Created Successfully"
        ]);
    }

    public function test_signin()
    {
        $response = $this->post('/api/signin', [
            'name' => 'test username',
            'password' => '123456',
        ]);
        $response->assertSuccessful();
        $response->assertJson([
            "success" => true,
            "token_type" => "Bearer",
            "message" => "User Login Successfully",
        ]);
    }

    public function test_signout()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->post('/api/sign-out');
        $response->assertSuccessful();
        $response->assertJson([
            "success" => true,
            "message" => "Tokens Revoked",
        ]);
    }

}
