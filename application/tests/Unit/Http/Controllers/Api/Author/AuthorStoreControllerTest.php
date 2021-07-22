<?php

namespace Tests\Unit\Http\Controllers\Api\Author;


use Tests\TestCase;

class AuthorStoreControllerTest extends TestCase
{
    public function testStore()
    {
        $response = $this->post(config('app.url') . '/api/v1/auth/register', [
            'firstname' => 'testAuthorFirstname',
            'lastname' => 'testAuthorLastname'
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);
        $content = json_decode($response->getContent(), true);
        dd($content);
    }
}
