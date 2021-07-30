<?php


namespace App\Http\Controllers\Api\Tag;


use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class TagGetController extends Controller
{
    /**
     * @param Tag $tag
     * @return JsonResponse
     */
    public function __invoke(Tag $tag): JsonResponse
    {
        return response()->json(['tag' => $tag]);
    }
}
