<?php


namespace App\Repositories\Interfaces;


use App\Models\Author;
use Symfony\Component\HttpFoundation\Request;

interface AuthorRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param array $author
     * @return Author
     */
    public function store(array $author): Author;

    /**
     * @param array $author
     * @return bool
     */
    public function update(array $author): bool;

    /**
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request);

    /**
     * @param array $author
     * @return mixed
     */
    public function remove(array $author): bool;
}
