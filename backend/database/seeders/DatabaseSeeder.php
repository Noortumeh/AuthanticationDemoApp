<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\{ProfileSeeder, UserSeeder};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProfileSeeder::class,
        ]);
    }
}
