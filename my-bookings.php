<?php
require_once 'db.php';

// যদি লগইন না করা থাকে তাহলে লগইন পেজে নিয়ে যান
if(!isLoggedIn()) {
    $_SESSION['error'] = "Please login to view your bookings!";
    header("Location: login.php");
    exit();
}

// Get user's bookings
$stmt = $pdo->prepare("SELECT b.*, t.name as tech_name, t.price_per_hour, t.phone as tech_phone
                       FROM bookings b 
                       JOIN technicians t ON b.technician_id = t.id 
                       WHERE b.user_id = ? 
                       ORDER BY b.created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$bookings = $stmt->fetchAll();

include 'inc/header.php';
?>

<div class="container my-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-user-circle fa-4x text-primary"></i>
                    <h5 class="mt-3"><?php echo htmlspecialchars($_SESSION['user_name']); ?></h5>
                    <p class="text-muted"><?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                </div>
                <div class="list-group list-group-flush">
                    <a href="profile.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-id-card"></i> My Profile
                    </a>
                    <a href="my-bookings.php" class="list-group-item list-group-item-action active">
                        <i class="fas fa-calendar-alt"></i> My Bookings
                    </a>
                    <a href="logout.php" class="list-group-item list-group-item-action text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3><i class="fas fa-calendar-alt"></i> My Bookings</h3>
                <a href="service.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Booking
                </a>
            </div>
            
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> <?php 
                        echo $_SESSION['success']; 
                        unset($_SESSION['success']);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if(count($bookings) > 0): ?>
                <div class="row">
                    <?php foreach($bookings as $booking): ?>
                    <div class="col-md-12 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <h5 class="mb-1"><?php echo htmlspecialchars($booking['tech_name']); ?></h5>
                                        <small class="text-muted">
                                            <i class="fas fa-phone"></i> <?php echo $booking['tech_phone']; ?>
                                        </small>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="mb-0">
                                            <i class="fas fa-calendar"></i> 
                                            <?php echo date('d M Y', strtotime($booking['booking_date'])); ?>
                                        </p>
                                        <p class="mb-0">
                                            <i class="fas fa-clock"></i> 
                                            <?php echo date('h:i A', strtotime($booking['booking_time'])); ?>
                                        </p>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="mb-0">
                                            <i class="fas fa-taka"></i> 
                                            <?php echo number_format($booking['total_amount'], 2); ?>
                                        </p>
                                        <small class="text-muted">
                                            <?php echo $booking['total_amount'] / $booking['price_per_hour']; ?> hours
                                        </small>
                                    </div>
                                    <div class="col-md-2">
                                        <?php
                                        $status_badge = [
                                            'pending' => 'bg-warning',
                                            'confirmed' => 'bg-primary',
                                            'completed' => 'bg-success',
                                            'cancelled' => 'bg-danger'
                                        ];
                                        $status_text = [
                                            'pending' => 'Pending',
                                            'confirmed' => 'Confirmed',
                                            'completed' => 'Completed',
                                            'cancelled' => 'Cancelled'
                                        ];
                                        ?>
                                        <span class="badge <?php echo $status_badge[$booking['status']]; ?> p-2">
                                            <?php echo $status_text[$booking['status']]; ?>
                                        </span>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <?php if($booking['status'] == 'pending'): ?>
                                            <a href="cancel-booking.php?id=<?php echo $booking['id']; ?>" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                <i class="fas fa-times"></i> Cancel
                                            </a>
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-info btn-sm" 
                                                data-bs-toggle="modal" data-bs-target="#detailsModal<?php echo $booking['id']; ?>">
                                            <i class="fas fa-eye"></i> Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal for Booking Details -->
                        <div class="modal fade" id="detailsModal<?php echo $booking['id']; ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Booking Details</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Booking ID:</strong> #<?php echo $booking['id']; ?></p>
                                        <p><strong>Technician:</strong> <?php echo htmlspecialchars($booking['tech_name']); ?></p>
                                        <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($booking['customer_name']); ?></p>
                                        <p><strong>Phone:</strong> <?php echo $booking['customer_phone']; ?></p>
                                        <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($booking['address'])); ?></p>
                                        <p><strong>Date:</strong> <?php echo date('d M Y', strtotime($booking['booking_date'])); ?></p>
                                        <p><strong>Time:</strong> <?php echo date('h:i A', strtotime($booking['booking_time'])); ?></p>
                                        <p><strong>Duration:</strong> <?php echo $booking['total_amount'] / $booking['price_per_hour']; ?> hours</p>
                                        <p><strong>Total Amount:</strong> TK <?php echo number_format($booking['total_amount'], 2); ?></p>
                                        <p><strong>Status:</strong> 
                                            <span class="badge <?php echo $status_badge[$booking['status']]; ?>">
                                                <?php echo $status_text[$booking['status']]; ?>
                                            </span>
                                        </p>
                                        <p><strong>Booked On:</strong> <?php echo date('d M Y, h:i A', strtotime($booking['created_at'])); ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                        <h5>No Bookings Found</h5>
                        <p class="text-muted">You haven't made any bookings yet.</p>
                        <a href="service.php" class="btn btn-primary">
                            <i class="fas fa-search"></i> Find Technicians
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>