<?php
ob_start();
include 'config/config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if ($username === '' || $password === '') {
        $error = 'Please enter username and password.';
    } else {
        try {
            // Check student login
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = 'student'");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password'])) {
                // Login successful
                $_SESSION['student_id'] = $user['student_id'];
                $_SESSION['student_name'] = $user['name'];
                $_SESSION['student_email'] = $user['email'];
                $_SESSION['student_username'] = $user['username'];
                $_SESSION['student_logged_in'] = true;
                
                header('Location: student_dashboard.php');
                exit();
            } else {
                $error = 'Invalid username or password.';
            }
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - Kartikey School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .login-card .logo {
            text-align: center;
            margin-bottom: 25px;
        }
        .login-card .logo img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #2563eb;
            padding: 3px;
        }
        .login-card .logo h3 {
            font-weight: 700;
            color: #1a1a2e;
            margin-top: 8px;
        }
        .login-card .logo p {
            color: #6b7280;
            font-size: 13px;
        }
        .login-card .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e5e7eb;
        }
        .login-card .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        .login-card .btn-login {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            border: none;
            width: 100%;
            transition: all 0.3s;
        }
        .login-card .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
        }
        .login-card .footer-text {
            text-align: center;
            color: #6b7280;
            font-size: 13px;
            margin-top: 15px;
        }
        .login-card .footer-text a {
            color: #2563eb;
            text-decoration: none;
        }
        .login-card .back-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #6b7280;
            font-size: 13px;
        }
        .login-card .back-link a {
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <img src="../images/logo.png" alt="School Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
            <div style="display:none; font-size:40px;">🏫</div>
            <h3>KARTIKEY SCHOOL</h3>
            <p>Student Login</p>
        </div>
        
        <?php if ($error): ?>
        <div class="alert alert-danger rounded-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
        <div class="alert alert-success rounded-4" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($success) ?>
        </div>
        <?php endif; ?>
        
        <form method="post">
            <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0">
                        <i class="fas fa-user text-secondary"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" name="username" 
                           placeholder="Enter your username" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0">
                        <i class="fas fa-lock text-secondary"></i>
                    </span>
                    <input type="password" class="form-control border-start-0" name="password" 
                           placeholder="Enter your password" required>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Login
            </button>
        </form>
        
        <div class="back-link">
            <a href="../index.php"><i class="fas fa-arrow-left me-1"></i>Back to School</a>
        </div>
        <div class="footer-text">
            <a href="parent_login.php">Parent Login</a> | 
            <a href="admin_login.php">Admin Login</a>
        </div>
    </div>
</body>
</html>
<?php ob_end_flush(); ?>    