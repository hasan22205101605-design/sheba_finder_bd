<?php
session_start();
include 'inc/header.php';
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <div class="hero-section bg-primary text-white text-center py-5 rounded">
                <h1>Welcome to Sheba Finder BD</h1>
                <p class="lead">Test page for Day 2 output</p>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <i class="fas fa-wrench fa-2x text-primary"></i>
                    <h5 class="mt-2">Header Working</h5>
                    <p>Navigation bar is showing correctly</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <i class="fas fa-css3 fa-2x text-primary"></i>
                    <h5 class="mt-2">CSS Working</h5>
                    <p>Styles are applied properly</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <i class="fas fa-js fa-2x text-primary"></i>
                    <h5 class="mt-2">JavaScript Working</h5>
                    <p>Check console for message</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Rating Stars Test</h5>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <span>(4.0 rating)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>