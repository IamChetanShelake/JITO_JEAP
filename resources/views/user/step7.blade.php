@extends('user.layout.master')
@section('content')
    <style>
        .section-divider {
            height: 1px;
            background: #e9ecef;
            margin: 30px 0;
        }
    </style>
    <!-- Main Content -->
    <div class="col-lg-9 main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card form-card">
                        <div class="card-body">
                            <div class="step-card">
                                <div class="card-icon">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div>
                                    <h3 class="card-title">Application Complete</h3>
                                    <p class="card-subtitle">Your loan application has been submitted successfully</p>
                                </div>
                            </div>

                            <div class="alert alert-success mt-4">
                                <h5>Thank you for your application!</h5>
                                <p>Your documents and information have been submitted. You will be notified regarding the
                                    approval process.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
