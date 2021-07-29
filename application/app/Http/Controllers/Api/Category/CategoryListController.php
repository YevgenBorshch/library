<?php


namespace App\Http\Controllers\Api\Category;


use App\DTO\ListDTO;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CategoryListController extends Controller
{
    /**
     * @var CategoryRepositoryInterface
     */
    protected CategoryRepositoryInterface $categoryRepository;

    /**
     * CategoryStoreController constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $categories = $this->categoryRepository->list($request);

        $result = new ListDTO(
            $categories->currentPage(),
            $categories->perPage(),
            $categories->total(),
            $categories->lastPage(),
            $request->get('orderBy', 'desc'),
            $categories->items(),
        );

        return response()->json(['categories' => $result]);
    }
}
