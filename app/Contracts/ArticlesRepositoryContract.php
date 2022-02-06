<?php

declare(strict_types=1);

namespace App\Contracts;

interface ArticlesRepositoryContract
{
    public function getArticles(array $filters);

    public function getArticleComments(array $filters);
}
