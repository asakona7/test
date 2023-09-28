<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainingTestController;
use App\Http\Controllers\SearchController;

Route::get('/', [TrainingTestController::class, 'index']);


Route::prefix('contacts')->group(function () {
    Route::get('search', [SearchController::class, 'search'])->name('contacts.search');
    Route::post('search', [SearchController::class, 'search']);
    Route::delete('delete/{id}', [SearchController::class, 'destroy']);
});


Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/contacts/delete/{id}', [SearchController::class, 'destroy'])->name('contacts.delete');


Route::post('/contacts/confirm', [TrainingTestController::class, 'confirm']);
Route::post('/contacts', [TrainingTestController::class, 'store']);
