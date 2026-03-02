<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

use App\Models\Donor;
use App\Models\DonationCommitment;

try {
    // Get first member donor
    $donor = Donor::where('donor_type', 'member')->first();

    if (!$donor) {
        echo "No member donors found in database.\n";
        exit(1);
    }

    echo "Found donor: {$donor->name} (ID: {$donor->id})\n";
    echo "Donor type: {$donor->donor_type}\n\n";

    // Test creating a commitment
    echo "Testing commitment creation...\n";

    $commitment = $donor->commitments()->create([
        'committed_amount' => 500000,
        'start_date' => now()->toDateString(),
        'end_date' => now()->addYear()->toDateString(),
        'status' => 'active',
    ]);

    echo "✓ Commitment created successfully!\n";
    echo "  ID: {$commitment->id}\n";
    echo "  Amount: ₹{$commitment->committed_amount}\n";
    echo "  Status: {$commitment->status}\n";
    echo "  Start Date: {$commitment->start_date}\n";
    echo "  End Date: {$commitment->end_date}\n\n";

    // Verify it was actually saved
    $retrieved = DonationCommitment::find($commitment->id);
    if ($retrieved) {
        echo "✓ Commitment verified in database!\n";
        echo "  Retrieved Amount: ₹{$retrieved->committed_amount}\n";
    } else {
        echo "✗ Commitment not found in database!\n";
    }
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}
