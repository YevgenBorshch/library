<?php


namespace App\Repositories\Eloquent;


use App\Exceptions\ApiArgumentException;
use App\Models\Author;
use App\Repositories\Interfaces\AuthorRepositoryInterface;
use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;

class AuthorRepository extends BaseRepository implements AuthorRepositoryInterface
{
    /**
     * AuthorRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Author::class);
    }

    /**
     * @param array $author
     * @return Author
     */
    public function store(array $author): Author
    {
        return Author::create($author);
    }

    /**
     * @param array $author
     * @return bool
     * @throws ApiArgumentException
     */
    public function update(array $author): bool
    {
        $authorExist = Author::find($author['id']);

        if (!$authorExist) {
            throw new ApiArgumentException(
                $this->filterErrorMessage('Class: ' . __CLASS__ . '; Line: ' . __LINE__ . '; ' . __('api.id.doesntExist'))
            );
        }

        return $authorExist->update($author);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws ApiArgumentException
     */
    public function list(Request $request)
    {
        $currentPage = $request->get('currentPage', 1);
        $perPage = $request->get('perPage', 10);
        $orderBy = $request->get('orderBy', 'desc');

        if (!$perPage || $perPage < 1 || !Author::validateOrder($orderBy)) {
            throw new ApiArgumentException(
                $this->filterErrorMessage('Class: ' . __CLASS__ . '; Line: ' . __LINE__ . '; ' . __('api.arguments.bad'))
            );
        }

        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        return Author::orderBy('id', $orderBy)->paginate($perPage);
    }
}
