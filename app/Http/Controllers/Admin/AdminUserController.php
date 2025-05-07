<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Origin;
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
            'classes' => Classe::with(['season'])->get(),
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

    public function upsertClasse(Request $request)
    {
        Gate::authorize('is_admin', User::class);

        $validatedData = $request->validate([
            'id' => 'nullable|numeric',
            'name' => 'required|string|max:255',
            'technical_name' => 'required|string|max:255',
            'season_id' => 'required|numeric',
        ]);

        $id = $validatedData['id'];
        if($id){
            $classe = Classe::findOrFail($id);
            $classe->name = $validatedData['name'];
            $classe->technical_name = $validatedData['technical_name'];
            $classe->description = 'Reach level bronze';
            $classe->season_id = $validatedData['season_id'];
            $classe->save();
        }
        else{
            $classe = new Classe();
            $classe->name = $validatedData['name'];
            $classe->technical_name = $validatedData['technical_name'];
            $classe->description = 'Reach level bronze';
            $classe->season_id = $validatedData['season_id'];
            $classe->save();
        }

        return redirect()->back();
    }

    public function upsertOrigin(Request $request)
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

    public function destroyClasses($id){
        Gate::authorize('is_admin', User::class);
        $classe = Classe::findOrFail($id);
        $classe->delete();
        return redirect()->back();
    }

    public function destroyOrigins($id){
        Gate::authorize('is_admin', User::class);
        $origin = Origin::findOrFail($id);
        $origin->delete();
        return redirect()->back();
    }


}
