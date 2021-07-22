<?php

namespace Tests\Unit\Http\Controllers\Api\Auth;


use App\Models\User;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    public function testLogin()
    {
        $user = User::factory()->create();

        $response = $this->post(config('app.url') . '/api/v1/auth/login', [
            "email" => $user->email,
            "password" => "password",
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('token', $content);
    }
}
