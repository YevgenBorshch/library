<?php


namespace App\Http\Controllers\Api\Category;


use App\Exceptions\ApiArgumentException;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Request;

class CategoryUpdateController extends Controller
{
    /**
     * @var CategoryRepositoryInterface
     */
    protected CategoryRepositoryInterface $repository;

    /**
     * AuthorController constructor.
     * @param CategoryRepositoryInterface $repository
     */
    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ApiArgumentException
     * @throws ValidationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        return $this->update($request, $this->repository);
    }
}
