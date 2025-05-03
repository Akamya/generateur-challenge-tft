<?php

namespace Database\Seeders;

use App\Models\Constraint;
use Illuminate\Database\Seeder;

class ConstraintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $constraints = [
            [
                'name' => 'Hard stuck',
                'description' => 'End the game at level 8',
            ],
            [
                'name' => 'Solo leveling',
                'description' => 'Reach level 10',
            ],
            [
                'name' => 'Greedy',
                'description' => 'Die with at least 50 remaining gold',
            ],
            [
                'name' => 'Killer',
                'description' => 'Eliminate at least 2 players',
            ],
            [
                'name' => 'Big D-DPS',
                'description' => 'Inflict at least 150 damages to other players',
            ],
            [
                'name' => 'Rainbow',
                'description' => 'Have at least 6 active traits',
            ],
            [
                'name' => 'Legen... Dary',
                'description' => 'Have at least 2 legendary (5gold) units active',
            ],
            [
                'name' => 'Santa',
                'description' => 'Every unit must have at least one item',
            ],
            [
                'name' => 'Tenacity',
                'description' => 'Live at least until round 5-7',
            ],
            [
                'name' => 'Overpopulated',
                'description' => 'Put at least ten units on the board',
            ],
        ];

        foreach ($constraints as $constraint) {
            Constraint::create($constraint);
        }
    }
}
