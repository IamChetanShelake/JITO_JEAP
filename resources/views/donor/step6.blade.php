@extends('donor.layout.master')

@section('step')
    <button class="btn me-2" style="background-color:#393185;color:white;">
        Step 6 of 8
    </button>
@endsection

@section('content')

<div class="col-lg-9 main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

<form method="POST" action="{{ route('donor.step6.store') }}">
@csrf

<h4 class="mb-3 text-center">Step 6 : Document Upload</h4>

<div class="card mb-4">
    <div class="card-body">

        <h5 class="mb-3">Mandatory Documents</h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>PAN Card Copy of Member *</label>
                <input type="file" class="form-control" name="pan_member_file" >
            </div>

            <div class="col-md-6 mb-3">
                <label>PAN Card Copy of Donor (If Different) *</label>
                <input type="file" class="form-control" name="pan_donor_file" >
            </div>

            <div class="col-md-6 mb-3">
                <label>Passport Size Photograph *</label>
                <input type="file" class="form-control" name="photo_file" >
            </div>

            <div class="col-md-6 mb-3">
                <label>Address Proof *</label>
                <input type="file" class="form-control" name="address_proof_file" >
            </div>

            <div class="col-md-6 mb-3">
                <label>Company Authorization Letter *</label>
                <input type="file" class="form-control" name="authorization_letter_file" >
            </div>
        </div>

    </div>
</div>

<!-- CHECKLIST -->
<div class="card mb-4">
    <div class="card-body">

        <h5 class="mb-3">Most Important Things to Check</h5>

        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="check_signature">
            <label class="form-check-label">
                Member’s Signature on Form
            </label>
        </div>

        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="check_contact">
            <label class="form-check-label">
                Mobile Number & Email Address Mentioned
            </label>
        </div>

        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="check_nominee">
            <label class="form-check-label">
                Nominee Name & Details Filled
            </label>
        </div>

        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="check_pan">
            <label class="form-check-label">
                PAN Card Copy Attached
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="check_payment">
            <label class="form-check-label">
                Payment Details Filled Properly
            </label>
        </div>

    </div>
</div>


<!-- BUTTONS -->
<div class="d-flex justify-content-between mt-4 mb-4">
    <a href="{{ route('donor.step5') }}" class="btn" style="background:#988DFF1F;color:gray;">
        ← Previous
    </a>

    <button type="submit" class="btn" style="background:#393185;color:white;">
        Next Step →
    </button>
</div>

</form>

            </div>
        </div>
    </div>
</div>

@endsection
