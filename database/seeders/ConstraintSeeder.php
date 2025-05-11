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
				'image' => 'seed/constraints/HardStuck.svg'
            ],
            [
                'name' => 'Solo leveling',
                'description' => 'Reach level 10',
				'image' => 'seed/constraints/SoloLeveling.svg'
            ],
            [
                'name' => 'Greedy',
                'description' => 'Die with at least 50 remaining gold',
				'image' => 'seed/constraints/Greedy.svg'
            ],
            [
                'name' => 'Killer',
                'description' => 'Eliminate at least 2 players',
				'image' => 'seed/constraints/Killer.svg'
            ],
            [
                'name' => 'Big D-DPS',
                'description' => 'Inflict at least 150 damages to other players',
				'image' => 'seed/constraints/BigDPS.svg'
			],
            [
                'name' => 'Rainbow',
                'description' => 'Have at least 6 active traits',
				'image' => 'seed/constraints/Rainbow.svg'
            ],
            [
                'name' => 'Legen... Dary',
                'description' => 'Have at least 2 legendary (5gold) units active',
				'image' => 'seed/constraints/Legendary.svg'
            ],
            [
                'name' => 'Santa',
                'description' => 'Every unit must have at least one item',
				'image' => 'seed/constraints/Santa.svg'
            ],
            [
                'name' => 'Tenacity',
                'description' => 'Live at least until round 5-7',
				'image' => 'seed/constraints/Tenacity.svg'
            ],
            [
                'name' => 'Overpopulated',
                'description' => 'Put at least ten units on the board',
				'image' => 'seed/constraints/Overpopulated.svg'
            ],
        ];

        foreach ($constraints as $constraint) {
            Constraint::create($constraint);
        }
    }
}
