<?php
require_once 'db.php';

if(isLoggedIn()) {
    redirect('index.php');
}

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if(empty($name) || empty($email) || empty($phone) || empty($password)) {
        $error = 'Please fill in all fields';
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    } elseif(strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } elseif($password != $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if($stmt->fetch()) {
            $error = 'Email already registered!';
        } else {
            // Create new user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, password, user_type) 
                                   VALUES (?, ?, ?, ?, 'user')");
            
            if($stmt->execute([$name, $email, $phone, $hashed_password])) {
                // Auto login after signup
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_type'] = 'user';
                
                $success = 'Account created successfully! Redirecting...';
                header("refresh:2;url=index.php");
            } else {
                $error = 'Registration failed! Please try again.';
            }
        }
    }
}

include 'inc/header.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4><i class="fas fa-user-plus"></i> Create New Account</h4>
                </div>
                <div class="card-body p-4">
                    <?php if($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <?php if($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label><i class="fas fa-user"></i> Full Name *</label>
                            <input type="text" name="name" class="form-control" required 
                                   placeholder="Enter your full name">
                        </div>
                        
                        <div class="mb-3">
                            <label><i class="fas fa-envelope"></i> Email Address *</label>
                            <input type="email" name="email" class="form-control" required 
                                   placeholder="Enter your email">
                        </div>
                        
                        <div class="mb-3">
                            <label><i class="fas fa-phone"></i> Phone Number *</label>
                            <input type="text" name="phone" class="form-control" required 
                                   placeholder="Enter your phone number">
                        </div>
                        
                        <div class="mb-3">
                            <label><i class="fas fa-lock"></i> Password *</label>
                            <input type="password" name="password" class="form-control" required 
                                   placeholder="Create a password (min 6 characters)">
                        </div>
                        
                        <div class="mb-3">
                            <label><i class="fas fa-lock"></i> Confirm Password *</label>
                            <input type="password" name="confirm_password" class="form-control" required 
                                   placeholder="Confirm your password">
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100 py-2">
                            <i class="fas fa-user-plus"></i> Create Account
                        </button>
                    </form>
                    
                    <hr>
                    
                    <p class="text-center mb-0">
                        Already have an account? <a href="login.php">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>