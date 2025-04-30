<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Classe;
use App\Models\Constraint;
use App\Models\Origin;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HistoryController extends Controller
{
    public function index(string $userID)
    {
        $user = User::findOrFail($userID);
        $ranking = User::where('score', '>=', $user->score)->count();
        $currentChallenge = Challenge::with(['position', 'classe', 'origin', 'constraint'])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();
        $completedChallenges = Challenge::with(['position', 'classe', 'origin', 'constraint'])
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->get();

        return Inertia::render('History/Index', [
            'user' => [
                'username' => $user->username,
                'riot_username' => $user->riot_username,
                'score' => $user->score,
                'ranking' => $ranking,
                'profile_photo' =>$user->profile_photo_path,
            ],
            'currentChallenge' => $currentChallenge,
            'completedChallenges' => $completedChallenges,
        ]);
    }
}
