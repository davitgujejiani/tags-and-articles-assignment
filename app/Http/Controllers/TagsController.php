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
        $validator = validator($request->query(), [
            'sort'     => 'nullable|string|in:article_count,created_at',
            'order'    => 'nullable|string|in:asc,desc',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $tags = $service->tags($validator->validated());

        return response()->json($tags);
    }

    public function articles(Request $request, TagsService $service, Tag $tag): JsonResponse
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

        $articles = $service->tagArticles($tag, $validator->validated());

        return response()->json($articles);
    }
}
