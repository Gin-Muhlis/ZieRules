<?php

namespace Database\Seeders;

use App\Models\Homeroom;
use Illuminate\Database\Seeder;

class HomeroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Homeroom::factory()
            ->count(5)
            ->create();
    }
}
