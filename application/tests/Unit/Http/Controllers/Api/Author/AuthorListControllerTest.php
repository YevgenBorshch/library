<?php

namespace Tests\Unit\Http\Controllers\Api\Author;

use App\Models\User;
use Tests\TestCase;

class AuthorListControllerTest extends TestCase
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

    public function testGetAuthorListValid(): void
    {
        $response = $this->getJson(route("author.list", [
            'perPage' => 3,
            'orderBy' => "desc"
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertFields($content['authors']);
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
    public function testGetAuthorListWithPerPageInvalid(int $perPage): void
    {
        $response = $this->getJson(route('author.list', [
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

    public function testGetAuthorListWithoutPerPage(): void
    {
        $response = $this->getJson(route('author.list', [
            'orderBy' => "desc"
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertFields($content['authors']);
        $this->assertCount(10, $content['authors']['list']);
    }

    public function testGetAuthorListWithoutOrderBy(): void
    {
        $response = $this->getJson(route('author.list', [
            'perPage' => 1,
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertFields($content['authors']);
        $this->assertCount(1, $content['authors']['list']);
    }

    public function testGetAuthorListWithCurrentPageInvalid(): void
    {
        $response = $this->getJson(route('author.list', [
            'perPage' => 1,
            'currentPage' => 100500
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertFields($content['authors']);
        $this->assertCount(0, $content['authors']['list']);
    }

    protected function assertFields(array $authors): void
    {
        $this->assertArrayHasKey('currentPage', $authors);
        $this->assertArrayHasKey('perPage', $authors);
        $this->assertArrayHasKey('total', $authors);
        $this->assertArrayHasKey('lastPage', $authors);
        $this->assertArrayHasKey('orderBy', $authors);
        $this->assertEquals('desc', $authors['orderBy']);
        $this->assertArrayHasKey('list', $authors);
        $this->assertIsArray($authors['list']);
    }
}
