<?php

namespace Tests\Unit\Http\Controllers\Api\Auth;

use App\Models\User;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    public function testRegister(): void
    {
        $user = User::factory()->make();

        $response = $this->post(config('app.url') . '/api/v1/auth/register', [
            "name" => $user->name,
            "email" => $user->email,
            "password" => $user->password,
            "password_confirmation" => $user->password
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);
        $content = json_decode($response->getContent(), true);

        $this->assertEquals($user->name, $content['user']['name']);
        $this->assertEquals($user->email, $content['user']['email']);
    }
}
