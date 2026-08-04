<?php
include 'includes/header.php';
?>
<div class="main-content">
    <!-- Welcome Section -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Welcome back, Admin!</h3>
            <div class="welcome-text">Here's what's happening with your school today.</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-pill px-3">
                <i class="fas fa-file-pdf me-2"></i>Report
            </button>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Total Students</div>
                        <div class="stat-number">826</div>
                    </div>
                    <div class="stat-icon" style="background:#2563eb;"><i class="fas fa-user-graduate"></i></div>
                </div>
                <div class="stat-sub">📈 12% increase from last month</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Total Classes</div>
                        <div class="stat-number">18</div>
                    </div>
                    <div class="stat-icon" style="background:#0ea5e9;"><i class="fas fa-school"></i></div>
                </div>
                <div class="stat-sub">Across primary and senior wing</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Active Sections</div>
                        <div class="stat-number">42</div>
                    </div>
                    <div class="stat-icon" style="background:#f59e0b;"><i class="fas fa-layer-group"></i></div>
                </div>
                <div class="stat-sub">Sections currently running</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Total Subjects</div>
                        <div class="stat-number">24</div>
                    </div>
                    <div class="stat-icon" style="background:#8b5cf6;"><i class="fas fa-book"></i></div>
                </div>
                <div class="stat-sub">Offered across all grades</div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Total Fees</div>
                        <div class="stat-number">₹12,50,000</div>
                    </div>
                    <div class="stat-icon" style="background:#2563eb;"><i class="fas fa-wallet"></i></div>
                </div>
                <div class="stat-sub">Total fees for the academic year</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Fees Collected</div>
                        <div class="stat-number">₹9,80,000</div>
                    </div>
                    <div class="stat-icon" style="background:#10b981;"><i class="fas fa-money-bill-wave"></i></div>
                </div>
                <div class="stat-sub">✅ 78% collection rate</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Pending Fees</div>
                        <div class="stat-number">₹2,70,000</div>
                    </div>
                    <div class="stat-icon" style="background:#f59e0b;"><i class="fas fa-hourglass-half"></i></div>
                </div>
                <div class="stat-sub">⏳ Awaiting payment</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Total Expenses</div>
                        <div class="stat-number">₹1,25,000</div>
                    </div>
                    <div class="stat-icon" style="background:#ef4444;"><i class="fas fa-chart-pie"></i></div>
                </div>
                <div class="stat-sub">This month</div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-xl-6">
            <div class="card border-0 rounded-4 shadow-sm p-3">
                <h6 class="fw-bold mb-3"><i class="fas fa-chart-bar text-primary me-2"></i>Monthly Fee Collection</h6>
                <div class="chart-container">
                    <canvas id="feeChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card border-0 rounded-4 shadow-sm p-3">
                <h6 class="fw-bold mb-3"><i class="fas fa-chart-pie text-primary me-2"></i>Student Distribution</h6>
                <div class="chart-container">
                    <canvas id="studentChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-xl-6">
            <div class="card border-0 rounded-4 shadow-sm p-3">
                <h6 class="fw-bold mb-3"><i class="fas fa-chart-line text-primary me-2"></i>Monthly Attendance Trend
                </h6>
                <div class="chart-container">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card border-0 rounded-4 shadow-sm p-3">
                <h6 class="fw-bold mb-3"><i class="fas fa-users text-primary me-2"></i>Staff Distribution</h6>
                <div class="chart-container">
                    <canvas id="staffChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-12">
            <h6 class="fw-bold mb-3"><i class="fas fa-bolt text-primary me-2"></i>Quick Actions</h6>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-6">
            <div class="quick-action">
                <div class="icon" style="background:#2563eb;"><i class="fas fa-user-plus"></i></div>
                <div class="title">Add Student</div>
                <div class="desc">New admission</div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-6">
            <div class="quick-action">
                <div class="icon" style="background:#10b981;"><i class="fas fa-money-bill"></i></div>
                <div class="title">Collect Fee</div>
                <div class="desc">Payment entry</div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-6">
            <div class="quick-action">
                <div class="icon" style="background:#f59e0b;"><i class="fas fa-user-tie"></i></div>
                <div class="title">Add Staff</div>
                <div class="desc">New employee</div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-6">
            <div class="quick-action">
                <div class="icon" style="background:#8b5cf6;"><i class="fas fa-bus"></i></div>
                <div class="title">Add Vehicle</div>
                <div class="desc">Transport</div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-6">
            <div class="quick-action">
                <div class="icon" style="background:#ef4444;"><i class="fas fa-file-alt"></i></div>
                <div class="title">Add Exam</div>
                <div class="desc">Schedule exam</div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-6">
            <div class="quick-action">
                <div class="icon" style="background:#06b6d4;"><i class="fas fa-route"></i></div>
                <div class="title">Add Route</div>
                <div class="desc">Transport route</div>
            </div>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-xl-6">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header bg-transparent border-0 p-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-clock text-primary me-2"></i>Recent Activities</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 d-flex align-items-center gap-3 px-3 py-2">
                            <div class="bg-success bg-opacity-10 text-success rounded-circle p-2">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">New student admitted</div>
                                <div class="text-secondary small">Aarav Sharma - Grade 10</div>
                            </div>
                            <span class="ms-auto text-secondary small">5 min ago</span>
                        </div>
                        <div class="list-group-item border-0 d-flex align-items-center gap-3 px-3 py-2">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2">
                                <i class="fas fa-money-bill"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Fee collected</div>
                                <div class="text-secondary small">₹5,000 - Tuition fee</div>
                            </div>
                            <span class="ms-auto text-secondary small">1 hour ago</span>
                        </div>
                        <div class="list-group-item border-0 d-flex align-items-center gap-3 px-3 py-2">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-2">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">New staff added</div>
                                <div class="text-secondary small">Priya Sharma - Teacher</div>
                            </div>
                            <span class="ms-auto text-secondary small">3 hours ago</span>
                        </div>
                        <div class="list-group-item border-0 d-flex align-items-center gap-3 px-3 py-2">
                            <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-2">
                                <i class="fas fa-bus"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Vehicle assigned</div>
                                <div class="text-secondary small">MH-12-AB-1234 - Route 1</div>
                            </div>
                            <span class="ms-auto text-secondary small">5 hours ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header bg-transparent border-0 p-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-bell text-primary me-2"></i>Notifications</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 d-flex align-items-start gap-3 px-3 py-2">
                            <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-2 mt-1">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Fee due reminder</div>
                                <div class="text-secondary small">12 students have pending fees for August</div>
                            </div>
                            <span class="ms-auto text-secondary small">New</span>
                        </div>
                        <div class="list-group-item border-0 d-flex align-items-start gap-3 px-3 py-2">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-2 mt-1">
                                <i class="fas fa-user-clock"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Staff on leave</div>
                                <div class="text-secondary small">5 staff members on leave today</div>
                            </div>
                            <span class="ms-auto text-secondary small">New</span>
                        </div>
                        <div class="list-group-item border-0 d-flex align-items-start gap-3 px-3 py-2">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 mt-1">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Exam schedule</div>
                                <div class="text-secondary small">Mid-term exams start from 15 Aug</div>
                            </div>
                            <span class="ms-auto text-secondary small">2 days ago</span>
                        </div>
                        <div class="list-group-item border-0 d-flex align-items-start gap-3 px-3 py-2">
                            <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 mt-1">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Backup completed</div>
                                <div class="text-secondary small">Database backup successful</div>
                            </div>
                            <span class="ms-auto text-secondary small">2 days ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    const feeChart = new Chart(document.getElementById('feeChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
            datasets: [{
                label: 'Fee Collection',
                data: [420000, 460000, 510000, 480000, 560000, 590000, 620000, 680000],
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37,99,235,0.15)',
                tension: 0.35,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    ticks: {
                        callback: value => '₹' + value.toLocaleString('en-IN')
                    }
                }
            }
        }
    });
    const studentChart = new Chart(document.getElementById('studentChart'), {
        type: 'doughnut',
        data: {
            labels: ['Primary', 'Middle', 'Senior'],
            datasets: [{
                data: [280, 240, 306],
                backgroundColor: ['#2563eb', '#10b981', '#f59e0b']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    const attendanceChart = new Chart(document.getElementById('attendanceChart'), {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            datasets: [{
                label: 'Attendance %',
                data: [94, 96, 93, 97, 95, 91],
                backgroundColor: ['#2563eb', '#0ea5e9', '#8b5cf6', '#10b981', '#f59e0b', '#ef4444']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
    const staffChart = new Chart(document.getElementById('staffChart'), {
        type: 'pie',
        data: {
            labels: ['Teaching', 'Non-Teaching', 'Support'],
            datasets: [{
                data: [48, 18, 9],
                backgroundColor: ['#2563eb', '#8b5cf6', '#10b981']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
<?php
include 'includes/footer.php';
?>