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
            ['description' => 'Reach level bronze', 'name' => 'A.M.P.', 'technical_name' => 'TFT14_Supercharge', 'image' => 'seed/classes/14_Amp.png'],
            ['description' => 'Reach level bronze', 'name' => 'Bastion', 'technical_name' => 'TFT14_Armorclad', 'image' => 'seed/classes/14_Bastion.png'],
            ['description' => 'Reach level bronze', 'name' => 'Bruiser', 'technical_name' => 'TFT14_Bruiser', 'image' => 'seed/classes/14_Bruiser.png'],
            ['description' => 'Reach level bronze', 'name' => 'Dynamo', 'technical_name' => 'TFT14_Thirsty', 'image' => 'seed/classes/14_Dynamo.png'],
            ['description' => 'Reach level bronze', 'name' => 'Executioner', 'technical_name' => 'TFT14_Cutter', 'image' => 'seed/classes/14_Executioner.png'],
            ['description' => 'Reach level bronze', 'name' => 'Marksman', 'technical_name' => 'TFT14_Marksman', 'image' => 'seed/classes/14_Marksman.png'],
            ['description' => 'Reach level bronze', 'name' => 'Rapidfire', 'technical_name' => 'TFT14_Swift', 'image' => 'seed/classes/14_Rapidfire.png'],
            ['description' => 'Reach level bronze', 'name' => 'Slayer', 'technical_name' => 'TFT14_Strong', 'image' => 'seed/classes/14_Slayer.png'],
            ['description' => 'Reach level bronze', 'name' => 'Strategist', 'technical_name' => 'TFT14_Controller', 'image' => 'seed/classes/14_Strategist.png'],
            ['description' => 'Reach level bronze', 'name' => 'Techie', 'technical_name' => 'TFT14_Techie', 'image' => 'seed/classes/14_Techie.png'],
            ['description' => 'Reach level bronze', 'name' => 'Vanguard', 'technical_name' => 'TFT14_Vanguard', 'image' => 'seed/classes/14_Vanguard.png'],
        ];

        foreach ($classes as $classe) {
            Classe::create([
                'name' => $classe["name"],
                'technical_name' => $classe["technical_name"],
                'description' => $classe["description"],
                'season_id' => Season::first()->id,
                'image' => $classe["image"],
            ]);
        }
    }
}
