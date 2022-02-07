<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\ArticlesRepositoryContract;
use App\Models\Article;

class ArticlesService
{
    private ArticlesRepositoryContract $repository;

    public function __construct(ArticlesRepositoryContract $articlesRepositoryContract)
    {
        $this->repository = $articlesRepositoryContract;
    }

    public function articles(array $requestData)
    {
        // default filter values
        $filters = [
            'sort'     => 'created_at',
            'order'    => 'desc',
            'limit'    => 10,
            'paginate' => null,
            'page'     => 1,
        ];

        $filters = array_merge($filters, $requestData);

        if ($filters['sort'] === 'comment_count') {
            $filters['sort'] = 'comments_count';
        }

        // getting articles from repository
        $articles = $this->repository->getArticles($filters);

        // if paginate is set - return paginated data
        if ($filters['paginate']) {
            return $articles->paginate($filters['paginate'], ['*'], 'page', $filters['page']);
        }

        // return articles data without pagination
        return $articles->get();
    }

    public function articleComments(Article $article, array $filters)
    {
        return $this->repository->getArticleComments($article, $filters);
    }
}
