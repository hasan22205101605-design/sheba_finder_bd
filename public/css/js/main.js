// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function() {
    
    // Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Form Validation
    const bookingForm = document.querySelector('form[action="booking.php"]');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            const phone = this.querySelector('input[name="customer_phone"]');
            if (phone) {
                const phoneRegex = /^01[3-9]\d{8}$/;
                if (!phoneRegex.test(phone.value)) {
                    e.preventDefault();
                    alert('Please enter a valid Bangladeshi phone number');
                    phone.focus();
                }
            }
        });
    }
    
    // Auto dismiss alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
    
    // Back to Top Button
    const backToTop = document.createElement('button');
    backToTop.innerHTML = '<i class="fas fa-arrow-up"></i>';
    backToTop.id = 'backToTop';
    backToTop.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        background: #0d6efd;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: none;
        z-index: 1000;
    `;
    document.body.appendChild(backToTop);
    
    window.addEventListener('scroll', () => {
        backToTop.style.display = window.scrollY > 300 ? 'block' : 'none';
    });
    
    backToTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    
    console.log('Sheba Finder BD Loaded!');
});