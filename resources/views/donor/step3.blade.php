@extends('donor.layout.master')

@section('step')
    <button class="btn btn-purple me-2" style="background-color:#393185;color:white;">
        Step 3 of 8
    </button>
@endsection

@section('content')
    <div class="col-lg-9 main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <form method="POST" action="{{ route('donor.step3.store') }}">
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


                        <!-- NOMINEE DETAILS -->
                        <h4 class="mb-4 text-center">Nominee Details</h4>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label>Title *</label>
                                <select name="nominee_title" class="form-control" required>
                                    <option value="" disabled
                                        {{ old('nominee_title', $nomineeDetail->nominee_title ?? '') === '' ? 'selected' : '' }}>
                                        Select</option>
                                    <option value="Mr"
                                        {{ old('nominee_title', $nomineeDetail->nominee_title ?? '') === 'Mr' ? 'selected' : '' }}>
                                        Mr</option>
                                    <option value="Mrs"
                                        {{ old('nominee_title', $nomineeDetail->nominee_title ?? '') === 'Mrs' ? 'selected' : '' }}>
                                        Mrs</option>
                                    <option value="Miss"
                                        {{ old('nominee_title', $nomineeDetail->nominee_title ?? '') === 'Miss' ? 'selected' : '' }}>
                                        Miss</option>
                                    <option value="Ms"
                                        {{ old('nominee_title', $nomineeDetail->nominee_title ?? '') === 'Ms' ? 'selected' : '' }}>
                                        Ms</option>
                                </select>
                                @error('nominee_title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-9">
                                <label>Nominee Name *</label>
                                <input type="text" name="nominee_name" class="form-control"
                                    placeholder="Enter nominee name" required
                                    value="{{ old('nominee_name', $nomineeDetail->nominee_name ?? '') }}">
                                @error('nominee_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Relationship with Member *</label>
                                <input type="text" name="nominee_relationship" class="form-control"
                                    placeholder="Enter relationship with member" required
                                    value="{{ old('nominee_relationship', $nomineeDetail->nominee_relationship ?? '') }}">
                                @error('nominee_relationship')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label>Mobile No *</label>
                                <input type="text" name="nominee_mobile" class="form-control" maxlength="10"
                                    placeholder="Enter 10-digit mobile number" required
                                    value="{{ old('nominee_mobile', $nomineeDetail->nominee_mobile ?? '') }}">
                                @error('nominee_mobile')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>Address *</label>
                                <textarea name="nominee_address" class="form-control" rows="2" placeholder="Enter nominee address"
                                    required>{{ old('nominee_address', $nomineeDetail->nominee_address ?? '') }}</textarea>
                                @error('nominee_address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>City *</label>
                                <input type="text" name="nominee_city" class="form-control" placeholder="Enter city"
                                    required
                                    value="{{ old('nominee_city', $nomineeDetail->nominee_city ?? '') }}">
                                @error('nominee_city')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label>Pin Code *</label>
                                <input type="text" name="nominee_pincode" class="form-control" maxlength="6"
                                    placeholder="Enter 6-digit pin code" required
                                    value="{{ old('nominee_pincode', $nomineeDetail->nominee_pincode ?? '') }}">
                                @error('nominee_pincode')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                </div>
            </div>

            <!-- BUTTONS -->
            <div class="d-flex justify-content-between mt-4 mb-4">
                <a href="{{ route('donor.step2') }}" class="btn" style="background:#988DFF1F;color:gray;">
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

<script>
    function toggleJito(show) {
        document.getElementById('jito_uid_box').style.display = show ? 'block' : 'none';
    }

    document.getElementById('kids_count').addEventListener('input', function() {
        let count = parseInt(this.value) || 0;
        let box = document.getElementById('kids_container');
        box.innerHTML = '';

        for (let i = 1; i <= count; i++) {
            box.innerHTML += `
        <div class="card mb-3">
            <div class="card-body">
                <h6>Child ${i}</h6>
                <div class="row">
                    <div class="col-md-4">
                        <input name="child_name[]" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="col-md-4">
                        <select name="child_gender[]" class="form-control" required>
                            <option value="">Gender</option>
                            <option>Male</option><option>Female</option><option>Other</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="child_dob[]" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>`;
        }
    });
</script>
