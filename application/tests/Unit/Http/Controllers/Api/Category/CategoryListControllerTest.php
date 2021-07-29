<?php

namespace Tests\Unit\Http\Controllers\Api\Category;

use App\Models\User;
use Tests\TestCase;

class CategoryListControllerTest extends TestCase
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

    public function testGetCategoryListValid(): void
    {
        $response = $this->getJson(route("category.list", [
            'perPage' => 3,
            'orderBy' => "desc"
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);

        $this->assertFields($content['categories']);
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
    public function testGetCategoryListWithPerPageInvalid(int $perPage): void
    {
        $response = $this->getJson(route('category.list', [
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

    public function testGetCategoryListWithoutPerPage(): void
    {
        $response = $this->getJson(route('category.list', [
            'orderBy' => "desc"
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertFields($content['categories']);
        $this->assertCount(10, $content['categories']['list']);
    }

    public function testGetCategoryListWithoutOrderBy(): void
    {
        $response = $this->getJson(route('category.list', [
            'perPage' => 1,
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertFields($content['categories']);
        $this->assertCount(1, $content['categories']['list']);
    }

    public function testGetCategoryListWithCurrentPageInvalid(): void
    {
        $response = $this->getJson(route('category.list', [
            'perPage' => 1,
            'currentPage' => 100500
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertFields($content['categories']);
        $this->assertCount(0, $content['categories']['list']);
    }

    protected function assertFields(array $categories): void
    {
        $this->assertArrayHasKey('currentPage', $categories);
        $this->assertArrayHasKey('perPage', $categories);
        $this->assertArrayHasKey('total', $categories);
        $this->assertArrayHasKey('lastPage', $categories);
        $this->assertArrayHasKey('orderBy', $categories);
        $this->assertEquals('desc', $categories['orderBy']);
        $this->assertArrayHasKey('list', $categories);
        $this->assertIsArray($categories['list']);
    }
}
