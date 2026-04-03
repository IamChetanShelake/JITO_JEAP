@extends('donor.layout.master')

@section('step')
    <button class="btn me-2" style="background:#393185;color:white;">
        Step 1 of 8
    </button>
@endsection

@section('content')
    <style>
        select option {
            border: none !important;
            border-radius: 15px !important;
            background-color: #F2F2F2 !important;
        }

        .ucwords {
            text-transform: capitalize;
        }

        .btn-add-remove {
            width: 38px;
            height: 38px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
        }

        /* Styles for file preview items */
        .file-preview-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 8px;
        }

        .file-preview-item .file-info {
            display: flex;
            align-items: center;
            gap: 10px;
            overflow: hidden;
        }

        .file-preview-item .file-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border-radius: 6px;
            border: 1px solid #dee2e6;
        }

        .file-preview-item .file-name {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        .file-preview-item .file-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>

    <!-- Main Content -->
    <div class="col-lg-9 main-content">
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
                    <form method="POST" action="{{ route('donor.step1.store') }}" enctype="multipart/form-data" novalidate>
                        @csrf

                        @php
                            $personalDetail = $personalDetail ?? new \App\Models\DonorPersonalDetail();

                            if (!function_exists('getImageUrl')) {
                                function getImageUrl($path)
                                {
                                    if (empty($path)) {
                                        return '';
                                    }
                                    if (str_starts_with($path, 'http')) {
                                        return $path;
                                    }
                                    if (
                                        str_starts_with($path, 'uploads/documents') ||
                                        str_starts_with($path, 'donor_documents')
                                    ) {
                                        return asset($path);
                                    }
                                    return asset('storage/' . $path);
                                }
                            }
                        @endphp

                        <div class="card form-card">
                            <div class="card-body">
                                <h4 class="mb-4 text-center">Personal Details (Mandatory)</h4>

                                <!-- NAME SECTION -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>Title</label><br>

                                        <input type="radio" name="title" value="Mr"
                                            {{ old('title', $personalDetail->title ?? '') == 'Mr' ? 'checked' : '' }}> Mr

                                        <input type="radio" name="title" value="Mrs"
                                            {{ old('title', $personalDetail->title ?? '') == 'Mrs' ? 'checked' : '' }}> Mrs

                                        <input type="radio" name="title" value="Ms"
                                            {{ old('title', $personalDetail->title ?? '') == 'Ms' ? 'checked' : '' }}> Ms

                                        <input type="radio" name="title" value="Master"
                                            {{ old('title', $personalDetail->title ?? '') == 'Master' ? 'checked' : '' }}>
                                        Master

                                        @error('title')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>First Name *</label>
                                        <input type="text" name="first_name" class="form-control ucwords"
                                            placeholder="Enter first name" required
                                            value="{{ old('first_name', $personalDetail->first_name ?? '') }}">
                                        @error('first_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label>Middle Name</label>
                                        <input type="text" name="middle_name" class="form-control ucwords"
                                            placeholder="Enter middle name"
                                            value="{{ old('middle_name', $personalDetail->middle_name ?? '') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Surname *</label>
                                        <input type="text" name="surname" class="form-control ucwords"
                                            placeholder="Enter surname" required
                                            value="{{ old('surname', $personalDetail->surname ?? '') }}">
                                        @error('surname')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- ADDRESS -->
                                <div class="mb-3">
                                    <label>Complete Address (Residence) *</label>
                                    <textarea name="complete_address" class="form-control" rows="2" placeholder="Enter complete residence address"
                                        required>{{ old('complete_address', $personalDetail->complete_address ?? '') }}</textarea>
                                    @error('complete_address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>City *</label>
                                        <input type="text" name="city" class="form-control ucwords"
                                            placeholder="Enter city" required
                                            value="{{ old('city', $personalDetail->city ?? '') }}">
                                        @error('city')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <!-- STATE DROPDOWN -->
                                    @php
                                        $states = [
                                            'Andhra Pradesh',
                                            'Arunachal Pradesh',
                                            'Assam',
                                            'Bihar',
                                            'Chhattisgarh',
                                            'Goa',
                                            'Gujarat',
                                            'Haryana',
                                            'Himachal Pradesh',
                                            'Jharkhand',
                                            'Karnataka',
                                            'Kerala',
                                            'Madhya Pradesh',
                                            'Maharashtra',
                                            'Manipur',
                                            'Meghalaya',
                                            'Mizoram',
                                            'Nagaland',
                                            'Odisha',
                                            'Punjab',
                                            'Rajasthan',
                                            'Sikkim',
                                            'Tamil Nadu',
                                            'Telangana',
                                            'Tripura',
                                            'Uttar Pradesh',
                                            'Uttarakhand',
                                            'West Bengal',
                                        ];
                                    @endphp
                                    <div class="col-md-4">
                                        <label>State <span class="text-danger">*</span></label>
                                        <select name="state" id="state_select" class="form-control">
                                            <option value="">-- Select State --</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state }}"
                                                    {{ ($personalDetail->state ?? '') == $state ? 'selected' : '' }}>
                                                    {{ $state }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- ZONE DROPDOWN -->
                                    <div class="col-md-4">
                                        <label>Zone <span class="text-danger">*</span></label>
                                        <select name="zone" id="zone_select" class="form-control">
                                            <option value="">-- Select Zone --</option>
                                            @if (isset($personalDetail->zone))
                                                <option value="{{ $personalDetail->zone }}" selected>
                                                    {{ $personalDetail->zone }}</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Chapter <span class="text-danger">*</span></label>
                                        <select name="chapter" id="chapter_select" class="form-control">
                                            <option value="">-- Select Chapter --</option>
                                            @if (isset($personalDetail->chapter_name))
                                                <option value="{{ $personalDetail->chapter_name }}" selected>
                                                    {{ $personalDetail->chapter_name }}</option>
                                            @endif
                                        </select>
                                    </div>


                                    <div class="col-md-4">
                                        <label>Pin Code *</label>
                                        <input type="number" name="pin_code" class="form-control"
                                            placeholder="Enter 6-digit pin code" required
                                            value="{{ old('pin_code', $personalDetail->pin_code ?? '') }}">
                                    </div>


                                    <div class="col-md-4">
                                        <label>Resi. Landline</label>
                                        <input type="text" name="resi_landline" class="form-control"
                                            placeholder="Enter landline number"
                                            value="{{ old('resi_landline', $personalDetail->resi_landline ?? '') }}">
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label>Mobile No *</label>
                                            <input type="tel" name="mobile_no" class="form-control" maxlength="10"
                                                placeholder="Enter 10-digit mobile number" required pattern="[0-9]{10}"
                                                value="{{ old('mobile_no', $personalDetail->mobile_no ?? '') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label>WhatsApp No *</label>
                                            <input type="tel" name="whatsapp_no" class="form-control" maxlength="10"
                                                placeholder="Enter 10-digit WhatsApp number" required pattern="[0-9]{10}"
                                                value="{{ old('whatsapp_no', $personalDetail->whatsapp_no ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Email ID 1 *</label>
                                        <input type="email" name="email_id_1" class="form-control"
                                            placeholder="Enter primary email address" required
                                            value="{{ old('email_id_1', $personalDetail->email_id_1 ?? '') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Email ID 2</label>
                                        <input type="email" name="email_id_2" class="form-control"
                                            placeholder="Enter secondary email address"
                                            value="{{ old('email_id_2', $personalDetail->email_id_2 ?? '') }}">
                                    </div>

                                    <h6 class="mt-4 mb-3">Preferred Address for Communication</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label>Residence Address</label>
                                            <textarea name="preferred_residence_address" placeholder="Enter Residence Address" class="form-control ucwords"
                                                rows="2">{{ old('preferred_residence_address', $personalDetail->preferred_residence_address ?? '') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Pin Code *</label>
                                            <input type="number" name="resi_pin_code" class="form-control"
                                                placeholder="Enter 6-digit pin code" required
                                                value="{{ old('resi_pin_code', $personalDetail->resi_pin_code ?? '') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Office Address</label>
                                            <textarea name="preferred_office_address" placeholder="Enter Office Address" class="form-control ucwords"
                                                rows="2">{{ old('preferred_office_address', $personalDetail->preferred_office_address ?? '') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label>PAN No *</label>
                                            <input type="text" name="pan_no" class="form-control"
                                                placeholder="Enter PAN number" required
                                                value="{{ old('pan_no', $personalDetail->pan_no ?? '') }}">
                                        </div>
                                    </div>

                                    {{-- <h6 class="mt-4 mb-3">Chapter Details</h6> --}}


                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label>Date of Birth *</label>
                                            <input type="date" name="date_of_birth" class="form-control" required
                                                max="{{ now()->subYears(18)->format('Y-m-d') }}"
                                                value="{{ old('date_of_birth', $personalDetail->date_of_birth ?? '') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Anniversary Date</label>
                                            <input type="date" name="anniversary_date" class="form-control"
                                                value="{{ old('anniversary_date', $personalDetail->anniversary_date ?? '') }}">
                                        </div>
                                    </div>

                                    <!-- BIRTH PHOTO SECTION -->
                                    @php $existingBirthPhotos = $personalDetail->birth_photo ?? []; @endphp
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label>Birth Photo / Proof <small class="text-muted">(Hold Ctrl to select
                                                    multiple)</small></label>

                                            @if (!empty($existingBirthPhotos) && is_array($existingBirthPhotos))
                                                <div class="mb-3">
                                                    @foreach ($existingBirthPhotos as $index => $photo)
                                                        @if (!empty($photo))
                                                            <div class="file-preview-item">
                                                                <div class="file-info">
                                                                    <div class="file-icon">
                                                                        @if (strpos($photo, '.pdf') !== false)
                                                                            <i
                                                                                class="fas fa-file-pdf text-danger fa-lg"></i>
                                                                        @else
                                                                            <i class="fas fa-image text-primary fa-lg"></i>
                                                                        @endif
                                                                    </div>
                                                                    <span class="file-name">{{ basename($photo) }}</span>
                                                                </div>
                                                                <div class="file-actions">
                                                                    <!-- VIEW BUTTON -->
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-info text-white"
                                                                        onclick="viewDocument('{{ getImageUrl($photo) }}')">
                                                                        <i class="fas fa-eye me-1"></i> View
                                                                    </button>
                                                                    <!-- REMOVE CHECKBOX -->
                                                                    <div class="form-check mb-0">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="delete_birth_photo[]"
                                                                            value="{{ $photo }}"
                                                                            id="del_birth_{{ $index }}">
                                                                        <label class="form-check-label text-danger small"
                                                                            for="del_birth_{{ $index }}">Remove</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div id="birth_photo_container">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="flex-grow-1">
                                                        <input type="file" name="birth_photo[]" class="form-control"
                                                            accept="image/*,.pdf" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <!-- ANNIVERSARY PHOTO SECTION -->
                                    @php $existingAnniversaryPhotos = $personalDetail->anniversary_photo ?? []; @endphp
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label>Anniversary Photo <small class="text-muted">(Hold Ctrl to select
                                                    multiple)</small></label>
                                            @if (!empty($existingAnniversaryPhotos) && is_array($existingAnniversaryPhotos))
                                                <div class="mb-3">
                                                    @foreach ($existingAnniversaryPhotos as $index => $photo)
                                                        @if (!empty($photo))
                                                            <div class="file-preview-item">
                                                                <div class="file-info">
                                                                    <div class="file-icon">
                                                                        @if (strpos($photo, '.pdf') !== false)
                                                                            <i
                                                                                class="fas fa-file-pdf text-danger fa-lg"></i>
                                                                        @else
                                                                            <i class="fas fa-image text-primary fa-lg"></i>
                                                                        @endif
                                                                    </div>
                                                                    <span class="file-name">{{ basename($photo) }}</span>
                                                                </div>
                                                                <div class="file-actions">
                                                                    <!-- VIEW BUTTON -->
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-info text-white"
                                                                        onclick="viewDocument('{{ getImageUrl($photo) }}')">
                                                                        <i class="fas fa-eye me-1"></i> View
                                                                    </button>
                                                                    <!-- REMOVE CHECKBOX -->
                                                                    <div class="form-check mb-0">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="delete_anniversary_photo[]"
                                                                            value="{{ $photo }}"
                                                                            id="del_anniv_{{ $index }}">
                                                                        <label class="form-check-label text-danger small"
                                                                            for="del_anniv_{{ $index }}">Remove</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div id="anniversary_photo_container">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="flex-grow-1">
                                                        <input type="file" name="anniversary_photo[]"
                                                            class="form-control" accept="image/*,.pdf" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- BLOOD GROUP -->
                                    <div class="mb-3">
                                        <label>Blood Group *</label><br>
                                        <div class="d-flex flex-wrap gap-3">
                                            @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                                <label><input type="radio" name="blood_group"
                                                        value="{{ $bg }}" required
                                                        {{ old('blood_group', $personalDetail->blood_group ?? '') === $bg ? 'checked' : '' }}>
                                                    {{ $bg }}</label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- FAMILY DETAILS -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label>Mother Tongue *</label>
                                            <input type="text" name="mother_tongue" class="form-control ucwords"
                                                placeholder="Enter mother tongue" required
                                                value="{{ old('mother_tongue', $personalDetail->mother_tongue ?? '') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label>District of Native Place *</label>
                                            <input type="text" name="district_of_native_place"
                                                class="form-control ucwords" placeholder="Enter district of native place"
                                                required
                                                value="{{ old('district_of_native_place', $personalDetail->district_of_native_place ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label>Father's Name *</label>
                                        <input type="text" name="fathers_name" class="form-control ucwords"
                                            placeholder="Enter father's name" required
                                            value="{{ old('fathers_name', $personalDetail->fathers_name ?? '') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label>Hobby 1</label>
                                        <input type="text" name="hobby_1" class="form-control ucwords"
                                            value="{{ old('hobby_1', $personalDetail->hobby_1 ?? '') }}">
                                    </div>
                                    <div class="mb-4">
                                        <label>Hobby 2</label>
                                        <input type="text" name="hobby_2" class="form-control ucwords"
                                            value="{{ old('hobby_2', $personalDetail->hobby_2 ?? '') }}">
                                    </div>

                                    <!-- JITO MEMBER -->
                                    <div class="mb-3">
                                        <label>Are you a JITO JEAP Member? *</label><br>
                                        <div class="d-flex gap-4 mt-2">
                                            <label class="fw-normal">
                                                <input type="radio" name="jito_member" value="yes"
                                                    {{ old('jito_member', $personalDetail->jito_member ?? '') === 'yes' ? 'checked' : '' }}
                                                    onchange="toggleJitoUid(this.value)" required> Yes
                                            </label>
                                            <label class="fw-normal">
                                                <input type="radio" name="jito_member" value="no"
                                                    {{ old('jito_member', $personalDetail->jito_member ?? '') === 'no' ? 'checked' : '' }}
                                                    onchange="toggleJitoUid(this.value)" required> No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3" id="jito_uid_container"
                                        style="display: {{ old('jito_member', $personalDetail->jito_member ?? '') === 'yes' ? 'block' : 'none' }}">
                                        <label>JITO UID *</label>
                                        <input type="text" name="jito_uid" id="jito_uid" class="form-control"
                                            placeholder="Enter JITO UID"
                                            value="{{ old('jito_uid', $personalDetail->jito_uid ?? '') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label>Are you a JATF Member? *</label><br>
                                        <div class="d-flex gap-4 mt-2">
                                            <label class="fw-normal">
                                                <input type="radio" name="jatf_member" value="yes"
                                                    {{ old('jatf_member', $personalDetail->jatf_member ?? '') === 'yes' ? 'checked' : '' }}
                                                    required> Yes
                                            </label>
                                            <label class="fw-normal">
                                                <input type="radio" name="jatf_member" value="no"
                                                    {{ old('jatf_member', $personalDetail->jatf_member ?? '') === 'no' ? 'checked' : '' }}
                                                    required> No
                                            </label>
                                        </div>
                                    </div>


                                    <div class="mb-3">
                                        <label>Are you a Shraman Arogyam Member? *</label><br>
                                        <div class="d-flex gap-4 mt-2">
                                            <label class="fw-normal">
                                                <input type="radio" name="arogyam_member" value="yes"
                                                    {{ old('arogyam_member', $personalDetail->arogyam_member ?? '') === 'yes' ? 'checked' : '' }}
                                                    required> Yes
                                            </label>
                                            <label class="fw-normal">
                                                <input type="radio" name="arogyam_member" value="no"
                                                    {{ old('arogyam_member', $personalDetail->arogyam_member ?? '') === 'no' ? 'checked' : '' }}
                                                    required> No
                                            </label>
                                        </div>
                                    </div>



                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4 mb-4">
                                <button type="button" class="btn " style="background:#988DFF1F;color:gray;"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        stroke="gray" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M15 18l-6-6 6-6" />
                                    </svg> Previous</button>
                                <button type="submit" class="btn" style="background:#393185;color:white;">Next Step
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        stroke="white" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M9 6l6 6-6 6" />
                                    </svg></button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- DOCUMENT VIEW MODAL -->
    <div class="modal fade" id="documentViewModal" tabindex="-1" aria-labelledby="documentViewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: #393185; color: white;">
                    <h5 class="modal-title" id="documentViewModalLabel">Document Preview</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="min-height: 500px; background: #f8f9fa;">
                    <div id="modalContent">
                        <!-- Content injected via JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggleJitoUid(value) {
            var jitoUidContainer = document.getElementById('jito_uid_container');
            var jitoUidInput = document.getElementById('jito_uid');
            if (value === 'yes') {
                jitoUidContainer.style.display = 'block';
                jitoUidInput.setAttribute('required', 'required');
            } else {
                jitoUidContainer.style.display = 'none';
                jitoUidInput.removeAttribute('required');
                jitoUidInput.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var jitoMemberRadios = document.getElementsByName('jito_member');
            for (var i = 0; i < jitoMemberRadios.length; i++) {
                if (jitoMemberRadios[i].checked) {
                    toggleJitoUid(jitoMemberRadios[i].value);
                    break;
                }
            }
        });

        // --- View Document Function ---
        function viewDocument(url) {
            var modalContent = document.getElementById('modalContent');
            var lowerUrl = url.toLowerCase();

            if (lowerUrl.indexOf('.pdf') !== -1) {
                // PDF
                modalContent.innerHTML = '<iframe src="' + url +
                    '" style="width: 100%; height: 70vh; border: none;"></iframe>';
            } else {
                // Image
                modalContent.innerHTML = '<img src="' + url +
                    '" style="max-width: 100%; max-height: 70vh; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">';
            }

            var myModal = new bootstrap.Modal(document.getElementById('documentViewModal'));
            myModal.show();
        }

        // Title Case
        document.addEventListener('blur', function(e) {
            if (e.target.classList.contains('ucwords')) {
                e.target.value = e.target.value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
            }
        }, true);

        $(document).ready(function() {
            // 1. Prepare the data (Passed from Controller)
            // This creates a JSON object available in JS
            var allZones = {!! json_encode($zonesByState) !!};
            var allChapters = {!! json_encode($chaptersByZone) !!};

            // Function to populate zones
            function populateZones(stateName, savedZone = '') {
                var zoneDropdown = $('#zone_select');
                zoneDropdown.empty(); // Clear existing options

                // Add default empty option
                zoneDropdown.append('<option value="">-- Select Zone --</option>');

                // Check if state exists in our data
                if (stateName && allZones[stateName]) {
                    // Loop through the zones for this specific state
                    $.each(allZones[stateName], function(index, zone) {
                        // We use zone.zone_name
                        var isSelected = (zone.zone_name == savedZone) ? 'selected' : '';
                        zoneDropdown.append('<option value="' + zone.zone_name + '" data-zone-id="' + zone
                            .id + '" ' + isSelected + '>' + zone.zone_name + '</option>');
                    });
                }
            }

            // Function to populate chapters based on zone_id
            function populateChapters(zoneId, savedChapter = '') {
                var chapterDropdown = $('#chapter_select');
                chapterDropdown.empty(); // Clear existing options

                // Add default empty option
                chapterDropdown.append('<option value="">-- Select Chapter --</option>');

                // Check if zone_id exists in our data
                if (zoneId && allChapters[zoneId]) {
                    // Loop through the chapters for this specific zone
                    $.each(allChapters[zoneId], function(index, chapter) {
                        var isSelected = (chapter.chapter_name == savedChapter) ? 'selected' : '';
                        chapterDropdown.append('<option value="' + chapter.chapter_name + '" ' +
                            isSelected + '>' + chapter.chapter_name + '</option>');
                    });
                }
            }

            // 2. EVENT: When State Changes
            $('#state_select').on('change', function() {
                var selectedState = $(this).val();
                populateZones(selectedState); // Populate zones, no saved zone needed for new selection

                // Also clear chapter dropdown when state changes
                $('#chapter_select').empty().append('<option value="">-- Select Chapter --</option>');
            });

            // 3. EVENT: When Zone Changes
            $('#zone_select').on('change', function() {
                var selectedZoneOption = $(this).find('option:selected');
                var zoneId = selectedZoneOption.attr('data-zone-id');
                populateChapters(zoneId); // Populate chapters based on selected zone
            });

            // 4. ON LOAD: If user is editing (State already selected)
            var initialState = $('#state_select').val();
            var savedZone = "{{ $personalDetail->zone ?? '' }}";
            var savedChapter = "{{ $personalDetail->chapter_name ?? '' }}";
            var savedZoneId = "{{ $zone_id ?? '' }}";

            if (initialState) {
                // Populate zones and mark the saved one as selected
                populateZones(initialState, savedZone);
            }

            // If we have a saved zone ID, populate chapters
            if (savedZoneId) {
                populateChapters(savedZoneId, savedChapter);
            }
        });
    </script>

@endsection
