@extends('user.layout.master')
@section('step')
    <button class="btn btn-purple me-2" style="background-color: #393185; color: white;">Step 4 of
        7</button>
@endsection

<script>
    // Pass existing funding data from database to JavaScript
    const existingFundingData = @json($existingFundingData ?? []);

    document.addEventListener('DOMContentLoaded', function() {
        // Function to populate funding table with existing data
        function populateFundingTable() {
            existingFundingData.forEach((funding, index) => {
                if (funding) {
                    // Update status select
                    const statusSelect = document.querySelector(`select[name="funding[${index}][status]"]`);
                    if (statusSelect && funding.status) {
                        statusSelect.value = funding.status;
                    }

                    // Update institute name
                    const instituteInput = document.querySelector(`input[name="funding[${index}][institute_name]"]`);
                    if (instituteInput && funding.institute_name) {
                        instituteInput.value = funding.institute_name;
                    }

                    // Update contact person
                    const contactInput = document.querySelector(`input[name="funding[${index}][contact_person]"]`);
                    if (contactInput && funding.contact_person) {
                        contactInput.value = funding.contact_person;
                    }

                    // Update contact number
                    const contactNoInput = document.querySelector(`input[name="funding[${index}][contact_no]"]`);
                    if (contactNoInput && funding.contact_no) {
                        contactNoInput.value = funding.contact_no;
                    }

                    // Update amount
                    const amountInput = document.querySelector(`input[name="funding[${index}][amount]"]`);
                    if (amountInput && funding.amount) {
                        amountInput.value = funding.amount;
                    }
                }
            });
        }

        // Function to toggle sibling assistance fields
        function toggleSiblingAssistanceFields() {
            const siblingAssistanceSelect = document.querySelector('select[name="sibling_assistance"]');
            const siblingAssistanceFields = document.querySelectorAll('.sibling-fields');

            if (siblingAssistanceSelect && siblingAssistanceSelect.value === 'yes') {
                siblingAssistanceFields.forEach(field => {
                    field.style.display = 'block';
                });
            } else {
                siblingAssistanceFields.forEach(field => {
                    field.style.display = 'none';
                });
            }
        }

        // Event listener for sibling assistance dropdown
        document.querySelector('select[name="sibling_assistance"]').addEventListener('change',
            toggleSiblingAssistanceFields);

        // Initialize sibling assistance fields on page load
        toggleSiblingAssistanceFields();

        // Function to calculate total amount
        function calculateTotal() {
            const amountInputs = document.querySelectorAll('tbody input[type="number"]:not([readonly])');
            let total = 0;
            amountInputs.forEach(input => {
                const value = parseFloat(input.value) || 0;
                total += value;
            });
            const totalInput = document.querySelector('tbody input[readonly]');
            if (totalInput) {
                totalInput.value = total;
            }
        }

        // Event listeners for amount inputs
        const amountInputs = document.querySelectorAll('tbody input[type="number"]:not([readonly])');
        amountInputs.forEach(input => {
            input.addEventListener('input', calculateTotal);
        });

        // Initialize total and populate table on page load
        calculateTotal();
        populateFundingTable();
    });
