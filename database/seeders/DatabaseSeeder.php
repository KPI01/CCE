<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adm = User::factory()
            ->count(1)
            ->for(Role::factory()->state([
                'name' => 'Administrador',
            ]))
            ->create([
                'name' => 'Informatica',
                'email' => 'informatica@fruveco.com',
                'email_verified_at' => now(),
                'password' => '123456'
            ]);
        $user = User::factory()
            ->count(1)
            ->for(Role::factory()->state([
                'name' => 'Usuario',
            ]))
            ->create([
                'password' => '123456'
            ]);
    }
}
