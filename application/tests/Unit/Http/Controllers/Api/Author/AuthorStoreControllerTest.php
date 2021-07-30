<?php

namespace Tests\Unit\Http\Controllers\Api\Author;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class AuthorStoreControllerTest extends TestCase
{
    /**
     * @var string
     */
    protected string $token;

    /**
     * @var Author
     */
    protected $author;

    protected function setUp():void
    {
        parent::setUp();
        $this->token = User::factory()->create()->createToken('client')->accessToken;
        $this->author = Author::factory()->create();
    }

    public function testAuthorStoreValid(): void
    {
        $response = $this->postJson(route('author.store'), [
            'firstname' => $this->author->firstname,
            'lastname' => $this->author->lastname
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(202);

        $content = json_decode($response->getContent(), true);
        $this->assertEquals($content['author']['firstname'], $this->author->firstname);
        $this->assertEquals($content['author']['lastname'], $this->author->lastname);
    }

    public function testAuthorStoreWithoutFirstname(): void
    {
        $response = $this->postJson(route('author.store'), [
            'lastname' => $this->author->lastname
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(500);
        $message = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $message);
    }
}
