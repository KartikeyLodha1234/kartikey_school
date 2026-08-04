<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-hand-holding-usd text-primary me-2"></i>Student Fee Collect</h3>
            <div class="text-secondary small">Collect and manage student fee payments.</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-pill px-3">
                <i class="fas fa-file-export me-2"></i>Export
            </button>
            <button class="btn btn-primary rounded-pill px-3">
                <i class="fas fa-plus me-2"></i>New Collection
            </button>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0"><i class="fas fa-coins text-primary me-2"></i>Collect Fee</h5>
                <span class="text-secondary small">Enter student details and collect fee</span>
            </div>
            
            <form class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Search Student <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-search text-secondary"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Enter name, admission no, or class..." required>
                        <button class="btn btn-primary" type="button">Search</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Select Class</label>
                    <select class="form-select">
                        <option value="">All Classes</option>
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
                    <h6 class="fw-bold"><i class="fas fa-file-invoice text-primary me-2"></i>Fee Details</h6>
                    <hr>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Fee Type</label>
                    <select class="form-select">
                        <option value="tuition">📚 Tuition Fee</option>
                        <option value="admission">🎓 Admission Fee</option>
                        <option value="exam">📝 Exam Fee</option>
                        <option value="transport">🚌 Transport Fee</option>
                        <option value="hostel">🏠 Hostel Fee</option>
                        <option value="library">📖 Library Fee</option>
                        <option value="sports">⚽ Sports Fee</option>
                        <option value="other">📌 Other</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Month/Period</label>
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
                    <label class="form-label fw-semibold">Amount (₹)</label>
                    <input type="number" class="form-control" placeholder="5000" value="5000">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Late Fee (₹)</label>
                    <input type="number" class="form-control" placeholder="100" value="0">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Discount (₹)</label>
                    <input type="number" class="form-control" placeholder="0" value="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Total Amount (₹)</label>
                    <input type="text" class="form-control" value="₹ 5,000" readonly style="background: #f8f9fa; font-weight: bold; color: #2563eb;">
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
                    <label class="form-label fw-semibold">Remarks / Notes</label>
                    <input type="text" class="form-control" placeholder="Any additional notes...">
                </div>
                <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fas fa-undo me-2"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i>Collect Fee
                    </button>
                    <button type="button" class="btn btn-success rounded-pill px-4">
                        <i class="fas fa-print me-2"></i>Print Receipt
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-header bg-transparent border-bottom-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="fas fa-history text-primary me-2"></i>Recent Collections</h6>
                <span class="text-secondary small">Today: 12 collections | Total: ₹1,25,000</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Receipt No</th>
                            <th>Student Name</th>
                            <th>Class</th>
                            <th>Fee Type</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><span class="badge bg-light text-dark">REC-2025-001</span></td>
                            <td><strong>Aarav Sharma</strong></td>
                            <td>Grade 10</td>
                            <td>📚 Tuition</td>
                            <td><strong>₹5,000</strong></td>
                            <td>💵 Cash</td>
                            <td>10 Aug 2025</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success rounded-circle" title="Print">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><span class="badge bg-light text-dark">REC-2025-002</span></td>
                            <td><strong>Priya Patel</strong></td>
                            <td>Grade 8</td>
                            <td>🚌 Transport</td>
                            <td><strong>₹1,500</strong></td>
                            <td>📱 UPI</td>
                            <td>10 Aug 2025</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-success rounded-circle"><i class="fas fa-print"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><span class="badge bg-light text-dark">REC-2025-003</span></td>
                            <td><strong>Rohit Singh</strong></td>
                            <td>Grade 11</td>
                            <td>📚 Tuition</td>
                            <td><strong>₹5,200</strong></td>
                            <td>🏦 Bank Transfer</td>
                            <td>09 Aug 2025</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-success rounded-circle"><i class="fas fa-print"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><span class="badge bg-light text-dark">REC-2025-004</span></td>
                            <td><strong>Sneha Reddy</strong></td>
                            <td>Grade 6</td>
                            <td>📖 Library</td>
                            <td><strong>₹500</strong></td>
                            <td>💳 Card</td>
                            <td>09 Aug 2025</td>
                            <td><span class="status-badge bg-success-subtle text-success">Paid</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-success rounded-circle"><i class="fas fa-print"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><span class="badge bg-light text-dark">REC-2025-005</span></td>
                            <td><strong>Amit Kumar</strong></td>
                            <td>Grade 3</td>
                            <td>📚 Tuition</td>
                            <td><strong>₹3,000</strong></td>
                            <td>💵 Cash</td>
                            <td>08 Aug 2025</td>
                            <td><span class="status-badge bg-warning-subtle text-warning">Pending</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-success rounded-circle"><i class="fas fa-print"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent border-top-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-secondary small">Showing 1-5 of 24 collections</div>
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