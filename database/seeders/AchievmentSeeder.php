<?php

namespace Database\Seeders;

use App\Models\Achievment;
use Illuminate\Database\Seeder;

class AchievmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Achievment::factory()
            ->count(5)
            ->create();
    }
}
