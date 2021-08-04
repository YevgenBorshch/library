<?php


namespace App\Http\Controllers\Api\Tag;


use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TagRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TagListController extends Controller
{
    /**
     * @var TagRepositoryInterface
     */
    protected TagRepositoryInterface $repository;

    /**
     * @param TagRepositoryInterface $repository
     */
    public function __construct(TagRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request): JsonResponse
    {
        return $this->list($request, $this->repository);
    }
}
