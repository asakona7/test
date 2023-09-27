<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainingTestController;
use App\Http\Controllers\SearchController;

Route::get('/', [TrainingTestController::class, 'index']);

// 検索関連のルート
Route::prefix('contacts')->group(function () {
    Route::get('search', [SearchController::class, 'search'])->name('contacts.search');
    Route::post('search', [SearchController::class, 'search']);
    Route::delete('delete/{id}', [SearchController::class, 'destroy']);
});

// 検索結果表示ページのルート
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/contacts/delete/{id}', [SearchController::class, 'destroy'])->name('contacts.delete');

// その他のルート
Route::post('/contacts/confirm', [TrainingTestController::class, 'confirm']);
Route::post('/contacts', [TrainingTestController::class, 'store']);
