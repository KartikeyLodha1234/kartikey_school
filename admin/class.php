<?php
include '../config/config.php';
include 'includes/auth_check.php'; 
checkRole(['admin']);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_class'])) {
    $class_name = trim($_POST['class_name']);
    $student_capacity = (int)$_POST['student_capacity'];
    $status = $_POST['status'];
    
    if (empty($class_name)) {
        $_SESSION['error'] = "Class name is required";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO classes (class_name, student_capacity, status) VALUES (?, ?, ?)");
            $stmt->execute([$class_name, $student_capacity, $status]);
            $_SESSION['success'] = "Class added successfully!";
            header("Location: class.php");
            exit();
        } catch(PDOException $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_class'])) {
    $id = (int)$_POST['edit_id'];
    $class_name = trim($_POST['edit_class_name']);
    $student_capacity = (int)$_POST['edit_student_capacity'];
    $status = $_POST['edit_status'];
    
    try {
        $stmt = $conn->prepare("UPDATE classes SET class_name = ?, student_capacity = ?, status = ? WHERE id = ?");
        $stmt->execute([$class_name, $student_capacity, $status, $id]);
        $_SESSION['success'] = "Class updated successfully!";
        header("Location: class.php");
        exit();
    } catch(PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        $stmt = $conn->prepare("DELETE FROM classes WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['success'] = "Class deleted successfully!";
        header("Location: class.php");
        exit();
    } catch(PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM classes WHERE id = ?");
    $stmt->execute([$id]);
    $edit_data = $stmt->fetch();
    
    if (!$edit_data) {
        $_SESSION['error'] = "Class not found!";
        header("Location: class.php");
        exit();
    }
}
$classes = $conn->query("SELECT * FROM classes ORDER BY id ASC")->fetchAll();
$total_classes = count($classes);
$active_classes = $conn->query("SELECT COUNT(*) as total FROM classes WHERE status = 'Active'")->fetch()['total'] ?? 0;
$total_capacity = $conn->query("SELECT SUM(student_capacity) as total FROM classes")->fetch()['total'] ?? 0;
include 'includes/header.php';
?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-school text-primary me-2"></i>Classes</h3>
            <div class="text-secondary small">Manage academic classes with student capacity.</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-pill px-3" data-bs-toggle="collapse" data-bs-target="#addClassForm">
                <i class="fas fa-plus me-2"></i>Add New Class
            </button>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Total Classes</div>
                        <div class="stat-number"><?php echo $total_classes; ?></div>
                    </div>
                    <div class="stat-icon" style="background:#2563eb;"><i class="fas fa-school"></i></div>
                </div>
                <div class="stat-sub">All classes</div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Active Classes</div>
                        <div class="stat-number"><?php echo $active_classes; ?></div>
                    </div>
                    <div class="stat-icon" style="background:#10b981;"><i class="fas fa-check-circle"></i></div>
                </div>
                <div class="stat-sub">Currently active</div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Total Capacity</div>
                        <div class="stat-number"><?php echo $total_capacity; ?></div>
                    </div>
                    <div class="stat-icon" style="background:#f59e0b;"><i class="fas fa-users"></i></div>
                </div>
                <div class="stat-sub">Total student capacity</div>
            </div>
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
    <div class="card border-0 rounded-4 shadow-sm mb-4 <?php echo isset($_GET['edit']) ? '' : 'collapse'; ?>" id="addClassForm">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0">
                    <i class="fas fa-plus-circle text-primary me-2"></i>
                    <?php echo isset($edit_data) ? 'Edit Class' : 'Add New Class'; ?>
                </h5>
                <span class="text-secondary small">
                    <?php echo isset($edit_data) ? 'Update class record' : 'Create a new academic class record'; ?>
                </span>
            </div>
            <form method="POST" action="" class="row g-3">
                <?php if (isset($edit_data)): ?>
                    <input type="hidden" name="edit_id" value="<?php echo $edit_data['id']; ?>">
                <?php endif; ?>
                
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Class Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="<?php echo isset($edit_data) ? 'edit_class_name' : 'class_name'; ?>" 
                           placeholder="e.g., Grade 10" 
                           value="<?php echo isset($edit_data) ? htmlspecialchars($edit_data['class_name']) : ''; ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Student Capacity</label>
                    <input type="number" class="form-control" name="<?php echo isset($edit_data) ? 'edit_student_capacity' : 'student_capacity'; ?>" 
                           placeholder="e.g., 40" 
                           value="<?php echo isset($edit_data) ? $edit_data['student_capacity'] : ''; ?>" min="0">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status</label>
                    <select class="form-select" name="<?php echo isset($edit_data) ? 'edit_status' : 'status'; ?>">
                        <option value="Active" <?php echo (isset($edit_data) && $edit_data['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                        <option value="Inactive" <?php echo (isset($edit_data) && $edit_data['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-12 d-flex justify-content-end gap-2">
                    <?php if (isset($edit_data)): ?>
                        <a href="class.php" class="btn btn-outline-secondary rounded-pill px-3">Cancel</a>
                        <button type="submit" name="edit_class" class="btn btn-primary rounded-pill px-3">
                            <i class="fas fa-save me-2"></i>Update Class
                        </button>
                    <?php else: ?>
                        <button type="reset" class="btn btn-outline-secondary rounded-pill px-3">Reset</button>
                        <button type="submit" name="add_class" class="btn btn-primary rounded-pill px-3">
                            <i class="fas fa-save me-2"></i>Save Class
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-header bg-transparent border-bottom-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="fas fa-list text-primary me-2"></i>Class List</h6>
                <span class="text-secondary small">Total: <?php echo $total_classes; ?> classes</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Class Name</th>
                            <th>Student Capacity</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($classes)): ?>
                            <?php $sn = 1; foreach ($classes as $row): ?>
                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><strong><?php echo htmlspecialchars($row['class_name']); ?></strong></td>
                                    <td><?php echo (int)$row['student_capacity']; ?></td>
                                    <td>
                                        <?php if ($row['status'] == 'Active'): ?>
                                            <span class="status-badge bg-success-subtle text-success">🟢 Active</span>
                                        <?php else: ?>
                                            <span class="status-badge bg-danger-subtle text-danger">🔴 Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="class.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-warning rounded-circle" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="class.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete" onclick="return confirm('Are you sure you want to delete this class?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-secondary py-4">
                                    <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                    No classes found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>