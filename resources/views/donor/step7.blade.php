@extends('donor.layout.master')

@section('step')
    <button class="btn me-2" style="background-color:#393185;color:white;">
        Step 7 of 8
    </button>
@endsection

@section('content')
    <div class="col-lg-9 main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <form method="POST" action="{{ route('donor.step7.store') }}">
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

                        @php
                            $paymentEntries = [];
                            if (old('utr_no')) {
                                $utrNos = old('utr_no', []);
                                $chequeDates = old('cheque_date', []);
                                $amounts = old('amount', []);
                                $bankBranches = old('bank_branch', []);
                                $issuedBy = old('issued_by', []);
                                foreach ($utrNos as $index => $utrNo) {
                                    $paymentEntries[] = [
                                        'utr_no' => $utrNo,
                                        'cheque_date' => $chequeDates[$index] ?? '',
                                        'amount' => $amounts[$index] ?? '',
                                        'bank_branch' => $bankBranches[$index] ?? '',
                                        'issued_by' => $issuedBy[$index] ?? '',
                                    ];
                                }
                            } elseif (!empty($paymentDetail?->payment_entries)) {
                                $paymentEntries = json_decode($paymentDetail->payment_entries, true) ?: [];
                            }
                            $rows = max(count($paymentEntries), 2);
                        @endphp

                        <h4 class="mb-3 text-center">Step 7 : Bank Details</h4>

                        <div class="card mb-4">
                            <div class="card-body">

                                <h5 class="mb-3">Cheque / RTGS / NEFT Details</h5>

                                <div class="row">
                                    <!-- Cheque Favoring -->
                                    <div class="col-md-6 mb-3">
                                        <label>Cheque Favoring *</label>
                                        <input type="text" class="form-control"
                                            value="JITO EDUCATION ASSISTANCE FOUNDATION" readonly>
                                    </div>

                                    <!-- For RTGS/NEFT  -->
                                    <div class="col-md-6 mb-3">
                                        <label>RTGS/NEFT *</label>
                                        <input type="text" class="form-control" name="rtgs_neft"
                                            placeholder="Enter RTGS/NEFT details" required
                                            value="{{ old('rtgs_neft', $paymentDetail->rtgs_neft ?? '') }}">
                                    </div>

                                    <!-- Bank Name -->
                                    <div class="col-md-6 mb-3">
                                        <label>Bank Name *</label>
                                        <input type="text" class="form-control" value="ICICI BANK" readonly>
                                    </div>

                                    <!-- Branch Name -->
                                    <div class="col-md-6 mb-3">
                                        <label>Branch Name *</label>
                                        <input type="text" class="form-control" value="WATER FIELD ROAD, BANDRA (WEST)"
                                            readonly>
                                    </div>

                                    <!-- Account Number -->
                                    <div class="col-md-6 mb-3">
                                        <label>Account Number *</label>
                                        <input type="text" class="form-control" value="003801040441" readonly>
                                    </div>

                                    <!-- IFSC Code -->
                                    <div class="col-md-6 mb-3">
                                        <label>IFSC Code *</label>
                                        <input type="text" class="form-control" value="ICIC0000388" readonly>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- PAYMENT ENTRY TABLE -->
                        <div class="card mb-4">
                            <div class="card-body">

                                <h5 class="mb-3">Payment Details (To be filled by Applicant)</h5>

                                <div class="table-responsive">
                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th>Sr. No</th>
                                                <th>Cheque / DD No / UTR No</th>
                                                <th>Cheque Date</th>
                                                <th>Amount</th>
                                                <th>Bank Name / Branch</th>
                                                <th>Cheque Issued / Transfer By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($i = 0; $i < $rows; $i++)
                                                @php $entry = $paymentEntries[$i] ?? []; @endphp
                                                <tr>
                                                    <td>{{ $i + 1 }}</td>
                                                    <td>
                                                        <input type="text" name="utr_no[]" class="form-control"
                                                            placeholder="Enter cheque/DD/UTR number" required
                                                            value="{{ old('utr_no.' . $i, $entry['utr_no'] ?? '') }}">
                                                        @error('utr_no.' . $i)
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="date" name="cheque_date[]" class="form-control" required
                                                            value="{{ old('cheque_date.' . $i, $entry['cheque_date'] ?? '') }}">
                                                        @error('cheque_date.' . $i)
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="number" name="amount[]" class="form-control"
                                                            placeholder="Enter amount" required
                                                            value="{{ old('amount.' . $i, $entry['amount'] ?? '') }}">
                                                        @error('amount.' . $i)
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" name="bank_branch[]" class="form-control"
                                                            placeholder="Enter bank name and branch" required
                                                            value="{{ old('bank_branch.' . $i, $entry['bank_branch'] ?? '') }}">
                                                        @error('bank_branch.' . $i)
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" name="issued_by[]" class="form-control"
                                                            placeholder="Enter issuer/transfer name" required
                                                            value="{{ old('issued_by.' . $i, $entry['issued_by'] ?? '') }}">
                                                        @error('issued_by.' . $i)
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>



                        <!-- BUTTONS -->
                        <div class="d-flex justify-content-between mt-4 mb-4">
                            <a href="{{ route('donor.step6') }}" class="btn" style="background:#988DFF1F;color:gray;">
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
