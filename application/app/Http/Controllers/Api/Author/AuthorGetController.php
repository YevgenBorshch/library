<?php


namespace App\Http\Controllers\Api\Author;


use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Repositories\Interfaces\AuthorRepositoryInterface;
use Illuminate\Http\JsonResponse;

class AuthorGetController extends Controller
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

    /**
     * @param Author $author
     * @return JsonResponse
     */
    public function __invoke(Author $author): JsonResponse
    {
        return response()->json(['author' => $author]);
    }
}
