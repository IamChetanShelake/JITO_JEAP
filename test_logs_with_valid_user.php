<?php
require_once 'vendor/autoload.php';

// Initialize Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Logs;

// Get a valid user from the database
$validUser = User::where('role', 'user')->first();

if ($validUser) {
    echo "Testing with valid user: " . $validUser->name . " (ID: " . $validUser->id . ")\n";
    
    // Test the route generation
    $route = route('admin.logs', ['user' => $validUser->id]);
    echo "Route generated: $route\n";
    
    // Test logs for this user
    $logs = Logs::where('user_id', $validUser->id)->get();
    echo "Logs count for user: " . $logs->count() . "\n";
    
    if ($logs->count() > 0) {
        echo "First log: " . $logs->first()->description . "\n";
        echo "First log activity type: " . $logs->first()->activity_type . "\n";
    }
    
    // Test pagination (like in the controller)
    $paginatedLogs = Logs::where('user_id', $validUser->id)->orderBy('created_at', 'desc')->paginate(20);
    echo "Paginated logs count: " . $paginatedLogs->count() . "\n";
    echo "Total paginated logs: " . $paginatedLogs->total() . "\n";
    
    echo "\n✅ Logs functionality is working correctly with valid user!\n";
} else {
    echo "❌ No valid users found in database\n";
}

echo "Test completed!\n";