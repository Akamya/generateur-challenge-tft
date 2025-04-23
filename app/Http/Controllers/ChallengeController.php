<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Formation;
use App\Models\Origin;
use App\Models\Position;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
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
        //
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
        //
    }

    public function generate()
    {
        $challenge = [
            'position' => Position::inRandomOrder()->first(),
            // 'formation' => Formation::inRandomOrder()->first(),
            'class' => Classe::inRandomOrder()->first(),
            'origin' => Origin::inRandomOrder()->first(),
        ];

        return Inertia::render('Challenge/Index', [
            'challenge' => $challenge,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

}
