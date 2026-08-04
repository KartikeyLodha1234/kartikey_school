<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}
function checkRole($allowed_roles = []) {
    if (empty($allowed_roles)) {
        return true;
    }
    if (!isset($_SESSION['user_role'])) {
        header("Location: ../login.php");
        exit();
    }
    if (!in_array($_SESSION['user_role'], $allowed_roles)) {
        header("Location: index.php");
        exit();
    }
    return true;
}

function getCurrentUser() {
    global $conn;
    if (isset($_SESSION['user_id'])) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch();
    }
    return null;
}
?>