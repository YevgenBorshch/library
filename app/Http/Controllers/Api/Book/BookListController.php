<?php

namespace App\Http\Controllers\Api\Book;

use App\DTO\ResponseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ListRequest;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Http\JsonResponse;

class BookListController extends Controller
{
    /**
     * @var BookRepositoryInterface
     */
    protected BookRepositoryInterface $repository;

    /**
     * BookRemoveController constructor
     * @param BookRepositoryInterface $repository
     */
    public function __construct(BookRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ListRequest $request
     * @return JsonResponse
     */
    public function __invoke(ListRequest $request): JsonResponse
    {
        return response()->json(
            new ResponseDTO($this->repository->list($request))
        );
    }
}
