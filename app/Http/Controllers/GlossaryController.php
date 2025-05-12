<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Constraint;
use App\Models\Origin;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class GlossaryController extends Controller
{
    public function index()
    {
        return Inertia::render('Glossary/Index', [
            'origins' => Origin::all(),
            'positions' => Position::all(),
            'classes' => Classe::all(),
            'constraints' => Constraint::all(),
            'auth' => [
                'user' => Auth::user(),
            ],
        ]);
    }
}
