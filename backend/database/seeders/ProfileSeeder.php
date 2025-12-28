<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        $profiles =[
            [
                'user_id' => 1,
                'bio' => 'This is the bio of user 1',
                'phone' => '123-456-7890',
                'address' => '123 Main St, Cityville',
                'birthdate' => '1990-01-01',
                'image' => 'https://example.com/images/user1.jpg',
            ],
            [
                'user_id' => 2,
                'bio' => 'This is the bio of user 2',
                'phone' => '234-567-8901',
                'address' => '456 Elm St, Townsville',
                'birthdate' => '1992-02-02',
                'image' => 'https://example.com/images/user2.jpg',
            ],
        ];
        foreach ($profiles as $profileData) {
            Profile::create($profileData);
        }
    }
}
