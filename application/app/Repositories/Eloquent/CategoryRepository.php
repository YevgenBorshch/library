<?php


namespace App\Repositories\Eloquent;


use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * CategoryRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Category::class);
    }

    public function store(array $category): Category
    {
        return Category::create($category);
    }

    public function update(array $category): bool
    {
        // TODO: Implement update() method.
    }

    public function list(Request $request)
    {
        // TODO: Implement list() method.
    }
}
