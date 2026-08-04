<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Staff Attendance</h3>
            <div class="text-secondary small">Manage staff attendance records.</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-pill px-3">
                <i class="fas fa-file-export me-2"></i>Export
            </button>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="border-left: 4px solid #2563eb;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Total Staff</div>
                        <div class="stat-number">48</div>
                    </div>
                    <div class="stat-icon" style="background:#2563eb;"><i class="fas fa-users"></i></div>
                </div>
                <div class="stat-sub">All staff members</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="border-left: 4px solid #10b981;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Present</div>
                        <div class="stat-number">42</div>
                    </div>
                    <div class="stat-icon" style="background:#10b981;"><i class="fas fa-check-circle"></i></div>
                </div>
                <div class="stat-sub">Today</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="border-left: 4px solid #ef4444;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Absent</div>
                        <div class="stat-number">4</div>
                    </div>
                    <div class="stat-icon" style="background:#ef4444;"><i class="fas fa-user-slash"></i></div>
                </div>
                <div class="stat-sub">Today</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="border-left: 4px solid #f59e0b;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">On Leave</div>
                        <div class="stat-number">2</div>
                    </div>
                    <div class="stat-icon" style="background:#f59e0b;"><i class="fas fa-clock"></i></div>
                </div>
                <div class="stat-sub">Today</div>
            </div>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0">MarkAttendance</h5>
                <span class="text-secondary small">Select date and mark attendance</span>
            </div>
            
            <form class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Department</label>
                    <select class="form-select">
                        <option value="">All Departments</option>
                        <option value="science">Science</option>
                        <option value="maths">Mathematics</option>
                        <option value="english">English</option>
                        <option value="hindi">Hindi</option>
                        <option value="social">Social Studies</option>
                        <option value="computer">Computer Science</option>
                        <option value="arts">Arts</option>
                        <option value="sports">Sports</option>
                        <option value="admin">Administration</option>
                        <option value="accounts">Accounts</option>
                        <option value="transport">Transport</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Designation</label>
                    <select class="form-select">
                        <option value="">All Designations</option>
                        <option value="teacher">Teacher</option>
                        <option value="principal">Principal</option>
                        <option value="admin">Admin</option>
                        <option value="accountant">Accountant</option>
                        <option value="librarian">Librarian</option>
                        <option value="peon">Peon</option>
                        <option value="driver">Driver</option>
                        <option value="security">Security</option>
                    </select>
                </div>
                <div class="col-12 d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-3">Reset</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-3">
                        <i class="fas fa-save me-2"></i>Save Attendance
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-search text-secondary"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search staff..." />
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option value="">All Status</option>
                        <option value="Present">✅ Present</option>
                        <option value="Absent">❌ Absent</option>
                        <option value="Leave">🟡 On Leave</option>
                        <option value="Half Day">🌓 Half Day</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-select" placeholder="Date">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100 rounded-pill">
                        <i class="fas fa-search me-2"></i>search
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>
                                <input type="checkbox" class="form-check-input">
                            </th>
                            <th>ID</th>
                            <th>Staff Name</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td><span class="badge bg-light text-dark">STF-001</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Rajesh+Kumar&background=2563eb&color=fff&size=30" alt="Staff" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Rajesh Kumar</strong>
                                </div>
                            </td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">Teacher</span></td>
                            <td>Mathematics</td>
                            <td>04 Aug 2025</td>
                            <td>08:30 AM</td>
                            <td>03:30 PM</td>
                            <td><span class="status-badge bg-success-subtle text-success">✅ Present</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td><span class="badge bg-light text-dark">STF-002</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Priya+Sharma&background=2563eb&color=fff&size=30" alt="Staff" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Priya Sharma</strong>
                                </div>
                            </td>
                            <td><span class="badge bg-success bg-opacity-10 text-success">Teacher</span></td>
                            <td>Science</td>
                            <td>04 Aug 2025</td>
                            <td>08:45 AM</td>
                            <td>03:30 PM</td>
                            <td><span class="status-badge bg-success-subtle text-success">✅ Present</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td><span class="badge bg-light text-dark">STF-003</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Amit+Singh&background=2563eb&color=fff&size=30" alt="Staff" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Amit Singh</strong>
                                </div>
                            </td>
                            <td><span class="badge bg-warning bg-opacity-10 text-warning">Admin</span></td>
                            <td>Administration</td>
                            <td>04 Aug 2025</td>
                            <td>09:00 AM</td>
                            <td>04:00 PM</td>
                            <td><span class="status-badge bg-danger-subtle text-danger">❌ Absent</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td><span class="badge bg-light text-dark">STF-004</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Sneha+Reddy&background=2563eb&color=fff&size=30" alt="Staff" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Sneha Reddy</strong>
                                </div>
                            </td>
                            <td><span class="badge bg-info bg-opacity-10 text-info">Accountant</span></td>
                            <td>Accounts</td>
                            <td>04 Aug 2025</td>
                            <td>-</td>
                            <td>-</td>
                            <td><span class="status-badge bg-warning-subtle text-warning">🟡 On Leave</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td><span class="badge bg-light text-dark">STF-005</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Suresh+Patel&background=2563eb&color=fff&size=30" alt="Staff" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Suresh Patel</strong>
                                </div>
                            </td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary">Peon</span></td>
                            <td>Administration</td>
                            <td>04 Aug 2025</td>
                            <td>08:15 AM</td>
                            <td>02:30 PM</td>
                            <td><span class="status-badge bg-success-subtle text-success">🌓 Half Day</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td><span class="badge bg-light text-dark">STF-006</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Rohit+Verma&background=2563eb&color=fff&size=30" alt="Staff" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Rohit Verma</strong>
                                </div>
                            </td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">Teacher</span></td>
                            <td>English</td>
                            <td>04 Aug 2025</td>
                            <td>08:30 AM</td>
                            <td>03:30 PM</td>
                            <td><span class="status-badge bg-success-subtle text-success">✅ Present</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Pagination -->
        <div class="card-footer bg-transparent border-top-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-secondary small">Showing 1-6 of 48 staff members</div>
                <nav>
                    <ul class="pagination pagination-custom mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                        <li class="page-item"><a class="page-link" href="#">6</a></li>
                        <li class="page-item"><a class="page-link" href="#">7</a></li>
                        <li class="page-item"><a class="page-link" href="#">8</a></li>
                        <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>