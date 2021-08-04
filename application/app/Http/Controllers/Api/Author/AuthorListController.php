<?php


namespace App\Http\Controllers\Api\Author;


use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AuthorRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AuthorListController extends Controller
{
    /**
     * @var AuthorRepositoryInterface
     */
    protected AuthorRepositoryInterface $repository;

    /**
     * AuthorController constructor.
     * @param AuthorRepositoryInterface $repository
     */
    public function __construct(AuthorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        return $this->list($request, $this->repository);
    }
}
