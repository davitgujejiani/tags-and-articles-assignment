<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticlesService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function index(Request $request, ArticlesService $service): JsonResponse
    {
        $validator = validator($request->query(), [
            'sort'     => 'nullable|string|in:comment_count,created_at',
            'order'    => 'nullable|string|in:asc,desc',
            'limit'    => 'nullable|integer',
            'paginate' => 'nullable|integer',
            'page'     => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $articles = $service->articles($validator->validated());

        return response()->json($articles);
    }

    public function comments(Request $request, ArticlesService $service, Article $article): JsonResponse
    {
        $validator = validator($request->query(), [
            'order' => 'nullable|string|in:asc,desc',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $comments = $service->articleComments($article, $validator->validated());

        return response()->json($comments);
    }
}
