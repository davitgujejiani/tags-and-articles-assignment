<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\TagsRepositoryContract;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class TagsRepository implements TagsRepositoryContract
{

    public function getTags(array $filters): Collection
    {
        return Tag::withArticlesCount()->with('articlesByOldest')->get();
    }

    public function getTagArticles(Tag $tag, array $filters): BelongsToMany
    {
        return $tag->articles()->sort($filters);
    }
}
