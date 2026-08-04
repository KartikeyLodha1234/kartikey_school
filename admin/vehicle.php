<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-bus text-primary me-2"></i>Vehicle</h3>
            <div class="text-secondary small">Manage school vehicles.</div>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0">Add New Vehicle</h5>
                <span class="text-secondary small">Register a new vehicle</span>
            </div>
            
            <form class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Vehicle Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="e.g., MH-12-AB-1234" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Vehicle Type</label>
                    <select class="form-select">
                        <option value="bus">🚌 Bus</option>
                        <option value="van">🚐 Van</option>
                        <option value="car">🚗 Car</option>
                        <option value="auto">🛺 Auto</option>
                        <option value="other">🚙 Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Capacity</label>
                    <input type="number" class="form-control" placeholder="e.g., 40">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status</label>
                    <select class="form-select">
                        <option value="Active">🟢 Active</option>
                        <option value="Inactive">🔴 Inactive</option>
                        <option value="Maintenance">🟡 Maintenance</option>
                    </select>
                </div>
                <div class="col-12 d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-3">Reset</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-3">Save Vehicle</button>
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
                            <th>Vehicle No</th>
                            <th>Type</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><span class="badge bg-light text-dark">MH-12-AB-1234</span></td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">🚌 Bus</span></td>
                            <td>40</td>
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
                            <td><span class="badge bg-light text-dark">MH-12-CD-5678</span></td>
                            <td><span class="badge bg-success bg-opacity-10 text-success">🚐 Van</span></td>
                            <td>12</td>
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
                            <td><span class="badge bg-light text-dark">MH-12-EF-9012</span></td>
                            <td><span class="badge bg-warning bg-opacity-10 text-warning">🚗 Car</span></td>
                            <td>4</td>
                            <td><span class="status-badge bg-warning-subtle text-warning">Maintenance</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><span class="badge bg-light text-dark">MH-12-GH-3456</span></td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">🚌 Bus</span></td>
                            <td>35</td>
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
                            <td><span class="badge bg-light text-dark">MH-12-IJ-7890</span></td>
                            <td><span class="badge bg-danger bg-opacity-10 text-danger">🛺 Auto</span></td>
                            <td>3</td>
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
                <div class="text-secondary small">Showing 1-5 of 12 vehicles</div>
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
<?php
include 'includes/footer.php';
?>