<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\GlossaryController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ChallengeController::class, 'index'])->name('homepage');
Route::get('/challenge/generate', [ChallengeController::class, 'generate'])->name('challenge.generate');

Route::get('/glossary', [GlossaryController::class, 'index'])->name('glossary');

Route::get('/user/search', [HistoryController::class, 'search'])->name('user.search');
Route::get('/history/{userID}', [HistoryController::class, 'index'])->name('history');

Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::post('/challenge/accept', [ChallengeController::class, 'accept'])->name('challenge.accept');
    Route::get('/challenge/{id}', [ChallengeController::class, 'show'])->name('challenge.show');
    Route::get('/challenge/{id}/complete', [ChallengeController::class, 'index']);
    Route::post('/challenge/{id}/complete', [ChallengeController::class, 'complete'])->name('challenge.complete');
    Route::delete('/challenge/{id}/delete', [ChallengeController::class, 'destroy'])->name('challenge.destroy');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/index', [AdminUserController::class, "index"])->name('admin.index');
    Route::put('/season/upsert', [AdminUserController::class, "upsertSeason"])->name('admin.season.upsert');
    Route::put('/classe/upsert', [AdminUserController::class, "upsertClasse"])->name('admin.classe.upsert');
    Route::put('/origin/upsert', [AdminUserController::class, "upsertOrigin"])->name('admin.origin.upsert');
    Route::delete('/season/{id}/delete', [AdminUserController::class, "destroySeason"])->name('admin.season.delete');
    Route::delete('/classe/{id}/delete', [AdminUserController::class, "destroyClasse"])->name('admin.classe.delete');
    Route::delete('/origin/{id}/delete', [AdminUserController::class, "destroyOrigin"])->name('admin.origin.delete');
});
