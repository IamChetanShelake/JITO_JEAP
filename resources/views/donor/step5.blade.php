@extends('donor.layout.master')

@section('step')
    <button class="btn me-2" style="background-color:#393185;color:white;">
        Step 5 of 8
    </button>
@endsection

@section('content')
    <div class="col-lg-9 main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <form method="POST" action="{{ route('donor.step5.store') }}">
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
                        <div class="card form-card">
                            <div class="card-body">

                                <h4 class="mb-4 text-center">Professional / Office Details</h4>

                                <!-- COMPANY DETAILS -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>Company Name *</label>
                                        <input type="text" name="company_name" class="form-control"
                                            placeholder="Enter company name" required
                                            value="{{ old('company_name', $professionalDetail->company_name ?? '') }}">
                                        @error('company_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label>Company Activity *</label>
                                        <input type="text" name="company_activity_details" class="form-control"
                                            placeholder="Enter company activity details" required
                                            value="{{ old('company_activity_details', $professionalDetail->company_activity_details ?? '') }}">
                                        @error('company_activity_details')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>Designation *</label>
                                        <input type="text" name="designation" class="form-control"
                                            placeholder="Enter designation" required
                                            value="{{ old('designation', $professionalDetail->designation ?? '') }}">
                                        @error('designation')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label>Company Website</label>
                                        <input type="url" name="company_website" class="form-control" onblur="fixUrl(this)" placeholder="https://example.com"
                                            value="{{ old('company_website', $professionalDetail->company_website ?? '') }}">
                                        @error('company_website')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <script>
                                    function fixUrl(input) {
                                        if (input.value && !input.value.match(/^https?:\/\//)) {
                                            input.value = 'https://' + input.value;
                                        }
                                    }
                                </script>


                                <hr>

                                <!-- OFFICE ADDRESS -->


                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label>Office Address *</label>
                                        <textarea name="office_address" class="form-control" rows="2" placeholder="Enter office address"
                                            required>{{ old('office_address', $professionalDetail->office_address ?? '') }}</textarea>
                                        @error('office_address')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>State *</label>
                                        <input type="text" name="office_state" class="form-control"
                                            placeholder="Enter office state" required
                                            value="{{ old('office_state', $professionalDetail->office_state ?? '') }}">
                                        @error('office_state')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label>City *</label>
                                        <input type="text" name="office_city" class="form-control"
                                            placeholder="Enter office city" required
                                            value="{{ old('office_city', $professionalDetail->office_city ?? '') }}">
                                        @error('office_city')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label>Pincode *</label>
                                        <input type="text" name="office_pincode" class="form-control" maxlength="6"
                                            placeholder="Enter 6-digit office pincode" required
                                            value="{{ old('office_pincode', $professionalDetail->office_pincode ?? '') }}">
                                        @error('office_pincode')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>Telephone No *</label>
                                        <input type="text" name="office_telephone" class="form-control"
                                            placeholder="Enter office telephone number" required
                                            value="{{ old('office_telephone', $professionalDetail->office_telephone ?? '') }}">
                                        @error('office_telephone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label>Mobile No *</label>
                                        <input type="text" name="office_mobile" class="form-control" maxlength="10"
                                            placeholder="Enter 10-digit office mobile number" required
                                            value="{{ old('office_mobile', $professionalDetail->office_mobile ?? '') }}">
                                        @error('office_mobile')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <hr>

                                <!-- PAN -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>PAN No *</label>
                                        <input type="text" name="pan_no" class="form-control" maxlength="10"
                                            placeholder="Enter PAN number" required
                                            value="{{ old('pan_no', $professionalDetail->pan_no ?? '') }}">
                                        @error('pan_no')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <hr>

                                <!-- SECRETARY / COORDINATOR -->
                                <h5 class="mb-3">Secretary / Coordinator Details</h5>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>Name</label>
                                        <input type="text" name="coordinator_name" class="form-control" placeholder="Enter coordinator name"
                                            value="{{ old('coordinator_name', $professionalDetail->coordinator_name ?? '') }}">
                                        @error('coordinator_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label>Mobile No</label>
                                        <input type="text" name="coordinator_mobile" class="form-control"
                                            maxlength="10" placeholder="Enter coordinator mobile number"
                                            value="{{ old('coordinator_mobile', $professionalDetail->coordinator_mobile ?? '') }}">
                                        @error('coordinator_mobile')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>Email 1</label>
                                        <input type="email" name="coordinator_email_1" class="form-control" placeholder="Enter coordinator email 1"
                                            value="{{ old('coordinator_email_1', $professionalDetail->coordinator_email_1 ?? '') }}">
                                        @error('coordinator_email_1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label>Email 2</label>
                                        <input type="email" name="coordinator_email_2" class="form-control" placeholder="Enter coordinator email 2"
                                            value="{{ old('coordinator_email_2', $professionalDetail->coordinator_email_2 ?? '') }}">
                                        @error('coordinator_email_2')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- BUTTONS -->
                        <div class="d-flex justify-content-between mt-4 mb-4">
                            <a href="{{ route('donor.step4') }}" class="btn"
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
    </div>
@endsection
