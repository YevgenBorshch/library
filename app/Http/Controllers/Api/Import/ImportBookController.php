<?php


namespace App\Http\Controllers\Api\Import;


use App\Http\Controllers\Controller;
use App\Jobs\ImportFromLovereadInPdfJob;
use App\Jobs\ImportFromLovereadInRawJob;
use App\Services\Import\BookService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ImportBookController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function __invoke(Request $request): JsonResponse
    {
        switch ($request->get('type')) {
            case "pdf":
                $job = new ImportFromLovereadInPdfJob(new BookService(), $request);
                break;
            case "raw":
                $job = new ImportFromLovereadInRawJob(new BookService(), $request);
                break;
            default:
                throw new Exception('This field "type" is not valid');
        }

        dispatch($job->onQueue('import'));

        return response()->json([], 201);
    }
}
