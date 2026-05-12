<?php
require_once '../db.php';

if(!isLoggedIn() || !isAdmin()) {
    header("Location: login.php");
    exit();
}

// Handle delete
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM technicians WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: technicians.php?msg=deleted");
    exit();
}

$technicians = $pdo->query("SELECT t.*, c.name as category_name 
                            FROM technicians t 
                            JOIN categories c ON t.category_id = c.id 
                            ORDER BY t.id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Technicians - Admin</title>
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
                    <a href="technicians.php" class="list-group-item list-group-item-action active">Technicians</a>
                    <a href="categories.php" class="list-group-item list-group-item-action">Categories</a>
                    <a href="bookings.php" class="list-group-item list-group-item-action">Bookings</a>
                </div>
            </div>

            <div class="col-md-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-users"></i> Manage Technicians</h2>
                    <a href="add_technician.php" class="btn btn-success">
                        <i class="fas fa-plus"></i> Add New Technician
                    </a>
                </div>

                <?php if(isset($_GET['msg'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?php 
                            if($_GET['msg'] == 'deleted') echo "Technician deleted successfully!";
                            if($_GET['msg'] == 'added') echo "Technician added successfully!";
                            if($_GET['msg'] == 'updated') echo "Technician updated successfully!";
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead class="table-dark">
                                <tr><th>ID</th><th>Name</th><th>Category</th><th>Phone</th><th>Experience</th><th>Price/Hour</th><th>Status</th><th>Actions</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach($technicians as $tech): ?>
                                <tr>
                                    <td><?php echo $tech['id']; ?></td>
                                    <td><?php echo htmlspecialchars($tech['name']); ?></td>
                                    <td><?php echo htmlspecialchars($tech['category_name']); ?></td>
                                    <td><?php echo $tech['phone']; ?></td>
                                    <td><?php echo $tech['experience']; ?> yrs</td>
                                    <td>TK <?php echo number_format($tech['price_per_hour'], 2); ?></td>
                                    <td>
                                        <span class="badge <?php echo $tech['status'] == 'active' ? 'bg-success' : 'bg-danger'; ?>">
                                            <?php echo ucfirst($tech['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="edit_technician.php?id=<?php echo $tech['id']; ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?delete=<?php echo $tech['id']; ?>" class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>