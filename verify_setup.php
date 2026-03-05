<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

echo "=== Testing Donation Commitment Setup ===\n\n";

// Test 1: Load models
echo "1. Loading models...\n";
try {
    $donorModel = new \App\Models\Donor();
    echo "   ✓ Donor model loaded\n";
    echo "     - Connection: " . $donorModel->getConnectionName() . "\n";
    echo "     - Table: " . $donorModel->getTable() . "\n";
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

try {
    $commitmentModel = new \App\Models\DonationCommitment();
    echo "   ✓ DonationCommitment model loaded\n";
    echo "     - Connection: " . $commitmentModel->getConnectionName() . "\n";
    echo "     - Table: " . $commitmentModel->getTable() . "\n";
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// Test 2: Check table existence
echo "\n2. Checking table existence...\n";
try {
    $db = $app->make('db');
    $connection = $db->connection('admin_panel');

    $allTables = $connection->getDoctrineSchemaManager()->listTableNames();

    if (in_array('donation_commitments', $allTables)) {
        echo "   ✓ donation_commitments table exists\n";
        $columns = $connection->getDoctrineSchemaManager()->listTableColumns('donation_commitments');
        echo "   ✓ Columns: " . implode(', ', array_keys($columns)) . "\n";
    } else {
        echo "   ✗ donation_commitments table NOT FOUND\n";
    }

    if (in_array('donors', $allTables)) {
        echo "   ✓ donors table exists\n";
    } else {
        echo "   ✗ donors table NOT FOUND\n";
    }
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// Test 3: Check if there's any data
echo "\n3. Checking for test data...\n";
try {
    $db = $app->make('db');
    $connection = $db->connection('admin_panel');

    $donorCount = $connection->table('donors')->where('donor_type', 'member')->count();
    echo "   ✓ Found $donorCount member donors\n";

    $commitmentCount = $connection->table('donation_commitments')->count();
    echo "   ✓ Found $commitmentCount total commitments\n";
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== Setup verification complete ===\n";
