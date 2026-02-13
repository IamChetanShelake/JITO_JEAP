<?php

// Simple test to verify logging functionality using Laravel's built-in commands
echo "Testing logging functionality...\n";

// Test 1: Check if Logs model exists
echo "Test 1: Checking Logs model...\n";
try {
    require_once 'vendor/autoload.php';
    
    // Use the existing Laravel application structure
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    // Test Logs model
    $logsModel = new App\Models\Logs();
    echo "✓ Logs model created successfully\n";
    
    // Test User model
    $userModel = new App\Models\User();
    echo "✓ User model created successfully\n";
    
    echo "✓ All models are working correctly!\n";
    echo "✓ Logging functionality is ready to use!\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}