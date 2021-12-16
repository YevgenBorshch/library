<?php
declare( strict_types = 1 );

namespace App\Repositories\Eloquent;

use App\Exceptions\ApiArgumentException;
use App\Models\Book;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use stdClass;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    /**
     * BookRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Book::class);
    }

    /**
     * @param array $value
     * @return Model
     */
    public function store(array $value): Model
    {
        try {
            // Book
            $book = [];
            if (isset($value['category_id'])) {
                $book['category_id'] = $value['category_id'];
            }

            // Series
            if (isset($value['series'])) {
                $seriesModel = (new SeriesRepository())->getOrCreate($value['series']);
                $book['series_id'] = $seriesModel->id;
            }

            $book['current_page'] = 0;
            $book['description'] = $value['description'];
            $book['pages'] = $value['pages'];
            $book['readed'] = 0;
            $book['source'] = 0;
            $book['title'] = $value['title'];
            $book['type'] = $value['type'];
            $book['year'] = $value['year'];

            $savedBook = $this->model::create($book);
            $id = $savedBook->id;

            // Authors
            $arrayAuthorModels = (new AuthorRepository())->getOrCreate(
                $this->preparationAuthors($value['author'])
            );

            foreach ($arrayAuthorModels as $arrayAuthorModel) {
                $savedBook->authors()->attach($arrayAuthorModel->id);
            }

            if (isset($value['file'])) {
                $this->storeFile((array) $value['file'], $id, 'context');
            }

            if (isset($value['image'])) {
                $this->storeFile((array) $value['image'], $id, 'image');
            }

            return $savedBook;
        } catch (\Exception $e) {
            Log::critical(__METHOD__, [__LINE__ => $e->getMessage()]);
        }
        return new Book();
    }

    /**
     * @throws ApiArgumentException
     */
    public function storeFile(array $file, int $bookId, string $type): Model
    {
        $forStore = [
            'book_id' => $bookId,
            'filename' => $file['filename'],
            'image' => $type === 'image' ? 1 : 0,
            'context' => $type === 'context' ? 1 : 0,
            'extension' => $file['extension'],
        ];

        return (new FileRepository())->store($forStore);
    }

    public function preparationAuthors(array $values): stdClass
    {
        $authors = new stdClass();

        // Поля в свойстве field должны содержать имена ключей массивов из свойства values
        foreach ($values as $value) {
            $explode = explode(' ', $value);
            switch (count($explode)) {
                case 2:
                    // Пример: Людмила Мартова
                    $authors->values[] = [
                        'firstname' => $explode[0],
                        'lastname' => $explode[1],
                    ];
                    break;
                case 3:
                    // Пример: Галина Владимировна Романова
                    $authors->values[] = [
                        'firstname' => $explode[0],
                        'lastname' => $explode[2],
                    ];
                    break;
                default:
                    // Пример: Анна и Сергей Литвиновы
                    $lastname = end($explode);
                    $firstname = implode(' ', array_slice($explode, 0, -1));
                    $authors->values[] = [
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                    ];
            }
        }

        return $authors;
    }
}
