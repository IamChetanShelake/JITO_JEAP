<?php
require_once 'vendor/autoload.php';

// Initialize Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Logs;

// Test the route model binding issue
echo "Testing route model binding issue:\n\n";

// Get a valid user
$validUser = User::where('role', 'user')->first();
echo "Valid user found: ID " . $validUser->id . " - " . $validUser->name . "\n\n";

// Test what happens when we try to find user ID 1767699992
$problematicUser = User::find(1767699992);
if ($problematicUser) {
    echo "User 1767699992 FOUND: " . $problematicUser->name . "\n";
} else {
    echo "User 1767699992 NOT FOUND - this is the issue!\n";
}

// Test route generation with valid user
$route = route('admin.apex.stage1.user.detail', ['user' => $validUser->id]);
echo "\nValid route: " . $route . "\n";

// Test route generation with problematic user ID
$route2 = route('admin.apex.stage1.user.detail', ['user' => 1767699992]);
echo "Problematic route: " . $route2 . "\n";

// Check if there are any users with ID starting with 1767699992
$similarUsers = User::where('id', 'like', '176769999%')->get();
echo "\nUsers with similar IDs: " . $similarUsers->count() . "\n";
foreach ($similarUsers as $user) {
    echo "ID: " . $user->id . " - Name: " . $user->name . "\n";
}

echo "\nTest completed!\n";