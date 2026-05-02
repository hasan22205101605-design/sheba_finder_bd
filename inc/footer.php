    </main>
    
    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5><i class="fas fa-tools"></i> Sheba Finder BD</h5>
                    <p>Your trusted partner for home services in Bangladesh. Quality service at your doorstep.</p>
                    <div class="social-links">
                        <a href="#" class="text-white me-2"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin fa-lg"></i></a>
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white text-decoration-none">Home</a></li>
                        <li><a href="service.php" class="text-white text-decoration-none">Services</a></li>
                        <li><a href="about.php" class="text-white text-decoration-none">About Us</a></li>
                        <li><a href="contact.php" class="text-white text-decoration-none">Contact</a></li>
                        <?php if(!isset($_SESSION['user_id'])): ?>
                            <li><a href="login.php" class="text-white text-decoration-none">Login</a></li>
                            <li><a href="signup.php" class="text-white text-decoration-none">Sign Up</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <div class="col-md-4 mb-3">
                    <h5>Contact Info</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-phone"></i> +880 1234 567890</li>
                        <li><i class="fas fa-envelope"></i> info@shebafinder.com</li>
                        <li><i class="fas fa-map-marker-alt"></i> Dhaka, Bangladesh</li>
                        <li><i class="fas fa-clock"></i> Sun-Thu: 9AM - 6PM</li>
                    </ul>
                </div>
            </div>
            
            <hr class="bg-secondary">
            
            <div class="text-center">
                <p class="mb-0">&copy; 2024 Sheba Finder BD. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
</body>
</html>