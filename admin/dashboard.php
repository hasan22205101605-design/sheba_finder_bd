<?php
require_once '../db.php';

// Check if logged in as admin
if(!isLoggedIn() || !isAdmin()) {
    header("Location: login.php");
    exit();
}

// Get statistics
$totalTech = $pdo->query("SELECT COUNT(*) FROM technicians")->fetchColumn();
$activeTech = $pdo->query("SELECT COUNT(*) FROM technicians WHERE status = 'active'")->fetchColumn();
$totalBookings = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$pendingBookings = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'pending'")->fetchColumn();
$totalCategories = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users WHERE user_type = 'user'")->fetchColumn();

// Get recent bookings
$stmt = $pdo->query("SELECT b.*, t.name as tech_name 
                     FROM bookings b 
                     JOIN technicians t ON b.technician_id = t.id 
                     ORDER BY b.created_at DESC LIMIT 5");
$recentBookings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sheba Finder BD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-tools"></i> Sheba Finder BD - Admin Panel
            </a>
            <div class="d-flex">
                <span class="text-white me-3">Welcome, <?php echo $_SESSION['user_name']; ?></span>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 bg-light p-0" style="min-height: calc(100vh - 56px);">
                <div class="list-group list-group-flush">
                    <a href="dashboard.php" class="list-group-item list-group-item-action active">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="technicians.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-users"></i> Technicians
                    </a>
                    <a href="categories.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-tags"></i> Categories
                    </a>
                    <a href="bookings.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-check"></i> Bookings
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <h2 class="mb-4">Dashboard Overview</h2>
                
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h3><?php echo $totalTech; ?></h3>
                                <p>Total Technicians</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h3><?php echo $activeTech; ?></h3>
                                <p>Active Technicians</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h3><?php echo $totalBookings; ?></h3>
                                <p>Total Bookings</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h3><?php echo $pendingBookings; ?></h3>
                                <p>Pending Bookings</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card bg-secondary text-white">
                            <div class="card-body">
                                <h3><?php echo $totalCategories; ?></h3>
                                <p>Categories</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card bg-dark text-white">
                            <div class="card-body">
                                <h3><?php echo $totalUsers; ?></h3>
                                <p>Registered Users</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="card mt-4">
                    <div class="card-header bg-primary text-white">
                        <h5>Recent Bookings</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr><th>ID</th><th>Customer</th><th>Technician</th><th>Date</th><th>Status</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach($recentBookings as $booking): ?>
                                <tr>
                                    <td><?php echo $booking['id']; ?></td>
                                    <td><?php echo $booking['customer_name']; ?></td>
                                    <td><?php echo $booking['tech_name']; ?></td>
                                    <td><?php echo $booking['booking_date']; ?></td>
                                    <td><?php echo ucfirst($booking['status']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>