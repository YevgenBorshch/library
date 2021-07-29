<?php

namespace Tests\Unit\Http\Controllers\Api\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class CategoryStoreControllerTest extends TestCase
{
    /**
     * @var string
     */
    protected string $token;

    /**
     * @var Category|Collection|Model
     */
    protected $category;

    protected function setUp():void
    {
        parent::setUp();
        $this->token = User::factory()->create()->createToken('client')->accessToken;
        $this->category = Category::factory()->create();
    }

    public function testCategoryStoreValid(): void
    {
        $response = $this->postJson(route('category.store'), [
            'title' => $this->category->title,
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(202);

        $content = json_decode($response->getContent(), true);
        $this->assertEquals($content['category']['title'], $this->category->title);
    }

    public function testCategoryStoreWithEmptyTitle(): void
    {
        $response = $this->postJson(route('category.store'), [
            'title' => '',
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(500);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $content);
    }

    public function testCategoryStoreWithShortTitle(): void
    {
        $response = $this->postJson(route('category.store'), [
            'title' => '12',
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(500);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $content);
    }
}