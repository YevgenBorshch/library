<?php

namespace App\Services\Images;


use App\Services\Book\Builder\Classes\Book;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class ImageService implements ImageInterface
{
    const LOVEREAD_HOST = 'http://loveread.ec/';

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function download(Book $book): void
    {
        $client = new Client();
        $response = $client->request('GET', self::LOVEREAD_HOST . $book->urlToImage, ['sink' => '/tmp/' . $book->filename]);

        if (200 === $response->getStatusCode()) {
            self::store($book);
        }
    }

    /**
     * @throws Exception
     */
    public static function store(Book $book): void
    {
        try {
            $size = Book::IMAGE;
            $image = Image::make('/tmp/' . $book->filename);

            $image_s = $image->resize($size['small'][0], null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image_s->save(public_path('images/books/s_') . $book->filename . '.' . $book->imageType, 100);

            if (file_exists('/tmp/' . $book->filename)) {
                unlink('/tmp/' . $book->filename);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}
