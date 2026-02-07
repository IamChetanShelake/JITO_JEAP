@extends('donor.layout.master')

@section('step')
    <button class="btn me-2" style="background-color:#393185;color:white;">
        Step 5 of 8
    </button>
@endsection

@section('content')

<div class="col-lg-9 main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

<form method="POST" action="{{ route('donor.step5.store') }}">
@csrf

<div class="card form-card">
<div class="card-body">

<h4 class="mb-4 text-center">Professional / Office Details</h4>

<!-- COMPANY DETAILS -->
<div class="row mb-3">
    <div class="col-md-6">
        <label>Company Name *</label>
        <input type="text" name="company_name" class="form-control" >
    </div>

    <div class="col-md-6">
        <label>Company Activity *</label>
        <input type="text" name="company_activity_details" class="form-control" >
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label>Designation *</label>
        <input type="text" name="designation" class="form-control" >
    </div>

    <div class="col-md-6">
        <label>Company Website *</label>
        <input type="url" name="company_website" class="form-control" >
    </div>
</div>

<hr>

<!-- OFFICE ADDRESS -->


<div class="row mb-3">
    <div class="col-md-12">
        <label>Office Address *</label>
        <textarea name="office_address" class="form-control" rows="2" ></textarea>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label>State *</label>
        <input type="text" name="office_state" class="form-control" >
    </div>

    <div class="col-md-4">
        <label>City *</label>
        <input type="text" name="office_city" class="form-control" >
    </div>

    <div class="col-md-4">
        <label>Pincode *</label>
        <input type="text" name="office_pincode" class="form-control" maxlength="6" >
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label>Telephone No *</label>
        <input type="text" name="office_telephone" class="form-control">
    </div>

    <div class="col-md-6">
        <label>Mobile No *</label>
        <input type="text" name="office_mobile" class="form-control" maxlength="10" >
    </div>
</div>

<hr>

<!-- PAN -->
<div class="row mb-3">
    <div class="col-md-6">
        <label>PAN No *</label>
        <input type="text" name="pan_no" class="form-control" maxlength="10" >
    </div>
</div>

<hr>

<!-- SECRETARY / COORDINATOR -->
<h5 class="mb-3">Secretary / Coordinator Details</h5>

<div class="row mb-3">
    <div class="col-md-6">
        <label>Name</label>
        <input type="text" name="coordinator_name" class="form-control" >
    </div>

    <div class="col-md-6">
        <label>Mobile No</label>
        <input type="text" name="coordinator_mobile" class="form-control" maxlength="10" >
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label>Email 1 *</label>
        <input type="email" name="coordinator_email_1" class="form-control" >
    </div>

    <div class="col-md-6">
        <label>Email 2</label>
        <input type="email" name="coordinator_email_2" class="form-control">
    </div>
</div>

</div>
</div>

<!-- BUTTONS -->
<div class="d-flex justify-content-between mt-4 mb-4">
    <a href="{{ route('donor.step4') }}" class="btn" style="background:#988DFF1F;color:gray;">
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
