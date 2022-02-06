<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\TagsRepositoryContract;
use App\Models\Tag;

class TagsRepository implements TagsRepositoryContract
{

    public function getTags(array $filters)
    {
        return Tag::withArticlesCount()->with('articlesByOldest')->get();
    }

    public function getTagArticles(Tag $tag, array $filters)
    {
        return $tag->articles()->sort($filters);
    }
}
