<?php

namespace App\Repositories\Eloquent;

use App\Models\Series;
use App\Repositories\Interfaces\SeriesRepositoryInterface;

class SeriesRepository extends BaseRepository implements SeriesRepositoryInterface
{
    /**
     * SeriesRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Series::class);
    }
}
