<?php

namespace App\Services\Book\Builder\Interfaces;

use App\Services\Book\Builder\Classes\Book;

interface BookBuilderInterface
{
    /**
     * @return BookBuilderInterface
     */
    public function create(): BookBuilderInterface;

    /**
     * @param string $title
     * @return BookBuilderInterface
     */
    public function setTitle(string $title): BookBuilderInterface;

    /**
     * @param string $author
     * @return BookBuilderInterface
     */
    public function setAuthor(string $author): BookBuilderInterface;

    /**
     * @param string $description
     * @return BookBuilderInterface
     */
    public function setDescription(string $description): BookBuilderInterface;

    /**
     * @param int $pages
     * @return BookBuilderInterface
     */
    public function setPages(int $pages): BookBuilderInterface;

    /**
     * @param string $filename
     * @return BookBuilderInterface
     */
    public function setFilename(string $filename): BookBuilderInterface;

    /**
     * @param string $fileType
     * @return BookBuilderInterface
     */
    public function setFileType(string $fileType): BookBuilderInterface;

    /**
     * @param string $imageType
     * @return BookBuilderInterface
     */
    public function setImageType(string $imageType): BookBuilderInterface;

    /**
     * @param int $year
     * @return BookBuilderInterface
     */
    public function setYear(int $year): BookBuilderInterface;

    /**
     * @param int $src
     * @return BookBuilderInterface
     */
    public function setSource(int $src): BookBuilderInterface;

    /**
     * @return Book
     */
    public function getBook(): Book;
}
