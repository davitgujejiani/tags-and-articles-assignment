<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $hidden = ['pivot'];

    public function scopeSort(Builder $query, array $filters): Builder
    {
        return $query->orderBy('created_at', $filters['order']);
    }
}
