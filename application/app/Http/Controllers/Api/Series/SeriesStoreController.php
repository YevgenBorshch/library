<?php

namespace App\Http\Controllers\Api\Series;

use App\Exceptions\ApiArgumentException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category_Seria_Tag\StoreRequest;
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
     * @throws ApiArgumentException
     * @throws ValidationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $series = Validator::make(
            json_decode($request->getContent(), true),
            (new StoreRequest())->rules()
        );

        if ($series->fails()) {
            throw new ApiArgumentException(
                $this->filterErrorMessage(__CLASS__, __LINE__, $request->getContent())
            );
        }

        return response()->json([
            'series' => $this->seriesRepository->store($series->validated())
        ], 202);
    }
}
