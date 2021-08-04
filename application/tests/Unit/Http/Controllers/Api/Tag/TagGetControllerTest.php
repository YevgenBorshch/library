<?php

namespace Tests\Unit\Http\Controllers\Api\Tag;


use App\Models\Tag;
use App\Models\User;
use Tests\TestCase;

class TagGetControllerTest extends TestCase
{
    /**
     * @var string
     */
    protected string $token;

    /**
     * @var Tag
     */
    protected $tag;

    protected function setUp(): void
    {
        parent::setUp();
        $this->token = User::factory()->create()->createToken('client')->accessToken;
        $this->tag = Tag::factory()->create();
    }

    public function testTagGetValid(): void
    {
        $response = $this->getJson(route("tag.get", [
            'tag' => $this->tag->id,
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('id', $content['tag']);
        $this->assertArrayHasKey('title', $content['tag']);
        $this->assertCount(1, $content);
        $this->assertCount(4, $content['tag']);
    }

    public function testTagGetWithIdInvalid(): void
    {
        $response = $this->getJson(route("tag.get", [
            'tag' => 100500,
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(404);
    }
}
