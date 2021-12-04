<?php

namespace App\Services\Import\FileType;

use App\Services\Book\Builder\Classes\Book;

class Html implements FileTypeInterface
{
    const FILE_TYPE = 'html';

    /**
     * @param Book $book
     * @return bool
     */
    public function save(Book $book): bool
    {
        return true;
    }
}
