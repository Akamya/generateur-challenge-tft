<?php

namespace Database\Seeders;

use App\Models\Origin;
use App\Models\Season;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OriginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $origins = [
            ['name' => 'Anima Squad', 'technical_name' => 'TFT14_AnimaSqua'],
            ['name' => 'BoomBots', 'technical_name' => 'TFT14_BallisTek'],
            ['name' => 'Cyberboss', 'technical_name' => 'TFT14_Cyberbos'],
            ['name' => 'Cypher', 'technical_name' => 'TFT14_Suits'],
            ['name' => 'Divincorp', 'technical_name' => 'TFT14_Divinicorp'],
            ['name' => 'Exotech', 'technical_name' => 'TFT14_EdgeRunner'],
            ['name' => 'God of the Net', 'technical_name' => 'TFT14_Netgod'],
            ['name' => 'Golden Ox', 'technical_name' => 'TFT14_Immortal'],
            ['name' => 'Nitro', 'technical_name' => 'TFT14_HotRod'],
            ['name' => 'Overlord', 'technical_name' => 'TFT14_Overlord'],
            ['name' => 'Soul Killer', 'technical_name' => 'TFT14_ViegoUniqueTrait'],
            ['name' => 'Street Demon', 'technical_name' => 'TFT14_StreetDemon'],
            ['name' => 'Syndicate', 'technical_name' => 'TFT14_Mob'],
            ['name' => 'Virus', 'technical_name' => 'TFT14_Virus'],
        ];

        foreach ($origins as $origin) {
            Origin::create([
                'name' => $origin["name"],
                'technical_name' => $origin["technical_name"],
                'season_id' => Season::first()->id
            ]);
        }
    }
}
