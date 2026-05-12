<?php
require_once '../db.php';

if(!isLoggedIn() || !isAdmin()) {
    header("Location: login.php");
    exit();
}

// Handle delete
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: categories.php?msg=deleted");
    exit();
}

// Handle add
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $name = $_POST['name'];
    $icon = $_POST['icon'];
    
    if(!empty($name)) {
        $stmt = $pdo->prepare("INSERT INTO categories (name, icon) VALUES (?, ?)");
        $stmt->execute([$name, $icon]);
        header("Location: categories.php?msg=added");
        exit();
    }
}

$categories = $pdo->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - Admin</title>
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
                    <a href="categories.php" class="list-group-item list-group-item-action active">Categories</a>
                    <a href="bookings.php" class="list-group-item list-group-item-action">Bookings</a>
                </div>
            </div>

            <div class="col-md-10 p-4">
                <h2><i class="fas fa-tags"></i> Manage Categories</h2>
                
                <?php if(isset($_GET['msg'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?php 
                            if($_GET['msg'] == 'deleted') echo "Category deleted successfully!";
                            if($_GET['msg'] == 'added') echo "Category added successfully!";
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Add New Category</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST">
                                    <div class="mb-3">
                                        <label>Category Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Icon Class</label>
                                        <input type="text" name="icon" class="form-control" value="fas fa-tools">
                                        <small class="text-muted">Example: fas fa-wrench, fas fa-bolt</small>
                                    </div>
                                    <button type="submit" name="add" class="btn btn-primary w-100">
                                        <i class="fas fa-plus"></i> Add Category
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body p-0">
                                <table class="table table-hover mb-0">
                                    <thead class="table-dark">
                                        <tr><th>ID</th><th>Name</th><th>Icon</th><th>Actions</th></tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($categories as $cat): ?>
                                        <tr>
                                            <td><?php echo $cat['id']; ?></td>
                                            <td><i class="<?php echo $cat['icon']; ?>"></i> <?php echo htmlspecialchars($cat['name']); ?></td>
                                            <td><?php echo $cat['icon']; ?></td>
                                            <td>
                                                <a href="?delete=<?php echo $cat['id']; ?>" class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i> Delete
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
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>