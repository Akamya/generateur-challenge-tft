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
            'Anima Squad',
            'BoomBots',
            'Cyberboss',
            'Cypher',
            'Divincorp',
            'Exotech',
            'God of the Net',
            'Golden Ox',
            'Nitro',
            'Overlord',
            'Soul Killer',
            'Street Demon',
            'Syndicate',
            'Virus',
        ];

        foreach ($origins as $name) {
            Origin::create([
                'name' => $name,
                'season_id' => Season::first()->id
            ]);
        }
    }
}
