<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Tag;

interface TagsRepositoryContract
{
    public function getTags(array $filters);

    public function getTagArticles(Tag $tag, array $filters);
}
