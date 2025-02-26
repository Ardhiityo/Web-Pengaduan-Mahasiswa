<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\ReportCategory;
use App\Models\Resident;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        $resident = Resident::first();
        $reportCategory = ReportCategory::first();

        Report::create([
            'code' => $faker->uuid(),
            'resident_id' =>  $resident->id,
            'report_category_id' => $reportCategory->id,
            'title' => $faker->title(),
            'description' => $faker->sentence(),
            'image' => $faker->image(),
            'latitude' => $faker->latitude(),
            'longitude' => $faker->longitude(),
            'address' => $faker->address()
        ]);
    }
}
