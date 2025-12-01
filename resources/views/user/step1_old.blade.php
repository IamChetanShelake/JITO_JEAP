<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 1 - Personal Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-custom {
            background-color: white !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
        }

        .sidebar {
            background-color: #1e1b4b;
            color: white;
            height: calc(100vh - 76px);
            /* Adjust based on navbar height */
            position: fixed;
            top: 76px;
            /* Navbar height */
            left: 0;
            width: 250px;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        @media (max-width: 767.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }

        .sidebar .stepper {
            padding: 20px;
        }

        .stepper .step {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .stepper .step.active {
            background-color: rgba(254, 215, 102, 0.2);
        }

        .stepper .step.active i {
            color: #fed766;
        }

        .stepper .step i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 250px;
            margin-top: 76px;
            /* Navbar height */
            padding: 20px;
        }

        @media (max-width: 767.98px) {
            .main-content {
                margin-left: 0;
            }
        }

        .card-custom {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 10px;
        }

        .btn-purple {
            background-color: #4b2aad;
            border-color: #4b2aad;
            color: white;
        }

        .btn-purple:hover {
            background-color: #3a218e;
            border-color: #3a218e;
        }

        .form-container {
            max-width: 100%;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .upload-btn {
            background-color: transparent;
            border: 2px dashed #ccc;
            color: #666;
            padding: 40px;
            text-align: center;
            cursor: pointer;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .upload-btn:hover {
            border-color: #4b2aad;
            color: #4b2aad;
        }

        /* Mobile toggle */
        .sidebar-toggle {
            display: none;
            background-color: #1e1b4b;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
        }

        @media (max-width: 767.98px) {
            .sidebar-toggle {
                display: block;
            }
        }
    </style>
</head>

<body>
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom fixed-top">
        <div class="container-fluid">
            <button class="sidebar-toggle me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar"
                aria-controls="sidebar" aria-expanded="false" aria-label="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>
            <img src="/jitojeaplogo.png" alt="Logo" width="50" class="d-inline-block align-text-top me-3">
            <span class="navbar-text me-auto">Supporting Jain Students Educational Journey</span>
            <span class="badge bg-success ms-3">Above ₹1.00 Lacs</span>
            <div class="ms-3">
                <button class="btn btn-outline-secondary me-2">Step 1 of 7</button>
                <button class="btn btn-danger">Logout</button>
            </div>
        </div>
    </nav>

    <!-- Vertical Sidebar -->
    <div class="sidebar collapse" id="sidebar">
        <div class="stepper">
            <h5 class="mb-4">Application Progress</h5>
            <div class="step active">
                <i class="bi bi-person-circle"></i>
                <span>Step 1 – Personal Details</span>
            </div>
            <div class="step">
                <i class="bi bi-house-door"></i>
                <span>Step 2 – Family Details</span>
            </div>
            <div class="step">
                <i class="bi bi-mortarboard"></i>
                <span>Step 3 – Education Details</span>
            </div>
            <div class="step">
                <i class="bi bi-cash-coin"></i>
                <span>Step 4 – Funding Details</span>
            </div>
            <div class="step">
                <i class="bi bi-shield-check"></i>
                <span>Step 5 – Guarantor Details</span>
            </div>
            <div class="step">
                <i class="bi bi-file-earmark-text"></i>
                <span>Step 6 – Documents Upload</span>
            </div>
            <div class="step">
                <i class="bi bi-check-circle"></i>
                <span>Step 7 – Review & Submit</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card card-custom p-4">
                        <div class="card-body">
                            <h2 class="card-title text-center mb-2">Personal Details</h2>
                            <p class="text-muted text-center mb-4">Provide your correct details</p>
                            <form class="form-container">
                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="applicantName">Applicant’s Name *</label>
                                            <input type="text" class="form-control" id="applicantName" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="photoUpload">Add Photo</label>
                                            <div class="upload-btn"
                                                onclick="document.getElementById('photoInput').click()">
                                                <i class="bi bi-camera"></i><br>
                                                <span>Click to Upload</span>
                                                <input type="file" id="photoInput" accept="image/*"
                                                    style="display:none;">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="assetType">Financial Asset Type *</label>
                                            <select class="form-control" id="assetType" required>
                                                <option value="">Select</option>
                                                <option value="type1">Type 1</option>
                                                <option value="type2">Type 2</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="assetFor">Financial Asset For *</label>
                                            <select class="form-control" id="assetFor" required>
                                                <option value="">Select</option>
                                                <option value="for1">For 1</option>
                                                <option value="for2">For 2</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="aadhaar">Aadhaar Number *</label>
                                            <input type="text" class="form-control" id="aadhaar" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="pan">PAN Number</label>
                                            <input type="text" class="form-control" id="pan">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone Number *</label>
                                            <input type="tel" class="form-control" id="phone" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email Address *</label>
                                            <input type="email" class="form-control" id="email" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="altPhone">Alternate Phone Number</label>
                                            <input type="tel" class="form-control" id="altPhone">
                                        </div>
                                        <div class="form-group">
                                            <label for="altEmail">Alternate Email Address</label>
                                            <input type="email" class="form-control" id="altEmail">
                                        </div>
                                    </div>
                                    <!-- Right Column -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Current Address *</label>
                                            <textarea class="form-control" id="address" rows="3" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="city">City *</label>
                                            <input type="text" class="form-control" id="city" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="district">District *</label>
                                            <input type="text" class="form-control" id="district" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="state">State *</label>
                                            <input type="text" class="form-control" id="state" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="chapter">Chapter *</label>
                                            <input type="text" class="form-control" id="chapter" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="pincode">Pin Code *</label>
                                            <input type="text" class="form-control" id="pincode" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nationality">Nationality *</label>
                                            <input type="text" class="form-control" id="nationality" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="dob">Date of Birth *</label>
                                            <input type="date" class="form-control" id="dob" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="birthPlace">Birth Place *</label>
                                            <input type="text" class="form-control" id="birthPlace" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="gender">Gender *</label>
                                            <select class="form-control" id="gender" required>
                                                <option value="">Select</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="age">Age *</label>
                                            <input type="number" class="form-control" id="age" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="maritalStatus">Marital Status *</label>
                                            <select class="form-control" id="maritalStatus" required>
                                                <option value="">Select</option>
                                                <option value="single">Single</option>
                                                <option value="married">Married</option>
                                                <option value="divorced">Divorced</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="religion">Religion *</label>
                                            <input type="text" class="form-control" id="religion" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="subCaste">Sub-caste *</label>
                                            <input type="text" class="form-control" id="subCaste" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="bloodGroup">Blood Group *</label>
                                            <select class="form-control" id="bloodGroup" required>
                                                <option value="">Select</option>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="O+">O+</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="speciallyAbled">Specially Abled *</label>
                                            <select class="form-control" id="speciallyAbled" required>
                                                <option value="">Select</option>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-secondary">Previous</button>
                                    </div>
                                    <div class="col-6 text-end">
                                        <button type="submit" class="btn btn-purple">Next Step</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
