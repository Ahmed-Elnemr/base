<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\BlogPostController;

Route::prefix('v1')->group(function () {
    Route::get('blog-posts', [BlogPostController::class, 'index'])->name('api.blog-posts.index');
    Route::get('blog-posts/{slug}', [BlogPostController::class, 'show'])->name('api.blog-posts.show');
});
