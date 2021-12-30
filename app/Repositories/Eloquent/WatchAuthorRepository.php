<?php

namespace App\Repositories\Eloquent;

use App\Models\WatchAuthor;
use App\Repositories\Interfaces\WatchAuthorRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class WatchAuthorRepository extends BaseRepository implements WatchAuthorRepositoryInterface
{
    /**
     * TagRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(WatchAuthor::class);
    }

    /**
     * @param int $page
     * @param int $limit
     * @return Collection
     */
    public function getWatchAuthors(int $page = 1, int $limit = 1): Collection
    {
        return $this->model::where('active', true)
            ->limit($limit)
            ->offset($page * $limit)
            ->get();
    }
}
