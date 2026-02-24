<?php

// Simple test to verify logging functionality
require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\Logs;
use App\Models\User;

// Initialize Eloquent
$capsule = new Capsule;
$capsule->addConnection(require 'config/database.php');
$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    // Test 1: Check if Logs model exists and can be instantiated
    echo "Test 1: Creating Logs model instance...\n";
    $log = new Logs();
    echo "✓ Logs model created successfully\n";
    
    // Test 2: Check if we can find a user
    echo "\nTest 2: Finding a user...\n";
    $user = User::first();
    if ($user) {
        echo "✓ Found user: " . $user->name . " (ID: " . $user->id . ")\n";
        
        // Test 3: Create a test log entry
        echo "\nTest 3: Creating test log entry...\n";
        $log->user_id = $user->id;
        $log->process_type = 'test';
        $log->process_action = 'test';
        $log->process_description = 'test';
        $log->module = 'test';
        
        if ($log->save()) {
            echo "✓ Test log entry created successfully\n";
            echo "✓ Logging functionality is working correctly!\n";
        } else {
            echo "✗ Failed to create test log entry\n";
        }
    } else {
        echo "✗ No users found in database\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
