<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Document;
use App\Models\Loan_category;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Step6StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that step6store correctly stores documents by calling the controller method directly.
     */
    public function test_step6store_stores_documents_directly(): void
    {
        // Create a user with required fields
        $user = User::factory()->create([
            'financial_asset_type' => 'domestic',
            'financial_asset_for' => 'post_graduation',
            'role' => 'user',
        ]);

        // Create a loan category for the user
        Loan_category::create([
            'user_id' => $user->id,
            'type' => 'education',
        ]);

        // Authenticate the user
        Auth::login($user);

        // Create fake files
        $files = [];
        $fileFields = [
            'ssc_cbse_icse_ib_igcse',
            'hsc_diploma_marksheet',
            'graduate_post_graduate_marksheet',
            'admission_letter_fees_structure',
            'aadhaar_applicant',
            'pan_applicant',
            'student_bank_details_statement',
            'jito_group_recommendation',
            'jain_sangh_certificate',
            'electricity_bill',
            'itr_acknowledgement_father',
            'itr_computation_father',
            'form16_salary_income_father',
            'bank_statement_father_12months',
            'bank_statement_mother_12months',
            'aadhaar_father_mother',
            'pan_father_mother',
            'guarantor1_aadhaar',
            'guarantor1_pan',
            'guarantor2_aadhaar',
            'guarantor2_pan',
            'student_handwritten_statement',
            'proof_funds_arranged',
            'other_documents',
            'extra_curricular'
        ];

        $requestData = [];
        foreach ($fileFields as $field) {
            $uploadedFile = UploadedFile::fake()->create($field . '.pdf', 1000);
            $files[$field] = $uploadedFile;
            $requestData[$field] = $uploadedFile;
        }

        // Create a request instance
        $request = new Request();
        $request->merge($requestData);
        $request->files->add($files);

        // Instantiate the controller
        $controller = new UserController();

        // Call the step6store method
        $response = $controller->step6store($request);

        // Assert document was created in database
        $this->assertDatabaseHas('documents', [
            'user_id' => $user->id,
        ]);

        // Get the created document
        $document = Document::where('user_id', $user->id)->first();
        $this->assertNotNull($document);

        // Assert all file paths are stored
        foreach ($fileFields as $field) {
            $this->assertNotNull($document->$field, "Field $field should not be null");
            $this->assertStringStartsWith('user_document_images/', $document->$field, "Field $field should start with user_document_images/");
        }

        // Assert response is a redirect
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('user/Step7', $response->getTargetUrl());
    }
}
