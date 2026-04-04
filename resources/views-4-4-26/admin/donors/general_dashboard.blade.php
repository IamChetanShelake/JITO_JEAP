@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">General Donors Dashboard</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.donors.create', ['donor_type' => 'general']) }}"
                                class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add New General Donor
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($donors->isEmpty())
                            <div class="alert alert-info">
                                No general donors found.
                                <a href="{{ route('admin.donors.create') }}">Add a new general donor</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            {{-- <th>Status</th> --}}
                                            <th>Total Payments</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($donors as $donor)
                                            <tr>
                                                <td>{{ $donor->id }}</td>
                                                <td>
                                                    {{ $donor->name ?? 'N/A' }}

                                                </td>
                                                <td>{{ $donor->email ?? 'N/A' }}</td>
                                                <td>

                                                    {{ $donor->phone ?? 'N/A' }}


                                                </td>
                                                {{-- <td>
                                                    @if ($donor->status === 'active')
                                                        <span class="badge badge-success">Active</span>
                                                    @elseif($donor->status === 'converted')
                                                        <span class="badge badge-info">Converted</span>
                                                    @else
                                                        <span class="badge badge-secondary">Inactive</span>
                                                    @endif
                                                </td> --}}
                                                <td>
                                                    @php
                                                        $payments = $donor->paymentDetail?->payment_entries;
                                                        $paymentCount = 0;
                                                        $totalAmount = 0;
                                                        if (!empty($payments)) {
                                                            $paymentsArray = is_array($payments)
                                                                ? $payments
                                                                : json_decode($payments, true);
                                                            if (is_array($paymentsArray)) {
                                                                $paymentCount = count($paymentsArray);
                                                                foreach ($paymentsArray as $payment) {
                                                                    $totalAmount += floatval($payment['amount'] ?? 0);
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    <span class="badge badge-primary">{{ $paymentCount }}</span>
                                                    <span
                                                        class="text-muted ml-2">₹{{ number_format($totalAmount, 2) }}</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.donors.dashboard.show', $donor->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    <a href="{{ route('admin.donors.edit', $donor->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
