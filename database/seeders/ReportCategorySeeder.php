<?php

namespace Database\Seeders;

use App\Models\ReportCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ReportCategorySeeder extends Seeder
{
    public function storedImage($path)
    {
        // Path file in public
        $publicPath = public_path($path);
        $extension = pathinfo($publicPath, PATHINFO_EXTENSION);

        // New path in storage
        $storedPath = 'assets/category/' . uniqid() . ".$extension";
        if (file_exists($publicPath)) {
            Storage::disk('public')->put($storedPath, file_get_contents($publicPath));

            return $storedPath;
        }
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReportCategory::create([
            'name' => 'Lingkungan',
            'image' => $this->storedImage('assets/app/images/category/TreeEvergreen.png')
        ]);
        ReportCategory::create([
            'name' => 'Keamanan',
            'image' => $this->storedImage('assets/app/images/category/Shield.png')
        ]);
        ReportCategory::create([
            'name' => 'Kesehatan',
            'image' => $this->storedImage('assets/app/images/category/Heartbeat.png')
        ]);
        ReportCategory::create([
            'name' => 'Infrastruktur',
            'image' => $this->storedImage('assets/app/images/category/Bridge.png')
        ]);
    }
}
