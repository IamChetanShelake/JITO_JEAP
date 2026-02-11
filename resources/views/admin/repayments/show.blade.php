@extends('admin.layouts.master')

@section('title', 'Repayment Details - ' . $user->name . ' - JITO JEAP')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<style>
    .detail-container {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid #e0e0e0;
        margin-bottom: 1.5rem;
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .detail-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
    }

    .summary-box {
        background: linear-gradient(135deg, #393185 0%, #5b5ba8 100%);
        color: white;
        border-radius: 12px;
        padding: 1.25rem;
        text-align: center;
    }

    .summary-box.disbursed {
        background: linear-gradient(135deg, #009846 0%, #00b359 100%);
    }

    .summary-box.repaid {
        background: linear-gradient(135deg, #00a6a6 0%, #00c9c9 100%);
    }

    .summary-box.outstanding {
        background: linear-gradient(135deg, #FBBA00 0%, #ffcd33 100%);
        color: #333;
    }

    .summary-label {
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        opacity: 0.9;
    }

    .summary-value {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .status-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-pending {
        background: #fff8e1;
        color: #f57c00;
    }

    .status-cleared {
        background: #e8f5e9;
        color: #388e3c;
    }

    .status-bounced {
        background: #ffebee;
        color: #c62828;
    }

    .btn-add {
        background: #009846;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-add:disabled {
        background: #ccc;
        color: #666;
        cursor: not-allowed;
    }

    .modal-header {
        background: #393185;
        color: white;
        border-radius: 12px 12px 0 0;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .form-label {
        font-weight: 500;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 0.75rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #393185;
        box-shadow: 0 0 0 0.2rem rgba(57, 49, 133, 0.25);
    }

    .amount-display {
        background: #e8f5e9;
        border: 2px solid #009846;
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
        font-size: 1.25rem;
        font-weight: 700;
        color: #009846;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">
                <i class="fas fa-receipt me-2"></i>
                Repayment Details
            </h1>
            <p class="dashboard-subtitle">Accounts Department</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.disbursement.show', ['user' => $user->id]) }}" class="change-country-btn">
                <i class="fas fa-arrow-left me-1"></i> Back to Disbursement
            </a>
            <button type="button" class="btn-add" data-bs-toggle="modal" data-bs-target="#repaymentModal"
                @if($outstandingAmount <= 0) disabled @endif>
                <i class="fas fa-plus me-1"></i> Add Repayment
            </button>
        </div>
    </div>

    <div class="detail-container">
        <div class="detail-header">
            <div class="detail-title">
                <i class="fas fa-user me-2"></i>
                {{ $user->name }}
                <span class="text-muted ms-2" style="font-size: 0.9rem;">ID: {{ $user->id }}</span>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-3">
                <div class="summary-box">
                    <div class="summary-label">Total Loan Amount</div>
                    <div class="summary-value">Rs. {{ number_format($totalLoanAmount, 2) }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-box disbursed">
                    <div class="summary-label">Total Disbursed Amount</div>
                    <div class="summary-value">Rs. {{ number_format($totalDisbursedAmount, 2) }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-box repaid">
                    <div class="summary-label">Total Repaid Amount</div>
                    <div class="summary-value">Rs. {{ number_format($totalRepaidAmount, 2) }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-box outstanding">
                    <div class="summary-label">Outstanding Amount</div>
                    <div class="summary-value">Rs. {{ number_format($outstandingAmount, 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="detail-container">
        <div class="detail-header">
            <div class="detail-title">
                <i class="fas fa-history me-2"></i>
                Repayment History
            </div>
        </div>

        @if($repayments->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                No repayments recorded yet.
            </div>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Payment Date</th>
                            <th>Amount</th>
                            <th>Payment Mode</th>
                            <th>Reference</th>
                            <th>Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($repayments as $repayment)
                        <tr>
                            <td>{{ date('d/m/Y', strtotime($repayment->payment_date)) }}</td>
                            <td class="fw-bold">Rs. {{ number_format($repayment->amount, 2) }}</td>
                            <td>{{ strtoupper($repayment->payment_mode) }}</td>
                            <td>{{ $repayment->reference_number ?? '-' }}</td>
                            <td>
                                @if($repayment->status === 'cleared')
                                    <span class="status-badge status-cleared">Cleared</span>
                                @elseif($repayment->status === 'bounced')
                                    <span class="status-badge status-bounced">Bounced</span>
                                @else
                                    <span class="status-badge status-pending">Pending</span>
                                @endif
                            </td>
                            <td>{{ $repayment->remarks ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<div class="modal fade" id="repaymentModal" tabindex="-1" aria-labelledby="repaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="repaymentModalLabel">
                    <i class="fas fa-plus me-2"></i>
                    Add Repayment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.repayments.store', ['user' => $user->id]) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Outstanding Amount</label>
                        <div class="amount-display">Rs. {{ number_format($outstandingAmount, 2) }}</div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Payment Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="payment_date"
                                value="{{ old('payment_date', date('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Amount <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="amount"
                                value="{{ old('amount') }}" step="0.01" min="0.01"
                                max="{{ $outstandingAmount }}" required>
                            <small class="text-muted">Max: Rs. {{ number_format($outstandingAmount, 2) }}</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Payment Mode <span class="text-danger">*</span></label>
                            <select class="form-select" name="payment_mode" id="paymentMode" required>
                                <option value="">Select Mode</option>
                                <option value="pdc" {{ old('payment_mode') === 'pdc' ? 'selected' : '' }}>PDC</option>
                                <option value="neft" {{ old('payment_mode') === 'neft' ? 'selected' : '' }}>NEFT</option>
                                <option value="cash" {{ old('payment_mode') === 'cash' ? 'selected' : '' }}>CASH</option>
                            </select>
                        </div>

                        <div class="col-md-6" id="referenceField">
                            <label class="form-label" id="referenceLabel">Cheque Number / UTR</label>
                            <input type="text" class="form-control" name="reference_number"
                                value="{{ old('reference_number') }}" placeholder="Enter reference number">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Remarks (Optional)</label>
                            <textarea class="form-control" name="remarks" rows="3"
                                placeholder="Enter remarks">{{ old('remarks') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i> Confirm Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Check for session success messages and show SweetAlert
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#393185'
        });
    @endif

    const modeSelect = document.getElementById('paymentMode');
    const referenceField = document.getElementById('referenceField');
    const referenceLabel = document.getElementById('referenceLabel');

    function updateReferenceField() {
        const mode = modeSelect.value;
        if (mode === 'cash') {
            referenceField.style.display = 'none';
            referenceField.querySelector('input').required = false;
        } else {
            referenceField.style.display = 'block';
            referenceLabel.textContent = mode === 'pdc' ? 'Cheque Number' : 'UTR Number';
            referenceField.querySelector('input').required = true;
        }
    }

    updateReferenceField();
    modeSelect.addEventListener('change', updateReferenceField);

    @if($errors->any())
        const repaymentModal = new bootstrap.Modal(document.getElementById('repaymentModal'));
        repaymentModal.show();
    @endif
});
</script>
@endsection
