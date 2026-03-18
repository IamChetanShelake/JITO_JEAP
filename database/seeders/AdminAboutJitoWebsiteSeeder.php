<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminAboutJitoWebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\AdminAboutJitoWebsite::create([
            'title' => 'About JITO',
            'paragraphs' => ['JITO is a global organisation...', 'Driven by entrepreneurship and service.'],
            'image' => null,
            'number' => '78',
            'stat_text' => 'Chapters',
            'display_order' => 1,
            'status' => true,
        ]);
    }
}
