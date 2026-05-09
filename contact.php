<?php
require_once 'db.php';
include 'inc/header.php';

$message_sent = false;
$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    
    if(empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'Please fill in all fields';
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    } else {
        // Here you can send email or save to database
        // For now, just show success message
        $message_sent = true;
        
        // You can uncomment this to save to database
        /*
        $stmt = $pdo->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $subject, $message]);
        */
    }
}
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="text-center mb-5">
                <h1 class="display-4">Contact Us</h1>
                <p class="lead">We'd love to hear from you! Get in touch with us.</p>
            </div>
            
            <?php if($message_sent): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> Thank you for contacting us! We'll get back to you soon.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-5 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h4><i class="fas fa-info-circle text-primary"></i> Get in Touch</h4>
                            <hr>
                            
                            <p><i class="fas fa-map-marker-alt text-primary"></i> <strong>Address:</strong><br>
                            Dhaka, Bangladesh</p>
                            
                            <p><i class="fas fa-phone text-primary"></i> <strong>Phone:</strong><br>
                            +880 1234 567890</p>
                            
                            <p><i class="fas fa-envelope text-primary"></i> <strong>Email:</strong><br>
                            info@shebafinder.com<br>
                            support@shebafinder.com</p>
                            
                            <p><i class="fas fa-clock text-primary"></i> <strong>Office Hours:</strong><br>
                            Sunday - Thursday: 9:00 AM - 6:00 PM<br>
                            Friday - Saturday: Closed</p>
                        </div>
                    </div>
                    
                    <div class="card shadow-sm mt-3">
                        <div class="card-body">
                            <h5><i class="fas fa-share-alt text-primary"></i> Follow Us</h5>
                            <hr>
                            <div class="social-links">
                                <a href="#" class="btn btn-outline-primary me-2">
                                    <i class="fab fa-facebook-f"></i> Facebook
                                </a>
                                <a href="#" class="btn btn-outline-info me-2">
                                    <i class="fab fa-twitter"></i> Twitter
                                </a>
                                <a href="#" class="btn btn-outline-danger">
                                    <i class="fab fa-instagram"></i> Instagram
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-7">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4><i class="fas fa-envelope text-primary"></i> Send us a Message</h4>
                            <hr>
                            
                            <form method="POST">
                                <div class="mb-3">
                                    <label><i class="fas fa-user"></i> Your Name *</label>
                                    <input type="text" name="name" class="form-control" 
                                           value="<?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''; ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label><i class="fas fa-envelope"></i> Email Address *</label>
                                    <input type="email" name="email" class="form-control" 
                                           value="<?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label><i class="fas fa-tag"></i> Subject *</label>
                                    <input type="text" name="subject" class="form-control" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label><i class="fas fa-comment"></i> Message *</label>
                                    <textarea name="message" class="form-control" rows="5" required></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100 py-2">
                                    <i class="fas fa-paper-plane"></i> Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Google Maps (Optional) -->
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h5><i class="fas fa-map text-primary"></i> Our Location</h5>
                    <hr>
                    <div class="ratio ratio-16x9">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14602.673107417349!2d90.3563309!3d23.7946248!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c0c1c6d0e5d5%3A0xa5c6f9e8b6e5c0f!2sDhaka!5e0!3m2!1sen!2sbd!4v1700000000000!5m2!1sen!2sbd" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>