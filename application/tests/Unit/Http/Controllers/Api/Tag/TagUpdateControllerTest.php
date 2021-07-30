<?php

namespace Tests\Unit\Http\Controllers\Api\Tag;


use App\Models\Tag;
use App\Models\User;
use Tests\TestCase;

class TagUpdateControllerTest extends TestCase
{
    /**
     * @var string
     */
    protected string $token;

    /**
     * @var Tag
     */
    protected Tag $tag;

    protected function setUp():void
    {
        parent::setUp();
        /** @var Tag $this */
        $this->tag = Tag::factory()->create();
        $this->token = User::factory()->create()->createToken('list')->accessToken;
    }

    public function testTagUpdateWithValidData(): void
    {
        $response = $this->postJson(route("tag.update"), [
            'id' => $this->tag->id,
            'title' => $this->tag->title . 'Test',
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(202);

        $content = json_decode($response->getContent(), true);
        $this->assertTrue($content['result']);

        $tag = Tag::find($this->tag->id);
        $this->assertNotNull($tag);
        $this->assertEquals($this->tag->title . 'Test', $tag->title);
    }

    public function testTagUpdateWithInvalidId()
    {
        $response = $this->postJson(route("tag.update"), [
            'id' => 100500,
            'title' => $this->tag->title . 'Test'
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(500);

        $message = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $message);
    }
}
