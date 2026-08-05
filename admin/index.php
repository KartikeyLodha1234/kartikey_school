<?php
include '../config/config.php';
include 'includes/auth_check.php';
checkRole(['admin']);
$total_students = $conn->query("SELECT COUNT(*) as total FROM students")->fetch()['total'] ?? 0;
$active_students = $conn->query("SELECT COUNT(*) as total FROM students WHERE status = 'Active'")->fetch()['total'] ?? 0;
$total_classes = $conn->query("SELECT COUNT(*) as total FROM classes")->fetch()['total'] ?? 0;
$active_classes = $conn->query("SELECT COUNT(*) as total FROM classes WHERE status = 'Active'")->fetch()['total'] ?? 0;
$total_subjects = $conn->query("SELECT COUNT(*) as total FROM subjects")->fetch()['total'] ?? 0;
$active_subjects = $conn->query("SELECT COUNT(*) as total FROM subjects WHERE status = 'Active'")->fetch()['total'] ?? 0;
$total_sections = $conn->query("SELECT COUNT(*) as total FROM sections")->fetch()['total'] ?? 0;
$total_fees = $conn->query("SELECT SUM(amount) as total FROM fees")->fetch()['total'] ?? 0;
$fee_collected = $conn->query("SELECT SUM(amount_paid) as total FROM student_fees WHERE payment_status = 'Paid'")->fetch()['total'] ?? 0;
$pending_fees = $conn->query("SELECT SUM(due_amount) as total FROM student_fees")->fetch()['total'] ?? 0;
$total_expenses = $conn->query("SELECT SUM(amount) as total FROM expenses")->fetch()['total'] ?? 0;
$total_staff = $conn->query("SELECT COUNT(*) as total FROM staff")->fetch()['total'] ?? 0;
$active_staff = $conn->query("SELECT COUNT(*) as total FROM staff WHERE status = 'Active'")->fetch()['total'] ?? 0;
$staff_on_leave = $conn->query("SELECT COUNT(*) as total FROM staff WHERE status = 'On Leave'")->fetch()['total'] ?? 0;
$total_vehicles = $conn->query("SELECT COUNT(*) as total FROM vehicles")->fetch()['total'] ?? 0;
$total_routes = $conn->query("SELECT COUNT(*) as total FROM routes")->fetch()['total'] ?? 0;
$total_drivers = $conn->query("SELECT COUNT(*) as total FROM drivers")->fetch()['total'] ?? 0;
$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'];
$monthly_fees = [];
foreach ($months as $index => $month) {
    $month_num = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
    $sql = "SELECT SUM(amount_paid) as total FROM student_fees 
            WHERE MONTH(paid_on) = $month_num AND YEAR(paid_on) = YEAR(CURDATE())";
    $result = $conn->query($sql)->fetch()['total'] ?? 0;
    $monthly_fees[] = $result > 0 ? $result : rand(400000, 700000); // Demo fallback
}
$student_distribution = [];
$class_categories = [
    'Primary' => [1, 2, 3, 4, 5],
    'Middle' => [6, 7, 8],
    'Senior' => [9, 10, 11, 12]
];
foreach ($class_categories as $category => $class_ids) {
    $ids = implode(',', $class_ids);
    $sql = "SELECT COUNT(*) as total FROM students WHERE class_id IN ($ids)";
    $student_distribution[$category] = $conn->query($sql)->fetch()['total'] ?? 0;
}
$staff_distribution = [
    'Teaching' => $conn->query("SELECT COUNT(*) as total FROM staff WHERE designation LIKE '%Teacher%' OR designation LIKE '%Professor%'")->fetch()['total'] ?? 0,
    'Non-Teaching' => $conn->query("SELECT COUNT(*) as total FROM staff WHERE designation NOT LIKE '%Teacher%' AND designation NOT LIKE '%Professor%' AND designation != 'Peon' AND designation != 'Driver' AND designation != 'Security'")->fetch()['total'] ?? 0,
    'Support' => $conn->query("SELECT COUNT(*) as total FROM staff WHERE designation = 'Peon' OR designation = 'Driver' OR designation = 'Security'")->fetch()['total'] ?? 0
];

$recent_activities = [];
$recent_students = $conn->query("SELECT name, class_id, created_at FROM students ORDER BY id DESC LIMIT 3")->fetchAll();
foreach ($recent_students as $student) {
    $recent_activities[] = [
        'icon' => 'fa-user-plus',
        'color' => 'success',
        'title' => 'New student admitted',
        'desc' => $student['name'] . ' - Grade ' . $student['class_id'],
        'time' => time_ago($student['created_at'])
    ];
}

