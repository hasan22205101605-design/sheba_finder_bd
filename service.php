<?php
require_once 'db.php';
include 'inc/header.php';

$category_id = isset($_GET['category']) ? (int)$_GET['category'] : null;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$query = "SELECT t.*, c.name as category_name 
          FROM technicians t 
          JOIN categories c ON t.category_id = c.id 
          WHERE t.status = 'active'";

$params = [];

if($category_id) {
    $query .= " AND t.category_id = ?";
    $params[] = $category_id;
}

if($search) {
    $query .= " AND (t.name LIKE ? OR c.name LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$query .= " ORDER BY t.rating DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$technicians = $stmt->fetchAll();

$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-filter"></i> Filter by Category</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="service.php" class="text-decoration-none <?php echo !$category_id ? 'text-primary fw-bold' : 'text-dark'; ?>">
                                <i class="fas fa-list"></i> All Services
                            </a>
                        </li>
                        <?php foreach($categories as $cat): ?>
                        <li class="list-group-item">
                            <a href="service.php?category=<?php echo $cat['id']; ?>" 
                               class="text-decoration-none <?php echo ($category_id == $cat['id']) ? 'text-primary fw-bold' : 'text-dark'; ?>">
                                <i class="<?php echo $cat['icon']; ?>"></i> <?php echo htmlspecialchars($cat['name']); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Quick Info</h5>
                </div>
                <div class="card-body">
                    <p><i class="fas fa-check-circle text-success"></i> Verified Technicians</p>
                    <p><i class="fas fa-tag text-primary"></i> Best Price Guarantee</p>
                    <p><i class="fas fa-clock text-warning"></i> 24/7 Service</p>
                </div>
            </div>
        </div>
        
        <!-- Main content -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>
                    <i class="fas fa-users"></i> Available Technicians 
                    <span class="badge bg-primary"><?php echo count($technicians); ?></span>
                </h3>
                <?php if($search): ?>
                    <a href="service.php" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Clear Search
                    </a>
                <?php endif; ?>
            </div>
            
            <?php if($search): ?>
                <div class="alert alert-info">
                    <i class="fas fa-search"></i> Search results for: <strong><?php echo htmlspecialchars($search); ?></strong>
                </div>
            <?php endif; ?>
            
            <?php if(count($technicians) > 0): ?>
                <div class="row">
                    <?php foreach($technicians as $tech): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm hover-card">
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <div class="avatar-circle bg-primary text-white">
                                        <?php echo strtoupper(substr($tech['name'], 0, 2)); ?>
                                    </div>
                                </div>
                                <h5 class="card-title text-center"><?php echo htmlspecialchars($tech['name']); ?></h5>
                                <p class="text-muted text-center">
                                    <i class="<?php echo $tech['icon'] ?? 'fas fa-tools'; ?>"></i>
                                    <?php echo htmlspecialchars($tech['category_name']); ?>
                                </p>
                                
                                <div class="rating text-center mb-2">
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <?php if($i <= $tech['rating']): ?>
                                            <i class="fas fa-star text-warning"></i>
                                        <?php else: ?>
                                            <i class="far fa-star text-warning"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    <span class="text-muted">(<?php echo $tech['rating']; ?>)</span>
                                </div>
                                
                                <div class="tech-details mt-3">
                                    <p><i class="fas fa-briefcase"></i> Experience: <?php echo $tech['experience']; ?> years</p>
                                    <p><i class="fas fa-taka"></i> Price: <?php echo number_format($tech['price_per_hour'], 2); ?>/hour</p>
                                    <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($tech['phone']); ?></p>
                                </div>
                                
                                <a href="technician.php?id=<?php echo $tech['id']; ?>" class="btn btn-primary w-100">
                                    <i class="fas fa-eye"></i> View Profile & Book
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-triangle fa-2x mb-3 d-block"></i>
                    <h5>No technicians found!</h5>
                    <p>Please try different search terms or browse all categories.</p>
                    <a href="service.php" class="btn btn-primary">View All Services</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}
.avatar-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: bold;
    margin: 0 auto;
}
.tech-details p {
    font-size: 14px;
    margin-bottom: 8px;
}
</style>

<?php include 'inc/footer.php'; ?>