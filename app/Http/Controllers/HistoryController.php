<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Season;
use App\Models\Classe;
use App\Models\Constraint;
use App\Models\Origin;
use App\Models\Position;


class HistoryController extends Controller
{

    public function getCurrentSeason()
    {
        return Season::where('active', true)->first();
    }


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

        $seasons = Season::all();
        $classes = Classe::all();
        $origins = Origin::all();
        $positions = Position::all();
        $constraints = Constraint::all();

        return Inertia::render('History/Index', [
            'user' => [
                'username' => $user->username,
                'riot_username' => $user->riot_username,
                'score' => $user->score,
                'ranking' => $ranking,
                'profile_photo' =>$user->profile_photo_path,
            ],
            'seasons' => $seasons,
            'classes' => $classes,
            'origins' => $origins,
            'positions' => $positions,
            'constraints' => $constraints,
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
