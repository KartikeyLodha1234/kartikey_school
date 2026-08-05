<?php
include 'includes/config.php';
include 'includes/auth_check.php'; 
checkRole(['admin']);

$error = '';
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
            $stmt = $conn->prepare("INSERT INTO sections (class_name, section, student_capacity, status) VALUES (?, ?, ?, ?)");
            $stmt->execute([$class_name, $section, (int)$student_capacity, $status]);
            header("Location: section.php");
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

include 'includes/header.php';

// Load existing sections
try {
    $stmt = $conn->query("SELECT * FROM sections ORDER BY id DESC");
    $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $sections = [];
    if ($error === '') $error = 'Failed to load sections.';
}
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Section</h3>
            <div class="text-secondary small">Manage academic class strength.</div>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0">Add New Class</h5>
                <span class="text-secondary small">Create a new academic class record</span>
            </div>
            <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form class="row g-3" method="post">
                <div class="col-md-4">
                    <label class="form-label">Class Name</label>
                    <input type="text" class="form-control" name="class_name" placeholder="Grade 10" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Section</label>
                    <select class="form-select" name="section">
                        <option value="A" selected>A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Student Capacity</label>
                    <input type="number" class="form-control" name="student_capacity" placeholder="40" min="1" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="Active" selected>Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-12 d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-3">Reset</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-3">Save Class</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Students</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($sections)): ?>
                        <?php foreach ($sections as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['class_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['section']); ?></td>
                            <td><?php echo htmlspecialchars($row['student_capacity']); ?></td>
                            <td>
                                <span
                                    class="status-badge <?php echo ($row['status'] === 'Active') ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'; ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="view_section.php?id=<?php echo urlencode($row['id']); ?>"
                                        class="text-primary text-decoration-none">View</a>
                                    <a href="edit_section.php?id=<?php echo urlencode($row['id']); ?>"
                                        class="text-primary text-decoration-none">Edit</a>
                                    <a href="delete_section.php?id=<?php echo urlencode($row['id']); ?>"
                                        class="text-primary text-decoration-none"
                                        onclick="return confirm('Delete this section?')">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No sections found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>