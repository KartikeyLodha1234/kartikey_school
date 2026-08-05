<?php
include '../config/config.php';
include 'includes/auth_check.php';
checkRole(['admin']);

// Fetch lookup data for subject form
$classes = $conn->query("SELECT id, class_name FROM classes WHERE status = 'Active' ORDER BY class_name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject_code = trim($_POST['subject_code'] ?? '');
    $subject_name = trim($_POST['subject_name'] ?? '');
    $class_id = $_POST['class_id'] !== '' ? (int)$_POST['class_id'] : null;
    $status = trim($_POST['status'] ?? 'Active');

    if (empty($subject_name)) {
        $_SESSION['error'] = 'Please provide a subject name.';
    } elseif (empty($subject_code)) {
        $_SESSION['error'] = 'Please provide a subject code.';
    } else {
        try {
            if (isset($_POST['add_subject'])) {
                $stmt = $conn->prepare("INSERT INTO subjects (subject_code, subject_name, class_id, status) VALUES (?, ?, ?, ?)");
                $stmt->execute([$subject_code, $subject_name, $class_id, $status]);
                $_SESSION['success'] = 'Subject added successfully!';
            } elseif (isset($_POST['edit_subject'])) {
                $id = (int)($_POST['edit_id'] ?? 0);
                $stmt = $conn->prepare("UPDATE subjects SET subject_code = ?, subject_name = ?, class_id = ?, status = ? WHERE id = ?");
                $stmt->execute([$subject_code, $subject_name, $class_id, $status, $id]);
                $_SESSION['success'] = 'Subject updated successfully!';
            }

            header('Location: subject.php');
            exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
        }
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        $stmt = $conn->prepare('DELETE FROM subjects WHERE id = ?');
        $stmt->execute([$id]);
        $_SESSION['success'] = 'Subject deleted successfully!';
        header('Location: subject.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error: ' . $e->getMessage();
    }
}

$edit_data = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $conn->prepare('SELECT * FROM subjects WHERE id = ?');
    $stmt->execute([$id]);
    $edit_data = $stmt->fetch();

    if (!$edit_data) {
        $_SESSION['error'] = 'Subject not found!';
        header('Location: subject.php');
        exit();
    }
}

$subjects = $conn->query("SELECT s.*, c.class_name AS class_name FROM subjects s LEFT JOIN classes c ON s.class_id = c.id ORDER BY s.id ASC")->fetchAll();
$total_subjects = count($subjects);
$active_subjects = $conn->query("SELECT COUNT(*) as total FROM subjects WHERE status = 'Active'")->fetch()['total'] ?? 0;
$total_capacity = $conn->query("SELECT SUM(student_capacity) as total FROM classes")->fetch()['total'] ?? 0;
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Subjects</h3>
            <div class="text-secondary small">Manage academic subjects and their details.</div>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0"><?php echo isset($edit_data) ? 'Edit Subject' : 'Add New Subject'; ?></h5>
                <span
                    class="text-secondary small"><?php echo isset($edit_data) ? 'Update the selected subject details' : 'Create a new academic subject record'; ?></span>
            </div>
            <form class="row g-3" method="post">
                <?php if (isset($edit_data)): ?>
                <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($edit_data['id']); ?>">
                <?php endif; ?>

                <div class="col-md-4">
                    <label class="form-label">Subject Code</label>
                    <input type="text" class="form-control" name="subject_code" placeholder="MATH-101"
                        value="<?php echo htmlspecialchars($edit_data['subject_code'] ?? ''); ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Subject Name</label>
                    <input type="text" class="form-control" name="subject_name" placeholder="Mathematics"
                        value="<?php echo htmlspecialchars($edit_data['subject_name'] ?? ''); ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Class</label>
                    <select class="form-select" name="class_id">
                        <option value="">Select class</option>
                        <?php foreach ($classes as $class): ?>
                        <option value="<?php echo $class['id']; ?>"
                            <?php echo (isset($edit_data['class_id']) && $edit_data['class_id'] == $class['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($class['class_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="Active"
                            <?php echo (isset($edit_data['status']) && $edit_data['status'] === 'Active') ? 'selected' : ''; ?>>
                            Active</option>
                        <option value="Inactive"
                            <?php echo (isset($edit_data['status']) && $edit_data['status'] === 'Inactive') ? 'selected' : ''; ?>>
                            Inactive</option>
                    </select>
                </div>

                <div class="col-12 d-flex justify-content-end gap-2">
                    <?php if (isset($edit_data)): ?>
                    <a href="subject.php" class="btn btn-outline-secondary rounded-pill px-3">Cancel</a>
                    <button type="submit" name="edit_subject" class="btn btn-primary rounded-pill px-3">Update
                        Subject</button>
                    <?php else: ?>
                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-3">Reset</button>
                    <button type="submit" name="add_subject" class="btn btn-primary rounded-pill px-3">Save
                        Subject</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0"><i
                                class="fas fa-search text-secondary"></i></span>
                        <input type="text" class="form-control border-start-0" placeholder="Search subjects..." />
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option value="">All Classes</option>
                        <?php foreach ($classes as $class): ?>
                        <option value="<?php echo $class['id']; ?>">
                            <?php echo htmlspecialchars($class['class_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100 rounded-pill"><i class="fas fa-filter me-2"></i>Filter</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Subject</th>
                            <th>Class</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($subjects)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-secondary">No subjects found.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($subjects as $index => $subject): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><span
                                    class="badge bg-light text-dark"><?php echo htmlspecialchars($subject['subject_code'] ?? ''); ?></span>
                            </td>
                            <td><strong><?php echo htmlspecialchars($subject['subject_name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($subject['class_name'] ?? '—'); ?></td>
                            <td>
                                <span
                                    class="status-badge <?php echo $subject['status'] === 'Active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'; ?>">
                                    <?php echo htmlspecialchars($subject['status']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="subject.php?edit=<?php echo $subject['id']; ?>"
                                        class="text-primary text-decoration-none">Edit</a>
                                    <a href="subject.php?delete=<?php echo $subject['id']; ?>"
                                        class="text-danger text-decoration-none"
                                        onclick="return confirm('Are you sure you want to delete this subject?');">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent border-top-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-secondary small">Showing
                    <?php echo min(1, $total_subjects); ?>-<?php echo $total_subjects; ?> of
                    <?php echo $total_subjects; ?> subjects</div>
                <nav>
                    <ul class="pagination pagination-custom mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#"><i
                                    class="fas fa-chevron-left"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                        <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>