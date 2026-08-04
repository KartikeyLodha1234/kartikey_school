<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Staff List</h3>
            <div class="text-secondary small">View and manage all staff members.</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-pill px-3">
                <i class="fas fa-file-export me-2"></i>Export
            </button>
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
                        <option value="">All Designations</option>
                        <option value="teacher">👨‍🏫 Teacher</option>
                        <option value="principal">👨‍🎓 Principal</option>
                        <option value="admin">📋 Admin</option>
                        <option value="accountant">💰 Accountant</option>
                        <option value="librarian">📖 Librarian</option>
                        <option value="peon">🚪 Peon</option>
                        <option value="driver">🚗 Driver</option>
                        <option value="security">🔒 Security</option>
                        <option value="other">📌 Other</option>
                    </select>
                </div>
                <div class="col-md-3">
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
                        <i class="fas fa-filter me-2"></i>Filter
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
                            <th>
                                <input type="checkbox" class="form-check-input">
                            </th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Join Date</th>
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
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">👨‍🏫 Teacher</span></td>
                            <td>Mathematics</td>
                            <td>rajesh@school.com</td>
                            <td>+91 98765 43210</td>
                            <td>01 Jun 2020</td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle" title="Edit">
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
                            <td><span class="badge bg-success bg-opacity-10 text-success">👩‍🏫 Teacher</span></td>
                            <td>Science</td>
                            <td>priya@school.com</td>
                            <td>+91 87654 32109</td>
                            <td>15 Jul 2019</td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle"><i class="fas fa-edit"></i></button>
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
                            <td><span class="badge bg-warning bg-opacity-10 text-warning">📋 Admin</span></td>
                            <td>Administration</td>
                            <td>amit@school.com</td>
                            <td>+91 76543 21098</td>
                            <td>01 Jan 2021</td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle"><i class="fas fa-edit"></i></button>
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
                            <td><span class="badge bg-info bg-opacity-10 text-info">💰 Accountant</span></td>
                            <td>Accounts</td>
                            <td>sneha@school.com</td>
                            <td>+91 65432 10987</td>
                            <td>01 Mar 2022</td>
                            <td><span class="status-badge bg-warning-subtle text-warning">On Leave</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle"><i class="fas fa-edit"></i></button>
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
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary">🚪 Peon</span></td>
                            <td>Administration</td>
                            <td>suresh@school.com</td>
                            <td>+91 54321 09876</td>
                            <td>01 Aug 2020</td>
                            <td><span class="status-badge bg-danger-subtle text-danger">Inactive</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle"><i class="fas fa-edit"></i></button>
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
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">👨‍🏫 Teacher</span></td>
                            <td>English</td>
                            <td>rohit@school.com</td>
                            <td>+91 98765 01234</td>
                            <td>15 Jan 2023</td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
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