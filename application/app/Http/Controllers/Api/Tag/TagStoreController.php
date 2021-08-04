<?php


namespace App\Http\Controllers\Api\Tag;


use App\Exceptions\ApiArgumentException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category_Series_Tag\StoreRequest;
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
    protected TagRepositoryInterface $repository;

    /**
     * TagStoreController constructor.
     * @param TagRepositoryInterface $repository
     */
    public function __construct(TagRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws ApiArgumentException
     */
    public function __invoke(Request $request): JsonResponse
    {
        return $this->store($request, $this->repository);
    }
}
