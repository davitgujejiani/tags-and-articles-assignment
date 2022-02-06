<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\ArticlesRepositoryContract;

class ArticleService
{
    private ArticlesRepositoryContract $repository;

    public function __construct(ArticlesRepositoryContract $articlesRepositoryContract)
    {
        $this->repository = $articlesRepositoryContract;
    }

    public function articles(array $filters)
    {

        $articles = $this->repository->getArticles($filters);

        if ($filters['paginate']) {
            return $articles->paginate($filters['paginate'], ['*'], 'page', $filters['page']);
        }

        return $articles->get();
    }
}
