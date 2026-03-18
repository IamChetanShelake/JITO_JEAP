<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminJitoStatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\AdminJitoStats::create([
            'number' => '78',
            'text' => 'Chapters',
            'display_order' => 1,
            'status' => true,
        ]);

        \App\Models\AdminJitoStats::create([
            'number' => '9',
            'text' => 'Zones',
            'display_order' => 2,
            'status' => true,
        ]);

        \App\Models\AdminJitoStats::create([
            'number' => '18,719+',
            'text' => 'Donors',
            'display_order' => 3,
            'status' => true,
        ]);

        \App\Models\AdminJitoStats::create([
            'number' => '32',
            'text' => 'International',
            'display_order' => 4,
            'status' => true,
        ]);
    }
}
