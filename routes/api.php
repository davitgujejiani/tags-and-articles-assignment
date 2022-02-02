<?php

declare(strict_types=1);

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\TagsController;

Route::get('/articles', [ArticlesController::class, 'index']);
Route::get('/articles/{article}/comments', [ArticlesController::class, 'comments']);

Route::get('/tags', [TagsController::class, 'index']);
Route::get('/tags/{id}/articles', [TagsController::class, 'articles']);
