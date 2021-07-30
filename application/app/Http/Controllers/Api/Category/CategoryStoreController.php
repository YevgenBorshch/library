<?php

namespace App\Http\Controllers\Api\Category;

use App\Exceptions\ApiArgumentException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category_Series_Tag\StoreRequest;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CategoryStoreController extends Controller
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
     * @throws ValidationException
     * @throws ApiArgumentException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $category = Validator::make(
            json_decode($request->getContent(), true),
            (new StoreRequest())->rules()
        );

        if ($category->fails()) {
            throw new ApiArgumentException(
                $this->filterErrorMessage(__CLASS__, __LINE__, $request->getContent())
            );
        }

        return response()->json([
            'category' => $this->categoryRepository->store($category->validated())
        ], 202);
    }
}
