<?php

namespace Tests\Unit\Http\Controllers\Api\Author;

use App\Models\Author;
use App\Models\User;
use Tests\TestCase;

class AuthorStoreControllerTest extends TestCase
{
    public function testStore()
    {
        $token = User::factory()->create()->createToken('client')->accessToken;
        $author = Author::factory()->create();

        $response = $this->postJson(route('author.store'), [
            'firstname' => $author->firstname,
            'lastname' => $author->lastname
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(202);

        $content = json_decode($response->getContent(), true);
        $this->assertEquals($content['author']['firstname'], $author->firstname);
        $this->assertEquals($content['author']['lastname'], $author->lastname);
    }
}
