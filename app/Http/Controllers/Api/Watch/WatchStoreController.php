<?php

namespace App\Http\Controllers\Api\Watch;

use App\Jobs\Watch\ParsingWatchAuthorJob;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class WatchStoreController
{
    public function __invoke(Request $request): JsonResponse
    {
        dispatch(
            (new ParsingWatchAuthorJob($request))->onQueue('watch-store')
        );

        return response()->json([], 201);
    }
}
