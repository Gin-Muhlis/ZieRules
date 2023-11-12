<?php

namespace Database\Seeders;

use App\Models\DataViolation;
use Illuminate\Database\Seeder;

class DataViolationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataViolation::factory()
            ->count(5)
            ->create();
    }
}
