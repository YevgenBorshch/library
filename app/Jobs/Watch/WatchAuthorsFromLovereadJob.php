<?php

namespace App\Jobs\Watch;

use App\Jobs\Watch\MessageType\MessageTypeInterface;
use App\Jobs\Watch\MessageType\Watch;
use App\Models\WatchAuthor;
use App\Repositories\Eloquent\WatchAuthorRepository;
use App\Repositories\Interfaces\WatchAuthorRepositoryInterface;
use App\Services\Watch\WatchService;
use App\Services\Watch\WatchServiceInterface;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WatchAuthorsFromLovereadJob implements ShouldQueue
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
     * @throws Exception
     */
    public function handle()
    {
        switch ($this->message->type) {
            case 'preparation':
                $this->preparation();
                break;
            case 'watch':
                $this->watch();
                break;
            default:
                throw new Exception('Invalid type of message in watch queue');
        }
    }

    protected function preparation()
    {
        $countAuthors = WatchAuthor::count();
        $countMessages = ceil($countAuthors/self::AMOUNT_AUTHORS_IN_MESSAGE);

        for ($page = 0; $page < $countMessages; $page++) {
            $message = new Watch();
            $message->type = 'watch';
            $message->data = $this->repository->getWatchAuthors($page, self::AMOUNT_AUTHORS_IN_MESSAGE);
            $job = new WatchAuthorsFromLovereadJob($message);
            dispatch($job->onQueue('watch'));
        }
    }

    protected function watch()
    {
        foreach ($this->message->data as $author) {
            $watchService = new WatchService();
            $watchService->run($author);
        }
    }
}
