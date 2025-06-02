<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;


Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/search', [SearchController::class, 'index'])->name('search');
// Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');
Route::get('/news/{slug}', [NewsController::class, 'detail'])->name('news.detail');
Route::get('/author/{username}', [AuthorController::class, 'show'])->name('author.show');
Route::get('/{slug}', [NewsController::class, 'category'])->name('news.category');