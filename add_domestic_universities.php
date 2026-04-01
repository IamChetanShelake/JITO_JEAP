<?php

/**
 * Script to add domestic universities to the database
 * Run this script using: php add_domestic_universities.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\UniversityWebsite;

// List of domestic universities to add
$universities = [
    [
        'university_name' => 'IIM',
        'university_type' => 'domestic',
        'country' => 'India',
        'state' => 'Multiple States',
        'city' => 'Multiple Cities',
        'status' => true,
    ],
    [
        'university_name' => 'IIT',
        'university_type' => 'domestic',
        'country' => 'India',
        'state' => 'Multiple States',
        'city' => 'Multiple Cities',
        'status' => true,
    ],
    [
        'university_name' => 'ISB-HYBD',
        'university_type' => 'domestic',
        'country' => 'India',
        'state' => 'Telangana',
        'city' => 'Hyderabad',
        'status' => true,
    ],
    [
        'university_name' => 'NMIMS',
        'university_type' => 'domestic',
        'country' => 'India',
        'state' => 'Maharashtra',
        'city' => 'Mumbai',
        'status' => true,
    ],
    [
        'university_name' => 'VIT',
        'university_type' => 'domestic',
        'country' => 'India',
        'state' => 'Tamil Nadu',
        'city' => 'Vellore',
        'status' => true,
    ],
    [
        'university_name' => 'Bitspilani',
        'university_type' => 'domestic',
        'country' => 'India',
        'state' => 'Rajasthan',
        'city' => 'Pilani',
        'status' => true,
    ],
    [
        'university_name' => 'Symbiosis',
        'university_type' => 'domestic',
        'country' => 'India',
        'state' => 'Maharashtra',
        'city' => 'Pune',
        'status' => true,
    ],
];

foreach ($universities as $university) {
    // Check if university already exists
    $exists = UniversityWebsite::where('university_name', $university['university_name'])
        ->where('university_type', $university['university_type'])
        ->exists();
    
    if (!$exists) {
        UniversityWebsite::create($university);
        echo "Added: " . $university['university_name'] . "\n";
    } else {
        echo "Already exists: " . $university['university_name'] . "\n";
    }
}

echo "\nDone! Domestic universities have been added.\n";
