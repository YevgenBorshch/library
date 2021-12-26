<?php

namespace App\Services\Watch;

use App\Models\WatchAuthor;

interface WatchServiceInterface
{
    /**
     * @param WatchAuthor $author
     * @return mixed
     */
    public function run(WatchAuthor $author);
}
