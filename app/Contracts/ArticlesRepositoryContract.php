<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface ArticlesRepositoryContract
{
    public function getArticles(array $filters): Builder;

    public function getArticleComments(Article $article, array $filters): Collection;
}
