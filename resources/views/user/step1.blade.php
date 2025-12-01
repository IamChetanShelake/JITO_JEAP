<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JITO Personal Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: white;
            border-bottom: 1px solid #dee2e6;
            height: 110px;
        }

        .sidebar {
            background-color: #1e1b4b;
            color: white;
            min-height: 80vh;
            overflow-y: auto;
        }

        .sidebar-title {
            text-align: center;
            margin-bottom: 2rem;
            font-weight: bold;
        }

        .stepper {
            list-style: none;
            padding: 0;
        }

        .stepper li {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding-left: 1rem;
        }

        .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            background-color: #e3f2fd;
            /* Light blue for inactive */
            color: white;
        }

        .stepper .active .step-icon {
            background-color: #fed766;
            /* Yellow for active */
            color: #1e1b4b;
        }

        .stepper .active .step-title {
            font-weight: bold;
            color: white;
        }

        .step-title {
            color: #b0c4de;
            /* Light grey white for inactive */
        }

        .main-content {
            padding: 2rem;
        }

        .form-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 110px;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 250px;
                height: calc(100vh - 110px);
                /* Fixed width for off-canvas */
                z-index: 1050;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding-top: 110px;
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1040;
            }

            .overlay.show {
                display: block;
            }
        }
    </style>
</head>

<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex flex-column align-items-center" href="#">
                <img src="{{ asset('jitojeaplogo.png') }}" alt="JITO Logo" width="150px" height="auto">
                <span>Supporting Jain Students Educational Journey</span>
            </a>
            <div class="ms-auto d-flex align-items-center">
                <button class="btn btn-purple me-2" style="background-color: #7c3aed; color: white;">Step 1 of
                    7</button>
                <button class="btn btn-danger">Logout</button>
                <button class="btn btn-dark d-md-none ms-2" onclick="toggleSidebar()">☰</button>
            </div>
        </div>
    </nav>


    <div class="container-fluid" style="margin-top:110px;">
        <div class="row">
            <!-- Sidebar -->
            <div id="sidebar" class="col-lg-3 sidebar">
                <div class="p-3">
                    <h5 class="sidebar-title">Application Progress</h5>
                    <ul class="stepper">
                        <li class="active">
                            <div class="step-icon">1</div>
                            <span class="step-title">Personal Details</span>
                        </li>
                        <li>
                            <div class="step-icon">2</div>
                            <span class="step-title">Family Details</span>
                        </li>
                        <li>
                            <div class="step-icon">3</div>
                            <span class="step-title">Education Details</span>
                        </li>
                        <li>
                            <div class="step-icon">4</div>
                            <span class="step-title">Funding Details</span>
                        </li>
                        <li>
                            <div class="step-icon">5</div>
                            <span class="step-title">Guarantor Details</span>
                        </li>
                        <li>
                            <div class="step-icon">6</div>
                            <span class="step-title">Documents Upload</span>
                        </li>
                        <li>
                            <div class="step-icon">7</div>
                            <span class="step-title">Review & Submit</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 main-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card form-card">
                        <div class="card-body">
                            <h3 class="card-title">Personal Details</h3>
                            <p class="card-subtitle mb-4 text-muted">Provide your correct details</p>
                            <form>
                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="applicantName" class="form-label">Applicant’s Name *</label>
                                            <input type="text" class="form-control" id="applicantName" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="addPhoto" class="form-label">Add Photo</label>
                                            <input type="file" class="form-control" id="addPhoto">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="financialAssetType" class="form-label">Financial Asset Type
                                                *</label>
                                            <input type="text" class="form-control" id="financialAssetType" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="financialAssetFor" class="form-label">Financial Asset For
                                                *</label>
                                            <input type="text" class="form-control" id="financialAssetFor" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="aadhaarNumber" class="form-label">Aadhaar Card Number *</label>
                                            <input type="text" class="form-control" id="aadhaarNumber" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="panCard" class="form-label">PAN Card *</label>
                                            <input type="text" class="form-control" id="panCard" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="phoneNumber" class="form-label">Phone Number *</label>
                                            <input type="tel" class="form-control" id="phoneNumber" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="emailAddress" class="form-label">Email Address *</label>
                                            <input type="email" class="form-control" id="emailAddress" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="alternatePhone" class="form-label">Alternate Phone
                                                Number</label>
                                            <input type="tel" class="form-control" id="alternatePhone">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="alternateEmail" class="form-label">Alternate Email
                                                Address</label>
                                            <input type="email" class="form-control" id="alternateEmail">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="currentAddress" class="form-label">Current Address *</label>
                                            <textarea class="form-control" id="currentAddress" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <!-- Right Column -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="city" class="form-label">City *</label>
                                            <input type="text" class="form-control" id="city" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="district" class="form-label">District *</label>
                                            <input type="text" class="form-control" id="district" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="state" class="form-label">State *</label>
                                            <input type="text" class="form-control" id="state" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="chapter" class="form-label">Chapter *</label>
                                            <input type="text" class="form-control" id="chapter" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="pinCode" class="form-label">Pin Code *</label>
                                            <input type="text" class="form-control" id="pinCode" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="nationality" class="form-label">Nationality *</label>
                                            <input type="text" class="form-control" id="nationality" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="dateOfBirth" class="form-label">Date of Birth *</label>
                                            <input type="date" class="form-control" id="dateOfBirth" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="birthPlace" class="form-label">Birth Place *</label>
                                            <input type="text" class="form-control" id="birthPlace" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="gender" class="form-label">Gender *</label>
                                            <select class="form-select" id="gender" required>
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="age" class="form-label">Age *</label>
                                            <input type="number" class="form-control" id="age" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="maritalStatus" class="form-label">Marital Status *</label>
                                            <select class="form-select" id="maritalStatus" required>
                                                <option value="">Select Status</option>
                                                <option value="single">Single</option>
                                                <option value="married">Married</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="religion" class="form-label">Religion *</label>
                                            <input type="text" class="form-control" id="religion" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="subCaste" class="form-label">Sub caste *</label>
                                            <input type="text" class="form-control" id="subCaste" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="bloodGroup" class="form-label">Blood Group *</label>
                                            <select class="form-select" id="bloodGroup" required>
                                                <option value="">Select Blood Group</option>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB-">AB-</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="speciallyAbled" class="form-label">Specially Abled *</label>
                                            <select class="form-select" id="speciallyAbled" required>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-light">Previous</button>
                                    <button type="submit" class="btn"
                                        style="background-color: #4b2aad; color: white;">Next Step</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay for Mobile -->
    <div id="overlay" class="overlay" onclick="toggleSidebar()"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS for Sidebar Toggle -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }
    </script>
</body>

</html>
