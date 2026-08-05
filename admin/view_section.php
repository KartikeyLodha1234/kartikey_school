<?php
include 'includes/config.php';
include 'includes/auth_check.php';
checkRole(['admin']);

$id = $_GET['id'] ?? '';
if (!ctype_digit($id)) {
    header('Location: section.php');
    exit();
}

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
    <h3>View Section</h3>
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Class:</strong> <?php echo htmlspecialchars($row['class_name']); ?></p>
            <p><strong>Section:</strong> <?php echo htmlspecialchars($row['section']); ?></p>
            <p><strong>Student Capacity:</strong> <?php echo htmlspecialchars($row['student_capacity']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($row['status']); ?></p>
            <a href="section.php" class="btn btn-outline-secondary">Back</a>
            <a href="edit_section.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-primary">Edit</a>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
