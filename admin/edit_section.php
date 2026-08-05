<?php
include 'includes/config.php';
include 'includes/auth_check.php';
checkRole(['admin']);

$error = '';
$id = $_GET['id'] ?? ($_POST['id'] ?? '');
if (!ctype_digit($id)) {
    header('Location: section.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_name = trim($_POST['class_name'] ?? '');
    $section = trim($_POST['section'] ?? '');
    $student_capacity = trim($_POST['student_capacity'] ?? '');
    $status = trim($_POST['status'] ?? '');

    if ($class_name === '' || $section === '' || $student_capacity === '' || $status === '') {
        $error = 'Please fill all fields.';
    } elseif (!ctype_digit($student_capacity) || (int)$student_capacity < 1) {
        $error = 'Student capacity must be a positive integer.';
    } else {
        try {
            $stmt = $conn->prepare('UPDATE sections SET class_name = ?, section = ?, student_capacity = ?, status = ? WHERE id = ?');
            $stmt->execute([$class_name, $section, (int)$student_capacity, $status, $id]);
            header('Location: section.php');
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// Load current values
try {
    $stmt = $conn->prepare('SELECT * FROM sections WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        header('Location: section.php');
        exit();
    }
} catch (Exception $e) {
    header('Location: section.php');
    exit();
}

include 'includes/header.php';
?>
<div class="main-content">
    <h3>Edit Section</h3>
    <div class="card mb-4">
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="post" class="row g-3">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                <div class="col-md-4">
                    <label class="form-label">Class Name</label>
                    <input type="text" class="form-control" name="class_name" value="<?php echo htmlspecialchars($row['class_name']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Section</label>
                    <input type="text" class="form-control" name="section" value="<?php echo htmlspecialchars($row['section']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Student Capacity</label>
                    <input type="number" class="form-control" name="student_capacity" min="1" value="<?php echo htmlspecialchars($row['student_capacity']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="Active" <?php echo ($row['status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                        <option value="Inactive" <?php echo ($row['status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="section.php" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
