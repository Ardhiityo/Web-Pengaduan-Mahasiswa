<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faculty::insert([
            [
                'name' => 'Fakultas Ilmu Komputer',
            ],
            [
                'name' => 'Fakultas Ekonomi Bisnis',
            ]
        ]);
    }
}
