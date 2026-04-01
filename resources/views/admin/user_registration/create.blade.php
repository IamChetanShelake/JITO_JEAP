@extends('admin.layouts.master')

@section('title', 'User Registration')

@section('content')
    <div class="section-card">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
            <span>Admin Registered Users</span>
            <button type="button" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#userRegistrationModal">
                User Registration
            </button>
        </div>
        <div class="card-body">
            @if (($adminRegisteredUsers ?? collect())->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>PAN</th>
                                <th>Email</th>
                                <th>Registered At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adminRegisteredUsers as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name ?? 'N/A' }}</td>
                                    <td>{{ $user->pan_card ?? 'N/A' }}</td>
                                    <td>{{ $user->email ?? 'N/A' }}</td>
                                    <td>{{ optional($user->created_at)->format('d M Y, h:i A') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning mb-0">No users registered from admin yet.</div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="userRegistrationModal" tabindex="-1" aria-labelledby="userRegistrationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userRegistrationModalLabel">User Registration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.user-registration.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="pan_card">PAN Number</label>
                                <input type="text" class="form-control" id="pan_card" name="pan_card"
                                    value="{{ old('pan_card') }}" maxlength="10" style="text-transform: uppercase;"
                                    placeholder="ABCDE1234F" required>
                                <div class="form-text">Example: ABCDE1234F</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}" placeholder="user@example.com" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Minimum 8 characters" required>
                            </div>
                        </div>

                        <div class="mt-3 d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-danger-custom" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-custom">Verify PAN & Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = new bootstrap.Modal(document.getElementById('userRegistrationModal'));
                modal.show();
            });
        </script>
    @endif
@endsection
