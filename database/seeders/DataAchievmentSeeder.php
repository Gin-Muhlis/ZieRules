<?php

namespace Database\Seeders;

use App\Models\DataAchievment;
use Illuminate\Database\Seeder;

class DataAchievmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataAchievment::factory()
            ->count(5)
            ->create();
    }
}
