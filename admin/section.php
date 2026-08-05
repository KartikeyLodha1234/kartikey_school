<?php
include '../config/config.php';
include 'includes/auth_check.php'; 
checkRole(['admin']);

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = trim($_POST['class_id'] ?? '');
    $class_name = trim($_POST['class_name'] ?? '');
    $section_input = trim($_POST['section'] ?? '');
    $student_capacity = trim($_POST['student_capacity'] ?? '');
    $status = trim($_POST['status'] ?? '');

    // section table has columns: class_id, section_name, room_no
    if ($class_name === '' && $class_id === '') {
        $error = 'Please select a class or enter class name.';
    } elseif ($section_input === '') {
        $error = 'Please provide a section name.';
    } else {
        try {
            // Insert into sections using actual columns: class_id, section_name, room_no
            $insertClassId = ($class_id !== '') ? $class_id : null;
            $room_no = ''; // optional, not in form currently
            $stmt = $conn->prepare("INSERT INTO sections (class_id, section_name, room_no) VALUES (?, ?, ?)");
            $stmt->execute([$insertClassId, $section_input, $room_no]);

            header('Location: section.php');
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// Load existing sections (join with classes to get class name and capacity)
try {
    $stmt = $conn->query("SELECT s.*, c.class_name, c.student_capacity FROM sections s LEFT JOIN classes c ON s.class_id = c.id ORDER BY s.id DESC");
    $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $sections = [];
    if ($error === '') $error = 'Failed to load sections.';
}

// Load classes for selection
try {
    $classStmt = $conn->query("SELECT id, class_name, student_capacity FROM classes ORDER BY class_name ASC");
    $classes = $classStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $classes = [];
}

include 'includes/header.php';
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
                <h5 class="mb-0">Add New Section</h5>
                <span class="text-secondary small">Create a new academic section record</span>
            </div>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form class="row g-3" method="post">
                 <div class="col-md-4">
                    <label class="form-label">Select Class (optional)</label>
                    <select id="class_select" class="form-select" name="class_id">
                        <option value="">-- Select class --</option>
                        <?php foreach ($classes as $c): ?>
                            <option value="<?php echo htmlspecialchars($c['id']); ?>" data-capacity="<?php echo htmlspecialchars($c['student_capacity']); ?>"><?php echo htmlspecialchars($c['class_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Class Name</label>
                    <input id="class_name_input" type="text" class="form-control" name="class_name" placeholder="Grade 10" required>
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
                    <input id="student_capacity_input" type="number" class="form-control" name="student_capacity" placeholder="40" min="1" required>
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
                            <th>id</th>
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
                                    <td><?php echo htmlspecialchars($row['id'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($row['class_name'] ?? ($row['class'] ?? '')); ?></td>
                                    <td><?php echo htmlspecialchars($row['section'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($row['student_capacity'] ?? ''); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo (isset($row['status']) && $row['status'] === 'Active') ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'; ?>">
                                            <?php echo htmlspecialchars($row['status'] ?? ''); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="view_section.php?id=<?php echo urlencode($row['id']); ?>" class="text-primary text-decoration-none">View</a>
                                            <a href="edit_section.php?id=<?php echo urlencode($row['id']); ?>" class="text-primary text-decoration-none">Edit</a>
                                            <a href="delete_section.php?id=<?php echo urlencode($row['id']); ?>" class="text-primary text-decoration-none" onclick="return confirm('Delete this section?')">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No sections found.</td>
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

<script>
document.addEventListener('DOMContentLoaded', function(){
    var classSelect = document.getElementById('class_select');
    var capacityInput = document.getElementById('student_capacity_input');
    var classNameInput = document.getElementById('class_name_input');
    if (!classSelect) return;
    classSelect.addEventListener('change', function(){
        var opt = this.options[this.selectedIndex];
        var cap = opt ? opt.dataset.capacity : '';
        var name = opt ? opt.text : '';
        if (this.value) {
            if (cap !== undefined) capacityInput.value = cap;
            if (name) classNameInput.value = name;
        } else {
            // if user deselects, clear capacity but leave class name
            capacityInput.value = '';
        }
    });
});
</script>