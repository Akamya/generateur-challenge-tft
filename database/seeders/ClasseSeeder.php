<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Season;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            ['description' => 'Reach level bronze', 'name' => 'A.M.P.', 'technical_name' => 'TFT14_Supercharge'],
            ['description' => 'Reach level bronze', 'name' => 'Bastion', 'technical_name' => 'TFT14_Armorclad'],
            ['description' => 'Reach level bronze', 'name' => 'Bruiser', 'technical_name' => 'TFT14_Bruiser'],
            ['description' => 'Reach level bronze', 'name' => 'Dynamo', 'technical_name' => 'TFT14_Thirsty'],
            ['description' => 'Reach level bronze', 'name' => 'Executioner', 'technical_name' => 'TFT14_Cutter'],
            ['description' => 'Reach level bronze', 'name' => 'Marksman', 'technical_name' => 'TFT14_Marksman'],
            ['description' => 'Reach level bronze', 'name' => 'Rapidfire', 'technical_name' => 'TFT14_Swift'],
            ['description' => 'Reach level bronze', 'name' => 'Slayer', 'technical_name' => 'TFT14_Strong'],
            ['description' => 'Reach level bronze', 'name' => 'Strategist', 'technical_name' => 'TFT14_Controller'],
            ['description' => 'Reach level bronze', 'name' => 'Techie', 'technical_name' => 'TFT14_Techie'],
            ['description' => 'Reach level bronze', 'name' => 'Vanguard', 'technical_name' => 'TFT14_Vanguard'],
        ];

        foreach ($classes as $classe) {
            Classe::create([
                'name' => $classe["name"],
                'technical_name' => $classe["technical_name"],
                'description' => $classe["description"],
                'season_id' => Season::first()->id
            ]);
        }
    }
}
