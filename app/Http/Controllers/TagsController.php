<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Services\TagsService;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index(Request $request, TagsService $service)
    {
        $filters = [
            'sort'  => $request->input('sort') ?? 'article_count',
            'order' => $request->input('order') ?? 'desc',
        ];

        return $service->tags($filters);
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
