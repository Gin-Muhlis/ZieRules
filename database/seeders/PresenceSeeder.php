<?php

namespace Database\Seeders;

use App\Models\Presence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PresenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $precences = ['hadir', 'izin', 'sakit', 'tanpa keterangan'];

        foreach ($precences as $name) {
            Presence::create(['name' => $name]);
        }
    }
}
