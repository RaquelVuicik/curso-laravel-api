<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SeriesController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
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
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    
    if (Auth::attempt($credentials) === false) {
        return response()->json('Unauthorized', 401);
    }

    $user = Auth::user();
    $user->tokens()->delete();
    $token = $user->createToken('token', ['is_admin']);

    return response()->json($token->plainTextToken);
});

Route::get('/gerar-senha', function () {
    $user = User::create([
        'name' => 'Lucas',
        'email' => 'lucas@email.com',
        'password' => bcrypt('123456'),
    ]);

    return $user;
});
