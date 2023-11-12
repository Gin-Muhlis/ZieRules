<?php

namespace Database\Seeders;

use App\Models\ClassStudent;
use Illuminate\Database\Seeder;

class ClassStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClassStudent::factory()
            ->count(5)
            ->create();
    }
}
