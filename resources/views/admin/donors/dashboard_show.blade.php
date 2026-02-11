@extends('admin.layouts.master')

@section('title', 'Donor Application - JitoJeap Admin')

@section('content')
<div class="container donor-form">
    <style>
        .donor-form .info-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .donor-form .fw-bold {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            font-size: 0.9rem;
            color: var(--text-dark);
            background-color: #f8f9fa;
            font-weight: 500;
            display: block;
            word-break: break-word;
        }

        .donor-form .fw-bold a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
        }

        .donor-form .fw-bold a:hover {
            text-decoration: underline;
        }

        .donor-form .section-card ul {
            margin-bottom: 0;
            padding-left: 1rem;
        }
        .donorH4{
            color: white;
            margin: 0;
            padding: 1rem 1.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: #393185;
        }
    </style>
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title"><i class="fas fa-hand-holding-heart me-2"></i> Donor Application</h1>
            <p class="dashboard-subtitle">{{ $donor->name }}</p>
        </div>
        <a href="{{ route('admin.donors.dashboard') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="section-card">
        <div class="card-body">
            <h4 class="mb-3 donorH4">Personal Details</h4>
            <div class="row g-3">
                <div class="col-md-4"><div class="info-label">Title</div><div class="fw-bold">{{ $donor->personalDetail->title ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">First Name</div><div class="fw-bold">{{ $donor->personalDetail->first_name ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Middle Name</div><div class="fw-bold">{{ $donor->personalDetail->middle_name ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Surname</div><div class="fw-bold">{{ $donor->personalDetail->surname ?? '-' }}</div></div>
                <div class="col-md-8"><div class="info-label">Complete Address</div><div class="fw-bold">{{ $donor->personalDetail->complete_address ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">City</div><div class="fw-bold">{{ $donor->personalDetail->city ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">State</div><div class="fw-bold">{{ $donor->personalDetail->state ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Pin Code</div><div class="fw-bold">{{ $donor->personalDetail->pin_code ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Resi Landline</div><div class="fw-bold">{{ $donor->personalDetail->resi_landline ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Mobile</div><div class="fw-bold">{{ $donor->personalDetail->mobile_no ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">WhatsApp</div><div class="fw-bold">{{ $donor->personalDetail->whatsapp_no ?? '-' }}</div></div>
                <div class="col-md-6"><div class="info-label">Email 1</div><div class="fw-bold">{{ $donor->personalDetail->email_id_1 ?? '-' }}</div></div>
                <div class="col-md-6"><div class="info-label">Email 2</div><div class="fw-bold">{{ $donor->personalDetail->email_id_2 ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Preferred Residence</div><div class="fw-bold">{{ $donor->personalDetail->preferred_residence_address ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Preferred Office</div><div class="fw-bold">{{ $donor->personalDetail->preferred_office_address ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">PAN No</div><div class="fw-bold">{{ $donor->personalDetail->pan_no ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Chapter Name</div><div class="fw-bold">{{ $donor->personalDetail->chapter_name ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Date of Birth</div><div class="fw-bold">{{ $donor->personalDetail->date_of_birth ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Anniversary Date</div><div class="fw-bold">{{ $donor->personalDetail->anniversary_date ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Blood Group</div><div class="fw-bold">{{ $donor->personalDetail->blood_group ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Mother Tongue</div><div class="fw-bold">{{ $donor->personalDetail->mother_tongue ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">District</div><div class="fw-bold">{{ $donor->personalDetail->district_of_native_place ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Father's Name</div><div class="fw-bold">{{ $donor->personalDetail->fathers_name ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Hobby 1</div><div class="fw-bold">{{ $donor->personalDetail->hobby_1 ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Hobby 2</div><div class="fw-bold">{{ $donor->personalDetail->hobby_2 ?? '-' }}</div></div>
            </div>
        </div>
    </div>

    <div class="section-card mt-4">
        <div class="card-body">
            <h4 class="mb-3 donorH4">Family Details</h4>
            <div class="row g-3">
                <div class="col-md-4"><div class="info-label">Spouse Title</div><div class="fw-bold">{{ $donor->familyDetail->spouse_title ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Spouse Name</div><div class="fw-bold">{{ $donor->familyDetail->spouse_name ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Birth Date</div><div class="fw-bold">{{ $donor->familyDetail->spouse_birth_date ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">JITO Member</div><div class="fw-bold">{{ $donor->familyDetail->jito_member ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">JITO UID</div><div class="fw-bold">{{ $donor->familyDetail->jito_uid ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Blood Group</div><div class="fw-bold">{{ $donor->familyDetail->spouse_blood_group ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Number of Kids</div><div class="fw-bold">{{ $donor->familyDetail->number_of_kids ?? '-' }}</div></div>
            </div>

            <div class="mt-3">
                <div class="info-label mb-2">Children Details</div>
                @if (count($children))
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>DOB</th>
                                    <th>Blood Group</th>
                                    <th>Marital Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($children as $index => $child)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $child['name'] ?? '-' }}</td>
                                        <td>{{ $child['gender'] ?? '-' }}</td>
                                        <td>{{ $child['dob'] ?? '-' }}</td>
                                        <td>{{ $child['blood_group'] ?? '-' }}</td>
                                        <td>{{ $child['marital_status'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="fw-bold">No children details.</div>
                @endif
            </div>
        </div>
    </div>

    <div class="section-card mt-4">
        <div class="card-body">
            <h4 class="mb-3 donorH4">Nominee Details</h4>
            <div class="row g-3">
                <div class="col-md-4"><div class="info-label">Title</div><div class="fw-bold">{{ $donor->nomineeDetail->nominee_title ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Name</div><div class="fw-bold">{{ $donor->nomineeDetail->nominee_name ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Relationship</div><div class="fw-bold">{{ $donor->nomineeDetail->nominee_relationship ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Mobile</div><div class="fw-bold">{{ $donor->nomineeDetail->nominee_mobile ?? '-' }}</div></div>
                <div class="col-md-8"><div class="info-label">Address</div><div class="fw-bold">{{ $donor->nomineeDetail->nominee_address ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">City</div><div class="fw-bold">{{ $donor->nomineeDetail->nominee_city ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Pincode</div><div class="fw-bold">{{ $donor->nomineeDetail->nominee_pincode ?? '-' }}</div></div>
            </div>
        </div>
    </div>

    <div class="section-card mt-4">
        <div class="card-body">
            <h4 class="mb-3 donorH4">Membership Details</h4>
            @if (count($paymentOptions))
                <div class="fw-bold">
                    <ul class="mb-0">
                        @foreach ($paymentOptions as $option)
                            <li>{{ $option }}</li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="fw-bold">No membership options selected.</div>
            @endif
        </div>
    </div>

    <div class="section-card mt-4">
        <div class="card-body">
            <h4 class="mb-3m donorH4">Professional Details</h4>
            <div class="row g-3">
                <div class="col-md-6"><div class="info-label">Company Name</div><div class="fw-bold">{{ $donor->professionalDetail->company_name ?? '-' }}</div></div>
                <div class="col-md-6"><div class="info-label">Company Activity</div><div class="fw-bold">{{ $donor->professionalDetail->company_activity_details ?? '-' }}</div></div>
                <div class="col-md-6"><div class="info-label">Designation</div><div class="fw-bold">{{ $donor->professionalDetail->designation ?? '-' }}</div></div>
                <div class="col-md-6"><div class="info-label">Website</div><div class="fw-bold">{{ $donor->professionalDetail->company_website ?? '-' }}</div></div>
                <div class="col-md-12"><div class="info-label">Office Address</div><div class="fw-bold">{{ $donor->professionalDetail->office_address ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Office State</div><div class="fw-bold">{{ $donor->professionalDetail->office_state ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Office City</div><div class="fw-bold">{{ $donor->professionalDetail->office_city ?? '-' }}</div></div>
                <div class="col-md-4"><div class="info-label">Office Pincode</div><div class="fw-bold">{{ $donor->professionalDetail->office_pincode ?? '-' }}</div></div>
                <div class="col-md-6"><div class="info-label">Office Telephone</div><div class="fw-bold">{{ $donor->professionalDetail->office_telephone ?? '-' }}</div></div>
                <div class="col-md-6"><div class="info-label">Office Mobile</div><div class="fw-bold">{{ $donor->professionalDetail->office_mobile ?? '-' }}</div></div>
                <div class="col-md-6"><div class="info-label">PAN No</div><div class="fw-bold">{{ $donor->professionalDetail->pan_no ?? '-' }}</div></div>
                <div class="col-md-6"><div class="info-label">Coordinator Name</div><div class="fw-bold">{{ $donor->professionalDetail->coordinator_name ?? '-' }}</div></div>
                <div class="col-md-6"><div class="info-label">Coordinator Mobile</div><div class="fw-bold">{{ $donor->professionalDetail->coordinator_mobile ?? '-' }}</div></div>
                <div class="col-md-6"><div class="info-label">Coordinator Email 1</div><div class="fw-bold">{{ $donor->professionalDetail->coordinator_email_1 ?? '-' }}</div></div>
                <div class="col-md-6"><div class="info-label">Coordinator Email 2</div><div class="fw-bold">{{ $donor->professionalDetail->coordinator_email_2 ?? '-' }}</div></div>
            </div>
        </div>
    </div>

    <div class="section-card mt-4">
        <div class="card-body">
            <h4 class="mb-3 donorH4">Documents</h4>
            <div class="row g-3">
                <div class="col-md-6"><div class="info-label">PAN Member</div><div class="fw-bold">@if(!empty($donor->document?->pan_member_file)) <a href="{{ asset($donor->document->pan_member_file) }}" target="_blank">View</a> @else - @endif</div></div>
                <div class="col-md-6"><div class="info-label">PAN Donor</div><div class="fw-bold">@if(!empty($donor->document?->pan_donor_file)) <a href="{{ asset($donor->document->pan_donor_file) }}" target="_blank">View</a> @else - @endif</div></div>
                <div class="col-md-6"><div class="info-label">Photo</div><div class="fw-bold">@if(!empty($donor->document?->photo_file)) <a href="{{ asset($donor->document->photo_file) }}" target="_blank">View</a> @else - @endif</div></div>
                <div class="col-md-6"><div class="info-label">Address Proof</div><div class="fw-bold">@if(!empty($donor->document?->address_proof_file)) <a href="{{ asset($donor->document->address_proof_file) }}" target="_blank">View</a> @else - @endif</div></div>
                <div class="col-md-6"><div class="info-label">Authorization Letter</div><div class="fw-bold">@if(!empty($donor->document?->authorization_letter_file)) <a href="{{ asset($donor->document->authorization_letter_file) }}" target="_blank">View</a> @else - @endif</div></div>
            </div>
        </div>
    </div>

    <div class="section-card mt-4">
        <div class="card-body">
            <h4 class="mb-3 donorH4">Payment Details</h4>
            @if (count($paymentEntries))
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>UTR / Cheque No</th>
                                <th>Cheque Date</th>
                                <th>Amount</th>
                                <th>Bank Branch</th>
                                <th>Issued By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paymentEntries as $index => $entry)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $entry['utr_no'] ?? '-' }}</td>
                                    <td>{{ $entry['cheque_date'] ?? '-' }}</td>
                                    <td>{{ $entry['amount'] ?? '-' }}</td>
                                    <td>{{ $entry['bank_branch'] ?? '-' }}</td>
                                    <td>{{ $entry['issued_by'] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="fw-bold">No payment entries.</div>
            @endif
        </div>
    </div>
</div>
@endsection
