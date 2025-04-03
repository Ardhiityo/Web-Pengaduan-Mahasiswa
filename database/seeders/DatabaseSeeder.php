<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call([
        //     RolePermissionSeeder::class,
        //     AdminSeeder::class,
        //     ResidentSeeder::class,
        //     ReportCategorySeeder::class
        // ]);

        //for testing
        $this->call([
            RolePermissionSeeder::class,
            AdminSeeder::class,
            ResidentSeeder::class,
            ReportCategorySeeder::class,
            ReportSeeder::class,
            ReportStatusSeeder::class,
            FaqSeeder::class
        ]);
    }
}
