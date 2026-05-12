<?php
require_once 'db.php';
include 'inc/header.php';

// Get statistics
$stmt = $pdo->query("SELECT COUNT(*) FROM technicians WHERE status = 'active'");
$techCount = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM bookings");
$bookingCount = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM categories");
$categoryCount = $stmt->fetchColumn();

// Get categories
$categories = $pdo->query("SELECT * FROM categories LIMIT 6")->fetchAll();

// Get top technicians
$technicians = $pdo->query("SELECT t.*, c.name as category_name 
                            FROM technicians t 
                            JOIN categories c ON t.category_id = c.id 
                            WHERE t.status = 'active' 
                            ORDER BY t.rating DESC LIMIT 6")->fetchAll();
?>

<!-- Hero Section -->
<div class="hero-section bg-primary text-white py-5">
    <div class="container text-center">
        <h1 class="display-4">Find Best Technicians in Bangladesh</h1>
        <p class="lead">Quality home services at your doorstep</p>
        
        <div class="search-box mt-4">
            <form action="service.php" method="GET" class="row justify-content-center">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control form-control-lg" 
                           placeholder="Search services or technicians...">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-light btn-lg">Search</button>
                </div>
            </form>
        </div>
        
        <?php if(!isset($_SESSION['user_id'])): ?>
            <div class="mt-4">
                <a href="signup.php" class="btn btn-success btn-lg me-2">
                    <i class="fas fa-user-plus"></i> Sign Up Free
                </a>
                <a href="login.php" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Stats Section -->
<div class="stats-section py-4 bg-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <h3 class="text-primary"><?php echo $techCount; ?>+</h3>
                <p>Expert Technicians</p>
            </div>
            <div class="col-md-4">
                <h3 class="text-primary"><?php echo $bookingCount; ?>+</h3>
                <p>Happy Customers</p>
            </div>
            <div class="col-md-4">
                <h3 class="text-primary"><?php echo $categoryCount; ?></h3>
                <p>Service Categories</p>
            </div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="categories-section py-5">
    <div class="container">
        <h2 class="text-center mb-4">Our Services</h2>
        <div class="row">
            <?php foreach($categories as $cat): ?>
            <div class="col-md-2 col-sm-4 col-6 mb-3">
                <a href="service.php?category=<?php echo $cat['id']; ?>" class="text-decoration-none">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="<?php echo $cat['icon']; ?> fa-2x text-primary"></i>
                            <h6 class="mt-2"><?php echo htmlspecialchars($cat['name']); ?></h6>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Technicians Section -->
<div class="technicians-section py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Top Rated Technicians</h2>
        <div class="row">
            <?php if(count($technicians) > 0): ?>
                <?php foreach($technicians as $tech): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($tech['name']); ?></h5>
                            <p class="text-muted"><?php echo htmlspecialchars($tech['category_name']); ?></p>
                            <div class="rating mb-2">
                                <?php for($i=1; $i<=5; $i++): ?>
                                    <?php if($i <= $tech['rating']): ?>
                                        <i class="fas fa-star text-warning"></i>
                                    <?php else: ?>
                                        <i class="far fa-star text-warning"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <span>(<?php echo $tech['rating']; ?>)</span>
                            </div>
                            <p><i class="fas fa-clock"></i> Experience: <?php echo $tech['experience']; ?> years</p>
                            <p><i class="fas fa-taka"></i> TK <?php echo number_format($tech['price_per_hour'], 2); ?>/hour</p>
                            <a href="technician.php?id=<?php echo $tech['id']; ?>" class="btn btn-primary w-100">
                                View Profile
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>No technicians found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>