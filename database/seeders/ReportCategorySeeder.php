<?php

namespace Database\Seeders;

use App\Models\ReportCategory;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        ReportCategory::create([
            'name' => $faker->name(),
            'image' => $faker->image()
        ]);
    }
}
