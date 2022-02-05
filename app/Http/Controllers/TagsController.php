<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'sort'  => $request->input('sort') ?? 'article_count',
            'order' => $request->input('order') ?? 'desc',
        ];

        // fetch tags data and turn it into collection
        $tags = collect(Tag::withArticlesCount()->with('articles')->get());

        // add the oldest article relation created_at attribute to tag collection for sorting purposes
        foreach ($tags as $tag) {
            $tag['created_at'] = $tag->articles?->first()?->created_at;
        }

        // sorting logic
        $sortBy = $filters['sort'] === 'created_at' ? 'created_at' : 'articles_count';
        $order = $filters['order'] === 'asc' ? 'asc' : 'desc';
        $tags = $tags->sortBy([[$sortBy, $order]]);

        // remove articles and created_at data form collection
        foreach ($tags as $key => $tag) {
            $tags[$key] = collect($tag)->forget(['articles', 'created_at']);
        }

        return $tags;
    }

    public function articles()
    {
        // todo: return articles by tags
    }
}
