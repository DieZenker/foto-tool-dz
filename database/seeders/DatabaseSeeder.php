<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin Admin',
            'email' => 'dominik.nussbaum@cognos-ag.de',
            'password' => Hash::make('geheim')
        ]);

        User::create([
            'name' => 'Barbara Debold',
            'email' => 'barbara.debold@hs-fresenius.de',
            'password' => Hash::make('geheim')
        ]);

        User::create([
            'name' => 'Carla Fellhauer',
            'email' => 'carla.fellhauer@hs-fresenius.de',
            'password' => Hash::make('geheim')
        ]);

        User::create([
            'name' => 'Catherine Joya Morales',
            'email' => 'catherine.joya_morales@onlineplus.de',
            'password' => Hash::make('geheim')
        ]);

        User::create([
            'name' => 'Juliane Mischer',
            'email' => 'juliane.mischer@hs-fresenius.de',
            'password' => Hash::make('geheim')
        ]);

        User::create([
            'name' => 'Nico Schnabel',
            'email' => 'nschnabel@cognos-ag.de',
            'password' => Hash::make('geheim')
        ]);
    }
}
