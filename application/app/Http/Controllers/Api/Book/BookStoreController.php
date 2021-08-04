<?php

namespace App\Http\Controllers\Api\Book;

use App\Exceptions\ApiArgumentException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreRequest;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BookStoreController extends Controller
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
     * @throws ApiArgumentException
     * @throws ValidationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $value = Validator::make(
            json_decode($request->getContent(), true),
            (new StoreRequest())->rules()
        );

        if ($value->fails()) {
            throw new ApiArgumentException(
                $this->filterErrorMessage(__CLASS__, __LINE__, $request->getContent() . '; ' . $value->errors())
            );
        }

        return response()->json([
            'result' => $this->repository->store($value->validated())
        ], 202);
    }
}
