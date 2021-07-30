<?php


namespace App\Repositories\Interfaces;


use App\Models\Tag;
use Symfony\Component\HttpFoundation\Request;

interface TagRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param array $tag
     * @return Tag
     */
    public function store(array $tag): Tag;

    /**
     * @param array $tag
     * @return bool
     */
    public function update(array $tag): bool;

    /**
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request);
}
