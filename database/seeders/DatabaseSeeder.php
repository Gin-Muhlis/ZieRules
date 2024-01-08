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
                'name' => 'Smakzie',
                'email' => 'adminzie@admin.com',
                'password' => Hash::make('zieadmin'),
            ]);
        $this->call(PermissionsSeeder::class);
        $this->call(PresenceSeeder  ::class);

    }
}
