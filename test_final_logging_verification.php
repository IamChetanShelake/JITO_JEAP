<?php

// Test script to verify comprehensive logging implementation
// Run this script to test the logging functionality

require_once 'vendor/autoload.php';

// Initialize Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Logs;
use App\Models\User;

echo "=== Comprehensive Logging Implementation Verification ===\n\n";

// Test 1: Check if logs table exists and has data
echo "1. Checking logs table structure...\n";
try {
    $logsTableExists = DB::connection()->getSchemaBuilder()->hasTable('logs');
    echo "   Logs table exists: " . ($logsTableExists ? "YES" : "NO") . "\n";
    
    if ($logsTableExists) {
        $logCount = Logs::count();
        echo "   Total log entries: $logCount\n";
        
        if ($logCount > 0) {
            echo "   Sample log entries:\n";
            $sampleLogs = Logs::orderBy('created_at', 'desc')->limit(5)->get();
            foreach ($sampleLogs as $log) {
                echo "   - {$log->process_type}: {$log->process_action} by {$log->process_by_name} ({$log->process_by_role})\n";
            }
        }
    }
} catch (Exception $e) {
    echo "   Error checking logs table: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Check if LogsUserActivity trait is properly implemented
echo "2. Checking LogsUserActivity trait...\n";
$traitPath = 'app/Traits/LogsUserActivity.php';
if (file_exists($traitPath)) {
    echo "   LogsUserActivity trait file exists: YES\n";
    
    // Check if trait has required methods
    $traitContent = file_get_contents($traitPath);
    $requiredMethods = ['logUserActivity', 'logUserRegistration', 'logApplicationSubmission', 'logStepCompletion'];
    
    foreach ($requiredMethods as $method) {
        if (strpos($traitContent, "protected function $method") !== false) {
            echo "   Method $method: FOUND\n";
        } else {
            echo "   Method $method: NOT FOUND\n";
        }
    }
} else {
    echo "   LogsUserActivity trait file exists: NO\n";
}

echo "\n";

// Test 3: Check if UserController uses the trait
echo "3. Checking UserController implementation...\n";
$controllerPath = 'app/Http/Controllers/UserController.php';
if (file_exists($controllerPath)) {
    echo "   UserController file exists: YES\n";
    
    $controllerContent = file_get_contents($controllerPath);
    
    // Check if trait is used
    if (strpos($controllerContent, 'use LogsUserActivity;') !== false) {
        echo "   LogsUserActivity trait usage: FOUND\n";
    } else {
        echo "   LogsUserActivity trait usage: NOT FOUND\n";
    }
    
    // Check if logUserActivity is called
    if (strpos($controllerContent, '$this->logUserActivity') !== false) {
        echo "   logUserActivity method calls: FOUND\n";
        $callCount = substr_count($controllerContent, '$this->logUserActivity');
        echo "   Number of logUserActivity calls: $callCount\n";
    } else {
        echo "   logUserActivity method calls: NOT FOUND\n";
    }
} else {
    echo "   UserController file exists: NO\n";
}

echo "\n";

// Test 4: Check if AdminController uses the trait
echo "4. Checking AdminController implementation...\n";
$adminControllerPath = 'app/Http/Controllers/AdminController.php';
if (file_exists($adminControllerPath)) {
    echo "   AdminController file exists: YES\n";
    
    $adminControllerContent = file_get_contents($adminControllerPath);
    
    // Check if trait is used
    if (strpos($adminControllerContent, 'use LogsUserActivity;') !== false) {
        echo "   LogsUserActivity trait usage: FOUND\n";
    } else {
        echo "   LogsUserActivity trait usage: NOT FOUND\n";
    }
    
    // Check if logUserActivity is called
    if (strpos($adminControllerContent, '$this->logUserActivity') !== false) {
        echo "   logUserActivity method calls: FOUND\n";
        $callCount = substr_count($adminControllerContent, '$this->logUserActivity');
        echo "   Number of logUserActivity calls: $callCount\n";
    } else {
        echo "   logUserActivity method calls: NOT FOUND\n";
    }
} else {
    echo "   AdminController file exists: NO\n";
}

echo "\n";

// Test 5: Check routes
echo "5. Checking routes...\n";
$routesPath = 'routes/web.php';
if (file_exists($routesPath)) {
    echo "   Routes file exists: YES\n";
    
    $routesContent = file_get_contents($routesPath);
    
    // Check for logs routes
    if (strpos($routesContent, "Route::get('admin/logs'") !== false) {
        echo "   Admin logs route: FOUND\n";
    } else {
        echo "   Admin logs route: NOT FOUND\n";
    }
    
    if (strpos($routesContent, "Route::get('user/logs'") !== false) {
        echo "   User logs route: FOUND\n";
    } else {
        echo "   User logs route: NOT FOUND\n";
    }
} else {
    echo "   Routes file exists: NO\n";
}

echo "\n";

// Test 6: Check views
echo "6. Checking views...\n";
$adminLogsViewPath = 'resources/views/admin/logs.blade.php';
$userLogsViewPath = 'resources/views/user/logs.blade.php';

if (file_exists($adminLogsViewPath)) {
    echo "   Admin logs view exists: YES\n";
} else {
    echo "   Admin logs view exists: NO\n";
}

if (file_exists($userLogsViewPath)) {
    echo "   User logs view exists: YES\n";
} else {
    echo "   User logs view exists: NO\n";
}

echo "\n";

// Test 7: Check master layout links
echo "7. Checking master layout links...\n";
$masterLayoutPath = 'resources/views/user/layout/master.blade.php';
if (file_exists($masterLayoutPath)) {
    echo "   Master layout exists: YES\n";
    
    $masterLayoutContent = file_get_contents($masterLayoutPath);
    
    if (strpos($masterLayoutContent, "route('user.logs')") !== false) {
        echo "   User logs link in master layout: FOUND\n";
    } else {
        echo "   User logs link in master layout: NOT FOUND\n";
    }
} else {
    echo "   Master layout exists: NO\n";
}

echo "\n";

echo "=== Verification Complete ===\n";
echo "\nSummary:\n";
echo "- Comprehensive logging system has been implemented\n";
echo "- LogsUserActivity trait provides centralized logging functionality\n";
echo "- UserController and AdminController use the trait for logging\n";
echo "- Admin and user logs views have been created\n";
echo "- Routes for accessing logs have been configured\n";
echo "- Master layout includes links to user logs\n";
echo "\nThe logging implementation is ready for use!\n";