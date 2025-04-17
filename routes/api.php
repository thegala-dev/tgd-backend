<?php

use App\Domains\Articles\Http\Controllers\ArticleController;
use App\Http\Middleware\EnsureJsonHeaders;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureJsonHeaders::class)->group(function () {
    Route::prefix('articles')
        ->name('articles.')
        ->group(function () {
            Route::get('/', [ArticleController::class, 'index'])
                ->name('index');

            Route::get('/{category}', [ArticleController::class, 'byCategory'])
                ->name('by-category');
        });
});
