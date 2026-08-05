<?php
ob_start();
include '../config/config.php';
include 'includes/auth_check.php'; 
checkRole(['admin']);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_attendance'])) {
    $class_id = intval($_POST['class_id'] ?? 0);
    $date = trim($_POST['attendance_date'] ?? '');
    $status = $_POST['status'] ?? [];
    $student_ids = $_POST['student_ids'] ?? [];
    if ($class_id === 0 || $date === '' || empty($student_ids)) {
        $error = 'Please select a class and date.';
    } else {
        try {
            $stmt = $conn->prepare("SELECT class_name FROM classes WHERE id = ?");
            $stmt->execute([$class_id]);
            $class = $stmt->fetch(PDO::FETCH_ASSOC);
            $class_name = $class ? $class['class_name'] : '';
            $stmt = $conn->prepare("DELETE FROM attendance WHERE class_id = ? AND attendance_date = ?");
            $stmt->execute([$class_id, $date]);
            $stmt = $conn->prepare("INSERT INTO attendance (class_id, class_name, student_id, student_name, attendance_date, status, marked_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
            foreach ($student_ids as $student_id) {
                $attendance_status = $status[$student_id] ?? 'Present';
                $stmt2 = $conn->prepare("SELECT name FROM students WHERE id = ?");
                $stmt2->execute([$student_id]);
                $student = $stmt2->fetch(PDO::FETCH_ASSOC);
                $student_name = $student ? $student['name'] : '';                
                $stmt->execute([$class_id, $class_name, $student_id, $student_name, $date, $attendance_status, $_SESSION['user_id'] ?? 1]);
            }            
            $_SESSION['success'] = 'Attendance marked successfully for ' . date('d M Y', strtotime($date));
            ob_end_clean();
            header('Location: student_attendance.php');
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
try {
    $stmt = $conn->query("SELECT id, class_name FROM classes WHERE status = 'Active' ORDER BY class_name");
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $classes = [];
}
$students = [];
$selected_class_id = intval($_GET['class_id'] ?? 0);
$selected_date = $_GET['attendance_date'] ?? date('Y-m-d');
if ($selected_class_id > 0) {
    try {
        $stmt = $conn->prepare("SELECT id, name FROM students WHERE class_id = ? AND status = 'Active' ORDER BY name");
        $stmt->execute([$selected_class_id]);
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $students = [];
        $error = 'Failed to load students: ' . $e->getMessage();
    }
}
$attendance_data = [];
if ($selected_class_id > 0 && $selected_date) {
    try {
        $stmt = $conn->prepare("SELECT student_id, status FROM attendance WHERE class_id = ? AND attendance_date = ?");
        $stmt->execute([$selected_class_id, $selected_date]);
        $attendance_data = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    } catch (Exception $e) {
        $attendance_data = [];
    }
}
$today = date('Y-m-d');
$today_present = 0;
$today_absent = 0;
$today_leave = 0;
$today_total = 0;
try {
    $stmt = $conn->prepare("SELECT status, COUNT(*) as count FROM attendance WHERE attendance_date = ? GROUP BY status");
    $stmt->execute([$today]);
    $today_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($today_stats as $stat) {
        if ($stat['status'] == 'Present') $today_present = $stat['count'];
        elseif ($stat['status'] == 'Absent') $today_absent = $stat['count'];
        elseif ($stat['status'] == 'Leave') $today_leave = $stat['count'];
    }
    $today_total = $today_present + $today_absent + $today_leave;
} catch (Exception $e) {

}
$month = date('Y-m');
$monthly_present = 0;
$monthly_absent = 0;
$monthly_total = 0;

try {
    $stmt = $conn->prepare("SELECT status, COUNT(*) as count FROM attendance WHERE attendance_date LIKE ? GROUP BY status");
    $stmt->execute([$month . '%']);
    $monthly_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($monthly_stats as $stat) {
        if ($stat['status'] == 'Present') $monthly_present = $stat['count'];
        if ($stat['status'] == 'Absent') $monthly_absent = $stat['count'];
    }
    $monthly_total = $monthly_present + $monthly_absent;
} catch (Exception $e) {
    // Ignore
}

include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-clipboard-check text-primary me-2"></i>Student Attendance</h3>
            <div class="text-secondary small">Manage student attendance and track daily presence.</div>
        </div>
        <div class="d-flex gap-2">
            <a href="attendence.php" class="btn btn-outline-primary rounded-pill px-3">
                <i class="fas fa-chart-bar me-2"></i>Reports
            </a>
            <button class="btn btn-outline-success rounded-pill px-3" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Print
            </button>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Today's Total</div>
                            <h3 class="mb-0 fw-bold"><?= $today_total ?></h3>
                            <div class="text-secondary small">Total students today</div>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-users text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Present Today</div>
                            <h3 class="mb-0 fw-bold text-success"><?= $today_present ?></h3>
                            <div class="text-secondary small"><?= $today_total > 0 ? round(($today_present/$today_total)*100) : 0 ?>% attendance</div>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Absent Today</div>
                            <h3 class="mb-0 fw-bold text-danger"><?= $today_absent ?></h3>
                            <div class="text-secondary small"><?= $today_total > 0 ? round(($today_absent/$today_total)*100) : 0 ?>% absent</div>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-times-circle text-danger fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Monthly Present</div>
                            <h3 class="mb-0 fw-bold text-info"><?= $monthly_present ?></h3>
                            <div class="text-secondary small">This month</div>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-calendar-check text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($_SESSION['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0"><i class="fas fa-clipboard-check text-primary me-2"></i>Mark Attendance</h5>
                <span class="text-secondary small">Select class and date to mark attendance</span>
            </div>            
            <form method="get" class="row g-3 mb-4" id="attendanceFilterForm">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Select Class <span class="text-danger">*</span></label>
                    <select class="form-select" name="class_id" id="classSelect" required>
                        <option value="">Select Class</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class['id'] ?>" <?= $selected_class_id == $class['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($class['class_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="attendance_date" value="<?= $selected_date ?>" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 w-100">
                        <i class="fas fa-search me-2"></i>Load Students
                    </button>
                </div>
            </form>
            <?php if ($selected_class_id > 0 && count($students) > 0): ?>
                <form method="post" class="row g-3">
                    <input type="hidden" name="class_id" value="<?= $selected_class_id ?>">
                    <input type="hidden" name="attendance_date" value="<?= $selected_date ?>">                    
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-custom align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>
                                            <div class="d-flex gap-2 flex-wrap">
                                                <button type="button" class="btn btn-sm btn-success" onclick="markAll('Present')">
                                                    <i class="fas fa-check me-1"></i>All Present
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="markAll('Absent')">
                                                    <i class="fas fa-times me-1"></i>All Absent
                                                </button>
                                                <button type="button" class="btn btn-sm btn-warning" onclick="markAll('Leave')">
                                                    <i class="fas fa-clock me-1"></i>All Leave
                                                </button>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach ($students as $student): ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><strong><?= htmlspecialchars($student['name']) ?></strong></td>
                                            <td>
                                                <input type="hidden" name="student_ids[]" value="<?= $student['id'] ?>">
                                                <div class="btn-group" role="group">
                                                    <input type="radio" class="btn-check" name="status[<?= $student['id'] ?>]" 
                                                           id="present_<?= $student['id'] ?>" value="Present" 
                                                           <?= (isset($attendance_data[$student['id']]) && $attendance_data[$student['id']] == 'Present') || !isset($attendance_data[$student['id']]) ? 'checked' : '' ?>>
                                                    <label class="btn btn-outline-success btn-sm" for="present_<?= $student['id'] ?>">
                                                        <i class="fas fa-check"></i> Present
                                                    </label>
                                                    
                                                    <input type="radio" class="btn-check" name="status[<?= $student['id'] ?>]" 
                                                           id="absent_<?= $student['id'] ?>" value="Absent"
                                                           <?= isset($attendance_data[$student['id']]) && $attendance_data[$student['id']] == 'Absent' ? 'checked' : '' ?>>
                                                    <label class="btn btn-outline-danger btn-sm" for="absent_<?= $student['id'] ?>">
                                                        <i class="fas fa-times"></i> Absent
                                                    </label>                                                    
                                                    <input type="radio" class="btn-check" name="status[<?= $student['id'] ?>]" 
                                                           id="leave_<?= $student['id'] ?>" value="Leave"
                                                           <?= isset($attendance_data[$student['id']]) && $attendance_data[$student['id']] == 'Leave' ? 'checked' : '' ?>>
                                                    <label class="btn btn-outline-warning btn-sm" for="leave_<?= $student['id'] ?>">
                                                        <i class="fas fa-clock"></i> Leave
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>                    
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-undo me-2"></i>Reset
                        </button>
                        <button type="submit" name="mark_attendance" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-save me-2"></i>Save Attendance
                        </button>
                    </div>
                </form>
            <?php elseif ($selected_class_id > 0 && count($students) == 0): ?>
                <div class="alert alert-warning rounded-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    No students found in this class. Please add students first.
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-header bg-transparent border-bottom-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="fas fa-history text-primary me-2"></i>Recent Attendance Records</h6>
                <span class="text-secondary small">Last 10 records</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Class</th>
                            <th>Student</th>
                            <th>Status</th>
                            <th>Marked By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $stmt = $conn->query("SELECT a.*, u.name as marked_by_name 
                                                  FROM attendance a 
                                                  LEFT JOIN users u ON a.marked_by = u.id 
                                                  ORDER BY a.attendance_date DESC, a.id DESC 
                                                  LIMIT 10");
                            $recent_attendance = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        } catch (Exception $e) {
                            $recent_attendance = [];
                        }
                        ?>
                        <?php if (count($recent_attendance) > 0): ?>
                            <?php $i = 1; foreach ($recent_attendance as $record): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= date('d M Y', strtotime($record['attendance_date'])) ?></td>
                                    <td><span class="badge bg-light text-dark"><?= htmlspecialchars($record['class_name']) ?></span></td>
                                    <td><strong><?= htmlspecialchars($record['student_name']) ?></strong></td>
                                    <td>
                                        <?php if ($record['status'] == 'Present'): ?>
                                            <span class="status-badge bg-success-subtle text-success">
                                                <i class="fas fa-check-circle me-1"></i>Present
                                            </span>
                                        <?php elseif ($record['status'] == 'Absent'): ?>
                                            <span class="status-badge bg-danger-subtle text-danger">
                                                <i class="fas fa-times-circle me-1"></i>Absent
                                            </span>
                                        <?php else: ?>
                                            <span class="status-badge bg-warning-subtle text-warning">
                                                <i class="fas fa-clock me-1"></i>Leave
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td><small class="text-secondary"><?= htmlspecialchars($record['marked_by_name'] ?? 'Admin') ?></small></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-secondary">
                                    <i class="fas fa-inbox fa-3x d-block mb-2 text-muted"></i>
                                    No attendance records found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if (count($recent_attendance) > 0): ?>
            <div class="card-footer bg-transparent border-top-0 p-3">
                <div class="text-secondary small">
                    <i class="fas fa-list me-1"></i>Showing last <?= count($recent_attendance) ?> records
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<script>
    function markAll(status) {
        const radios = document.querySelectorAll('input[type="radio"][name^="status["]');
        radios.forEach(radio => {
            if (radio.value === status) {
                radio.checked = true;
            }
        });
    }
</script>
<?php 
include 'includes/footer.php';
ob_end_flush();
?>