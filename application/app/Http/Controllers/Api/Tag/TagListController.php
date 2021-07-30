<?php


namespace App\Http\Controllers\Api\Tag;


use App\DTO\ListDTO;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TagRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TagListController extends Controller
{
    /**
     * @var TagRepositoryInterface
     */
    protected TagRepositoryInterface $tagRepository;

    /**
     * @param TagRepositoryInterface $tagRepository
     */
    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $tags = $this->tagRepository->list($request);

        $result = new ListDTO(
            $tags->currentPage(),
            $tags->perPage(),
            $tags->total(),
            $tags->lastPage(),
            $request->get('orderBy', 'desc'),
            $tags->items(),
        );

        return response()->json(['tags' => $result]);
    }
}