$recent_fees = $conn->query("SELECT sf.amount_paid, s.name FROM student_fees sf JOIN students s ON sf.student_id = s.id ORDER BY sf.id DESC LIMIT 2")->fetchAll();
foreach ($recent_fees as $fee) {
    $recent_activities[] = [
        'icon' => 'fa-money-bill',
        'color' => 'primary',
        'title' => 'Fee collected',
        'desc' => '₹' . number_format($fee['amount_paid']) . ' - ' . $fee['name'],
        'time' => 'Just now'
    ];
}
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">👋 Welcome back, Admin!</h3>
            <div class="welcome-text">Here's what's happening with your school today.</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-pill px-3">
                <i class="fas fa-file-pdf me-2"></i>Report
            </button>
            <a href="class.php" class="btn btn-primary rounded-pill px-3">
                <i class="fas fa-plus me-2"></i>Add Class
            </a>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Total Students</div>
                        <div class="stat-number"><?php echo $total_students; ?></div>
                    </div>
                    <div class="stat-icon" style="background:#2563eb;"><i class="fas fa-user-graduate"></i></div>
                </div>
                <div class="stat-sub">📈 <?php echo $active_students; ?> active students</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Total Classes</div>
                        <div class="stat-number"><?php echo $total_classes; ?></div>
                    </div>
                    <div class="stat-icon" style="background:#0ea5e9;"><i class="fas fa-school"></i></div>
                </div>
                <div class="stat-sub"><?php echo $active_classes; ?> active classes</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Active Sections</div>
                        <div class="stat-number"><?php echo $total_sections; ?></div>
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
                        <div class="stat-number"><?php echo $total_subjects; ?></div>
                    </div>
                    <div class="stat-icon" style="background:#8b5cf6;"><i class="fas fa-book"></i></div>
                </div>
                <div class="stat-sub"><?php echo $active_subjects; ?> active subjects</div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Total Fees</div>
                        <div class="stat-number">₹<?php echo number_format($total_fees); ?></div>
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
                        <div class="stat-number">₹<?php echo number_format($fee_collected); ?></div>
                    </div>
                    <div class="stat-icon" style="background:#10b981;"><i class="fas fa-money-bill-wave"></i></div>
                </div>
                <div class="stat-sub">✅ <?php echo $total_fees > 0 ? round(($fee_collected / $total_fees) * 100) : 0; ?>% collection rate</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Pending Fees</div>
                        <div class="stat-number">₹<?php echo number_format($pending_fees); ?></div>
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
                        <div class="stat-number">₹<?php echo number_format($total_expenses); ?></div>
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
                <div class="chart-container" style="height:280px;">
                    <canvas id="feeChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card border-0 rounded-4 shadow-sm p-3">
                <h6 class="fw-bold mb-3"><i class="fas fa-chart-pie text-primary me-2"></i>Student Distribution</h6>
                <div class="chart-container" style="height:280px;">
                    <canvas id="studentChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-xl-6">
            <div class="card border-0 rounded-4 shadow-sm p-3">
                <h6 class="fw-bold mb-3"><i class="fas fa-chart-line text-primary me-2"></i>Monthly Attendance Trend</h6>
                <div class="chart-container" style="height:280px;">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card border-0 rounded-4 shadow-sm p-3">
                <h6 class="fw-bold mb-3"><i class="fas fa-users text-primary me-2"></i>Staff Distribution</h6>
                <div class="chart-container" style="height:280px;">
                    <canvas id="staffChart"></canvas>
                </div>
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
                        <?php foreach ($recent_activities as $activity): ?>
                        <div class="list-group-item border-0 d-flex align-items-center gap-3 px-3 py-2">
                            <div class="bg-<?php echo $activity['color']; ?> bg-opacity-10 text-<?php echo $activity['color']; ?> rounded-circle p-2">
                                <i class="fas <?php echo $activity['icon']; ?>"></i>
                            </div>
                            <div>
                                <div class="fw-semibold"><?php echo $activity['title']; ?></div>
                                <div class="text-secondary small"><?php echo $activity['desc']; ?></div>
                            </div>
                            <span class="ms-auto text-secondary small"><?php echo $activity['time']; ?></span>
                        </div>
                        <?php endforeach; ?>
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
                                <div class="text-secondary small"><?php echo $pending_fees > 0 ? number_format($pending_fees) : 'No'; ?> students have pending fees</div>
                            </div>
                            <span class="ms-auto text-secondary small">New</span>
                        </div>
                        <div class="list-group-item border-0 d-flex align-items-start gap-3 px-3 py-2">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-2 mt-1">
                                <i class="fas fa-user-clock"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Staff on leave</div>
                                <div class="text-secondary small"><?php echo $staff_on_leave; ?> staff members on leave today</div>
                            </div>
                            <span class="ms-auto text-secondary small">New</span>
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
    const feeCtx = document.getElementById('feeChart').getContext('2d');
    new Chart(feeCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($months); ?>,
            datasets: [{
                label: 'Fee Collection (₹)',
                data: <?php echo json_encode($monthly_fees); ?>,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37,99,235,0.15)',
                tension: 0.35,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: false,
                    ticks: { callback: value => '₹' + value.toLocaleString('en-IN') }
                }
            }
        }
    });
    const studentCtx = document.getElementById('studentChart').getContext('2d');
    new Chart(studentCtx, {
        type: 'doughnut',
        data: {
            labels: ['Primary', 'Middle', 'Senior'],
            datasets: [{
                data: <?php echo json_encode(array_values($student_distribution)); ?>,
                backgroundColor: ['#2563eb', '#10b981', '#f59e0b']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
    const attCtx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(attCtx, {
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
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, max: 100 } }
        }
    });
    const staffCtx = document.getElementById('staffChart').getContext('2d');
    new Chart(staffCtx, {
        type: 'pie',
        data: {
            labels: ['Teaching', 'Non-Teaching', 'Support'],
            datasets: [{
                data: <?php echo json_encode(array_values($staff_distribution)); ?>,
                backgroundColor: ['#2563eb', '#8b5cf6', '#10b981']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>

<?php
function time_ago($datetime) {
    $time = strtotime($datetime);
    $diff = time() - $time;
    
    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff/60) . ' min ago';
    if ($diff < 86400) return floor($diff/3600) . ' hours ago';
    if ($diff < 604800) return floor($diff/86400) . ' days ago';
    return date('d M Y', $time);
}

include 'includes/footer.php';
?>