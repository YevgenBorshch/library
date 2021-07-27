<?php


namespace App\Repositories\Interfaces;


use App\Models\Category;
use Symfony\Component\HttpFoundation\Request;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param array $category
     * @return Category
     */
    public function store(array $category): Category;

    /**
     * @param array $category
     * @return bool
     */
    public function update(array $category): bool;

    /**
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request);
}
