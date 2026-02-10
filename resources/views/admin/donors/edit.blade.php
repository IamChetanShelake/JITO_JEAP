@extends('admin.layouts.master')

@section('title', 'Edit Donor - JitoJeap Admin')

@section('content')
<div class="container">
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title"><i class="fas fa-edit me-2"></i> Edit Donor</h1>
            <p class="dashboard-subtitle">{{ $donor->name }}</p>
        </div>
        <a href="{{ route('admin.donors.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="section-card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.donors.update', $donor) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $donor->name) }}" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $donor->email) }}" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $donor->phone) }}">
                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">New Password (optional)</label>
                    <input type="password" name="password" class="form-control">
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-success-custom">Update Donor</button>
            </form>
        </div>
    </div>
</div>
@endsection
