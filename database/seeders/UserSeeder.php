<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'username' => 'trueAdmin',
            'email' => 'elodielanglet420@gmail.com',
            'is_admin' => true
        ]);

        User::factory()->create([
            'username' => 'admin',
            'email' => 'kevin.verhoeven.pro@hotmail.com',
            'is_admin' => true
        ]);

        // User::factory(10)->create();
    }
}
