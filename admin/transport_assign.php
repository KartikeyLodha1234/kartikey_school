<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Transport Assign</h3>
            <div class="text-secondary small">Assign vehicles and routes to students.</div>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0">Assign Transport students</h5>
                <span class="text-secondary small">Assign a vehicle and route to a student</span>
            </div>
            <form class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Student <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-search text-secondary"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search student by name or admission no..." required>
                        <button class="btn btn-primary" type="button">Search</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Class</label>
                    <select class="form-select">
                        <option value="">Select Class</option>
                        <option value="1">Grade 1</option>
                        <option value="2">Grade 2</option>
                        <option value="3">Grade 3</option>
                        <option value="4">Grade 4</option>
                        <option value="5">Grade 5</option>
                        <option value="6">Grade 6</option>
                        <option value="7">Grade 7</option>
                        <option value="8">Grade 8</option>
                        <option value="9">Grade 9</option>
                        <option value="10">Grade 10</option>
                        <option value="11">Grade 11</option>
                        <option value="12">Grade 12</option>
                    </select>
                </div>
                <div class="col-12 mt-2">
                    <h6 class="fw-bold"><i class="fas fa-route text-primary me-2"></i>Transport Details</h6>
                    <hr>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Route <span class="text-danger">*</span></label>
                    <select class="form-select" required>
                        <option value="">Select Route</option>
                        <option value="1">Route 1 - City Center</option>
                        <option value="2">Route 2 - North Side</option>
                        <option value="3">Route 3 - South Side</option>
                        <option value="4">Route 4 - East Side</option>
                        <option value="5">Route 5 - West Side</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Vehicle</label>
                    <select class="form-select">
                        <option value="">Select Vehicle</option>
                        <option value="1">MH-12-AB-1234 (Bus)</option>
                        <option value="2">MH-12-CD-5678 (Van)</option>
                        <option value="3">MH-12-EF-9012 (Car)</option>
                        <option value="4">MH-12-GH-3456 (Bus)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Pickup Point</label>
                    <input type="text" class="form-control" placeholder="e.g., Main Gate, Bus Stop">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Pickup Time</label>
                    <input type="time" class="form-control" value="07:00">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Drop Time</label>
                    <input type="time" class="form-control" value="14:30">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Transport Fee</label>
                    <input type="number" class="form-control" placeholder="e.g., 1500" value="1500">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select class="form-select">
                        <option value="Active">🟢 Active</option>
                        <option value="Inactive">🔴 Inactive</option>
                        <option value="Hold">🟡 Hold</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Remarks / Notes</label>
                    <input type="text" class="form-control" placeholder="Any special instructions...">
                </div>
                <div class="col-12 d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-3">Reset</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-3">Assign Transport</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-header bg-transparent border-bottom-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="fas fa-list text-primary me-2"></i>Assigned Transport List</h6>
                <span class="text-secondary small">Total: 45 students | Active: 38</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="px-3 pb-3">
                <div class="row g-2">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="fas fa-search text-secondary"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search student..." />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option value="">All Routes</option>
                            <option value="1">Route 1 - City Center</option>
                            <option value="2">Route 2 - North Side</option>
                            <option value="3">Route 3 - South Side</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option value="">All Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Hold">Hold</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100 rounded-pill">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Class</th>
                            <th>Route</th>
                            <th>Vehicle</th>
                            <th>Pickup Point</th>
                            <th>Pickup Time</th>
                            <th>Drop Time</th>
                            <th>Fee</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><strong>Aarav Sharma</strong></td>
                            <td>Grade 10</td>
                            <td>Route 1 - City Center</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">MH-12-AB-1234</span></td>
                            <td>Main Gate</td>
                            <td>07:00 AM</td>
                            <td>02:30 PM</td>
                            <td>₹1,500</td>
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
                            <td><strong>Priya Patel</strong></td>
                            <td>Grade 8</td>
                            <td>Route 2 - North Side</td>
                            <td><span class="badge bg-success bg-opacity-10 text-success">MH-12-CD-5678</span></td>
                            <td>Bus Stop</td>
                            <td>06:45 AM</td>
                            <td>02:45 PM</td>
                            <td>₹1,200</td>
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
                            <td><strong>Rohit Singh</strong></td>
                            <td>Grade 11</td>
                            <td>Route 3 - South Side</td>
                            <td><span class="badge bg-warning bg-opacity-10 text-warning">MH-12-EF-9012</span></td>
                            <td>Main Gate</td>
                            <td>07:15 AM</td>
                            <td>02:15 PM</td>
                            <td>₹1,800</td>
                            <td><span class="status-badge bg-warning-subtle text-warning">Hold</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><strong>Sneha Reddy</strong></td>
                            <td>Grade 6</td>
                            <td>Route 4 - East Side</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">MH-12-GH-3456</span></td>
                            <td>Bus Stop</td>
                            <td>07:30 AM</td>
                            <td>02:00 PM</td>
                            <td>₹1,000</td>
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
                            <td><strong>Amit Kumar</strong></td>
                            <td>Grade 3</td>
                            <td>Route 5 - West Side</td>
                            <td><span class="badge bg-danger bg-opacity-10 text-danger">MH-12-IJ-7890</span></td>
                            <td>Main Gate</td>
                            <td>08:00 AM</td>
                            <td>01:30 PM</td>
                            <td>₹800</td>
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
        <div class="card-footer bg-transparent border-top-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-secondary small">Showing 1-5 of 45 students</div>
                <nav>
                    <ul class="pagination pagination-custom mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
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