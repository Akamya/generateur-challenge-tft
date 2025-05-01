<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LeaderboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

    $topPlayers = User::select('id', 'username', 'riot_username', 'score')
                      ->orderBy('score', 'desc')
                      ->limit(10)
                      ->get();

    $userRanking = null;
    if ($user) {
        $rank = User::where('score', '>=', $user->score)->count();
        $userRanking = [
            'id' => $user->id,
            'username' => $user->username,
            'riot_username' => $user->riot_username,
            'score' => $user->score,
            'rank' => $rank
        ];
    }

    return Inertia::render('Leaderboard/Index', [
        'topPlayers' => $topPlayers,
        'userRanking' => $userRanking,
        'auth' => [
            'user' => $user,
        ],
    ]);
    }
}
