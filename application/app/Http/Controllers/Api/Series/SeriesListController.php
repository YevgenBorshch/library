<?php

namespace App\Http\Controllers\Api\Series;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SeriesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SeriesListController extends Controller
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
     */
    public function __invoke(Request $request): JsonResponse
    {
        return $this->list($request, $this->repository);
    }
}
