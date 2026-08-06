<?php
ob_start();
include '../config/config.php';
include 'includes/auth_check.php';
checkRole(['admin']);

// ====== FETCH CLASSES ======
try {
    $stmt = $conn->query("SELECT id, class_name FROM classes WHERE status = 'Active' ORDER BY class_name");
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $classes = [];
}

// ====== FETCH SECTIONS ======
try {
    $stmt = $conn->query("SELECT id, section_name FROM sections ORDER BY section_name");
    $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $sections = [];
}

// ====== FETCH FEE TYPES WITH AMOUNTS FROM FEES TABLE ======
$fee_data = [];
try {
    $stmt = $conn->query("SELECT DISTINCT fee_type, amount FROM fees WHERE status = 'Active' AND fee_type IS NOT NULL AND fee_type != '' ORDER BY fee_type");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $fee_data[$row['fee_type']] = floatval($row['amount']);
    }
} catch (Exception $e) {
    $fee_data = [];
}

$fee_types = array_keys($fee_data);
if (empty($fee_types)) {
    $fee_types = ['Tuition', 'Admission', 'Exam', 'Transport', 'Hostel', 'Library', 'Sports', 'Other'];
    $fee_data = [
        'Tuition' => 5000,
        'Admission' => 1000,
        'Exam' => 500,
        'Transport' => 1500,
        'Hostel' => 3000,
        'Library' => 300,
        'Sports' => 200,
        'Other' => 1000
    ];
}

