<?php

namespace App\Services\Images;


use App\Traits\FileNameGenerate;
use App\ValueObject\Book;
use App\ValueObject\Image;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Imagick;

class ImageService implements ImageInterface
{
    use FileNameGenerate;

    /**
     * @var string
     */
    public string $source = '';

    /**
     * @var string
     */
    public string $filename;

    /**
     * @param string $source
     */
    public function __construct(string $source)
    {
        $this->source = $source;
        $this->filename = $this->getFileName();
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function download(Book $book): void
    {
        $response = (new Client())->request(
            'GET',
            $this->source . $book->urlToImage,
            [
                'sink' => '/tmp/' . $this->filename
            ]
        );

        if (200 === $response->getStatusCode()) {
            $this->store($book);
        }
    }

    /**
     * @throws Exception
     */
    public function store(Book $book): void
    {
        try {
            $imagick = new Imagick();
            $imagick->readImage('/tmp/' . $this->filename);

            $book->image = new Image();
            $book->image->width = $imagick->getImageWidth();
            $book->image->height = $imagick->getImageHeight();
            $book->image->size = $imagick->getImageLength();
            $book->image->extension = strtolower($imagick->getImageFormat());
            $book->image->isVertical = $imagick->getImageWidth() < $imagick->getImageHeight();
            $book->image->filename = $this->filename;
            $path = public_path('/images/books/') . $book->image->filename . '.' . $book->image->extension;

            if ($book->image->size > $book->image::MAX_IMAGE_SIZE_IN_BYTE) {
                throw new Exception('Image filesize must be less, than ' . $book->image::MAX_IMAGE_SIZE_IN_BYTE / (1024 * 1024) . ' byte');
            }

            if (!in_array($book->image->extension, $book->image::EXTENSIONS)) {
                throw new Exception('Image must be with next extension: ' . $book->image->extensionsToString(1));
            }

            if ($imagick->getImageHeight() > $book->image::MAX_HEIGHT && $imagick->getImageWidth() > $book->image::MAX_WIDTH) {
                $imagick->scaleImage($book->image::MAX_WIDTH * !$book->image->isVertical, $book->image::MAX_HEIGHT * $book->image->isVertical);
            }

            $imagick->writeImage($path);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}
