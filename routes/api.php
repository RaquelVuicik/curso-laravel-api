<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SeriesController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::get('/series', [SeriesController::class, 'index']);

// Route::post('/series', [SeriesController::class, 'store']);

Route::apiResource('/series', SeriesController::class);
Route::get('/series/{series}/seasons', function (\App\Models\Series $series) {
    return $series->seasons;
});

Route::get('/series/{series}/episodes', function (\App\Models\Series $series) {
    return $series->episodes;
});

Route::patch('/episodes/{episode}', function (\App\Models\Episode $episode, Request $request) {
    $episode->watched = $request->watched;
    $episode->save();

    return $episode;
});