// ====== HANDLE FEE COLLECTION ======
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['collect_fee'])) {
    $student_id = intval($_POST['student_id'] ?? 0);
    $fee_types_selected = $_POST['fee_type'] ?? [];
    $amount = floatval($_POST['amount'] ?? 0);
    $late_fee = floatval($_POST['late_fee'] ?? 0);
    $discount = floatval($_POST['discount'] ?? 0);
    $total_amount = floatval($_POST['total_amount'] ?? 0);
    $month = trim($_POST['month'] ?? date('F'));
    $year = intval($_POST['year'] ?? date('Y'));
    $payment_method = trim($_POST['payment_method'] ?? 'cash');
    $payment_date = trim($_POST['payment_date'] ?? date('Y-m-d'));
    $remarks = trim($_POST['remarks'] ?? '');
    $payment_status = trim($_POST['payment_status'] ?? 'Paid');

    if ($student_id === 0 || empty($fee_types_selected) || $amount <= 0) {
        $error = 'Please select a student and at least one fee type.';
    } else {
        try {
            $last_inserted_ids = [];
            $error_count = 0;
            
            foreach ($fee_types_selected as $fee_type) {
                // Check if fee already exists
                $stmt = $conn->prepare("SELECT id FROM student_fees WHERE student_id = ? AND month = ? AND year = ? AND fee_type = ?");
                $stmt->execute([$student_id, $month, $year, $fee_type]);
                
                if ($stmt->rowCount() > 0) {
                    $error = 'Fee "' . $fee_type . '" already collected for ' . $month . ' ' . $year;
                    $error_count++;
                } else {
                    // Get fee_id from fees table
                    $stmt2 = $conn->prepare("SELECT id FROM fees WHERE fee_type = ? AND class_id = (SELECT class_id FROM students WHERE id = ?) LIMIT 1");
                    $stmt2->execute([$fee_type, $student_id]);
                    $fee = $stmt2->fetch(PDO::FETCH_ASSOC);
                    $fee_id = $fee['id'] ?? 0;

                    // Get amount from fees table or use per fee amount
                    $per_fee_amount = $fee_data[$fee_type] ?? ($amount / count($fee_types_selected));

                    $stmt = $conn->prepare("INSERT INTO student_fees (student_id, fee_id, fee_type, amount_paid, late_fee, discount, total_amount, payment_method, remarks, payment_status, paid_on, month, year) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$student_id, $fee_id, $fee_type, $per_fee_amount, $late_fee, $discount, $total_amount, $payment_method, $remarks, $payment_status, $payment_date, $month, $year]);
                    $last_inserted_ids[] = $conn->lastInsertId();
                }
            }
            
            if ($error_count > 0 && empty($last_inserted_ids)) {
                $error = 'All fees already exist for this month.';
            } else {
                $_SESSION['success'] = '✅ Fee collected successfully for ' . count($last_inserted_ids) . ' fee type(s)!';
                $_SESSION['last_receipt_id'] = end($last_inserted_ids);
                ob_end_clean();
                header('Location: student_fees.php?success=1');
                exit();
            }
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// ====== HANDLE DELETE ======
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    try {
        $stmt = $conn->prepare("DELETE FROM student_fees WHERE id = ?");
        $stmt->execute([$delete_id]);
        $_SESSION['success'] = 'Fee record deleted successfully!';
        header('Location: student_fees.php');
        exit();
    } catch (Exception $e) {
        $error = 'Failed to delete record.';
    }
}

// ====== FETCH STUDENTS ======
$search = $_GET['search'] ?? '';
$class_filter = $_GET['class_id'] ?? '';
$section_filter = $_GET['section_id'] ?? '';
$students = [];
$selected_student = null;
$search_performed = false;

if (!empty($search) || !empty($class_filter) || !empty($section_filter)) {
    $search_performed = true;
    try {
        $sql = "SELECT s.*, c.class_name, sec.section_name 
                FROM students s 
                LEFT JOIN classes c ON s.class_id = c.id 
                LEFT JOIN sections sec ON s.section_id = sec.id 
                WHERE s.status = 'Active'";
        
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (s.name LIKE ? OR s.admission_no LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        
        if (!empty($class_filter)) {
            $sql .= " AND s.class_id = ?";
            $params[] = $class_filter;
        }
        
        if (!empty($section_filter)) {
            $sql .= " AND s.section_id = ?";
            $params[] = $section_filter;
        }
        
        $sql .= " ORDER BY s.name LIMIT 20";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $students = [];
    }
}

// Get selected student
if (isset($_GET['student_id']) && $_GET['student_id'] > 0) {
    $student_id = intval($_GET['student_id']);
    try {
        $stmt = $conn->prepare("SELECT s.*, c.class_name, sec.section_name 
                               FROM students s 
                               LEFT JOIN classes c ON s.class_id = c.id 
                               LEFT JOIN sections sec ON s.section_id = sec.id 
                               WHERE s.id = ?");
        $stmt->execute([$student_id]);
        $selected_student = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $selected_student = null;
    }
}

// ====== FETCH RECENT COLLECTIONS ======
try {
    $stmt = $conn->query("SELECT sf.*, s.name as student_name, s.admission_no, c.class_name 
                          FROM student_fees sf 
                          LEFT JOIN students s ON sf.student_id = s.id 
                          LEFT JOIN classes c ON s.class_id = c.id 
                          ORDER BY sf.id DESC LIMIT 10");
    $recent_collections = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $recent_collections = [];
}

// ====== GET STATISTICS ======
try {
    $stmt = $conn->query("SELECT COUNT(*) as total, SUM(amount_paid) as total_amount FROM student_fees");
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_collections = $stats['total'] ?? 0;
    $total_amount = $stats['total_amount'] ?? 0;
} catch (Exception $e) {
    $total_collections = 0;
    $total_amount = 0;
}

try {
    $stmt = $conn->query("SELECT COUNT(*) as today_count, SUM(amount_paid) as today_amount FROM student_fees WHERE DATE(paid_on) = CURDATE()");
    $today_stats = $stmt->fetch(PDO::FETCH_ASSOC);
    $today_collections = $today_stats['today_count'] ?? 0;
    $today_amount = $today_stats['today_amount'] ?? 0;
} catch (Exception $e) {
    $today_collections = 0;
    $today_amount = 0;
}

include 'includes/header.php';
?>

<style>
.student-result {
    cursor: pointer;
    transition: all 0.2s;
    border-left: 3px solid transparent;
}
.student-result:hover {
    background: #f0f4ff !important;
    border-left-color: #2563eb;
}
.student-result.selected {
    background: #e8f0fe !important;
    border-left-color: #2563eb;
}
.student-details-box {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 15px 20px;
    border-left: 4px solid #2563eb;
    display: flex;
    flex-wrap: wrap;
    gap: 5px 25px;
}
.student-details-box .detail-item {
    font-size: 14px;
    white-space: nowrap;
}
.student-details-box .detail-item strong {
    color: #4b5563;
    font-weight: 600;
}
.total-amount-display {
    background: #f0f7ff;
    font-weight: 700;
    color: #2563eb;
    font-size: 18px;
    border: 2px solid #2563eb;
    text-align: center;
}
.fee-checkbox-group {
    display: flex;
    flex-wrap: wrap;
    gap: 8px 15px;
    padding: 10px 0;
}
.fee-checkbox-group .form-check {
    margin-right: 5px;
}
.fee-checkbox-group .form-check-input:checked {
    background-color: #2563eb;
    border-color: #2563eb;
}
.fee-checkbox-group .form-check-label {
    font-weight: 500;
    color: #1a1a2e;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 6px;
    transition: all 0.2s;
}
.fee-checkbox-group .form-check-label:hover {
    background: #f0f4ff;
}
.fee-checkbox-group .form-check-input:checked + .form-check-label {
    color: #2563eb;
}
.stats-card {
    transition: all 0.3s ease;
}
.stats-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}
.search-info {
    font-size: 13px;
    color: #6b7280;
    margin-top: 5px;
    padding-left: 5px;
}
.table-custom tbody tr {
    transition: all 0.2s;
}
.table-custom tbody tr:hover {
    background: #f8fafc;
}
</style>

<!-- ====== PAGE CONTENT ====== -->
<div class="main-content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-hand-holding-usd text-primary me-2"></i>Student Fee Collect</h3>
            <div class="text-secondary small">Collect and manage student fee payments.</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-pill px-3" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Print
            </button>
            <a href="fee_report.php" class="btn btn-outline-success rounded-pill px-3">
                <i class="fas fa-chart-bar me-2"></i>Reports
            </a>
        </div>
    </div>

    <!-- ====== STATISTICS CARDS ====== -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 rounded-4 shadow-sm stats-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Total Collections</div>
                            <h3 class="mb-0 fw-bold"><?= $total_collections ?></h3>
                            <div class="text-secondary small">All time</div>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-list text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 rounded-4 shadow-sm stats-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Total Amount</div>
                            <h3 class="mb-0 fw-bold text-success">₹<?= number_format($total_amount, 0) ?></h3>
                            <div class="text-secondary small">Collected</div>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-rupee-sign text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 rounded-4 shadow-sm stats-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Today's Collections</div>
                            <h3 class="mb-0 fw-bold text-info"><?= $today_collections ?></h3>
                            <div class="text-secondary small">₹<?= number_format($today_amount, 0) ?></div>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-calendar-day text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 rounded-4 shadow-sm stats-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Students Found</div>
                            <h3 class="mb-0 fw-bold text-warning"><?= count($students) ?></h3>
                            <div class="text-secondary small">Search results</div>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-users text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== SUCCESS/ERROR MESSAGES ====== -->
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

    <!-- ====== MAIN FORM CARD ====== -->
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0"><i class="fas fa-coins text-primary me-2"></i>Collect Fee</h5>
                <span class="text-secondary small">Enter student details and collect fee</span>
            </div>
            
            <!-- ====== SEARCH SECTION ====== -->
            <form method="get" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Search Student <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-search text-secondary"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" name="search" 
                               placeholder="Enter name, admission no..." 
                               value="<?= htmlspecialchars($search) ?>">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search me-1"></i>Search
                        </button>
                    </div>
                    <?php if ($search_performed && count($students) > 0): ?>
                    <div class="search-info">
                        <i class="fas fa-check-circle text-success me-1"></i> 
                        <?= count($students) ?> student(s) found
                    </div>
                    <?php elseif ($search_performed && count($students) == 0): ?>
                    <div class="search-info text-danger">
                        <i class="fas fa-exclamation-circle me-1"></i> 
                        No students found. Try different search.
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Select Class</label>
                    <select class="form-select" name="class_id" onchange="this.form.submit()">
                        <option value="">All Classes</option>
                        <?php foreach ($classes as $class): ?>
                        <option value="<?= $class['id'] ?>" <?= $class_filter == $class['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($class['class_name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Select Section</label>
                    <select class="form-select" name="section_id" onchange="this.form.submit()">
                        <option value="">All Sections</option>
                        <?php foreach ($sections as $section): ?>
                        <option value="<?= $section['id'] ?>" <?= $section_filter == $section['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($section['section_name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Select Student</label>
                    <select class="form-select" name="student_id" onchange="this.form.submit()">
                        <option value="">-- Select --</option>
                        <?php foreach ($students as $student): ?>
                        <option value="<?= $student['id'] ?>" <?= (isset($_GET['student_id']) && $_GET['student_id'] == $student['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($student['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>

            <!-- ====== STUDENT DETAILS ====== -->
            <?php if ($selected_student): ?>
            <div class="mt-4">
                <h6 class="fw-bold"><i class="fas fa-user-graduate text-primary me-2"></i>Student Details</h6>
                <div class="student-details-box">
                    <span class="detail-item"><strong>👤 Name:</strong> <?= htmlspecialchars($selected_student['name']) ?></span>
                    <span class="detail-item"><strong>🎓 Admission No:</strong> <?= htmlspecialchars($selected_student['admission_no']) ?></span>
                    <span class="detail-item"><strong>📚 Class:</strong> <?= htmlspecialchars($selected_student['class_name'] ?? 'N/A') ?></span>
                    <span class="detail-item"><strong>📋 Section:</strong> <?= htmlspecialchars($selected_student['section_name'] ?? 'N/A') ?></span>
                    <span class="detail-item"><strong>🩸 Blood Group:</strong> <?= htmlspecialchars($selected_student['blood_group'] ?? 'N/A') ?></span>
                    <span class="detail-item"><strong>📞 Contact:</strong> <?= htmlspecialchars($selected_student['parent_phone'] ?? $selected_student['phone'] ?? 'N/A') ?></span>
                </div>
            </div>

            <!-- ====== FEE DETAILS ====== -->
            <div class="mt-4">
                <h6 class="fw-bold"><i class="fas fa-file-invoice text-primary me-2"></i>Fee Details</h6>
                <hr>
                
                <form method="post" class="row g-3">
                    <input type="hidden" name="student_id" value="<?= $selected_student['id'] ?>">

                    <!-- Fee Type - CHECKBOXES -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Fee Type <span class="text-danger">*</span></label>
                        <div class="fee-checkbox-group">
                            <?php 
                            $fee_icons = [
                                'Tuition' => '📚',
                                'Admission' => '🎓',
                                'Exam' => '📝',
                                'Transport' => '🚌',
                                'Hostel' => '🏠',
                                'Library' => '📖',
                                'Sports' => '⚽',
                                'Other' => '📌'
                            ];
                            $i = 0;
                            foreach ($fee_types as $ft): 
                                $checked = ($i == 0) ? 'checked' : '';
                                $fee_amount = $fee_data[$ft] ?? 0;
                            ?>
                            <div class="form-check">
                                <input class="form-check-input fee-checkbox" type="checkbox" 
                                       name="fee_type[]" value="<?= htmlspecialchars($ft) ?>" 
                                       id="fee_<?= md5($ft) ?>"
                                       data-amount="<?= $fee_amount ?>"
                                       <?= $checked ?>>
                                <label class="form-check-label" for="fee_<?= md5($ft) ?>">
                                    <?= $fee_icons[$ft] ?? '📌' ?> <?= htmlspecialchars($ft) ?> Fee
                                    <?php if ($fee_amount > 0): ?>
                                    <span class="badge bg-primary">₹<?= number_format($fee_amount, 2) ?></span>
                                    <?php endif; ?>
                                </label>
                            </div>
                            <?php $i++; endforeach; ?>
                        </div>
                        <small class="text-secondary">Select one or more fee types</small>
                    </div>

                    <!-- Month -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Month/Period</label>
                        <select class="form-select" name="month">
                            <?php 
                            $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
                            $current_month = date('F');
                            foreach ($months as $m): 
                            ?>
                            <option value="<?= $m ?>" <?= $m == $current_month ? 'selected' : '' ?>><?= $m ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Amount - Auto filled -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Amount (₹)</label>
                        <input type="number" class="form-control" name="amount" id="feeAmount" 
                               placeholder="0" min="0" step="0.01" readonly 
                               style="background: #e8f5e9; font-weight: bold; color: #155724; border-color: #28a745;">
                    </div>

                    <!-- Late Fee -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Late Fee (₹)</label>
                        <input type="number" class="form-control" name="late_fee" id="lateFee" 
                               placeholder="100" min="0" step="0.01" value="0" oninput="calculateTotal()">
                    </div>

                    <!-- Discount -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Discount (₹)</label>
                        <input type="number" class="form-control" name="discount" id="discount" 
                               placeholder="0" min="0" step="0.01" value="0" oninput="calculateTotal()">
                    </div>

                    <!-- Total Amount -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Total Amount (₹)</label>
                        <input type="text" class="form-control total-amount-display" name="total_amount" 
                               id="totalAmount" value="₹ 0.00" readonly>
                    </div>

                    <!-- Payment Status -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Payment Status</label>
                        <select class="form-select" name="payment_status">
                            <option value="Paid">✅ Paid</option>
                            <option value="Partial">🟡 Partial</option>
                            <option value="Pending">🔴 Pending</option>
                        </select>
                    </div>

                    <!-- Payment Method -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Payment Method</label>
                        <select class="form-select" name="payment_method">
                            <option value="cash">💵 Cash</option>
                            <option value="bank_transfer">🏦 Bank Transfer</option>
                            <option value="card">💳 Credit/Debit Card</option>
                            <option value="upi">📱 UPI</option>
                            <option value="cheque">📝 Cheque</option>
                            <option value="online">🌐 Online Payment</option>
                        </select>
                    </div>

                    <!-- Payment Date -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Payment Date</label>
                        <input type="date" class="form-control" name="payment_date" value="<?= date('Y-m-d') ?>">
                    </div>

                    <!-- Remarks -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Remarks / Notes</label>
                        <input type="text" class="form-control" name="remarks" placeholder="Any additional notes...">
                    </div>

                    <input type="hidden" name="year" value="<?= date('Y') ?>">

                    <!-- ====== BUTTONS ====== -->
                    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                        <a href="student_fees.php" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="reset" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-undo me-2"></i>Reset
                        </button>
                        <button type="submit" name="collect_fee" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-save me-2"></i>Collect Fee
                        </button>
                        <button type="button" class="btn btn-success rounded-pill px-4" onclick="printLatestReceipt()">
                            <i class="fas fa-print me-2"></i>Print Receipt
                        </button>
                    </div>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ====== RECENT COLLECTIONS ====== -->
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-header bg-transparent border-bottom-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="fas fa-history text-primary me-2"></i>Recent Collections</h6>
                <span class="text-secondary small">Total: <?= count($recent_collections) ?> records</span>
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
                        <?php if (count($recent_collections) > 0): ?>
                        <?php $i = 1; foreach ($recent_collections as $collection): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><span class="badge bg-light text-dark">REC-<?= date('Y') ?>-<?= str_pad($collection['id'], 4, '0', STR_PAD_LEFT) ?></span></td>
                            <td><strong><?= htmlspecialchars($collection['student_name'] ?? 'N/A') ?></strong></td>
                            <td><?= htmlspecialchars($collection['class_name'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($collection['fee_type'] ?? 'N/A') ?></td>
                            <td><strong>₹<?= number_format($collection['amount_paid'] ?? 0, 2) ?></strong></td>
                            <td>
                                <?php
                                $method_icons = [
                                    'cash' => '💵',
                                    'bank_transfer' => '🏦',
                                    'card' => '💳',
                                    'upi' => '📱',
                                    'cheque' => '📝',
                                    'online' => '🌐'
                                ];
                                $method = $collection['payment_method'] ?? 'cash';
                                echo $method_icons[$method] ?? '💵';
                                ?>
                            </td>
                            <td><?= !empty($collection['paid_on']) ? date('d M Y', strtotime($collection['paid_on'])) : '—' ?></td>
                            <td>
                                <?php if ($collection['payment_status'] == 'Paid'): ?>
                                <span class="status-badge bg-success-subtle text-success">Paid</span>
                                <?php elseif ($collection['payment_status'] == 'Partial'): ?>
                                <span class="status-badge bg-warning-subtle text-warning">Partial</span>
                                <?php else: ?>
                                <span class="status-badge bg-danger-subtle text-danger">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="fee_receipt.php?id=<?= $collection['id'] ?>" 
                                       class="btn btn-sm btn-outline-primary rounded-circle" 
                                       title="View Receipt" 
                                       target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="fee_receipt.php?id=<?= $collection['id'] ?>&print=1" 
                                       class="btn btn-sm btn-outline-success rounded-circle" 
                                       title="Print Receipt" 
                                       target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <a href="javascript:void(0)" 
                                       class="btn btn-sm btn-outline-danger rounded-circle" 
                                       title="Delete" 
                                       onclick="deleteFee(<?= $collection['id'] ?>, '<?= htmlspecialchars(addslashes($collection['student_name'] ?? 'N/A')) ?>')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center py-4 text-secondary">
                                <i class="fas fa-inbox fa-3x d-block mb-2 text-muted"></i>
                                No collections found. Search and collect fee.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if (count($recent_collections) > 0): ?>
        <div class="card-footer bg-transparent border-top-0 p-3">
            <div class="text-secondary small">
                <i class="fas fa-list me-1"></i>Showing <?= count($recent_collections) ?> recent collections
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Calculate total amount
function calculateTotal() {
    const amount = parseFloat(document.getElementById('feeAmount').value) || 0;
    const lateFee = parseFloat(document.getElementById('lateFee').value) || 0;
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const total = amount + lateFee - discount;
    document.getElementById('totalAmount').value = '₹ ' + total.toFixed(2);
}

// Auto-update total when checkboxes change
document.addEventListener('DOMContentLoaded', function() {
    const feeCheckboxes = document.querySelectorAll('.fee-checkbox');
    const feeAmount = document.getElementById('feeAmount');
    
    if (feeCheckboxes.length > 0) {
        feeCheckboxes[0].checked = true;
    }
    
    feeCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const checkedBoxes = document.querySelectorAll('.fee-checkbox:checked');
            if (checkedBoxes.length > 0) {
                let total = 0;
                checkedBoxes.forEach(function(cb) {
                    total += parseFloat(cb.getAttribute('data-amount')) || 0;
                });
                feeAmount.value = total;
            } else {
                feeAmount.value = 0;
            }
            calculateTotal();
        });
    });
    
    calculateTotal();
});

// ====== PRINT LATEST RECEIPT ======
function printLatestReceipt() {
    const receiptLinks = document.querySelectorAll('a[href*="fee_receipt.php?id="]');
    
    if (receiptLinks.length > 0) {
        const firstLink = receiptLinks[0];
        const href = firstLink.getAttribute('href');
        window.open(href, '_blank');
    } else {
        alert('No receipt found to print. Please collect fee first.');
    }
}

function printReceipt() {
    printLatestReceipt();
}

// ====== DELETE FEE FUNCTION ======
function deleteFee(id, studentName) {
    if (confirm('Are you sure you want to delete fee record for "' + studentName + '"? This action cannot be undone.')) {
        window.location.href = 'student_fees.php?delete_id=' + id;
    }
}
</script>

<?php 
include 'includes/footer.php';
ob_end_flush();
?>