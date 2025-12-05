@extends('user.layout.master')
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
                    <form method="POST" action="" enctype="multipart/form-data">
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

                                <!-- Section 1: Amount Fields -->
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
                                                <input type="number" class="form-control" name="tuition_fees_amount"
                                                    placeholder="Amount tuition fees in Indian rupees *" min="0"
                                                    value="{{ old('tuition_fees_amount') }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('tuition_fees_amount') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section Divider -->
                                <div class="section-divider"></div>

                                <!-- Section 2: Funding Details Table -->
                                <div class="education-section">
                                    <h4 class="title" style="color:#4C4C4C;font-size:18px;">Funding Details</h4>

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
                                                        <select class="form-control form-control-sm">
                                                            <option value="">Select Status</option>
                                                            <option value="applied">Applied</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="received">Received</option>
                                                            <option value="pending">Pending</option>
                                                        </select>
                                                    </td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of Trust/Institute"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of contact person"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm" placeholder="Contact No">
                                                    </td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" placeholder="00"
                                                            min="0"></td>
                                                </tr>

                                                <!-- Row 2: Bank Loan -->
                                                <tr style="border-bottom: 1px solid lightgray; background-color: #f8f9fa;">
                                                    <td style="font-weight: 500; border: none;">Bank Loan</td>
                                                    <td style="border: none;">
                                                        <select class="form-control form-control-sm">
                                                            <option value="">Select Status</option>
                                                            <option value="applied">Applied</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="received">Received</option>
                                                            <option value="pending">Pending</option>
                                                        </select>
                                                    </td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of Trust/Institute"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of contact person"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm" placeholder="Contact No">
                                                    </td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" placeholder="00"
                                                            min="0"></td>
                                                </tr>

                                                <!-- Row 3: Other Assistance (1) -->
                                                <tr style="border-bottom: 1px solid lightgray;">
                                                    <td style="font-weight: 500; border: none;">Other Assistance (1)</td>
                                                    <td style="border: none;">
                                                        <select class="form-control form-control-sm">
                                                            <option value="">Select Status</option>
                                                            <option value="applied">Applied</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="received">Received</option>
                                                            <option value="pending">Pending</option>
                                                        </select>
                                                    </td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of Trust/Institute"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of contact person"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm" placeholder="Contact No">
                                                    </td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" placeholder="00"
                                                            min="0"></td>
                                                </tr>

                                                <!-- Row 4: Other Assistance (2) -->
                                                <tr style="border-bottom: 1px solid lightgray; background-color: #f8f9fa;">
                                                    <td style="font-weight: 500; border: none;">Other Assistance (2)</td>
                                                    <td style="border: none;">
                                                        <select class="form-control form-control-sm">
                                                            <option value="">Select Status</option>
                                                            <option value="applied">Applied</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="received">Received</option>
                                                            <option value="pending">Pending</option>
                                                        </select>
                                                    </td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of Trust/Institute"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of contact person"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm" placeholder="Contact No">
                                                    </td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" placeholder="00"
                                                            min="0"></td>
                                                </tr>

                                                <!-- Row 5: Local Assistance -->
                                                <tr style="border-bottom: 1px solid lightgray;">
                                                    <td style="font-weight: 500; border: none;">Local Assistance</td>
                                                    <td style="border: none;">
                                                        <select class="form-control form-control-sm">
                                                            <option value="">Select Status</option>
                                                            <option value="applied">Applied</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="received">Received</option>
                                                            <option value="pending">Pending</option>
                                                        </select>
                                                    </td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of Trust/Institute"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm"
                                                            placeholder="Name of contact person"></td>
                                                    <td style="border: none;"><input type="text"
                                                            class="form-control form-control-sm" placeholder="Contact No">
                                                    </td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" placeholder="00"
                                                            min="0"></td>
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
                                        received financial assistance from JITO JEAP/ JATF/SEED or JITO Chapter?
                                    </h4>

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

                                    <!-- Additional Fields when Yes is selected -->
                                    <div id="sibling-assistance-fields" style="display: none;">
                                        <div class="row">
                                            <!-- Left Column -->
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="sibling_ngo_name"
                                                        placeholder="NGO name? *" value="{{ old('sibling_ngo_name') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('sibling_ngo_name') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <select class="form-control" name="sibling_loan_status">
                                                        <option value=""
                                                            {{ !old('sibling_loan_status') ? 'selected' : '' }} disabled
                                                            hidden>Loan status? *</option>
                                                        <option value="applied"
                                                            {{ old('sibling_loan_status') == 'applied' ? 'selected' : '' }}>
                                                            Applied</option>
                                                        <option value="approved"
                                                            {{ old('sibling_loan_status') == 'approved' ? 'selected' : '' }}>
                                                            Approved</option>
                                                        <option value="received"
                                                            {{ old('sibling_loan_status') == 'received' ? 'selected' : '' }}>
                                                            Received</option>
                                                        <option value="pending"
                                                            {{ old('sibling_loan_status') == 'pending' ? 'selected' : '' }}>
                                                            Pending</option>
                                                    </select>
                                                    <small
                                                        class="text-danger">{{ $errors->first('sibling_loan_status') }}</small>
                                                </div>
                                            </div>

                                            <!-- Right Column -->
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <select class="form-control" name="sibling_applied_year">
                                                        <option value=""
                                                            {{ !old('sibling_applied_year') ? 'selected' : '' }} disabled
                                                            hidden>Applied for year? *</option>
                                                        <option value="1st_year"
                                                            {{ old('sibling_applied_year') == '1st_year' ? 'selected' : '' }}>
                                                            1st Year</option>
                                                        <option value="2nd_year"
                                                            {{ old('sibling_applied_year') == '2nd_year' ? 'selected' : '' }}>
                                                            2nd Year</option>
                                                        <option value="3rd_year"
                                                            {{ old('sibling_applied_year') == '3rd_year' ? 'selected' : '' }}>
                                                            3rd Year</option>
                                                        <option value="4th_year"
                                                            {{ old('sibling_applied_year') == '4th_year' ? 'selected' : '' }}>
                                                            4th Year</option>
                                                    </select>
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
                                        <p class="mb-0" style="color: #856404; font-size: 14px;">
                                            <strong>Note:</strong> We accept cheques only from Government Nationalized Banks
                                            and the following banks: HDFC Bank, ICICI Bank, Kotak Mahindra Bank, Axis Bank,
                                            IndusInd Bank, IDBI Bank, Yes Bank, and IDFC First Bank. Please mention the bank
                                            details of the account from which post-dated cheques will be submitted if your
                                            application is sanctioned.
                                        </p>
                                    </div>

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="account_holder_name"
                                                    placeholder="Account Holder's Name *"
                                                    value="{{ old('account_holder_name') }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('account_holder_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="bank_name"
                                                    placeholder="Bank Name *" value="{{ old('bank_name') }}">
                                                <small class="text-danger">{{ $errors->first('bank_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="account_number"
                                                    placeholder="Account Number *" value="{{ old('account_number') }}">
                                                <small class="text-danger">{{ $errors->first('account_number') }}</small>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="branch_name"
                                                    placeholder="Branch Name *" value="{{ old('branch_name') }}">
                                                <small class="text-danger">{{ $errors->first('branch_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="ifsc_code"
                                                    placeholder="IFSC Code *" value="{{ old('ifsc_code') }}">
                                                <small class="text-danger">{{ $errors->first('ifsc_code') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <textarea class="form-control" name="bank_address" rows="3" placeholder="Bank Address *"
                                                    style="resize: vertical;">{{ old('bank_address') }}</textarea>
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
                            <button type="submit" class="btn" style="background:#393185;color:white;">Next Step <svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
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
                const siblingAssistanceFields = document.getElementById('sibling-assistance-fields');

                if (siblingAssistanceSelect && siblingAssistanceSelect.value === 'yes') {
                    siblingAssistanceFields.style.display = 'block';
                } else {
                    siblingAssistanceFields.style.display = 'none';
                }
            }

            // Event listener for sibling assistance dropdown
            document.querySelector('select[name="sibling_assistance"]').addEventListener('change',
                toggleSiblingAssistanceFields);

            // Initialize sibling assistance fields on page load
            toggleSiblingAssistanceFields();
        });
    </script>
@endsection
