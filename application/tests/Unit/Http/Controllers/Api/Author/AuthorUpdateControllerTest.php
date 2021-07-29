<?php

namespace Tests\Unit\Http\Controllers\Api\Author;


use App\Models\Author;
use App\Models\User;
use Tests\TestCase;

class AuthorUpdateControllerTest extends TestCase
{
    /**
     * @var string
     */
    protected string $token;

    /**
     * @var Author
     */
    protected Author $author;

    protected function setUp():void
    {
        parent::setUp();
        /** @var Author $this */
        $this->author = Author::factory()->create();
        $this->token = User::factory()->create()->createToken('list')->accessToken;
    }

    public function testAuthorUpdateWithValidData(): void
    {
        $response = $this->postJson(route("author.update"), [
            'id' => $this->author->id,
            'firstname' => $this->author->firstname . 'Test',
            'lastname' => $this->author->lastname . 'Test'
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(202);

        $content = json_decode($response->getContent(), true);
        $this->assertTrue($content['result']);

        $author = Author::find($this->author->id);
        $this->assertNotNull($author);
        $this->assertEquals($this->author->firstname . 'Test', $author->firstname);
        $this->assertEquals($this->author->lastname . 'Test', $author->lastname);
    }

    public function testAuthorUpdateWithInvalidId()
    {
        $response = $this->postJson(route("author.update"), [
            'id' => 100500,
            'firstname' => $this->author->firstname . 'Test',
            'lastname' => $this->author->lastname . 'Test'
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(500);

        $message = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $message);
    }
}
