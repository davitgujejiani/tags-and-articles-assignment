<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\ArticlesRepositoryContract;
use App\Models\Article;

class ArticlesRepository implements ArticlesRepositoryContract
{

    public function getArticles(array $filters)
    {
        return Article::sort($filters)->with('tags');
    }

    public function getArticleComments(Article $article, array $filters)
    {
        return $article->comments()->sort($filters)->get();
    }
}
