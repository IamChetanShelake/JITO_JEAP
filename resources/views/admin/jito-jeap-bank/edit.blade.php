@extends('admin.layouts.master')

@section('title', 'Edit Bank Details - JitoJeap Admin')

@section('styles')
    <style>
        .edit-header {
            background: linear-gradient(135deg, #393185, #5a4d9a);
            color: white;
            padding: 2rem;
            border-radius: 15px 15px 0 0;
            margin-bottom: 0;
        }

        .edit-header h1 {
            color: white;
            margin-bottom: 0.5rem;
            font-size: 1.75rem;
        }

        .edit-header .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
        }

        .edit-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }

        .edit-card-body {
            padding: 2rem;
        }

        .form-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #393185;
        }

        .form-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #393185;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .form-group {
            position: relative;
        }

        .form-label {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 0.5rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: #393185;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #393185;
            box-shadow: 0 0 0 3px rgba(57, 49, 133, 0.1);
        }

        .form-switch {
            padding-left: 2.5rem;
        }

        .form-switch .form-check-input {
            width: 2rem;
            height: 1rem;
            border-radius: 1rem;
        }

        .form-switch .form-check-input:checked {
            background-color: #393185;
            border-color: #393185;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e0e0e0;
        }

        .btn-custom {
            background: #393185;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background: #2a226a;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(57, 49, 133, 0.3);
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            border: 1px solid #e0e0e0;
        }

        .text-danger {
            color: #dc3545;
        }
    </style>
@endsection

@section('content')
    <div class="edit-card">
        <div class="edit-header">
            <h1><i class="fas fa-edit me-2"></i> Edit Bank Details</h1>
            <p class="subtitle">Update bank account information</p>
        </div>

        <div class="edit-card-body">
            <form action="{{ route('admin.jito-jeap-banks.update', $jitoJeapBank) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-info-circle"></i> Bank Account Information
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="account_name" class="form-label">
                                <i class="fas fa-user"></i> Account Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('account_name') is-invalid @enderror"
                                id="account_name" name="account_name"
                                value="{{ old('account_name', $jitoJeapBank->account_name) }}" required>
                            @error('account_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="bank_name" class="form-label">
                                <i class="fas fa-building"></i> Bank Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                                id="bank_name" name="bank_name" value="{{ old('bank_name', $jitoJeapBank->bank_name) }}"
                                required>
                            @error('bank_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="account_type" class="form-label">
                                <i class="fas fa-credit-card"></i> Account Type <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('account_type') is-invalid @enderror" id="account_type"
                                name="account_type" required>
                                <option value="">Select Account Type</option>
                                <option value="Savings"
                                    {{ old('account_type', $jitoJeapBank->account_type) == 'Savings' ? 'selected' : '' }}>
                                    Savings</option>
                                <option value="Current"
                                    {{ old('account_type', $jitoJeapBank->account_type) == 'Current' ? 'selected' : '' }}>
                                    Current</option>
                                <option value="Fixed Deposit"
                                    {{ old('account_type', $jitoJeapBank->account_type) == 'Fixed Deposit' ? 'selected' : '' }}>
                                    Fixed Deposit</option>
                                <option value="Cash Credit"
                                    {{ old('account_type', $jitoJeapBank->account_type) == 'Cash Credit' ? 'selected' : '' }}>
                                    Cash Credit</option>
                                <option value="Overdraft"
                                    {{ old('account_type', $jitoJeapBank->account_type) == 'Overdraft' ? 'selected' : '' }}>
                                    Overdraft</option>
                            </select>
                            @error('account_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="account_number" class="form-label">
                                <i class="fas fa-hashtag"></i> Account Number <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control @error('account_number') is-invalid @enderror"
                                id="account_number" name="account_number"
                                value="{{ old('account_number', $jitoJeapBank->account_number) }}" required>
                            @error('account_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="ifsc_code" class="form-label">
                                <i class="fas fa-code"></i> IFSC Code <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('ifsc_code') is-invalid @enderror"
                                id="ifsc_code" name="ifsc_code" value="{{ old('ifsc_code', $jitoJeapBank->ifsc_code) }}"
                                required>
                            @error('ifsc_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <button type="submit" class="btn-custom">
                        <i class="fas fa-save me-2"></i> Update Bank Details
                    </button>
                    <a href="{{ route('admin.jito-jeap-banks.index') }}" class="btn-secondary">
                        <i class="fas fa-times me-2"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
