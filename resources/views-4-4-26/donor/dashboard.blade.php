@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body py-5">
                    <h3 class="mb-3">Donor Dashboard</h3>
                    <p class="mb-4">Coming soon</p>
                    <form method="POST" action="{{ route('donor.logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
