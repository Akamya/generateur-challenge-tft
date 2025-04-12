<?php

namespace Database\Seeders;

use App\Models\Formation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formations = [
            [
                'name' => 'Triangle',
                'description' => 'Form a triangle with all your units',
            ],
            [
                'name' => 'All Forward',
                'description' => 'Champions must be placed on the first two rows',
            ],
            [
                'name' => 'All Back',
                'description' => 'Champions must be placed on the last two rows',
            ],
            [
                'name' => 'The Infinity',
                'description' => 'Infinity sign form on the board',
            ],
            [
                'name' => 'Center is Lava',
                'description' => 'The 2nd and 3rd rows are unavailable',
            ],
            [
                'name' => 'Poles are Flooded',
                'description' => 'The 1st and 4th rows are unavailable',
            ],
            [
                'name' => 'Upside Down World',
                'description' => 'Ranged champions on the 1st row and melee champions on the 4th row',
            ],
            [
                'name' => 'Covid',
                'description' => 'Each champion must be one tile away from any other',
            ],
            [
                'name' => 'Hug',
                'description' => 'Each champion must touch at least one other to form a complete chain',
            ],
            [
                'name' => 'Side Line Formation',
                'description' => 'Create a vertical line of champions spanning from the first to the last row',
            ],
        ];

        foreach ($formations as $formation) {
            Formation::create($formation);
        }
    }
}
