<?php


namespace App\Http\Controllers\Api\Category;


use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CategoryListController extends Controller
{
    /**
     * @var CategoryRepositoryInterface
     */
    protected CategoryRepositoryInterface $repository;

    /**
     * CategoryStoreController constructor.
     * @param CategoryRepositoryInterface $repository
     */
    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        return $this->list($request, $this->repository);
    }
}
