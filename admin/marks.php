<?php
// ====== START OUTPUT BUFFERING ======
ob_start();

include '../config/config.php';
include 'includes/auth_check.php'; 
checkRole(['admin']);

// ====== HANDLE ADD MARKS ======
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_marks'])) {
    $class_id = intval($_POST['class_id'] ?? 0);
    $subject_id = intval($_POST['subject_id'] ?? 0);
    $student_id = intval($_POST['student_id'] ?? 0);
    $marks_obtained = trim($_POST['marks_obtained'] ?? '');
    $total_marks = trim($_POST['total_marks'] ?? '');
    $exam_type = trim($_POST['exam_type'] ?? '');
    $status = trim($_POST['status'] ?? 'Active');

    if ($class_id === 0 || $subject_id === 0 || $student_id === 0 || $marks_obtained === '' || $total_marks === '') {
        $error = 'Please fill in all required fields.';
    } else {
        try {
            // Get class name
            $stmt = $conn->prepare("SELECT class_name FROM classes WHERE id = ?");
            $stmt->execute([$class_id]);
            $class = $stmt->fetch(PDO::FETCH_ASSOC);
            $class_name = $class ? $class['class_name'] : '';

            // Get subject name
            $stmt = $conn->prepare("SELECT subject_name FROM subjects WHERE id = ?");
            $stmt->execute([$subject_id]);
            $subject = $stmt->fetch(PDO::FETCH_ASSOC);
            $subject_name = $subject ? $subject['subject_name'] : '';

            // Get student name
            $stmt = $conn->prepare("SELECT first_name, last_name FROM students WHERE id = ?");
            $stmt->execute([$student_id]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);
            $student_name = $student ? $student['first_name'] . ' ' . $student['last_name'] : '';

            $percentage = ($marks_obtained > 0 && $total_marks > 0) ? ($marks_obtained / $total_marks) * 100 : 0;
            
            // Determine grade
            if ($percentage >= 90) $grade = 'A+';
            elseif ($percentage >= 80) $grade = 'A';
            elseif ($percentage >= 70) $grade = 'B+';
            elseif ($percentage >= 60) $grade = 'B';
            elseif ($percentage >= 50) $grade = 'C+';
            elseif ($percentage >= 40) $grade = 'C';
            else $grade = 'F';

            $stmt = $conn->prepare("INSERT INTO marks (class_id, class_name, subject_id, subject_name, student_id, student_name, marks_obtained, total_marks, percentage, grade, exam_type, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$class_id, $class_name, $subject_id, $subject_name, $student_id, $student_name, $marks_obtained, $total_marks, $percentage, $grade, $exam_type, $status]);
            
            $_SESSION['success'] = 'Marks added successfully!';
            ob_end_clean();
            header('Location: marks.php');
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// ====== HANDLE EDIT MARKS ======
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_marks'])) {
    $id = intval($_POST['id'] ?? 0);
    $class_id = intval($_POST['class_id'] ?? 0);
    $subject_id = intval($_POST['subject_id'] ?? 0);
    $student_id = intval($_POST['student_id'] ?? 0);
    $marks_obtained = trim($_POST['marks_obtained'] ?? '');
    $total_marks = trim($_POST['total_marks'] ?? '');
    $exam_type = trim($_POST['exam_type'] ?? '');
    $status = trim($_POST['status'] ?? 'Active');

    if ($id === 0 || $class_id === 0 || $subject_id === 0 || $student_id === 0 || $marks_obtained === '' || $total_marks === '') {
        $error = 'Please fill in all required fields.';
    } else {
        try {
            // Get class name
            $stmt = $conn->prepare("SELECT class_name FROM classes WHERE id = ?");
            $stmt->execute([$class_id]);
            $class = $stmt->fetch(PDO::FETCH_ASSOC);
            $class_name = $class ? $class['class_name'] : '';

            // Get subject name
            $stmt = $conn->prepare("SELECT subject_name FROM subjects WHERE id = ?");
            $stmt->execute([$subject_id]);
            $subject = $stmt->fetch(PDO::FETCH_ASSOC);
            $subject_name = $subject ? $subject['subject_name'] : '';

            // Get student name
            $stmt = $conn->prepare("SELECT first_name, last_name FROM students WHERE id = ?");
            $stmt->execute([$student_id]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);
            $student_name = $student ? $student['first_name'] . ' ' . $student['last_name'] : '';

            $percentage = ($marks_obtained > 0 && $total_marks > 0) ? ($marks_obtained / $total_marks) * 100 : 0;
            
            // Determine grade
            if ($percentage >= 90) $grade = 'A+';
            elseif ($percentage >= 80) $grade = 'A';
            elseif ($percentage >= 70) $grade = 'B+';
            elseif ($percentage >= 60) $grade = 'B';
            elseif ($percentage >= 50) $grade = 'C+';
            elseif ($percentage >= 40) $grade = 'C';
            else $grade = 'F';

            $stmt = $conn->prepare("UPDATE marks SET class_id = ?, class_name = ?, subject_id = ?, subject_name = ?, student_id = ?, student_name = ?, marks_obtained = ?, total_marks = ?, percentage = ?, grade = ?, exam_type = ?, status = ? WHERE id = ?");
            $stmt->execute([$class_id, $class_name, $subject_id, $subject_name, $student_id, $student_name, $marks_obtained, $total_marks, $percentage, $grade, $exam_type, $status, $id]);
            
            $_SESSION['success'] = 'Marks updated successfully!';
            ob_end_clean();
            header('Location: marks.php');
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// ====== HANDLE DELETE MARKS ======
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_marks'])) {
    $id = intval($_POST['id'] ?? 0);
    if ($id > 0) {
        try {
            $stmt = $conn->prepare("DELETE FROM marks WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['success'] = 'Marks deleted successfully!';
            ob_end_clean();
            header('Location: marks.php');
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// ====== FETCH ALL CLASSES FOR DROPDOWN ======
try {
    $stmt = $conn->query("SELECT id, class_name FROM classes WHERE status = 'Active' ORDER BY class_name");
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $classes = [];
}

// ====== FETCH ALL SUBJECTS FOR DROPDOWN ======
try {
    $stmt = $conn->query("SELECT id, subject_name FROM subjects WHERE status = 'Active' ORDER BY subject_name");
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $subjects = [];
}

// ====== FETCH ALL STUDENTS FOR DROPDOWN ======
try {
    $stmt = $conn->query("SELECT id, first_name, last_name FROM students ORDER BY first_name");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $students = [];
}

// ====== FETCH ALL MARKS ======
try {
    $stmt = $conn->query("SELECT * FROM marks ORDER BY id DESC");
    $marks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $marks = [];
    $error = 'Failed to load marks: ' . $e->getMessage();
}

// ====== FETCH SINGLE MARK FOR EDIT ======
$edit_mark = null;
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    try {
        $stmt = $conn->prepare("SELECT * FROM marks WHERE id = ?");
        $stmt->execute([$edit_id]);
        $edit_mark = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $error = 'Failed to load mark details.';
    }
}

// ====== CALCULATE STATISTICS ======
$total_marks = count($marks);
$active_marks = count(array_filter($marks, fn($m) => $m['status'] == 'Active'));
$average_percentage = $total_marks > 0 ? array_sum(array_column($marks, 'percentage')) / $total_marks : 0;

include 'includes/header.php';
?>

<!-- ====== PAGE CONTENT ====== -->
<div class="main-content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-graduation-cap text-primary me-2"></i>Marks</h3>
            <div class="text-secondary small">Manage student marks and grades.</div>
        </div>
    </div>

    <!-- ====== STATISTICS CARDS ====== -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Total Marks</div>
                            <h3 class="mb-0 fw-bold"><?= $total_marks ?></h3>
                            <div class="text-secondary small">All records</div>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-list text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Active Records</div>
                            <h3 class="mb-0 fw-bold text-success"><?= $active_marks ?></h3>
                            <div class="text-secondary small">Currently active</div>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Average Percentage</div>
                            <h3 class="mb-0 fw-bold text-warning"><?= number_format($average_percentage, 1) ?>%</h3>
                            <div class="text-secondary small">Overall performance</div>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-chart-line text-warning fs-4"></i>
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

    <!-- ====== ADD / EDIT MARKS FORM ====== -->
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0"><?= $edit_mark ? 'Edit Mark Entry' : 'Add New Mark Entry' ?></h5>
                <span class="text-secondary small"><?= $edit_mark ? 'Update mark details' : 'Create a new mark record for a student' ?></span>
            </div>
            <form class="row g-3" method="post">
                <?php if ($edit_mark): ?>
                    <input type="hidden" name="id" value="<?= $edit_mark['id'] ?>">
                <?php endif; ?>
                
                <div class="col-md-4">
                    <label class="form-label required">Class</label>
                    <select class="form-select" name="class_id" required>
                        <option value="">Select Class</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class['id'] ?>" 
                                <?= $edit_mark && $edit_mark['class_id'] == $class['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($class['class_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (count($classes) == 0): ?>
                        <small class="text-danger">No classes found. Please add a class first.</small>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label required">Subject</label>
                    <select class="form-select" name="subject_id" required>
                        <option value="">Select Subject</option>
                        <?php foreach ($subjects as $subject): ?>
                            <option value="<?= $subject['id'] ?>" 
                                <?= $edit_mark && $edit_mark['subject_id'] == $subject['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($subject['subject_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (count($subjects) == 0): ?>
                        <small class="text-danger">No subjects found. Please add a subject first.</small>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label required">Student</label>
                    <select class="form-select" name="student_id" required>
                        <option value="">Select Student</option>
                        <?php foreach ($students as $student): ?>
                            <option value="<?= $student['id'] ?>" 
                                <?= $edit_mark && $edit_mark['student_id'] == $student['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (count($students) == 0): ?>
                        <small class="text-danger">No students found. Please add a student first.</small>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label required">Marks Obtained</label>
                    <input type="number" class="form-control" name="marks_obtained" 
                           placeholder="45" min="0" 
                           value="<?= $edit_mark ? $edit_mark['marks_obtained'] : '' ?>" required>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label required">Total Marks</label>
                    <input type="number" class="form-control" name="total_marks" 
                           placeholder="50" min="1" 
                           value="<?= $edit_mark ? $edit_mark['total_marks'] : '' ?>" required>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label required">Exam Type</label>
                    <select class="form-select" name="exam_type" required>
                        <option value="">Select Exam Type</option>
                        <option value="Unit Test" <?= $edit_mark && $edit_mark['exam_type'] == 'Unit Test' ? 'selected' : '' ?>>Unit Test</option>
                        <option value="Monthly Test" <?= $edit_mark && $edit_mark['exam_type'] == 'Monthly Test' ? 'selected' : '' ?>>Monthly Test</option>
                        <option value="Quarterly Exam" <?= $edit_mark && $edit_mark['exam_type'] == 'Quarterly Exam' ? 'selected' : '' ?>>Quarterly Exam</option>
                        <option value="Half Yearly Exam" <?= $edit_mark && $edit_mark['exam_type'] == 'Half Yearly Exam' ? 'selected' : '' ?>>Half Yearly Exam</option>
                        <option value="Pre Board Exam" <?= $edit_mark && $edit_mark['exam_type'] == 'Pre Board Exam' ? 'selected' : '' ?>>Pre Board Exam</option>
                        <option value="Annual Exam" <?= $edit_mark && $edit_mark['exam_type'] == 'Annual Exam' ? 'selected' : '' ?>>Annual Exam</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="Active" <?= $edit_mark && $edit_mark['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?= $edit_mark && $edit_mark['status'] == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                
                <div class="col-12 d-flex justify-content-end gap-2">
                    <?php if ($edit_mark): ?>
                        <a href="marks.php" class="btn btn-outline-secondary rounded-pill px-3">Cancel</a>
                        <button type="submit" name="edit_marks" class="btn btn-warning rounded-pill px-3">
                            <i class="fas fa-edit me-1"></i>Update Marks
                        </button>
                    <?php else: ?>
                        <button type="reset" class="btn btn-outline-secondary rounded-pill px-3">Reset</button>
                        <button type="submit" name="add_marks" class="btn btn-primary rounded-pill px-3">
                            <i class="fas fa-save me-1"></i>Save Marks
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- ====== MARKS TABLE ====== -->
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Subject</th>
                            <th>Marks</th>
                            <th>Percentage</th>
                            <th>Grade</th>
                            <th>Exam Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($marks) > 0): ?>
                            <?php $i = 1; foreach ($marks as $mark): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><strong><?= htmlspecialchars($mark['student_name']) ?></strong></td>
                                    <td><?= htmlspecialchars($mark['class_name']) ?></td>
                                    <td><?= htmlspecialchars($mark['subject_name']) ?></td>
                                    <td><?= $mark['marks_obtained'] ?> / <?= $mark['total_marks'] ?></td>
                                    <td>
                                        <span class="badge <?= $mark['percentage'] >= 70 ? 'bg-success' : ($mark['percentage'] >= 40 ? 'bg-warning' : 'bg-danger') ?>">
                                            <?= number_format($mark['percentage'], 1) ?>%
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge <?= $mark['grade'] == 'F' ? 'bg-danger' : 'bg-primary' ?>">
                                            <?= $mark['grade'] ?>
                                        </span>
                                    </td>
                                    <td><small><?= htmlspecialchars($mark['exam_type']) ?></small></td>
                                    <td>
                                        <?php if ($mark['status'] == 'Active'): ?>
                                            <span class="status-badge bg-success-subtle text-success">Active</span>
                                        <?php else: ?>
                                            <span class="status-badge bg-danger-subtle text-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="marks.php?edit_id=<?= $mark['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="post" onsubmit="return confirm('Are you sure you want to delete this mark record?')" style="display:inline;">
                                                <input type="hidden" name="id" value="<?= $mark['id'] ?>">
                                                <button type="submit" name="delete_marks" class="btn btn-sm btn-outline-danger rounded-pill" title="Delete">
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
                                    No marks found. Fill the form above to add one.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if (count($marks) > 0): ?>
            <div class="card-footer bg-transparent border-top-0 p-3">
                <div class="text-secondary small">
                    <i class="fas fa-list me-1"></i>Total: <?= count($marks) ?> mark records
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php 
include 'includes/footer.php';
ob_end_flush();
?>