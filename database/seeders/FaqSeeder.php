<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        Faq::create([
            'title' => $faker->sentence(5),
            'description' => $faker->sentence(10)
        ]);
    }
}
