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
                                        <h3 class="card-title">Step 8: PDC/Cheque Details</h3>
                                        <p class="card-subtitle">Upload your first cheque and add all cheque details for the
                                            financial assistance.</p>
                                    </div>
                                </div>

                                <div style="margin-top: 30px; padding: 0 20px;">
                                    <!-- First Cheque Image Section -->
                                    <div class="card mb-4" style="border: 2px solid #393185; border-radius: 15px;">
                                        <div class="card-header bg-primary text-white"
                                            style="border-radius: 13px 13px 0 0; background-color: #393185 !important;">
                                            <h5 class="mb-0">First Cheque Image (Mandatory)</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="first_cheque_image" class="form-label"
                                                    style="font-weight: 600; color: #393185;">Upload First Cheque Image
                                                    *</label>
                                                <input type="file"
                                                    class="form-control @error('first_cheque_image') is-invalid @enderror"
                                                    id="first_cheque_image" name="first_cheque_image" accept="image/*,.pdf"
                                                    required
                                                    style="border: 2px solid #393185; border-radius: 10px;">
                                                @error('first_cheque_image')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Upload a clear image of the first cheque (JPEG, PNG, JPG) or PDF file</small>
                                            </div>

                                            @if (isset($pdcDetail->first_cheque_image) && $pdcDetail->first_cheque_image)
                                                <div class="mt-3">
                                                    <label class="form-label"
                                                        style="font-weight: 600; color: #393185;">Current Uploaded
                                                        File:</label>
                                                    <br>
                                                    @php
                                                        $fileExtension = strtolower(pathinfo($pdcDetail->first_cheque_image, PATHINFO_EXTENSION));
                                                    @endphp
                                                    @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                        <img src="{{ asset($pdcDetail->first_cheque_image) }}" alt="First Cheque"
                                                            style="max-width: 300px; max-height: 200px; border-radius: 10px; border: 2px solid #393185;">
                                                    @elseif($fileExtension == 'pdf')
                                                        <a href="{{ asset($pdcDetail->first_cheque_image) }}" target="_blank"
                                                            class="btn btn-primary"
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

                                    <!-- Cheque Details Table -->
                                    <div class="card mb-4" style="border: 2px solid #393185; border-radius: 15px;">
                                        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center"
                                            style="border-radius: 13px 13px 0 0; background-color: #393185 !important;">
                                            <h5 class="mb-0">Cheque Details Table</h5>
                                            <button type="button" class="btn btn-light btn-sm" id="addRowBtn"
                                                style="border-radius: 8px; font-weight: 600;">
                                                + Add Row
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div id="chequeRows">
                                                <!-- Cheque rows will be added here dynamically -->
                                            </div>

                                            @error('cheque_details')
                                                <div class="text-danger mb-3">{{ $message }}</div>
                                            @enderror
                                            @error('cheque_details.*')
                                                <div class="text-danger mb-3">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
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
                                style="background: #F0FDF4; color: #009846; border: 2px solid #009846; border-radius: 10px; font-weight: 600;">
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

            // Get existing cheque details if available
            let existingCheques = [];
            @if (isset($pdcDetail->cheque_details) && $pdcDetail->cheque_details)
                existingCheques = {!! $pdcDetail->cheque_details !!};
            @endif

            // Function to create a cheque row
            function createChequeRow(index, data = null) {
                const rowDiv = document.createElement('div');
                rowDiv.className = 'cheque-row';
                rowDiv.dataset.rowIndex = index;
                rowDiv.style.cssText = 'background: #f8f9fa; padding: 15px; margin-bottom: 15px; border-radius: 10px; border: 2px solid #dee2e6;';

                const chequeDate = data ? data.cheque_date : '';
                const amount = data ? data.amount : '';
                const bankName = data ? data.bank_name : '';
                const ifsc = data ? data.ifsc : '';
                const accountNumber = data ? data.account_number : '';
                const chequeNumber = data ? data.cheque_number : '';

                rowDiv.innerHTML = `
                    <div class="row" style="gap: 10px;">
                        <div class="col-md-2 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #393185;">Cheque Date *</label>
                            <input type="date" class="form-control"
                                   name="cheque_details[${index}][cheque_date]" value="${chequeDate}" required
                                   style="border: 2px solid #393185; border-radius: 10px;">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #393185;">Amount (₹) *</label>
                            <input type="number" class="form-control"
                                   name="cheque_details[${index}][amount]" value="${amount}" step="0.01" min="0" required
                                   style="border: 2px solid #393185; border-radius: 10px;">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #393185;">Bank Name *</label>
                            <input type="text" class="form-control"
                                   name="cheque_details[${index}][bank_name]" value="${bankName}" placeholder="Enter bank name" required
                                   style="border: 2px solid #393185; border-radius: 10px;">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #393185;">IFSC Code *</label>
                            <input type="text" class="form-control"
                                   name="cheque_details[${index}][ifsc]" value="${ifsc}" placeholder="e.g., SBIN0001234" required
                                   style="border: 2px solid #393185; border-radius: 10px;">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #393185;">Account Number *</label>
                            <input type="text" class="form-control"
                                   name="cheque_details[${index}][account_number]" value="${accountNumber}" placeholder="Enter account number" required
                                   style="border: 2px solid #393185; border-radius: 10px;">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #393185;">Cheque Number *</label>
                            <input type="text" class="form-control"
                                   name="cheque_details[${index}][cheque_number]" value="${chequeNumber}" placeholder="Enter cheque number" required
                                   style="border: 2px solid #393185; border-radius: 10px;">
                        </div>
                        ${index > 0 ? `
                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"
                                    style="border-radius: 8px;">Remove</button>
                            </div>
                        ` : ''}
                    </div>
                `;

                return rowDiv;
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
                });
            }
        });
    </script>
@endsection
