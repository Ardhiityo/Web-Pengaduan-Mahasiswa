<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Report;
use App\Models\Resident;
use App\Models\ReportCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        // Path file in public
        $publicPath = public_path('assets/app/images/report-1.png');
        $extension = pathinfo($publicPath, PATHINFO_EXTENSION);

        // New path in storage
        $storedPath = 'assets/report/' . uniqid() . ".$extension";

        if (file_exists($publicPath)) {
            Storage::disk('public')->put($storedPath, file_get_contents($publicPath));
        }

        $resident = Resident::first();
        $reportCategory = ReportCategory::first();

        Report::create([
            'code' => $faker->uuid(),
            'resident_id' => $resident->id,
            'report_category_id' => $reportCategory->id,
            'title' => $faker->sentence(),
            'description' => $faker->sentence(),
            'image' => $storedPath,
            'latitude' => $faker->latitude(),
            'longitude' => $faker->longitude(),
            'address' => $faker->address()
        ]);
    }
}
