@extends('user.layout.master')
@section('step')
    <button class="btn btn-purple me-2" style="background-color: #393185; color: white;">Step 3 of
        7</button>
@endsection

<!-- Validation Error Modal -->
<div class="modal fade modal-modern" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="validationModalLabel" style="color: #393185; font-weight: 600;">Validation
                    Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="bi bi-exclamation-triangle" style="font-size: 3rem; color: #E31E24;"></i>
                    </div>
                    <p style="color: #495057; font-size: 16px; margin-bottom: 0;">
                        At least one complete relative set (name, mobile, and email) must be filled.
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-modern" style="background: #393185; color: white;"
                    data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Pass existing family member data from database to JavaScript
    const oldFamilyMembers = @json($existingFamilyMembers ?? []);

    document.addEventListener('DOMContentLoaded', function() {
        // Check if there's a relatives validation error and show modal
        @if ($errors->has('relatives'))
            var validationModal = new bootstrap.Modal(document.getElementById('validationModal'));
            if (validationModal) {
                validationModal.show();
            }
        @endif

        // Function to show/hide sibling fields
        function toggleSiblingFields() {
            const hasSiblingInput = document.querySelector('input[name="has_sibling"]:checked');
            const siblingFields1 = document.getElementById('sibling-fields');
            const siblingFields2 = document.getElementById('sibling-fields-2');
            const siblingInputs = document.querySelectorAll('#sibling-fields input, #sibling-fields-2 input');

            if (hasSiblingInput && siblingFields1 && siblingFields2) {
                if (hasSiblingInput.value === 'yes') {
                    siblingFields1.style.display = 'block';
                    siblingFields2.style.display = 'block';
                } else {
                    siblingFields1.style.display = 'none';
                    siblingFields2.style.display = 'none';
                    // Reset all sibling fields
                    siblingInputs.forEach(input => {
                        input.value = '';
                    });
                }
            }
        }

        // Initialize sibling fields based on old value
        toggleSiblingFields();

        // Add event listeners to radio buttons
        const radioButtons = document.querySelectorAll('input[name="has_sibling"]');
        radioButtons.forEach(radio => {
            radio.addEventListener('change', toggleSiblingFields);
        });

        // Initialize Bootstrap tabs
        var triggerTabList = [].slice.call(document.querySelectorAll('#parentTabs button'))
        triggerTabList.forEach(function(triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
            triggerEl.addEventListener('click', function(event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })

        // Initialize relatives tabs
        var relativesTabList = [].slice.call(document.querySelectorAll('#relativesTabs button'))
        relativesTabList.forEach(function(triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
            triggerEl.addEventListener('click', function(event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })

        // Family table functionality
        const numberFamilyMembersInput = document.getElementById('number_family_members');
        const familyTableContainer = document.getElementById('family-table-container');
        const tbody = document.getElementById('family-tbody');

        function toggleFamilyTable() {
            if (!numberFamilyMembersInput || !familyTableContainer || !tbody) {
                return;
            }

            const totalMembers = parseInt(numberFamilyMembersInput.value) || 0;

            // Remove all rows except Applicant
            const extraRows = tbody.querySelectorAll('tr:not(#applicant-row)');
            extraRows.forEach(row => row.remove());

            // Table should always be visible
            familyTableContainer.style.display = 'block';

            // Applicant is already there → add remaining members
            const familyMembersCount = totalMembers > 1 ? totalMembers - 1 : 0;

            for (let i = 1; i <= familyMembersCount; i++) {
                const row = document.createElement('tr');

                // Get old data for this family member (array is 0-indexed, i is 1-indexed)
                const oldData = oldFamilyMembers[i - 1];

                row.innerHTML = `
              <td>
                <select name="family_${i}_relation" class="form-control">
                    <option value="">Select Relation</option>
                    <option value="Father" ${oldData && oldData.relation === 'Father' ? 'selected' : ''}>Father</option>
                    <option value="Mother" ${oldData && oldData.relation === 'Mother' ? 'selected' : ''}>Mother</option>
                    <option value="Grandfather" ${oldData && oldData.relation === 'Grandfather' ? 'selected' : ''}>Grandfather</option>
                    <option value="Grandmother" ${oldData && oldData.relation === 'Grandmother' ? 'selected' : ''}>Grandmother</option>
                    <option value="Uncle" ${oldData && oldData.relation === 'Uncle' ? 'selected' : ''}>Uncle</option>
                    <option value="Aunt" ${oldData && oldData.relation === 'Aunt' ? 'selected' : ''}>Aunt</option>
                    <option value="Brother" ${oldData && oldData.relation === 'Brother' ? 'selected' : ''}>Brother</option>
                </select>
            </td>
            <td><input type="text" name="family_${i}_name" class="form-control" value="${oldData ? oldData.name || '' : ''}"></td>
            <td><input type="number" name="family_${i}_age" class="form-control" value="${oldData ? oldData.age || '' : ''}"></td>
            <td>
                <select name="family_${i}_marital_status" class="form-control">
                    <option value="">Select</option>
                    <option value="married" ${oldData && oldData.marital_status === 'married' ? 'selected' : ''}>Married</option>
                    <option value="unmarried" ${oldData && oldData.marital_status === 'unmarried' ? 'selected' : ''}>Unmarried</option>
                </select>
            </td>
            <td><input type="text" name="family_${i}_qualification" class="form-control" value="${oldData ? oldData.qualification || '' : ''}"></td>
            <td>
                <select name="family_${i}_occupation" class="form-control">
                    <option value="">Select Occupation</option>
                    <option value="Job" ${oldData && oldData.occupation === 'Job' ? 'selected' : ''}>Job</option>
                    <option value="Business" ${oldData && oldData.occupation === 'Business' ? 'selected' : ''}>Business</option>
                    <option value="Agriculture" ${oldData && oldData.occupation === 'Agriculture' ? 'selected' : ''}>Agriculture</option>
                    <option value="Professional" ${oldData && oldData.occupation === 'Professional' ? 'selected' : ''}>Professional</option>
                    <option value="Student" ${oldData && oldData.occupation === 'Student' ? 'selected' : ''}>Student</option>
                    <option value="Homemaker" ${oldData && oldData.occupation === 'Homemaker' ? 'selected' : ''}>Homemaker</option>
                </select>
            </td>
            <td><input type="tel" name="family_${i}_mobile" class="form-control" value="${oldData ? oldData.mobile || '' : ''}"></td>
            <td><input type="email" name="family_${i}_email" class="form-control" value="${oldData ? oldData.email || '' : ''}"></td>
            <td><input type="number" name="family_${i}_yearly_income" class="form-control" value="${oldData ? oldData.yearly_income || '' : ''}"></td>
            <td><input type="text" name="family_${i}_pan_card" class="form-control" value="${oldData ? oldData.pan_card || '' : ''}"></td>
            <td><input type="text" name="family_${i}_aadhar_no" class="form-control" value="${oldData ? oldData.aadhar_no || '' : ''}"></td>
        `;

                tbody.appendChild(row);
            }
        }

        // Run once on page load
        toggleFamilyTable();

        // Update rows when number changes
        if (numberFamilyMembersInput) {
            numberFamilyMembersInput.addEventListener('input', toggleFamilyTable);
        }

        // Function to calculate total family income
        function calculateTotalFamilyIncome() {
            const applicantIncome = parseFloat(@json($user->applicant_yearly_income ?? 0)) || 0;
            let total = applicantIncome;

            // Sum incomes from other family members
            const incomeInputs = document.querySelectorAll('input[name^="family_"][name$="_yearly_income"]');
            incomeInputs.forEach(input => {
                const value = parseFloat(input.value) || 0;
                total += value;
            });

            // Set the total to the input field
            const totalInput = document.querySelector('input[name="total_family_income"]');
            if (totalInput) {
                totalInput.value = total;
            }
        }

        // Calculate initially
        calculateTotalFamilyIncome();

        // Add event listeners to income inputs to recalculate on change
        document.addEventListener('input', function(e) {
            if (e.target.name && e.target.name.endsWith('_yearly_income')) {
                calculateTotalFamilyIncome();
            }
        });

        // Function to show/hide diksha fields
        function toggleDikshaFields() {
            const dikshaSelect = document.querySelector('select[name="family_member_diksha"]');
            const dikshaFields = document.querySelector('.diksha-fields');

            if (dikshaSelect && dikshaFields) {
                if (dikshaSelect.value === 'yes') {
                    dikshaFields.style.display = 'block';
                } else {
                    dikshaFields.style.display = 'none';
                    // Reset diksha fields
                    const dikshaInputs = dikshaFields.querySelectorAll('input, select');
                    dikshaInputs.forEach(input => {
                        input.value = '';
                    });
                }
            }
        }

        // Initialize diksha fields based on old value
        toggleDikshaFields();

        // Add event listener to diksha select
        const dikshaSelect = document.querySelector('select[name="family_member_diksha"]');
        if (dikshaSelect) {
            dikshaSelect.addEventListener('change', toggleDikshaFields);
        }
    });
</script>

@section('content')
    <style>
        .modern-form-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            border: none;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #393185;
            margin-bottom: 8px;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 60px;
            height: 2px;
            background: #393185;
        }

        .form-control-modern {
            height: 45px;
            border-radius: 8px;
            border: 1px solid #e1e5e9;
            padding: 0 15px;
            font-size: 14px;
            color: #495057;
        }

        .form-control-modern:focus {
            border-color: #393185;
            box-shadow: 0 0 0 0.2rem rgba(57, 49, 133, 0.25);
        }

        .tab-modern .nav-link {
            border: none;
            background: #f8f9fa;
            color: #6c757d;
            border-radius: 8px 8px 0 0;
            margin-right: 5px;
            padding: 12px 20px;
        }

        .tab-modern .nav-link.active {
            background: #393185;
            color: white;
        }

        .tab-content-modern {
            border: 1px solid #e1e5e9;
            border-radius: 0 8px 8px 8px;
            background: white;
            padding: 20px;
        }

        .sub-card {
            background: #f8f9fc;
            border-radius: 8px;
            padding: 15px;
            border: 1px solid #e1e5e9;
        }

        .upload-box {
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .upload-box:hover {
            border-color: #393185;
            background: #f8f9fe;
        }

        .btn-modern {
            border-radius: 8px;
            padding: 12px 30px;
            font-weight: 500;
        }

        .btn-previous {
            background: #f8f9fa;
            color: #6c757d;
            border: 2px solid #e9ecef;
        }

        .btn-next {
            background: #393185;
            color: white;
            border: 2px solid #393185;
        }

        .modal-modern .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .modern-form-card {
                margin: 10px;
                padding: 15px;
            }

            .tab-modern .nav-link {
                margin-right: 2px;
                padding: 10px 15px;
                font-size: 14px;
            }
        }

        .nav.nav-tabs .nav-link {
            color: #4C4C4C;
            font-size: 16px;
            font-weight: 600;
            background: none;
            border: none;
            padding-bottom: 8px;
            position: relative;

        }

        .nav.nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50%;
            height: 3.5px;
            margin-left: 15px;
            background: #4C4C4C;
        }

        #family-table th, #family-table td {
            min-width: 150px;
        }
    </style>
    <!-- Main Content -->
    <div class="col-lg-9 main-content">
        <!-- Hold Remark Alert -->
        @if ($familyDetail && $familyDetail->submit_status === 'resubmit' && $familyDetail->admin_remark)
            <div class="alert alert-warning alert-dismissible fade show" role="alert"
                style="background-color: #fff3cd; border-color: #ffeaa7; color: #856404; border-radius: 8px; margin-bottom: 20px;">
                <strong><i class="bi bi-exclamation-triangle-fill"></i> Hold Notice:</strong>
                <p style="margin: 8px 0 0 0; font-size: 14px;">{{ $familyDetail->admin_remark }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('user.step3.store') }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        @if (session('success'))
                            <div class="alert alert-warning alert-dismissible fade show position-relative" role="alert"
                                id="successAlert">

                                {{ session('success') }}

                                <button type="button" class="close custom-close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="row mb-3">
                            <div class="col-md-5 offset-md-1">

                                <select class="form-control" name="financial_asset_type" id="financial_asset_type"
                                    style="border:2px solid #393185;border-radius:15px;" readonly required>
                                    <option disabled
                                        {{ (old('financial_asset_type') ?: $user->financial_asset_type ?? '') ? '' : 'selected' }}
                                        hidden>Financial Asst Type *</option>
                                    <option value="domestic"
                                        {{ (old('financial_asset_type') ?: $user->financial_asset_type ?? '') == 'domestic' ? 'selected' : '' }}
                                        hidden>
                                        Domestic</option>
                                    <option value="foreign_finance_assistant"
                                        {{ (old('financial_asset_type') ?: $user->financial_asset_type ?? '') == 'foreign_finance_assistant' ? 'selected' : '' }}
                                        hidden>
                                        Foreign Financial Assistance</option>
                                </select>
                                <small class="text-danger">{{ $errors->first('financial_asset_type') }}</small>
                            </div>
                            <div class="col-md-5">
                                <select class="form-control" name="financial_asset_for" id="financial_asset_for"
                                    style="border:2px solid #393185;border-radius:15px;" readonly required>
                                    <option disabled
                                        {{ (old('financial_asset_for') ?: $user->financial_asset_for ?? '') ? '' : 'selected' }}
                                        hidden>Financial Asst For *</option>
                                    <option value="graduation"
                                        {{ (old('financial_asset_for') ?: $user->financial_asset_for ?? '') == 'graduation' ? 'selected' : '' }}
                                        hidden>
                                        Graduation</option>
                                    <option value="post_graduation"
                                        {{ (old('financial_asset_for') ?: $user->financial_asset_for ?? '') == 'post_graduation' ? 'selected' : '' }}
                                        hidden>
                                        Post Graduation</option>
                                </select>
                                <small class="text-danger">{{ $errors->first('financial_asset_for') }}</small>
                            </div>
                        </div>
                        <div class="card form-card">
                            <div class="card-body">

                                <div class="step-card">
                                    <div class="card-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div>
                                        <h3 class="card-title">Family Details</h3>
                                        <p class="card-subtitle">Information about your family members</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">

                                        <div class="form-group mb-3">
                                            <label for="number_family_members" class="form-label">Number of Family Members
                                                <span style="color: red;">*</span></label>

                                            <input type="number" id="number_family_members" class="form-control"
                                                name="number_family_members" placeholder="Enter number of family members"
                                                value="{{ old('number_family_members', $familyDetail->number_family_members ?? '') }}"
                                                required>
                                            <small
                                                class="text-danger">{{ $errors->first('number_family_members') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">

                                        <div id="family-table-container" class="table-responsive">
                                            <table class="table table-borderless mt-3" id="family-table">
                                                <thead>
                                                    <tr>
                                                        <th style="color:#4C4C4C;">Relation with student</th>
                                                        <th style="color:#4C4C4C;">Name</th>
                                                        <th style="color:#4C4C4C;">Age</th>
                                                        <th style="color:#4C4C4C;">Marital Status</th>
                                                        <th style="color:#4C4C4C;">Qualification</th>
                                                        <th style="color:#4C4C4C;">Occupation</th>
                                                        <th style="color:#4C4C4C;">Mobile Number</th>
                                                        <th style="color:#4C4C4C;">Email ID</th>
                                                        <th style="color:#4C4C4C;">Yearly Gross Income</th>
                                                        <th style="color:#4C4C4C;">PAN Card No.</th>
                                                        <th style="color:#4C4C4C;">Aadhar No.</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="family-tbody">
                                                    <tr id="applicant-row">
                                                        {{-- <td><input type="text" name="applicant_relation" value="Self"
                                                                readonly class="form-control"></td> --}}
                                                        <td style="color:#E31E24">
                                                            Applicant’s Name
                                                            {{-- <input type="text" name="applicant_relation" value="Applicant’s Name"
                                                                readonly class="form-control"> --}}
                                                        </td>
                                                        <td style="color:#E31E24">{{ $user->name ?? '' }}</td>
                                                        <td style="color:#E31E24">{{ $user->age ?? '' }}
                                                        </td>

                                                        <td style="color:#E31E24">
                                                            {{ $user->marital_status ?? '' }}</td>
                                                        <td style="color:#E31E24">
                                                            {{ $user->qualification ?? '' }}</td>
                                                        <td style="color:#E31E24">{{ $user->occupation ?? '' }}
                                                        </td>
                                                        <td style="color:#E31E24">{{ $user->phone ?? '' }}</td>
                                                        <td style="color:#E31E24">{{ $user->email ?? '' }}</td>
                                                        <td style="color:#E31E24">
                                                            {{ $user->applicant_yearly_income ?? '' }}</td>
                                                        <td style="color:#E31E24">{{ $user->pan_card ?? '' }}</td>
                                                        <td style="color:#E31E24">{{ $user->aadhar_card_number ?? '' }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                                <hr>

                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="total_family_income" class="form-label">Total Family Income (₹)
                                                <span style="color: red;">*</span></label>

                                            <input type="number" class="form-control" name="total_family_income"
                                                placeholder="Total Family Income (₹) "
                                                value="{{ old('total_family_income', $familyDetail->total_family_income ?? '') }}"
                                                required>
                                            <small class="text-danger">{{ $errors->first('total_family_income') }}</small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="total_students" class="form-label">Total Number of Students
                                                <span style="color: red;">*</span></label>
                                            <input type="number" class="form-control" name="total_students"
                                                placeholder="Total Number of Students "
                                                value="{{ old('total_students', $familyDetail->total_students ?? '') }}"
                                                required>
                                            <small class="text-danger">{{ $errors->first('total_students') }}</small>
                                            {{-- @error('total_students')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror --}}

                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="family_member_diksha" class="form-label">Family Member Taken
                                                Diksha
                                                <span style="color: red;">*</span></label>
                                            <select class="form-control" name="family_member_diksha" required>
                                                <option value=""
                                                    {{ !old('family_member_diksha') && !$familyDetail ? 'selected' : '' }}
                                                    disabled hidden>Family Member Taken Diksha</option>
                                                <option value="yes"
                                                    {{ old('family_member_diksha') == 'yes' || ($familyDetail && $familyDetail->family_member_diksha === 'yes') ? 'selected' : '' }}>
                                                    Yes</option>
                                                <option value="no"
                                                    {{ old('family_member_diksha') == 'no' || ($familyDetail && $familyDetail->family_member_diksha === 'no') ? 'selected' : '' }}>
                                                    No</option>
                                            </select>
                                            <small
                                                class="text-danger">{{ $errors->first('family_member_diksha') }}</small>
                                        </div>
                                        <div class="diksha-fields" style="display:none;">
                                            <div class="form-group mb-3">
                                                <label for="diksha_member_name" class="form-label">Name of Family
                                                    Member<span style="color: red;">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="diksha_member_name"
                                                    placeholder="Name of Family Member"
                                                    value="{{ old('diksha_member_name', $familyDetail->diksha_member_name ?? '') }}"
                                                    required>
                                                <small class="text-danger"
                                                    id="diksha_member_name_error">{{ $errors->first('diksha_member_name') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="diksha_member_relation" class="form-label">Relation with
                                                    Applicant <span style="color: red;">*</span></label>
                                                <select class="form-control" name="diksha_member_relation" required>
                                                    <option value=""
                                                        {{ !old('diksha_member_relation') ? 'selected' : '' }} disabled
                                                        hidden>Select Relation</option>
                                                    <option value="grandparent"
                                                        {{ old('diksha_member_relation') == 'grandfather' ? 'selected' : '' }}>
                                                        GrandFather</option>
                                                    <option value="grandparent"
                                                        {{ old('diksha_member_relation') == 'grandmother' ? 'selected' : '' }}>
                                                        GrandMother</option>
                                                    <option value="parents"
                                                        {{ old('diksha_member_relation') == 'father' ? 'selected' : '' }}>
                                                        Father</option>
                                                    <option value="parents"
                                                        {{ old('diksha_member_relation') == 'mother' ? 'selected' : '' }}>
                                                        Mother</option>
                                                    <option value="uncle and aunt"
                                                        {{ old('diksha_member_relation') == 'uncle' ? 'selected' : '' }}>
                                                        Uncle </option>
                                                    <option value="uncle and aunt"
                                                        {{ old('diksha_member_relation') == 'aunt' ? 'selected' : '' }}>
                                                        Aunt</option>
                                                    <option value="brother"
                                                        {{ old('diksha_member_relation') == 'brother' ? 'selected' : '' }}>
                                                        Brother </option>
                                                    <option value="sister"
                                                        {{ old('diksha_member_relation') == 'sister' ? 'selected' : '' }}>
                                                        Sister</option>
                                                </select>
                                                <small
                                                    class="text-danger">{{ $errors->first('diksha_member_relation') }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="total_insurance_coverage" class="form-label">Total Insurance
                                                Coverage of Family (₹)
                                                <span style="color: red;">*</span></label>
                                            <input type="number" class="form-control" name="total_insurance_coverage"
                                                placeholder="Total Insurance Coverage of Family (₹) "
                                                value="{{ old('total_insurance_coverage', $familyDetail->total_insurance_coverage ?? '') }}"
                                                required>
                                            <small
                                                class="text-danger">{{ $errors->first('total_insurance_coverage') }}</small>
                                        </div>


                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="total_premium_paid" class="form-label">Total Premium Paid in
                                                Rupees/Year
                                                <span style="color: red;">*</span></label>
                                            <input type="number" class="form-control" name="total_premium_paid"
                                                placeholder="Total Premium Paid in Rupees/Year "
                                                value="{{ old('total_premium_paid', $familyDetail->total_premium_paid ?? '') }}"
                                                required>
                                            <small class="text-danger">{{ $errors->first('total_premium_paid') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="recent_electricity_amount" class="form-label">Recent Electricity
                                                Bill Amount
                                                <span style="color: red;">*</span></label>
                                            <input type="number" class="form-control" name="recent_electricity_amount"
                                                placeholder="Recent Electricity Bill Amount "
                                                value="{{ old('recent_electricity_amount', $familyDetail->recent_electricity_amount ?? '') }}"
                                                required>
                                            <small
                                                class="text-danger">{{ $errors->first('recent_electricity_amount') }}</small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="total_monthly_emi" class="form-label">Total Monthly EMI Amount
                                                <span style="color: red;">*</span></label>
                                            <input type="number" class="form-control" name="total_monthly_emi"
                                                placeholder="Total Monthly EMI  "
                                                value="{{ old('total_monthly_emi', $familyDetail->total_monthly_emi ?? '') }}"
                                                required>
                                            <small class="text-danger">{{ $errors->first('total_monthly_emi') }}</small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="mediclaim_insurance_amount" class="form-label">Mediclaim Insurance
                                                Amount
                                                <span style="color: red;">*</span></label>
                                            <input type="number" class="form-control" name="mediclaim_insurance_amount"
                                                placeholder="Mediclaim Insurance Amount "
                                                value="{{ old('mediclaim_insurance_amount', $familyDetail->mediclaim_insurance_amount ?? '') }}"
                                                required>
                                            <small
                                                class="text-danger">{{ $errors->first('mediclaim_insurance_amount') }}</small>
                                        </div>
                                    </div>
                                </div>




                                <!-- Bootstrap Tabs for Relatives Details -->
                                <ul class="nav nav-tabs" id="relativesTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="paternal-tab" data-bs-toggle="tab"
                                            data-bs-target="#paternal" type="button" role="tab"
                                            aria-controls="paternal" aria-selected="true">Paternal Side</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="maternal-tab" data-bs-toggle="tab"
                                            data-bs-target="#maternal" type="button" role="tab"
                                            aria-controls="maternal" aria-selected="false">Maternal Side</button>
                                    </li>
                                </ul>
                                <div class="tab-content mt-4" id="relativesTabsContent">
                                    <!-- Paternal Side Tab -->
                                    <div class="tab-pane fade show active" id="paternal" role="tabpanel"
                                        aria-labelledby="paternal-tab">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p style="font-size:15px;color:#E31E24;">Note : In the sections for
                                                    paternal side and maternal side, do not repeat
                                                    the names of family members you have already mentioned earlier in the
                                                    form. The person you list here cannot be added later as a guarantor, so
                                                    choose carefully.<b> You must enter the details of at least one family
                                                        member in this section.</b></p>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="paternal_uncle_name" class="form-label">Paternal Uncle's
                                                        Name
                                                    </label>
                                                    <input type="text" class="form-control" name="paternal_uncle_name"
                                                        placeholder="Paternal Uncle's Name"
                                                        value="{{ old('paternal_uncle_name', $familyDetail->paternal_uncle_name ?? '') }}">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="paternal_uncle_mobile" class="form-label">Paternal Uncle's
                                                        Mobile Number
                                                    </label>
                                                    <input type="tel" class="form-control"
                                                        name="paternal_uncle_mobile" placeholder="His Mobile Number"
                                                        value="{{ old('paternal_uncle_mobile', $familyDetail->paternal_uncle_mobile ?? '') }}">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="paternal_uncle_email" class="form-label">Paternal Uncle's
                                                        Email Address
                                                    </label>
                                                    <input type="email" class="form-control"
                                                        name="paternal_uncle_email" placeholder="His Email Address"
                                                        value="{{ old('paternal_uncle_email', $familyDetail->paternal_uncle_email ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="paternal_aunt_name" class="form-label">Paternal Aunt's
                                                        Name
                                                    </label>
                                                    <input type="text" class="form-control" name="paternal_aunt_name"
                                                        placeholder="Paternal Aunt's Name"
                                                        value="{{ old('paternal_aunt_name', $familyDetail->paternal_aunt_name ?? '') }}">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="paternal_aunt_mobile" class="form-label">Paternal Aunt's
                                                        Mobile Number
                                                    </label>
                                                    <input type="tel" class="form-control"
                                                        name="paternal_aunt_mobile" placeholder="Her Mobile Number"
                                                        value="{{ old('paternal_aunt_mobile', $familyDetail->paternal_aunt_mobile ?? '') }}">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="paternal_aunt_email" class="form-label">Paternal Aunt's
                                                        Email Address
                                                    </label>
                                                    <input type="email" class="form-control" name="paternal_aunt_email"
                                                        placeholder="Her Email Address"
                                                        value="{{ old('paternal_aunt_email', $familyDetail->paternal_aunt_email ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Maternal Side Tab -->
                                    <div class="tab-pane fade" id="maternal" role="tabpanel"
                                        aria-labelledby="maternal-tab">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p style="font-size:15px;color:#E31E24;">Note : In the sections for
                                                    paternal side and maternal side, do not repeat
                                                    the names of family members you have already mentioned earlier in the
                                                    form. The person you list here cannot be added later as a guarantor, so
                                                    choose carefully.<b> You must enter the details of at least one family
                                                        member in this section.</b></p>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="maternal_uncle_name" class="form-label">Maternal Uncle's
                                                        Name
                                                    </label>
                                                    <input type="text" class="form-control" name="maternal_uncle_name"
                                                        placeholder="Maternal Uncle's Name"
                                                        value="{{ old('maternal_uncle_name', $familyDetail->maternal_uncle_name ?? '') }}">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="maternal_uncle_mobile" class="form-label">Maternal Uncle's
                                                        Mobile Number
                                                    </label>
                                                    <input type="tel" class="form-control"
                                                        name="maternal_uncle_mobile" placeholder="His Mobile Number"
                                                        value="{{ old('maternal_uncle_mobile', $familyDetail->maternal_uncle_mobile ?? '') }}">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="maternal_uncle_email" class="form-label">Maternal Uncle's
                                                        Email Address
                                                    </label>
                                                    <input type="email" class="form-control"
                                                        name="maternal_uncle_email" placeholder="His Email Address"
                                                        value="{{ old('maternal_uncle_email', $familyDetail->maternal_uncle_email ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="maternal_aunt_name" class="form-label">Maternal Aunt's
                                                        Name</label>
                                                    <input type="text" class="form-control" name="maternal_aunt_name"
                                                        placeholder="Maternal Aunt's Name"
                                                        value="{{ old('maternal_aunt_name', $familyDetail->maternal_aunt_name ?? '') }}">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="maternal_aunt_mobile" class="form-label">Maternal Aunt's
                                                        Mobile Number</label>
                                                    <input type="tel" class="form-control"
                                                        name="maternal_aunt_mobile" placeholder="Her Mobile Number"
                                                        value="{{ old('maternal_aunt_mobile', $familyDetail->maternal_aunt_mobile ?? '') }}">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="maternal_aunt_email" class="form-label">Maternal Aunt's
                                                        Email Address</label>
                                                    <input type="email" class="form-control" name="maternal_aunt_email"
                                                        placeholder="Her Email Address"
                                                        value="{{ old('maternal_aunt_email', $familyDetail->maternal_aunt_email ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4 mb-4">
                            {{-- <button  type="button" class="btn" style="background:#988DFF1F;color:gray;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    stroke="gray" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M15 18l-6-6 6-6" />
                                </svg>
                                Previous
                            </button> --}}
                            <a href="{{ route('user.step1') }}" class="btn"
                                style="background:#988DFF1F;color:gray;border:1px solid #393185;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    stroke="gray" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M15 18l-6-6 6-6" />
                                </svg>
                                Previous
                            </a>

                            <button type="submit" class="btn" style="background:#393185;color:white;">
                                Next Step
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

    </div>
@endsection
