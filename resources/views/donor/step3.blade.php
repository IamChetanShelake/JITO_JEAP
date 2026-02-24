@extends('donor.layout.master')

@section('step')
    <button class="btn btn-purple me-2" style="background-color:#393185;color:white;">
        Step 3 of 8
    </button>
@endsection

@section('content')
    <!-- CHANGE 1: CSS Class for Title Case Visual -->
    <style>
        .ucwords {
            text-transform: capitalize;
        }
    </style>

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
                                <!-- CHANGE 2: Added ucwords class -->
                                <input type="text" name="nominee_name" class="form-control ucwords"
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
                                <!-- CHANGE 2: Added ucwords class -->
                                <input type="text" name="nominee_relationship" class="form-control ucwords"
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
                                <!-- CHANGE 2: Added ucwords class -->
                                <textarea name="nominee_address" class="form-control ucwords" rows="2" placeholder="Enter nominee address"
                                    required>{{ old('nominee_address', $nomineeDetail->nominee_address ?? '') }}</textarea>
                                @error('nominee_address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>City *</label>
                                <!-- CHANGE 2: Added ucwords class -->
                                <input type="text" name="nominee_city" class="form-control ucwords" placeholder="Enter city"
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
    // --- CHANGE 3: Title Case Auto-Capitalization Logic ---
    function toTitleCase(str) {
        return str.toLowerCase().split(' ').map(function(word) {
            return (word.charAt(0).toUpperCase() + word.slice(1));
        }).join(' ');
    }

    // Use event delegation to handle blur for inputs
    document.addEventListener('blur', function(e) {
        // Check if the blurred element has the 'ucwords' class
        if (e.target.classList.contains('ucwords')) {
            e.target.value = toTitleCase(e.target.value);
        }
    }, true);
</script>