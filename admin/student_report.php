<?php
include '../config/config.php';
include 'includes/auth_check.php';
checkRole(['admin']);

function fetchStudents($conn)
{
    try {
        $stmt = $conn->query("SELECT s.*, c.class_name, sec.section_name FROM students s LEFT JOIN classes c ON s.class_id = c.id LEFT JOIN sections sec ON s.section_id = sec.id ORDER BY s.id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return [];
    }
}

function exportExcel($students)
{
    $rows = [];
    $rows[] = ['Admission No', 'Student Name', 'Class', 'Father Name', 'Contact', 'Date', 'Status', 'Student Type', 'Admission Fees'];

    foreach ($students as $student) {
        $rows[] = [
            $student['admission_no'] ?? '—',
            $student['name'] ?? '—',
            $student['class_name'] ?? '—',
            $student['father_name'] ?? '—',
            $student['parent_phone'] ?? $student['phone'] ?? '—',
            !empty($student['created_at']) ? date('d M Y', strtotime($student['created_at'])) : '—',
            $student['status'] ?? '—',
            $student['student_type'] ?? '—',
            '₹' . number_format((float)($student['admission_fees'] ?? 0), 2),
        ];
    }

    header('Content-Type: application/vnd.ms-excel; charset=utf-8');
    header('Content-Disposition: attachment; filename="student_report.xls"');
    echo "\xEF\xBB\xBF";
    $output = fopen('php://output', 'w');
    foreach ($rows as $row) {
        $cleanRow = array_map(function ($value) {
            return str_replace(["\r", "\n"], ' ', (string) $value);
        }, $row);
        fputcsv($output, $cleanRow, "\t");
    }
    fclose($output);
    exit();
}

function exportPdf($students)
{
    $lines = [];
    $lines[] = 'Student Admission Report';
    $lines[] = 'Generated: ' . date('d M Y H:i:s');
    $lines[] = '';

    foreach ($students as $index => $student) {
        $lines[] = ($index + 1) . '. ' . ($student['admission_no'] ?? '—')
            . ' | ' . ($student['name'] ?? '—')
            . ' | ' . ($student['class_name'] ?? '—')
            . ' | ' . ($student['father_name'] ?? '—')
            . ' | ' . ($student['parent_phone'] ?? $student['phone'] ?? '—')
            . ' | ' . ($student['student_type'] ?? '—')
            . ' | ' . number_format((float)($student['admission_fees'] ?? 0), 2);
    }

    $contentStream = '';
    $y = 770;
    foreach ($lines as $line) {
        $escapedLine = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $line);
        $contentStream .= "BT /F1 10 Tf 50 {$y} Td ({$escapedLine}) Tj ET\n";
        $y -= 12;
    }

    $objects = [];
    $objects[] = "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj";
    $objects[] = "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj";
    $objects[] = "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\nendobj";
    $objects[] = "4 0 obj\n<< /Length " . strlen($contentStream) . " >>\nstream\n" . $contentStream . "\nendstream\nendobj";
    $objects[] = "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj";

    $pdf = "%PDF-1.4\n";
    $offsets = [];
    foreach ($objects as $object) {
        $offsets[] = strlen($pdf);
        $pdf .= $object . "\n";
    }

    $startxref = strlen($pdf);
    $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
    $pdf .= "0000000000 65535 f \n";
    foreach ($offsets as $offset) {
        $pdf .= str_pad($offset, 10, '0', STR_PAD_LEFT) . " 00000 n \n";
    }
    $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n" . $startxref . "\n%%EOF";

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="student_report.pdf"');
    echo $pdf;
    exit();
}

