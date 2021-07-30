<?php

namespace App\Http\Controllers\Api\Series;

use App\Http\Controllers\Controller;
use App\Models\Series;
use Illuminate\Http\JsonResponse;

class SeriesGetController extends Controller
{
    /**
     * @param Series $series
     * @return JsonResponse
     */
    public function __invoke(Series $series): JsonResponse
    {
        return response()->json(['series' => $series]);
    }
}
