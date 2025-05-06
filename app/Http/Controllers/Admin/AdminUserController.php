<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Season;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class AdminUserController extends Controller
{
    public function index()
    {
        Gate::authorize('is_admin', User::class);

        return Inertia::render('Admin/Index', [
            'seasons' => Season::all(),
        ]);
    }

    public function upsertSeason(Request $request)
    {
        Gate::authorize('is_admin', User::class);

        $validatedData = $request->validate([
            'id' => 'nullable|numeric',
            'name' => 'required|string|max:255',
            'active' => 'required|boolean',
        ]);

        $id = $validatedData['id'];
        if($id){
            $season = Season::findOrFail($id);
            $season->name = $validatedData['name'];
            $season->active = $validatedData['active'];
            $season->save();
        }
        else{
            $season = new Season();
            $season->name = $validatedData['name'];
            $season->active = $validatedData['active'];
            $season->save();
        }

        return redirect()->back();
    }

    public function destroySeason($id){
        Gate::authorize('is_admin', User::class);
        $season = Season::findOrFail($id);
        $season->delete();
        return redirect()->back();
    }


}
