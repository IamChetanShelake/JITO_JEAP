@extends('admin.layouts.master')

@section('title', 'General Donor Details - JitoJeap Admin')

@section('content')
    <div class="container-fluid">
        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Validation Error!</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @if (!empty($donor->personalDetail?->photo))
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('donor_documents/' . $donor->personalDetail->photo) }}"
                                    alt="User profile picture">
                            @else
                                <img class="profile-user-img img-fluid img-circle" src="{{ asset('dist/img/avatar.png') }}"
                                    alt="Default avatar">
                            @endif
                        </div>
                        <h3 class="profile-username text-center">
                            {{ $donor->personalDetail?->donor_name ?? ($donor->name ?? 'N/A') }}
                        </h3>
                        <p class="text-muted text-center">
                            <span class="badge badge-info">General Donor</span>
                        </p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Status</b>
                                <a class="float-right">
                                    @if ($donor->status === 'active')
                                        <span class="badge badge-success">Active</span>
                                    @elseif($donor->status === 'converted')
                                        <span class="badge badge-info">Converted</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b>
                                <a class="float-right">{{ $donor->email ?? 'N/A' }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Can Login</b>
                                <a class="float-right">
                                    @if ($donor->can_login)
                                        <span class="badge badge-success">Yes</span>
                                    @else
                                        <span class="badge badge-danger">No</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                        <a href="{{ route('admin.general-donors.dashboard') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-arrow-left"></i> Back to General Donors
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" href="#personal" data-toggle="tab">
                                    <i class="fas fa-user"></i> Personal Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#payments" data-toggle="tab">
                                    <i class="fas fa-money-bill-wave"></i> Payments
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="personal">
                                <div class="card card-primary">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h3 class="card-title">Personal Details</h3>
                                        <a href="{{ route('admin.donors.edit', $donor->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        @if ($donor->personalDetail)
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Donor Name</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $donor->personalDetail->donor_name ?? 'N/A' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Date of Birth</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $donor->personalDetail->dob ?? 'N/A' }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Gender</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $donor->personalDetail->gender ?? 'N/A' }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Blood Group</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $donor->personalDetail->blood_group ?? 'N/A' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Phone</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $donor->personalDetail->phone ?? 'N/A' }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>WhatsApp</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $donor->personalDetail->whatsapp ?? 'N/A' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $donor->email ?? 'N/A' }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $donor->personalDetail->address ?? 'N/A' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $donor->personalDetail->city ?? 'N/A' }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Pincode</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $donor->personalDetail->pincode ?? 'N/A' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>PAN Number</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $donor->personalDetail->pan_number ?? 'N/A' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Aadhaar Number</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $donor->personalDetail->aadhaar_number ?? 'N/A' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-warning">
                                                No personal details found for this donor. <br>
                                                <a href="{{ route('admin.donors.edit', $donor->id) }}"
                                                    class="btn btn-primary btn-sm mt-2">
                                                    <i class="fas fa-edit"></i> Add Personal Details
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="payments">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Payment History</h3>
                                    </div>
                                    <div class="card-body">
                                        @if (count($paymentEntries) > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Amount</th>
                                                            <th>Payment Date</th>
                                                            <th>Financial Year</th>
                                                            <th>Payment Mode</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($paymentEntries as $index => $payment)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>₹{{ number_format($payment['amount'] ?? 0, 2) }}</td>
                                                                <td>{{ $payment['payment_date'] ?? 'N/A' }}</td>
                                                                <td>{{ $payment['financial_year'] ?? 'N/A' }}</td>
                                                                <td>{{ $payment['payment_mode'] ?? 'N/A' }}</td>
                                                                <td>{{ $payment['remarks'] ?? 'N/A' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="5" class="text-right">Total</th>
                                                            <th>₹{{ number_format(array_sum(array_column($paymentEntries, 'amount')), 2) }}
                                                            </th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                No payment records found for this donor.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
