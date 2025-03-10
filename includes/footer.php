    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5>যোগাযোগ করুন</h5>
                    <p><i class="fas fa-phone me-2"></i>০১৭১২-৩৪৫৬৭৮</p>
                    <p><i class="fas fa-envelope me-2"></i>info@example.com</p>
                    <p><i class="fas fa-map-marker-alt me-2"></i>ঢাকা, বাংলাদেশ</p>
                </div>
                <div class="col-md-4">
                    <h5>দ্রুত লিংক</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="#">প্রাইভেসি পলিসি</a></li>
                        <li><a href="#">রিফান্ড পলিসি</a></li>
                        <li><a href="#">শর্তাবলী</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>সামাজিক যোগাযোগ</h5>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0">&copy; ২০২৪ কালোজিরা মধু। সর্বস্বত্ব সংরক্ষিত।</p>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button
    <a href="https://wa.me/your-number" class="floating-whatsapp">
        <i class="fab fa-whatsapp fa-2x"></i>
    </a> -->

    <!-- Scripts -->
    <script src="assets/plugin/bootstrap@5.3.0/bootstrap.bundle.min.js"></script>
    <script src="assets/plugin/aos@2.3.1/aos.js"></script>
    <script src="assets/plugin/sweetalert2@11/sweetalert2@11.js"></script>
    <script src="assets/plugin/zencdn/video.min.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Remove preloader
        window.addEventListener('load', function() {
            setTimeout(() => {
                document.querySelector('.preloader').style.opacity = '0';
                setTimeout(() => {
                    document.querySelector('.preloader').style.display = 'none';
                }, 500);
            }, 1500);
        });

        // Order form functionality
        const orderForm = document.getElementById('orderForm');
        const quantitySelect = document.getElementById('quantity');
        const summaryQuantity = document.getElementById('summaryQuantity');
        const summaryPrice = document.getElementById('summaryPrice');
        const summaryTotal = document.getElementById('summaryTotal');

        const prices = {
            '250': 450,
            '500': 850,
            '1000': 1650
        };

        quantitySelect.addEventListener('change', function() {
            const selected = this.value;
            const price = prices[selected] || 0;
            
            summaryQuantity.textContent = selected ? `${selected} গ্রাম` : '-';
            summaryPrice.textContent = price ? `৳${price}` : '-';
            summaryTotal.textContent = price ? `৳${price}` : '-';
        });

        orderForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>প্রক্রিয়াকরণ হচ্ছে...';

            // Simulate form submission
            setTimeout(() => {
                Swal.fire({
                    title: 'অর্ডার সফল হয়েছে!',
                    text: 'আপনার অর্ডারটি সফলভাবে গৃহীত হয়েছে।',
                    icon: 'success',
                    confirmButtonText: 'ঠিক আছে'
                });

                // Reset form
                this.reset();
                summaryQuantity.textContent = '-';
                summaryPrice.textContent = '-';
                summaryTotal.textContent = '-';
                
                // Reset button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>অর্ডার কনফার্ম করুন';
            }, 2000);
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                const offset = 100;
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            });
        });

        // Pricing card hover effect
        const pricingCards = document.querySelectorAll('.price-card');
        pricingCards.forEach(card => {
            card.addEventListener('mouseover', function() {
                pricingCards.forEach(c => c.classList.remove('featured'));
                this.classList.add('featured');
            });
        });

        // Add floating animations to benefit items
        const benefitItems = document.querySelectorAll('.benefit-item');
        benefitItems.forEach((item, index) => {
            item.style.animation = `float ${2 + index * 0.2}s ease-in-out infinite`;
        });
        var player = videojs('honey-video', {
        responsive: true,
        fluid: true,
        controls: true,
        playbackRates: [0.5, 1, 1.5, 2]
    });
    </script>
</body>
</html>