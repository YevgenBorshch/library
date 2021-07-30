<?php


namespace App\Http\Controllers\Api\Category;


use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryGetController extends Controller
{
    /**
     * @param Category $category
     * @return JsonResponse
     */
    public function __invoke(Category $category): JsonResponse
    {
        return response()->json(['category' => $category]);
    }
}
