<?php
require_once 'vendor/autoload.php';

// Initialize Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Logs;

// Get all users with role 'user'
$users = User::where('role', 'user')->get();

echo "All users in database:\n";
foreach ($users as $user) {
    echo "ID: " . $user->id . " - Name: " . $user->name . " - Created: " . $user->created_at . "\n";
    
    // Check logs for this user
    $logsCount = Logs::where('user_id', $user->id)->count();
    echo "  Logs count: " . $logsCount . "\n";
}

echo "\nTesting logs button route generation:\n";
foreach ($users as $user) {
    $route = route('admin.logs', ['user' => $user->id]);
    echo "User " . $user->id . " route: " . $route . "\n";
}

echo "\nTest completed!\n";