<?php


namespace App\Http\Controllers\Api\Author;


use App\DTO\ListDTO;
use App\Http\Controllers\Controller;
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
     */
    public function __invoke(Request $request): JsonResponse
    {
        $authors = $this->authorRepository->list($request);

        $result = new ListDTO(
            $authors->currentPage(),
            $authors->perPage(),
            $authors->total(),
            $authors->lastPage(),
            $request->get('orderBy', 'desc'),
            $authors->items(),
        );

        return response()->json(['authors' => $result]);
    }
}
