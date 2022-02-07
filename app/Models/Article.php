<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    protected $hidden = ['pivot'];

    public function scopeSort(Builder $query, array $filters): Builder
    {
        return $query->withCount('comments')->orderBy($filters['sort'], $filters['order'])->take($filters['limit']);
    }

    public function comments(): BelongsToMany
    {
        return $this->belongsToMany(
            Comment::class,
            'article_comment',
            'comment_id',
            'article_id',
        );
    }
}
