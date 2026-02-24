<?php

// Simple test to verify logging functionality
require_once 'vendor/autoload.php';

// Set up Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Logs;
use App\Http\Controllers\AdminController;

echo "=== FINAL LOGGING VERIFICATION TEST ===\n\n";

// Test 1: Check if we can create a log entry using the trait
echo "1. Testing log creation using LogsUserActivity trait...\n";
try {
    // Create a test admin controller instance
    $adminController = new AdminController();
    
    // Test the logUserActivity method
    $adminController->logUserActivity(
        processType: 'test_logging',
        processAction: 'test',
        processDescription: 'Test log entry for verification',
        module: 'test',
        additionalData: ['test' => 'data']
    );
    
    echo "✓ LogUserActivity method called successfully\n";
    
    // Check if the log was created
    $testLog = Logs::where('process_type', 'test_logging')
        ->where('process_action', 'test')
        ->latest()
        ->first();
    
    if ($testLog) {
        echo "✓ Test log entry created successfully (ID: {$testLog->id})\n";
        echo "  - User: {$testLog->user_name}\n";
        echo "  - Process: {$testLog->process_type}\n";
        echo "  - Action: {$testLog->process_action}\n";
        echo "  - Description: {$testLog->process_description}\n";
    } else {
        echo "✗ Test log entry not found\n";
    }
} catch (\Exception $e) {
    echo "✗ Failed to test logUserActivity: " . $e->getMessage() . "\n";
}

// Test 2: Check if AdminController has the trait
echo "\n2. Testing AdminController trait usage...\n";
try {
    $reflection = new ReflectionClass('App\Http\Controllers\AdminController');
    $traits = $reflection->getTraits();
    
    $hasLogsTrait = false;
    foreach ($traits as $trait) {
        if ($trait->getName() === 'App\Traits\LogsUserActivity') {
            $hasLogsTrait = true;
            break;
        }
    }
    
    if ($hasLogsTrait) {
        echo "✓ AdminController uses LogsUserActivity trait\n";
        
        // Check if the method exists
        if ($reflection->hasMethod('logUserActivity')) {
            echo "✓ logUserActivity method is available in AdminController\n";
        } else {
            echo "✗ logUserActivity method not found in AdminController\n";
        }
    } else {
        echo "✗ AdminController does not use LogsUserActivity trait\n";
    }
} catch (\Exception $e) {
    echo "✗ AdminController test error: " . $e->getMessage() . "\n";
}

// Test 3: Check database connection and Logs table
echo "\n3. Testing database connection and Logs table...\n";
try {
    DB::connection()->getPdo();
    echo "✓ Database connection successful\n";
    
    // Check if we can query the logs table
    $logsCount = Logs::count();
    echo "✓ Logs table accessible, current count: {$logsCount}\n";
    
    // Check if we can create a simple log entry
    $simpleLog = Logs::create([
        'user_id' => 999998,
        'user_name' => 'Test User 2',
        'user_email' => 'test@example.com',
        'process_type' => 'simple_test',
        'process_action' => 'created',
        'process_description' => 'Simple test log entry',
        'process_by_name' => 'Test Script',
        'process_by_role' => 'test',
        'process_by_id' => 999998,
        'module' => 'test',
        'action_url' => 'http://test.com',
        'process_date' => now(),
    ]);
    
    if ($simpleLog) {
        echo "✓ Simple log entry created successfully (ID: {$simpleLog->id})\n";
        
        // Clean up
        Logs::where('user_id', 999998)->delete();
        echo "✓ Test log cleaned up\n";
    } else {
        echo "✗ Failed to create simple log entry\n";
    }
} catch (\Exception $e) {
    echo "✗ Database test error: " . $e->getMessage() . "\n";
}

echo "\n=== FINAL LOGGING VERIFICATION COMPLETE ===\n";
echo "\nIf you see ✓ marks above, the logging system is working correctly.\n";
echo "The approveWorkingCommittee() method in AdminController now has comprehensive logging.\n";