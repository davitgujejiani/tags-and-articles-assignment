<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Services\TagsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index(Request $request, TagsService $service): JsonResponse
    {
        $requestData = validator($request->query(), [
            'sort'  => 'nullable|string|in:article_count,created_at',
            'order' => 'nullable|string|in:asc,desc',
        ]);

        if ($requestData->fails()) {
            return response()->json($requestData->messages(), 400);
        }

        $tagsData = $service->getTags($requestData->validated());

        return response()->json($tagsData);
    }

    public function tagArticles(Request $request, TagsService $service, Tag $tag): JsonResponse
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

        $tagArticlesData = $service->getTagArticles($tag, $requestData->validated());

        return response()->json($tagArticlesData);
    }
}
