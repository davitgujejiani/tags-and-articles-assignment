<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticlesController extends Controller
{
    public function index(Request $request): Collection|LengthAwarePaginator
    {
        $filters = [
            'sort'     => $request->input('sort') ?? 'created_at',
            'order'    => $request->input('order') ?? 'desc',
            'limit'    => $request->input('limit') ?? '10',
            'paginate' => $request->input('paginate') ?? null,
            'page'     => $request->input('page') ?? 1,
        ];

        $articles = Article::sort($filters)->with('tags');

        if ($filters['paginate']) {
            return $articles->paginate($filters['paginate'], ['*'], 'page', $filters['page']);
        }

        return $articles->get();
    }

    public function comments(Request $request, Article $article): Collection
    {
        $filters = ['order' => $request->input('order') ?? 'desc'];

        return $article->comments()->sort($filters)->get();
    }
}
