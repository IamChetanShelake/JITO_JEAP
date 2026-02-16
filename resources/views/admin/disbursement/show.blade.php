@extends('admin.layouts.master')

@section('title', 'Disbursement Details - ' . $user->first_name . ' ' . $user->last_name . ' - JITO JEAP')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<link href="{{ asset('summernotes/summernote-lite.min.css') }}" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    .back-btn {
        background: #6c757d;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        background: #5a6268;
    }

    .info-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .info-label {
        font-size: 0.8rem;
        color: #666;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-size: 1rem;
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

    .summary-box.remaining {
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

    .pdc-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.5rem;
    }

    .pdc-status {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-weight: 600;
    }

    .pdc-status.cleared {
        background: #e8f5e9;
        color: #388e3c;
    }

    .pdc-status.deposited {
        background: #e3f2fd;
        color: #1976d2;
    }

    .pdc-status.bounced {
        background: #ffebee;
        color: #c62828;
    }

    .table-responsive {
        overflow-x: auto;
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

    .status-completed {
        background: #e8f5e9;
        color: #388e3c;
    }

    .status-on-hold {
        background: #ffebee;
        color: #c62828;
    }

    .btn-disburse {
        background: #009846;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-disburse:hover {
        background: #007a3a;
    }

    .btn-disabled {
        background: #ccc;
        color: #666;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        cursor: not-allowed;
    }

    .btn-view-history {
        background: #393185;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
    }

    /* Modal Styles */
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

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .alert-info {
        background: #e3f2fd;
        color: #1565c0;
        border: 1px solid #90caf9;
    }
</style>
@endsection

@section('content')
<div class="container">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">
                <i class="fas fa-money-bill-wave me-2"></i>
                Disbursement Details
            </h1>
            <p class="dashboard-subtitle">Accounts Department</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.disbursement.index') }}" class="change-country-btn">
                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
            </a>
            <a href="{{ route('admin.repayments.show', ['user' => $user->id]) }}" class="change-country-btn">
                <i class="fas fa-receipt me-1"></i> Repayments
            </a>
        </div>
    </div>

    <!-- Student Info Header -->
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
                <div class="info-card">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $user->email }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-card">
                    <div class="info-label">Phone</div>
                    <div class="info-value">{{ $user->phone }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-card">
                    <div class="info-label">Course</div>
                    <div class="info-value">{{ $user->course ?? 'N/A' }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-card">
                    <div class="info-label">Institute</div>
                    <div class="info-value">{{ $user->institute_name ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 mt-2">
            <div class="col-md-4">
                <div class="summary-box">
                    <div class="summary-label">Total Planned Amount</div>
                    <div class="summary-value">
                        ₹{{ number_format($allSchedules->sum('planned_amount'), 2) }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-box disbursed">
                    <div class="summary-label">Disbursed Amount</div>
                    <div class="summary-value">
                        ₹{{ number_format($allDisbursements->sum('amount'), 2) }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-box remaining">
                    <div class="summary-label">Remaining Amount</div>
                    <div class="summary-value">
                        ₹{{ number_format($allSchedules->sum('planned_amount') - $allDisbursements->sum('amount'), 2) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PDC/Cheque Details -->
    @if($pdcDetails->isNotEmpty())
    <div class="detail-container">
        {{-- <div class="detail-header">
            <div class="detail-title">
                <i class="fas fa-money-check me-2"></i>
                PDC / Cheque Details
            </div>
        </div>

        <div class="row g-3">
            @foreach($pdcDetails as $pdc)
            <div class="col-md-4">
                <div class="pdc-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <span class="fw-bold">{{ $pdc->cheque_number ?? 'N/A' }}</span>
                            @switch($pdc->status)
                                @case('cleared')
                                    <span class="pdc-status cleared">Cleared</span>
                                    @break
                                @case('deposited')
                                    <span class="pdc-status deposited">Deposited</span>
                                    @break
                                @case('bounced')
                                    <span class="pdc-status bounced">Bounced</span>
                                    @break
                                @default
                                    <span class="pdc-status" style="background: #f5f5f5;">{{ ucfirst($pdc->status ?? 'Pending') }}</span>
                            @endswitch
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="info-label">Amount</div>
                            <div class="fw-bold">₹{{ number_format($pdc->amount, 2) }}</div>
                        </div>
                        <div class="col-6">
                            <div class="info-label">Due Date</div>
                            <div>{{ $pdc->due_date ? date('d/m/Y', strtotime($pdc->due_date)) : 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div> --}}
    </div>
    @endif

    <!-- Disbursement History -->
    @if($allDisbursements->isNotEmpty())
    <div class="detail-container">
        <div class="detail-header">
            <div class="detail-title">
                <i class="fas fa-history me-2"></i>
                Disbursement History
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Installment</th>
                        <th>Disbursement Date</th>
                        <th>Bank Account</th>
                        <th>UTR Number</th>
                        <th>Amount</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allDisbursements as $disbursement)
                    <tr>
                        <td>{{ $disbursement->disbursement_schedule_id }}</td>
                        <td>{{ date('d/m/Y', strtotime($disbursement->disbursement_date)) }}</td>
                        <td>
                            @if($disbursement->jito_jeap_bank_id)
                                @php
                                    $bank = DB::connection('admin_panel')
                                        ->table('jito_jeap_banks')
                                        ->where('id', $disbursement->jito_jeap_bank_id)
                                        ->first();
                                @endphp
                                {{ $bank ? $bank->bank_name : 'N/A' }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="fw-bold">{{ $disbursement->utr_number }}</td>
                        <td class="fw-bold text-success">₹{{ number_format($disbursement->amount, 2) }}</td>
                        <td>{!! $disbursement->remarks ?? '-' !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Section 2: Disbursement Schedule Table -->
    <div class="detail-container">
        <div class="detail-header">
            <div class="detail-title">
                <i class="fas fa-calendar-alt me-2"></i>
                Disbursement Schedule
            </div>
        </div>

        @if($allSchedules->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                No disbursement schedule found for this student.
            </div>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Installment No</th>
                            <th>Planned Date</th>
                            <th>Planned Amount</th>
                            <th>Status</th>
                            <th>Actual Disbursement Date</th>
                            <th>UTR Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allSchedules as $schedule)
                        <tr>
                            <td>
                                <span class="fw-bold">Installment {{ $schedule->installment_no }}</span>
                            </td>
                            <td>{{ date('d/m/Y', strtotime($schedule->planned_date)) }}</td>
                            <td class="fw-bold">₹{{ number_format($schedule->planned_amount, 2) }}</td>
                            <td>
                                @if($schedule->status === 'completed')
                                    <span class="status-badge status-completed">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Completed
                                    </span>
                                @elseif($schedule->status === 'on_hold')
                                    <span class="status-badge status-on-hold">
                                        <i class="fas fa-pause-circle me-1"></i>
                                        On Hold
                                    </span>
                                @else
                                    <span class="status-badge status-pending">
                                        <i class="fas fa-clock me-1"></i>
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($schedule->disbursement_date)
                                    {{ date('d/m/Y', strtotime($schedule->disbursement_date)) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($schedule->utr_number)
                                    <span class="fw-bold">{{ $schedule->utr_number }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($schedule->status === 'completed')
                                    <button type="button" class="btn-disabled" disabled>
                                        <i class="fas fa-check me-1"></i> Completed
                                    </button>
                                @else
                                    <button type="button" class="btn-disburse" data-bs-toggle="modal"
                                        data-bs-target="#disburseModal{{ $schedule->id }}"
                                        data-schedule-id="{{ $schedule->id }}"
                                        data-planned-date="{{ date('d/m/Y', strtotime($schedule->planned_date)) }}"
                                        data-planned-amount="{{ $schedule->planned_amount }}">
                                        <i class="fas fa-money-bill-wave me-1"></i> Disburse
                                    </button>
                                @endif
                            </td>
                        </tr>

                        <!-- Disburse Modal for each row -->
                        <div class="modal fade" id="disburseModal{{ $schedule->id }}" tabindex="-1"
                            aria-labelledby="disburseModalLabel{{ $schedule->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="disburseModalLabel{{ $schedule->id }}">
                                            <i class="fas fa-money-bill-wave me-2"></i>
                                            Disburse Installment {{ $schedule->installment_no }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.disbursement.store') }}" method="POST" id="disburseForm{{ $schedule->id }}">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="disbursement_schedule_id" value="{{ $schedule->id }}">

                                            <!-- Planned Amount Display -->
                                            <div class="mb-3">
                                                <label class="form-label">Planned Amount</label>
                                                <div class="amount-display">
                                                    ₹{{ number_format($schedule->planned_amount, 2) }}
                                                </div>
                                            </div>

                                            <div class="row g-3">
                                                <!-- Disbursement Date -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Disbursement Date <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="disbursement_date"
                                                        value="{{ date('Y-m-d') }}" required>
                                                </div>

                                                <!-- Amount -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Amount <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="amount"
                                                        value="{{ $schedule->planned_amount }}"
                                                        step="0.01" min="0" max="{{ $schedule->planned_amount }}" required>
                                                    <small class="text-muted">Max: ₹{{ number_format($schedule->planned_amount, 2) }}</small>
                                                </div>

                                                <!-- Source Bank Account -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Source Bank Account <span class="text-danger">*</span></label>
                                                    <select class="form-select" name="jito_jeap_bank_id" required>
                                                        <option value="">Select Bank Account</option>
                                                        @foreach($bankAccounts as $bank)
                                                            <option value="{{ $bank->id }}">
                                                                {{ $bank->bank_name }} - {{ $bank->account_number }} ({{ $bank->account_name }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- UTR Number -->
                                                <div class="col-md-6">
                                                    <label class="form-label">UTR Number <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="utr_number"
                                                        placeholder="Enter UTR Number" required>
                                                </div>

                                                <!-- Remarks -->
                                                <div class="col-12">
                                                    <label class="form-label">Remarks (Optional)</label>
                                                    <textarea class="form-control" name="remarks" rows="3"
                                                        placeholder="Enter any additional remarks"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-1"></i> Cancel
                                            </button>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-check me-1"></i> Confirm Disbursement
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- AJAX handling for form submission -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('summernotes/summernote-lite.min.js') }}"></script>
<script>
$(document).ready(function() {
    $('textarea:not([readonly]):not([disabled]):not(.swal2-textarea)').each(function() {
        const $textarea = $(this);
        if ($textarea.next('.note-editor').length) {
            return;
        }

        $textarea.summernote({
            height: 140,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['codeview']]
            ]
        });
    });

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
    // Handle disbursement form submissions using event delegation
    document.addEventListener('submit', function(e) {
        if (e.target.id && e.target.id.startsWith('disburseForm')) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const modalId = form.id.replace('Form', 'Modal');

            // Store original button content
            const originalText = submitBtn ? submitBtn.innerHTML : 'Submit';

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processing...';
            }

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('CSRF token not found');
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'CSRF token not found. Please refresh the page.'
                });
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
                return;
            }

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                }
            })
            .then(response => {
                console.log('Response status:', response.status);

                // Get response text first to debug
                return response.text().then(text => {
                    console.log('Response text:', text);

                    // Try to parse as JSON
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('JSON parse error:', e);
                        // If it's not JSON but response is OK, treat as success
                        if (response.ok) {
                            return { success: true, message: 'Disbursement recorded successfully' };
                        }
                        throw new Error('Invalid JSON response: ' + text.substring(0, 200));
                    }
                });
            })
            .then(data => {
                console.log('Response data:', data);

                if (data.success) {
                    // Close modal
                    const modalElement = document.getElementById(modalId);
                    if (modalElement) {
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        if (modal) {
                            modal.hide();
                        } else {
                            // Try to hide using jQuery or vanilla JS
                            modalElement.style.display = 'none';
                            modalElement.classList.remove('show');
                            document.body.classList.remove('modal-open');
                            const backdrop = document.querySelector('.modal-backdrop');
                            if (backdrop) {
                                backdrop.remove();
                            }
                        }
                    }

                    // Show success message with longer delay
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message || 'Disbursement recorded successfully',
                        timer: 2500,
                        showConfirmButton: false
                    }).then(() => {
                        // Force complete page reload to get fresh data
                        window.location.href = window.location.href;
                    });
                } else {
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Something went wrong'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);

                // Still reload page on error since disbursement might have been stored
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: error.message + '. If the disbursement was stored, the page will reload.',
                    timer: 3000,
                    showConfirmButton: true
                }).then(() => {
                    window.location.reload();
                });
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            });
        }
    });
});
</script>
@endsection
