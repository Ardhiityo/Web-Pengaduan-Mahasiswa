<?php

namespace Database\Seeders;

use App\Models\Resident;
use Faker\Factory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ResidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        $user = User::create([
            'name' => $faker->name(),
            'email' => 'hello@test.com',
            'password' => Hash::make(11111111)
        ])->assignRole('resident');

        Resident::create(['user_id' => $user->id]);
    }
}
