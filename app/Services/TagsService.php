<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\TagsRepositoryContract;
use App\Models\Tag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TagsService
{
    private TagsRepositoryContract $repository;

    public function __construct(TagsRepositoryContract $tagsRepositoryContract)
    {
        $this->repository = $tagsRepositoryContract;
    }

    public function getTags(array $requestData): Collection
    {
        $defaultFilters = [
            'sort'  => 'articles_count',
            'order' => 'desc',
        ];

        $filters = array_merge($defaultFilters, $requestData);

        if ($filters['sort'] === 'article_count') {
            $filters['sort'] = 'articles_count';
        }

        // fetch tags data and turn it into collection
        $tags = collect($this->repository->getTags($filters));

        // add the oldest article relation created_at attribute to tag collection for sorting purposes
        foreach ($tags as $tag) {
            $tag['created_at'] = $tag->articlesByOldest?->first()?->created_at;
        }

        // sorting logic
        $sortBy = $filters['sort'] === 'created_at' ? 'created_at' : 'articles_count';
        $order = $filters['order'] === 'asc' ? 'asc' : 'desc';
        $tags = $tags->sortBy([[$sortBy, $order]]);

        // remove unnecessary (articles, created_at) data form collection
        foreach ($tags as $key => $tag) {
            $tags[$key] = collect($tag)->forget(['articles_by_oldest', 'created_at']);
        }

        return $tags;
    }

    public function getTagArticles(Tag $tag, array $requestData): Collection|LengthAwarePaginator
    {
        $defaultFilters = [
            'sort'     => 'created_at',
            'order'    => 'desc',
            'limit'    => 10,
            'paginate' => null,
            'page'     => 1,
        ];

        $filters = array_merge($defaultFilters, $requestData);

        if ($filters['sort'] === 'comment_count') {
            $filters['sort'] = 'comments_count';
        }

        $articles = $this->repository->getTagArticles($tag, $filters);

        if ($filters['paginate']) {
            return $articles->paginate($filters['paginate'], ['*'], 'page', $filters['page']);
        }

        return $articles->get();
    }
}
