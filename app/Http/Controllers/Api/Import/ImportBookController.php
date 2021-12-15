<?php


namespace App\Http\Controllers\Api\Import;


use App\Http\Controllers\Controller;
use App\Jobs\ImportFromLovereadInPdfJob;
use App\Jobs\ImportFromLovereadInRawJob;
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
        $job = new ImportFromLovereadInRawJob(new BookService(), $request);
        dispatch($job->onQueue('import-loveread-raw'));

        return response()->json([], 201);
    }
}
