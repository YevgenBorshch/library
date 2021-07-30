<?php

namespace Tests\Unit\Http\Controllers\Api\Tag;

use App\Models\User;
use Tests\TestCase;

class TagListControllerTest extends TestCase
{
    /**
     * @var string
     */
    protected string $token;

    protected function setUp():void
    {
        parent::setUp();
        $this->token = User::factory()->create()->createToken('list')->accessToken;
    }

    public function testGetTagListValid(): void
    {
        $response = $this->getJson(route("tag.list", [
            'perPage' => 3,
            'orderBy' => "desc"
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);

        $this->assertFields($content['tags']);
    }

    /**
     * @return \int[][]
     */
    public function perPageProviderCase(): array
    {
        return [
            [0],
            [-1]
        ];
    }

    /**
     * @dataProvider perPageProviderCase
     */
    public function testGetTagListWithPerPageInvalid(int $perPage): void
    {
        $response = $this->getJson(route('tag.list', [
            'perPage' => $perPage,
            'orderBy' => "desc"
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(500);

        $content = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('message', $content);
    }

    public function testGetTagListWithoutPerPage(): void
    {
        $response = $this->getJson(route('tag.list', [
            'orderBy' => "desc"
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertFields($content['tags']);
        $this->assertCount(10, $content['tags']['list']);
    }

    public function testGetTagListWithoutOrderBy(): void
    {
        $response = $this->getJson(route('tag.list', [
            'perPage' => 1,
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertFields($content['tags']);
        $this->assertCount(1, $content['tags']['list']);
    }

    public function testGetTagListWithCurrentPageInvalid(): void
    {
        $response = $this->getJson(route('tag.list', [
            'perPage' => 1,
            'currentPage' => 100500
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertFields($content['tags']);
        $this->assertCount(0, $content['tags']['list']);
    }

    protected function assertFields(array $tags): void
    {
        $this->assertArrayHasKey('currentPage', $tags);
        $this->assertArrayHasKey('perPage', $tags);
        $this->assertArrayHasKey('total', $tags);
        $this->assertArrayHasKey('lastPage', $tags);
        $this->assertArrayHasKey('orderBy', $tags);
        $this->assertEquals('desc', $tags['orderBy']);
        $this->assertArrayHasKey('list', $tags);
        $this->assertIsArray($tags['list']);
    }
}
