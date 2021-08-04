<?php

namespace App\Repositories\Eloquent;

use App\Models\Book;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    /**
     * BookRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Book::class);
    }

    /**
     * @param array $value
     * @return Model
     */
    public function store(array $value): Model
    {
        $book = $this->model::create($value);

        if (isset($value['author'])) {
            foreach ($value['author'] as $author) {
                $book->authors()->attach($author);
            }
        }

        if (isset($value['tag'])) {
            foreach ($value['tag'] as $tag) {
                $book->tags()->attach($tag);
            }
        }

        return $book;
    }
}
