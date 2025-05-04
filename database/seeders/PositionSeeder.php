<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            'first',
            'second',
            'third',
            'fourth',
            'fifth',
            'sixth',
            'seventh',
        ];

        $index = 1;

        foreach ($positions as $name) {
            $description = "Finish in the $name place or better";

            Position::create([
                'name' => $name,
                'value' => $index,
                'description' => $description,
            ]);

            $index++;
        }
    }
}
