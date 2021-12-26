<?php

namespace App\Repositories\Eloquent;

use App\Models\WatchSeries;
use App\Repositories\Interfaces\WatchSeriesRepositoryInterface;

class WatchSeriesRepository extends BaseRepository implements WatchSeriesRepositoryInterface
{
    /**
     * TagRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(WatchSeries::class);
    }

    /**
     * @param int $seriesId
     * @return mixed
     */
    public function isExist(int $seriesId)
    {
        return $this->model::where('series_id', $seriesId)->count();
    }
}
