<?php


namespace App\Services\Import;


use App\Services\Book\Builder\Classes\Book;
use App\Services\Import\FileType\FileTypeInterface;
use App\Services\Import\Parser\ParserInterface;

interface BookServiceInterface
{
    /**
     * @param ParserInterface $parser
     * @return Book
     */
    public function createBook(ParserInterface $parser): Book;

    /**
     * @param FileTypeInterface $fileType
     * @param Book $book
     * @return bool
     */
    public function saveTo(FileTypeInterface $fileType, Book $book): bool;
}
