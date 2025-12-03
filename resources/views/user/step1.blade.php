@extends('user.layout.master')
@section('content')
    <!-- Main Content -->
    <div class="col-lg-9 main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('user.step1.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card form-card">
                            <div class="card-body">

                                <div class="step-card">
                                    <div class="card-icon">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div>
                                        <h3 class="card-title">Personal Details</h3>
                                        <p class="card-subtitle">Provide your correct details</p>
                                    </div>
                                </div>




                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">

                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Applicant's Name *" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <div class="photo-upload-box">
                                                <span class="photo-label">Add Photo *</span>

                                                <label for="uploadInput" class="upload-btn">
                                                    <span class="upload-icon">⭱</span> Upload
                                                </label>

                                                <input type="file" id="uploadInput" name="image" hidden>
                                            </div>
                                        </div>

                                        {{-- <div class="form-group mb-3">
                                                    <select class="form-control" style="color:#4C4C4C" required>
                                                        <option>Financial Asset Type *</option>
                                                        <option value="domestic">Domestic</option>
                                                        <option value="foreign_finance_assistant">Foreign Financial
                                                            Assistance</option>
                                                    </select>
                                                </div> --}}
                                        <div class="form-group mb-3">
                                            <select class="form-control " name="financial_asset_type" required>
                                                <option disabled selected hidden>Financial Asst Type *</option>
                                                <option value="domestic">Domestic</option>
                                                <option value="foreign_finance_assistant">Foreign Financial
                                                    Assistance</option>
                                            </select>
                                        </div>


                                        <div class="form-group mb-3">
                                            <select class="form-control" name="financial_asset_for" required>
                                                <option disabled selected hidden>Financial Asset For *</option>
                                                <option value="graduation">Graduation</option>
                                                <option value="post_graduation">Post Graduation</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="number" name="aadhar_card_number" class="form-control"
                                                placeholder="Aadhar Card Number *" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" name="pan_card"
                                                placeholder="Pan card" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="tel" name="phone" class="form-control"
                                                placeholder="Phone Number *" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Email Address *" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="tel" name="alternate_phone" class="form-control"
                                                placeholder="Alternate Phone Number">
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="email" name="alternate_email" class="form-control"
                                                placeholder="Alternate Email Address">
                                        </div>

                                        <div class="form-group mb-3">
                                            <textarea class="form-control" name="address" rows="3" placeholder="Current Address *" required></textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" name="city" placeholder="City *"
                                                required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" name="district"
                                                placeholder="District *" required>
                                        </div>

                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-6">



                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" name="state" placeholder="State *"
                                                required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="text" name="chapter" class="form-control"
                                                placeholder="Chapter *" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="number" name="pin_code" class="form-control"
                                                placeholder="Pin Code *" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <select class="form-control" name="nationality" required>
                                                <option disabled selected hidden>Nationality *</option>
                                                <option value="indian">Indian</option>
                                                <option value="foreigner">Foreigner</option>
                                            </select>
                                        </div>

                                        {{-- <div class="form-group mb-3">
                                                    <input type="text" name="d_o_b" class="form-control"
                                                        placeholder="Date of Birth *" required>
                                                </div> --}}
                                        {{-- <div class="form-group mb-3">
                                                    <input type="text" id="dob" name="d_o_b"
                                                        class="form-control"
                                                        placeholder="Date of Birth (dd-mm-yyyy) *" required>
                                                </div>

                                                <script>
                                                    document.getElementById('dob').addEventListener('input', function(e) {
                                                        let value = e.target.value.replace(/\D/g, '').slice(0, 8);
                                                        if (value.length >= 5) {
                                                            value = value.replace(/(\d{2})(\d{2})(\d{0,4})/, '$1-$2-$3');
                                                        } else if (value.length >= 3) {
                                                            value = value.replace(/(\d{2})(\d{0,2})/, '$1-$2');
                                                        }
                                                        e.target.value = value;
                                                    });
                                                </script> --}}

                                        <div class="form-group mb-3">
                                            <input type="text" name="d_o_b" class="form-control"
                                                placeholder="Date of Birth (dd-mm-yyyy) *" pattern="\d{2}-\d{2}-\d{4}"
                                                title="Format: dd-mm-yyyy" inputmode="numeric" required>
                                        </div>



                                        <div class="form-group mb-3">
                                            <input type="text" name="birth_place" class="form-control"
                                                placeholder="Birth Place *" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <select class="form-control" name="gender" required>
                                                <option disabled selected hidden>Gender *</option>
                                                <option name="male">Male</option>
                                                <option name="female">Female</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="number" name="age" class="form-control"
                                                placeholder="Age *" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <select class="form-control" name="marital_status" required>
                                                <option disabled selected hidden>Marital Status *</option>
                                                <option value="married">Married</option>
                                                <option value="unmarried">Unmarried</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="text" name="religion" class="form-control"
                                                placeholder="Religion *" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="text" name="sub_cast" class="form-control"
                                                placeholder="Sub caste *" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <select class="form-control" name="blood_group" required>
                                                <option disabled selected hidden>Blood Group *</option>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB-">AB-</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <select class="form-control" name="specially_abled" required>
                                                <option disabled selected hidden>Specially Abled *</option>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
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
@endsection
