<?php
require_once '../db.php';

if(!isLoggedIn() || !isAdmin()) {
    header("Location: login.php");
    exit();
}

// Handle status update
if(isset($_GET['status']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
    header("Location: bookings.php?msg=updated");
    exit();
}

$bookings = $pdo->query("SELECT b.*, t.name as tech_name 
                         FROM bookings b 
                         JOIN technicians t ON b.technician_id = t.id 
                         ORDER BY b.created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Sheba Finder BD - Admin</a>
            <div>
                <span class="text-white me-3">Welcome, <?php echo $_SESSION['user_name']; ?></span>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 bg-light p-0" style="min-height: calc(100vh - 56px);">
                <div class="list-group list-group-flush">
                    <a href="dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
                    <a href="technicians.php" class="list-group-item list-group-item-action">Technicians</a>
                    <a href="categories.php" class="list-group-item list-group-item-action">Categories</a>
                    <a href="bookings.php" class="list-group-item list-group-item-action active">Bookings</a>
                </div>
            </div>

            <div class="col-md-10 p-4">
                <h2><i class="fas fa-calendar-check"></i> Manage Bookings</h2>
                
                <?php if(isset($_GET['msg'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        Booking status updated successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th><th>Customer</th><th>Technician</th>
                                        <th>Date</th><th>Time</th><th>Amount</th><th>Status</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($bookings as $booking): ?>
                                    <tr>
                                        <td>#<?php echo $booking['id']; ?></td>
                                        <td><?php echo htmlspecialchars($booking['customer_name']); ?><br>
                                            <small><?php echo $booking['customer_phone']; ?></small>
                                        </td>
                                        <td><?php echo htmlspecialchars($booking['tech_name']); ?></td>
                                        <td><?php echo date('d M Y', strtotime($booking['booking_date'])); ?></td>
                                        <td><?php echo date('h:i A', strtotime($booking['booking_time'])); ?></td>
                                        <td>TK <?php echo number_format($booking['total_amount'], 2); ?></td>
                                        <td>
                                            <span class="badge <?php 
                                                echo $booking['status'] == 'pending' ? 'bg-warning' : 
                                                    ($booking['status'] == 'confirmed' ? 'bg-primary' : 
                                                    ($booking['status'] == 'completed' ? 'bg-success' : 'bg-danger')); 
                                            ?>">
                                                <?php echo ucfirst($booking['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="?status=pending&id=<?php echo $booking['id']; ?>" 
                                                   class="btn btn-warning">Pending</a>
                                                <a href="?status=confirmed&id=<?php echo $booking['id']; ?>" 
                                                   class="btn btn-primary">Confirm</a>
                                                <a href="?status=completed&id=<?php echo $booking['id']; ?>" 
                                                   class="btn btn-success">Complete</a>
                                                <a href="?status=cancelled&id=<?php echo $booking['id']; ?>" 
                                                   class="btn btn-danger" onclick="return confirm('Cancel this booking?')">Cancel</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>