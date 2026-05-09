<?php
require_once 'db.php';
include 'inc/header.php';
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="text-center mb-5">
                <h1 class="display-4">About Sheba Finder BD</h1>
                <p class="lead">Your trusted partner for home services in Bangladesh</p>
            </div>
            
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3><i class="fas fa-rocket text-primary"></i> Our Mission</h3>
                    <p>To provide reliable, quality, and affordable home services to every household in Bangladesh. We connect customers with verified and experienced technicians for all their home service needs.</p>
                </div>
            </div>
            
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3><i class="fas fa-eye text-primary"></i> Our Vision</h3>
                    <p>To become the largest and most trusted home service platform in Bangladesh, creating employment opportunities for skilled technicians while providing peace of mind to our customers.</p>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h4>Why Choose Us?</h4>
                            <ul class="text-start mt-3">
                                <li>✓ Verified and experienced technicians</li>
                                <li>✓ Transparent pricing</li>
                                <li>✓ 100% satisfaction guarantee</li>
                                <li>✓ 24/7 customer support</li>
                                <li>✓ On-time service delivery</li>
                                <li>✓ Quality workmanship</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
                            <h4>Our Achievements</h4>
                            <div class="row mt-3 text-center">
                                <div class="col-6">
                                    <h2 class="text-primary">50+</h2>
                                    <p>Technicians</p>
                                </div>
                                <div class="col-6">
                                    <h2 class="text-primary">100+</h2>
                                    <p>Happy Clients</p>
                                </div>
                                <div class="col-6">
                                    <h2 class="text-primary">6+</h2>
                                    <p>Services</p>
                                </div>
                                <div class="col-6">
                                    <h2 class="text-primary">98%</h2>
                                    <p>Satisfaction</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3><i class="fas fa-tools text-primary"></i> Our Services</h3>
                    <div class="row mt-3">
                        <div class="col-md-4 mb-2">
                            <i class="fas fa-wrench text-primary"></i> Plumbing
                        </div>
                        <div class="col-md-4 mb-2">
                            <i class="fas fa-bolt text-primary"></i> Electrical
                        </div>
                        <div class="col-md-4 mb-2">
                            <i class="fas fa-hammer text-primary"></i> Carpentry
                        </div>
                        <div class="col-md-4 mb-2">
                            <i class="fas fa-snowflake text-primary"></i> AC Repair
                        </div>
                        <div class="col-md-4 mb-2">
                            <i class="fas fa-broom text-primary"></i> Cleaning
                        </div>
                        <div class="col-md-4 mb-2">
                            <i class="fas fa-paint-brush text-primary"></i> Painting
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h3>Ready to get started?</h3>
                    <p>Book a service today and experience the best home service in Bangladesh!</p>
                    <a href="service.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-search"></i> Find Technicians
                    </a>
                    <?php if(!isLoggedIn()): ?>
                        <a href="signup.php" class="btn btn-success btn-lg">
                            <i class="fas fa-user-plus"></i> Sign Up Free
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>