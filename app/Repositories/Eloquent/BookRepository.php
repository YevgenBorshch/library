<?php

namespace App\Repositories\Eloquent;

use App\Models\Book;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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
        try {
            $book = [];
            if (isset($value['category_id'])) {
                $book['category_id'] = $value['category_id'];
            }
            $book['current_page'] = 0;
            $book['description'] = $value['description'];
            $book['image'] = $value['filename'] . '.' . $value['imageType'];
            $book['pages'] = $value['pages'];
            $book['readed'] = 0;
            $book['source'] = 0;
            $book['title'] = $value['title'];
            $book['year'] = $value['year'];

            return $this->model::create($book);
        } catch (\Exception $e) {
            Log::critical(__METHOD__, [__LINE__ => $e->getMessage()]);
        }
        return new Book();
    }
}
