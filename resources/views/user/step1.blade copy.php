<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 1 - Personal Details</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .sidebar {
            background-color: #292c54;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            color: white;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .navbar {
            margin-left: 250px;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content,
            .navbar {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow">
        <div class="container-fluid justify-content-between">
            <a class="navbar-brand fw-bold" href="#">JITO Educational Aid Program</a>
            <div class="d-flex">
                <button class="btn btn-primary me-2" style="background-color: purple; border-color: purple;">Step 1 of
                    7</button>
                <button class="btn btn-danger">Logout</button>
            </div>
        </div>
    </nav>

    <!-- Left Sidebar -->
    <div class="sidebar">
        <div class="p-3">
            <h5 class="text-center mb-4">Steps</h5>
            <ul class="list-unstyled">
                <li class="mb-3">
                    <div class="bg-primary text-white p-2 rounded d-flex align-items-center"
                        style="background-color: #007bff !important;">
                        <i class="bx bx-user me-2"></i> Personal Details
                    </div>
                </li>
                <li class="mb-3">
                    <div class="p-2 d-flex align-items-center text-muted">
                        <i class="bx bx-graduation me-2"></i> Educational Details
                    </div>
                </li>
                <li class="mb-3">
                    <div class="p-2 d-flex align-items-center text-muted">
                        <i class="bx bx-dollar-circle me-2"></i> Financial Information
                    </div>
                </li>
                <li class="mb-3">
                    <div class="p-2 d-flex align-items-center text-muted">
                        <i class="bx bx-receipt me-2"></i> Documents Upload
                    </div>
                </li>
                <li class="mb-3">
                    <div class="p-2 d-flex align-items-center text-muted">
                        <i class="bx bx-edit me-2"></i> Review & Submit
                    </div>
                </li>
                <li class="mb-3">
                    <div class="p-2 d-flex align-items-center text-muted">
                        <i class="bx bx-check-circle me-2"></i> Confirmation
                    </div>
                </li>
                <li class="mb-3">
                    <div class="p-2 d-flex align-items-center text-muted">
                        <i class="bx bx-notification me-2"></i> Acknowledgment
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="card shadow" style="border-radius: 10px;">
            <div class="card-body">
                <h3 class="card-title mb-4">Personal Details</h3>
                <form>
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="applicantName" class="form-label">Applicant Name</label>
                                <input type="text" class="form-control" id="applicantName">
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="form-label">Add Photo</label>
                                <input type="file" class="form-control" id="photo">
                            </div>
                            <div class="mb-3">
                                <label for="financialAsstType" class="form-label">Financial Asst Type</label>
                                <select class="form-select" id="financialAsstType">
                                    <option selected>Select</option>
                                    <option>Option 1</option>
                                    <option>Option 2</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="financialAsstFor" class="form-label">Financial Asst For</label>
                                <select class="form-select" id="financialAsstFor">
                                    <option selected>Select</option>
                                    <option>Option 1</option>
                                    <option>Option 2</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="aadharCardNumber" class="form-label">Aadhar Card Number</label>
                                <input type="text" class="form-control" id="aadharCardNumber">
                            </div>
                            <div class="mb-3">
                                <label for="panCard" class="form-label">PAN Card</label>
                                <input type="text" class="form-control" id="panCard">
                            </div>
                            <div class="mb-3">
                                <label for="phoneNumber" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phoneNumber">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email">
                            </div>
                            <div class="mb-3">
                                <label for="alternatePhone" class="form-label">Alternate Phone Number</label>
                                <input type="tel" class="form-control" id="alternatePhone">
                            </div>
                            <div class="mb-3">
                                <label for="alternateEmail" class="form-label">Alternate Email Address</label>
                                <input type="email" class="form-control" id="alternateEmail">
                            </div>
                        </div>
                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" id="state">
                            </div>
                            <div class="mb-3">
                                <label for="chapter" class="form-label">Chapter</label>
                                <input type="text" class="form-control" id="chapter">
                            </div>
                            <div class="mb-3">
                                <label for="pinCode" class="form-label">Pin Code</label>
                                <input type="text" class="form-control" id="pinCode">
                            </div>
                            <div class="mb-3">
                                <label for="nationality" class="form-label">Nationality</label>
                                <select class="form-select" id="nationality">
                                    <option selected>Select</option>
                                    <option>Indian</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="dob">
                            </div>
                            <div class="mb-3">
                                <label for="birthPlace" class="form-label">Birth Place</label>
                                <input type="text" class="form-control" id="birthPlace">
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender">
                                    <option selected>Select</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="age" class="form-label">Age</label>
                                <input type="number" class="form-control" id="age">
                            </div>
                            <div class="mb-3">
                                <label for="maritalStatus" class="form-label">Marital Status</label>
                                <select class="form-select" id="maritalStatus">
                                    <option selected>Select</option>
                                    <option>Single</option>
                                    <option>Married</option>
                                    <option>Divorced</option>
                                    <option>Widowed</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="religion" class="form-label">Religion</label>
                                <select class="form-select" id="religion">
                                    <option selected>Select</option>
                                    <option>Hindu</option>
                                    <option>Muslim</option>
                                    <option>Christian</option>
                                    <option>Sikh</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="subCaste" class="form-label">Sub caste</label>
                                <select class="form-select" id="subCaste">
                                    <option selected>Select</option>
                                    <option>Option 1</option>
                                    <option>Option 2</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="bloodGroup" class="form-label">Blood Group</label>
                                <select class="form-select" id="bloodGroup">
                                    <option selected>Select</option>
                                    <option>A+</option>
                                    <option>A-</option>
                                    <option>B+</option>
                                    <option>B-</option>
                                    <option>O+</option>
                                    <option>O-</option>
                                    <option>AB+</option>
                                    <option>AB-</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="speciallyAbled" class="form-label">Specially Abled</label>
                                <select class="form-select" id="speciallyAbled">
                                    <option selected>Select</option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary">Previous</button>
                        <button type="button" class="btn btn-primary">Next Step</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
