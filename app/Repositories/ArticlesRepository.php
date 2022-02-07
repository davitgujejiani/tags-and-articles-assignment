<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\ArticlesRepositoryContract;
use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ArticlesRepository implements ArticlesRepositoryContract
{

    public function getArticles(array $filters): Builder
    {
        return Article::sort($filters)->with('tags');
    }

    public function getArticleComments(Article $article, array $filters): Collection
    {
        return $article->comments()->sort($filters)->get();
    }
}
