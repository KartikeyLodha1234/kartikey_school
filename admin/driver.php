<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-user-tie text-primary me-2"></i>Driver</h3>
            <div class="text-secondary small">Manage school drivers.</div>
        </div>
    </div>

    <!-- Add Driver Form -->
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0">Add New Driver</h5>
                <span class="text-secondary small">Register a new driver</span>
            </div>
            
            <form class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Driver Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Driver full name" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">License Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="e.g., DL-1234567890" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Contact <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" placeholder="+91 98765 43210" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" class="form-control" placeholder="driver@example.com">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Assigned Vehicle</label>
                    <select class="form-select">
                        <option value="">Select Vehicle</option>
                        <option value="1">MH-12-AB-1234 (Bus)</option>
                        <option value="2">MH-12-CD-5678 (Van)</option>
                        <option value="3">MH-12-EF-9012 (Car)</option>
                        <option value="4">MH-12-GH-3456 (Bus)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">License Expiry</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Address</label>
                    <textarea class="form-control" rows="2" placeholder="Driver address"></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status</label>
                    <select class="form-select">
                        <option value="Active">🟢 Active</option>
                        <option value="Inactive">🔴 Inactive</option>
                        <option value="On Leave">🟡 On Leave</option>
                    </select>
                </div>
                <div class="col-12 d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-3">Reset</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-3">Save Driver</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Driver Table -->
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Driver Name</th>
                            <th>License No</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Assigned Vehicle</th>
                            <th>License Expiry</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><strong>Rajesh Singh</strong></td>
                            <td><span class="badge bg-light text-dark">DL-1234567890</span></td>
                            <td>+91 98765 43210</td>
                            <td>rajesh@example.com</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">MH-12-AB-1234</span></td>
                            <td>31 Dec 2026</td>
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
                            <td>2</td>
                            <td><strong>Suresh Patel</strong></td>
                            <td><span class="badge bg-light text-dark">DL-0987654321</span></td>
                            <td>+91 87654 32109</td>
                            <td>suresh@example.com</td>
                            <td><span class="badge bg-success bg-opacity-10 text-success">MH-12-CD-5678</span></td>
                            <td>15 Jun 2026</td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><strong>Priya Sharma</strong></td>
                            <td><span class="badge bg-light text-dark">DL-5678901234</span></td>
                            <td>+91 76543 21098</td>
                            <td>priya@example.com</td>
                            <td><span class="badge bg-warning bg-opacity-10 text-warning">MH-12-EF-9012</span></td>
                            <td>20 Mar 2026</td>
                            <td><span class="status-badge bg-warning-subtle text-warning">On Leave</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><strong>Amit Kumar</strong></td>
                            <td><span class="badge bg-light text-dark">DL-4321098765</span></td>
                            <td>+91 65432 10987</td>
                            <td>amit@example.com</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">MH-12-GH-3456</span></td>
                            <td>10 Nov 2026</td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><strong>Ramesh Yadav</strong></td>
                            <td><span class="badge bg-light text-dark">DL-6789012345</span></td>
                            <td>+91 54321 09876</td>
                            <td>ramesh@example.com</td>
                            <td><span class="badge bg-danger bg-opacity-10 text-danger">MH-12-IJ-7890</span></td>
                            <td>05 Jan 2026</td>
                            <td><span class="status-badge bg-danger-subtle text-danger">Inactive</span></td>
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
                <div class="text-secondary small">Showing 1-5 of 12 drivers</div>
                <nav>
                    <ul class="pagination pagination-custom mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>