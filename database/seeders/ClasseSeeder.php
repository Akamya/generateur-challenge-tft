<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Season;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            'A.M.P',
            'Bastion',
            'Bruiser',
            'Dynamo',
            'Executioner',
            'Marksman',
            'Rapidfire',
            'Slayer',
            'Strategist',
            'Techie',
            'Vanguard',
        ];

        foreach ($classes as $name) {
            Classe::create([
                'name' => $name,
                'season_id' => Season::first()->id
            ]);
        }
    }
}
