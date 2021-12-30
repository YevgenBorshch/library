<?php

namespace App\Services\Watch\Parser\Sites;

use App\Models\WatchAuthor;
use App\Services\Watch\Parser\ParserInterface;

class Litres implements ParserInterface
{
    /**
     * @param string $url
     */
    public function parseAuthorInfo(string $url): void
    {
        //
    }

    /**
     * @param WatchAuthor $author
     */
    public function parseBookList(WatchAuthor $author): void
    {
        //
    }
}
