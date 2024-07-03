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

        User::factory()
            ->count(1)
            ->for(Role::factory()->state([
                'name' => 'Admin',
            ]))
            ->create([
                'name' => 'Informatica',
                'email' => 'informatica@fruveco.com',
                'password' => 'Fruveco@2024',
                'email_verified_at' => now(),
                'remember_token' => null,
            ]);

        User::factory()
            ->count(1)
            ->for(Role::factory()->state([
                'name' => 'Usuario',
            ]))
            ->create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => '0dEwSl-!$*',
                'email_verified_at' => null,
                'remember_token' => null,
            ]);

        $this->call([
            PersonaSeeder::class,
            EmpresaSeeder::class,
        ]);
    }
}
