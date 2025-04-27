<?php

use App\Http\Controllers\ChallengeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Challenge/Index', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('homepage');
Route::get('/generate-challenge', [ChallengeController::class, 'generate'])->name('generate');
Route::post('/challenge/accept', [ChallengeController::class, 'accept'])->name('accept');


// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/', function () {
//         return Inertia::render('Challenge/Index');
//     })->name('homepage');
// });