</script>
@section('content')
    <style>
        .section-divider {
            height: 1px;
            background: #e9ecef;
            margin: 30px 0;
        }
    </style>
    <!-- Main Content -->
    <div class="col-lg-9 main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('user.step4.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card form-card">
                            <div class="card-body">

                                <div class="step-card">
                                    <div class="card-icon">
                                        <i class="bi bi-currency-rupee"></i>
                                    </div>
                                    <div>
                                        <h3 class="card-title">Funding Details</h3>
                                        <p class="card-subtitle">Information about your funding sources</p>
                                    </div>
                                </div>

                                {{-- <!-- Section 1: Amount Fields -->
                                <div class="education-section">
                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <select class="form-control" name="amount_requested_year">
                                                    <option value=""
                                                        {{ !old('amount_requested_year') ? 'selected' : '' }} disabled
                                                        hidden>Amount requested for year *</option>
                                                    <option value="year1"
                                                        {{ old('amount_requested_year') == 'year1' ? 'selected' : '' }}>1st
                                                        Year</option>
                                                    <option value="year2"
                                                        {{ old('amount_requested_year') == 'year2' ? 'selected' : '' }}>2nd
                                                        Year</option>
                                                    <option value="year3"
                                                        {{ old('amount_requested_year') == 'year3' ? 'selected' : '' }}>3rd
                                                        Year</option>
                                                    <option value="year4"
                                                        {{ old('amount_requested_year') == 'year4' ? 'selected' : '' }}>4th
                                                        Year</option>
                                                    <option value="year5"
                                                        {{ old('amount_requested_year') == 'year4' ? 'selected' : '' }}>5th
                                                        Year</option>
                                                    <option value="year6"
                                                        {{ old('amount_requested_year') == 'year4' ? 'selected' : '' }}>6th
                                                        Year</option>
                                                </select>
                                                <small
                                                    class="text-danger">{{ $errors->first('amount_requested_year') }}</small>
                                            </div>
                                        </div>

                                            <!-- Right Column -->
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="sibling_ngo_name"
                                                        placeholder="NGO name? *" value="{{ old('sibling_ngo_name') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('sibling_ngo_name') }}</small>
                                                </div>

                                <!-- Section Divider -->
                                <div class="section-divider"></div> --}}

                                <!-- Section 2: Funding Details Table -->
                                <div class="education-section">
                                    {{-- <h4 class="title" style="color:#4C4C4C;font-size:18px;">Funding Details</h4> --}}

                                    <div class="table-responsive">
                                        <table class="table"
                                            style="background: white; border: none; border-collapse: collapse;font-size: 15px;">
                                            <thead style="background-color: #f8f9fa;">
                                                <tr style="border-bottom: 1px solid lightgray;">
                                                    <th class="text-start"
                                                        style="width: 22%; font-weight: 600; color: #4C4C4C; border: none;">
                                                        Particulars</th>
                                                    <th class="text-start"
                                                        style="width: 13%; font-weight: 600; color: #4C4C4C; border: none;">
                                                        Status</th>
                                                    <th class="text-start"
                                                        style="width: 18%; font-weight: 600; color: #4C4C4C; border: none;">
                                                        Name of Trust/Institute</th>
                                                    <th class="text-start"
                                                        style="width: 19%; font-weight: 600; color: #4C4C4C; border: none;">
                                                        Name of contact person</th>
                                                    <th class="text-start"
                                                        style="width: 13%; font-weight: 600; color: #4C4C4C; border: none;">
                                                        Contact No</th>
                                                    <th class="text-start"
                                                        style="width: 13%; font-weight: 600; color: #393185; border: none;">
                                                        Amount (Rs)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Row 1: Own family funding -->
                                                <tr style="border-bottom: 1px solid lightgray;">
                                                    <td style="font-weight: 500; border: none;">Own family funding (Father +
                                                        Mother)</td>
                                                    <td style="border: none;">
                                                        <select class="form-control form-control-sm" name="funding[0][status]">
                                                            <option value="">Select Status</option>
                                                            <option value="applied">Applied</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="received">Received</option>
                                                            <option value="pending">Pending</option>
                                                        </select>
                                                    </td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of Trust/Institute" name="funding[0][institute_name]"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of contact person" name="funding[0][contact_person]"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm" placeholder="Contact No" name="funding[0][contact_no]">
                                                    </td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" placeholder="00"
                                                            min="0" name="funding[0][amount]"></td>
                                                </tr>

                                                <!-- Row 2: Bank Loan -->
                                                <tr style="border-bottom: 1px solid lightgray; background-color: #f8f9fa;">
                                                    <td style="font-weight: 500; border: none;">Bank Loan</td>
                                                    <td style="border: none;">
                                                        <select class="form-control form-control-sm" name="funding[1][status]">
                                                            <option value="">Select Status</option>
                                                            <option value="applied">Applied</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="received">Received</option>
                                                            <option value="pending">Pending</option>
                                                        </select>
                                                    </td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of Trust/Institute" name="funding[1][institute_name]"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of contact person" name="funding[1][contact_person]"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm" placeholder="Contact No" name="funding[1][contact_no]">
                                                    </td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" placeholder="00"
                                                            min="0" name="funding[1][amount]"></td>
                                                </tr>

                                                <!-- Row 3: Other Assistance (1) -->
                                                <tr style="border-bottom: 1px solid lightgray;">
                                                    <td style="font-weight: 500; border: none;">Other Assistance (1)</td>
                                                    <td style="border: none;">
                                                        <select class="form-control form-control-sm" name="funding[2][status]">
                                                            <option value="">Select Status</option>
                                                            <option value="applied">Applied</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="received">Received</option>
                                                            <option value="pending">Pending</option>
                                                        </select>
                                                    </td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of Trust/Institute" name="funding[2][institute_name]"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of contact person" name="funding[2][contact_person]"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm" placeholder="Contact No" name="funding[2][contact_no]">
                                                    </td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" placeholder="00"
                                                            min="0" name="funding[2][amount]"></td>
                                                </tr>

                                                <!-- Row 4: Other Assistance (2) -->
                                                <tr style="border-bottom: 1px solid lightgray; background-color: #f8f9fa;">
                                                    <td style="font-weight: 500; border: none;">Other Assistance (2)</td>
                                                    <td style="border: none;">
                                                        <select class="form-control form-control-sm" name="funding[3][status]">
                                                            <option value="">Select Status</option>
                                                            <option value="applied">Applied</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="received">Received</option>
                                                            <option value="pending">Pending</option>
                                                        </select>
                                                    </td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of Trust/Institute" name="funding[3][institute_name]"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of contact person" name="funding[3][contact_person]"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm" placeholder="Contact No" name="funding[3][contact_no]">
                                                    </td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" placeholder="00"
                                                            min="0" name="funding[3][amount]"></td>
                                                </tr>

                                                <!-- Row 5: Local Assistance -->
                                                <tr style="border-bottom: 1px solid lightgray;">
                                                    <td style="font-weight: 500; border: none;">Local Assistance</td>
                                                    <td style="border: none;">
                                                        <select class="form-control form-control-sm" name="funding[4][status]">
                                                            <option value="">Select Status</option>
                                                            <option value="applied">Applied</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="received">Received</option>
                                                            <option value="pending">Pending</option>
                                                        </select>
                                                    </td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of Trust/Institute" name="funding[4][institute_name]"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of contact person" name="funding[4][contact_person]"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm" placeholder="Contact No" name="funding[4][contact_no]">
                                                    </td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" placeholder="00"
                                                            min="0" name="funding[4][amount]"></td>
                                                </tr>

                                                <!-- Total Row -->
                                                <tr>
                                                    <td colspan="5"
                                                        style="font-weight: 600; border: none; text-align: right; color: #393185;">
                                                        Total ₹</td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" style="font-weight: 600;"
                                                            placeholder="00" min="0" readonly></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Section Divider -->
                                <div class="section-divider"></div>

                                <!-- Section 3: Brother/Sister Assistance -->
                                <div class="education-section">
                                    <h4 class="title" style="color:#4C4C4C;font-size:18px;">Have your Brother/Sister
                                        received financial assistance<br> from JITO JEAP/ JATF/SEED or JITO Chapter?
                                    </h4>

                                    <!-- Additional Fields when Yes is selected -->
                                    {{-- <div id="sibling-assistance-fields">
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <select class="form-control" name="sibling_assistance">
                                                        <option value=""
                                                            {{ !old('sibling_assistance') ? 'selected' : '' }} disabled hidden>
                                                            Yes/No*
                                                        </option>
                                                        <option value="yes"
                                                            {{ old('sibling_assistance') == 'yes' ? 'selected' : '' }}>Yes
                                                        </option>
                                                        <option value="no"
                                                            {{ old('sibling_assistance') == 'no' ? 'selected' : '' }}>No
                                                        </option>
                                                    </select>
                                                    <small
                                                        class="text-danger">{{ $errors->first('sibling_assistance') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="sibling-fields" style="display: none;">
                                        <div class="row">
                                            <!-- Left Column -->
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="sibling_name"
                                                        placeholder="Sibling name *" value="{{ old('sibling_name') }}">
                                                    <small class="text-danger">{{ $errors->first('sibling_name') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="sibling_number"
                                                        placeholder="Sibling number *"
                                                        value="{{ old('sibling_number') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('sibling_number') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="ngo_number"
                                                        placeholder="NGO Phone number *" value="{{ old('ngo_number') }}">
                                                    <small class="text-danger">{{ $errors->first('ngo_number') }}</small>
                                                </div>
                                            </div>

                                            <!-- Right Column -->
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="sibling_ngo_name"
                                                        placeholder="NGO name? *" value="{{ old('sibling_ngo_name') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('sibling_ngo_name') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="sibling_loan_status"
                                                        placeholder="Loan status? *"
                                                        value="{{ old('sibling_loan_status') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('sibling_loan_status') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control"
                                                        name="sibling_applied_year" placeholder="Applied for year? *"
                                                        value="{{ old('sibling_applied_year') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('sibling_applied_year') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <input type="number" class="form-control"
                                                        name="sibling_applied_amount" placeholder="Applied amount? *"
                                                        min="0" value="{{ old('sibling_applied_amount') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('sibling_applied_amount') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <!-- Sibling Assistance Wrapper -->
                                    {{-- <div id="sibling-assistance-fields">

                                        <div class="row mt-4">

                                            <!-- Left Column -->
                                            <div class="col-md-6">

                                                <!-- Yes / No Dropdown (Moved here) -->
                                                <div class="form-group mb-3">
                                                    <select class="form-control" name="sibling_assistance">
                                                        <option value=""
                                                            {{ !old('sibling_assistance') ? 'selected' : '' }} disabled
                                                            hidden>
                                                            Yes/No *
                                                        </option>
                                                        <option value="yes"
                                                            {{ old('sibling_assistance') == 'yes' ? 'selected' : '' }}>
                                                            Yes
                                                        </option>
                                                        <option value="no"
                                                            {{ old('sibling_assistance') == 'no' ? 'selected' : '' }}>
                                                            No
                                                        </option>
                                                    </select>
                                                    <small
                                                        class="text-danger">{{ $errors->first('sibling_assistance') }}</small>
                                                </div>

                                                <!-- Left side fields -->
                                                <div id="sibling-fields" style="display: none;">
                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control" name="sibling_name"
                                                            placeholder="Sibling name *"
                                                            value="{{ old('sibling_name') }}">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control" name="sibling_number"
                                                            placeholder="Sibling number *"
                                                            value="{{ old('sibling_number') }}">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control" name="ngo_number"
                                                            placeholder="NGO Phone number *"
                                                            value="{{ old('ngo_number') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right Column -->
                                            <div class="col-md-6">
                                                <div id="sibling-fields" style="display: none;">

                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control"
                                                            name="sibling_ngo_name" placeholder="NGO name *"
                                                            value="{{ old('sibling_ngo_name') }}">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control"
                                                            name="sibling_loan_status" placeholder="Loan status *"
                                                            value="{{ old('sibling_loan_status') }}">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control"
                                                            name="sibling_applied_year" placeholder="Applied for year *"
                                                            value="{{ old('sibling_applied_year') }}">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <input type="number" class="form-control"
                                                            name="sibling_applied_amount" placeholder="Applied amount *"
                                                            min="0" value="{{ old('sibling_applied_amount') }}">
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div> --}}

                                    <div id="sibling-assistance-fields">

                                        {{-- <div class="row mt-4">

                                            <!-- Yes / No Dropdown -->
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <select class="form-control" name="sibling_assistance">
                                                        <option value=""
                                                            {{ !old('sibling_assistance') ? 'selected' : '' }} disabled
                                                            hidden>
                                                            Yes/No *
                                                        </option>
                                                        <option value="yes"
                                                            {{ old('sibling_assistance') == 'yes' ? 'selected' : '' }}>
                                                            Yes
                                                        </option>
                                                        <option value="no"
                                                            {{ old('sibling_assistance') == 'no' ? 'selected' : '' }}>
                                                            No
                                                        </option>
                                                    </select>
                                                    <small
                                                        class="text-danger">{{ $errors->first('sibling_assistance') }}</small>
                                                </div>
                                            </div>

                                        </div> --}}

                                        <!-- ✅ BOTH COLUMNS WRAPPED INSIDE ONE DIV -->
                                        {{-- <div id="sibling-fields" style="display:none;"> --}}
                                        <div class="row">

                                            <!-- Left Column -->
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <select class="form-control" name="sibling_assistance">
                                                        <option value=""
                                                            {{ (!old('sibling_assistance') && !$fundingDetail) ? 'selected' : '' }} disabled
                                                            hidden>
                                                            Yes/No *
                                                        </option>
                                                        <option value="yes"
                                                            {{ (old('sibling_assistance') == 'yes' || $fundingDetail && $fundingDetail->sibling_assistance === 'yes') ? 'selected' : '' }}>
                                                            Yes
                                                        </option>
                                                        <option value="no"
                                                            {{ (old('sibling_assistance') == 'no' || $fundingDetail && $fundingDetail->sibling_assistance === 'no') ? 'selected' : '' }}>
                                                            No
                                                        </option>
                                                    </select>
                                                    <small
                                                        class="text-danger">{{ $errors->first('sibling_assistance') }}</small>
                                                </div>
                                                <div class="sibling-fields" style="display:none;">
                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control" name="sibling_name"
                                                            placeholder="Sibling name *"
                                                            value="{{ old('sibling_name', $fundingDetail->sibling_name ?? '') }}">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control" name="sibling_number"
                                                            placeholder="Sibling number *"
                                                            value="{{ old('sibling_number', $fundingDetail->sibling_number ?? '') }}">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control"
                                                            name="sibling_ngo_name" placeholder="NGO name *"
                                                            value="{{ old('sibling_ngo_name', $fundingDetail->sibling_ngo_name ?? '') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right Column -->
                                            <div class="col-md-6">
                                                <div class="sibling-fields" style="display:none;">
                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control" name="ngo_number"
                                                            placeholder="NGO Phone number *"
                                                            value="{{ old('ngo_number', $fundingDetail->ngo_number ?? '') }}">
                                                    </div>


                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control"
                                                            name="sibling_loan_status" placeholder="Loan status *"
                                                            value="{{ old('sibling_loan_status', $fundingDetail->sibling_loan_status ?? '') }}">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control"
                                                            name="sibling_applied_year" placeholder="Applied for year *"
                                                            value="{{ old('sibling_applied_year', $fundingDetail->sibling_applied_year ?? '') }}">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <input type="number" class="form-control"
                                                            name="sibling_applied_amount" placeholder="Applied amount *"
                                                            min="0" value="{{ old('sibling_applied_amount', $fundingDetail->sibling_applied_amount ?? '') }}">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>

                            <!-- Section Divider -->
                            <div class="section-divider"></div>

                            <!-- Section 4: Bank Details -->
                            <div class="education-section">
                                <h4 class="title" style="color:#4C4C4C;font-size:18px;">Bank Details of Applicant
                                </h4>

                                <!-- Important Note Box -->
                                <div
                                    style="background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 12px; margin-bottom: 20px;">
                                    <p class="mb-0" style="color: #E31E24; font-size: 15px;">
                                        <b>Note </b>: Kindly share the student’s bank details. Please ensure the account is
                                        a major account in the student’s name, as minor accounts are not valid. If the
                                        application is sanctioned, post-dated cheques (PDCs) will be required and the
                                        details will be verified. Any mismatch may lead to action by management. So, request
                                        you to provide correct details.
                                        <br><br>
                                        We only accept cheques of Government Nationalized bank and Private banks (HDFC Bank,
                                        ICICI Bank, Kotak Mahindra Bank, Axis Bank, IndusInd Bank, IDBI Bank, Yes Bank, IDFC
                                        First Bank, etc).
                                    </p>
                                </div>

                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">

                                        <div class="form-group mb-3">
                                            <select class="form-control" name="bank_name">
                                                <option value="" {{ (!old('bank_name') && !$fundingDetail) ? 'selected' : '' }} disabled
                                                    hidden>Select Bank *</option>
                                                <option value="HDFC Bank"
                                                    {{ (old('bank_name') == 'HDFC Bank' || $fundingDetail && $fundingDetail->bank_name === 'HDFC Bank') ? 'selected' : '' }}>HDFC Bank
                                                </option>
                                                <option value="ICICI Bank"
                                                    {{ (old('bank_name') == 'ICICI Bank' || $fundingDetail && $fundingDetail->bank_name === 'ICICI Bank') ? 'selected' : '' }}>ICICI Bank
                                                </option>
                                                <option value="Kotak Mahindra Bank"
                                                    {{ (old('bank_name') == 'Kotak Mahindra Bank' || $fundingDetail && $fundingDetail->bank_name === 'Kotak Mahindra Bank') ? 'selected' : '' }}>Kotak
                                                    Mahindra Bank</option>
                                                <option value="Axis Bank"
                                                    {{ (old('bank_name') == 'Axis Bank' || $fundingDetail && $fundingDetail->bank_name === 'Axis Bank') ? 'selected' : '' }}>Axis Bank
                                                </option>
                                                <option value="IndusInd Bank"
                                                    {{ (old('bank_name') == 'IndusInd Bank' || $fundingDetail && $fundingDetail->bank_name === 'IndusInd Bank') ? 'selected' : '' }}>IndusInd
                                                    Bank</option>
                                                <option value="IDBI Bank"
                                                    {{ (old('bank_name') == 'IDBI Bank' || $fundingDetail && $fundingDetail->bank_name === 'IDBI Bank') ? 'selected' : '' }}>IDBI Bank
                                                </option>
                                                <option value="Yes Bank"
                                                    {{ (old('bank_name') == 'Yes Bank' || $fundingDetail && $fundingDetail->bank_name === 'Yes Bank') ? 'selected' : '' }}>Yes Bank
                                                </option>
                                                <option value="IDFC First Bank"
                                                    {{ (old('bank_name') == 'IDFC First Bank' || $fundingDetail && $fundingDetail->bank_name === 'IDFC First Bank') ? 'selected' : '' }}>IDFC
                                                    First Bank</option>
                                                <option value="State Bank of India"
                                                    {{ (old('bank_name') == 'State Bank of India' || $fundingDetail && $fundingDetail->bank_name === 'State Bank of India') ? 'selected' : '' }}>State
                                                    Bank of India</option>
                                                <option value="Punjab National Bank"
                                                    {{ (old('bank_name') == 'Punjab National Bank' || $fundingDetail && $fundingDetail->bank_name === 'Punjab National Bank') ? 'selected' : '' }}>
                                                    Punjab National Bank</option>
                                                <option value="Bank of Baroda"
                                                    {{ (old('bank_name') == 'Bank of Baroda' || $fundingDetail && $fundingDetail->bank_name === 'Bank of Baroda') ? 'selected' : '' }}>Bank of
                                                    Baroda</option>
                                                <option value="Canara Bank"
                                                    {{ (old('bank_name') == 'Canara Bank' || $fundingDetail && $fundingDetail->bank_name === 'Canara Bank') ? 'selected' : '' }}>Canara Bank
                                                </option>
                                                <option value="Union Bank of India"
                                                    {{ (old('bank_name') == 'Union Bank of India' || $fundingDetail && $fundingDetail->bank_name === 'Union Bank of India') ? 'selected' : '' }}>Union
                                                    Bank of India</option>
                                            </select>
                                            <small class="text-danger">{{ $errors->first('bank_name') }}</small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" name="account_holder_name"
                                                placeholder="Account Holder's Name *"
                                                value="{{ old('account_holder_name', $fundingDetail->account_holder_name ?? '') }}">
                                            <small class="text-danger">{{ $errors->first('account_holder_name') }}</small>
                                        </div>


                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" name="account_number"
                                                placeholder="Account Number *" value="{{ old('account_number', $fundingDetail->account_number ?? '') }}">
                                            <small class="text-danger">{{ $errors->first('account_number') }}</small>
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" name="branch_name"
                                                placeholder="Branch Name *" value="{{ old('branch_name', $fundingDetail->branch_name ?? '') }}">
                                            <small class="text-danger">{{ $errors->first('branch_name') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" name="ifsc_code"
                                                placeholder="IFSC Code *" value="{{ old('ifsc_code', $fundingDetail->ifsc_code ?? '') }}">
                                            <small class="text-danger">{{ $errors->first('ifsc_code') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <textarea class="form-control" name="bank_address" rows="3" placeholder="Bank Address *"
                                                style="resize: vertical;">{{ old('bank_address', $fundingDetail->bank_address ?? '') }}</textarea>
                                            <small class="text-danger">{{ $errors->first('bank_address') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>









                        </div>
                </div>
                <div class="d-flex justify-content-between mt-4 mb-4">
                    <button type="button" class="btn " style="background:#988DFF1F;color:gray;"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            stroke="gray" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M15 18l-6-6 6-6" />
                        </svg>

                        Previous</button>
                    <button type="submit" class="btn" style="background:#393185;color:white;">Next Step
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            stroke="white" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 6l6 6-6 6" />
                        </svg>

                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to toggle sibling assistance fields
            function toggleSiblingAssistanceFields() {
                const siblingAssistanceSelect = document.querySelector('select[name="sibling_assistance"]');
                const siblingAssistanceFields = document.querySelectorAll('.sibling-fields');

                if (siblingAssistanceSelect && siblingAssistanceSelect.value === 'yes') {
                    siblingAssistanceFields.forEach(field => {
                        field.style.display = 'block';
                    });
                } else {
                    siblingAssistanceFields.forEach(field => {
                        field.style.display = 'none';
                    });
                }
            }

            // Event listener for sibling assistance dropdown
            document.querySelector('select[name="sibling_assistance"]').addEventListener('change',
                toggleSiblingAssistanceFields);

            // Initialize sibling assistance fields on page load
            toggleSiblingAssistanceFields();

            // Function to calculate total amount
            function calculateTotal() {
                const amountInputs = document.querySelectorAll('tbody input[type="number"]:not([readonly])');
                let total = 0;
                amountInputs.forEach(input => {
                    const value = parseFloat(input.value) || 0;
                    total += value;
                });
                const totalInput = document.querySelector('tbody input[readonly]');
                if (totalInput) {
                    totalInput.value = total;
                }
            }

            // Event listeners for amount inputs
            const amountInputs = document.querySelectorAll('tbody input[type="number"]:not([readonly])');
            amountInputs.forEach(input => {
                input.addEventListener('input', calculateTotal);
            });

            // Initialize total on page load
            calculateTotal();
        });
    </script>
@endsection
