<?php
require_once 'vendor/autoload.php';

// Initialize Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Logs;
use App\Models\User;

// Test user ID from the logs button
$testUserId = 1767699992;
$user = User::find($testUserId);

if ($user) {
    echo "User found: " . $user->name . "\n";
    
    // Get logs for this specific user
    $logs = Logs::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();
    
    echo "Total logs for user: " . $logs->count() . "\n";
    
    if ($logs->count() > 0) {
        echo "First log description: " . $logs->first()->description . "\n";
        echo "First log activity type: " . $logs->first()->activity_type . "\n";
        echo "First log created at: " . $logs->first()->created_at . "\n";
    }
    
    // Test pagination (like in the controller)
    $paginatedLogs = Logs::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->paginate(20);
    
    echo "Paginated logs count: " . $paginatedLogs->count() . "\n";
    echo "Total paginated logs: " . $paginatedLogs->total() . "\n";
} else {
    echo "User not found with ID: " . $testUserId . "\n";
}

echo "Test completed successfully!\n";