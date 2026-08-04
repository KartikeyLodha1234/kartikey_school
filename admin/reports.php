<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-chart-pie text-primary me-2"></i>Reports</h3>
            <div class="text-secondary small">View and generate various school reports.</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-pill px-3">
                <i class="fas fa-file-export me-2"></i>Export All
            </button>
            <button class="btn btn-primary rounded-pill px-3">
                <i class="fas fa-sync me-2"></i>Refresh
            </button>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="stat-icon" style="background: #2563eb; width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.5rem;">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Student Reports</h5>
                            <div class="text-secondary small">View student related reports</div>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-users text-primary me-2"></i>Student List</span>
                            <span class="badge bg-light text-dark">48</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-id-card text-primary me-2"></i>Admission Report</span>
                            <span class="badge bg-light text-dark">156</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-chart-bar text-primary me-2"></i>Class-wise Strength</span>
                            <span class="badge bg-light text-dark">12</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-venus-mars text-primary me-2"></i>Gender-wise Report</span>
                            <span class="badge bg-light text-dark">2</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-calendar-alt text-primary me-2"></i>Birthday Report</span>
                            <span class="badge bg-light text-dark">This Month</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="stat-icon" style="background: #10b981; width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.5rem;">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Fee Reports</h5>
                            <div class="text-secondary small">View fee related reports</div>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-file-invoice text-success me-2"></i>Fee Collection Report</span>
                            <span class="badge bg-light text-dark">₹1,25,000</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-clock text-success me-2"></i>Pending Fees</span>
                            <span class="badge bg-light text-dark">₹20,000</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-chart-line text-success me-2"></i>Monthly Collection</span>
                            <span class="badge bg-light text-dark">Aug 2025</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-route text-success me-2"></i>Transport Fee Report</span>
                            <span class="badge bg-light text-dark">₹45,000</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-hand-holding-usd text-success me-2"></i>Fee Due Report</span>
                            <span class="badge bg-light text-dark">12 Students</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="stat-icon" style="background: #f59e0b; width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.5rem;">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Staff & Payroll</h5>
                            <div class="text-secondary small">View staff and payroll reports</div>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-users text-warning me-2"></i>Staff List</span>
                            <span class="badge bg-light text-dark">48</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-wallet text-warning me-2"></i>Payroll Report</span>
                            <span class="badge bg-light text-dark">₹12,50,000</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-file-invoice-dollar text-warning me-2"></i>Salary Report</span>
                            <span class="badge bg-light text-dark">Aug 2025</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-clipboard-check text-warning me-2"></i>Attendance Report</span>
                            <span class="badge bg-light text-dark">This Month</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-user-tag text-warning me-2"></i>Designation-wise</span>
                            <span class="badge bg-light text-dark">9 Designations</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="stat-icon" style="background: #8b5cf6; width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.5rem;">
                            <i class="fas fa-bus"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Transport Reports</h5>
                            <div class="text-secondary small">View transport related reports</div>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-route text-purple me-2"></i>Route Report</span>
                            <span class="badge bg-light text-dark">12 Routes</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-user-friends text-purple me-2"></i>Student Transport</span>
                            <span class="badge bg-light text-dark">45 Students</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-money-bill text-purple me-2"></i>Transport Fee</span>
                            <span class="badge bg-light text-dark">₹45,000</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-truck text-purple me-2"></i>Vehicle Report</span>
                            <span class="badge bg-light text-dark">12 Vehicles</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-user-tie text-purple me-2"></i>Driver Report</span>
                            <span class="badge bg-light text-dark">8 Drivers</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="stat-icon" style="background: #ef4444; width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.5rem;">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Expense Reports</h5>
                            <div class="text-secondary small">View expense related reports</div>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-list text-danger me-2"></i>All Expenses</span>
                            <span class="badge bg-light text-dark">₹1,25,000</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-chart-pie text-danger me-2"></i>Category-wise</span>
                            <span class="badge bg-light text-dark">10 Categories</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-calendar-week text-danger me-2"></i>Monthly Expense</span>
                            <span class="badge bg-light text-dark">Aug 2025</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-arrow-up text-danger me-2"></i>Top Expenses</span>
                            <span class="badge bg-light text-dark">View</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="stat-icon" style="background: #06b6d4; width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.5rem;">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Academic Reports</h5>
                            <div class="text-secondary small">View academic related reports</div>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-graduation-cap text-cyan me-2"></i>Class-wise Report</span>
                            <span class="badge bg-light text-dark">12 Classes</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-subject text-cyan me-2"></i>Subject Report</span>
                            <span class="badge bg-light text-dark">24 Subjects</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span><i class="fas fa-chart-simple text-cyan me-2"></i>Performance Report</span>
                            <span class="badge bg-light text-dark">View</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>