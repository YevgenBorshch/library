<?php


namespace App\Http\Controllers\Api\Tag;


use App\Exceptions\ApiArgumentException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category_Seria_Tag\UpdateRequest;
use App\Repositories\Interfaces\TagRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Request;

class TagUpdateController extends Controller
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
     * @throws ApiArgumentException
     * @throws ValidationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $tag = Validator::make(
            json_decode($request->getContent(), true),
            (new UpdateRequest())->rules()
        );

        if ($tag->fails()) {
            throw new ApiArgumentException(
                $this->filterErrorMessage(__CLASS__, __LINE__, $request->getContent())
            );
        }

        return response()->json([
            'result' => $this->tagRepository->update($tag->validated())
        ], 202);
    }
}
