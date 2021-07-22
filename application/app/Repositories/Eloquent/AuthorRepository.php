<?php


namespace App\Repositories\Eloquent;


use App\Models\Author;
use App\Repositories\Interfaces\AuthorRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthorRepository implements AuthorRepositoryInterface
{
    /**
     * @param array $author
     * @return Author
     */
    public function store(array $author): Author
    {
        return Author::create($author);
    }

    /**
     * @param int $perPage
     * @param string $order
     * @return LengthAwarePaginator
     */
    public function list(int $perPage, string $order): LengthAwarePaginator
    {
        return Author::orderBy('id', $order)->paginate($perPage);
    }
}
