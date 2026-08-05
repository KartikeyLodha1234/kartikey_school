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
    $stmt = $conn->prepare('DELETE FROM sections WHERE id = ?');
    $stmt->execute([$id]);
} catch (Exception $e) {
    // ignore and redirect
}

header('Location: section.php');
exit();
