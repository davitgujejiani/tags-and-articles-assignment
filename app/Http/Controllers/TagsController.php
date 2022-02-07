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

    public function articles(Request $request, TagsService $service, Tag $tag)
    {
        $filters = [
            'sort'     => $request->input('sort') ?? 'created_at',
            'order'    => $request->input('order') ?? 'desc',
            'limit'    => $request->input('limit') ?? '10',
            'paginate' => $request->input('paginate') ?? null,
            'page'     => $request->input('page') ?? 1,
        ];

        return $service->articleComments($tag, $filters);
    }
}
