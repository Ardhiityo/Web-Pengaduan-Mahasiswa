<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Report;
use App\Models\ReportStatus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReportStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $report = Report::first();

        $faker = Factory::create();

        ReportStatus::create([
            'report_id' => $report->id,
            'status' => 'delivered',
            'description' => $faker->sentence()
        ]);
    }
}
