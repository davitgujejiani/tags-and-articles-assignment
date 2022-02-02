<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'sort'     => $request->input('sort') ?? 'created_at',
            'order'    => $request->input('order') ?? 'desc',
            'limit'    => $request->input('limit') ?? '10',
            'paginate' => $request->input('paginate') ?? null,
            'page'     => $request->input('page') ?? 1,
        ];

        return Article::sort($filters)->get();
    }

    public function comments()
    {
        // todo: return comments
    }
}
