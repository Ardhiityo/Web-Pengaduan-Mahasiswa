<?php

namespace Database\Seeders;

use App\Models\ReportCategory;
use Illuminate\Database\Seeder;

class ReportCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReportCategory::create([
            'name' => 'Lingkungan',
            'image' => 'assets/category/TreeEvergreen.png'
        ]);
        ReportCategory::create([
            'name' => 'Keamanan',
            'image' => 'assets/category/Shield.png'
        ]);
        ReportCategory::create([
            'name' => 'Kesehatan',
            'image' => 'assets/category/Heartbeat.png'
        ]);
        ReportCategory::create([
            'name' => 'Infrastruktur',
            'image' => 'assets/category/Bridge.png'
        ]);
    }
}
