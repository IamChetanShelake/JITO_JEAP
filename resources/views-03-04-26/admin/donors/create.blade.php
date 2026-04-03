@extends('admin.layouts.master')

@section('title', 'Add Donor - JitoJeap Admin')

@section('content')
    <div class="container">
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title"><i class="fas fa-plus me-2"></i> Add Donor</h1>
                <p class="dashboard-subtitle">Create new donor account</p>
            </div>
            <a href="{{ route('admin.donors.index') }}" class="btn btn-secondary">Back</a>
        </div>

        <div class="section-card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.donors.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Donor Type <span class="text-danger">*</span></label>
                        <select name="donor_type" class="form-control" id="donorTypeSelect" required>
                            <option value="member"
                                {{ (isset($donorType) && $donorType == 'member') || old('donor_type') == 'member' ? 'selected' : '' }}>
                                Member
                                Donor</option>
                            <option value="general"
                                {{ (isset($donorType) && $donorType == 'general') || old('donor_type') == 'general' ? 'selected' : '' }}>
                                General Donor
                            </option>
                        </select>
                        <small class="text-muted">
                            <strong>Member Donor:</strong> Can login, has access to membership forms<br>
                            <strong>General Donor:</strong> Cannot login, simplified form
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Membership Number</label>
                        <input type="number" name="membership_number" class="form-control" value="{{ old('membership_number') }}">
                        @error('membership_number') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password fields - only shown for Member donors -->
                    <div id="passwordFields">
                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" id="passwordInput">
                            <small class="text-muted">Required for member donors to login</small>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control"
                                id="confirmPasswordInput">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success-custom">Create Donor</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const donorTypeSelect = document.getElementById('donorTypeSelect');
            const passwordFields = document.getElementById('passwordFields');
            const passwordInput = document.getElementById('passwordInput');
            const confirmPasswordInput = document.getElementById('confirmPasswordInput');

            function togglePasswordFields() {
                if (donorTypeSelect.value === 'general') {
                    passwordFields.style.display = 'none';
                    passwordInput.removeAttribute('required');
                    confirmPasswordInput.removeAttribute('required');
                    passwordInput.value = '';
                    confirmPasswordInput.value = '';
                } else {
                    passwordFields.style.display = 'block';
                    passwordInput.setAttribute('required', 'required');
                    confirmPasswordInput.setAttribute('required', 'required');
                }
            }

            donorTypeSelect.addEventListener('change', togglePasswordFields);
            togglePasswordFields(); // Initial state
        });
    </script>
@endsection
