@extends('admin.layouts.master')

@section('title', 'Edit Donor Application - JitoJeap Admin')

@section('content')
    <div class="container-fluid donor-edit-wrapper px-4">
        <form action="{{ route('admin.donors.updatedonor', $donor->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="current_step" id="current_step_input"
                value="{{ request()->get('step', old('current_step', 1)) }}">

            <style>
                /* Scoped Layout Structure */
                .donor-edit-layout {
                    display: flex;
                    gap: 0;
                    background: #fff;
                    border-radius: 8px;
                    overflow: hidden;
                    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.07);
                    min-height: 85vh;
                    margin-top: 1.5rem;
                    border: 1px solid #e0e0e0;
                }

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
                    from {
                        opacity: 0;
                        transform: translateY(5px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .form-control,
                .form-select {
                    border-radius: 4px;
                    border: 1px solid #ccc;
                    font-size: 0.9rem;
                }

                .form-control:focus,
                .form-select:focus {
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

                .btn-nav-back:hover {
                    background-color: #5a6268;
                }

                .btn-nav-next {
                    background-color: #393185;
                    color: white;
                }

                .btn-nav-next:hover {
                    background-color: #2d2669;
                }

                .current-file {
                    font-size: 0.8rem;
                    color: #666;
                    margin-top: 0.25rem;
                }

                .current-file a {
                    color: #393185;
                    font-weight: 600;
                }

                .ucwords {
                    text-transform: capitalize;
                }

                /* File preview styles for admin */
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

                .file-preview-item .file-name {
                    font-size: 13px;
                    font-weight: 500;
                    color: #333;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    max-width: 200px;
                }
            </style>

            <div class="dashboard-header">
                <div>
                    <h1 class="dashboard-title"><i class="fas fa-user-edit me-2"></i> Edit Donor Application</h1>
                    <p class="dashboard-subtitle">{{ $donor->name }}
                        @if ($donor->donor_type === 'general')
                            <span class="badge bg-secondary ms-2">General Donor</span>
                        @else
                            <span class="badge bg-primary ms-2">Member Donor</span>
                        @endif
                    </p>
                </div>
                @if ($donor->donor_type === 'general')
                    <a href="{{ route('admin.general-donors.dashboard') }}" class="btn btn-outline-secondary">Back to
                        General
                        Dashboard</a>
                @else
                    <a href="{{ route('admin.donors.dashboard', ['donor_type' => 'member']) }}"
                        class="btn btn-outline-secondary">Back to Member Dashboard</a>
                @endif
            </div>

            <div class="donor-edit-layout">
                <div class="donor-edit-sidebar">
                    @if ($donor->donor_type === 'general')
                        {{-- General Donors: Only Personal Details and Payment --}}
                        <div class="donor-step-item" data-step="1">
                            <div class="donor-step-number">1</div>
                            <div>Personal Details</div>
                        </div>
                        <div class="donor-step-item" data-step="2">
                            <div class="donor-step-number">2</div>
                            <div>Payment</div>
                        </div>
                    @else
                        {{-- Member Donors: All 7 Steps --}}
                        @for ($i = 1; $i <= 7; $i++)
                            <div class="donor-step-item" data-step="{{ $i }}">
                                <div class="donor-step-number">{{ $i }}</div>
                                <div>
                                    @switch($i)
                                        @case(1)
                                            Personal Details
                                        @break

                                        @case(2)
                                            Family Details
                                        @break

                                        @case(3)
                                            Nominee Details
                                        @break

                                        @case(4)
                                            Professional
                                        @break

                                        @case(5)
                                            Documents
                                        @break

                                        @case(6)
                                            Membership
                                        @break

                                        @case(7)
                                            Payment
                                        @break
                                    @endswitch
                                </div>
                            </div>
                        @endfor
                    @endif
                </div>

                <div class="donor-edit-content">

                    <!-- Helper Function for URL Resolution -->
                    @php
                        if (!function_exists('resolveFileUrl')) {
                            function resolveFileUrl($path)
                            {
                                if (empty($path)) {
                                    return '#';
                                }

                                // 1. Full URL (http://...)
                                if (str_starts_with($path, 'http')) {
                                    return $path;
                                }

                                // 2. New Public Paths (uploads/documents or donor_documents)
                                // These are stored as 'uploads/documents/filename.jpg' in DB
                                if (str_starts_with($path, 'uploads/') || str_starts_with($path, 'donor_documents/')) {
                                    return asset($path);
                                }

                                // 3. Old Storage Path fallback
                                return asset('storage/' . $path);
                            }
                        }
                    @endphp

                    <!-- Step 1: Personal Details -->
                    <div class="step-content-section" id="step-1">
                        <h4 class="donorH4">Personal Details</h4>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="info-label">Title</div>

                                <div>
                                    <input type="radio" name="personal_detail[title]" value="Mr"
                                        {{ ($donor->personalDetail->title ?? '') == 'Mr' ? 'checked' : '' }}> Mr

                                    <input type="radio" name="personal_detail[title]" value="Mrs"
                                        {{ ($donor->personalDetail->title ?? '') == 'Mrs' ? 'checked' : '' }}> Mrs

                                    <input type="radio" name="personal_detail[title]" value="Ms"
                                        {{ ($donor->personalDetail->title ?? '') == 'Ms' ? 'checked' : '' }}> Ms

                                    <input type="radio" name="personal_detail[title]" value="Master"
                                        {{ ($donor->personalDetail->title ?? '') == 'Master' ? 'checked' : '' }}> Master
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">First Name</div>
                                <input type="text" name="personal_detail[first_name]" class="form-control ucwords"
                                    value="{{ $donor->personalDetail->first_name ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Middle Name</div>
                                <input type="text" name="personal_detail[middle_name]" class="form-control ucwords"
                                    value="{{ $donor->personalDetail->middle_name ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Surname</div>
                                <input type="text" name="personal_detail[surname]" class="form-control ucwords"
                                    value="{{ $donor->personalDetail->surname ?? '' }}">
                            </div>
                            <div class="col-md-8">
                                <div class="info-label">Complete Address</div>
                                <textarea name="personal_detail[complete_address]" class="form-control" rows="2">{{ $donor->personalDetail->complete_address ?? '' }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">City</div>
                                <input type="text" name="personal_detail[city]" class="form-control ucwords"
                                    value="{{ $donor->personalDetail->city ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">State</div>

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

                                <select name="personal_detail[state]" id="state_select" class="form-control">
                                    <option value="">Select State</option>

                                    @foreach ($states as $state)
                                        <option value="{{ $state }}"
                                            {{ ($donor->personalDetail->state ?? '') == $state ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Zone</div>
                                <select name="personal_detail[zone]" id="zone_select" class="form-control">
                                    <option value="">-- Select Zone --</option>
                                    @if (isset($donor->personalDetail->zone))
                                        <option value="{{ $donor->personalDetail->zone }}" selected>
                                            {{ $donor->personalDetail->zone }}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Chapter Name</div>
                                <select name="personal_detail[chapter_name]" id="chapter_select" class="form-control">
                                    <option value="">-- Select Chapter --</option>
                                    @if (isset($donor->personalDetail->chapter_name))
                                        <option value="{{ $donor->personalDetail->chapter_name }}" selected>
                                            {{ $donor->personalDetail->chapter_name }}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Pin Code</div>
                                <input type="text" name="personal_detail[pin_code]" class="form-control"
                                    value="{{ $donor->personalDetail->pin_code ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Resi. Landline</div>
                                <input type="text" name="personal_detail[resi_landline]" class="form-control"
                                    value="{{ $donor->personalDetail->resi_landline ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Mobile</div>
                                <input type="text" name="personal_detail[mobile_no]" class="form-control"
                                    value="{{ $donor->personalDetail->mobile_no ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">WhatsApp</div>
                                <input type="text" name="personal_detail[whatsapp_no]" class="form-control"
                                    value="{{ $donor->personalDetail->whatsapp_no ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Email 1</div>
                                <input type="email" name="personal_detail[email_id_1]" class="form-control"
                                    value="{{ $donor->personalDetail->email_id_1 ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Email 2</div>
                                <input type="email" name="personal_detail[email_id_2]" class="form-control"
                                    value="{{ $donor->personalDetail->email_id_2 ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <div class="info-label">Residence Address</div>
                                <input type="text" name="personal_detail[preferred_residence_address]"
                                    class="form-control"
                                    value="{{ $donor->personalDetail->preferred_residence_address ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <div class="info-label">Pin Code</div>
                                <input type="text" name="personal_detail[resi_pin_code]" class="form-control"
                                    value="{{ $donor->personalDetail->resi_pin_code ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <div class="info-label">Office Address</div>
                                <input type="text" name="personal_detail[preferred_office_address]"
                                    class="form-control"
                                    value="{{ $donor->personalDetail->preferred_office_address ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">PAN No</div>
                                <input type="text" name="personal_detail[pan_no]" class="form-control"
                                    value="{{ $donor->personalDetail->pan_no ?? '' }}">
                            </div>

                            <div class="col-md-4">
                                <div class="info-label">Date of Birth</div>
                                <input type="date" name="personal_detail[date_of_birth]" class="form-control"
                                    value="{{ $donor->personalDetail->date_of_birth ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Anniversary Date</div>
                                <input type="date" name="personal_detail[anniversary_date]" class="form-control"
                                    value="{{ $donor->personalDetail->anniversary_date ?? '' }}">
                            </div>

                            <!-- === BIRTH PHOTO === -->
                            <div class="col-md-6">
                                <div class="info-label">Birth Photo / Proof (Multiple)</div>
                                @php
                                    $rawData =
                                        $donor->personalDetail->birth_photo ?? ($donor->document->birth_photo ?? null);
                                    $birthPhotos = [];
                                    if (is_array($rawData)) {
                                        $birthPhotos = $rawData;
                                    } elseif (is_string($rawData) && !empty($rawData)) {
                                        $decoded = json_decode($rawData, true);
                                        $birthPhotos = is_array($decoded) ? $decoded : [$rawData];
                                    }
                                @endphp
                                @if (!empty($birthPhotos))
                                    <div class="mb-2">
                                        @foreach ($birthPhotos as $index => $file)
                                            @if (!empty($file))
                                                <div class="file-preview-item">
                                                    <div class="file-info">
                                                        <i
                                                            class="fas {{ strpos($file, '.pdf') !== false ? 'fa-file-pdf text-danger' : 'fa-image text-primary' }}"></i>
                                                        <span class="file-name">{{ basename($file) }}</span>
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ resolveFileUrl($file) }}" target="_blank"
                                                            class="btn btn-sm btn-info text-white">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="delete_birth_photo[]" value="{{ $file }}"
                                                                id="del_birth_{{ $index }}">
                                                            <label class="form-check-label text-danger small"
                                                                for="del_birth_{{ $index }}">Del</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted small mb-1">No birth photo uploaded yet</p>
                                @endif
                                <input type="file" name="birth_photo[]" class="form-control" multiple
                                    accept="image/*,.pdf">
                            </div>

                            <!-- === ANNIVERSARY PHOTO === -->
                            <div class="col-md-6">
                                <div class="info-label">Anniversary Photo (Multiple)</div>
                                @php
                                    $rawAnnData =
                                        $donor->personalDetail->anniversary_photo ??
                                        ($donor->document->anniversary_photo ?? null);
                                    $anniversaryPhotos = [];
                                    if (is_array($rawAnnData)) {
                                        $anniversaryPhotos = $rawAnnData;
                                    } elseif (is_string($rawAnnData) && !empty($rawAnnData)) {
                                        $decodedAnn = json_decode($rawAnnData, true);
                                        $anniversaryPhotos = is_array($decodedAnn) ? $decodedAnn : [$rawAnnData];
                                    }
                                @endphp
                                @if (!empty($anniversaryPhotos))
                                    <div class="mb-2">
                                        @foreach ($anniversaryPhotos as $index => $file)
                                            @if (!empty($file))
                                                <div class="file-preview-item">
                                                    <div class="file-info">
                                                        <i
                                                            class="fas {{ strpos($file, '.pdf') !== false ? 'fa-file-pdf text-danger' : 'fa-image text-primary' }}"></i>
                                                        <span class="file-name">{{ basename($file) }}</span>
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ resolveFileUrl($file) }}" target="_blank"
                                                            class="btn btn-sm btn-info text-white">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="delete_anniversary_photo[]"
                                                                value="{{ $file }}"
                                                                id="del_ann_{{ $index }}">
                                                            <label class="form-check-label text-danger small"
                                                                for="del_ann_{{ $index }}">Del</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted small mb-1">No anniversary photo uploaded yet</p>
                                @endif
                                <input type="file" name="anniversary_photo[]" class="form-control" multiple
                                    accept="image/*,.pdf">
                            </div>

                            <div class="col-md-4">
                                <div class="info-label">Blood Group</div>
                                <div class="mt-2">
                                    @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                        <label class="me-3">
                                            <input type="radio" name="personal_detail[blood_group]"
                                                value="{{ $bg }}"
                                                {{ ($donor->personalDetail->blood_group ?? '') == $bg ? 'checked' : '' }}>
                                            {{ $bg }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Mother Tongue</div>
                                <input type="text" name="personal_detail[mother_tongue]" class="form-control ucwords"
                                    value="{{ $donor->personalDetail->mother_tongue ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">District Of Native Place</div>
                                <input type="text" name="personal_detail[district_of_native_place]"
                                    class="form-control ucwords"
                                    value="{{ $donor->personalDetail->district_of_native_place ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Father Name</div>
                                <input type="text" name="personal_detail[fathers_name]" class="form-control ucwords"
                                    value="{{ $donor->personalDetail->fathers_name ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Jito Member</div>
                                <div class="mt-2">
                                    <label class="me-3">
                                        <input type="radio" name="personal_detail[jito_member]" value="yes"
                                            {{ ($donor->personalDetail->jito_member ?? '') == 'yes' ? 'checked' : '' }}
                                            onchange="toggleJitoUid(this.value)">
                                        Yes
                                    </label>
                                    <label>
                                        <input type="radio" name="personal_detail[jito_member]" value="no"
                                            {{ ($donor->personalDetail->jito_member ?? '') == 'no' ? 'checked' : '' }}
                                            onchange="toggleJitoUid(this.value)">
                                        No
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4" id="jito_uid_section"
                                style="display: {{ ($donor->personalDetail->jito_member ?? '') == 'yes' ? 'block' : 'none' }}">
                                <div class="info-label">JITO UID</div>
                                <input type="text" name="personal_detail[jito_uid]" class="form-control"
                                    value="{{ $donor->personalDetail->jito_uid ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">JATF Member</div>
                                <div class="mt-2">
                                    <label class="me-3">
                                        <input type="radio" name="personal_detail[jatf_member]" value="yes"
                                            {{ ($donor->personalDetail->jatf_member ?? '') == 'yes' ? 'checked' : '' }}>
                                        Yes
                                    </label>
                                    <label>
                                        <input type="radio" name="personal_detail[jatf_member]" value="no"
                                            {{ ($donor->personalDetail->jatf_member ?? '') == 'no' ? 'checked' : '' }}>
                                        No
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Shraman Arogyam Member</div>
                                <div class="mt-2">
                                    <label class="me-3">
                                        <input type="radio" name="personal_detail[arogyam_member]" value="yes"
                                            {{ ($donor->personalDetail->arogyam_member ?? '') == 'yes' ? 'checked' : '' }}>
                                        Yes
                                    </label>
                                    <label>
                                        <input type="radio" name="personal_detail[arogyam_member]" value="no"
                                            {{ ($donor->personalDetail->arogyam_member ?? '') == 'no' ? 'checked' : '' }}>
                                        No
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Hobby 1</div>
                                <input type="text" name="personal_detail[hobby_1]" class="form-control"
                                    value="{{ $donor->personalDetail->hobby_1 ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Hobby 2</div>
                                <input type="text" name="personal_detail[hobby_2]" class="form-control"
                                    value="{{ $donor->personalDetail->hobby_2 ?? '' }}">
                            </div>
                        </div>
                        <div class="form-navigation">
                            <div></div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn-submit-update"><i class="fas fa-save me-2"></i>
                                    Update</button>
                                <button type="button" class="btn-nav btn-nav-next" onclick="nextStep()">Next <i
                                        class="fas fa-arrow-right ms-2"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Family Details (Member Donors Only) -->
                    @if ($donor->donor_type !== 'general')
                        <div class="step-content-section" id="step-2">
                            <h4 class="donorH4">Family Details</h4>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="info-label">Title</div>
                                    <select name="family_detail[spouse_title]" class="form-select">
                                        <option value="Mr"
                                            {{ ($donor->familyDetail->spouse_title ?? '') == 'Mr' ? 'selected' : '' }}>Mr
                                        </option>
                                        <option value="Mrs"
                                            {{ ($donor->familyDetail->spouse_title ?? '') == 'Mrs' ? 'selected' : '' }}>Mrs
                                        </option>
                                        <option value="Ms"
                                            {{ ($donor->familyDetail->spouse_title ?? '') == 'Ms' ? 'selected' : '' }}>Ms
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-label">Spouse Name</div>
                                    <input type="text" name="family_detail[spouse_name]" class="form-control ucwords"
                                        value="{{ $donor->familyDetail->spouse_name ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <div class="info-label">Spouse DOB</div>
                                    <input type="date" name="family_detail[spouse_birth_date]" class="form-control"
                                        value="{{ $donor->familyDetail->spouse_birth_date ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <div class="info-label">Jito Member</div>
                                    <input type="text" name="family_detail[jito_member]" class="form-control"
                                        value="{{ $donor->familyDetail->jito_member ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <div class="info-label">Spouse Blood Group</div>
                                    <input type="text" name="family_detail[spouse_blood_group]" class="form-control"
                                        value="{{ $donor->familyDetail->spouse_blood_group ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <div class="info-label">Number of Kids</div>
                                    <input type="number" name="family_detail[number_of_kids]" id="num_kids_input"
                                        class="form-control" value="{{ $donor->familyDetail->number_of_kids ?? 0 }}"
                                        min="0">
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
                                                <th>Marital Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="children_tbody">
                                            @if (isset($children) && count($children) > 0)
                                                @foreach ($children as $i => $child)
                                                    <tr>
                                                        <td><input type="text"
                                                                name="children[{{ $i }}][name]"
                                                                class="form-control form-control-sm ucwords"
                                                                value="{{ $child['name'] ?? '' }}"></td>
                                                        <td><select name="children[{{ $i }}][gender]"
                                                                class="form-select form-select-sm">
                                                                <option value="Male"
                                                                    {{ ($child['gender'] ?? '') == 'Male' ? 'selected' : '' }}>
                                                                    Male</option>
                                                                <option value="Female"
                                                                    {{ ($child['gender'] ?? '') == 'Female' ? 'selected' : '' }}>
                                                                    Female</option>
                                                            </select></td>
                                                        <td><input type="date"
                                                                name="children[{{ $i }}][dob]"
                                                                class="form-control form-control-sm"
                                                                value="{{ $child['dob'] ?? '' }}"></td>
                                                        <td><input type="text"
                                                                name="children[{{ $i }}][blood_group]"
                                                                class="form-control form-control-sm"
                                                                value="{{ $child['blood_group'] ?? '' }}"></td>
                                                        <td><input type="text"
                                                                name="children[{{ $i }}][marital_status]"
                                                                class="form-control form-control-sm"
                                                                value="{{ $child['marital_status'] ?? '' }}"></td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td><input type="text" name="children[0][name]"
                                                            class="form-control form-control-sm ucwords"></td>
                                                    <td><select name="children[0][gender]"
                                                            class="form-select form-select-sm">
                                                            <option>Male</option>
                                                            <option>Female</option>
                                                        </select></td>
                                                    <td><input type="date" name="children[0][dob]"
                                                            class="form-control form-control-sm"></td>
                                                    <td><input type="text" name="children[0][blood_group]"
                                                            class="form-control form-control-sm"></td>
                                                    <td><input type="text" name="children[0][marital_status]"
                                                            class="form-control form-control-sm"></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-navigation">
                                <button type="button" class="btn-nav btn-nav-back" onclick="prevStep()"><i
                                        class="fas fa-arrow-left me-2"></i> Back</button>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn-submit-update"><i class="fas fa-save me-2"></i>
                                        Update</button>
                                    <button type="button" class="btn-nav btn-nav-next" onclick="nextStep()">Next <i
                                            class="fas fa-arrow-right ms-2"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Nominee Details -->
                        <div class="step-content-section" id="step-3">
                            <h4 class="donorH4">Nominee Details</h4>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="info-label">Nominee Name</div>
                                    <input type="text" name="nominee_detail[nominee_name]"
                                        class="form-control ucwords"
                                        value="{{ $donor->nomineeDetail->nominee_name ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <div class="info-label">Relationship</div>
                                    <input type="text" name="nominee_detail[nominee_relationship]"
                                        class="form-control ucwords"
                                        value="{{ $donor->nomineeDetail->nominee_relationship ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <div class="info-label">Mobile</div>
                                    <input type="text" name="nominee_detail[nominee_mobile]" class="form-control"
                                        value="{{ $donor->nomineeDetail->nominee_mobile ?? '' }}">
                                </div>
                                <div class="col-md-12">
                                    <div class="info-label">Address</div>
                                    <textarea name="nominee_detail[nominee_address]" class="form-control">{{ $donor->nomineeDetail->nominee_address ?? '' }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-label">City</div>
                                    <input type="text" name="nominee_detail[nominee_city]"
                                        class="form-control ucwords"
                                        value="{{ $donor->nomineeDetail->nominee_city ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <div class="info-label">Pin Code</div>
                                    <input type="text" name="nominee_detail[nominee_pincode]" class="form-control"
                                        value="{{ $donor->nomineeDetail->nominee_pincode ?? '' }}">
                                </div>
                            </div>
                            <div class="form-navigation">
                                <button type="button" class="btn-nav btn-nav-back" onclick="prevStep()"><i
                                        class="fas fa-arrow-left me-2"></i> Back</button>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn-submit-update"><i class="fas fa-save me-2"></i>
                                        Update</button>
                                    <button type="button" class="btn-nav btn-nav-next" onclick="nextStep()">Next <i
                                            class="fas fa-arrow-right ms-2"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Professional Details -->
                        <div class="step-content-section" id="step-4">
                            <h4 class="donorH4">Professional Details</h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="info-label">Company Name</div>
                                    <input type="text" name="professional_detail[company_name]"
                                        class="form-control ucwords"
                                        value="{{ $donor->professionalDetail->company_name ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Company Activity</div>
                                    <input type="text" name="professional_detail[company_activity_details]"
                                        class="form-control"
                                        value="{{ $donor->professionalDetail->company_activity_details ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Company Website</div>
                                    <input type="text" name="professional_detail[company_website]"
                                        class="form-control" placeholder="https://www.example.com"
                                        value="{{ $donor->professionalDetail->company_website ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Designation</div>
                                    <input type="text" name="professional_detail[designation]"
                                        class="form-control ucwords"
                                        value="{{ $donor->professionalDetail->designation ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Office Mobile</div>
                                    <input type="text" name="professional_detail[office_mobile]" class="form-control"
                                        value="{{ $donor->professionalDetail->office_mobile ?? '' }}">
                                </div>
                                <div class="col-md-12">
                                    <div class="info-label">Office Address</div>
                                    <textarea name="professional_detail[office_address]" class="form-control">{{ $donor->professionalDetail->office_address ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Office State</div>
                                    <input type="text" name="professional_detail[office_state]"
                                        class="form-control ucwords"
                                        value="{{ $donor->professionalDetail->office_state ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Office City</div>
                                    <input type="text" name="professional_detail[office_city]"
                                        class="form-control ucwords"
                                        value="{{ $donor->professionalDetail->office_city ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Office Pincode</div>
                                    <input type="text" name="professional_detail[office_pincode]" class="form-control"
                                        value="{{ $donor->professionalDetail->office_pincode ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Office Telephone</div>
                                    <input type="text" name="professional_detail[office_telephone]"
                                        class="form-control"
                                        value="{{ $donor->professionalDetail->office_telephone ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Pan Number</div>
                                    <input type="text" name="professional_detail[pan_no]" class="form-control"
                                        value="{{ $donor->professionalDetail->pan_no ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Coordinator Name</div>
                                    <input type="text" name="professional_detail[coordinator_name]"
                                        class="form-control ucwords"
                                        value="{{ $donor->professionalDetail->coordinator_name ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Coordinator Mobile</div>
                                    <input type="text" name="professional_detail[coordinator_mobile]"
                                        class="form-control"
                                        value="{{ $donor->professionalDetail->coordinator_mobile ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Coordinator Email 1</div>
                                    <input type="text" name="professional_detail[coordinator_email_1]"
                                        class="form-control"
                                        value="{{ $donor->professionalDetail->coordinator_email_1 ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Coordinator Email 2</div>
                                    <input type="text" name="professional_detail[coordinator_email_2]"
                                        class="form-control"
                                        value="{{ $donor->professionalDetail->coordinator_email_2 ?? '' }}">
                                </div>
                            </div>

                            <div class="form-navigation">
                                <button type="button" class="btn-nav btn-nav-back" onclick="prevStep()"><i
                                        class="fas fa-arrow-left me-2"></i> Back</button>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn-submit-update"><i class="fas fa-save me-2"></i>
                                        Update</button>
                                    <button type="button" class="btn-nav btn-nav-next" onclick="nextStep()">Next <i
                                            class="fas fa-arrow-right ms-2"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 5: Documents -->
                        <div class="step-content-section" id="step-5">
                            <h4 class="donorH4">Documents</h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="info-label">PAN Card File</div>
                                    <input type="file" name="pan_member_file" class="form-control">
                                    @if (!empty($donor->document?->pan_member_file))
                                        <div class="current-file">Current: <a
                                                href="{{ resolveFileUrl($donor->document->pan_member_file) }}"
                                                target="_blank">View File</a></div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Photo</div>
                                    <input type="file" name="photo_file" class="form-control">
                                    @if (!empty($donor->document?->photo_file))
                                        <div class="current-file">Current: <a
                                                href="{{ resolveFileUrl($donor->document->photo_file) }}"
                                                target="_blank">View File</a></div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Address Proof</div>
                                    <input type="file" name="address_proof_file" class="form-control">
                                    @if (!empty($donor->document?->address_proof_file))
                                        <div class="current-file">Current: <a
                                                href="{{ resolveFileUrl($donor->document->address_proof_file) }}"
                                                target="_blank">View File</a></div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Pan Donor File</div>
                                    <input type="file" name="pan_donor_file" class="form-control">
                                    @if (!empty($donor->document?->pan_donor_file))
                                        <div class="current-file">Current: <a
                                                href="{{ resolveFileUrl($donor->document->pan_donor_file) }}"
                                                target="_blank">View File</a></div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Authorization Letter File</div>
                                    <input type="file" name="authorization_letter_file" class="form-control">
                                    @if (!empty($donor->document?->authorization_letter_file))
                                        <div class="current-file">Current: <a
                                                href="{{ resolveFileUrl($donor->document->authorization_letter_file) }}"
                                                target="_blank">View File</a></div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-navigation">
                                <button type="button" class="btn-nav btn-nav-back" onclick="prevStep()"><i
                                        class="fas fa-arrow-left me-2"></i> Back</button>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn-submit-update"><i class="fas fa-save me-2"></i>
                                        Update</button>
                                    <button type="button" class="btn-nav btn-nav-next" onclick="nextStep()">Next <i
                                            class="fas fa-arrow-right ms-2"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 6: Membership Details -->
                        <div class="step-content-section" id="step-6">
                            <h4 class="donorH4">Membership Details</h4>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="info-label">Selected Options</div>
                                    <textarea name="membership_options" class="form-control" rows="4">{{ implode("\n", $paymentOptions ?? []) }}</textarea>
                                    <small class="text-muted">Enter each membership option on a new line.</small>
                                </div>
                            </div>

                            <div class="form-navigation">
                                <button type="button" class="btn-nav btn-nav-back" onclick="prevStep()"><i
                                        class="fas fa-arrow-left me-2"></i> Back</button>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn-submit-update"><i class="fas fa-save me-2"></i>
                                        Update</button>
                                    <button type="button" class="btn-nav btn-nav-next" onclick="nextStep()">Next <i
                                            class="fas fa-arrow-right ms-2"></i></button>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Step 7: Payment Details -->
                    <div class="step-content-section" id="step-7">
                        <h4 class="donorH4">Payment Details</h4>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="info-label">Cheque Favoring</div>
                                <input type="text" class="form-control" name="cheque_favoring"
                                    value="{{ old('cheque_favoring', 'JITO EDUCATION ASSISTANCE FOUNDATION') }}"
                                    readonly>
                            </div>
                            <div class="col-md-6">
                                <div class="info-label">RTGS/NEFT</div>
                                <input type="text" class="form-control" name="rtgs_neft"
                                    placeholder="Enter RTGS/NEFT details"
                                    value="{{ old('rtgs_neft', $paymentDetail->rtgs_neft ?? '') }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <div class="info-label">Bank Name</div>
                                <input type="text" class="form-control" name="bank_name"
                                    value="{{ old('bank_name', 'ICICI BANK') }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <div class="info-label">Branch Name</div>
                                <input type="text" class="form-control" name="branch_name"
                                    value="{{ old('branch_name', 'WATER FIELD ROAD, BANDRA (WEST)') }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <div class="info-label">Account Number</div>
                                <input type="text" class="form-control" name="account_number"
                                    value="{{ old('account_number', '003801040441') }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <div class="info-label">IFSC Code</div>
                                <input type="text" class="form-control" name="ifsc_code"
                                    value="{{ old('ifsc_code', 'ICIC0000388') }}" readonly>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>UTR/Cheque No</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Bank Branch</th>
                                        <th>Issued By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($paymentEntries) > 0)
                                        @foreach ($paymentEntries as $i => $entry)
                                            <tr>
                                                <td><input type="text" name="payments[{{ $i }}][utr_no]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $entry['utr_no'] ?? '' }}"></td>
                                                <td><input type="date"
                                                        name="payments[{{ $i }}][cheque_date]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $entry['cheque_date'] ?? '' }}"></td>
                                                <td><input type="number" name="payments[{{ $i }}][amount]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $entry['amount'] ?? '' }}"></td>
                                                <td><input type="text"
                                                        name="payments[{{ $i }}][bank_branch]"
                                                        class="form-control form-control-sm ucwords"
                                                        value="{{ $entry['bank_branch'] ?? '' }}"></td>
                                                <td><input type="text"
                                                        name="payments[{{ $i }}][issued_by]"
                                                        class="form-control form-control-sm ucwords"
                                                        value="{{ $entry['issued_by'] ?? '' }}"></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td><input type="text" name="payments[0][utr_no]"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="date" name="payments[0][cheque_date]"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="payments[0][amount]"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="text" name="payments[0][bank_branch]"
                                                    class="form-control form-control-sm ucwords"></td>
                                            <td><input type="text" name="payments[0][issued_by]"
                                                    class="form-control form-control-sm ucwords"></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="form-navigation">
                            <button type="button" class="btn-nav btn-nav-back" onclick="prevStep()"><i
                                    class="fas fa-arrow-left me-2"></i> Back</button>
                            <button type="submit" class="btn-submit-update"><i class="fas fa-save me-2"></i> Update
                                Application</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <!-- JAVASCRIPT -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // === Toggle JITO UID Field ===
        function toggleJitoUid(value) {
            var jitoUidSection = document.getElementById('jito_uid_section');
            if (value === 'yes') {
                jitoUidSection.style.display = 'block';
            } else {
                jitoUidSection.style.display = 'none';
            }
        }

        // === State-Zone-Chapter Cascading Dropdown Logic ===
        $(document).ready(function() {
            // Prepare the data (Passed from Controller)
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

            // EVENT: When State Changes
            $('#state_select').on('change', function() {
                var selectedState = $(this).val();
                populateZones(selectedState); // Populate zones, no saved zone needed for new selection

                // Also clear chapter dropdown when state changes
                $('#chapter_select').empty().append('<option value="">-- Select Chapter --</option>');
            });

            // EVENT: When Zone Changes
            $('#zone_select').on('change', function() {
                var selectedZoneOption = $(this).find('option:selected');
                var zoneId = selectedZoneOption.attr('data-zone-id');
                populateChapters(zoneId); // Populate chapters based on selected zone
            });

            // ON LOAD: If user is editing (State already selected)
            var initialState = $('#state_select').val();
            var savedZone = "{{ $donor->personalDetail->zone ?? '' }}";
            var savedChapter = "{{ $donor->personalDetail->chapter_name ?? '' }}";
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

        const stepInput = document.getElementById('current_step_input');
        let currentStep = parseInt(stepInput.value) || 1;
        // General donors have 2 steps (Personal Details + Payment), members have 7 steps
        const totalSteps = {{ $donor->donor_type === 'general' ? '2' : '7' }};

        document.addEventListener('DOMContentLoaded', function() {
            goToStep(currentStep);

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
            stepInput.value = step;

            document.querySelectorAll('.donor-step-item').forEach((item, index) => {
                if (index + 1 === step) item.classList.add('active');
                else item.classList.remove('active');
            });

            document.querySelectorAll('.step-content-section').forEach((section, index) => {
                if (index + 1 === step) section.classList.add('active');
                else section.classList.remove('active');
            });
        }

        function nextStep() {
            if (currentStep < totalSteps) goToStep(currentStep + 1);
        }

        function prevStep() {
            if (currentStep > 1) goToStep(currentStep - 1);
        }

        const kidsInput = document.getElementById('num_kids_input');
        const childrenTbody = document.getElementById('children_tbody');

        if (kidsInput) {
            kidsInput.addEventListener('input', function() {
                let count = parseInt(this.value);
                if (isNaN(count)) return;
                updateChildrenRows(count);
            });
        }

        function updateChildrenRows(count) {
            const currentRows = childrenTbody.querySelectorAll('tr');
            const currentCount = currentRows.length;

            if (count > currentCount) {
                for (let i = currentCount; i < count; i++) {
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td><input type="text" name="children[${i}][name]" class="form-control form-control-sm ucwords"></td>
                        <td>
                            <select name="children[${i}][gender]" class="form-select form-select-sm">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </td>
                        <td><input type="date" name="children[${i}][dob]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="children[${i}][blood_group]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="children[${i}][marital_status]" class="form-control form-control-sm"></td>
                    `;
                    childrenTbody.appendChild(newRow);
                }
            } else if (count < currentCount) {
                for (let i = currentCount - 1; i >= count; i--) {
                    childrenTbody.removeChild(currentRows[i]);
                }
            }
        }

        function toTitleCase(str) {
            return str.toLowerCase().split(' ').map(function(word) {
                return (word.charAt(0).toUpperCase() + word.slice(1));
            }).join(' ');
        }

        document.addEventListener('blur', function(e) {
            if (e.target.classList.contains('ucwords')) {
                e.target.value = toTitleCase(e.target.value);
            }
        }, true);
    </script>
@endsection
