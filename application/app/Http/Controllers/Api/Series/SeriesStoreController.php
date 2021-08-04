<?php

namespace App\Http\Controllers\Api\Series;

use App\Exceptions\ApiArgumentException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category_Series_Tag\StoreRequest;
use App\Repositories\Interfaces\SeriesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Request;

class SeriesStoreController extends Controller
{
    /**
     * @var SeriesRepositoryInterface
     */
    protected SeriesRepositoryInterface $repository;

    /**
     * @param SeriesRepositoryInterface $repository
     */
    public function __construct(SeriesRepositoryInterface $repository)
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
        return $this->store($request, $this->repository);
    }
}
