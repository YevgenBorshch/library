<?php


namespace App\Http\Controllers\Api\Author;


use App\DTO\ListDTO;
use App\Exceptions\ApiArgumentException;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Repositories\Interfaces\AuthorRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AuthorListController extends Controller
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
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request = json_decode($request->getContent(), true);
        $perPage = $request['perPage'] ?? 10;
        $orderBy = $request['orderBy'] ?? 'desc';

        if (!$perPage || $perPage < 0 || !Author::validateOrder($orderBy)) {
            throw new ApiArgumentException(
                $this->filterErrorMessage('Class: ' . __CLASS__ . '; Line: ' . __LINE__ . '; ' . __('api.arguments.bad'))
            );
        }

        $authors = $this->authorRepository->list($perPage, $orderBy);

        $result = new ListDTO(
            $authors->currentPage(),
            $authors->perPage(),
            $authors->total(),
            $authors->lastPage(),
            $orderBy,
            $authors->items(),
        );

        return response()->json(['authors' => $result]);
    }
}
