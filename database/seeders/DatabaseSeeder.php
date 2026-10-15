<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed or update Admin User
        User::updateOrCreate(
            ['email' => 'admin@jordan.com'],
            [
                'name' => 'Jordan Admin',
                'password' => 'password',
                'is_admin' => true,
            ]
        );

        // Seed regular test user
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
                'is_admin' => false,
            ]
        );

        $this->call([
            StoreSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
