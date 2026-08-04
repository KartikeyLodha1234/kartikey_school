<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Add Expense</h3>
            <div class="text-secondary small">Manage school expenses and expenditures.</div>
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
                <h5 class="mb-0"><i class="fas fa-plus-circle text-primary me-2"></i>Add New Expense</h5>
                <span class="text-secondary small">Create a new expense record</span>
            </div>
            
            <form class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Expense ID</label>
                    <input type="text" class="form-control" placeholder="e.g., EXP-001" value="EXP-006">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Expense Category <span class="text-danger">*</span></label>
                    <select class="form-select" required>
                        <option value="">Select Category</option>
                        <option value="salary">👨‍🏫 Staff Salary</option>
                        <option value="maintenance">🔧 Maintenance</option>
                        <option value="utilities">💡 Utilities (Electricity, Water)</option>
                        <option value="transport">🚌 Transport</option>
                        <option value="stationery">📚 Stationery & Supplies</option>
                        <option value="events">🎉 Events & Functions</option>
                        <option value="equipment">💻 Equipment Purchase</option>
                        <option value="rent">🏢 Rent</option>
                        <option value="insurance">🛡️ Insurance</option>
                        <option value="other">📌 Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Expense Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="e.g., Staff salary for August" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Amount (₹) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" placeholder="e.g., 5000" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Payment Method</label>
                    <select class="form-select">
                        <option value="cash">💵 Cash</option>
                        <option value="bank">🏦 Bank Transfer</option>
                        <option value="card">💳 Card</option>
                        <option value="cheque">📝 Cheque</option>
                        <option value="online">🌐 Online</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Paid To</label>
                    <input type="text" class="form-control" placeholder="e.g., Vendor name, Staff name">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Payment Status</label>
                    <select class="form-select">
                        <option value="Paid">✅ Paid</option>
                        <option value="Pending">🟡 Pending</option>
                        <option value="Overdue">🔴 Overdue</option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Remarks / Notes</label>
                    <textarea class="form-control" rows="2" placeholder="Any additional notes..."></textarea>
                </div>

                <div class="col-12 d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fas fa-undo me-2"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i>Save Expense
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-header bg-transparent border-bottom-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="fas fa-list text-primary me-2"></i>Recent Expenses</h6>
                <span class="text-secondary small">Total: 24 expenses this month</span>
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
                            <input type="text" class="form-control border-start-0" placeholder="Search expenses..." />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option value="">All Categories</option>
                            <option value="salary">👨‍🏫 Staff Salary</option>
                            <option value="maintenance">🔧 Maintenance</option>
                            <option value="utilities">💡 Utilities</option>
                            <option value="transport">🚌 Transport</option>
                            <option value="stationery">📚 Stationery</option>
                            <option value="events">🎉 Events</option>
                            <option value="equipment">💻 Equipment</option>
                            <option value="rent">🏢 Rent</option>
                            <option value="insurance">🛡️ Insurance</option>
                            <option value="other">📌 Other</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option value="">All Status</option>
                            <option value="Paid">✅ Paid</option>
                            <option value="Pending">🟡 Pending</option>
                            <option value="Overdue">🔴 Overdue</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100 rounded-pill">
                        <i class="fas fa-search me-2"></i> Search
                    </button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Paid To</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge bg-light text-dark">EXP-001</span></td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">👨‍🏫 Salary</span></td>
                            <td><strong>Staff salary - August</strong></td>
                            <td>31 Aug 2025</td>
                            <td><strong>₹50,000</strong></td>
                            <td>Staff Members</td>
                            <td>🏦 Bank Transfer</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="#" class="text-primary text-decoration-none">View</a>
                                    <a href="#" class="text-primary text-decoration-none">Edit</a>
                                    <a href="#" class="text-danger text-decoration-none">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-light text-dark">EXP-002</span></td>
                            <td><span class="badge bg-warning bg-opacity-10 text-warning">💡 Utilities</span></td>
                            <td><strong>Electricity bill - August</strong></td>
                            <td>28 Aug 2025</td>
                            <td><strong>₹12,000</strong></td>
                            <td>Electricity Board</td>
                            <td>🌐 Online</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="#" class="text-primary text-decoration-none">View</a>
                                    <a href="#" class="text-primary text-decoration-none">Edit</a>
                                    <a href="#" class="text-danger text-decoration-none">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-light text-dark">EXP-003</span></td>
                            <td><span class="badge bg-info bg-opacity-10 text-info">🚌 Transport</span></td>
                            <td><strong>Bus maintenance</strong></td>
                            <td>25 Aug 2025</td>
                            <td><strong>₹8,000</strong></td>
                            <td>Workshop</td>
                            <td>💵 Cash</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="#" class="text-primary text-decoration-none">View</a>
                                    <a href="#" class="text-primary text-decoration-none">Edit</a>
                                    <a href="#" class="text-danger text-decoration-none">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-light text-dark">EXP-004</span></td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary">📚 Stationery</span></td>
                            <td><strong>School stationery supplies</strong></td>
                            <td>20 Aug 2025</td>
                            <td><strong>₹5,000</strong></td>
                            <td>Stationery Shop</td>
                            <td>💳 Card</td>
                            <td><span class="status-badge bg-warning-subtle text-warning">Pending</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="#" class="text-primary text-decoration-none">View</a>
                                    <a href="#" class="text-primary text-decoration-none">Edit</a>
                                    <a href="#" class="text-danger text-decoration-none">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-light text-dark">EXP-005</span></td>
                            <td><span class="badge bg-danger bg-opacity-10 text-danger">🔧 Maintenance</span></td>
                            <td><strong>Building repair work</strong></td>
                            <td>15 Aug 2025</td>
                            <td><strong>₹15,000</strong></td>
                            <td>Contractor</td>
                            <td>📝 Cheque</td>
                            <td><span class="status-badge bg-danger-subtle text-danger">Overdue</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="#" class="text-primary text-decoration-none">View</a>
                                    <a href="#" class="text-primary text-decoration-none">Edit</a>
                                    <a href="#" class="text-danger text-decoration-none">Delete</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>