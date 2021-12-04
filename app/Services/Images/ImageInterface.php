<?php

namespace App\Services\Images;


use App\Services\Book\Builder\Classes\Book;

interface ImageInterface
{
    /**
     * @param Book $book
     * @return mixed
     */
    public function download(Book $book);
}
