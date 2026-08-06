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
    $address = trim($_POST['address'] ?? '');
    $class_id = intval($_POST['class_id'] ?? 0);
    $status = trim($_POST['status'] ?? 'Active');
    $student_type = trim($_POST['student_type'] ?? 'Non-RTO');
    $admission_fees = number_format(floatval($_POST['admission_fees'] ?? 0), 2, '.', '');
    $blood_group = trim($_POST['blood_group'] ?? '');

    if ($student_id > 0 && $name !== '') {
        try {
            $stmt = $conn->prepare("UPDATE students SET name = ?, father_name = ?, parent_phone = ?, address = ?, class_id = ?, status = ?, student_type = ?, admission_fees = ?, blood_group = ? WHERE id = ?");
            $stmt->execute([$name, $father_name, $parent_phone, $address, $class_id, $status, $student_type, $admission_fees, $blood_group, $student_id]);
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

<style>
.document-link {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 11px;
    text-decoration: none;
    margin: 2px;
}
.document-link:hover {
    opacity: 0.8;
}
.document-link .badge {
    font-size: 10px;
}
.student-photo-sm {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #2563eb;
}
.doc-card {
    transition: all 0.3s ease;
}
.doc-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}
.file-missing {
    background: #fef2f2;
    border: 1px solid #fecaca;
    border-radius: 8px;
    padding: 5px 10px;
    font-size: 11px;
    color: #dc2626;
}
</style>

<!-- ====== MAIN CONTENT ====== -->
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
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($selected_student['address'] ?? '') ?>">
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
            <!-- Student Details View -->
            <div class="row g-3">
                <div class="col-md-3"><strong>Admission No:</strong><br><?= htmlspecialchars($selected_student['admission_no'] ?? '—') ?></div>
                <div class="col-md-3"><strong>Student Name:</strong><br><?= htmlspecialchars($selected_student['name'] ?? '—') ?></div>
                <div class="col-md-3"><strong>Class:</strong><br><?= htmlspecialchars($selected_student['class_name'] ?? '—') ?></div>
                <div class="col-md-3"><strong>Section:</strong><br><?= htmlspecialchars($selected_student['section_name'] ?? '—') ?></div>
                <div class="col-md-3"><strong>Father Name:</strong><br><?= htmlspecialchars($selected_student['father_name'] ?? '—') ?></div>
                <div class="col-md-3"><strong>Parent Phone:</strong><br><?= htmlspecialchars($selected_student['parent_phone'] ?? '—') ?></div>
                <div class="col-md-3"><strong>Parent Email:</strong><br><?= htmlspecialchars($selected_student['parent_email'] ?? '—') ?></div>
                <div class="col-md-3"><strong>Blood Group:</strong><br><?= htmlspecialchars($selected_student['blood_group'] ?? '—') ?></div>
                <div class="col-md-3"><strong>Student Type:</strong><br><?= htmlspecialchars($selected_student['student_type'] ?? '—') ?></div>
                <div class="col-md-3"><strong>Admission Fees:</strong><br>₹<?= number_format((float)($selected_student['admission_fees'] ?? 0), 2) ?></div>
                <div class="col-md-3"><strong>Status:</strong><br><?= htmlspecialchars($selected_student['status'] ?? '—') ?></div>
                <div class="col-md-3"><strong>Address:</strong><br><?= nl2br(htmlspecialchars($selected_student['address'] ?? '—')) ?></div>
            </div>
            
            <!-- ====== UPLOADED DOCUMENTS ====== -->
            <div class="mt-4">
                <h6 class="fw-bold"><i class="fas fa-file-alt text-primary me-2"></i>Uploaded Documents</h6>
                <hr>
                <div class="row g-3">
                    <?php
                    $documents = [
                        'photo' => ['label' => '📸 Photo', 'icon' => 'fa-image', 'color' => 'primary', 'is_image' => true],
                        'birth_certificate' => ['label' => '📄 Birth Certificate', 'icon' => 'fa-file-pdf', 'color' => 'danger'],
                        'marksheet' => ['label' => '📊 Marksheet', 'icon' => 'fa-file-alt', 'color' => 'success'],
                        'tc_certificate' => ['label' => '📜 TC Certificate', 'icon' => 'fa-file-pdf', 'color' => 'warning'],
                        'aadhaar' => ['label' => '🆔 Student Aadhaar', 'icon' => 'fa-id-card', 'color' => 'info'],
                        'father_aadhaar' => ['label' => '🆔 Father Aadhaar', 'icon' => 'fa-id-card', 'color' => 'secondary'],
                        'mother_aadhaar' => ['label' => '🆔 Mother Aadhaar', 'icon' => 'fa-id-card', 'color' => 'secondary']
                    ];
                    
                    $has_documents = false;
                    foreach ($documents as $field => $doc) {
                        $file = $selected_student[$field] ?? '';
                        if (!empty($file)) {
                            $file_path = '../uploads/students/' . $file;
                            $has_documents = true;
                            ?>
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm rounded-3 h-100 doc-card">
                                    <div class="card-body text-center p-3">
                                        <?php if ($doc['is_image'] ?? false): ?>
                                            <img src="<?= file_exists($file_path) ? $file_path : 'https://ui-avatars.com/api/?name=' . urlencode($selected_student['name'] ?? 'S') . '&background=2563eb&color=fff&size=100' ?>" 
                                                 alt="Photo" style="width:80px; height:80px; border-radius:50%; object-fit:cover; border:2px solid #2563eb; margin-bottom:8px;">
                                        <?php else: ?>
                                            <i class="fas <?= $doc['icon'] ?> fa-3x text-<?= $doc['color'] ?> mb-2"></i>
                                        <?php endif; ?>
                                        <div class="small fw-bold text-truncate"><?= $doc['label'] ?></div>
                                        <div class="text-secondary small text-truncate" style="font-size:10px;"><?= htmlspecialchars($file) ?></div>
                                        
                                        <?php if (file_exists($file_path)): ?>
                                            <div class="mt-2">
                                                <a href="<?= $file_path ?>" target="_blank" class="btn btn-sm btn-outline-<?= $doc['color'] ?> rounded-pill">
                                                    <i class="fas fa-eye me-1"></i> View
                                                </a>
                                                <a href="<?= $file_path ?>" download class="btn btn-sm btn-outline-secondary rounded-pill">
                                                    <i class="fas fa-download me-1"></i>
                                                </a>
                                            </div>
                                        <?php else: ?>
                                            <div class="file-missing mt-2">
                                                <i class="fas fa-exclamation-triangle me-1"></i> File Missing
                                            </div>
                                            <div class="text-secondary small mt-1" style="font-size:9px;">Please re-upload</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    
                    if (!$has_documents): 
                    ?>
                    <div class="col-12 text-center text-secondary py-4">
                        <i class="fas fa-file fa-3x d-block mb-3 text-muted"></i>
                        No documents uploaded for this student.
                    </div>
                    <?php endif; ?>
                </div>
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
                            <th>Photo</th>
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
                            <td>
                                <?php if (!empty($student['photo']) && file_exists('../uploads/students/' . $student['photo'])): ?>
                                <img src="../uploads/students/<?= htmlspecialchars($student['photo']) ?>" 
                                     alt="Student" class="student-photo-sm"
                                     onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($student['name'] ?? 'S') ?>&background=2563eb&color=fff&size=35'">
                                <?php else: ?>
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($student['name'] ?? 'S') ?>&background=2563eb&color=fff&size=35" 
                                     alt="Student" class="student-photo-sm">
                                <?php endif; ?>
                            </td>
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
                            <td colspan="10" class="text-center py-4 text-secondary">
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