<?php

namespace App\Repositories\Eloquent;

use App\Models\Queue;
use App\Repositories\Interfaces\QueueRepositoryInterface;

class QueueRepository extends BaseRepository implements QueueRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Queue::class);
    }
}
