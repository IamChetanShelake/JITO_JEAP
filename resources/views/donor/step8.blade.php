@extends('donor.layout.master')

@section('step')
    <button class="btn me-2" style="background-color:#393185;color:white;">
        Step 8 of 8
    </button>
@endsection

@section('content')

<div class="col-lg-9 main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

<form method="POST" action="{{ route('donor.step8.store') }}">
@csrf

<h4 class="mb-3 text-center">Step 8 : Review & Submit</h4>

<div class="form-group mt-4 p-3" style="border: 1px solid #ccc; border-radius: 8px; background-color: #f9f9f9;">
    <p>
        1. I agree to abide by the Code of Conduct and Memorandum & Articles of Association of JITO Education Assistance Foundation.<br>
        2. I I also agree to the condition that the contribution towards Membership fee shall be purely in the nature of donation. I am also aware that as per the provisions of the Memorandum of Association and the Articles of Association of the JITO Education Assistance Foundation, a Member is not eligible for any benefit, monetary or of any other kind, from the Company (JITO Education Assistance Foundation), and no such benefit can be demanded by the Member. <br>
        3. I also hereby agree to receive all communications on my email ID and mobile no. registered with JITO Education Assistance Foundation.
    </p>

    <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" name="agree_terms" id="agree_terms" value="1" required>
        <label class="form-check-label" for="agree_terms">
            I agree to the above terms and conditions
        </label>
    </div>
</div>




<!-- BUTTONS -->
<div class="d-flex justify-content-between mt-4 mb-4">
    <a href="{{ route('donor.step7') }}" class="btn" style="background:#988DFF1F;color:gray;">
        ← Previous
    </a>

    <button type="submit" class="btn" style="background:#393185;color:white;">
        Submit
    </button>
</div>

</form>

            </div>
        </div>
    </div>
</div>

@endsection
