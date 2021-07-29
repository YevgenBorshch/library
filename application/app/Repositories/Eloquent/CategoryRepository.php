<?php


namespace App\Repositories\Eloquent;


use App\Exceptions\ApiArgumentException;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Pagination\Paginator;
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

    /**
     * @param array $category
     * @return bool
     * @throws ApiArgumentException
     */
    public function update(array $category): bool
    {
        $categoryExist = Category::find($category['id']);

        if (!$categoryExist) {
            throw new ApiArgumentException(
                $this->filterErrorMessage('Class: ' . __CLASS__ . '; Line: ' . __LINE__ . '; ' . __('api.id.doesntExist'))
            );
        }

        return $categoryExist->update($category);
    }

    /**
     * @throws ApiArgumentException
     */
    public function list(Request $request)
    {
        $currentPage = $request->get('currentPage', 1);
        $perPage = $request->get('perPage', 10);
        $orderBy = $request->get('orderBy', 'desc');

        if (!$perPage || $perPage < 1 || !Category::validateOrder($orderBy)) {
            throw new ApiArgumentException(
                $this->filterErrorMessage('Class: ' . __CLASS__ . '; Line: ' . __LINE__ . '; ' . __('api.arguments.bad'))
            );
        }

        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        return Category::orderBy('id', $orderBy)->paginate($perPage);
    }
}
