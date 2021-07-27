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

    public function testGetListValid(): void
    {
        $response = $this->getJson(route("author.list", [
            "perPage" => 3,
            "orderBy" => "desc"
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('currentPage', $content['authors']);
        $this->assertArrayHasKey('perPage', $content['authors']);
        $this->assertArrayHasKey('total', $content['authors']);
        $this->assertArrayHasKey('lastPage', $content['authors']);
        $this->assertArrayHasKey('orderBy', $content['authors']);
        $this->assertArrayHasKey('list', $content['authors']);
        $this->assertIsArray($content['authors']['list']);
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
    public function testGetListWithPerPageInvalid(int $perPage): void
    {
        $response = $this->getJson(route('author.list', [
            "perPage" => $perPage,
            "orderBy" => "desc"
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(500);

        $content = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('message', $content);
    }

    public function testGetListWithoutPerPage(): void
    {
        $response = $this->getJson(route('author.list', [
            "orderBy" => "desc"
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('currentPage', $content['authors']);
        $this->assertArrayHasKey('perPage', $content['authors']);
        $this->assertArrayHasKey('total', $content['authors']);
        $this->assertArrayHasKey('lastPage', $content['authors']);
        $this->assertArrayHasKey('orderBy', $content['authors']);
        $this->assertArrayHasKey('list', $content['authors']);
        $this->assertIsArray($content['authors']['list']);
        $this->assertCount(10, $content['authors']['list']);
    }

    public function testGetListWithoutOrderBy(): void
    {
        $response = $this->getJson(route('author.list', [
            "perPage" => 1,
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('currentPage', $content['authors']);
        $this->assertArrayHasKey('perPage', $content['authors']);
        $this->assertArrayHasKey('total', $content['authors']);
        $this->assertArrayHasKey('lastPage', $content['authors']);
        $this->assertArrayHasKey('orderBy', $content['authors']);
        $this->assertEquals('desc', $content['authors']['orderBy']);
        $this->assertArrayHasKey('list', $content['authors']);
        $this->assertIsArray($content['authors']['list']);
        $this->assertCount(1, $content['authors']['list']);
    }

    public function testGetListWithCurrentPageInvalid(): void
    {
        $response = $this->getJson(route('author.list', [
            "perPage" => 1,
            "currentPage" => 100500
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('currentPage', $content['authors']);
        $this->assertArrayHasKey('perPage', $content['authors']);
        $this->assertArrayHasKey('total', $content['authors']);
        $this->assertArrayHasKey('lastPage', $content['authors']);
        $this->assertArrayHasKey('orderBy', $content['authors']);
        $this->assertEquals('desc', $content['authors']['orderBy']);
        $this->assertArrayHasKey('list', $content['authors']);
        $this->assertIsArray($content['authors']['list']);
        $this->assertCount(0, $content['authors']['list']);
    }
}
