<?php

namespace Tests\Unit\Http\Controllers\Api\Category;


use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class CategoryRemoveControllerTest extends TestCase
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

    public function testCategoryRemoveValid(): void
    {
        $response = $this->postJson(route('category.remove'), [
            'id' => $this->category->id,
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(202);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('result', $content);
        $this->assertTrue($content['result']);
    }
}
