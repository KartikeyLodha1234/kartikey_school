<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Designation</h3>
            <div class="text-secondary small">Manage staff designations and roles.</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-pill px-3">
                <i class="fas fa-file-export me-2"></i>Export
            </button>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0">Add New Designation</h5>
                <span class="text-secondary small">Create a new designation record</span>
            </div>
            <form class="row g-3">
                <div class="col-12">
                    <h6 class="fw-bold mb-2"
                        style="color: #2563eb; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">
                        <i class="fas fa-user me-2"></i>Personal Information
                    </h6>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Designation ID</label>
                    <input type="text" class="form-control" placeholder="e.g., DES-001" value="DES-006">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Designation Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="e.g., Senior Teacher" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Department</label>
                    <select class="form-select">
                        <option value="">Select Department</option>
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
                    <label class="form-label fw-semibold">Base Salary (₹)</label>
                    <input type="number" class="form-control" placeholder="e.g., 25000">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status</label>
                    <select class="form-select">
                        <option value="Active">🟢 Active</option>
                        <option value="Inactive">🔴 Inactive</option>
                        <option value="Maintenance">🟡 Maintenance</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Save Designation</button>
                </div>
        </div>
    </div>
</div>
<div class="main-content">
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
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Base Salary</th>
                            <th>Staff Count</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td><span class="badge bg-light text-dark">DES-001</span></td>
                            <td><strong>👨‍🏫 Teacher</strong></td>
                            <td>All Departments</td>
                            <td>₹25,000</td>
                            <td><span class="badge bg-primary">15</span></td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
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
                            <td><span class="badge bg-light text-dark">DES-002</span></td>
                            <td><strong>👨‍🎓 Principal</strong></td>
                            <td>Administration</td>
                            <td>₹60,000</td>
                            <td><span class="badge bg-primary">1</span></td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td><span class="badge bg-light text-dark">DES-003</span></td>
                            <td><strong>📋 Admin Staff</strong></td>
                            <td>Administration</td>
                            <td>₹20,000</td>
                            <td><span class="badge bg-primary">5</span></td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td><span class="badge bg-light text-dark">DES-004</span></td>
                            <td><strong>💰 Accountant</strong></td>
                            <td>Accounts</td>
                            <td>₹22,000</td>
                            <td><span class="badge bg-primary">2</span></td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td><span class="badge bg-light text-dark">DES-005</span></td>
                            <td><strong>📖 Librarian</strong></td>
                            <td>Library</td>
                            <td>₹18,000</td>
                            <td><span class="badge bg-primary">1</span></td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td><span class="badge bg-light text-dark">DES-006</span></td>
                            <td><strong>🚪 Peon</strong></td>
                            <td>Administration</td>
                            <td>₹12,000</td>
                            <td><span class="badge bg-primary">4</span></td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td><span class="badge bg-light text-dark">DES-007</span></td>
                            <td><strong>🚗 Driver</strong></td>
                            <td>Transport</td>
                            <td>₹15,000</td>
                            <td><span class="badge bg-primary">3</span></td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td><span class="badge bg-light text-dark">DES-008</span></td>
                            <td><strong>🔒 Security</strong></td>
                            <td>Security</td>
                            <td>₹14,000</td>
                            <td><span class="badge bg-primary">2</span></td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td><span class="badge bg-light text-dark">DES-009</span></td>
                            <td><strong>📌 Other</strong></td>
                            <td>Other</td>
                            <td>₹10,000</td>
                            <td><span class="badge bg-primary">0</span></td>
                            <td><span class="status-badge bg-danger-subtle text-danger">Inactive</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent border-top-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-secondary small">Showing 1-9 of 12 designations</div>
                <nav>
                    <ul class="pagination pagination-custom mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#"><i
                                    class="fas fa-chevron-left"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>