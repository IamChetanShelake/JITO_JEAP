@extends('admin.layouts.master')

@section('title', 'Edit Donor Application - JitoJeap Admin')

@section('content')
<div class="container-fluid donor-edit-wrapper px-4">
    <form action="{{ route('admin.donors.updatedonor', $donor->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
       <!-- Add this line -->
       <input type="hidden" name="current_step" id="current_step_input" value="{{ request()->get('step', old('current_step', 1)) }}">


        <style>
            /* Scoped Layout Structure to avoid conflicts */
            .donor-edit-layout {
                display: flex;
                gap: 0;
                background: #fff;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 4px 20px rgba(0,0,0,0.07);
                min-height: 85vh;
                margin-top: 1.5rem;
                border: 1px solid #e0e0e0;
            }

            /* Sidebar Styling */
            .donor-edit-sidebar {
                width: 260px;
                background-color: #393185;
                display: flex;
                flex-direction: column;
                flex-shrink: 0;
            }

            .donor-step-item {
                padding: 1.1rem 1.5rem;
                cursor: pointer;
                display: flex;
                align-items: center;
                color: rgba(255, 255, 255, 0.8);
                font-weight: 500;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                transition: all 0.2s ease;
            }

            .donor-step-item:hover {
                background-color: rgba(0, 0, 0, 0.1);
                color: #fff;
            }

            .donor-step-item.active {
                background-color: #fff;
                color: #393185;
                font-weight: 600;
                border-left: 4px solid #f0ad4e;
                padding-left: calc(1.5rem - 4px);
            }

            .donor-step-number {
                width: 26px;
                height: 26px;
                border-radius: 50%;
                background-color: rgba(255, 255, 255, 0.2);
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.8rem;
                margin-right: 1rem;
                font-weight: 600;
            }

            .donor-step-item.active .donor-step-number {
                background-color: #393185;
                color: #fff;
            }

            /* Content Area Styling */
            .donor-edit-content {
                flex-grow: 1;
                padding: 2rem;
                background: #fdfdff;
                overflow-y: auto;
                max-height: 85vh;
            }

            .donorH4 {
                color: white;
                margin: 0;
                padding: 1rem 1.5rem;
                font-size: 1.1rem;
                font-weight: 600;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                background: #393185;
                border-radius: 4px;
                margin-bottom: 1.5rem;
            }

            .step-content-section {
                display: none;
            }

            .step-content-section.active {
                display: block;
                animation: fadeIn 0.3s ease;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(5px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .form-control, .form-select {
                border-radius: 4px;
                border: 1px solid #ccc;
                font-size: 0.9rem;
            }
            
            .form-control:focus, .form-select:focus {
                border-color: #393185;
                box-shadow: 0 0 0 0.2rem rgba(57, 49, 133, 0.15);
            }

            .info-label {
                font-size: 0.8rem;
                font-weight: 600;
                color: #555;
                text-transform: uppercase;
                margin-bottom: 0.3rem;
                letter-spacing: 0.5px;
            }

            /* Buttons Styling */
            .form-navigation {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 2rem;
                padding-top: 1.5rem;
                border-top: 1px solid #eee;
            }

            .btn-submit-update {
                background-color: #393185;
                color: white;
                padding: 0.7rem 2rem;
                font-weight: 600;
                border-radius: 5px;
                border: none;
                transition: background 0.2s;
            }

            .btn-submit-update:hover {
                background-color: #2d2669;
                color: white;
            }

            .btn-nav {
                padding: 0.7rem 1.5rem;
                font-weight: 600;
                border-radius: 5px;
                border: none;
                transition: all 0.2s;
                cursor: pointer;
            }

            .btn-nav-back {
                background-color: #6c757d;
                color: white;
            }
            .btn-nav-back:hover { background-color: #5a6268; }

            .btn-nav-next {
                background-color: #393185;
                color: white;
            }
            .btn-nav-next:hover { background-color: #2d2669; }
            
            .current-file {
                font-size: 0.8rem;
                color: #666;
                margin-top: 0.25rem;
            }
            .current-file a { color: #393185; font-weight: 600; }
        </style>

        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title"><i class="fas fa-user-edit me-2"></i> Edit Donor Application</h1>
                <p class="dashboard-subtitle">{{ $donor->name }}</p>
            </div>
            <a href="{{ route('admin.donors.dashboard') }}" class="btn btn-outline-secondary">Back</a>
        </div>

        <div class="donor-edit-layout">
            <!-- Sidebar Navigation -->
            <div class="donor-edit-sidebar">
    @for ($i = 1; $i <= 7; $i++)
        <!-- Removed the inline active class logic here -->
        <div class="donor-step-item" data-step="{{ $i }}">
            <div class="donor-step-number">{{ $i }}</div>
            <div>
                @switch($i)
                    @case(1) Personal Details @break
                    @case(2) Family Details @break
                    @case(3) Nominee Details @break
                    @case(4) Membership @break
                    @case(5) Professional @break
                    @case(6) Documents @break
                    @case(7) Payment @break
                @endswitch
            </div>
        </div>
    @endfor
    </div>

            <!-- Content Area -->
            <div class="donor-edit-content">
                
                <!-- Step 1: Personal Details -->
                <div class="step-content-section" id="step-1">
                    <h4 class="donorH4">Personal Details</h4>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="info-label">Title</div>
                            <select name="personal_detail[title]" class="form-select">
                                <option value="Mr" {{ ($donor->personalDetail->title ?? '') == 'Mr' ? 'selected' : '' }}>Mr</option>
                                <option value="Mrs" {{ ($donor->personalDetail->title ?? '') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                                <option value="Ms" {{ ($donor->personalDetail->title ?? '') == 'Ms' ? 'selected' : '' }}>Ms</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">First Name</div>
                            <input type="text" name="personal_detail[first_name]" class="form-control" value="{{ $donor->personalDetail->first_name ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Middle Name</div>
                            <input type="text" name="personal_detail[middle_name]" class="form-control" value="{{ $donor->personalDetail->middle_name ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Surname</div>
                            <input type="text" name="personal_detail[surname]" class="form-control" value="{{ $donor->personalDetail->surname ?? '' }}">
                        </div>
                        <div class="col-md-8">
                            <div class="info-label">Complete Address</div>
                            <textarea name="personal_detail[complete_address]" class="form-control" rows="2">{{ $donor->personalDetail->complete_address ?? '' }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">City</div>
                            <input type="text" name="personal_detail[city]" class="form-control" value="{{ $donor->personalDetail->city ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">State</div>
                            <input type="text" name="personal_detail[state]" class="form-control" value="{{ $donor->personalDetail->state ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Pin Code</div>
                            <input type="text" name="personal_detail[pin_code]" class="form-control" value="{{ $donor->personalDetail->pin_code ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Mobile</div>
                            <input type="text" name="personal_detail[mobile_no]" class="form-control" value="{{ $donor->personalDetail->mobile_no ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">WhatsApp</div>
                            <input type="text" name="personal_detail[whatsapp_no]" class="form-control" value="{{ $donor->personalDetail->whatsapp_no ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Email 1</div>
                            <input type="email" name="personal_detail[email_id_1]" class="form-control" value="{{ $donor->personalDetail->email_id_1 ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Email 2</div>
                            <input type="email" name="personal_detail[email_id_2]" class="form-control" value="{{ $donor->personalDetail->email_id_2 ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">PAN No</div>
                            <input type="text" name="personal_detail[pan_no]" class="form-control" value="{{ $donor->personalDetail->pan_no ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Date of Birth</div>
                            <input type="date" name="personal_detail[date_of_birth]" class="form-control" value="{{ $donor->personalDetail->date_of_birth ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Blood Group</div>
                            <input type="text" name="personal_detail[blood_group]" class="form-control" value="{{ $donor->personalDetail->blood_group ?? '' }}">
                        </div>
                    </div>
                    
                    <div class="form-navigation">
                        <div></div> <!-- Empty space for alignment -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-submit-update"><i class="fas fa-save me-2"></i> Update</button>
                            <button type="button" class="btn-nav btn-nav-next" onclick="nextStep()">Next <i class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Family Details -->
                <div class="step-content-section" id="step-2">
                    <h4 class="donorH4">Family Details</h4>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="info-label">Spouse Name</div>
                            <input type="text" name="family_detail[spouse_name]" class="form-control" value="{{ $donor->familyDetail->spouse_name ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Spouse DOB</div>
                            <input type="date" name="family_detail[spouse_birth_date]" class="form-control" value="{{ $donor->familyDetail->spouse_birth_date ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Spouse Blood Group</div>
                            <input type="text" name="family_detail[spouse_blood_group]" class="form-control" value="{{ $donor->familyDetail->spouse_blood_group ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Number of Kids</div>
                            <input type="number" name="family_detail[number_of_kids]" class="form-control" value="{{ $donor->familyDetail->number_of_kids ?? '' }}">
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <div class="info-label mb-2">Children Details</div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>DOB</th>
                                        <th>Blood Group</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($children) && count($children) > 0)
                                        @foreach($children as $i => $child)
                                        <tr>
                                            <td><input type="text" name="children[{{ $i }}][name]" class="form-control form-control-sm" value="{{ $child['name'] ?? '' }}"></td>
                                            <td>
                                                <select name="children[{{ $i }}][gender]" class="form-select form-select-sm">
                                                    <option value="Male" {{ ($child['gender'] ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option value="Female" {{ ($child['gender'] ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                                </select>
                                            </td>
                                            <td><input type="date" name="children[{{ $i }}][dob]" class="form-control form-control-sm" value="{{ $child['dob'] ?? '' }}"></td>
                                            <td><input type="text" name="children[{{ $i }}][blood_group]" class="form-control form-control-sm" value="{{ $child['blood_group'] ?? '' }}"></td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td><input type="text" name="children[0][name]" class="form-control form-control-sm"></td>
                                            <td><select name="children[0][gender]" class="form-select form-select-sm"><option>Male</option><option>Female</option></select></td>
                                            <td><input type="date" name="children[0][dob]" class="form-control form-control-sm"></td>
                                            <td><input type="text" name="children[0][blood_group]" class="form-control form-control-sm"></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="btn-nav btn-nav-back" onclick="prevStep()"><i class="fas fa-arrow-left me-2"></i> Back</button>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-submit-update"><i class="fas fa-save me-2"></i> Update</button>
                            <button type="button" class="btn-nav btn-nav-next" onclick="nextStep()">Next <i class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Nominee Details -->
                <div class="step-content-section" id="step-3">
                    <h4 class="donorH4">Nominee Details</h4>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="info-label">Nominee Name</div>
                            <input type="text" name="nominee_detail[nominee_name]" class="form-control" value="{{ $donor->nomineeDetail->nominee_name ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Relationship</div>
                            <input type="text" name="nominee_detail[nominee_relationship]" class="form-control" value="{{ $donor->nomineeDetail->nominee_relationship ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Mobile</div>
                            <input type="text" name="nominee_detail[nominee_mobile]" class="form-control" value="{{ $donor->nomineeDetail->nominee_mobile ?? '' }}">
                        </div>
                        <div class="col-md-12">
                            <div class="info-label">Address</div>
                            <textarea name="nominee_detail[nominee_address]" class="form-control">{{ $donor->nomineeDetail->nominee_address ?? '' }}</textarea>
                        </div>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="btn-nav btn-nav-back" onclick="prevStep()"><i class="fas fa-arrow-left me-2"></i> Back</button>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-submit-update"><i class="fas fa-save me-2"></i> Update</button>
                            <button type="button" class="btn-nav btn-nav-next" onclick="nextStep()">Next <i class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Membership Details -->
                <div class="step-content-section" id="step-4">
                    <h4 class="donorH4">Membership Details</h4>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="info-label">Selected Options</div>
                            <textarea name="membership_options" class="form-control" rows="4">{{ implode("\n", $paymentOptions ?? []) }}</textarea>
                            <small class="text-muted">Enter each membership option on a new line.</small>
                        </div>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="btn-nav btn-nav-back" onclick="prevStep()"><i class="fas fa-arrow-left me-2"></i> Back</button>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-submit-update"><i class="fas fa-save me-2"></i> Update</button>
                            <button type="button" class="btn-nav btn-nav-next" onclick="nextStep()">Next <i class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Step 5: Professional Details -->
                <div class="step-content-section" id="step-5">
                    <h4 class="donorH4">Professional Details</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-label">Company Name</div>
                            <input type="text" name="professional_detail[company_name]" class="form-control" value="{{ $donor->professionalDetail->company_name ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Designation</div>
                            <input type="text" name="professional_detail[designation]" class="form-control" value="{{ $donor->professionalDetail->designation ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Office Mobile</div>
                            <input type="text" name="professional_detail[office_mobile]" class="form-control" value="{{ $donor->professionalDetail->office_mobile ?? '' }}">
                        </div>
                        <div class="col-md-12">
                            <div class="info-label">Office Address</div>
                            <textarea name="professional_detail[office_address]" class="form-control">{{ $donor->professionalDetail->office_address ?? '' }}</textarea>
                        </div>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="btn-nav btn-nav-back" onclick="prevStep()"><i class="fas fa-arrow-left me-2"></i> Back</button>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-submit-update"><i class="fas fa-save me-2"></i> Update</button>
                            <button type="button" class="btn-nav btn-nav-next" onclick="nextStep()">Next <i class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Step 6: Documents -->
                <div class="step-content-section" id="step-6">
                    <h4 class="donorH4">Documents</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-label">PAN Card File</div>
                            <input type="file" name="pan_member_file" class="form-control">
                            @if(!empty($donor->document?->pan_member_file))
                                <div class="current-file">Current: <a href="{{ asset($donor->document->pan_member_file) }}" target="_blank">View File</a></div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Photo</div>
                            <input type="file" name="photo_file" class="form-control">
                             @if(!empty($donor->document?->photo_file))
                                <div class="current-file">Current: <a href="{{ asset($donor->document->photo_file) }}" target="_blank">View File</a></div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Address Proof</div>
                            <input type="file" name="address_proof_file" class="form-control">
                             @if(!empty($donor->document?->address_proof_file))
                                <div class="current-file">Current: <a href="{{ asset($donor->document->address_proof_file) }}" target="_blank">View File</a></div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="btn-nav btn-nav-back" onclick="prevStep()"><i class="fas fa-arrow-left me-2"></i> Back</button>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-submit-update"><i class="fas fa-save me-2"></i> Update</button>
                            <button type="button" class="btn-nav btn-nav-next" onclick="nextStep()">Next <i class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Step 7: Payment Details -->
                <div class="step-content-section" id="step-7">
                    <h4 class="donorH4">Payment Details</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>UTR/Cheque No</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Bank Branch</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($paymentEntries) > 0)
                                    @foreach($paymentEntries as $i => $entry)
                                    <tr>
                                        <td><input type="text" name="payments[{{ $i }}][utr_no]" class="form-control form-control-sm" value="{{ $entry['utr_no'] ?? '' }}"></td>
                                        <td><input type="date" name="payments[{{ $i }}][cheque_date]" class="form-control form-control-sm" value="{{ $entry['cheque_date'] ?? '' }}"></td>
                                        <td><input type="number" name="payments[{{ $i }}][amount]" class="form-control form-control-sm" value="{{ $entry['amount'] ?? '' }}"></td>
                                        <td><input type="text" name="payments[{{ $i }}][bank_branch]" class="form-control form-control-sm" value="{{ $entry['bank_branch'] ?? '' }}"></td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td><input type="text" name="payments[0][utr_no]" class="form-control form-control-sm"></td>
                                        <td><input type="date" name="payments[0][cheque_date]" class="form-control form-control-sm"></td>
                                        <td><input type="number" name="payments[0][amount]" class="form-control form-control-sm"></td>
                                        <td><input type="text" name="payments[0][bank_branch]" class="form-control form-control-sm"></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="btn-nav btn-nav-back" onclick="prevStep()"><i class="fas fa-arrow-left me-2"></i> Back</button>
                        <button type="submit" class="btn-submit-update"><i class="fas fa-save me-2"></i> Update Application</button>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    // Read initial step from the hidden input (which gets value from URL or defaults to 1)
    const stepInput = document.getElementById('current_step_input');
    let currentStep = parseInt(stepInput.value) || 1;
    const totalSteps = 7;

    // Initialize the view on page load
    document.addEventListener('DOMContentLoaded', function() {
        goToStep(currentStep);

        // Sidebar Click Logic
        const items = document.querySelectorAll('.donor-step-item');
        items.forEach(item => {
            item.addEventListener('click', function() {
                const step = parseInt(this.getAttribute('data-step'));
                goToStep(step);
            });
        });
    });

    function goToStep(step) {
        if (step < 1 || step > totalSteps) return;

        currentStep = step;
        
        // Update the hidden input value so the form submits the correct current step
        stepInput.value = step;

        // Update Sidebar Active State
        document.querySelectorAll('.donor-step-item').forEach((item, index) => {
            if (index + 1 === step) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });

        // Update Content Section Visibility
        document.querySelectorAll('.step-content-section').forEach((section, index) => {
            if (index + 1 === step) {
                section.classList.add('active');
            } else {
                section.classList.remove('active');
            }
        });
    }

    function nextStep() {
        if (currentStep < totalSteps) {
            goToStep(currentStep + 1);
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            goToStep(currentStep - 1);
        }
    }
</script>
@endsection