<?php

namespace Tests\Unit\Http\Controllers\Api\Author;


use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class AuthorRemoveControllerTest extends TestCase
{
    /**
     * @var string
     */
    protected string $token;

    /**
     * @var Author|Collection|Model
     */
    protected $author;

    protected function setUp():void
    {
        parent::setUp();
        $this->token = User::factory()->create()->createToken('client')->accessToken;
        $this->author = Author::factory()->create();
    }

    public function testAuthorRemoveValid(): void
    {
        $response = $this->postJson(route('author.remove'), [
            'author_id' => $this->author->id,
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(202);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('result', $content);
        $this->assertTrue($content['result']);
    }

    public function testAuthorRemoveWithoutId(): void
    {
        $response = $this->postJson(route('author.remove'), [], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(500);
        $message = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $message);
    }

    public function testAuthorRemoveWithEmptyId(): void
    {
        $response = $this->postJson(route('author.remove'), [
            'author_id' => '',
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(500);
        $message = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $message);
    }
}
