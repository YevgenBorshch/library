<?php


namespace App\Repositories\Eloquent;


use App\Models\Author;
use App\Repositories\Interfaces\AuthorRepositoryInterface;

class AuthorRepository implements AuthorRepositoryInterface
{
    /**
     * @param array $author
     * @return Author
     */
    public function create(array $author): Author
    {
        dd(Author::create($author));
    }
}
