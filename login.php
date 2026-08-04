<?php
session_start();
include 'config/config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['pswd'] ?? '');

    if ($email === 'adminkartikey@gmail.com' && $password === 'kartikey@1805') {
        $_SESSION['logged_in'] = true;
        $_SESSION['user_role'] = 'admin';
        $_SESSION['admin_email'] = $email;
        header('Location: admin/index.php');
        exit;
    } else {
        $message = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="login.css">
    <title>Login | Kartikey School</title>
</head>
<body>
    <div class="login-shell">
        <div class="login-card">
            <div class="login-brand">
                <h2><i class="fas fa-graduation-cap me-2"></i>Kartikey School</h2>
                <p>Login Portal</p>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert alert-danger rounded-3"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="adminkartikey@gmail.com" required>
                </div>
                <div class="mb-3">
                    <label for="pwd" class="form-label">Password</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" value="kartikey@1805" required>
                </div>
                <button type="submit" class="btn btn-primary login-btn">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </button>
            </form>
        </div>
    </div>
</body>
</html>