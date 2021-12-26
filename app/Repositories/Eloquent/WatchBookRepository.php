<?php

namespace App\Repositories\Eloquent;

use App\Models\WatchBook;
use App\Repositories\Interfaces\WatchBookRepositoryInterface;

class WatchBookRepository extends BaseRepository implements WatchBookRepositoryInterface
{
    /**
     * TagRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(WatchBook::class);
    }

}
