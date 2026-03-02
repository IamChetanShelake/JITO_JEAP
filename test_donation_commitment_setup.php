<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

$container = $app->make('Illuminate\Container\Container');
$db = $container->make('db');

// Test 1: Check donation_commitments table exists
echo "=== TEST 1: Checking donation_commitments table ===\n";
try {
    $connection = $db->connection('admin_panel');
    $tables = $connection->getDoctrineSchemaManager()->listTableNames();

    if (in_array('donation_commitments', $tables)) {
        echo "✓ donation_commitments table EXISTS\n";
        $columns = $connection->getDoctrineSchemaManager()->listTableColumns('donation_commitments');
        echo "✓ Columns: " . implode(', ', array_keys($columns)) . "\n\n";
    } else {
        echo "✗ donation_commitments table DOES NOT EXIST\n";
        echo "Available tables: " . implode(', ', $tables) . "\n\n";
    }
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n\n";
}

// Test 2: Check if a sample donor exists and test relationship
echo "=== TEST 2: Testing Donor model relationships ===\n";
try {
    $donorModel = require 'app/Models/Donor.php';
    $donorClass = new \App\Models\Donor();
    echo "✓ Donor model loaded successfully\n";
    echo "✓ Donor connection: " . $donorClass->getConnectionName() . "\n";
    echo "✓ Donor table: " . $donorClass->getTable() . "\n\n";
} catch (\Exception $e) {
    echo "✗ Error loading Donor model: " . $e->getMessage() . "\n\n";
}

// Test 3: Check DonationCommitment model
echo "=== TEST 3: Testing DonationCommitment model ===\n";
try {
    $commitmentClass = new \App\Models\DonationCommitment();
    echo "✓ DonationCommitment model loaded successfully\n";
    echo "✓ Connection: " . $commitmentClass->getConnectionName() . "\n";
    echo "✓ Table: " . $commitmentClass->getTable() . "\n\n";
} catch (\Exception $e) {
    echo "✗ Error loading DonationCommitment model: " . $e->getMessage() . "\n\n";
}

// Test 4: Verify the relationship works
echo "=== TEST 4: Verifying commitments() relationship ===\n";
try {
    $donor = \App\Models\Donor::first();
    if ($donor) {
        echo "✓ Found a donor: {$donor->name} (ID: {$donor->id})\n";

        // Test the relationship
        $commitmentQuery = $donor->commitments();
        echo "✓ Commitments relationship works\n";
        echo "✓ Relationship query class: " . get_class($commitmentQuery) . "\n";
        echo "✓ Foreign key: " . $commitmentQuery->getForeignKeyName() . "\n";
        echo "✓ Related model table: " . $commitmentQuery->getRelated()->getTable() . "\n\n";
    } else {
        echo "✗ No donors found in database\n\n";
    }
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n\n";
}

// Test 5: Check route
echo "=== TEST 5: Checking route ===\n";
try {
    $router = $container->make('router');
    $route = $router->getRoutes()->getByName('admin.donors.createCommitment');
    if ($route) {
        echo "✓ Route 'admin.donors.createCommitment' exists\n";
        echo "✓ Route method: " . implode(', ', $route->methods) . "\n";
        echo "✓ Route path: " . $route->uri . "\n";
        echo "✓ Action: " . $route->action['controller'] . "\n\n";
    } else {
        echo "✗ Route 'admin.donors.createCommitment' NOT FOUND\n\n";
    }
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n\n";
}

echo "=== ALL TESTS COMPLETED ===\n";
