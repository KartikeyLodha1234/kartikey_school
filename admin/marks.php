<?php
// ====== START OUTPUT BUFFERING ======
ob_start();

include '../config/config.php';
include 'includes/auth_check.php'; 
checkRole(['admin']);

// ====== HANDLE ADD SUBJECT MARKS ======
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_subject_marks'])) {
    $class_id = intval($_POST['class_id'] ?? 0);
    $subject_id = intval($_POST['subject_id'] ?? 0);
    $total_marks = trim($_POST['total_marks'] ?? '');
    $passing_marks = trim($_POST['passing_marks'] ?? '');
    $theory_marks = trim($_POST['theory_marks'] ?? '');
    $practical_marks = trim($_POST['practical_marks'] ?? '');
    $exam_type = trim($_POST['exam_type'] ?? '');
    $status = trim($_POST['status'] ?? 'Active');

    if ($class_id === 0 || $subject_id === 0 || $total_marks === '' || $passing_marks === '') {
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

            $stmt = $conn->prepare("INSERT INTO subject_marks_config (class_id, class_name, subject_id, subject_name, total_marks, passing_marks, theory_marks, practical_marks, exam_type, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$class_id, $class_name, $subject_id, $subject_name, $total_marks, $passing_marks, $theory_marks, $practical_marks, $exam_type, $status]);
            
            $_SESSION['success'] = 'Subject marks configuration added successfully!';
            ob_end_clean();
            header('Location: marks.php');
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// ====== HANDLE EDIT SUBJECT MARKS ======
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_subject_marks'])) {
    $id = intval($_POST['id'] ?? 0);
    $class_id = intval($_POST['class_id'] ?? 0);
    $subject_id = intval($_POST['subject_id'] ?? 0);
    $total_marks = trim($_POST['total_marks'] ?? '');
    $passing_marks = trim($_POST['passing_marks'] ?? '');
    $theory_marks = trim($_POST['theory_marks'] ?? '');
    $practical_marks = trim($_POST['practical_marks'] ?? '');
    $exam_type = trim($_POST['exam_type'] ?? '');
    $status = trim($_POST['status'] ?? 'Active');

    if ($id === 0 || $class_id === 0 || $subject_id === 0 || $total_marks === '' || $passing_marks === '') {
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

            $stmt = $conn->prepare("UPDATE subject_marks_config SET class_id = ?, class_name = ?, subject_id = ?, subject_name = ?, total_marks = ?, passing_marks = ?, theory_marks = ?, practical_marks = ?, exam_type = ?, status = ? WHERE id = ?");
            $stmt->execute([$class_id, $class_name, $subject_id, $subject_name, $total_marks, $passing_marks, $theory_marks, $practical_marks, $exam_type, $status, $id]);
            
            $_SESSION['success'] = 'Subject marks configuration updated successfully!';
            ob_end_clean();
            header('Location: marks.php');
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// ====== HANDLE DELETE SUBJECT MARKS ======
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_subject_marks'])) {
    $id = intval($_POST['id'] ?? 0);
    if ($id > 0) {
        try {
            $stmt = $conn->prepare("DELETE FROM subject_marks_config WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['success'] = 'Subject marks configuration deleted successfully!';
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

// ====== FETCH ALL CONFIGURATIONS ======
try {
    $stmt = $conn->query("SELECT * FROM subject_marks_config ORDER BY id DESC");
    $configs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $configs = [];
    $error = 'Failed to load configurations: ' . $e->getMessage();
}

// ====== FETCH SINGLE CONFIG FOR EDIT ======
$edit_config = null;
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    try {
        $stmt = $conn->prepare("SELECT * FROM subject_marks_config WHERE id = ?");
        $stmt->execute([$edit_id]);
        $edit_config = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $error = 'Failed to load configuration details.';
    }
}

// ====== CALCULATE STATISTICS ======
$total_configs = count($configs);
$active_configs = count(array_filter($configs, fn($c) => $c['status'] == 'Active'));

include 'includes/header.php';
?>

<!-- ====== PAGE CONTENT ====== -->
<div class="main-content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-cog text-primary me-2"></i>Subject Marks Configuration</h3>
            <div class="text-secondary small">Configure marks for each subject per class and exam type.</div>
        </div>
    </div>

    <!-- ====== STATISTICS CARDS ====== -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Total Configurations</div>
                            <h3 class="mb-0 fw-bold"><?= $total_configs ?></h3>
                            <div class="text-secondary small">All configurations</div>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-list text-primary fs-4"></i>
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
                            <div class="text-secondary small">Active Configurations</div>
                            <h3 class="mb-0 fw-bold text-success"><?= $active_configs ?></h3>
                            <div class="text-secondary small">Currently active</div>
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
                            <div class="text-secondary small">Total Subjects</div>
                            <h3 class="mb-0 fw-bold text-warning"><?= count($subjects) ?></h3>
                            <div class="text-secondary small">Available subjects</div>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-book text-warning fs-4"></i>
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
                            <div class="text-secondary small">Total Classes</div>
                            <h3 class="mb-0 fw-bold text-info"><?= count($classes) ?></h3>
                            <div class="text-secondary small">Available classes</div>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-school text-info fs-4"></i>
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

    <!-- ====== ADD / EDIT CONFIGURATION FORM ====== -->
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0"><?= $edit_config ? 'Edit Configuration' : 'Add New Configuration' ?></h5>
                <span class="text-secondary small"><?= $edit_config ? 'Update marks configuration' : 'Configure marks for a subject' ?></span>
            </div>
            <form class="row g-3" method="post">
                <?php if ($edit_config): ?>
                    <input type="hidden" name="id" value="<?= $edit_config['id'] ?>">
                <?php endif; ?>
                
                <div class="col-md-4">
                    <label class="form-label required">Class</label>
                    <select class="form-select" name="class_id" required>
                        <option value="">Select Class</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class['id'] ?>" 
                                <?= $edit_config && $edit_config['class_id'] == $class['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($class['class_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label required">Subject</label>
                    <select class="form-select" name="subject_id" required>
                        <option value="">Select Subject</option>
                        <?php foreach ($subjects as $subject): ?>
                            <option value="<?= $subject['id'] ?>" 
                                <?= $edit_config && $edit_config['subject_id'] == $subject['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($subject['subject_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label required">Exam Type</label>
                    <select class="form-select" name="exam_type" required>
                        <option value="">Select Exam Type</option>
                        <option value="Unit Test" <?= $edit_config && $edit_config['exam_type'] == 'Unit Test' ? 'selected' : '' ?>>Unit Test</option>
                        <option value="Monthly Test" <?= $edit_config && $edit_config['exam_type'] == 'Monthly Test' ? 'selected' : '' ?>>Monthly Test</option>
                        <option value="Quarterly Exam" <?= $edit_config && $edit_config['exam_type'] == 'Quarterly Exam' ? 'selected' : '' ?>>Quarterly Exam</option>
                        <option value="Half Yearly Exam" <?= $edit_config && $edit_config['exam_type'] == 'Half Yearly Exam' ? 'selected' : '' ?>>Half Yearly Exam</option>
                        <option value="Pre Board Exam" <?= $edit_config && $edit_config['exam_type'] == 'Pre Board Exam' ? 'selected' : '' ?>>Pre Board Exam</option>
                        <option value="Annual Exam" <?= $edit_config && $edit_config['exam_type'] == 'Annual Exam' ? 'selected' : '' ?>>Annual Exam</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label required">Total Marks</label>
                    <input type="number" class="form-control" name="total_marks" 
                           placeholder="100" min="1" 
                           value="<?= $edit_config ? $edit_config['total_marks'] : '' ?>" required>
                    <small class="text-secondary">Maximum marks for this subject</small>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label required">Passing Marks</label>
                    <input type="number" class="form-control" name="passing_marks" 
                           placeholder="35" min="0" 
                           value="<?= $edit_config ? $edit_config['passing_marks'] : '' ?>" required>
                    <small class="text-secondary">Minimum marks to pass</small>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Theory Marks</label>
                    <input type="number" class="form-control" name="theory_marks" 
                           placeholder="70" min="0" 
                           value="<?= $edit_config ? $edit_config['theory_marks'] : '' ?>">
                    <small class="text-secondary">Theory portion marks</small>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Practical Marks</label>
                    <input type="number" class="form-control" name="practical_marks" 
                           placeholder="30" min="0" 
                           value="<?= $edit_config ? $edit_config['practical_marks'] : '' ?>">
                    <small class="text-secondary">Practical portion marks</small>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="Active" <?= $edit_config && $edit_config['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?= $edit_config && $edit_config['status'] == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                
                <div class="col-md-6 d-flex align-items-end">
                    <div class="alert alert-info rounded-4 w-100 mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>Theory + Practical should equal Total Marks</small>
                    </div>
                </div>
                
                <div class="col-12 d-flex justify-content-end gap-2">
                    <?php if ($edit_config): ?>
                        <a href="marks.php" class="btn btn-outline-secondary rounded-pill px-3">Cancel</a>
                        <button type="submit" name="edit_subject_marks" class="btn btn-warning rounded-pill px-3">
                            <i class="fas fa-edit me-1"></i>Update Configuration
                        </button>
                    <?php else: ?>
                        <button type="reset" class="btn btn-outline-secondary rounded-pill px-3">Reset</button>
                        <button type="submit" name="add_subject_marks" class="btn btn-primary rounded-pill px-3">
                            <i class="fas fa-save me-1"></i>Save Configuration
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- ====== CONFIGURATIONS TABLE ====== -->
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Class</th>
                            <th>Subject</th>
                            <th>Exam Type</th>
                            <th>Total Marks</th>
                            <th>Passing Marks</th>
                            <th>Theory</th>
                            <th>Practical</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($configs) > 0): ?>
                            <?php $i = 1; foreach ($configs as $config): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><strong><?= htmlspecialchars($config['class_name']) ?></strong></td>
                                    <td><?= htmlspecialchars($config['subject_name']) ?></td>
                                    <td><span class="badge bg-info text-dark"><?= htmlspecialchars($config['exam_type']) ?></span></td>
                                    <td><strong><?= $config['total_marks'] ?></strong></td>
                                    <td>
                                        <span class="badge <?= $config['passing_marks'] <= $config['total_marks'] * 0.4 ? 'bg-success' : 'bg-warning' ?>">
                                            <?= $config['passing_marks'] ?>
                                        </span>
                                    </td>
                                    <td><?= $config['theory_marks'] ?: '—' ?></td>
                                    <td><?= $config['practical_marks'] ?: '—' ?></td>
                                    <td>
                                        <?php if ($config['status'] == 'Active'): ?>
                                            <span class="status-badge bg-success-subtle text-success">Active</span>
                                        <?php else: ?>
                                            <span class="status-badge bg-danger-subtle text-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="marks.php?edit_id=<?= $config['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="post" onsubmit="return confirm('Are you sure you want to delete this configuration?')" style="display:inline;">
                                                <input type="hidden" name="id" value="<?= $config['id'] ?>">
                                                <button type="submit" name="delete_subject_marks" class="btn btn-sm btn-outline-danger rounded-pill" title="Delete">
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
                                    No configurations found. Fill the form above to add one.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if (count($configs) > 0): ?>
            <div class="card-footer bg-transparent border-top-0 p-3">
                <div class="text-secondary small">
                    <i class="fas fa-list me-1"></i>Total: <?= count($configs) ?> configurations
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php 
include 'includes/footer.php';
ob_end_flush();
?>