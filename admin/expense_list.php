<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Expense List</h3>
            <div class="text-secondary small">View and manage all school expenses.</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-pill px-3">
                <i class="fas fa-file-export me-2"></i>Export
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="border-left: 4px solid #2563eb;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Total Expenses</div>
                        <div class="stat-number">₹1,25,000</div>
                    </div>
                    <div class="stat-icon" style="background:#2563eb;"><i class="fas fa-chart-pie"></i></div>
                </div>
                <div class="stat-sub">This month</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="border-left: 4px solid #10b981;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Paid</div>
                        <div class="stat-number">₹98,000</div>
                    </div>
                    <div class="stat-icon" style="background:#10b981;"><i class="fas fa-check-circle"></i></div>
                </div>
                <div class="stat-sub">Completed payments</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="border-left: 4px solid #f59e0b;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Pending</div>
                        <div class="stat-number">₹20,000</div>
                    </div>
                    <div class="stat-icon" style="background:#f59e0b;"><i class="fas fa-clock"></i></div>
                </div>
                <div class="stat-sub">Pending payments</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="border-left: 4px solid #ef4444;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Overdue</div>
                        <div class="stat-number">₹7,000</div>
                    </div>
                    <div class="stat-icon" style="background:#ef4444;"><i class="fas fa-exclamation-triangle"></i></div>
                </div>
                <div class="stat-sub">Overdue payments</div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <div class="col-md-3">
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
                <div class="col-md-3">
                    <button class="btn btn-primary w-100 rounded-pill">
                        <i class="fas fa-search me-2"></i> Search
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Expense Table -->
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
                            <th>Category</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Paid To</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td><span class="badge bg-light text-dark">EXP-001</span></td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">👨‍🏫 Salary</span></td>
                            <td><strong>Staff salary - August</strong></td>
                            <td>31 Aug 2025</td>
                            <td><strong>₹50,000</strong></td>
                            <td>Staff Members</td>
                            <td>🏦 Bank</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
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
                            <td><span class="badge bg-light text-dark">EXP-002</span></td>
                            <td><span class="badge bg-warning bg-opacity-10 text-warning">💡 Utilities</span></td>
                            <td><strong>Electricity bill - August</strong></td>
                            <td>28 Aug 2025</td>
                            <td><strong>₹12,000</strong></td>
                            <td>Electricity Board</td>
                            <td>🌐 Online</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
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
                            <td><span class="badge bg-light text-dark">EXP-003</span></td>
                            <td><span class="badge bg-info bg-opacity-10 text-info">🚌 Transport</span></td>
                            <td><strong>Bus maintenance</strong></td>
                            <td>25 Aug 2025</td>
                            <td><strong>₹8,000</strong></td>
                            <td>Workshop</td>
                            <td>💵 Cash</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
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
                            <td><span class="badge bg-light text-dark">EXP-004</span></td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary">📚 Stationery</span></td>
                            <td><strong>School stationery supplies</strong></td>
                            <td>20 Aug 2025</td>
                            <td><strong>₹5,000</strong></td>
                            <td>Stationery Shop</td>
                            <td>💳 Card</td>
                            <td><span class="status-badge bg-warning-subtle text-warning">Pending</span></td>
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
                            <td><span class="badge bg-light text-dark">EXP-005</span></td>
                            <td><span class="badge bg-danger bg-opacity-10 text-danger">🔧 Maintenance</span></td>
                            <td><strong>Building repair work</strong></td>
                            <td>15 Aug 2025</td>
                            <td><strong>₹15,000</strong></td>
                            <td>Contractor</td>
                            <td>📝 Cheque</td>
                            <td><span class="status-badge bg-danger-subtle text-danger">Overdue</span></td>
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
                            <td><span class="badge bg-light text-dark">EXP-006</span></td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">👨‍🏫 Salary</span></td>
                            <td><strong>Staff salary - July</strong></td>
                            <td>31 Jul 2025</td>
                            <td><strong>₹50,000</strong></td>
                            <td>Staff Members</td>
                            <td>🏦 Bank</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
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
                            <td><span class="badge bg-light text-dark">EXP-007</span></td>
                            <td><span class="badge bg-info bg-opacity-10 text-info">🚌 Transport</span></td>
                            <td><strong>Fuel expenses - August</strong></td>
                            <td>18 Aug 2025</td>
                            <td><strong>₹6,000</strong></td>
                            <td>Petrol Pump</td>
                            <td>💵 Cash</td>
                            <td><span class="status-badge bg-warning-subtle text-warning">Pending</span></td>
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
        <!-- Pagination -->
        <div class="card-footer bg-transparent border-top-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-secondary small">Showing 1-7 of 24 expenses</div>
                <nav>
                    <ul class="pagination pagination-custom mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
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