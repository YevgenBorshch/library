<?php

namespace Tests\Unit\Http\Controllers\Api\Tag;

use App\Models\Tag;
use App\Models\User;
use Tests\TestCase;

class TagRemoveControllerTest extends TestCase
{
    /**
     * @var string
     */
    protected string $token;

    /**
     * @var Tag
     */
    protected $tag;

    protected function setUp():void
    {
        parent::setUp();
        $this->token = User::factory()->create()->createToken('list')->accessToken;
        $this->tag = Tag::factory()->create();
    }

    public function testTagRemoveValid()
    {
        $response = $this->postJson(route('tag.remove'), [
            'id' => $this->tag->id,
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(202);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('result', $content);
        $this->assertTrue($content['result']);
    }

    public function testTagRemoveWithoutId(): void
    {
        $response = $this->postJson(route('tag.remove'), [], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(500);
        $message = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $message);
    }

    public function testTagRemoveWithEmptyId(): void
    {
        $response = $this->postJson(route('tag.remove'), [
            'id' => '',
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(500);
        $message = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $message);
    }
}
