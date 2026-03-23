<?php

/**
 * Script to add domestic colleges to the database
 * Run this script using: php add_domestic_colleges.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\CollegeWebsite;

// List of domestic colleges with their courses
$colleges = [
    [
        'college_name' => 'IIM Ahmedabad',
        'university_name' => 'IIM',
        'college_type' => 'domestic',
        'country' => 'India',
        'state' => 'Gujarat',
        'city' => 'Ahmedabad',
        'courses' => json_encode(['MBA', 'PGDM', 'Executive Education']),
        'status' => true,
    ],
    [
        'college_name' => 'IIM Bangalore',
        'university_name' => 'IIM',
        'college_type' => 'domestic',
        'country' => 'India',
        'state' => 'Karnataka',
        'city' => 'Bangalore',
        'courses' => json_encode(['MBA', 'PGDM', 'Executive Education']),
        'status' => true,
    ],
    [
        'college_name' => 'IIT Bombay',
        'university_name' => 'IIT',
        'college_type' => 'domestic',
        'country' => 'India',
        'state' => 'Maharashtra',
        'city' => 'Mumbai',
        'courses' => json_encode(['B.Tech', 'M.Tech', 'MBA', 'M.Sc', 'PhD']),
        'status' => true,
    ],
    [
        'college_name' => 'IIT Delhi',
        'university_name' => 'IIT',
        'college_type' => 'domestic',
        'country' => 'India',
        'state' => 'Delhi',
        'city' => 'New Delhi',
        'courses' => json_encode(['B.Tech', 'M.Tech', 'MBA', 'M.Sc', 'PhD']),
        'status' => true,
    ],
    [
        'college_name' => 'ISB Hyderabad',
        'university_name' => 'ISB-HYBD',
        'college_type' => 'domestic',
        'country' => 'India',
        'state' => 'Telangana',
        'city' => 'Hyderabad',
        'courses' => json_encode(['MBA', 'PGP', 'Executive Education', 'PhD']),
        'status' => true,
    ],
    [
        'college_name' => 'NMIMS Mumbai',
        'university_name' => 'NMIMS',
        'college_type' => 'domestic',
        'country' => 'India',
        'state' => 'Maharashtra',
        'city' => 'Mumbai',
        'courses' => json_encode(['MBA', 'BBA', 'B.Com', 'M.Com', 'M.Sc']),
        'status' => true,
    ],
    [
        'college_name' => 'VIT Vellore',
        'university_name' => 'VIT',
        'college_type' => 'domestic',
        'country' => 'India',
        'state' => 'Tamil Nadu',
        'city' => 'Vellore',
        'courses' => json_encode(['B.Tech', 'M.Tech', 'MBA', 'B.Sc', 'M.Sc', 'PhD']),
        'status' => true,
    ],
    [
        'college_name' => 'BITS Pilani',
        'university_name' => 'Bitspilani',
        'college_type' => 'domestic',
        'country' => 'India',
        'state' => 'Rajasthan',
        'city' => 'Pilani',
        'courses' => json_encode(['B.Tech', 'M.Tech', 'MBA', 'B.Pharm', 'M.Pharm', 'PhD']),
        'status' => true,
    ],
    [
        'college_name' => 'Symbiosis Pune',
        'university_name' => 'Symbiosis',
        'college_type' => 'domestic',
        'country' => 'India',
        'state' => 'Maharashtra',
        'city' => 'Pune',
        'courses' => json_encode(['MBA', 'BBA', 'LLB', 'M.Sc', 'B.Sc', 'PhD']),
        'status' => true,
    ],
];

foreach ($colleges as $college) {
    // Check if college already exists
    $exists = CollegeWebsite::where('college_name', $college['college_name'])
        ->where('college_type', $college['college_type'])
        ->exists();
    
    if (!$exists) {
        CollegeWebsite::create($college);
        echo "Added: " . $college['college_name'] . "\n";
    } else {
        echo "Already exists: " . $college['college_name'] . "\n";
    }
}

echo "\nDone! Domestic colleges have been added.\n";
