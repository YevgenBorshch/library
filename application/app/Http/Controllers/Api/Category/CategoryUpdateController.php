<?php


namespace App\Http\Controllers\Api\Category;


use App\Exceptions\ApiArgumentException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category_Seria_Tag\UpdateRequest;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Request;

class CategoryUpdateController extends Controller
{
    /**
     * @var CategoryRepositoryInterface
     */
    protected CategoryRepositoryInterface $categoryRepository;

    /**
     * AuthorController constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ApiArgumentException
     * @throws ValidationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $category = Validator::make(
            json_decode($request->getContent(), true),
            (new UpdateRequest())->rules()
        );

        if ($category->fails()) {
            throw new ApiArgumentException(
                $this->filterErrorMessage(__CLASS__, __LINE__, $request->getContent())
            );
        }

        return response()->json([
            'result' => $this->categoryRepository->update($category->validated())
        ], 202);
    }
}
