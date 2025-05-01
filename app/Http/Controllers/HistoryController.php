<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\User;
use Illuminate\Http\Request;
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

    public function search(Request $request)
    {
        $query = $request->input('query');

        $searchResults = [];

        if (!empty($query) && strlen($query) >= 2) {
            $searchResults = User::where('username', 'like', "%{$query}%")
                ->orWhere('riot_username', 'like', "%{$query}%")
                ->select('id', 'username', 'riot_username')
                ->limit(10)
                ->get();

            return response()->json(['searchResults' => $searchResults]);
        }

        return response()->json(['searchResults' => []]);
    }
}
