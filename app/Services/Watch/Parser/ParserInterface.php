<?php

namespace App\Services\Watch\Parser;

use App\Models\WatchAuthor;

interface ParserInterface
{
    /**
     * @param string $url
     * @return mixed
     */
    public function parseAuthorInfo(string $url);

    /**
     * @param WatchAuthor $author
     * @return mixed
     */
    public function parseBookList(WatchAuthor $author);
}
