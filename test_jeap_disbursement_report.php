<?php

/**
 * Test file for JEAP Disbursement Report Export
 * 
 * This file tests the JeapDisbursementReportExport functionality
 * Run: php test_jeap_disbursement_report.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Exports\JeapDisbursementReportExport;

echo "=== JEAP Disbursement Report Export Test ===\n\n";

// Test 1: Check if users exist with working committee approvals
echo "Test 1: Checking for users with working committee approvals...\n";
$usersWithApprovals = User::with(['workingCommitteeApproval', 'workflowStatus'])
    ->whereHas('workingCommitteeApproval')
    ->get();

echo "Found {$usersWithApprovals->count()} users with working committee approvals\n\n";

// Test 2: Check disbursement systems
echo "Test 2: Checking disbursement systems...\n";
$yearlyCount = User::whereHas('workingCommitteeApproval', function($q) {
    $q->where('disbursement_system', 'yearly');
})->count();

$halfYearlyCount = User::whereHas('workingCommitteeApproval', function($q) {
    $q->where('disbursement_system', 'half_yearly');
})->count();

echo "Yearly disbursement system: {$yearlyCount} users\n";
echo "Half-yearly disbursement system: {$halfYearlyCount} users\n\n";

// Test 3: Check installment data
echo "Test 3: Checking installment data...\n";
$usersWithInstallments = 0;
$totalInstallments = 0;

foreach ($usersWithApprovals as $user) {
    $approval = $user->workingCommitteeApproval;
    
    if ($approval->disbursement_system === 'yearly') {
        $dates = $approval->yearly_dates ?? [];
        $amounts = $approval->yearly_amounts ?? [];
    } else {
        $dates = $approval->half_yearly_dates ?? [];
        $amounts = $approval->half_yearly_amounts ?? [];
    }
    
    if (!empty($dates) && !empty($amounts)) {
        $usersWithInstallments++;
        $totalInstallments += count($dates);
        
        echo "User ID: {$user->id}, Name: {$user->name}\n";
        echo "  Disbursement System: {$approval->disbursement_system}\n";
        echo "  Installments: " . count($dates) . "\n";
        echo "  Meeting No: {$approval->meeting_no}\n";
        echo "  File Status: " . ($user->workflowStatus->file_status ?? 'N/A') . "\n\n";
    }
}

echo "Total users with installments: {$usersWithInstallments}\n";
echo "Total installments across all users: {$totalInstallments}\n\n";

// Test 4: Test export class instantiation
echo "Test 4: Testing export class instantiation...\n";
try {
    $export = new JeapDisbursementReportExport();
    echo "Export class instantiated successfully\n";
    
    $collection = $export->collection();
    echo "Collection retrieved: {$collection->count()} users\n\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n\n";
}

// Test 5: Test mapping
echo "Test 5: Testing data mapping...\n";
try {
    $export = new JeapDisbursementReportExport();
    $collection = $export->collection();
    
    $totalRows = 0;
    foreach ($collection as $user) {
        $rows = $export->map($user);
        $totalRows += count($rows);
    }
    
    echo "Total rows that will be generated in Excel: {$totalRows}\n\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n\n";
}

// Test 6: Test headings
echo "Test 6: Testing column headings...\n";
try {
    $export = new JeapDisbursementReportExport();
    $headings = $export->headings();
    
    echo "Column headings:\n";
    foreach ($headings as $index => $heading) {
        echo "  " . ($index + 1) . ". {$heading}\n";
    }
    echo "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n\n";
}

echo "=== Test Complete ===\n";
echo "\nTo download the Excel report, visit:\n";
echo "http://your-domain/admin/reports/jeap-disbursement\n";
echo "\nMake sure you are logged in as admin.\n";