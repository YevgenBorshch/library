<?php


namespace App\Http\Controllers\Api\Author;


use App\Exceptions\ApiArgumentException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Author\StoreRequest;
use App\Repositories\Interfaces\AuthorRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthorStoreController extends Controller
{
    /**
     * @var AuthorRepositoryInterface
     */
    protected AuthorRepositoryInterface $authorRepository;

    /**
     * AuthorController constructor.
     * @param AuthorRepositoryInterface $authorRepository
     */
    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ApiArgumentException
     * @throws ValidationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $author = Validator::make(
            json_decode($request->getContent(), true),
            (new StoreRequest())->rules()
        );

        if ($author->fails()) {
            throw new ApiArgumentException(
                $this->filterErrorMessage(__CLASS__, __LINE__, $request->getContent())
            );
        }

        return response()->json([
            'author' => $this->authorRepository->store($author->validated())
        ], 202);
    }
}
