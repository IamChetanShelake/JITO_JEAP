<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\WorkingCommitteeApproval;
use Barryvdh\DomPDF\Facade\Pdf;

// Get a user (assuming there's at least one user)
$user = User::where('role', 'user')->first();

if (!$user) {
    echo "No users found in database.\n";
    exit;
}

echo "Testing PDF generation for user: " . $user->name . " (ID: " . $user->id . ")\n";

// Load related data
$user->load(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document']);

// Get working committee approval
$workingCommitteeApproval = WorkingCommitteeApproval::where('user_id', $user->id)->first();

if (!$workingCommitteeApproval) {
    echo "No working committee approval found for this user.\n";
    echo "Creating mock data for testing...\n";

    // Create mock working committee approval for testing
    $workingCommitteeApproval = (object) [
        'approval_financial_assistance_amount' => 1500000,
        'yearly_amounts' => [750000, 750000, 0, 0, 0, 0],
        'yearly_dates' => ['09/07/2025', '15/07/2025', '', '', '', ''],
        'no_of_cheques_to_be_collected' => 15,
        'installment_amount' => 100000,
        'repayment_starting_from' => '11/06/2027',
        'repayment_type' => 'Monthly'
    ];
}

$educationDetail = $user->educationDetail;

if (!$educationDetail) {
    echo "No education detail found. Creating mock data...\n";
    $educationDetail = (object) ['course_type' => 'FOREIGN FINANCIAL ASSISTANCE'];
}

try {
    // Generate PDF
    $pdf = Pdf::loadView('pdf.jeap-sanction-letter', compact('user', 'educationDetail', 'workingCommitteeApproval'));

    // Set paper size and orientation
    $pdf->setPaper('a4', 'portrait');

    // Save PDF to file for inspection
    $filename = 'test_sanction_letter_' . $user->id . '.pdf';
    $pdf->save(public_path($filename));

    echo "PDF generated successfully! Saved as: " . public_path($filename) . "\n";
    echo "You can now open the PDF file to check the formatting and layout.\n";

} catch (\Exception $e) {
    echo "Error generating PDF: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
