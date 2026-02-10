@extends('donor.layout.master')

@section('step')
    <button class="btn me-2" style="background-color:#393185;color:white;">
        Step 4 of 8
    </button>
@endsection

@section('content')

<div class="col-lg-9 main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

<form method="POST" action="{{ route('donor.step4.store') }}">
@csrf

@php
    $selectedPayments = old('payment_options', $membershipDetail ? (json_decode($membershipDetail->payment_options, true) ?: []) : []);
@endphp

<div class="card form-card">
<div class="card-body">

<h4 class="mb-4 text-center">Membership Fees Payment Schedule</h4>

<p>
    <strong>JITO Education Assistance Foundation Membership:</strong><br>
    I wish to become JITO Education Assistance Foundation member as follows
    (please tick ✓ in appropriate box)
</p>

<p>
    An individual JITO member can become a member of JITO Education Assistance
    Foundation by paying upfront payment of <strong>Rs. 54 Lakhs</strong>.
</p>

<hr>

<!-- CHECKBOX OPTIONS -->
<div class="mb-3">

    <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" name="payment_options[]" value="54_lakhs" {{ in_array('54_lakhs', $selectedPayments, true) ? 'checked' : '' }}>
        <label class="form-check-label">
            Rs. 54 Lakhs at time of Application
        </label>
    </div>

    <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" name="payment_options[]" value="1_year" {{ in_array('1_year', $selectedPayments, true) ? 'checked' : '' }}>
        <label class="form-check-label">
            1<sup>st</sup> Installment of Rs. 17 Lakhs within 1<sup>st</sup> year of application
        </label>
    </div>

    <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" name="payment_options[]" value="2_year" {{ in_array('2_year', $selectedPayments, true) ? 'checked' : '' }}>
        <label class="form-check-label">
            2<sup>nd</sup> Installment of Rs. 17 Lakhs within 2<sup>nd</sup> year of application
        </label>
    </div>

    <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" name="payment_options[]" value="3_year" {{ in_array('3_year', $selectedPayments, true) ? 'checked' : '' }}>
        <label class="form-check-label">
            3<sup>rd</sup> Installment of Rs. 17 Lakhs within 3<sup>rd</sup> year of application
        </label>
    </div>

</div>

<hr>

<p class="text-muted" style="font-size:14px;">
    The terms of membership and payment will be governed by the
    Article of Association of JITO Education Assistance Foundation.
</p>

</div>
</div>

<!-- BUTTONS -->
<div class="d-flex justify-content-between mt-4 mb-4">
    <a href="{{ route('donor.step3') }}" class="btn" style="background:#988DFF1F;color:gray;">
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
