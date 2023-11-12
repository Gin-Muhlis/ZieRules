<?php

namespace Database\Seeders;

use App\Models\DataTask;
use Illuminate\Database\Seeder;

class DataTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataTask::factory()
            ->count(5)
            ->create();
    }
}
