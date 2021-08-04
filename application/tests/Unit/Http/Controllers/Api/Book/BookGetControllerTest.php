<?php

namespace Tests\Unit\Http\Controllers\Api\Book;


use App\Models\Book;
use App\Models\User;
use Tests\TestCase;

class BookGetControllerTest extends TestCase
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
        $this->book = Book::factory()->create();
    }

    public function testBookGetValid(): void
    {
        //
    }
}
