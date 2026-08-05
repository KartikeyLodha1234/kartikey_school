<?php
include '../config/config.php';
include 'includes/auth_check.php';
checkRole(['admin']);

$error = '';
$id = $_GET['id'] ?? ($_POST['id'] ?? '');
if (!ctype_digit($id)) {
    header('Location: section.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = trim($_POST['class_id'] ?? '');
    $section_name = trim($_POST['section_name'] ?? '');
    $room_no = trim($_POST['room_no'] ?? '');

    if ($section_name === '') {
        $error = 'Please provide a section name.';
    } else {
        try {
            $stmt = $conn->prepare('UPDATE sections SET class_id = ?, section_name = ?, room_no = ? WHERE id = ?');
            $stmt->execute([$class_id !== '' ? $class_id : null, $section_name, $room_no, $id]);
            header('Location: section.php');
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// Load current values (with class info)
try {
    $stmt = $conn->prepare('SELECT s.*, c.class_name, c.student_capacity FROM sections s LEFT JOIN classes c ON s.class_id = c.id WHERE s.id = ?');
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

// Load classes for select
try {
    $classStmt = $conn->query("SELECT id, class_name, student_capacity FROM classes ORDER BY class_name ASC");
    $classes = $classStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $classes = [];
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
                    <label class="form-label">Select Class (optional)</label>
                    <select class="form-select" name="class_id">
                        <option value="">-- Select class --</option>
                        <?php foreach ($classes as $c): ?>
                            <option value="<?php echo htmlspecialchars($c['id']); ?>" data-capacity="<?php echo htmlspecialchars($c['student_capacity']); ?>" <?php echo ($row['class_id'] == $c['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($c['class_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Section Name</label>
                    <input type="text" class="form-control" name="section_name" value="<?php echo htmlspecialchars($row['section_name']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Room No (optional)</label>
                    <input type="text" class="form-control" name="room_no" value="<?php echo htmlspecialchars($row['room_no'] ?? ''); ?>">
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
