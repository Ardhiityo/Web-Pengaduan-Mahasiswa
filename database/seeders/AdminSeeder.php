<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //1
        $user = User::create([
            'name' => 'Admin FIK',
            'email' => 'admin@fik.com',
            'password' => 11111111
        ]);

        $user->assignRole('admin');

        $faculty = Faculty::where('name', 'Fakultas Ilmu Komputer')->first();

        $user->admins()->create([
            'faculty_id' => $faculty->id,
        ]);

        //2
        $user = User::create([
            'name' => 'Admin FEB',
            'email' => 'admin@feb.com',
            'password' => 11111111
        ]);

        $user->assignRole('admin');

        $faculty = Faculty::where('name', 'Fakultas Ekonomi Bisnis')->first();

        $user->admins()->create([
            'faculty_id' => $faculty->id,
        ]);
    }
}
