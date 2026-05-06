<?php
require_once 'db.php';
include 'inc/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT t.*, c.name as category_name, c.icon 
                       FROM technicians t 
                       JOIN categories c ON t.category_id = c.id 
                       WHERE t.id = ? AND t.status = 'active'");
$stmt->execute([$id]);
$technician = $stmt->fetch();

if(!$technician) {
    $_SESSION['error'] = "Technician not found!";
    header("Location: service.php");
    exit();
}

$reviewCount = 0; 
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-7">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="service.php">Services</a></li>
                    <li class="breadcrumb-item active"><?php echo htmlspecialchars($technician['name']); ?></li>
                </ol>
            </nav>
            
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="avatar-circle-lg bg-primary text-white mx-auto mb-3">
                                <?php echo strtoupper(substr($technician['name'], 0, 2)); ?>
                            </div>
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle"></i> Verified
                            </span>
                        </div>
                        <div class="col-md-8">
                            <h2><?php echo htmlspecialchars($technician['name']); ?></h2>
                            <p class="text-muted">
                                <i class="<?php echo $technician['icon']; ?>"></i> 
                                <?php echo htmlspecialchars($technician['category_name']); ?>
                            </p>
                            
                            <div class="rating mb-3">
                                <?php for($i=1; $i<=5; $i++): ?>
                                    <?php if($i <= $technician['rating']): ?>
                                        <i class="fas fa-star text-warning"></i>
                                    <?php else: ?>
                                        <i class="far fa-star text-warning"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <span class="text-muted">(<?php echo $technician['rating']; ?> rating)</span>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-6">
                                    <p><i class="fas fa-briefcase"></i> <strong>Experience:</strong><br>
                                    <?php echo $technician['experience']; ?> years</p>
                                </div>
                                <div class="col-6">
                                    <p><i class="fas fa-taka"></i> <strong>Rate:</strong><br>
                                    <?php echo number_format($technician['price_per_hour'], 2); ?> /hour</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-address-card"></i> Contact Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><i class="fas fa-phone"></i> <strong>Phone:</strong><br>
                            <?php echo htmlspecialchars($technician['phone']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><i class="fas fa-envelope"></i> <strong>Email:</strong><br>
                            <?php echo htmlspecialchars($technician['email'] ?: 'Not provided'); ?></p>
                        </div>
                        <div class="col-12">
                            <p><i class="fas fa-map-marker-alt"></i> <strong>Address:</strong><br>
                            <?php echo htmlspecialchars($technician['address']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> About</h5>
                </div>
                <div class="card-body">
                    <p><?php echo htmlspecialchars($technician['name']); ?> is a professional 
                    <?php echo htmlspecialchars($technician['category_name']); ?> technician 
                    with <?php echo $technician['experience']; ?> years of experience. 
                    Known for quality work and customer satisfaction.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="card shadow-sm sticky-top" style="top: 80px;">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar-check"></i> Book This Technician</h5>
                </div>
                <div class="card-body">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <form action="booking.php" method="POST">
                            <input type="hidden" name="technician_id" value="<?php echo $technician['id']; ?>">
                            <input type="hidden" name="price_per_hour" value="<?php echo $technician['price_per_hour']; ?>">
                            
                            <div class="mb-3">
                                <label><i class="fas fa-user"></i> Your Name *</label>
                                <input type="text" name="customer_name" class="form-control" 
                                       value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label><i class="fas fa-phone"></i> Phone Number *</label>
                                <input type="text" name="customer_phone" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label><i class="fas fa-envelope"></i> Email</label>
                                <input type="email" name="customer_email" class="form-control" 
                                       value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label><i class="fas fa-location-dot"></i> Service Address *</label>
                                <textarea name="address" class="form-control" rows="2" required></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label><i class="fas fa-calendar"></i> Date *</label>
                                    <input type="date" name="booking_date" class="form-control" 
                                           min="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label><i class="fas fa-clock"></i> Time *</label>
                                    <input type="time" name="booking_time" class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label><i class="fas fa-hourglass-half"></i> Duration (hours) *</label>
                                <input type="number" name="hours" class="form-control" min="1" max="24" 
                                       id="hours" onchange="updateTotal()" required>
                            </div>
                            
                            <div class="mb-3">
                                <label><i class="fas fa-calculator"></i> Total Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">TK</span>
                                    <input type="text" id="total_amount" class="form-control" readonly 
                                           value="0">
                                </div>
                                <small class="text-muted">Rate: TK <?php echo number_format($technician['price_per_hour'], 2); ?> per hour</small>
                            </div>
                            
                            <button type="submit" class="btn btn-success w-100 py-2">
                                <i class="fas fa-check-circle"></i> Confirm Booking
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-sign-in-alt fa-2x mb-2 d-block"></i>
                            <h5>Please login to book this technician</h5>
                            <p>You need to be logged in to make a booking.</p>
                            <a href="login.php" class="btn btn-primary">Login Now</a>
                            <a href="signup.php" class="btn btn-success">Create Account</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateTotal() {
    let hours = document.getElementById('hours').value;
    let rate = <?php echo $technician['price_per_hour']; ?>;
    let total = hours * rate;
    document.getElementById('total_amount').value = total.toFixed(2);
}
</script>

<style>
.avatar-circle-lg {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    font-weight: bold;
}
.sticky-top {
    position: sticky;
    top: 20px;
}
</style>

<?php include 'inc/footer.php'; ?>