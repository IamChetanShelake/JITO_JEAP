@extends('user.layout.master')
@section('step')
    <button class="btn btn-purple me-2" style="background-color: #393185; color: white;">Step 8 of
        8</button>
@endsection
@section('content')
    <!-- Main Content -->
    <div class="col-lg-9 main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('user.step8.store') }}" enctype="multipart/form-data">
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

                        <!-- Step Progress Indicator -->

                        <div class="card form-card">
                            <div class="card-body">
                                <div class="step-card">
                                    <div class="card-icon">
                                        <i class="bi bi-credit-card-2-front"></i>
                                    </div>
                                    <div>
                                        <h3 class="card-title"> PDC/Cheque Details</h3>
                                        <p class="card-subtitle">Upload your first cheque and add all cheque details for the
                                            financial assistance.</p>
                                    </div>
                                </div>

                                <!-- Send Back for Correction Notice -->
                                @if (isset($user->workflowStatus) &&
                                        $user->workflowStatus->apex_2_status === 'rejected' &&
                                        $user->workflowStatus->apex_2_reject_remarks)
                                    <div class="alert alert-danger"
                                        style="border: 2px solid #dc3545; border-radius: 10px; background-color: #f8d7da; margin-top: 20px;">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-exclamation-triangle me-2"
                                                style="font-size: 1.2rem; color: #dc3545;"></i>
                                            <div>
                                                <h5 class="mb-1" style="color: #721c24; font-weight: 600;">Application
                                                    Send Back for Correction</h5>
                                                <p class="mb-0" style="color: #721c24; font-size: 14px;">
                                                    <strong>Remarks:</strong>
                                                    {!! $user->workflowStatus->apex_2_reject_remarks !!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                                <!-- Important Note Section -->
                                <div class="alert alert-info"
                                    style="border: 2px solid #FBBA00; border-radius: 10px; background-color: #FEF6E0; margin-top: 20px;">
                                    <p class="mb-0" style="color: #E31E24; font-size: 15px;font-weight: 500;">
                                        <strong>NOTE:</strong> Please fill in the Post Dated Cheque (PDC) details below.
                                        Once completed, kindly submit the form. If the required details are not provided,
                                        there may be a delay of 10 to 15 days in the disbursement process.
                                </div>

                                <div style="margin-top: 30px; padding: 0 20px;">
                                    <!-- First Cheque Image Section -->
                                    <div class="card mb-4" style="border: 2px solid #393185; border-radius: 15px;">
                                        <div class="card-header bg-primary text-white"
                                            style="border-radius: 13px 13px 0 0; background-color: #393185 !important;">
                                            <h5 class="mb-0">First Cheque Image (Mandatory)</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class=" col-6  mb-3">
                                                    <label for="first_cheque_image" class="form-label"
                                                        style="font-weight: 600; color: #393185;">
                                                        @if (isset($pdcDetail->first_cheque_image) && $pdcDetail->first_cheque_image)
                                                            Replace First Cheque Image (Optional)
                                                        @else
                                                            Upload First Cheque Image *
                                                        @endif
                                                    </label>
                                                    <input type="file"
                                                        class="form-control @error('first_cheque_image') is-invalid @enderror"
                                                        id="first_cheque_image" name="first_cheque_image"
                                                        accept="image/*,.pdf"
                                                        @if (!isset($pdcDetail->first_cheque_image) || !$pdcDetail->first_cheque_image) required @endif
                                                        style="border: 2px solid #393185; border-radius: 10px;">
                                                    @error('first_cheque_image')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                    <small class="text-muted">
                                                        @if (isset($pdcDetail->first_cheque_image) && $pdcDetail->first_cheque_image)
                                                            Upload a new image to replace the existing one, or leave empty
                                                            to
                                                            keep current image.
                                                        @else
                                                            Upload a clear image of the first cheque (JPEG, PNG, JPG) or PDF
                                                            file.
                                                        @endif
                                                    </small>
                                                </div>

                                                @if (isset($pdcDetail->first_cheque_image) && $pdcDetail->first_cheque_image)
                                                    <div class=" col-6 mt-3">
                                                        <label class="form-label"
                                                            style="font-weight: 600; color: #393185;">Current Uploaded
                                                            File:</label>
                                                        <br>
                                                        @php
                                                            $fileExtension = strtolower(
                                                                pathinfo(
                                                                    $pdcDetail->first_cheque_image,
                                                                    PATHINFO_EXTENSION,
                                                                ),
                                                            );
                                                        @endphp
                                                        @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                            <img src="{{ asset($pdcDetail->first_cheque_image) }}"
                                                                alt="First Cheque"
                                                                style="max-width: 300px; max-height: 200px; border-radius: 10px; border: 2px solid #393185;">
                                                        @elseif($fileExtension == 'pdf')
                                                            <a href="{{ asset($pdcDetail->first_cheque_image) }}"
                                                                target="_blank" class="btn btn-primary"
                                                                style="background-color: #393185; border: 2px solid #393185; border-radius: 10px; font-weight: 600;">
                                                                <i class="bi bi-file-earmark-pdf"></i> View PDF
                                                            </a>
                                                        @else
                                                            <span class="text-muted">Unsupported file format</span>
                                                        @endif


                                                    </div>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="alert alert-info "
                                            style="border: 2px solid #FBBA00; border-radius: 10px; background-color: #FEF6E0; margin-top: 20px; margin:0 20px 10px;">
                                            <p class="mb-0" style="color: #E31E24; font-size: 15px;font-weight: 500;">
                                                (Please upload the same PDC scanned 1st cheque copy here which
                                                you are submitting to JEAP)
                                        </div>

                                    </div>

                                    <!-- Cheque Details Table -->
                                    {{-- <div class="card mb-4" style="border: 2px solid #393185; border-radius: 15px;"> --}}
                                    <hr>

                                    <!-- Amount Mismatch Error Message -->
                                    @if (isset($user->workingCommitteeApproval) && $user->workingCommitteeApproval->approval_financial_assistance_amount)
                                        <div id="amountMismatchAlert" class="alert alert-danger d-none"
                                            style="border: 2px solid #dc3545; border-radius: 10px; background-color: #f8d7da; margin-top: 20px;">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-exclamation-circle me-2"
                                                    style="font-size: 1.2rem; color: #dc3545;"></i>
                                                <div>
                                                    <h5 class="mb-1" style="color: #721c24; font-weight: 600;">Validation Error</h5>
                                                    <p class="mb-0" style="color: #721c24; font-size: 14px;">
                                                        Total cheque amount must match the approved financial assistance amount exactly.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="   d-flex justify-content-between align-items-center"
                                        style="border-radius: 13px 13px 0 0; background-color: none !important; color:#393185">
                                        <h4 class="mb-0" style="font-weight: 600;">Cheque Details Table</h4>
                                        <button type="button" class="btn btn-sm" id="addRowBtn"
                                            style="border-radius: 8px;background:#393185; color:white; font-weight: 600;">
                                            + Add Row
                                        </button>
                                    </div>
                                    {{-- <div class="card-body"> --}}
                                    <div class="table-responsive mt-4"
                                        style="max-height: 500px; overflow-y: auto; overflow-x: auto;">
                                        <table class="table table-bordered table-striped" id="chequeTable"
                                            style="min-width: 1200px;">
                                            <thead class="table-dark"
                                                style="background-color: #393185 !important; position: sticky; top: 0; z-index: 10;">
                                                <tr>
                                                    <th scope="col"
                                                        style="width: 5%; background-color: #393185; color: white; font-weight: 700;">
                                                        Sr. No</th>
                                                    <th scope="col"
                                                        style="width: 20%; background-color: #393185; color: white; font-weight: 700;">
                                                        If Parents Jnt A/C Name</th>
                                                    <th scope="col"
                                                        style="width: 10%; background-color: #393185; color: white; font-weight: 700;">
                                                        Repayment Date</th>
                                                    <th scope="col"
                                                        style="width: 15%; background-color: #393185; color: white; font-weight: 700;">
                                                        Amount (₹)</th>
                                                    <th scope="col"
                                                        style="width: 20%; background-color: #393185; color: white; font-weight: 700;">
                                                        Bank Name</th>
                                                    <th scope="col"
                                                        style="width: 20%; background-color: #393185; color: white; font-weight: 700;">
                                                        Bank IFSC Code</th>
                                                    <th scope="col"
                                                        style="width: 25%; background-color: #393185; color: white; font-weight: 700;">
                                                        Account Number</th>
                                                    <th scope="col"
                                                        style="width: 12%; background-color: #393185; color: white; font-weight: 700;">
                                                        Cheque Number</th>
                                                    <th scope="col"
                                                        style="width: 10%; background-color: #393185; color: white; font-weight: 700;">
                                                        Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="chequeRows">
                                                <!-- Cheque rows will be added here dynamically -->
                                            </tbody>
                                        </table>
                                    </div>

                                    @error('cheque_details')
                                        <div class="text-danger mb-3">{{ $message }}</div>
                                    @enderror
                                    @error('cheque_details.*')
                                        <div class="text-danger mb-3">{{ $message }}</div>
                                    @enderror
                                    {{-- </div> --}}
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4 mb-4">
                            <a href="{{ route('user.step7') }}" class="btn"
                                style="background: #988DFF1F; color: #393185; border: 2px solid #393185; border-radius: 10px; font-weight: 600;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    stroke="#393185" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M15 18l-6-6 6-6" />
                                </svg>
                                Previous
                            </a>
                            <button type="submit" class="btn"
                                style="background: #F0FDF4; color: #009846; border: 2px solid #009846; border-radius: 10px; font-weight: 600;"
                                id="submitBtn">
                                <i class="bi bi-check-lg" style="color: green; font-size: 24px;"></i>
                                Save PDC Details
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chequeRowsContainer = document.getElementById('chequeRows');
            const addRowBtn = document.getElementById('addRowBtn');
            const totalCheques = {{ 1 }};

            // Get approval amount from PHP
            const approvalAmount =
            {{ $user->workingCommitteeApproval->approval_financial_assistance_amount ?? 0 }};
            const amountMismatchAlert = document.getElementById('amountMismatchAlert');
            const currentTotalSpan = document.getElementById('currentTotal');
            const differenceAmountSpan = document.getElementById('differenceAmount');

            // Get existing cheque details if available
            let existingCheques = [];
            @if (isset($pdcDetail->cheque_details) && $pdcDetail->cheque_details)
                existingCheques = {!! $pdcDetail->cheque_details !!};
            @endif

            // Function to format number as currency
            function formatCurrency(amount) {
                return '₹' + Number(amount).toLocaleString('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            // Function to calculate total and update alert (only for submission)
            function updateAmountAlert() {
                // Don't show alert during real-time input
                // Only show when form is submitted
                return;
            }

            // Function to create a cheque row
            function createChequeRow(index, data = null) {
                const row = document.createElement('tr');
                row.className = 'cheque-row';
                row.dataset.rowIndex = index;

                const chequeDate = data ? data.cheque_date : '';
                const amount = data ? data.amount : '';
                const bankName = data ? data.bank_name : '';
                const ifsc = data ? data.ifsc : '';
                const accountNumber = data ? data.account_number : '';
                const chequeNumber = data ? data.cheque_number : '';
                const parentsJntAcName = data ? data.parents_jnt_ac_name : '';

                row.innerHTML = `
                    <td class="align-middle">
                        <span class="sr-no">${index + 1}</span>
                    </td>
                    <td>
                        <input type="text" class="form-control"
                               name="cheque_details[${index}][parents_jnt_ac_name]" value="${parentsJntAcName}"
                               placeholder="${parentsJntAcName ? '' : 'Enter parents joint account name (Optional)'}"
                               style="border: 2px solid #393185; border-radius: 10px;width:220px !important;">
                    </td>
                    <td>
                        <input type="date" class="form-control"
                               name="cheque_details[${index}][cheque_date]" value="${chequeDate}" required
                               min="{{ date('Y-m-d') }}"
                               style="border: 2px solid #393185; border-radius: 10px; background-color: white;width:160px !important;">
                    </td>
                    <td>
                        <input type="number" class="form-control"
                               name="cheque_details[${index}][amount]" value="${amount}" step="0.01" min="0" required
                               style="border: 2px solid #393185; border-radius: 10px;width:120px !important;">
                    </td>
                    <td>
                        <input type="text" class="form-control"
                               name="cheque_details[${index}][bank_name]" value="${bankName}" placeholder="Enter bank name" required
                               style="border: 2px solid #393185; border-radius: 10px;width:180px !important;">
                    </td>
                    <td>
                        <input type="text" class="form-control"
                               name="cheque_details[${index}][ifsc]" value="${ifsc}" placeholder="e.g., SBIN0001234" required
                               style="border: 2px solid #393185; border-radius: 10px;width:150px !important;">
                    </td>
                    <td>
                        <input type="text" class="form-control"
                               name="cheque_details[${index}][account_number]" value="${accountNumber}" placeholder="Enter account number" required
                               style="border: 2px solid #393185; border-radius: 10px;width:170px !important;">
                    </td>
                    <td>
                        <input type="text" class="form-control"
                               name="cheque_details[${index}][cheque_number]" value="${chequeNumber}" placeholder="Enter cheque number" required
                               style="border: 2px solid #393185; border-radius: 10px;width:100px !important;">
                    </td>
                    <td class="text-center">
                        ${index > 0 ? `
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"
                                    style="border-radius: 8px; font-weight: 600;">
                                    Remove
                                </button>
                            ` : `
                                <span class="text-muted"></span>
                            `}
                    </td>
                `;

                // Add event listener for amount input to update alert
                const amountInput = row.querySelector('input[name*="[amount]"]');
                if (amountInput) {
                    amountInput.addEventListener('input', updateAmountAlert);
                }

                return row;
            }

            // Initialize with existing rows or default 11 rows
            if (existingCheques.length > 0) {
                existingCheques.forEach((cheque, index) => {
                    chequeRowsContainer.appendChild(createChequeRow(index, cheque));
                });
            } else {
                // Create default 11 rows
                for (let i = 0; i < totalCheques; i++) {
                    chequeRowsContainer.appendChild(createChequeRow(i));
                }
            }

            // Add row button functionality
            addRowBtn.addEventListener('click', function() {
                const currentRows = chequeRowsContainer.querySelectorAll('.cheque-row');
                const newIndex = currentRows.length;
                chequeRowsContainer.appendChild(createChequeRow(newIndex));
            });

            // Make removeRow globally accessible
            window.removeRow = function(button) {
                const row = button.closest('.cheque-row');
                row.remove();
                // Re-index remaining rows
                reindexRows();
                // Update amount alert after removing row
                updateAmountAlert();
            };

            function reindexRows() {
                const rows = chequeRowsContainer.querySelectorAll('.cheque-row');
                rows.forEach((row, index) => {
                    row.dataset.rowIndex = index;
                    row.querySelectorAll('input').forEach(input => {
                        const name = input.name;
                        const newName = name.replace(/\[\d+\]/, `[${index}]`);
                        input.name = newName;
                    });
                    // Update Sr. No
                    const srNoSpan = row.querySelector('.sr-no');
                    if (srNoSpan) {
                        srNoSpan.textContent = index + 1;
                    }
                });
            }

            // Initial calculation
            updateAmountAlert();

            // Form validation before submission
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');

            // Function to validate amounts before submission
            function validateAmounts() {
                // Always validate if approval amount exists
                if (!approvalAmount || approvalAmount <= 0) {
                    return true; // No validation needed if no approval amount
                }

                const rows = chequeRowsContainer.querySelectorAll('.cheque-row');
                let total = 0;

                rows.forEach(row => {
                    const amountInput = row.querySelector('input[name*="[amount]"]');
                    if (amountInput && amountInput.value) {
                        total += parseFloat(amountInput.value) || 0;
                    }
                });

                const isMatch = Math.abs(total - approvalAmount) < 0.01;
                return isMatch;
            }

            // Form submission validation
            form.addEventListener('submit', function(e) {
                const isValid = validateAmounts();

                if (!isValid) {
                    e.preventDefault(); // CRITICAL: Prevent form submission

                    // Show error message with user-friendly text
                    const requiredAmount = formatCurrency(approvalAmount);
                    const currentTotal = formatCurrency(total);

                    // Update alert content with user-friendly message
                    amountMismatchAlert.classList.remove('d-none');
                    currentTotalSpan.textContent = currentTotal;
                    differenceAmountSpan.textContent = formatCurrency(Math.abs(total - approvalAmount));

                    // Change alert to show error message
                    amountMismatchAlert.innerHTML = `
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2" style="font-size: 1.2rem; color: #FBBA00;"></i>
                            <div>
                                <h5 class="mb-1" style="color: #E31E24; font-weight: 600;">Amount Mismatch - Cannot Submit</h5>
                                <p class="mb-0" style="color: #E31E24; font-size: 14px;">
                                    <strong>Approved Amount:</strong> ${requiredAmount}<br>
                                    <strong>Current Total:</strong> ${currentTotal}<br>
                                    <strong>Difference:</strong> ${formatCurrency(Math.abs(total - approvalAmount))}<br><br>
                                    <strong>Form submission is blocked until amounts match exactly.</strong>
                                </p>
                            </div>
                        </div>
                    `;

                    // Scroll to alert
                    amountMismatchAlert.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    return false;
                }
            });

            // Also validate on button click
            submitBtn.addEventListener('click', function(e) {
                const isValid = validateAmounts();

                if (!isValid) {
                    e.preventDefault(); // Prevent submission

                    // Show error message
                    const rows = chequeRowsContainer.querySelectorAll('.cheque-row');
                    let total = 0;
                    rows.forEach(row => {
                        const amountInput = row.querySelector('input[name*="[amount]"]');
                        if (amountInput && amountInput.value) {
                            total += parseFloat(amountInput.value) || 0;
                        }
                    });

                    const requiredAmount = formatCurrency(approvalAmount);
                    const currentTotal = formatCurrency(total);

                    amountMismatchAlert.classList.remove('d-none');
                    currentTotalSpan.textContent = currentTotal;
                    differenceAmountSpan.textContent = formatCurrency(Math.abs(total - approvalAmount));

                    amountMismatchAlert.innerHTML = `
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2" style="font-size: 1.2rem; color: #FBBA00;"></i>
                            <div>
                                <h5 class="mb-1" style="color: #E31E24; font-weight: 600;">Amount Mismatch - Cannot Submit</h5>
                                <p class="mb-0" style="color: #E31E24; font-size: 14px;">
                                    <strong>Approved Amount:</strong> ${requiredAmount}<br>
                                    <strong>Current Total:</strong> ${currentTotal}<br>
                                    <strong>Difference:</strong> ${formatCurrency(Math.abs(total - approvalAmount))}<br><br>
                                    <strong>Form submission is blocked until amounts match exactly.</strong>
                                </p>
                            </div>
                        </div>
                    `;

                    amountMismatchAlert.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            });
        });
    </script>
@endsection
