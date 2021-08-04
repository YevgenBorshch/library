<?php

namespace Tests\Unit\Http\Controllers\Api\Author;


use App\Models\Author;
use App\Models\User;
use Tests\TestCase;

class AuthorGetControllerTest extends TestCase
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
        $this->token = User::factory()->create()->createToken('list')->accessToken;
        $this->author = Author::factory()->create();
    }

    public function testAuthorGetValid(): void
    {
        $response = $this->getJson(route("author.get", [
            'author' => $this->author->id,
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('id', $content['author']);
        $this->assertArrayHasKey('firstname', $content['author']);
        $this->assertArrayHasKey('lastname', $content['author']);
        $this->assertCount(1, $content);
        $this->assertCount(5, $content['author']);
    }

    public function testAuthorGetWithIdInvalid(): void
    {
        $response = $this->getJson(route("author.get", [
            'author' => 100500,
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(404);
    }
}
