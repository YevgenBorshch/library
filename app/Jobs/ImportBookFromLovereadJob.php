<?php

namespace App\Jobs;

use App\Repositories\Eloquent\BookRepository;
use App\Services\Import\BookServiceInterface;
use App\Services\Import\FileType\PDF;
use App\Services\Import\Parser\Sites\Loveread;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpFoundation\Request;

class ImportBookFromLovereadJob implements ShouldQueue, ShouldBeUnique
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
        $book->fileType = PDF::FILE_TYPE;
        $saveToFile = $this->bookService->saveTo(new PDF(), $book);
        if ($saveToFile) {
            unset($book->context);
            (new BookRepository())->store((array) $book);
        }
    }
}
