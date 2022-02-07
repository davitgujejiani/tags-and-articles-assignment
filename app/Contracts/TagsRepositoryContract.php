<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

interface TagsRepositoryContract
{
    public function getTags(array $filters): Collection;

    public function getTagArticles(Tag $tag, array $filters): BelongsToMany;
}
