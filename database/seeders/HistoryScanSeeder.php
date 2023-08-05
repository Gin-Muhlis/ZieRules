<?php

namespace Database\Seeders;

use App\Models\HistoryScan;
use Illuminate\Database\Seeder;

class HistoryScanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HistoryScan::factory()
            ->count(5)
            ->create();
    }
}
