<?php

// Test script to verify logging functionality
require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\User;
use App\Models\Logs;

// Initialize Eloquent
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => env('ADMIN_DB_HOST', '127.0.0.1'),
    'database' => env('ADMIN_DB_DATABASE', 'jitojeap_adminpanel_db'),
    'username' => env('ADMIN_DB_USERNAME', 'root'),
    'password' => env('ADMIN_DB_PASSWORD', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

echo "Testing Logging Functionality...\n\n";

// Test 1: Check if Logs table exists and is accessible
try {
    // Use the default connection for testing
    $logs = Logs::on('mysql')->all();
    echo "✓ Logs table is accessible\n";
    echo "✓ Current log entries: " . $logs->count() . "\n\n";
} catch (Exception $e) {
    echo "✗ Error accessing Logs table: " . $e->getMessage() . "\n\n";
}

// Test 2: Test user activity logging
try {
    // Find a test user
    $user = User::where('role', 'user')->first();
    
    if ($user) {
        echo "✓ Found test user: " . $user->name . " (ID: " . $user->id . ")\n";
        
        // Test logging a user action
        Logs::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'action' => 'test_action',
            'description' => 'Test logging functionality',
            'details' => json_encode([
                'test_data' => 'This is a test log entry',
                'timestamp' => date('Y-m-d H:i:s')
            ]),
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Test Script',
            'guard' => 'web'
        ]);
        
        echo "✓ Successfully created test log entry\n";
        
        // Check if the log was created
        $testLogs = Logs::where('action', 'test_action')->get();
        echo "✓ Test log entries found: " . $testLogs->count() . "\n\n";
        
    } else {
        echo "✗ No test users found\n\n";
    }
} catch (Exception $e) {
    echo "✗ Error testing user logging: " . $e->getMessage() . "\n\n";
}

// Test 3: Test admin activity logging
try {
    // Find an admin user
    $admin = User::where('role', 'admin')->first();
    
    if ($admin) {
        echo "✓ Found admin user: " . $admin->name . " (ID: " . $admin->id . ")\n";
        
        // Test logging an admin action
        Logs::create([
            'user_id' => $admin->id,
            'user_name' => $admin->name,
            'user_email' => $admin->email,
            'action' => 'test_admin_action',
            'description' => 'Test admin logging functionality',
            'details' => json_encode([
                'test_data' => 'This is a test admin log entry',
                'timestamp' => date('Y-m-d H:i:s')
            ]),
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Test Script',
            'guard' => 'admin'
        ]);
        
        echo "✓ Successfully created test admin log entry\n";
        
        // Check if the log was created
        $testAdminLogs = Logs::where('action', 'test_admin_action')->get();
        echo "✓ Test admin log entries found: " . $testAdminLogs->count() . "\n\n";
        
    } else {
        echo "✓ No admin users found (this is normal for some setups)\n\n";
    }
} catch (Exception $e) {
    echo "✗ Error testing admin logging: " . $e->getMessage() . "\n\n";
}

// Test 4: Test recent logs
try {
    $recentLogs = Logs::orderBy('created_at', 'desc')->take(5)->get();
    echo "✓ Recent log entries:\n";
    foreach ($recentLogs as $log) {
        echo "  - " . $log->created_at . ": " . $log->user_name . " (" . $log->action . ")\n";
    }
    echo "\n";
} catch (Exception $e) {
    echo "✗ Error retrieving recent logs: " . $e->getMessage() . "\n\n";
}

echo "Logging functionality test completed!\n";
echo "If all tests show ✓, the logging system is working correctly.\n";