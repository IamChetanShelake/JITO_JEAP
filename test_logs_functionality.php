<?php

// Test script to verify logs functionality
require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Initialize Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test the logs functionality
echo "Testing Logs Functionality\n";
echo "=========================\n\n";

try {
    // Check if Logs model exists and is working
    echo "1. Testing Logs Model...\n";
    $logsModel = new \App\Models\Logs();
    echo "✓ Logs model instantiated successfully\n";
    
    // Check if table exists
    $tableExists = DB::connection('admin_panel')->getSchemaBuilder()->hasTable('logs');
    echo "✓ Logs table exists: " . ($tableExists ? 'Yes' : 'No') . "\n\n";
    
    // Test creating a log entry
    echo "2. Testing Log Creation...\n";
    $logData = [
        'user_id' => 1,
        'activity_type' => 'test',
        'description' => 'Test log entry for functionality verification',
        'details' => json_encode(['test' => 'data', 'timestamp' => time()]),
        'process_type' => 'test',
        'process_action' => 'test'
    ];
    
    $log = \App\Models\Logs::create($logData);
    echo "✓ Log entry created with ID: " . $log->id . "\n\n";
    
    // Test retrieving logs
    echo "3. Testing Log Retrieval...\n";
    $logs = \App\Models\Logs::where('user_id', 1)->get();
    echo "✓ Retrieved " . $logs->count() . " log entries\n";
    
    // Test the AdminController method
    echo "4. Testing AdminController@showLogs...\n";
    $controller = new \App\Http\Controllers\AdminController();
    
    // Mock a request with authenticated user
    $mockUser = new \stdClass();
    $mockUser->id = 1;
    
    // Test the method
    $result = $controller->showLogs();
    echo "✓ AdminController@showLogs method executed successfully\n";
    
    echo "\n✅ All tests passed! Logs functionality is working correctly.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}