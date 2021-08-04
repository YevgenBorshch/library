<?php

namespace Tests\Unit\Http\Controllers\Api\Category;

use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class CategoryGetControllerTest extends TestCase
{
    /**
     * @var string
     */
    protected string $token;

    /**
     * @var Category
     */
    protected $category;

    protected function setUp():void
    {
        parent::setUp();
        $this->token = User::factory()->create()->createToken('list')->accessToken;
        $this->category = Category::factory()->create();
    }

    public function testCategoryGetValid(): void
    {
        $response = $this->getJson(route("category.get", [
            'category' => $this->category->id,
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('id', $content['category']);
        $this->assertArrayHasKey('title', $content['category']);
        $this->assertCount(1, $content);
        $this->assertCount(4, $content['category']);
    }

    public function testCategoryGetWithIdInvalid(): void
    {
        $response = $this->getJson(route("category.get", [
            'category' => 100500,
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(404);
    }
}
