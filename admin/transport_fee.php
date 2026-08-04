<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-hand-holding-usd text-primary me-2"></i>Transport Fee</h3>
            <div class="text-secondary small">Manage transport fee collection.</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-pill px-3">
                <i class="fas fa-file-export me-2"></i>Export
            </button>
            <button class="btn btn-primary rounded-pill px-3">
                <i class="fas fa-plus me-2"></i>Add Fee
            </button>
        </div>
    </div>

    <!-- Add Transport Fee Form -->
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0">Add Transport Fee</h5>
                <span class="text-secondary small">Create a new transport fee record</span>
            </div>
            
            <form class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Student <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-search text-secondary"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search student..." required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Route</label>
                    <select class="form-select">
                        <option value="">Select Route</option>
                        <option value="1">Route 1 - City Center</option>
                        <option value="2">Route 2 - North Side</option>
                        <option value="3">Route 3 - South Side</option>
                    </select>
                </div>
                <div class="col-md-4">
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
                    <label class="form-label fw-semibold">Fee Amount (₹)</label>
                    <input type="number" class="form-control" placeholder="e.g., 1500" value="1500">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Late Fee (₹)</label>
                    <input type="number" class="form-control" placeholder="e.g., 100" value="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Discount (₹)</label>
                    <input type="number" class="form-control" placeholder="e.g., 0" value="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Total (₹)</label>
                    <input type="text" class="form-control" value="₹ 1,500" readonly style="background: #f8f9fa; font-weight: bold; color: #2563eb;">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Payment Method</label>
                    <select class="form-select">
                        <option value="cash">💵 Cash</option>
                        <option value="bank_transfer">🏦 Bank Transfer</option>
                        <option value="card">💳 Credit/Debit Card</option>
                        <option value="upi">📱 UPI</option>
                        <option value="cheque">📝 Cheque</option>
                        <option value="online">🌐 Online Payment</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Payment Date</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Remarks</label>
                    <input type="text" class="form-control" placeholder="Any additional notes...">
                </div>
                <div class="col-12 d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-3">Reset</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-3">Save Fee</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Transport Fee Table -->
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-header bg-transparent border-bottom-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="fas fa-history text-primary me-2"></i>Transport Fee List</h6>
                <span class="text-secondary small">Total Collections: ₹45,000 | Pending: ₹12,000</span>
            </div>
        </div>
        <div class="card-body p-0">
            <!-- Search & Filter -->
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
                            <option value="">All Months</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option value="">All Status</option>
                            <option value="Paid">Paid</option>
                            <option value="Pending">Pending</option>
                            <option value="Overdue">Overdue</option>
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
                            <th>Month</th>
                            <th>Amount</th>
                            <th>Late Fee</th>
                            <th>Total</th>
                            <th>Payment Date</th>
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
                            <td>August</td>
                            <td>₹1,500</td>
                            <td>₹0</td>
                            <td><strong>₹1,500</strong></td>
                            <td>10 Aug 2025</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success rounded-circle" title="Print">
                                        <i class="fas fa-print"></i>
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
                            <td>August</td>
                            <td>₹1,200</td>
                            <td>₹0</td>
                            <td><strong>₹1,200</strong></td>
                            <td>10 Aug 2025</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-success rounded-circle"><i class="fas fa-print"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><strong>Rohit Singh</strong></td>
                            <td>Grade 11</td>
                            <td>Route 3 - South Side</td>
                            <td>August</td>
                            <td>₹1,800</td>
                            <td>₹0</td>
                            <td><strong>₹1,800</strong></td>
                            <td>-</td>
                            <td><span class="status-badge bg-warning-subtle text-warning">Pending</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-success rounded-circle"><i class="fas fa-print"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><strong>Sneha Reddy</strong></td>
                            <td>Grade 6</td>
                            <td>Route 4 - East Side</td>
                            <td>August</td>
                            <td>₹1,000</td>
                            <td>₹100</td>
                            <td><strong>₹1,100</strong></td>
                            <td>-</td>
                            <td><span class="status-badge bg-danger-subtle text-danger">Overdue</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-success rounded-circle"><i class="fas fa-print"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><strong>Amit Kumar</strong></td>
                            <td>Grade 3</td>
                            <td>Route 5 - West Side</td>
                            <td>July</td>
                            <td>₹800</td>
                            <td>₹0</td>
                            <td><strong>₹800</strong></td>
                            <td>25 Jul 2025</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-success rounded-circle"><i class="fas fa-print"></i></button>
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
                <div class="text-secondary small">Showing 1-5 of 24 records</div>
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