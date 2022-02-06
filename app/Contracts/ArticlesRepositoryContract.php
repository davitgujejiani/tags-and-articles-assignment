<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Article;

interface ArticlesRepositoryContract
{
    public function getArticles(array $filters);

    public function getArticleComments(Article $article, array $filters);
}
