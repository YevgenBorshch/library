<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\ApiArgumentException;
use App\Models\Series;
use App\Repositories\Interfaces\SeriesRepositoryInterface;
use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;

class SeriesRepository extends BaseRepository implements SeriesRepositoryInterface
{
    /**
     * SeriesRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Series::class);
    }

    /**
     * @param array $series
     * @return Series
     */
    public function store(array $series): Series
    {
        return Series::create($series);
    }

    /**
     * @param array $series
     * @return bool
     * @throws ApiArgumentException
     */
    public function update(array $series): bool
    {
        $storeExist = Series::find($series['id']);

        if (!$storeExist) {
            throw new ApiArgumentException(
                $this->filterErrorMessage('Class: ' . __CLASS__ . '; Line: ' . __LINE__ . '; ' . __('api.id.doesntExist'))
            );
        }

        return $storeExist->update($series);
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

        if (!$perPage || $perPage < 1 || !Series::validateOrder($orderBy)) {
            throw new ApiArgumentException(
                $this->filterErrorMessage('Class: ' . __CLASS__ . '; Line: ' . __LINE__ . '; ' . __('api.arguments.bad'))
            );
        }

        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        return Series::orderBy('id', $orderBy)->paginate($perPage);
    }
}
