<?php


namespace App\Repositories\Interfaces;


use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Request;

interface AuthorRepositoryInterface
{
    /**
     * @param array $author
     * @return Author
     */
    public function store(array $author): Author;

    /**
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request);
}