// ====== HANDLE ID CARD PRINT (PERFECT VERSION) ======
if (isset($_GET['print_id'])) {
    $student_id = intval($_GET['print_id']);
    try {
        $stmt = $conn->prepare("SELECT s.*, c.class_name, sec.section_name FROM students s LEFT JOIN classes c ON s.class_id = c.id LEFT JOIN sections sec ON s.section_id = sec.id WHERE s.id = ?");
        $stmt->execute([$student_id]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($student) {
            $school_name = "KARTIKEY SCHOOL";
            $school_tagline = "Promised To Ensure Quality Education.";
            $school_logo = "../images/logo.png";
            
            $photo = !empty($student['photo']) ? '../uploads/students/' . $student['photo'] : '';
            $default_photo = 'https://ui-avatars.com/api/?name=' . urlencode($student['name']) . '&background=2563eb&color=fff&size=120';
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>ID Card - <?= htmlspecialchars($student['name']) ?></title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
                <style>
                    @page {
                        size: 400px 560px;
                        margin: 0;
                    }
                    * { margin: 0; padding: 0; box-sizing: border-box; }
                    body { 
                        display: flex; 
                        justify-content: center; 
                        align-items: center; 
                        min-height: 100vh; 
                        background: #f0f2f5;
                        font-family: 'Segoe UI', Tahoma, Arial, sans-serif;
                    }
                    .id-card {
                        background: white;
                        width: 380px;
                        min-height: 540px;
                        border-radius: 14px;
                        padding: 16px 22px 14px 22px;
                        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
                        border: 1px solid #e5e7eb;
                        position: relative;
                        overflow: hidden;
                    }
                    .id-card .top-line {
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 4px;
                        background: linear-gradient(90deg, #1a56db, #7c3aed, #1a56db);
                        z-index: 2;
                    }
                    .id-card::before {
                        content: '';
                        position: absolute;
                        top: -70px;
                        right: -70px;
                        width: 200px;
                        height: 200px;
                        background: linear-gradient(135deg, #1a56db, #7c3aed);
                        border-radius: 50%;
                        opacity: 0.06;
                    }
                    .id-card::after {
                        content: '';
                        position: absolute;
                        bottom: -50px;
                        left: -50px;
                        width: 150px;
                        height: 150px;
                        background: linear-gradient(135deg, #2563eb, #7c3aed);
                        border-radius: 50%;
                        opacity: 0.05;
                    }
                    .card-header {
                        text-align: center;
                        border-bottom: 2px solid #2563eb;
                        padding-bottom: 8px;
                        margin-bottom: 8px;
                        position: relative;
                        z-index: 1;
                    }
                    .school-logo {
                        width: 52px;
                        height: 52px;
                        border-radius: 50%;
                        object-fit: cover;
                        border: 3px solid #2563eb;
                        padding: 2px;
                        margin-bottom: 1px;
                    }
                    .school-name {
                        font-size: 16px;
                        font-weight: 800;
                        color: #1a1a2e;
                        letter-spacing: 1.5px;
                    }
                    .school-tagline {
                        font-size: 8px;
                        color: #6b7280;
                        letter-spacing: 1.2px;
                        font-weight: 500;
                        margin-top: -1px;
                    }
                    .card-title {
                        background: linear-gradient(135deg, #2563eb, #7c3aed);
                        color: white;
                        padding: 2px 16px;
                        border-radius: 20px;
                        font-size: 11px;
                        font-weight: 700;
                        display: inline-block;
                        letter-spacing: 2.5px;
                        margin: 3px 0 5px 0;
                    }
                    .student-photo {
                        width: 90px;
                        height: 90px;
                        border-radius: 50%;
                        border: 4px solid #2563eb;
                        object-fit: cover;
                        margin: 0 auto 6px auto;
                        display: block;
                        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
                    }
                    .card-body {
                        position: relative;
                        z-index: 1;
                        padding: 0;
                    }
                    .info-row {
                        display: flex;
                        padding: 2.5px 0;
                        font-size: 12px;
                        align-items: baseline;
                        line-height: 1.4;
                    }
                    .info-label {
                        font-weight: 600;
                        color: #4b5563;
                        width: 105px;
                        flex-shrink: 0;
                        font-size: 11.5px;
                        letter-spacing: 0.2px;
                    }
                    .info-value {
                        font-weight: 600;
                        color: #1a1a2e;
                        flex: 1;
                        font-size: 12px;
                        padding-left: 2px;
                    }
                    .card-footer {
                        margin-top: 8px;
                        padding-top: 8px;
                        border-top: 2px solid #2563eb;
                        text-align: center;
                        position: relative;
                        z-index: 1;
                    }
                    .principal-sign {
                        font-size: 10px;
                        color: #6b7280;
                        letter-spacing: 0.3px;
                    }
                    .principal-sign .sign-line {
                        display: inline-block;
                        width: 100px;
                        border-top: 2px solid #1a1a2e;
                        margin-top: 2px;
                    }
                    .valid-till {
                        font-size: 9px;
                        color: #6b7280;
                        margin-top: 3px;
                        letter-spacing: 0.3px;
                    }
                    .watermark {
                        position: absolute;
                        bottom: 20px;
                        right: 12px;
                        font-size: 6.5px;
                        color: #d1d5db;
                        letter-spacing: 1px;
                        transform: rotate(-5deg);
                        opacity: 0.3;
                        z-index: 0;
                    }
                    @media print {
                        body { background: white; }
                        .id-card { 
                            box-shadow: none; 
                            border: 1px solid #ddd;
                            page-break-after: avoid;
                            width: 100%;
                            min-height: 100vh;
                            border-radius: 0;
                        }
                        .no-print { display: none !important; }
                    }
                </style>
            </head>
            <body>
                <div class="id-card">
                    <div class="top-line"></div>
                    <div class="watermark">KARTIKEY SCHOOL</div>
                    
                    <div class="card-header">
                        <img src="<?= $school_logo ?>" alt="School Logo" class="school-logo" 
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
                        <div style="display:none; font-size:28px;">🏫</div>
                        <div class="school-name">KARTIKEY SCHOOL</div>
                        <div class="school-tagline">Promised To Ensure Quality Education.</div>
                        <div class="card-title">ID CARD</div>
                    </div>
                    
                    <img src="<?= $photo ? $photo : $default_photo ?>" 
                         alt="<?= htmlspecialchars($student['name']) ?>" 
                         class="student-photo"
                         onerror="this.src='<?= $default_photo ?>'">
                    
                    <div class="card-body">
                        <div class="info-row">
                            <span class="info-label">Name</span>
                            <span class="info-value">: <?= htmlspecialchars($student['name']) ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Class</span>
                            <span class="info-value">: <?= htmlspecialchars($student['class_name'] ?? 'N/A') ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Section</span>
                            <span class="info-value">: <?= htmlspecialchars($student['section_name'] ?? 'N/A') ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Admission No</span>
                            <span class="info-value">: <?= htmlspecialchars($student['admission_no']) ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Date of Birth</span>
                            <span class="info-value">: <?= !empty($student['dob']) ? date('d-m-Y', strtotime($student['dob'])) : 'N/A' ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Blood Group</span>
                            <span class="info-value">: <?= htmlspecialchars($student['blood_group'] ?? 'N/A') ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Mobile</span>
                            <span class="info-value">: <?= htmlspecialchars($student['parent_phone'] ?? $student['phone'] ?? 'N/A') ?></span>
                        </div>
                        <?php if (!empty($student['parent_email'])): ?>
                        <div class="info-row">
                            <span class="info-label">Email</span>
                            <span class="info-value">: <?= htmlspecialchars($student['parent_email']) ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="info-row">
                            <span class="info-label">Session</span>
                            <span class="info-value">: <?= date('Y') . '-' . (date('Y') + 1) ?></span>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="principal-sign">
                            <div>Principal</div>
                            <div class="sign-line"></div>
                        </div>
                        <div class="valid-till">
                            <i class="fas fa-qrcode me-1"></i> Valid till: <?= date('M Y', strtotime('+1 year')) ?>
                        </div>
                    </div>
                </div>
                
                <script>
                    window.onload = function() {
                        setTimeout(function() {
                            window.print();
                        }, 600);
                    }
                </script>
            </body>
            </html>
            <?php
            exit();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}

if (isset($_GET['export']) && in_array($_GET['export'], ['excel', 'pdf'], true)) {
    $students = fetchStudents($conn);
    if ($_GET['export'] === 'excel') {
        exportExcel($students);
    }
    exportPdf($students);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_student'])) {
    $student_id = intval($_POST['student_id'] ?? 0);
    if ($student_id > 0) {
        try {
            $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
            $stmt->execute([$student_id]);
            $_SESSION['success'] = 'Student deleted successfully.';
        } catch (Exception $e) {
            $error = 'Failed to delete student.';
        }
    }
    header('Location: student_report.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_student'])) {
    $student_id = intval($_POST['student_id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $father_name = trim($_POST['father_name'] ?? '');
    $parent_phone = trim($_POST['parent_phone'] ?? '');
    $class_id = intval($_POST['class_id'] ?? 0);
    $status = trim($_POST['status'] ?? 'Active');
    $student_type = trim($_POST['student_type'] ?? 'Non-RTO');
    $admission_fees = number_format(floatval($_POST['admission_fees'] ?? 0), 2, '.', '');
    $blood_group = trim($_POST['blood_group'] ?? '');

    if ($student_id > 0 && $name !== '') {
        try {
            $stmt = $conn->prepare("UPDATE students SET name = ?, father_name = ?, parent_phone = ?, class_id = ?, status = ?, student_type = ?, admission_fees = ?, blood_group = ? WHERE id = ?");
            $stmt->execute([$name, $father_name, $parent_phone, $class_id, $status, $student_type, $admission_fees, $blood_group, $student_id]);
            $_SESSION['success'] = 'Student updated successfully.';
        } catch (Exception $e) {
            $error = 'Failed to update student.';
        }
    } else {
        $error = 'Student name is required.';
    }

    header('Location: student_report.php');
    exit();
}

try {
    $stmt = $conn->query("SELECT id, class_name FROM classes WHERE status = 'Active' ORDER BY class_name");
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $classes = [];
}

$students = fetchStudents($conn);

$selected_student = null;
$mode = '';
if (isset($_GET['view_id'])) {
    $view_id = intval($_GET['view_id']);
    foreach ($students as $student) {
        if ((int)$student['id'] === $view_id) {
            $selected_student = $student;
            $mode = 'view';
            break;
        }
    }
} elseif (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    foreach ($students as $student) {
        if ((int)$student['id'] === $edit_id) {
            $selected_student = $student;
            $mode = 'edit';
            break;
        }
    }
}

include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Student Admission Report</h3>
            <div class="text-secondary small">View and manage student admission information.</div>
        </div>
        <div class="d-flex gap-2">
            <a href="student_report.php?export=pdf" class="btn btn-outline-primary rounded-pill px-3">
                <i class="fas fa-file-pdf me-2"></i>PDF
            </a>
            <a href="student_report.php?export=excel" class="btn btn-outline-success rounded-pill px-3">
                <i class="fas fa-file-excel me-2"></i>Excel
            </a>
            <button class="btn btn-primary rounded-pill px-3" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Print
            </button>
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

    <?php if ($selected_student): ?>
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="fas fa-user-graduate text-primary me-2"></i><?= $mode === 'edit' ? 'Edit Student' : 'Student Details' ?></h5>
                <a href="student_report.php" class="btn btn-outline-secondary rounded-pill px-3">Close</a>
            </div>
            <?php if ($mode === 'edit'): ?>
            <form method="post" class="row g-3">
                <input type="hidden" name="student_id" value="<?= (int)$selected_student['id'] ?>">
                <div class="col-md-4">
                    <label class="form-label">Student Name</label>
                    <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($selected_student['name'] ?? '') ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Father Name</label>
                    <input type="text" class="form-control" name="father_name" value="<?= htmlspecialchars($selected_student['father_name'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Parent Phone</label>
                    <input type="text" class="form-control" name="parent_phone" value="<?= htmlspecialchars($selected_student['parent_phone'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Class</label>
                    <select class="form-select" name="class_id">
                        <option value="">Select Class</option>
                        <?php foreach ($classes as $class): ?>
                        <option value="<?= (int)$class['id'] ?>" <?= ((int)($selected_student['class_id'] ?? 0) === (int)$class['id']) ? 'selected' : '' ?>><?= htmlspecialchars($class['class_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="Active" <?= (($selected_student['status'] ?? '') === 'Active') ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?= (($selected_student['status'] ?? '') === 'Inactive') ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Student Type</label>
                    <select class="form-select" name="student_type">
                        <option value="Non-RTO" <?= (($selected_student['student_type'] ?? '') === 'Non-RTO') ? 'selected' : '' ?>>Non-RTO</option>
                        <option value="RTO" <?= (($selected_student['student_type'] ?? '') === 'RTO') ? 'selected' : '' ?>>RTO</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Admission Fees (₹)</label>
                    <input type="number" class="form-control" name="admission_fees" value="<?= htmlspecialchars($selected_student['admission_fees'] ?? '0') ?>" min="0" step="0.01">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Blood Group</label>
                    <select class="form-select" name="blood_group">
                        <option value="" <?= (($selected_student['blood_group'] ?? '') === '') ? 'selected' : '' ?>>Select Blood Group</option>
                        <option value="A+" <?= (($selected_student['blood_group'] ?? '') === 'A+') ? 'selected' : '' ?>>A+</option>
                        <option value="A-" <?= (($selected_student['blood_group'] ?? '') === 'A-') ? 'selected' : '' ?>>A-</option>
                        <option value="B+" <?= (($selected_student['blood_group'] ?? '') === 'B+') ? 'selected' : '' ?>>B+</option>
                        <option value="B-" <?= (($selected_student['blood_group'] ?? '') === 'B-') ? 'selected' : '' ?>>B-</option>
                        <option value="AB+" <?= (($selected_student['blood_group'] ?? '') === 'AB+') ? 'selected' : '' ?>>AB+</option>
                        <option value="AB-" <?= (($selected_student['blood_group'] ?? '') === 'AB-') ? 'selected' : '' ?>>AB-</option>
                        <option value="O+" <?= (($selected_student['blood_group'] ?? '') === 'O+') ? 'selected' : '' ?>>O+</option>
                        <option value="O-" <?= (($selected_student['blood_group'] ?? '') === 'O-') ? 'selected' : '' ?>>O-</option>
                    </select>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" name="update_student" class="btn btn-primary rounded-pill px-3">Update</button>
                    <a href="student_report.php" class="btn btn-outline-secondary rounded-pill px-3">Cancel</a>
                </div>
            </form>
            <?php else: ?>
            <div class="row g-3">
                <div class="col-md-4"><strong>Admission No:</strong><br><?= htmlspecialchars($selected_student['admission_no'] ?? '—') ?></div>
                <div class="col-md-4"><strong>Student Name:</strong><br><?= htmlspecialchars($selected_student['name'] ?? '—') ?></div>
                <div class="col-md-4"><strong>Class:</strong><br><?= htmlspecialchars($selected_student['class_name'] ?? '—') ?></div>
                <div class="col-md-4"><strong>Father Name:</strong><br><?= htmlspecialchars($selected_student['father_name'] ?? '—') ?></div>
                <div class="col-md-4"><strong>Parent Phone:</strong><br><?= htmlspecialchars($selected_student['parent_phone'] ?? '—') ?></div>
                <div class="col-md-4"><strong>Student Type:</strong><br><?= htmlspecialchars($selected_student['student_type'] ?? '—') ?></div>
                <div class="col-md-4"><strong>Admission Fees:</strong><br>₹<?= number_format((float)($selected_student['admission_fees'] ?? 0), 2) ?></div>
                <div class="col-md-4"><strong>Status:</strong><br><?= htmlspecialchars($selected_student['status'] ?? '—') ?></div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-search text-secondary"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="searchInput"
                            placeholder="Search by name, admission no..." />
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="classFilter">
                        <option value="">All Classes</option>
                        <?php foreach ($classes as $class): ?>
                        <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['class_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100 rounded-pill" onclick="filterTable()">
                        <i class="fas fa-search me-2"></i> Search
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0" id="studentTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Admission No</th>
                            <th>Student Name</th>
                            <th>Class</th>
                            <th>Father Name</th>
                            <th>Contact</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($students) > 0): ?>
                        <?php $i = 1; foreach ($students as $student): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><span class="badge bg-light text-dark"><?= htmlspecialchars($student['admission_no'] ?? '—') ?></span></td>
                            <td><strong><?= htmlspecialchars($student['name'] ?? '—') ?></strong></td>
                            <td><?= htmlspecialchars($student['class_name'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($student['father_name'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($student['parent_phone'] ?? $student['phone'] ?? '—') ?></td>
                            <td><?= !empty($student['created_at']) ? date('d M Y', strtotime($student['created_at'])) : '—' ?></td>
                            <td>
                                <?php if (($student['status'] ?? '') === 'Active'): ?>
                                <span class="status-badge bg-success-subtle text-success">✅ Active</span>
                                <?php else: ?>
                                <span class="status-badge bg-danger-subtle text-danger">❌ Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center flex-wrap">
                                    <a href="student_report.php?view_id=<?= (int)$student['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="student_report.php?edit_id=<?= (int)$student['id'] ?>" class="btn btn-sm btn-outline-warning rounded-pill" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="student_report.php?print_id=<?= (int)$student['id'] ?>" class="btn btn-sm btn-outline-success rounded-pill" title="ID Card" target="_blank">
                                        <i class="fas fa-id-card"></i>
                                    </a>
                                    <form method="post" class="d-inline" onsubmit="return confirm('Delete this student?');">
                                        <input type="hidden" name="student_id" value="<?= (int)$student['id'] ?>">
                                        <button type="submit" name="delete_student" class="btn btn-sm btn-outline-danger rounded-pill" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-4 text-secondary">
                                <i class="fas fa-inbox fa-3x d-block mb-2 text-muted"></i>
                                No admissions found.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent border-top-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-secondary small">Total: <?= count($students) ?> students</div>
                <nav>
                    <ul class="pagination pagination-custom mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
function filterTable() {
    var input = document.getElementById('searchInput');
    var filter = input.value.toLowerCase();
    var table = document.getElementById('studentTable');
    var rows = table.getElementsByTagName('tr');
    
    for (var i = 1; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName('td');
        var found = false;
        
        for (var j = 0; j < cells.length; j++) {
            var cell = cells[j];
            if (cell) {
                var text = cell.textContent || cell.innerText;
                if (text.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }
        
        if (found) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}

document.getElementById('searchInput').addEventListener('keyup', filterTable);
document.getElementById('classFilter').addEventListener('change', filterTable);
document.getElementById('statusFilter').addEventListener('change', filterTable);
</script>

<?php
include 'includes/footer.php';
?>