<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Salary Report</h3>
            <div class="text-secondary small">View and manage staff salary reports.</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-pill px-3">
                <i class="fas fa-file-pdf me-2"></i>PDF
            </button>
            <button class="btn btn-outline-success rounded-pill px-3">
                <i class="fas fa-file-excel me-2"></i>Excel
            </button>
            <button class="btn btn-primary rounded-pill px-3">
                <i class="fas fa-print me-2"></i>Print
            </button>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Month</label>
                    <select class="form-select">
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August" selected>August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Year</label>
                    <select class="form-select">
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025" selected>2025</option>
                        <option value="2026">2026</option>
                    </select>
                </div>
                <div class="col-md-3">
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
                <div class="col-md-3">
                    <button class="btn btn-primary w-100 rounded-pill">
                        <i class="fas fa-search me-2"></i>Generate Report
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Staff ID</th>
                            <th>Staff Name</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Basic Salary</th>
                            <th>Allowances</th>
                            <th>Deductions</th>
                            <th>Net Salary</th>
                            <th>Month</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><span class="badge bg-light text-dark">STF-001</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Rajesh+Kumar&background=2563eb&color=fff&size=30" alt="Staff" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Rajesh Kumar</strong>
                                </div>
                            </td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">Teacher</span></td>
                            <td>Mathematics</td>
                            <td>₹25,000</td>
                            <td>₹5,000</td>
                            <td>₹2,000</td>
                            <td><strong>₹28,000</strong></td>
                            <td>August 2025</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle" title="View Slip">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success rounded-circle" title="Print">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle" title="Download">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><span class="badge bg-light text-dark">STF-002</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Priya+Sharma&background=2563eb&color=fff&size=30" alt="Staff" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Priya Sharma</strong>
                                </div>
                            </td>
                            <td><span class="badge bg-success bg-opacity-10 text-success">Teacher</span></td>
                            <td>Science</td>
                            <td>₹22,000</td>
                            <td>₹4,000</td>
                            <td>₹1,500</td>
                            <td><strong>₹24,500</strong></td>
                            <td>August 2025</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-success rounded-circle"><i class="fas fa-print"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-download"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><span class="badge bg-light text-dark">STF-003</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Amit+Singh&background=2563eb&color=fff&size=30" alt="Staff" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Amit Singh</strong>
                                </div>
                            </td>
                            <td><span class="badge bg-warning bg-opacity-10 text-warning">Admin</span></td>
                            <td>Administration</td>
                            <td>₹20,000</td>
                            <td>₹3,000</td>
                            <td>₹1,000</td>
                            <td><strong>₹22,000</strong></td>
                            <td>August 2025</td>
                            <td><span class="status-badge bg-warning-subtle text-warning">Pending</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-success rounded-circle"><i class="fas fa-print"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-download"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><span class="badge bg-light text-dark">STF-004</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Sneha+Reddy&background=2563eb&color=fff&size=30" alt="Staff" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Sneha Reddy</strong>
                                </div>
                            </td>
                            <td><span class="badge bg-info bg-opacity-10 text-info">Accountant</span></td>
                            <td>Accounts</td>
                            <td>₹18,000</td>
                            <td>₹2,000</td>
                            <td>₹1,000</td>
                            <td><strong>₹19,000</strong></td>
                            <td>August 2025</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-success rounded-circle"><i class="fas fa-print"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-download"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><span class="badge bg-light text-dark">STF-005</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Suresh+Patel&background=2563eb&color=fff&size=30" alt="Staff" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Suresh Patel</strong>
                                </div>
                            </td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary">Peon</span></td>
                            <td>Administration</td>
                            <td>₹12,000</td>
                            <td>₹1,000</td>
                            <td>₹500</td>
                            <td><strong>₹12,500</strong></td>
                            <td>August 2025</td>
                            <td><span class="status-badge bg-danger-subtle text-danger">Unpaid</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-success rounded-circle"><i class="fas fa-print"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-download"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td><span class="badge bg-light text-dark">STF-006</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Rohit+Verma&background=2563eb&color=fff&size=30" alt="Staff" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Rohit Verma</strong>
                                </div>
                            </td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">Teacher</span></td>
                            <td>English</td>
                            <td>₹24,000</td>
                            <td>₹4,500</td>
                            <td>₹2,000</td>
                            <td><strong>₹26,500</strong></td>
                            <td>August 2025</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-success rounded-circle"><i class="fas fa-print"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-download"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td><span class="badge bg-light text-dark">STF-007</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Neha+Verma&background=2563eb&color=fff&size=30" alt="Staff" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Neha Verma</strong>
                                </div>
                            </td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">Teacher</span></td>
                            <td>Hindi</td>
                            <td>₹21,000</td>
                            <td>₹3,500</td>
                            <td>₹1,500</td>
                            <td><strong>₹23,000</strong></td>
                            <td>August 2025</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-success rounded-circle"><i class="fas fa-print"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-download"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent border-top-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-secondary small">Showing 1-7 of 48 staff members</div>
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