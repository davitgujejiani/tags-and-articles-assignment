<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticlesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function index(Request $request, ArticlesService $service): JsonResponse
    {
        $requestData = validator($request->query(), [
            'sort'     => 'nullable|string|in:comment_count,created_at',
            'order'    => 'nullable|string|in:asc,desc',
            'limit'    => 'nullable|integer',
            'paginate' => 'nullable|integer',
            'page'     => 'nullable|integer',
        ]);

        if ($requestData->fails()) {
            return response()->json($requestData->messages(), 400);
        }

        $articlesData = $service->getArticles($requestData->validated());

        return response()->json($articlesData);
    }

    public function articleComments(Request $request, ArticlesService $service, Article $article): JsonResponse
    {
        $requestData = validator($request->query(), [
            'order' => 'nullable|string|in:asc,desc',
        ]);

        if ($requestData->fails()) {
            return response()->json($requestData->messages(), 400);
        }

        $articleCommentsData = $service->getArticleComments($article, $requestData->validated());

        return response()->json($articleCommentsData);
    }
}
