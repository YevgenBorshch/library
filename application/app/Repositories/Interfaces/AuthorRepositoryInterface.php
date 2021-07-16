<?php


namespace App\Repositories\Interfaces;


use App\Models\Author;

interface AuthorRepositoryInterface
{
    /**
     * @param array $author
     * @return Author
     */
    public function create(array $author): Author;
}
