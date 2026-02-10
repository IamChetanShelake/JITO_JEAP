<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Donor;
use App\Models\DonorPaymentDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DonorWebControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_donor_payment_details()
    {
        // Create a test donor
        $donor = Donor::create([
            'name' => 'Test Donor',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'submit_status' => 'pending',
        ]);

        // Create payment data
        $paymentData = [
            'utr_no' => ['UTR123456', 'UTR654321'],
            'cheque_date' => ['2023-10-05', '2023-10-10'],
            'amount' => ['50000', '100000'],
            'bank_branch' => ['ICICI Bank, Mumbai', 'HDFC Bank, Delhi'],
            'issued_by' => ['John Doe', 'Jane Smith'],
        ];

        // Acting as the test donor
        $this->actingAs($donor, 'donor');

        // Make a POST request to store payment details
        $response = $this->post(route('donor.step7.store'), $paymentData);

        // Check if the response is successful and redirects to step8
        $response->assertStatus(302);
        $response->assertRedirect(route('donor.step8'));
        $response->assertSessionHas('success', 'Payment details saved successfully!');

        // Check if payment details were stored in the database
        $this->assertCount(1, DonorPaymentDetail::where('donor_id', $donor->id)->get());
        $paymentDetail = DonorPaymentDetail::where('donor_id', $donor->id)->first();

        $this->assertEquals('submited', $paymentDetail->submit_status);

        // Check if payment entries are stored as JSON
        $this->assertNotNull($paymentDetail->payment_entries);
        $this->assertIsString($paymentDetail->payment_entries);

        $entries = json_decode($paymentDetail->payment_entries, true);
        $this->assertCount(2, $entries);

        // Verify the first payment entry
        $this->assertEquals('UTR123456', $entries[0]['utr_no']);
        $this->assertEquals('2023-10-05', $entries[0]['cheque_date']);
        $this->assertEquals('50000', $entries[0]['amount']);
        $this->assertEquals('ICICI Bank, Mumbai', $entries[0]['bank_branch']);
        $this->assertEquals('John Doe', $entries[0]['issued_by']);

        // Verify the second payment entry
        $this->assertEquals('UTR654321', $entries[1]['utr_no']);
        $this->assertEquals('2023-10-10', $entries[1]['cheque_date']);
        $this->assertEquals('100000', $entries[1]['amount']);
        $this->assertEquals('HDFC Bank, Delhi', $entries[1]['bank_branch']);
        $this->assertEquals('Jane Smith', $entries[1]['issued_by']);
    }
}
