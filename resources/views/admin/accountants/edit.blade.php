@extends('admin.layouts.master')

@section('title', 'Edit Accountant - JitoJeap Admin')

@section('content')
<div class="section-card">
    <div class="card-header">Edit Accountant</div>
    <div class="card-body">
        <form action="{{ route('admin.accountants.update', $accountant) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $accountant->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Designation</label>
                    <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation', $accountant->designation) }}">
                    @error('designation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $accountant->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Contact <span class="text-danger">*</span></label>
                    <input type="text" name="contact" class="form-control @error('contact') is-invalid @enderror" value="{{ old('contact', $accountant->contact) }}" required>
                    @error('contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Password (leave blank to keep same)</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label d-block">Status</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status" value="1" {{ old('status', $accountant->status) ? 'checked' : '' }}>
                        <label class="form-check-label">Active</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label d-block">Visibility</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="show_hide" value="1" {{ old('show_hide', $accountant->show_hide) ? 'checked' : '' }}>
                        <label class="form-check-label">Show</label>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-custom" type="submit">Update Accountant</button>
                <a href="{{ route('admin.accountants.index') }}" class="btn btn-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
