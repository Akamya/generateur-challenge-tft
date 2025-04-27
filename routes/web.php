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
Route::get('/challenge/generate', [ChallengeController::class, 'generate'])->name('challenge.generate');
Route::post('/challenge/accept', [ChallengeController::class, 'accept'])->name('challenge.accept');
Route::get('/challenge/{id}', [ChallengeController::class, 'show'])->name('challenge.show');
Route::post('/challenge/{id}/complete', [ChallengeController::class, 'markAsCompleted'])->name('challenge.complete');
Route::post('/challenge/{id}/cancel', [ChallengeController::class, 'cancel'])->name('challenge.cancel');


// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/', function () {
//         return Inertia::render('Challenge/Index');
//     })->name('homepage');
// });
