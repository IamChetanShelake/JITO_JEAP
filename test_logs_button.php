<?php
require_once 'vendor/autoload.php';

// Initialize Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

// Test the specific user ID that's being passed in the logs button
$testUserId = 1767699992;
$user = User::find($testUserId);

if ($user) {
    echo "User found with ID $testUserId: " . $user->name . "\n";
    
    // Test the route generation
    $route = route('admin.logs', ['user' => $user->id]);
    echo "Route generated: $route\n";
    
    // Test logs for this user
    $logs = \App\Models\Logs::where('user_id', $user->id)->get();
    echo "Logs count for user: " . $logs->count() . "\n";
} else {
    echo "User NOT found with ID $testUserId\n";
    
    // Check if this user exists in a different connection
    try {
        $userAdmin = \App\Models\User::on('admin_panel')->find($testUserId);
        if ($userAdmin) {
            echo "User found in admin_panel connection: " . $userAdmin->name . "\n";
        } else {
            echo "User not found in admin_panel connection either\n";
        }
    } catch (\Exception $e) {
        echo "Error checking admin_panel connection: " . $e->getMessage() . "\n";
    }
    
    // Check if this is a chapter user
    try {
        $chapterUser = \App\Models\Chapter::find($testUserId);
        if ($chapterUser) {
            echo "Chapter found with ID $testUserId: " . $chapterUser->name . "\n";
        } else {
            echo "No chapter found with ID $testUserId\n";
        }
    } catch (\Exception $e) {
        echo "Error checking chapter: " . $e->getMessage() . "\n";
    }
}

echo "Test completed!\n";