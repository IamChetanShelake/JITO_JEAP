<?php

// Simple test script to verify logging functionality
require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\Logs;

// Initialize Eloquent with admin_panel connection
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'database' => 'jitojeap_adminpanel_db',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
], 'admin_panel'); // Specify connection name

$capsule->setAsGlobal();
$capsule->bootEloquent();

echo "Testing Logging Functionality...\n\n";

// Test 1: Check if Logs table exists and is accessible
try {
    $logs = Logs::all();
    echo "✓ Logs table is accessible\n";
    echo "✓ Current log entries: " . $logs->count() . "\n\n";
} catch (Exception $e) {
    echo "✗ Error accessing Logs table: " . $e->getMessage() . "\n\n";
}

// Test 2: Test logging an action
try {
    Logs::create([
        'user_id' => 1,
        'user_name' => 'Test User',
        'user_email' => 'test@example.com',
        'process_type' => 'test',
        'process_action' => 'test_action',
        'process_description' => 'Test logging functionality',
        'process_by_name' => 'Test Script',
        'process_by_role' => 'test',
        'process_by_id' => 1,
        'module' => 'test',
        'action_url' => 'test_url',
        'additional_data' => json_encode([
            'test_data' => 'This is a test log entry',
            'timestamp' => date('Y-m-d H:i:s')
        ])
    ]);
    
    echo "✓ Successfully created test log entry\n";
    
    // Check if the log was created
    $testLogs = Logs::where('process_action', 'test_action')->get();
    echo "✓ Test log entries found: " . $testLogs->count() . "\n\n";
    
} catch (Exception $e) {
    echo "✗ Error testing logging: " . $e->getMessage() . "\n\n";
}

// Test 3: Test recent logs
try {
    $recentLogs = Logs::orderBy('created_at', 'desc')->take(5)->get();
    echo "✓ Recent log entries:\n";
    foreach ($recentLogs as $log) {
        echo "  - " . $log->created_at . ": " . $log->user_name . " (" . $log->process_action . ")\n";
    }
    echo "\n";
} catch (Exception $e) {
    echo "✗ Error retrieving recent logs: " . $e->getMessage() . "\n\n";
}

echo "Logging functionality test completed!\n";
echo "If all tests show ✓, the logging system is working correctly.\n";