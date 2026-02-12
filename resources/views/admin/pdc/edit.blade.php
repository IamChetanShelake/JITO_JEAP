@extends('admin.layouts.master')

@section('title', 'Edit PDC Details - JitoJeap Admin')

@section('styles')
    <style>
        :root {
            --primary-green: #4CAF50;
            --primary-purple: #393185;
            --primary-blue: #2196F3;
            --primary-yellow: #FFC107;
            --primary-red: #f44336;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --bg-light: #f8f9fa;
            --border-color: #e9ecef;
        }

        .page-header {
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .page-header {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-purple);
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
        }

        @media (min-width: 768px) {
            .page-title {
                font-size: 1.75rem;
            }
        }

        .back-btn {
            background-color: var(--primary-purple);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 2px 8px rgba(57, 49, 133, 0.3);
            width: 100%;
            font-size: 0.9rem;
        }

        @media (min-width: 768px) {
            .back-btn {
                width: auto;
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
            }
        }

        .back-btn:hover {
            background-color: #4a40a8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(57, 49, 133, 0.4);
        }

        .back-btn i {
            font-size: 0.9rem;
        }

        .user-info-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(57, 49, 133, 0.1);
        }

        .user-info-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-purple);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .user-details h3 {
            margin: 0;
            color: var(--text-dark);
            font-size: 1.25rem;
        }

        .user-details p {
            margin: 0.25rem 0;
            color: var(--text-light);
        }

        .form-data {
            background: white;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .data-group {
            border-bottom: 1px solid var(--border-color);
        }

        .data-group:last-child {
            border-bottom: none;
        }

        .data-group h4 {
            background: var(--primary-purple);
            color: white;
            margin: 0;
            padding: 1rem 1.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .form-section {
            padding: 1.5rem;
        }

        .form-row {
            display: flex;
            gap: 2rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .form-row:last-child {
            margin-bottom: 0;
        }

        .form-field {
            flex: 1;
            min-width: 250px;
        }

        .form-field-full {
            width: 100%;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input,
        .form-textarea,
        .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            font-size: 0.9rem;
            color: var(--text-dark);
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--primary-purple);
            background-color: white;
            box-shadow: 0 0 0 3px rgba(57, 49, 133, 0.1);
        }

        .form-input[readonly],
        .form-textarea[readonly],
        .form-select[readonly] {
            background-color: #f8f9fa;
            cursor: not-allowed;
            border-color: #dee2e6;
        }

        .form-textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-link {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .form-link:hover {
            color: var(--primary-purple);
            text-decoration: underline;
        }

        .form-image {
            max-width: 120px;
            max-height: 120px;
            border: 2px solid #dee2e6;
            border-radius: 6px;
            object-fit: cover;
        }

        .table-container {
            margin-top: 1rem;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .custom-table th,
        .custom-table td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .custom-table th {
            background-color: var(--bg-light);
            font-weight: 600;
            color: var(--text-dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.8rem;
        }

        .custom-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .amount-cell {
            font-weight: 600;
            color: var(--primary-green);
        }

        .status-cell {
            font-weight: 500;
        }

        .status-approved {
            color: var(--primary-green);
        }

        .status-pending {
            color: var(--primary-yellow);
        }

        .status-rejected {
            color: var(--primary-red);
        }

        .no-data {
            text-align: center;
            padding: 2rem;
            color: var(--text-light);
            font-style: italic;
        }

        .data-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .data-item:last-child {
            border-bottom: none;
        }

        .data-label {
            font-weight: 600;
            color: var(--text-dark);
            flex: 1;
        }

        .data-value {
            color: var(--text-light);
            flex: 1;
            text-align: right;
        }

        .cheque-form-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            padding: 1rem;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            background: #f8f9fa;
        }

        .cheque-form-row:last-child {
            margin-bottom: 0;
        }

        .cheque-form-field {
            flex: 1;
            /* min-width: 200px; */
        }

        .cheque-form-field input,
        .cheque-form-field select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .cheque-form-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            margin-top: 0.5rem;
        }

        .btn-add-cheque {
            background: var(--primary-green);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-add-cheque:hover {
            background: #45a049;
            transform: translateY(-1px);
        }

        .btn-remove-cheque {
            background: var(--primary-red);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-remove-cheque:hover {
            background: #d32f2f;
            transform: translateY(-1px);
        }

        .btn-submit {
            background: var(--primary-purple);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-submit:hover {
            background: #4a40a8;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(57, 49, 133, 0.4);
        }

        .btn-cancel {
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-cancel:hover {
            background: #1976d2;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(33, 150, 243, 0.4);
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        .current-image-preview {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-bottom: 1rem;
            padding: 1rem;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            background: #f8f9fa;
        }

        .current-image-preview img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
        }

        .image-upload-group {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .file-input-wrapper input[type=file] {
            position: absolute;
            left: -9999px;
        }

        .file-input-label {
            background: var(--primary-blue);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .file-input-label:hover {
            background: #1976d2;
            transform: translateY(-1px);
        }

        .file-name-display {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-left: 1rem;
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 1rem;
            }

            .cheque-form-row {
                flex-direction: column;
                gap: 0.5rem;
            }

            .form-actions {
                flex-direction: column;
                gap: 0.5rem;
            }

            .btn-submit,
            .btn-cancel {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-title-section">
            <h1 class="page-title">
                <i class="fas fa-edit" style="color: var(--primary-purple); margin-right: 0.5rem;"></i>
                Edit PDC/Cheque Details
            </h1>
            <p class="page-subtitle">Update cheque details for {{ $user->name }}</p>
        </div>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <a href="{{ route('admin.pdc.user.detail', $user) }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Details
            </a>
        </div>
    </div>

    <!-- User Info Card -->
    <div class="user-info-card">
        <div class="user-info-header">
            <div class="user-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="user-details">
                <h3>{{ $user->name }}</h3>
                <p>{{ $user->email }}</p>
                <p>{{ $user->mobile }}</p>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="form-data">
        <form action="{{ route('admin.pdc.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- First Cheque Image Section -->
            <div class="data-group">
                <h4>First Cheque Image</h4>
                <div class="form-section">
                    @if ($user->pdcDetail->first_cheque_image)
                        <div class="current-image-preview">
                            <img src="{{ asset($user->pdcDetail->first_cheque_image) }}" alt="Current Cheque Image"
                                class="form-image">
                            <div>
                                <p style="margin: 0; font-weight: 600; color: var(--text-dark);">Current Image</p>
                                <p style="margin: 0.25rem 0 0 0; color: var(--text-light); font-size: 0.9rem;">
                                    {{ basename($user->pdcDetail->first_cheque_image) }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="current-image-preview" style="border-color: #ffc107; background: #fff8e1;">
                            <i class="fas fa-image" style="font-size: 2rem; color: #ffc107;"></i>
                            <div>
                                <p style="margin: 0; font-weight: 600; color: var(--text-dark);">No Image Uploaded</p>
                                <p style="margin: 0.25rem 0 0 0; color: var(--text-light); font-size: 0.9rem;">
                                    Please upload a cheque image
                                </p>
                            </div>
                        </div>
                    @endif

                    <div class="image-upload-group">
                        <div class="file-input-wrapper">
                            <input type="file" id="first_cheque_image" name="first_cheque_image" accept="image/*">
                            <label for="first_cheque_image" class="file-input-label">
                                <i class="fas fa-upload"></i> Change Image
                            </label>
                        </div>
                        <span class="file-name-display" id="file-name-display">No file chosen</span>
                        <span style="color: var(--text-light); font-size: 0.85rem;">Max 2MB, JPG/PNG/GIF/WebP</span>
                    </div>
                </div>
            </div>

            <!-- Cheque Details Section -->
            <div class="data-group">
                <h4>Cheque Details</h4>
                <div class="form-section">
                    <div id="cheque-details-container">
                        @php
                            $chequeDetails = json_decode($user->pdcDetail->cheque_details, true);
                        @endphp

                        @if ($chequeDetails && count($chequeDetails) > 0)
                            @foreach ($chequeDetails as $index => $cheque)
                                <div class="cheque-form-row" data-cheque-index="{{ $index }}">
                                    <div class="cheque-form-field">
                                        <label class="form-label">Parents JNT A/C Name</label>
                                        <input type="text"
                                            name="cheque_details[{{ $index }}][parents_jnt_ac_name]"
                                            value="{{ $cheque['parents_jnt_ac_name'] ?? '' }}" required>
                                    </div>
                                    <div class="cheque-form-field">
                                        <label class="form-label">Cheque Date</label>
                                        <input type="date" name="cheque_details[{{ $index }}][cheque_date]"
                                            value="{{ $cheque['cheque_date'] ?? '' }}" required>
                                    </div>
                                    <div class="cheque-form-field">
                                        <label class="form-label">Amount (₹)</label>
                                        <input type="number" name="cheque_details[{{ $index }}][amount]"
                                            value="{{ $cheque['amount'] ?? '' }}" min="0" step="0.01" required>
                                    </div>
                                    <div class="cheque-form-field">
                                        <label class="form-label">Bank Name</label>
                                        <input type="text" name="cheque_details[{{ $index }}][bank_name]"
                                            value="{{ $cheque['bank_name'] ?? '' }}" required>
                                    </div>
                                    <div class="cheque-form-field">
                                        <label class="form-label">IFSC Code</label>
                                        <input type="text" name="cheque_details[{{ $index }}][ifsc]"
                                            value="{{ $cheque['ifsc'] ?? '' }}" required>
                                    </div>
                                    <div class="cheque-form-field">
                                        <label class="form-label">Account Number</label>
                                        <input type="text" name="cheque_details[{{ $index }}][account_number]"
                                            value="{{ $cheque['account_number'] ?? '' }}" required>
                                    </div>
                                    <div class="cheque-form-field">
                                        <label class="form-label">Cheque Number</label>
                                        <input type="text" name="cheque_details[{{ $index }}][cheque_number]"
                                            value="{{ $cheque['cheque_number'] ?? '' }}" required>
                                    </div>
                                    <div class="cheque-form-actions">
                                        @if ($loop->first)
                                            <button type="button" class="btn-add-cheque" onclick="addChequeRow()">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn-remove-cheque"
                                                onclick="removeChequeRow(this)">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="cheque-form-row" data-cheque-index="0">
                                <div class="cheque-form-field">
                                    <label class="form-label">Parents JNT A/C Name</label>
                                    <input type="text" name="cheque_details[0][parents_jnt_ac_name]" required>
                                </div>
                                <div class="cheque-form-field">
                                    <label class="form-label">Cheque Date</label>
                                    <input type="date" name="cheque_details[0][cheque_date]" required>
                                </div>
                                <div class="cheque-form-field">
                                    <label class="form-label">Amount (₹)</label>
                                    <input type="number" name="cheque_details[0][amount]" min="0" step="0.01"
                                        required>
                                </div>
                                <div class="cheque-form-field">
                                    <label class="form-label">Bank Name</label>
                                    <input type="text" name="cheque_details[0][bank_name]" required>
                                </div>
                                <div class="cheque-form-field">
                                    <label class="form-label">IFSC Code</label>
                                    <input type="text" name="cheque_details[0][ifsc]" required>
                                </div>
                                <div class="cheque-form-field">
                                    <label class="form-label">Account Number</label>
                                    <input type="text" name="cheque_details[0][account_number]" required>
                                </div>
                                <div class="cheque-form-field">
                                    <label class="form-label">Cheque Number</label>
                                    <input type="text" name="cheque_details[0][cheque_number]" required>
                                </div>
                                <div class="cheque-form-actions">
                                    <button type="button" class="btn-add-cheque" onclick="addChequeRow()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-section">
                <div class="form-actions">
                    <a href="{{ route('admin.pdc.user.detail', $user) }}" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Update PDC Details
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

<script>
    let chequeIndex = {{ $chequeDetails ? count($chequeDetails) : 1 }};

    function addChequeRow() {
        const container = document.getElementById('cheque-details-container');
        const newRow = document.createElement('div');
        newRow.className = 'cheque-form-row';
        newRow.setAttribute('data-cheque-index', chequeIndex);

        newRow.innerHTML = `
            <div class="cheque-form-field">
                <label class="form-label">Parents JNT A/C Name</label>
                <input type="text" name="cheque_details[${chequeIndex}][parents_jnt_ac_name]" required>
            </div>
            <div class="cheque-form-field">
                <label class="form-label">Cheque Date</label>
                <input type="date" name="cheque_details[${chequeIndex}][cheque_date]" required>
            </div>
            <div class="cheque-form-field">
                <label class="form-label">Amount (₹)</label>
                <input type="number" name="cheque_details[${chequeIndex}][amount]" min="0" step="0.01" required>
            </div>
            <div class="cheque-form-field">
                <label class="form-label">Bank Name</label>
                <input type="text" name="cheque_details[${chequeIndex}][bank_name]" required>
            </div>
            <div class="cheque-form-field">
                <label class="form-label">IFSC Code</label>
                <input type="text" name="cheque_details[${chequeIndex}][ifsc]" required>
            </div>
            <div class="cheque-form-field">
                <label class="form-label">Account Number</label>
                <input type="text" name="cheque_details[${chequeIndex}][account_number]" required>
            </div>
            <div class="cheque-form-field">
                <label class="form-label">Cheque Number</label>
                <input type="text" name="cheque_details[${chequeIndex}][cheque_number]" required>
            </div>
            <div class="cheque-form-actions">
                <button type="button" class="btn-remove-cheque" onclick="removeChequeRow(this)">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        `;

        container.appendChild(newRow);
        chequeIndex++;
    }

    function removeChequeRow(button) {
        const row = button.closest('.cheque-form-row');
        if (confirm('Are you sure you want to remove this cheque entry?')) {
            row.remove();
        }
    }

    // File upload preview
    document.getElementById('first_cheque_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileNameDisplay = document.getElementById('file-name-display');

        if (file) {
            fileNameDisplay.textContent = file.name;
            fileNameDisplay.style.color = 'var(--primary-green)';
        } else {
            fileNameDisplay.textContent = 'No file chosen';
            fileNameDisplay.style.color = 'var(--text-light)';
        }
    });
</script>
