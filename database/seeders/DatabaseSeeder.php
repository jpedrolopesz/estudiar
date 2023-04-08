<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'Joao Pedro',
            'last_name' => 'Lopes Zamonelo',
            'email' => 'jplopeszamonelo@hotmail.com',
            'role' => Roles::SUPER_ADMIN,
            'password' => bcrypt('joao1998'),

        ]);
    }
}
