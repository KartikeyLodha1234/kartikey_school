<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School ERP · Staff & Payroll</title>
    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style/ok.css">
</head>

<body>

    <div class="container-fluid px-0">
        <div class="row g-0">
            <aside class="col-lg-2 col-md-3 sidebar d-md-block d-none">
                <div class="brand">
                    <i class="fas fa-graduation-cap"></i> School
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link active" href="#"><i class="fas fa-th-large"></i> Dashboard</a>
                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                            href="#masterMenu" role="button" aria-expanded="false">
                            <span>
                                <i class="fas fa-coins"></i> Master
                            </span>
                            <i class="fas fa-chevron-down small"></i>
                        </a>
                        <div class="collapse" id="masterMenu">
                            <nav class="nav flex-column ms-4 mt-2">
                                <a class="nav-link py-2" href="class.php">
                                    <i class="fas fa-school"></i> Classes
                                </a>

                                <a class="nav-link py-2" href="section.php">
                                    <i class="fas fa-layer-group"></i> Sections
                                </a>

                                <a class="nav-link py-2" href="subject.php">
                                    <i class="fas fa-book-open"></i> Subjects
                                </a>
                                <a class="nav-link py-2" href="fees.php">
                                    <i class="fas fa-money-bill-wave"></i> Fees
                                </a>

                                <a class="nav-link py-2" href="marks.php">
                                    <i class="fas fa-chart-line"></i> Marks
                                </a>
                            </nav>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                            href="#studentMenu" role="button" aria-expanded="false">
                            <span>
                                <i class="fas fa-user-graduate"></i> Students
                            </span>
                            <i class="fas fa-chevron-down small"></i>
                        </a>
                        <div class="collapse" id="studentMenu">
                            <nav class="nav flex-column ms-4 mt-2">
                                <a class="nav-link py-2" href="admission.php">
                                    <i class="fas fa-user-plus"></i> Add Student
                                </a>
                                <a class="nav-link py-2" href="student_report.php">
                                    <i class="fas fa-chart-bar"></i> Student Report
                                </a>
                                <a class="nav-link py-2" href="id_card.php">
                                    <i class="fas fa-id-card"></i> Student ID
                                </a>
                                <a class="nav-link py-2" href="student_fees.php">
                                    <i class="fas fa-wallet"></i> Student Fees
                                </a>
                            </nav>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                            href="#transportMenu">
                            <span>
                                <i class="fas fa-bus"></i> Transport
                            </span>
                            <i class="fas fa-chevron-down"></i>
                        </a>

                        <div class="collapse" id="transportMenu">
                            <ul class="nav flex-column ms-3">
                                <li class="nav-item">
                                    <a class="nav-link py-2" href="vehicle.php">
                                        <i class="fas fa-car"></i> Vehicles
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link py-2" href="route.php">
                                        <i class="fas fa-route"></i> Routes
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link py-2" href="driver.php">
                                        <i class="fas fa-id-card"></i> Drivers
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link py-2" href="transport_assign.php">
                                        <i class="fas fa-user-check"></i> Assign Students
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link py-2" href="transport_fee.php">
                                        <i class="fas fa-money-bill-wave"></i> Transport Fees
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                            href="#expenseMenu">
                            <span>
                                <i class="fas fa-wallet"></i> Expenses
                            </span>
                            <i class="fas fa-chevron-down"></i>
                        </a>

                        <div class="collapse" id="expenseMenu">
                            <ul class="nav flex-column ms-3">
                                <li class="nav-item">
                                    <a class="nav-link py-2" href="add_expense.php">
                                        <i class="fas fa-plus-circle"></i> Add Expense
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link py-2" href="expense_list.php">
                                        <i class="fas fa-file-invoice"></i> Expense List
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                            href="#staffPayrollMenu">
                            <span>
                                <i class="fas fa-user-tie"></i> Staff & Payroll
                            </span>
                            <i class="fas fa-chevron-down"></i>
                        </a>

                        <div class="collapse" id="staffPayrollMenu">
                            <ul class="nav flex-column ms-3">

                                <li class="nav-item">
                                    <a class="nav-link py-2" href="staff.php">
                                        <i class="fas fa-users"></i> Staff List
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link py-2" href="add_staff.php">
                                        <i class="fas fa-user-plus"></i> Add Staff
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link py-2" href="designation.php">
                                        <i class="fas fa-id-badge"></i> Designations
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link py-2" href="attendance_staff.php">
                                        <i class="fas fa-calendar-check"></i> Staff Attendance
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link py-2" href="payroll.php">
                                        <i class="fas fa-money-check-alt"></i> Payroll
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link py-2" href="salary_report.php">
                                        <i class="fas fa-file-invoice-dollar"></i> Salary Reports
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <a class="nav-link" href="reports.php"><i class="fas fa-chart-pie"></i> Reports</a>
                    <a class="nav-link" href="settings.php"><i class="fas fa-cog"></i> Settings</a>
                </nav>
                <hr class="border-secondary opacity-25 my-4">
                <div class="px-3 small text-secondary">
                    <i class="far fa-clock me-1"></i> v2.4.0
                </div>
            </aside>
            <div class="col-lg-10 col-md-9 wrapper">
                <nav class="navbar navbar-expand-lg navbar-dark topbar">
                    <div class="container-fluid px-0">
                        <a class="navbar-brand d-md-none" href="#"><i class="fas fa-graduation-cap"></i> School</a>
                        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                            data-bs-target="#topNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="topNav">
                            <ul class="navbar-nav ms-auto align-items-lg-center">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                                        data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle"></i> Profile
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>My
                                                Account</a></li>
                                        <li><a class="dropdown-item" href="#"><i
                                                    class="fas fa-cog me-2"></i>Settings</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="#"><i
                                                    class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
                <script>
                    document.querySelectorAll('.sidebar .nav-link').forEach(link => {
                        link.addEventListener('click', function(e) {
                            if (this.getAttribute('href') === '#') e.preventDefault();
                            document.querySelectorAll('.sidebar .nav-link').forEach(l => l.classList
                                .remove(
                                    'active'));
                            this.classList.add('active');
                        });
                    });
                </script>