<?php

namespace App\Http\Controllers\Api\Category;

use App\Exceptions\ApiArgumentException;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryStoreController extends Controller
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
     * @throws ValidationException
     * @throws ApiArgumentException
     */
    public function __invoke(Request $request): JsonResponse
    {
        return $this->store($request, $this->repository);
    }
}
