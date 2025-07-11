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
use Illuminate\Support\Facades\Storage;


class AdminUserController extends Controller
{
    public function index()
    {
        Gate::authorize('is_admin', User::class);

        return Inertia::render('Admin/Index', [
            'seasons' => Season::all(),
            'classes' => Classe::with(['season'])->get(),
            'origins' => Origin::with(['season'])->get(),
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
            'image' => 'nullable|image|max:2048',
            'delete_image' => 'nullable|boolean',
        ]);

        $id = $validatedData['id'];
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('classes', 'public');
        }

        if($id){
            $classe = Classe::findOrFail($id);
            $classe->name = $validatedData['name'];
            $classe->technical_name = $validatedData['technical_name'];
            $classe->description = 'Reach level bronze';
            $classe->season_id = $validatedData['season_id'];

            // Supprimer l’image existante si demandé
            if ($request->boolean('delete_image') && $classe->image) {
                Storage::disk('public')->delete($classe->image);
                $classe->image = null;
            }

            // Remplacer l’image si une nouvelle est uploadée
            if ($imagePath) {
                // Supprimer l’ancienne image si elle existe
                if ($classe->image) {
                    Storage::disk('public')->delete($classe->image);
                }
                $classe->image = $imagePath;
            }

            $classe->save();
        }
        else{
            $classe = new Classe();
            $classe->name = $validatedData['name'];
            $classe->technical_name = $validatedData['technical_name'];
            $classe->description = 'Reach level bronze';
            $classe->season_id = $validatedData['season_id'];
            $classe->image = $imagePath;
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
            'technical_name' => 'required|string|max:255',
            'season_id' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
            'delete_image' => 'nullable|boolean',
        ]);

        $id = $validatedData['id'];
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('origins', 'public');
        }

        if ($id) {
            $origin = Origin::findOrFail($id);
            $origin->name = $validatedData['name'];
            $origin->technical_name = $validatedData['technical_name'];
            $origin->description = 'Reach level gold';
            $origin->season_id = $validatedData['season_id'];

            // Supprimer l’image existante si demandé
            if ($request->boolean('delete_image') && $origin->image) {
                Storage::disk('public')->delete($origin->image);
                $origin->image = null;
            }

            // Remplacer l’image si une nouvelle est uploadée
            if ($imagePath) {
                // Supprimer l’ancienne image si elle existe
                if ($origin->image) {
                    Storage::disk('public')->delete($origin->image);
                }
                $origin->image = $imagePath;
            }

            $origin->save();
        } else {
            $origin = new Origin();
            $origin->name = $validatedData['name'];
            $origin->technical_name = $validatedData['technical_name'];
            $origin->description = 'Reach level gold';
            $origin->season_id = $validatedData['season_id'];
            $origin->image = $imagePath;
            $origin->save();
        }

        return redirect()->back();
    }


    public function destroySeason($id){
        Gate::authorize('is_admin', User::class);
        $season = Season::findOrFail($id);
        $season->delete();
        return redirect()->back();
    }

    public function destroyClasse($id){
        Gate::authorize('is_admin', User::class);
        $classe = Classe::findOrFail($id);
        $classe->delete();
        return redirect()->back();
    }

    public function destroyOrigin($id){
        Gate::authorize('is_admin', User::class);
        $origin = Origin::findOrFail($id);
        $origin->delete();
        return redirect()->back();
    }
}
