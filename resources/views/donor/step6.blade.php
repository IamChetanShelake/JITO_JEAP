@extends('donor.layout.master')

@section('step')
    <button class="btn me-2" style="background-color:#393185;color:white;">
        Step 6 of 8
    </button>
@endsection

@section('content')
    <div class="col-lg-9 main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form method="POST" action="{{ route('donor.step6.store') }}" enctype="multipart/form-data">
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

                        <h4 class="mb-3 text-center">Step 6 : Document Upload</h4>

                        <div class="card mb-4">
                            <div class="card-body">

                                <h5 class="mb-3">Mandatory Documents</h5>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>PAN Card Copy of Member *</label>
                                        <input type="file" class="form-control" name="pan_member_file"
                                            {{ empty($document?->pan_member_file) ? 'required' : '' }}>
                                        @error('pan_member_file')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        @if (!empty($document?->pan_member_file))
                                            <small class="text-muted">Uploaded: <a
                                                    href="{{ asset($document->pan_member_file) }}"
                                                    target="_blank">View</a></small>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>PAN Card Copy of Donor (If Different) *</label>
                                        <input type="file" class="form-control" name="pan_donor_file"
                                            {{ empty($document?->pan_donor_file) ? 'required' : '' }}>
                                        @error('pan_donor_file')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        @if (!empty($document?->pan_donor_file))
                                            <small class="text-muted">Uploaded: <a
                                                    href="{{ asset($document->pan_donor_file) }}"
                                                    target="_blank">View</a></small>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Passport Size Photograph *</label>
                                        <input type="file" class="form-control" name="photo_file"
                                            {{ empty($document?->photo_file) ? 'required' : '' }}>
                                        @error('photo_file')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        @if (!empty($document?->photo_file))
                                            <small class="text-muted">Uploaded: <a href="{{ asset($document->photo_file) }}"
                                                    target="_blank">View</a></small>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Address Proof *</label>
                                        <input type="file" class="form-control" name="address_proof_file"
                                            {{ empty($document?->address_proof_file) ? 'required' : '' }}>
                                        @error('address_proof_file')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        @if (!empty($document?->address_proof_file))
                                            <small class="text-muted">Uploaded: <a
                                                    href="{{ asset($document->address_proof_file) }}"
                                                    target="_blank">View</a></small>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Company Authorization Letter *</label>
                                        <input type="file" class="form-control" name="authorization_letter_file"
                                            {{ empty($document?->authorization_letter_file) ? 'required' : '' }}>
                                        @error('authorization_letter_file')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        @if (!empty($document?->authorization_letter_file))
                                            <small class="text-muted">Uploaded: <a
                                                    href="{{ asset($document->authorization_letter_file) }}"
                                                    target="_blank">View</a></small>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- CHECKLIST -->
                        <div class="card mb-4">
                            <div class="card-body">

                                <h5 class="mb-3">Most Important Things to Check</h5>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="check_signature"
                                        {{ old('check_signature', $document->check_signature ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Member’s Signature on Form
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="check_contact"
                                        {{ old('check_contact', $document->check_contact ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Mobile Number & Email Address Mentioned
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="check_nominee"
                                        {{ old('check_nominee', $document->check_nominee ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Nominee Name & Details Filled
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="check_pan"
                                        {{ old('check_pan', $document->check_pan ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        PAN Card Copy Attached
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="check_payment"
                                        {{ old('check_payment', $document->check_payment ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Payment Details Filled Properly
                                    </label>
                                </div>

                            </div>
                        </div>


                        <!-- BUTTONS -->
                        <div class="d-flex justify-content-between mt-4 mb-4">
                            <a href="{{ route('donor.step5') }}" class="btn" style="background:#988DFF1F;color:gray;">
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
