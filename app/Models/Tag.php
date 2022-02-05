<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $hidden = ['pivot'];

    public function scopeWithArticlesCount(Builder $query)
    {
        $query->withCount('articles');
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class)->oldest();
    }
}
