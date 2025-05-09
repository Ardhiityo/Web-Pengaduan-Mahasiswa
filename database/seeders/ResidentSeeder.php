<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Faker\Factory;
use App\Models\User;
use App\Models\Resident;
use App\Models\StudyProgram;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ResidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path file in public
        $publicPath = public_path('assets/app/images/avatar.png');
        $extension = pathinfo($publicPath, PATHINFO_EXTENSION);

        // New path in storage
        $storedPath = 'assets/resident/' . uniqid() . ".$extension";
        if (file_exists($publicPath)) {
            Storage::disk('public')->put($storedPath, file_get_contents($publicPath));
        }

        $faker = Factory::create();
        $studyProgram = StudyProgram::first();

        $user = User::create([
            'name' => $faker->name(),
            'email' => 'hello@test.com',
            'password' => Hash::make(11111111),
            'email_verified_at' => now()
        ])->assignRole('resident');

        Resident::create([
            'user_id' => $user->id,
            'avatar' => $storedPath,
            'study_program_id' => $studyProgram->id,
            'nim' => 22040004,
        ]);
    }
}
