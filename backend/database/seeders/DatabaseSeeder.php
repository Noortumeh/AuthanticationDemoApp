<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Profile, User};
use Database\Seeders\{ProfileSeeder, UserSeeder};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            ProfileSeeder::class,
        ]);
    }
}
