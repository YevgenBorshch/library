<?php


namespace App\Repositories\Eloquent;


use App\Exceptions\ApiArgumentException;
use App\Models\Author;
use App\Repositories\Interfaces\AuthorRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method filterErrorMessage(string $string)
 */
class AuthorRepository implements AuthorRepositoryInterface
{
    /**
     * @param array $author
     * @return Author
     */
    public function store(array $author): Author
    {
        return Author::create($author);
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
