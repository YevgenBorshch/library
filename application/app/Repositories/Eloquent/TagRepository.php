<?php


namespace App\Repositories\Eloquent;


use App\Exceptions\ApiArgumentException;
use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;
use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;

class TagRepository extends BaseRepository implements TagRepositoryInterface
{
    /**
     * TagRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Tag::class);
    }

    /**
     * @param array $tag
     * @return Tag
     */
    public function store(array $tag): Tag
    {
        return Tag::create($tag);
    }

    /**
     * @param array $tag
     * @return bool
     * @throws ApiArgumentException
     */
    public function update(array $tag): bool
    {
        $tagExist = Tag::find($tag['id']);

        if (!$tagExist) {
            throw new ApiArgumentException(
                $this->filterErrorMessage('Class: ' . __CLASS__ . '; Line: ' . __LINE__ . '; ' . __('api.id.doesntExist'))
            );
        }

        return $tagExist->update($tag);
    }

    /**
     * @throws ApiArgumentException
     */
    public function list(Request $request)
    {
        $currentPage = $request->get('currentPage', 1);
        $perPage = $request->get('perPage', 10);
        $orderBy = $request->get('orderBy', 'desc');

        if (!$perPage || $perPage < 1 || !Tag::validateOrder($orderBy)) {
            throw new ApiArgumentException(
                $this->filterErrorMessage('Class: ' . __CLASS__ . '; Line: ' . __LINE__ . '; ' . __('api.arguments.bad'))
            );
        }

        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        return Tag::orderBy('id', $orderBy)->paginate($perPage);
    }
}
