<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Transport Fee</h3>
            <div class="text-secondary small">Manage transport charges by route and distance.</div>
        </div>
    </div>

    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0">Add Route Charge</h5>
                <span class="text-secondary small">Register a new fee structure</span>
            </div>
            <form class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Fee ID</label>
                    <input type="text" class="form-control" placeholder="e.g., TF-001" value="TF-006">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Route Name <span class="text-danger">*</span></label>
                    <select class="form-select" required>
                        <option value="">Select Route</option>
                        <option value="1">Route 1 - City Center</option>
                        <option value="2">Route 2 - North Side</option>
                        <option value="3">Route 3 - South Side</option>
                        <option value="4">Route 4 - East Side</option>
                        <option value="5">Route 5 - West Side</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Distance (KM)</label>
                    <input type="number" class="form-control" placeholder="e.g., 15">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Fee Amount (₹) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" placeholder="e.g., 1500" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Status</label>
                    <select class="form-select">
                        <option value="Active">🟢 Active</option>
                        <option value="Inactive">🔴 Inactive</option>
                        <option value="On Leave">🟡 Hold</option>
                    </select>
                </div>
                <div class="col-12 d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-3">Reset</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Save Fee</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="border-left: 4px solid #2563eb;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Total Routes</div>
                        <div class="stat-number">12</div>
                    </div>
                    <div class="stat-icon" style="background:#2563eb;"><i class="fas fa-route"></i></div>
                </div>
                <div class="stat-sub">Active transport routes</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="border-left: 4px solid #10b981;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Active Fees</div>
                        <div class="stat-number">10</div>
                    </div>
                    <div class="stat-icon" style="background:#10b981;"><i class="fas fa-check-circle"></i></div>
                </div>
                <div class="stat-sub">Fee structures active</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="border-left: 4px solid #f59e0b;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Avg Fee</div>
                        <div class="stat-number">₹1,250</div>
                    </div>
                    <div class="stat-icon" style="background:#f59e0b;"><i class="fas fa-chart-line"></i></div>
                </div>
                <div class="stat-sub">Average transport fee</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="border-left: 4px solid #ef4444;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Highest Fee</div>
                        <div class="stat-number">₹2,000</div>
                    </div>
                    <div class="stat-icon" style="background:#ef4444;"><i class="fas fa-arrow-up"></i></div>
                </div>
                <div class="stat-sub">Route 6 - Far Side</div>
            </div>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-header bg-transparent border-bottom-0 p-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h6 class="mb-0 fw-bold"><i class="fas fa-list text-primary me-2"></i>Route Wise Fee List</h6>
                <span class="text-secondary small">Showing 6 fee entries</span>
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
                            <input type="text" class="form-control border-start-0" placeholder="Search route...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option value="">All Routes</option>
                            <option>Route 1 - City Center</option>
                            <option>Route 2 - North Side</option>
                            <option>Route 3 - South Side</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option value="">All Status</option>
                            <option>Active</option>
                            <option>Inactive</option>
                            <option>Hold</option>
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
                            <th>Fee ID</th>
                            <th>Route</th>
                            <th>Distance</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>TF-001</td>
                            <td>Route 1 - City Center</td>
                            <td>12 KM</td>
                            <td>₹1,200</td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle" title="Edit"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle" title="Delete"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>TF-002</td>
                            <td>Route 2 - North Side</td>
                            <td>18 KM</td>
                            <td>₹1,500</td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle" title="Edit"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle" title="Delete"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>TF-003</td>
                            <td>Route 3 - South Side</td>
                            <td>22 KM</td>
                            <td>₹1,800</td>
                            <td><span class="status-badge bg-warning-subtle text-warning">Hold</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle" title="Edit"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle" title="Delete"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="text-center text-secondary small mt-4">
        © 2026 School ERP · Transport Fee Management
    </div>
</div>