<?php

namespace App\Http\Controllers\Api\Author;

use App\Exceptions\ApiArgumentException;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AuthorRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Request;

class AuthorRemoveController extends Controller
{
    /**
     * @var AuthorRepositoryInterface
     */
    protected AuthorRepositoryInterface $repository;

    /**
     * AuthorController constructor.
     * @param AuthorRepositoryInterface $repository
     */
    public function __construct(AuthorRepositoryInterface $repository)
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
        return $this->remove($request, $this->repository);
    }
}
