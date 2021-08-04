<?php

namespace Tests\Unit\Http\Controllers\Api\Book;


use App\Models\Book;
use App\Models\User;
use Tests\TestCase;

/**
 * @property  faker
 */
class BookStoreControllerTest extends TestCase
{
    /**
     * @var string
     */
    protected string $token;

    /**
     * @var Book
     */
    protected $book;

    protected function setUp():void
    {
        parent::setUp();
        $this->token = User::factory()->create()->createToken('client')->accessToken;
        $this->book = Book::factory()->makeOne();
    }

    public function testBookStoreWithMaximalData(): void
    {
        $response = $this->postJson(route('book.store'), [
            'author' => [
                mt_rand(1, 10),
                mt_rand(5, 15)
            ],
            'category_id' => $this->book->category_id,
            'description' => $this->book->description,
            'title' => $this->book->title,
            'series_id' => $this->book->series_id,
            'tag' => [
                mt_rand(1, 10),
                mt_rand(5, 15)
            ],
            'pages' => $this->book->pages,
            'year' => $this->book->year,
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(202);

        $content = json_decode($response->getContent(), true);
        $this->checkResponseArrayStructure($content);

        $this->assertEquals($content['result']['category_id'], $this->book->category_id);
        $this->assertEquals($content['result']['title'], $this->book->title);
    }

    public function testBookStoreWithMinimalData(): void
    {
        $response = $this->postJson(route('book.store'), [
            'author' => [
                mt_rand(1, 10),
                mt_rand(5, 15)
            ],
            'category_id' => $this->book->category_id,
            'title' => $this->book->title,
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(202);

        $content = json_decode($response->getContent(), true);
        $this->checkResponseArrayStructure($content);

        $this->assertEquals($content['result']['category_id'], $this->book->category_id);
        $this->assertEquals($content['result']['title'], $this->book->title);;
    }

    /**
     * @param array $content
     */
    protected function checkResponseArrayStructure(array $content): void
    {
        $this->assertArrayHasKey('id', $content['result']);
        $this->assertArrayHasKey('category_id', $content['result']);
        $this->assertArrayHasKey('title', $content['result']);
    }
}
