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
        $column = ($filters['sort'] === 'comment_count') ? 'comments_count' : 'created_at';

        return $query->withCount('comments')->orderBy($column, $filters['order'])->take($filters['limit']);
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

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'article_tag',
            'tag_id',
            'article_id',
        );
    }
}
