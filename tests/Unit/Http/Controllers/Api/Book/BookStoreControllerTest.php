<?php

namespace Unit\Http\Controllers\Api\Book;


use App\Models\Author;
use App\Models\Book;
use App\Models\Tag;
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
        $this->book = Book::factory()->make();
    }

    public function testBookStoreWithMaximalData(): void
    {
        $response = $this->postJson(route('book.store'), [
            'author' => [
                (new Author())->id,
                (new Author())->id
            ],
            'category_id' => $this->book->category_id,
            'description' => $this->book->description,
            'title' => $this->book->title,
            'series_id' => $this->book->series_id,
            'tag' => [
                (new Tag())->id,
                (new Tag())->id
            ],
            'pages' => $this->book->pages,
            'year' => $this->book->year,
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(201);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals($content['data']['category_id'], $this->book->category_id);
        $this->assertEquals($content['data']['title'], $this->book->title);
    }

    public function testBookStoreWithMinimalData(): void
    {
        $response = $this->postJson(route('book.store'), [
            'author' => [
                (new Author())->id,
                (new Author())->id
            ],
            'category_id' => $this->book->category_id,
            'title' => $this->book->title,
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(201);

        $content = json_decode($response->getContent(), true);
        $this->checkResponseArrayStructure($content);

        $this->assertEquals($content['data']['category_id'], $this->book->category_id);
        $this->assertEquals($content['data']['title'], $this->book->title);;
    }

    /**
     * @param array $content
     */
    protected function checkResponseArrayStructure(array $content): void
    {
        $this->assertArrayHasKey('id', $content['data']);
        $this->assertArrayHasKey('category_id', $content['data']);
        $this->assertArrayHasKey('title', $content['data']);
    }
}
