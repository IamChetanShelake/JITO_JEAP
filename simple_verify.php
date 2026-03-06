<?php

echo "Starting verification...\n";
flush();

require 'vendor/autoload.php';
echo "Autoloader loaded\n";
flush();

$app = require_once 'bootstrap/app.php';
echo "App bootstrapped\n";
flush();

echo "=== Testing Donation Commitment Setup ===\n\n";
flush();

// Test 1: Load models
echo "1. Loading models...\n";
flush();

try {
    $donorModel = new \App\Models\Donor();
    echo "   ✓ Donor model loaded\n";
    echo "     - Table: " . $donorModel->getTable() . "\n";
    flush();
} catch (\Throwable $e) {
    echo "   ✗ Donor Error: " . $e->getMessage() . "\n";
    flush();
}

try {
    $commitmentModel = new \App\Models\DonationCommitment();
    echo "   ✓ DonationCommitment model loaded\n";
    echo "     - Table: " . $commitmentModel->getTable() . "\n";
    flush();
} catch (\Throwable $e) {
    echo "   ✗ DonationCommitment Error: " . $e->getMessage() . "\n";
    flush();
}

echo "=== Complete ===\n";
flush();
