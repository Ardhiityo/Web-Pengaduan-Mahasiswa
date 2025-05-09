<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\User;
use App\Models\Resident;
use App\Models\StudyProgram;
use Illuminate\Database\Seeder;
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

        //1
        $studyProgram = StudyProgram::where('name', 'Teknik Informatika')->first();

        $user = User::create([
            'name' => $faker->name(),
            'email' => 'hello@test.com',
            'password' => 11111111,
            'email_verified_at' => now()
        ])->assignRole('resident');

        Resident::create([
            'user_id' => $user->id,
            'avatar' => $storedPath,
            'study_program_id' => $studyProgram->id,
            'nim' => 22040004,
        ]);

        //2
        $studyProgram = StudyProgram::where('name', 'Manajemen')->first();

        $user = User::create([
            'name' => $faker->name(),
            'email' => 'allo@test.com',
            'password' => 11111111,
            'email_verified_at' => now()
        ])->assignRole('resident');

        Resident::create([
            'user_id' => $user->id,
            'avatar' => $storedPath,
            'study_program_id' => $studyProgram->id,
            'nim' => 22040005,
        ]);
    }
}
