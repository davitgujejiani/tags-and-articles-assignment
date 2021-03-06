<?php

declare(strict_types=1);

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\TagsController;

Route::get('/articles', [ArticlesController::class, 'index']);
Route::get('/articles/{article}/comments', [ArticlesController::class, 'articleComments']);

Route::get('/tags', [TagsController::class, 'index']);
Route::get('/tags/{tag}/articles', [TagsController::class, 'tagArticles']);
