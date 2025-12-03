@extends('user.layout.master')

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
    </style>
    <!-- Main Content -->
    <div class="col-lg-9 main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('user.step2.store') }}" enctype="multipart/form-data">
                        @csrf
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
                                            <input type="number" class="form-control" name="number_family_members"
                                                placeholder="Number of Family Members *" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="number" class="form-control" name="total_family_income"
                                                placeholder="Total Family Income (₹) *" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="number" class="form-control" name="total_students"
                                                placeholder="Total Number of Students *" required>
                                        </div>

                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <input type="number" class="form-control" name="family_member_diksha"
                                                placeholder="Family Member Taken Diksha " >
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="number" class="form-control" name="total_insurance_coverage"
                                                placeholder="Total Insurance Coverage of Family (₹) *" required>
                                        </div>



                                        <div class="form-group mb-3">
                                            <input type="number" class="form-control" name="total_premium_paid"
                                                placeholder="Total Premium Paid in Rupees/Year *" required>
                                        </div>

                                    </div>
                                </div>

                                {{-- </div>
                        </div>

                        <div class="card form-card">
                            <div class="card-body"> --}}

                                {{-- <div class="step-card">
                                    <div class="card-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div>
                                        <h3 class="card-title">Parents Details</h3>
                                        <p class="card-subtitle">Details about your parents</p>
                                    </div>
                                </div> --}}
                                <hr>

                                <!-- Bootstrap Tabs for Parents Details -->
                                <ul class="nav nav-tabs" id="parentTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="father-tab" data-bs-toggle="tab"
                                            data-bs-target="#father" type="button" role="tab" aria-controls="father"
                                            aria-selected="true">Father's Details</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="mother-tab" data-bs-toggle="tab"
                                            data-bs-target="#mother" type="button" role="tab" aria-controls="mother"
                                            aria-selected="false">Mother's Details</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="additional-tab" data-bs-toggle="tab"
                                            data-bs-target="#additional" type="button" role="tab" aria-controls="additional"
                                            aria-selected="false">Additional Information</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="parentTabsContent">
                                    <!-- Father's Details Tab -->
                                    <div class="tab-pane fade show active" id="father" role="tabpanel"
                                        aria-labelledby="father-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="father_name"
                                                        placeholder="Father's Name *" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="number" class="form-control" name="father_age"
                                                        placeholder="Age *" required min="18">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <select class="form-control" name="father_marital_status" required>
                                                        <option disabled selected hidden>Marital Status *</option>
                                                        <option value="married">Married</option>
                                                        <option value="unmarried">Unmarried</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="father_qualification"
                                                        placeholder="Qualification *" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="father_occupation"
                                                        placeholder="Occupation *" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="tel" class="form-control" name="father_mobile"
                                                        placeholder="Mobile Number *" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Mother's Details Tab -->
                                    <div class="tab-pane fade" id="mother" role="tabpanel"
                                        aria-labelledby="mother-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="mother_name"
                                                        placeholder="Mother's Name *" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="number" class="form-control" name="mother_age"
                                                        placeholder="Age *" required min="18">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <select class="form-control" name="mother_marital_status" required>
                                                        <option disabled selected hidden>Marital Status *</option>
                                                        <option value="married">Married</option>
                                                        <option value="unmarried">Unmarried</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control"
                                                        name="mother_qualification" placeholder="Qualification *"
                                                        required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="mother_occupation"
                                                        placeholder="Occupation *" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="tel" class="form-control" name="mother_mobile"
                                                        placeholder="Mobile Number *" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Additional Information Tab -->
                                    <div class="tab-pane fade" id="additional" role="tabpanel" aria-labelledby="additional-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Do You Have Sibling?</label>
                                                    <div>
                                                        <input type="radio" name="has_sibling" value="yes" id="has_sibling_yes"> <label for="has_sibling_yes">Yes</label>
                                                        <input type="radio" name="has_sibling" value="no" id="has_sibling_no" checked> <label for="has_sibling_no">No</label>
                                                    </div>
                                                </div>
                                                <div id="sibling-fields" style="display: none;">
                                                    <div class="form-group mb-3">
                                                        <input type="number" class="form-control" name="number_of_siblings" placeholder="Number Of Siblings">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control" name="sibling_name_1" placeholder="Name 1">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control" name="sibling_qualification" placeholder="Qualification">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control" name="sibling_occupation" placeholder="Occupation">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control" name="sibling_mobile" placeholder="Mobile Number">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="email" class="form-control" name="sibling_email" placeholder="Email Address">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="number" class="form-control" name="sibling_yearly_income" placeholder="Yearly Gross Income (₹)">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="number" class="form-control" name="sibling_insurance_coverage" placeholder="Individual Insurance Coverage Value (₹)">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="number" class="form-control" name="sibling_premium_paid" placeholder="Individual Premium Paid Year (₹)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="email" class="form-control" name="additional_email" placeholder="Email Address *" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="number" class="form-control" name="yearly_gross_income" placeholder="Yearly Gross Income (₹) *" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="number" class="form-control" name="individual_insurance_coverage" placeholder="Individual Insurance Coverage Value (₹) *" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="number" class="form-control" name="individual_premium_paid" placeholder="Individual Premium Paid Year (₹) *" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <div class="photo-upload-box">
                                                        <span class="photo-label">Father's Aadhaar Card</span>
                                                        <label for="father_aadhaar" class="upload-btn">
                                                            <span class="upload-icon">⭱</span> Upload
                                                        </label>
                                                        <input type="file" id="father_aadhaar" name="father_aadhaar" hidden accept=".jpg,.jpeg,.png,.pdf">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <div class="photo-upload-box">
                                                        <span class="photo-label">Father's Passport Size Photo</span>
                                                        <label for="father_photo" class="upload-btn">
                                                            <span class="upload-icon">⭱</span> Upload
                                                        </label>
                                                        <input type="file" id="father_photo" name="father_photo" hidden accept=".jpg,.jpeg,.png">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card form-card">
                            <div class="card-body">

                                <div class="step-card">
                                    <div class="card-icon">
                                        <i class="bi bi-person-hearts"></i>
                                    </div>
                                    <div>
                                        <h3 class="card-title">Paternal & Maternal Side</h3>
                                        <p class="card-subtitle">Details about relatives</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="border rounded p-3 mb-3">
                                            <h5 class="text-primary mb-3">Paternal Side</h5>
                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="paternal_uncle_name"
                                                    placeholder="Paternal Uncle's Name">
                                            </div>
                                            <div class="form-group mb-3">
                                                <input type="tel" class="form-control" name="paternal_uncle_mobile"
                                                    placeholder="His Mobile Number">
                                            </div>
                                            <div class="form-group mb-3">
                                                <input type="email" class="form-control" name="paternal_uncle_email"
                                                    placeholder="His Email Address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="border rounded p-3 mb-3">
                                            <h5 class="text-primary mb-3">Maternal Side</h5>
                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="maternal_aunt_name"
                                                    placeholder="Maternal Aunt's Name">
                                            </div>
                                            <div class="form-group mb-3">
                                                <input type="tel" class="form-control" name="maternal_aunt_mobile"
                                                    placeholder="Her Mobile Number">
                                            </div>
                                            <div class="form-group mb-3">
                                                <input type="email" class="form-control" name="maternal_aunt_email"
                                                    placeholder="Her Email Address">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4 mb-4">
                            <button type="button" class="btn" style="background:#988DFF1F;color:gray;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    stroke="gray" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M15 18l-6-6 6-6" />
                                </svg>
                                Previous
                            </button>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to show/hide sibling fields
        function toggleSiblingFields() {
            const hasSibling = document.querySelector('input[name="has_sibling"]:checked').value;
            const siblingFields = document.getElementById('sibling-fields');
            const siblingInputs = siblingFields.querySelectorAll('input');

            if (hasSibling === 'yes') {
                siblingFields.style.display = 'block';
            } else {
                siblingFields.style.display = 'none';
                // Reset all sibling fields
                siblingInputs.forEach(input => {
                    input.value = '';
                });
            }
        }

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
    })
</script>
@endsection
