@extends('donor.layout.master')
@section('step')
    <button class="btn me-2" style="background:#393185;color:white;">
        Step 2 of 8
    </button>
@endsection
@section('content')
    <style>
        select option {
            border: none !important;
            border-radius: 15px !important;
            background-color: #F2F2F2 !important;
        }
    </style>


    <!-- Main Content -->
    <div class="col-lg-9 main-content">
        <!-- Hold Remark Alert -->
        @if (auth()->check() && auth()->user()->submit_status === 'resubmit' && auth()->user()->admin_remark)
            <div class="alert alert-warning alert-dismissible fade show" role="alert"
                style="background-color: #fff3cd; border-color: #ffeaa7; color: #856404; border-radius: 8px; margin-bottom: 20px;">
                <strong><i class="bi bi-exclamation-triangle-fill"></i> Hold Notice:</strong>
                <p style="margin: 8px 0 0 0; font-size: 14px;">{{ auth()->user()->admin_remark }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('donor.step2.store') }}" enctype="multipart/form-data" novalidate>
    @csrf

    @php
        $existingChildren = [];
        if (old('child_name')) {
            $childNames = old('child_name', []);
            $childGenders = old('child_gender', []);
            $childDobs = old('child_dob', []);
            $childBloodGroups = old('child_blood_group', []);
            $childMaritalStatuses = old('child_marital_status', []);
            foreach ($childNames as $index => $childName) {
                $existingChildren[] = [
                    'name' => $childName,
                    'gender' => $childGenders[$index] ?? '',
                    'dob' => $childDobs[$index] ?? '',
                    'blood_group' => $childBloodGroups[$index] ?? '',
                    'marital_status' => $childMaritalStatuses[$index] ?? '',
                ];
            }
        } elseif (!empty($familyDetail?->children_details)) {
            $existingChildren = json_decode($familyDetail->children_details, true) ?: [];
        }

        $childCount = old('number_of_kids', $familyDetail->number_of_kids ?? count($existingChildren));
        $childCount = max((int) $childCount, count($existingChildren));
    @endphp

    <div class="card form-card">
        <div class="card-body">

            <h4 class="mb-4 text-center">Family Details</h4>

            <!-- TITLE + SPOUSE NAME -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <label>Title *</label>
                    <select class="form-control" name="spouse_title">
                        <option value="" disabled {{ old('spouse_title', $familyDetail->spouse_title ?? '') === '' ? 'selected' : '' }}>Select</option>
                        <option value="Mr" {{ old('spouse_title', $familyDetail->spouse_title ?? '') === 'Mr' ? 'selected' : '' }}>Mr</option>
                        <option value="Mrs" {{ old('spouse_title', $familyDetail->spouse_title ?? '') === 'Mrs' ? 'selected' : '' }}>Mrs</option>
                        <option value="Miss" {{ old('spouse_title', $familyDetail->spouse_title ?? '') === 'Miss' ? 'selected' : '' }}>Miss</option>
                        <option value="Ms" {{ old('spouse_title', $familyDetail->spouse_title ?? '') === 'Ms' ? 'selected' : '' }}>Ms</option>
                    </select>
                </div>

                <div class="col-md-9">
                    <label>Spouse Name *</label>
                    <input type="text" name="spouse_name" class="form-control" value="{{ old('spouse_name', $familyDetail->spouse_name ?? '') }}">
                </div>
            </div>

            <!-- DOB + JITO MEMBER -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Birth Date *</label>
                    <input type="date" name="spouse_birth_date" class="form-control" max="{{ now()->subYears(18)->format('Y-m-d') }}" value="{{ old('spouse_birth_date', $familyDetail->spouse_birth_date ?? '') }}">
                </div>

                <div class="col-md-4">
                    <label>Is he / she JITO Member? *</label>
                    <div class="d-flex gap-4 mt-2">
                        <label>
                            <input type="radio" name="jito_member" value="yes" onclick="toggleJitoUID(true)" {{ old('jito_member', $familyDetail->jito_member ?? '') === 'yes' ? 'checked' : '' }}> Yes
                        </label>
                        <label>
                            <input type="radio" name="jito_member" value="no" onclick="toggleJitoUID(false)" {{ old('jito_member', $familyDetail->jito_member ?? '') === 'no' ? 'checked' : '' }}> No
                        </label>
                    </div>
                </div>

                <div class="col-md-4" id="jito_uid_box" style="display:none;">
                    <label>JITO UID *</label>
                    <input type="text" name="jito_uid" class="form-control" value="{{ old('jito_uid', $familyDetail->jito_uid ?? '') }}">
                </div>
            </div>

            <!-- BLOOD GROUP + KIDS -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Blood Group *</label>
                    <select name="spouse_blood_group" class="form-control">
                        <option value="">Select Blood Group</option>
                        <option value="A+" {{ old('spouse_blood_group', $familyDetail->spouse_blood_group ?? '') === 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A-" {{ old('spouse_blood_group', $familyDetail->spouse_blood_group ?? '') === 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ old('spouse_blood_group', $familyDetail->spouse_blood_group ?? '') === 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B-" {{ old('spouse_blood_group', $familyDetail->spouse_blood_group ?? '') === 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="AB+" {{ old('spouse_blood_group', $familyDetail->spouse_blood_group ?? '') === 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="AB-" {{ old('spouse_blood_group', $familyDetail->spouse_blood_group ?? '') === 'AB-' ? 'selected' : '' }}>AB-</option>
                        <option value="O+" {{ old('spouse_blood_group', $familyDetail->spouse_blood_group ?? '') === 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="O-" {{ old('spouse_blood_group', $familyDetail->spouse_blood_group ?? '') === 'O-' ? 'selected' : '' }}>O-</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Number of Kids *</label>
                    <input type="number" name="number_of_kids" id="number_of_kids"
                           class="form-control" min="0" placeholder="Enter number of kids" value="{{ $childCount }}">
                </div>
            </div>

            <!-- CHILD DETAILS -->
            
            <div id="child_details_container">
                @for ($i = 0; $i < $childCount; $i++)
                    @php $child = $existingChildren[$i] ?? []; @endphp
                    <h5 class="mt-4 mb-3">Child Details</h5>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6>Child {{ $i + 1 }}</h6>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>Name *</label>
                                    <input type="text" name="child_name[]" class="form-control" value="{{ $child['name'] ?? '' }}">
                                </div>

                                <div class="col-md-4">
                                    <label>Gender *</label>
                                    <select name="child_gender[]" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Male" {{ ($child['gender'] ?? '') === 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ ($child['gender'] ?? '') === 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ ($child['gender'] ?? '') === 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>DOB *</label>
                                    <input type="date" name="child_dob[]" class="form-control" value="{{ $child['dob'] ?? '' }}">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Blood Group *</label>
                                    <select name="child_blood_group[]" class="form-control">
                                        <option value="">Select</option>
                                        <option value="A+" {{ ($child['blood_group'] ?? '') === 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A-" {{ ($child['blood_group'] ?? '') === 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ ($child['blood_group'] ?? '') === 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ ($child['blood_group'] ?? '') === 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="AB+" {{ ($child['blood_group'] ?? '') === 'AB+' ? 'selected' : '' }}>AB+</option>
                                        <option value="AB-" {{ ($child['blood_group'] ?? '') === 'AB-' ? 'selected' : '' }}>AB-</option>
                                        <option value="O+" {{ ($child['blood_group'] ?? '') === 'O+' ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ ($child['blood_group'] ?? '') === 'O-' ? 'selected' : '' }}>O-</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label>Marital Status *</label>
                                    <select name="child_marital_status[]" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Single" {{ ($child['marital_status'] ?? '') === 'Single' ? 'selected' : '' }}>Single</option>
                                        <option value="Married" {{ ($child['marital_status'] ?? '') === 'Married' ? 'selected' : '' }}>Married</option>
                                        <option value="Divorced" {{ ($child['marital_status'] ?? '') === 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                        <option value="Widowed" {{ ($child['marital_status'] ?? '') === 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                        <option value="Separated" {{ ($child['marital_status'] ?? '') === 'Separated' ? 'selected' : '' }}>Separated</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

        </div>
    </div>

    <!-- BUTTONS -->
    <div class="d-flex justify-content-between mt-4 mb-4">
        <a href="{{ route('donor.step1') }}" class="btn"
           style="background:#988DFF1F;color:gray;">
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
    @endsection

   <script>
document.addEventListener('DOMContentLoaded', function () {

    function toggleJitoUID(show) {
        document.getElementById('jito_uid_box').style.display = show ? 'block' : 'none';
    }
    window.toggleJitoUID = toggleJitoUID; // make it accessible

    const container = document.getElementById('child_details_container');
    const numberInput = document.getElementById('number_of_kids');

    if (!numberInput || !container) return;

    const existingChildren = @json($existingChildren);

    function renderChildren(count) {
        container.innerHTML = '';

        for (let i = 1; i <= count; i++) {
            const child = existingChildren[i - 1] || {};
            const childName = child.name || '';
            const childGender = child.gender || '';
            const childDob = child.dob || '';
            const childBloodGroup = child.blood_group || '';
            const childMaritalStatus = child.marital_status || '';

            container.innerHTML += `
               <h5 class="mt-4 mb-3">Child Details</h5>
                <div class="card mb-3">
                
                    <div class="card-body">
                    
                        <h6>Child ${i}</h6>

                        <div class="row">
                            <div class="col-md-4">
                                <label>Name *</label>
                                <input type="text" name="child_name[]" class="form-control" value="${childName}">
                            </div>

                            <div class="col-md-4">
                                <label>Gender *</label>
                                <select name="child_gender[]" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Male" ${childGender === 'Male' ? 'selected' : ''}>Male</option>
                                    <option value="Female" ${childGender === 'Female' ? 'selected' : ''}>Female</option>
                                    <option value="Other" ${childGender === 'Other' ? 'selected' : ''}>Other</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>DOB *</label>
                                <input type="date" name="child_dob[]" class="form-control" value="${childDob}">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>Blood Group *</label>
                                <select name="child_blood_group[]" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="A+" ${childBloodGroup === 'A+' ? 'selected' : ''}>A+</option>
                                    <option value="A-" ${childBloodGroup === 'A-' ? 'selected' : ''}>A-</option>
                                    <option value="B+" ${childBloodGroup === 'B+' ? 'selected' : ''}>B+</option>
                                    <option value="B-" ${childBloodGroup === 'B-' ? 'selected' : ''}>B-</option>
                                    <option value="AB+" ${childBloodGroup === 'AB+' ? 'selected' : ''}>AB+</option>
                                    <option value="AB-" ${childBloodGroup === 'AB-' ? 'selected' : ''}>AB-</option>
                                    <option value="O+" ${childBloodGroup === 'O+' ? 'selected' : ''}>O+</option>
                                    <option value="O-" ${childBloodGroup === 'O-' ? 'selected' : ''}>O-</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Marital Status *</label>
                                <select name="child_marital_status[]" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Single" ${childMaritalStatus === 'Single' ? 'selected' : ''}>Single</option>
                                    <option value="Married" ${childMaritalStatus === 'Married' ? 'selected' : ''}>Married</option>
                                    <option value="Divorced" ${childMaritalStatus === 'Divorced' ? 'selected' : ''}>Divorced</option>
                                    <option value="Widowed" ${childMaritalStatus === 'Widowed' ? 'selected' : ''}>Widowed</option>
                                    <option value="Separated" ${childMaritalStatus === 'Separated' ? 'selected' : ''}>Separated</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    toggleJitoUID(document.querySelector('input[name="jito_member"]:checked')?.value === 'yes');
    renderChildren(parseInt(numberInput.value, 10) || 0);

    numberInput.addEventListener('input', function () {
        const count = parseInt(this.value, 10) || 0;
        renderChildren(count);
    });

});
</script>

