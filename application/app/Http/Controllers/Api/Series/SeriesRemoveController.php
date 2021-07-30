<?php

namespace App\Http\Controllers\Api\Series;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SeriesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SeriesRemoveController extends Controller
{
    /**
     * @var SeriesRepositoryInterface
     */
    protected SeriesRepositoryInterface $seriesRepository;

    /**
     * @param SeriesRepositoryInterface $seriesRepository
     */
    public function __construct(SeriesRepositoryInterface $seriesRepository)
    {
        $this->seriesRepository = $seriesRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {

    }
}
