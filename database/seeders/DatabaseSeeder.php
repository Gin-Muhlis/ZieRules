<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);

        // $this->call(AchievmentSeeder::class);
        // $this->call(ClassStudentSeeder::class);
        // $this->call(DataAchievmentSeeder::class);
        // $this->call(DataTaskSeeder::class);
        // $this->call(DataViolationSeeder::class);
        // $this->call(HistoryScanSeeder::class);
        // $this->call(HomeroomSeeder::class);
        // $this->call(StudentSeeder::class);
        // $this->call(TaskSeeder::class);
        // $this->call(TeacherSeeder::class);
        // $this->call(UserSeeder::class);
        // $this->call(ViolationSeeder::class);
    }
}
