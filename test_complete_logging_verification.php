<?php

// Test script to verify complete logging functionality
require_once 'vendor/autoload.php';

// Set up Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Logs;

echo "=== COMPLETE LOGGING VERIFICATION TEST ===\n\n";

// Test 1: Check if Logs table exists and is accessible
echo "1. Testing Logs table accessibility...\n";
try {
    $logsCount = Logs::count();
    echo "✓ Logs table accessible, current count: {$logsCount}\n";
} catch (\Exception $e) {
    echo "✗ Logs table error: " . $e->getMessage() . "\n";
    exit(1);
}

// Test 2: Check if we can create a test log entry
echo "\n2. Testing log creation...\n";
try {
    $testLog = Logs::create([
        'user_id' => 999999, // Test user ID
        'user_name' => 'Test User',
        'user_role' => 'test',
        'activity_type' => 'test_activity',
        'description' => 'Test log entry for verification',
        'metadata' => json_encode(['test' => 'data']),
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Test Script'
    ]);
    echo "✓ Test log entry created successfully (ID: {$testLog->id})\n";
} catch (\Exception $e) {
    echo "✗ Failed to create test log: " . $e->getMessage() . "\n";
}

// Test 3: Check if we can retrieve the test log
echo "\n3. Testing log retrieval...\n";
try {
    $retrievedLog = Logs::where('user_id', 999999)->where('activity_type', 'test_activity')->first();
    if ($retrievedLog) {
        echo "✓ Test log retrieved successfully\n";
        echo "  - ID: {$retrievedLog->id}\n";
        echo "  - User: {$retrievedLog->user_name}\n";
        echo "  - Activity: {$retrievedLog->activity_type}\n";
        echo "  - Description: {$retrievedLog->description}\n";
    } else {
        echo "✗ Test log not found\n";
    }
} catch (\Exception $e) {
    echo "✗ Failed to retrieve test log: " . $e->getMessage() . "\n";
}

// Test 4: Check if we can delete the test log
echo "\n4. Testing log cleanup...\n";
try {
    $deleted = Logs::where('user_id', 999999)->where('activity_type', 'test_activity')->delete();
    if ($deleted) {
        echo "✓ Test log cleaned up successfully\n";
    } else {
        echo "- No test log found to clean up\n";
    }
} catch (\Exception $e) {
    echo "✗ Failed to clean up test log: " . $e->getMessage() . "\n";
}

// Test 5: Check if we can access the LogsUserActivity trait
echo "\n5. Testing LogsUserActivity trait...\n";
try {
    // Check if the trait exists
    if (trait_exists('App\Traits\LogsUserActivity')) {
        echo "✓ LogsUserActivity trait exists\n";
        
        // Check if the logUserActivity method exists
        $reflection = new ReflectionClass('App\Traits\LogsUserActivity');
        if ($reflection->hasMethod('logUserActivity')) {
            echo "✓ logUserActivity method exists in trait\n";
            
            // Check method signature
            $method = $reflection->getMethod('logUserActivity');
            $parameters = $method->getParameters();
            echo "✓ Method has " . count($parameters) . " parameters:\n";
            foreach ($parameters as $param) {
                echo "  - {$param->getName()}" . ($param->isOptional() ? ' (optional)' : ' (required)') . "\n";
            }
        } else {
            echo "✗ logUserActivity method not found in trait\n";
        }
    } else {
        echo "✗ LogsUserActivity trait not found\n";
    }
} catch (\Exception $e) {
    echo "✗ Trait test error: " . $e->getMessage() . "\n";
}

// Test 6: Check if AdminController has the trait
echo "\n6. Testing AdminController trait usage...\n";
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
    } else {
        echo "✗ AdminController does not use LogsUserActivity trait\n";
    }
} catch (\Exception $e) {
    echo "✗ AdminController test error: " . $e->getMessage() . "\n";
}

// Test 7: Check database connection
echo "\n7. Testing database connection...\n";
try {
    DB::connection()->getPdo();
    echo "✓ Database connection successful\n";
    
    // Check if we can query the logs table
    $tables = DB::connection()->getSchemaBuilder()->getAllTables();
    $hasLogsTable = false;
    foreach ($tables as $table) {
        if (isset($table->name) && $table->name === 'logs') {
            $hasLogsTable = true;
            break;
        }
    }
    
    if ($hasLogsTable) {
        echo "✓ Logs table exists in database\n";
    } else {
        echo "✗ Logs table not found in database\n";
    }
} catch (\Exception $e) {
    echo "✗ Database connection error: " . $e->getMessage() . "\n";
}

echo "\n=== LOGGING VERIFICATION COMPLETE ===\n";
echo "\nAll tests completed. If you see ✓ marks above, the logging system is working correctly.\n";
echo "If you see ✗ marks, there may be issues that need to be addressed.\n";