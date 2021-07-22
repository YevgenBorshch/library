<?php


namespace App\Repositories\Interfaces;


use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;

interface AuthorRepositoryInterface
{
    /**
     * @param array $author
     * @return Author
     */
    public function store(array $author): Author;

    /**
     * @param int $perPage
     * @param string $order
     * @return LengthAwarePaginator
     */
    public function list(int $perPage, string $order): LengthAwarePaginator;
}
