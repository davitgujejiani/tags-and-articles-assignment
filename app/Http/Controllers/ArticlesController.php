<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticlesService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticlesController extends Controller
{
    public function index(Request $request, ArticlesService $service): Collection|LengthAwarePaginator
    {
        $filters = [
            'sort'     => $request->input('sort') ?? 'created_at',
            'order'    => $request->input('order') ?? 'desc',
            'limit'    => $request->input('limit') ?? '10',
            'paginate' => $request->input('paginate') ?? null,
            'page'     => $request->input('page') ?? 1,
        ];

        return $service->articles($filters);
    }

    public function comments(Request $request, ArticlesService $service, Article $article): Collection
    {
        $filters = ['order' => $request->input('order') ?? 'desc'];

        return $service->articleComments($article, $filters);
    }
}
