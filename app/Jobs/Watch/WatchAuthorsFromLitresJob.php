<?php

namespace App\Jobs\Watch;

use App\Jobs\Watch\MessageType\MessageTypeInterface;
use App\Repositories\Eloquent\WatchAuthorRepository;
use App\Repositories\Interfaces\WatchAuthorRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WatchAuthorsFromLitresJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const AMOUNT_AUTHORS_IN_MESSAGE = 2;

    /**
     * @var WatchAuthorRepositoryInterface
     */
    protected WatchAuthorRepositoryInterface $repository;

    /**
     * @var MessageTypeInterface
     */
    protected MessageTypeInterface $message;

    /**
     * @var int
     */
    public int $timeout = 90;

    public function __construct(MessageTypeInterface $message)
    {
        $this->repository = new WatchAuthorRepository();
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
