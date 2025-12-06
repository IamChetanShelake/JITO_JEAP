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
                    <form method="POST" action="{{ route('user.step5.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card form-card">
                            <div class="card-body">

                                <div class="step-card">
                                    <div class="card-icon">
                                        <i class="bi bi-check2-square"></i>
                                    </div>
                                    <div>
                                        <h3 class="card-title">Guarantor Details</h3>
                                        <p class="card-subtitle">Information about your Guarantors</p>
                                    </div>
                                </div>

                                <!-- Important Note Box -->
                                <div
                                    style="background-color: #FEF6E0; border: 1px solid #FBBA00; border-radius: 8px; padding: 12px; margin-bottom: 20px;">
                                    <p class="mb-0" style="color: #494C4E; font-size: 14px;font-weight: 500;">
                                        <strong>Note:</strong> We accept cheques only from Government Nationalized Banks
                                        and the following banks: HDFC Bank, ICICI Bank, Kotak Mahindra Bank, Axis Bank,
                                        IndusInd Bank, IDBI Bank, Yes Bank, and IDFC First Bank. Please mention the bank
                                        details of the account from which post-dated cheques will be submitted if your
                                        application is sanctioned.
                                    </p>
                                </div>

                                <!--  Guarantor Fields -->
                                <div class="guarantor-section">
                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                            <h4 class="title mb-3" style="color:#4C4C4C;font-size:18px;">First Guarantor
                                            </h4>
                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="g_one_name"
                                                    placeholder="Name *" value="{{ old('g_one_name') }}" required>
                                                <small class="text-danger">{{ $errors->first('g_one_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <select class="form-control" name="g_one_gender" required>
                                                    <option disabled {{ old('g_one_gender') ? '' : 'selected' }} hidden>
                                                        Gender *
                                                    </option>
                                                    <option value="male"
                                                        {{ old('g_one_gender') == 'male' ? 'selected' : '' }}>
                                                        Male</option>
                                                    <option value="female"
                                                        {{ old('g_one_gender') == 'female' ? 'selected' : '' }}>Female
                                                    </option>
                                                </select>
                                                <small class="text-danger">{{ $errors->first('g_one_gender') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <textarea class="form-control" name="g_one_permanent_address" rows="3" placeholder="Permanent Address *" required>{{ old('g_one_permanent_address') }}</textarea>
                                                <small
                                                    class="text-danger">{{ $errors->first('g_one_permanent_address') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="tel" name="g_one_phone" class="form-control"
                                                    placeholder="Phone Number *" value="{{ old('g_one_phone') }}"
                                                    maxlength="10" required>
                                                <small class="text-danger">{{ $errors->first('g_one_phone') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="email" name="g_one_email" class="form-control"
                                                    placeholder="Email ID *" value="{{ old('g_one_email') }}" required>
                                                <small class="text-danger">{{ $errors->first('g_one_email') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control"
                                                    name="g_one_relation_with_student" placeholder="Relation with student *"
                                                    value="{{ old('g_one_relation_with_student') }}" required>
                                                <small
                                                    class="text-danger">{{ $errors->first('g_one_relation_with_student') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="number" name="g_one_aadhar_card_number" class="form-control"
                                                    placeholder="Aadhar Card Number *" minlength="12" maxlength="12"
                                                    value="{{ old('g_one_aadhar_card_number') }}" required>
                                                <small
                                                    class="text-danger">{{ $errors->first('g_one_aadhar_card_number') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="g_one_pan_card_no"
                                                    placeholder="Pan card" value="{{ old('g_one_pan_card_no') }}"
                                                    minlength="10" maxlength="10" required>
                                                <small
                                                    class="text-danger">{{ $errors->first('g_one_pan_card_no') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" name="g_one_d_o_b" class="form-control"
                                                    placeholder="Date of Birth *" value="{{ old('g_one_d_o_b') }}"
                                                    pattern="\d{2}-\d{2}-\d{4}" title="Format: dd-mm-yyyy"
                                                    inputmode="numeric" required>
                                                <small class="text-danger">{{ $errors->first('g_one_d_o_b') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <select class="form-control" name="g_one_income" required>
                                                    <option disabled {{ old('g_one_income') ? '' : 'selected' }} hidden>
                                                        Income *</option>

                                                    <option value="10000-20000"
                                                        {{ old('g_one_income') == '10000-20000' ? 'selected' : '' }}>10,000
                                                        – 20,000</option>
                                                    <option value="20000-40000"
                                                        {{ old('g_one_income') == '20000-40000' ? 'selected' : '' }}>20,000
                                                        – 40,000</option>
                                                    <option value="40000-70000"
                                                        {{ old('g_one_income') == '40000-70000' ? 'selected' : '' }}>40,000
                                                        – 70,000</option>
                                                    <option value="70000-100000"
                                                        {{ old('g_one_income') == '70000-100000' ? 'selected' : '' }}>
                                                        70,000 – 100,000</option>
                                                    <option value="100000-150000"
                                                        {{ old('g_one_income') == '100000-150000' ? 'selected' : '' }}>
                                                        100,000 – 150,000</option>
                                                </select>

                                                <small class="text-danger">{{ $errors->first('g_one_income') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <span class="photo-label">Guarantor 1 - Pan card copy *</span>

                                                    <label for="uploadInput1" class="upload-btn">
                                                        <span class="upload-icon">⭱</span> Upload
                                                    </label>

                                                    <input type="file" id="uploadInput1" name="g_one_pan_card" hidden
                                                        accept=".jpg,.jpeg,.png">
                                                </div>
                                                <small class="text-danger">{{ $errors->first('g_one_pan_card') }}</small>
                                            </div>



                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                            <h4 class="title mb-3" style="color:#4C4C4C;font-size:18px;">Second Guarantor
                                            </h4>
                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="g_two_name"
                                                    placeholder="Name *" value="{{ old('g_two_name') }}" required>
                                                <small class="text-danger">{{ $errors->first('g_two_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <select class="form-control" name="g_two_gender" required>
                                                    <option disabled {{ old('g_two_gender') ? '' : 'selected' }} hidden>
                                                        Gender *
                                                    </option>
                                                    <option value="male"
                                                        {{ old('g_two_gender') == 'male' ? 'selected' : '' }}>
                                                        Male</option>
                                                    <option value="female"
                                                        {{ old('g_two_gender') == 'female' ? 'selected' : '' }}>Female
                                                    </option>
                                                </select>
                                                <small class="text-danger">{{ $errors->first('g_two_gender') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <textarea class="form-control" name="g_two_permanent_address" rows="3" placeholder="Permanent Address *"
                                                    required>{{ old('g_two_permanent_address') }}</textarea>
                                                <small
                                                    class="text-danger">{{ $errors->first('g_two_permanent_address') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="tel" name="g_two_phone" class="form-control"
                                                    placeholder="Phone Number *" value="{{ old('g_two_phone') }}"
                                                    maxlength="10" required>
                                                <small class="text-danger">{{ $errors->first('g_two_phone') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="email" name="g_two_email" class="form-control"
                                                    placeholder="Email ID *" value="{{ old('g_two_email') }}" required>
                                                <small class="text-danger">{{ $errors->first('g_two_email') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control"
                                                    name="g_two_relation_with_student"
                                                    placeholder="Relation with student *"
                                                    value="{{ old('g_two_relation_with_student') }}" required>
                                                <small
                                                    class="text-danger">{{ $errors->first('g_two_relation_with_student') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="number" name="g_two_aadhar_card_number"
                                                    class="form-control" placeholder="Aadhar Card Number *"
                                                    minlength="12" maxlength="12"
                                                    value="{{ old('g_two_aadhar_card_number') }}" required>
                                                <small
                                                    class="text-danger">{{ $errors->first('g_two_aadhar_card_number') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="g_two_pan_card_no"
                                                    placeholder="Pan card" value="{{ old('g_two_pan_card_no') }}"
                                                    minlength="10" maxlength="10" required>
                                                <small
                                                    class="text-danger">{{ $errors->first('g_two_pan_card_no') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" name="g_two_d_o_b" class="form-control"
                                                    placeholder="Date of Birth *" value="{{ old('g_two_d_o_b') }}"
                                                    pattern="\d{2}-\d{2}-\d{4}" title="Format: dd-mm-yyyy"
                                                    inputmode="numeric" required>
                                                <small class="text-danger">{{ $errors->first('g_two_d_o_b') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <select class="form-control" name="g_two_income" required>
                                                    <option disabled {{ old('g_two_income') ? '' : 'selected' }} hidden>
                                                        Income *</option>

                                                    <option value="10000-20000"
                                                        {{ old('g_two_income') == '10000-20000' ? 'selected' : '' }}>10,000
                                                        – 20,000</option>
                                                    <option value="20000-40000"
                                                        {{ old('g_two_income') == '20000-40000' ? 'selected' : '' }}>20,000
                                                        – 40,000</option>
                                                    <option value="40000-70000"
                                                        {{ old('g_two_income') == '40000-70000' ? 'selected' : '' }}>40,000
                                                        – 70,000</option>
                                                    <option value="70000-100000"
                                                        {{ old('g_two_income') == '70000-100000' ? 'selected' : '' }}>
                                                        70,000 – 100,000</option>
                                                    <option value="100000-150000"
                                                        {{ old('g_two_income') == '100000-150000' ? 'selected' : '' }}>
                                                        100,000 – 150,000</option>
                                                </select>

                                                <small class="text-danger">{{ $errors->first('g_two_income') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <span class="photo-label">Guarantor 2 - Pan card copy *</span>

                                                    <label for="uploadInput2" class="upload-btn">
                                                        <span class="upload-icon">⭱</span> Upload
                                                    </label>

                                                    <input type="file" id="uploadInput2" name="g_two_pan_card" hidden
                                                        accept=".jpg,.jpeg,.png">
                                                </div>
                                                <small class="text-danger">{{ $errors->first('g_two_pan_card') }}</small>
                                            </div>


                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <h4 class="title mb-3" style="color:#4C4C4C;font-size:18px;">Power of Attorney
                                            Details
                                        </h4>

                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="attorney_name"
                                                    placeholder="Name *" value="{{ old('attorney_name') }}" required>
                                                <small class="text-danger">{{ $errors->first('attorney_name') }}</small>
                                            </div>


                                            <div class="form-group mb-3">
                                                <input type="email" name="attorney_email" class="form-control"
                                                    placeholder="Email *" value="{{ old('attorney_email') }}" required>
                                                <small class="text-danger">{{ $errors->first('attorney_email') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="tel" name="attorney_phone" class="form-control"
                                                    placeholder="Contact *" value="{{ old('attorney_phone') }}"
                                                    maxlength="10" required>
                                                <small class="text-danger">{{ $errors->first('attorney_phone') }}</small>
                                            </div>

                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group mb-3">
                                                <textarea class="form-control" name="attorney_address" rows="3" placeholder="Address *" required>{{ old('attorney_address') }}</textarea>
                                                <small
                                                    class="text-danger">{{ $errors->first('attorney_address') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control"
                                                    name="attorney_relation_with_student" placeholder="Relation *"
                                                    value="{{ old('attorney_relation_with_student') }}" required>
                                                <small
                                                    class="text-danger">{{ $errors->first('attorney_relation_with_student') }}</small>
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
