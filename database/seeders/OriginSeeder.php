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
            ['description' => 'Reach level gold with trait Anima Squad', 'name' => 'Anima Squad', 'technical_name' => 'TFT14_AnimaSqua'],
            ['description' => 'Reach level gold with trait BoomBots', 'name' => 'BoomBots', 'technical_name' => 'TFT14_BallisTek'],
            ['description' => 'Reach level gold with trait Cyberboss', 'name' => 'Cyberboss', 'technical_name' => 'TFT14_Cyberbos'],
            ['description' => 'Reach level gold with trait Cypher', 'name' => 'Cypher', 'technical_name' => 'TFT14_Suits'],
            ['description' => 'Reach level gold with trait Divincorp', 'name' => 'Divincorp', 'technical_name' => 'TFT14_Divinicorp'],
            ['description' => 'Reach level gold with trait Exotech', 'name' => 'Exotech', 'technical_name' => 'TFT14_EdgeRunner'],
            ['description' => 'Reach level gold with trait God of the Net', 'name' => 'God of the Net', 'technical_name' => 'TFT14_Netgod'],
            ['description' => 'Reach level gold with trait Golden Ox', 'name' => 'Golden Ox', 'technical_name' => 'TFT14_Immortal'],
            ['description' => 'Reach level gold with trait Nitro', 'name' => 'Nitro', 'technical_name' => 'TFT14_HotRod'],
            ['description' => 'Reach level gold with trait Overlord', 'name' => 'Overlord', 'technical_name' => 'TFT14_Overlord'],
            ['description' => 'Reach level gold with trait Soul Killer', 'name' => 'Soul Killer', 'technical_name' => 'TFT14_ViegoUniqueTrait'],
            ['description' => 'Reach level gold with trait Street Demon', 'name' => 'Street Demon', 'technical_name' => 'TFT14_StreetDemon'],
            ['description' => 'Reach level gold with trait Syndicate', 'name' => 'Syndicate', 'technical_name' => 'TFT14_Mob'],
            ['description' => 'Reach level gold with trait Virus', 'name' => 'Virus', 'technical_name' => 'TFT14_Virus'],
        ];

        foreach ($origins as $origin) {
            Origin::create([
                'name' => $origin["name"],
                'technical_name' => $origin["technical_name"],
                'description' => $origin["description"],
                'season_id' => Season::first()->id
            ]);
        }
    }
}
