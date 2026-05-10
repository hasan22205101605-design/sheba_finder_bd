<?php
session_start();

if(isset($_SESSION['user_id']) && $_SESSION['user_type'] == 'admin') {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../db.php';
    
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND user_type = 'admin'");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();
    
    // MD5 password check
    if($admin && md5($password) == $admin['password']) {
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['user_name'] = $admin['name'];
        $_SESSION['user_email'] = $admin['email'];
        $_SESSION['user_type'] = $admin['user_type'];
        
        header("Location: dashboard.php");
        exit();
    } else {
        $error = 'Invalid email or password!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Sheba Finder BD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4><i class="fas fa-user-shield"></i> Admin Login</h4>
                        <p class="mb-0">Sheba Finder BD</p>
                    </div>
                    <div class="card-body p-4">
                        <?php if($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label><i class="fas fa-envelope"></i> Email Address</label>
                                <input type="email" name="email" class="form-control" 
                                       value="admin@shebafinder.com" required>
                            </div>
                            <div class="mb-3">
                                <label><i class="fas fa-lock"></i> Password</label>
                                <input type="password" name="password" class="form-control" 
                                       value="admin123" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </button>
                        </form>
                        
                        <hr>
                        
                        <div class="text-center">
                            <small class="text-muted">
                                Demo: admin@shebafinder.com / admin123
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>