<?php

namespace App\Http\Controllers\Api\Book;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BookListController extends Controller
{
    /**
     * @var BookRepositoryInterface
     */
    protected BookRepositoryInterface $repository;

    /**
     * @param BookRepositoryInterface $repository
     */
    public function __construct(BookRepositoryInterface $repository)
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
