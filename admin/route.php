<?php
include 'includes/header.php';
?><div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-route text-primary me-2"></i>Route</h3>
            <div class="text-secondary small">Manage school transport routes.</div>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0">Add New Route</h5>
                <span class="text-secondary small">Create a new transport route</span>
            </div>
            <form class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Route Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="e.g., Route 1 - City Center" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Route Code</label>
                    <input type="text" class="form-control" placeholder="e.g., R-001">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status</label>
                    <select class="form-select">
                        <option value="Active">🟢 Active</option>
                        <option value="Inactive">🔴 Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Start Point</label>
                    <input type="text" class="form-control" placeholder="e.g., School Main Gate">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">End Point</label>
                    <input type="text" class="form-control" placeholder="e.g., City Center">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Distance (KM)</label>
                    <input type="number" class="form-control" placeholder="e.g., 15">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Duration (Mins)</label>
                    <input type="number" class="form-control" placeholder="e.g., 45">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Assigned Vehicle</label>
                    <select class="form-select">
                        <option value="">Select Vehicle</option>
                        <option value="1">MH-12-AB-1234 (Bus)</option>
                        <option value="2">MH-12-CD-5678 (Van)</option>
                        <option value="3">MH-12-EF-9012 (Car)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Assigned Driver</label>
                    <select class="form-select">
                        <option value="">Select Driver</option>
                        <option value="1">Rajesh Singh</option>
                        <option value="2">Suresh Patel</option>
                        <option value="3">Priya Sharma</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Route Description / Stops</label>
                    <textarea class="form-control" rows="2" placeholder="Enter route details with stops..."></textarea>
                </div>
                <div class="col-12 d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-3">Reset</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-3">Save Route</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Route Name</th>
                            <th>Code</th>
                            <th>Start Point</th>
                            <th>End Point</th>
                            <th>Distance</th>
                            <th>Duration</th>
                            <th>Vehicle</th>
                            <th>Driver</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><strong>Route 1 - City Center</strong></td>
                            <td><span class="badge bg-light text-dark">R-001</span></td>
                            <td>School Main Gate</td>
                            <td>City Center</td>
                            <td>15 KM</td>
                            <td>45 Mins</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">MH-12-AB-1234</span></td>
                            <td>Rajesh Singh</td>
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
                            <td><strong>Route 2 - North Side</strong></td>
                            <td><span class="badge bg-light text-dark">R-002</span></td>
                            <td>School Back Gate</td>
                            <td>North Side</td>
                            <td>12 KM</td>
                            <td>35 Mins</td>
                            <td><span class="badge bg-success bg-opacity-10 text-success">MH-12-CD-5678</span></td>
                            <td>Suresh Patel</td>
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
                            <td><strong>Route 3 - South Side</strong></td>
                            <td><span class="badge bg-light text-dark">R-003</span></td>
                            <td>School Main Gate</td>
                            <td>South Side</td>
                            <td>20 KM</td>
                            <td>55 Mins</td>
                            <td><span class="badge bg-warning bg-opacity-10 text-warning">MH-12-EF-9012</span></td>
                            <td>Priya Sharma</td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><strong>Route 4 - East Side</strong></td>
                            <td><span class="badge bg-light text-dark">R-004</span></td>
                            <td>School Main Gate</td>
                            <td>East Side</td>
                            <td>18 KM</td>
                            <td>50 Mins</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">MH-12-GH-3456</span></td>
                            <td>Amit Kumar</td>
                            <td><span class="status-badge bg-warning-subtle text-warning">Inactive</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><strong>Route 5 - West Side</strong></td>
                            <td><span class="badge bg-light text-dark">R-005</span></td>
                            <td>School Back Gate</td>
                            <td>West Side</td>
                            <td>10 KM</td>
                            <td>30 Mins</td>
                            <td><span class="badge bg-danger bg-opacity-10 text-danger">MH-12-IJ-7890</span></td>
                            <td>Ramesh Yadav</td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
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
        <div class="card-footer bg-transparent border-top-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-secondary small">Showing 1-5 of 8 routes</div>
                <nav>
                    <ul class="pagination pagination-custom mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
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