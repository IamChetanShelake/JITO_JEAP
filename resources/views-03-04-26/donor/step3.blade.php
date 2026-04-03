@extends('donor.layout.master')

@section('step')
    <button class="btn btn-purple me-2" style="background-color:#393185;color:white;">
        Step 3 of 8
    </button>
@endsection

@section('content')
    <!-- CSS Class for Title Case Visual -->
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
                                <input type="text" name="nominee_name" class="form-control ucwords"
                                    placeholder="Enter nominee name" required
                                    value="{{ old('nominee_name', $nomineeDetail->nominee_name ?? '') }}">
                                @error('nominee_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Relationship with Member Field -->
                            <div class="col-md-6">
                                <label>Relationship with Member *</label>
                                
                                <!-- Hidden input to hold the actual value sent to the server -->
                                <input type="hidden" name="nominee_relationship" id="nominee_relationship_hidden" value="{{ old('nominee_relationship', $nomineeDetail->nominee_relationship ?? '') }}">

                                <!-- Dropdown Select -->
                               <select id="nominee_relationship_select" class="form-control" name="nominee_relationship" required>
    <option value="">Select Relationship</option>

    <option value="Mother"
        {{ old('nominee_relationship', $nomineeDetail->nominee_relationship ?? '') == 'Mother' ? 'selected' : '' }}>
        Mother
    </option>

    <option value="Father"
        {{ old('nominee_relationship', $nomineeDetail->nominee_relationship ?? '') == 'Father' ? 'selected' : '' }}>
        Father
    </option>

    <option value="Sister"
        {{ old('nominee_relationship', $nomineeDetail->nominee_relationship ?? '') == 'Sister' ? 'selected' : '' }}>
        Sister
    </option>

    <option value="Brother"
        {{ old('nominee_relationship', $nomineeDetail->nominee_relationship ?? '') == 'Brother' ? 'selected' : '' }}>
        Brother
    </option>

    <option value="Other"
        {{ old('nominee_relationship', $nomineeDetail->nominee_relationship ?? '') == 'Other' ? 'selected' : '' }}>
        Other
    </option>
</select>

                               
    
   
                                <!-- Textarea for 'Other' (Hidden by default) -->
                                <div id="other_relationship_div" class="mt-2" style="display: none;">
                                    <textarea id="nominee_relationship_other" class="form-control ucwords" rows="1" 
                                        placeholder="Please specify relationship"></textarea>
                                </div>

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

    <!-- JAVASCRIPT MOVED INSIDE SECTION -->
    <script>
        // --- 1. Title Case Auto-Capitalization Logic ---
        function toTitleCase(str) {
            if (!str) return "";
            return str.toLowerCase().split(' ').map(function(word) {
                return (word.charAt(0).toUpperCase() + word.slice(1));
            }).join(' ');
        }

        // Use event delegation to handle blur for inputs
        document.addEventListener('blur', function(e) {
            if (e.target.classList.contains('ucwords')) {
                e.target.value = toTitleCase(e.target.value);
                
                // SPECIAL: If this is the 'Other' relationship field, update the hidden input too
                if (e.target.id === 'nominee_relationship_other') {
                    document.getElementById('nominee_relationship_hidden').value = e.target.value;
                }
            }
        }, true);


        // --- 2. Handle Relationship Dropdown Logic ---
        const relSelect = document.getElementById('nominee_relationship_select');
        const relOtherDiv = document.getElementById('other_relationship_div');
        const relOtherText = document.getElementById('nominee_relationship_other');
        const relHidden = document.getElementById('nominee_relationship_hidden');
        
        const standardOptions = ['Mother', 'Father', 'Sister', 'Brother'];

        // Function to set initial state on page load (important for validation errors)
        function initRelationship() {
            const currentVal = relHidden.value;
            
            if (standardOptions.includes(currentVal)) {
                // It is a standard option
                relSelect.value = currentVal;
                relOtherDiv.style.display = 'none';
            } else if (currentVal) {
                // It is a custom value (Other)
                relSelect.value = 'Other';
                relOtherText.value = currentVal;
                relOtherDiv.style.display = 'block';
            } else {
                // Default state
                relSelect.value = "";
                relOtherDiv.style.display = 'none';
            }
        }

        // Run on load
        initRelationship();

        // Handle dropdown change
        relSelect.addEventListener('change', function() {
            if (this.value === 'Other') {
                relOtherDiv.style.display = 'block';
                // Clear the hidden value temporarily so user must type something new
                // Or keep old value:
                relHidden.value = relOtherText.value; 
                // Focus on the text area
                relOtherText.focus();
            } else {
                relOtherDiv.style.display = 'none';
                relOtherText.value = ''; // Clear the other text
                relHidden.value = this.value; // Set hidden value to selected option
            }
        });

        // Handle typing in the 'Other' field (updates hidden input live)
        relOtherText.addEventListener('input', function() {
            relHidden.value = this.value;
        });
    
    
document.addEventListener("DOMContentLoaded", function () {

    const select = document.getElementById("nominee_relationship_select");
    const otherDiv = document.getElementById("other_relationship_div");
    const otherInput = document.getElementById("nominee_relationship_other");

    function toggleOtherField() {
        if (select.value === "Other") {
            otherDiv.style.display = "block";
            otherInput.setAttribute("name", "nominee_relationship");
            select.removeAttribute("name");
        } else {
            otherDiv.style.display = "none";
            select.setAttribute("name", "nominee_relationship");
            otherInput.removeAttribute("name");
        }
    }

    select.addEventListener("change", toggleOtherField);

    toggleOtherField(); // run on page load

});
</script>
@endsection