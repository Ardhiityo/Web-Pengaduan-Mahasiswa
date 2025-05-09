<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\StudyProgram;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //1
        $faculty = Faculty::where('name', 'Fakultas Ilmu Komputer')->first();

        StudyProgram::create([
            'faculty_id' => $faculty->id,
            'name' => 'Teknik Informatika'
        ]);

        //2
        $faculty = Faculty::where('name', 'Fakultas Ekonomi Bisnis')->first();

        StudyProgram::create([
            'faculty_id' => $faculty->id,
            'name' => 'Manajemen'
        ]);
    }
}
