<?php

namespace App\Services\Book\Builder\Classes;

class Book
{
    const BOOK_FORM = 1;
    const BOOK_IMPORT = 2;

    const BOOK_SRC = [
        self::BOOK_FORM,
        self::BOOK_IMPORT
    ];

    const IMAGE_BIG = [550, 800];
    const IMAGE_SMALL = [200, 300];

    const IMAGE = [
        'big' => self::IMAGE_BIG,
        'small' => self::IMAGE_SMALL
    ];

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
     * @var string
     */
    public string $filename;

    /**
     * @var string
     */
    public string $fileType;

    /**
     * @var string
     */
    public string $imageType;

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
}
