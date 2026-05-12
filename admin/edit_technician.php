<?php
require_once '../db.php';

if(!isLoggedIn() || !isAdmin()) {
    header("Location: login.php");
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM technicians WHERE id = ?");
$stmt->execute([$id]);
$technician = $stmt->fetch();

if(!$technician) {
    header("Location: technicians.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $experience = $_POST['experience'];
    $price_per_hour = $_POST['price_per_hour'];
    $status = $_POST['status'];
    
    $stmt = $pdo->prepare("UPDATE technicians SET category_id=?, name=?, phone=?, email=?, 
                           address=?, experience=?, price_per_hour=?, status=? WHERE id=?");
    
    if($stmt->execute([$category_id, $name, $phone, $email, $address, $experience, $price_per_hour, $status, $id])) {
        header("Location: technicians.php?msg=updated");
        exit();
    } else {
        $error = 'Failed to update technician';
    }
}

$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Technician - Admin</title>
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
                <h2><i class="fas fa-edit"></i> Edit Technician</h2>
                
                <div class="card mt-3">
                    <div class="card-body">
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Category *</label>
                                    <select name="category_id" class="form-control" required>
                                        <?php foreach($categories as $cat): ?>
                                            <option value="<?php echo $cat['id']; ?>" 
                                                <?php echo $cat['id'] == $technician['category_id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($cat['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label>Full Name *</label>
                                    <input type="text" name="name" class="form-control" 
                                           value="<?php echo htmlspecialchars($technician['name']); ?>" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label>Phone Number *</label>
                                    <input type="text" name="phone" class="form-control" 
                                           value="<?php echo $technician['phone']; ?>" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" 
                                           value="<?php echo $technician['email']; ?>">
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label>Address</label>
                                    <textarea name="address" class="form-control" rows="2"><?php echo htmlspecialchars($technician['address']); ?></textarea>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label>Experience (Years)</label>
                                    <input type="number" name="experience" class="form-control" 
                                           value="<?php echo $technician['experience']; ?>">
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label>Price per Hour (TK) *</label>
                                    <input type="number" name="price_per_hour" class="form-control" step="50" 
                                           value="<?php echo $technician['price_per_hour']; ?>" required>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="active" <?php echo $technician['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo $technician['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Technician
                                    </button>
                                    <a href="technicians.php" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>