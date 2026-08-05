<?php
include '../config/config.php';
include 'includes/auth_check.php';
checkRole(['admin']);

$id = $_GET['id'] ?? '';
if (!ctype_digit($id)) {
    header('Location: section.php');
    exit();
}

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

include 'includes/header.php';
?>
<div class="main-content">
    <h3>View Section</h3>
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Class:</strong> <?php echo htmlspecialchars($row['class_name'] ?? ''); ?></p>
            <p><strong>Section:</strong> <?php echo htmlspecialchars($row['section_name'] ?? ''); ?></p>
            <p><strong>Class Capacity:</strong> <?php echo htmlspecialchars($row['student_capacity'] ?? ''); ?></p>
            <p><strong>Room No:</strong> <?php echo htmlspecialchars($row['room_no'] ?? ''); ?></p>
            <a href="section.php" class="btn btn-outline-secondary">Back</a>
            <a href="edit_section.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-primary">Edit</a>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
