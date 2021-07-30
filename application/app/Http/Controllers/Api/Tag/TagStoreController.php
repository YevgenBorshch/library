<?php


namespace App\Http\Controllers\Api\Tag;


use App\Exceptions\ApiArgumentException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category_Seria_Tag\StoreRequest;
use App\Repositories\Interfaces\TagRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Request;

class TagStoreController extends Controller
{
    /**
     * @var TagRepositoryInterface
     */
    protected TagRepositoryInterface $tagRepository;

    /**
     * TagStoreController constructor.
     * @param TagRepositoryInterface $tagRepository
     */
    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws ApiArgumentException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $tag = Validator::make(
            json_decode($request->getContent(), true),
            (new StoreRequest())->rules()
        );

        if ($tag->fails()) {
            throw new ApiArgumentException(
                $this->filterErrorMessage('Class: ' . __CLASS__ . '; Line: ' . __LINE__ . '; ' . __('api.arguments.bad') . '; Context: ' . $request->getContent())
            );
        }

        return response()->json([
            'tag' => $this->tagRepository->store($tag->validated())
        ], 202);
    }
}
