<?php

namespace App\Http\Controllers\Api\Series;

use App\DTO\ListDTO;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SeriesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SeriesListController extends Controller
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
        $series = $this->seriesRepository->list($request);

        $result = new ListDTO(
            $series->currentPage(),
            $series->perPage(),
            $series->total(),
            $series->lastPage(),
            $request->get('orderBy', 'desc'),
            $series->items(),
        );

        return response()->json(['series' => $result]);
    }
}
