<?php

namespace Database\Seeders;

use App\Models\Constraint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'name' => 'Stingy',
                'description' => 'End the game with at least 50 remaining gold',
            ],
            [
                'name' => 'Persevering',
                'description' => 'Live at least until round 5-4',
            ],
            [
                'name' => 'Solo leveling',
                'description' => 'Reach level 10',
            ],
            [
                'name' => 'Killer',
                'description' => 'Eliminate at least 2 players',
            ],
            [
                'name' => 'Big D-DPS',
                'description' => 'Inflict at least 150 damages to other players',
            ],
        ];

        foreach ($constraints as $constraint) {
            Constraint::create($constraint);
        }
    }
}
