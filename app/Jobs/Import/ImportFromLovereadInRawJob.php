<?php

namespace App\Jobs\Import;

use App\Repositories\Eloquent\BookRepository;
use App\Repositories\Eloquent\ContextRepository;
use App\Services\Import\BookServiceInterface;
use App\Services\Import\FileType\Raw;
use App\Services\Import\Parser\Sites\Loveread;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Request;

class ImportFromLovereadInRawJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    public int $timeout = 90;

    /**
     * @var BookServiceInterface
     */
    protected BookServiceInterface $bookService;

    /**
     * @var string
     */
    protected string $url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(BookServiceInterface $bookService, Request $request)
    {
        $this->url = $request->get('url');
        $this->bookService = $bookService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $parser = new Loveread();
        $parser->setUrlToBookInformation($this->url);
        $book = $this->bookService->createBook($parser);
        $book->type = 'raw';

        // Move context to variable
        $context = $book->context;
        unset($book->context);

        $savedBook = (new BookRepository())->store((array) $book);
        $book->id = $savedBook->id;
        $book->context = $context;

        $this->bookService->saveTo(
            new Raw(new ContextRepository()),
            $book
        );
    }
}
