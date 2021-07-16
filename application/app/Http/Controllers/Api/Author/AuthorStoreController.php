<?php


namespace App\Http\Controllers\Api\Author;


use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AuthorRepositoryInterface;

class AuthorStoreController extends Controller
{
    /**
     * @var AuthorRepositoryInterface
     */
    protected AuthorRepositoryInterface $authorRepository;

    /**
     * AuthorController constructor.
     * @param AuthorRepositoryInterface $authorRepository
     */
    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function __invoke()
    {

    }
}
