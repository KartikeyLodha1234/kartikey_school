<?php
// ============================================
// AUTHENTICATION CHECK
// ============================================

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

// Role-based access control
function checkRole($allowed_roles = []) {
    if (empty($allowed_roles)) {
        return true;
    }
    
    // If user role not set, redirect
    if (!isset($_SESSION['user_role'])) {
        header("Location: ../login.php");
        exit();
    }
    
    // Check if user role is allowed
    if (!in_array($_SESSION['user_role'], $allowed_roles)) {
        header("Location: index.php");
        exit();
    }
    return true;
}

// Get current user info
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