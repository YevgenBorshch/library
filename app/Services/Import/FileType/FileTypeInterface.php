<?php

namespace App\Services\Import\FileType;

use App\Services\Book\Builder\Classes\Book;

interface FileTypeInterface
{
    /**
     * @param Book $book
     * @return bool
     */
    public function save(Book &$book): bool;
}
