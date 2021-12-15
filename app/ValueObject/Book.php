<?php

namespace App\ValueObject;

/**
 * @property $filename
 */
class Book
{
    const BOOK_FORM = 1;
    const BOOK_IMPORT = 2;

    const BOOK_SRC = [
        self::BOOK_FORM,
        self::BOOK_IMPORT
    ];

    /**
     * @var int
     */
    public int $id;

    /**
     * @var array
     */
    public array $author = [];

    /**
     * @var array
     */
    public array $context;

    /**
     * @var string
     */
    public string $description;

    /**
     * @var int
     */
    public int $pages = 0;

    /**
     * @var string
     */
    public string $series;

    /**
     * @var int
     */
    public int $source;

    /**
     * @var string
     */
    public string $title;

    /**
     * @return string
     */
    public string $urlToContext;

    /**
     * @var string
     */
    public string $urlToImage;

    /**
     * @var int
     */
    public int $year;

    /**
     * @var File
     */
    public File $file;

    /**
     * @var Image
     */
    public Image $image;
}
