<?php


namespace App\Repositories\Eloquent;


use App\Models\Author;
use App\Repositories\Interfaces\AuthorRepositoryInterface;

class AuthorRepository extends BaseRepository implements AuthorRepositoryInterface
{
    /**
     * AuthorRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Author::class);
    }
}
