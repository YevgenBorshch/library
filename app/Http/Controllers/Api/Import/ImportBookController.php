<?php


namespace App\Http\Controllers\Api\Import;


use App\Http\Controllers\Controller;
use App\Jobs\ImportBookFromLovereadJob;
use App\Services\Import\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Request;

class ImportBookController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $job = new ImportBookFromLovereadJob(new BookService(), $request);
        dispatch($job->onQueue('import'));

        return response()->json([], 201);
    }
}
