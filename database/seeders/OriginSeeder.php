<?php

namespace Database\Seeders;

use App\Models\Origin;
use App\Models\Season;
use Illuminate\Database\Seeder;

class OriginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $origins = [
            ['description' => 'Reach level gold', 'name' => 'Anima Squad', 'technical_name' => 'TFT14_AnimaSqua', 'image' => 'seed/origins/14_AnimaSquad.png'],
            ['description' => 'Reach level gold', 'name' => 'BoomBots', 'technical_name' => 'TFT14_BallisTek', 'image' => 'seed/origins/14_BoomBots.png'],
            ['description' => 'Reach level gold', 'name' => 'Cyberboss', 'technical_name' => 'TFT14_Cyberbos', 'image' => 'seed/origins/14_Cyberbosses.png'],
            ['description' => 'Reach level gold', 'name' => 'Cypher', 'technical_name' => 'TFT14_Suits', 'image' => 'seed/origins/14_Cypher.png'],
            ['description' => 'Reach level gold', 'name' => 'Divincorp', 'technical_name' => 'TFT14_Divinicorp', 'image' => 'seed/origins/14_Divincorp.png'],
            ['description' => 'Reach level gold', 'name' => 'Exotech', 'technical_name' => 'TFT14_EdgeRunner', 'image' => 'seed/origins/14_Exotech.png'],
            ['description' => 'Reach level gold', 'name' => 'God of the Net', 'technical_name' => 'TFT14_Netgod', 'image' => 'seed/origins/14_GodoftheNet.png'],
            ['description' => 'Reach level gold', 'name' => 'Golden Ox', 'technical_name' => 'TFT14_Immortal', 'image' => 'seed/origins/14_GoldenOx.png'],
            ['description' => 'Reach level gold', 'name' => 'Nitro', 'technical_name' => 'TFT14_HotRod', 'image' => 'seed/origins/14_NitroForge.png'],
            ['description' => 'Reach level gold', 'name' => 'Overlord', 'technical_name' => 'TFT14_Overlord', 'image' => 'seed/origins/14_Overlord.png'],
            ['description' => 'Reach level gold', 'name' => 'Soul Killer', 'technical_name' => 'TFT14_ViegoUnique', 'image' => 'seed/origins/14_SoulKiller.png'],
            ['description' => 'Reach level gold', 'name' => 'Street Demon', 'technical_name' => 'TFT14_StreetDemon', 'image' => 'seed/origins/14_StreetDemon.png'],
            ['description' => 'Reach level gold', 'name' => 'Syndicate', 'technical_name' => 'TFT14_Mob', 'image' => 'seed/origins/14_Mob.png'],
            ['description' => 'Reach level gold', 'name' => 'Virus', 'technical_name' => 'TFT14_Virus', 'image' => 'seed/origins/14_Virus.png'],
        ];

        foreach ($origins as $origin) {
            Origin::create([
                'name' => $origin["name"],
                'technical_name' => $origin["technical_name"],
                'description' => $origin["description"],
                'season_id' => Season::first()->id,
                'image' => $origin["image"],
            ]);
        }
    }
}
