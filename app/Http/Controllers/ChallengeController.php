<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Classe;
use App\Models\Constraint;
use App\Models\Origin;
use App\Models\Position;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $user = Auth::user();

        if ($user) {
            $latestChallenge = Challenge::where('user_id', $user->id)
                ->where('status', 'active')
                ->latest()
                ->first();

            if ($latestChallenge) {
                return redirect()->route('challenge.show', ['id' => $latestChallenge->id]);
            }
        }

        return Inertia::render('Challenge/Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $challenge = Challenge::with(['season', 'position', 'constraint', 'classe', 'origin'])->findOrFail($id);

        return Inertia::render('Challenge/Show', [
            'challenge' => $challenge,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $challenge = Challenge::findOrFail($id);
        $challenge->delete();

        return redirect()->route('homepage')->with('success', 'Challenge deleted');
    }

    public function generate()
    {
        $challenge = [
            'position' => Position::inRandomOrder()->first(),
            'constraint' => Constraint::inRandomOrder()->first(),
            'classe' => Classe::inRandomOrder()->first(),
            'origin' => Origin::inRandomOrder()->first(),
        ];

        return Inertia::render('Challenge/Index', [
            'challenge' => $challenge,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'auth' => [
                'user' => Auth::user(),
            ],
        ]);
    }

    public function accept(Request $request)
    {
        $data = $request->validate([
            'position_id' => 'required|exists:positions,id',
            'classe_id' => 'required|exists:classes,id',
            'origin_id' => 'required|exists:origins,id',
            'constraint_id' => 'required|exists:constraints,id',
        ]);

        $challenge = Challenge::create([
            'position_id' => $data['position_id'],
            'classe_id' => $data['classe_id'],
            'origin_id' => $data['origin_id'],
            'constraint_id' => $data['constraint_id'],
            'season_id' => $this->getCurrentSeason()->id,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('challenge.show', $challenge->id)->with('success', 'Challenge accepted and registered !');
    }

    public function getCurrentSeason()
    {
        return Season::orderBy('id', 'desc')->first();
    }

    public function complete(string $id)
    {
        $user = Auth::user();

        $challenge = Challenge::where('user_id', $user->id)
            ->where('id', $id)
            ->with(['position', 'classe', 'origin', 'constraint'])
            ->firstOrFail();

        $results = [
            'position' => random_int(1, 100) <= 75,
            'classe' => random_int(1, 100) <= 75,
            'origin' => random_int(1, 100) <= 75,
            'constraint' => random_int(1, 100) <= 75,
        ];

        if (in_array(false, $results)) {
            return Inertia::render('Challenge/Fail', [
                'challenge' => $challenge,
                'results' => $results
            ]);
        }

        $challenge->status = 'completed';
        $challenge->save();

        $user->score = $user->score+1;
        $user->save();

        return Inertia::render('Challenge/Success', [
            'challenge' => $challenge,
            'results' => $results
        ]);
    }
}
