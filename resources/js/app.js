import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Mobile menu functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('#mobile-menu') && 
            !event.target.closest('#mobile-menu-button') &&
            !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
        }
    });
    // Quick Review Functionality
class QuickReview {
    constructor() {
        this.modal = document.getElementById('quickReviewModal');
        this.modalContent = document.getElementById('modalContent');
        this.closeBtn = document.getElementById('closeModal');
        this.form = document.getElementById('quickReviewForm');
        this.quickComment = document.getElementById('quickComment');
        this.charCount = document.getElementById('charCount');
        this.guestNameField = document.getElementById('guestNameField');
        this.loginPrompt = document.getElementById('loginPrompt');
        
        this.init();
    }

    init() {
        // Event listeners untuk tombol review
        document.querySelectorAll('.quick-review-btn').forEach(btn => {
            btn.addEventListener('click', (e) => this.openModal(e));
        });

        // Close modal events
        this.closeBtn.addEventListener('click', () => this.closeModal());
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) this.closeModal();
        });

        // Character count untuk komentar
        this.quickComment.addEventListener('input', () => this.updateCharCount());

        // Form submission
        this.form.addEventListener('submit', (e) => this.submitReview(e));

        // Escape key untuk close modal
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') this.closeModal();
        });

        // Check auth status untuk tampilkan field nama
        this.checkAuthStatus();
    }

    openModal(e) {
        const button = e.currentTarget;
        const productId = button.getAttribute('data-product-id');
        const productName = button.getAttribute('data-product-name');
        const productPrice = button.getAttribute('data-product-price');

        // Set data produk ke modal
        document.getElementById('modalProductId').value = productId;
        document.getElementById('modalProductName').textContent = productName;
        
        // Format harga
        const formattedPrice = new Intl.NumberFormat('id-ID').format(productPrice);
        document.getElementById('modalProductPrice').textContent = `Rp ${formattedPrice}`;

        // Reset form
        this.resetForm();

        // Show modal dengan animation
        this.modal.classList.remove('hidden');
        setTimeout(() => {
            this.modalContent.classList.remove('scale-95', 'opacity-0');
            this.modalContent.classList.add('scale-100', 'opacity-100');
        }, 50);
    }

    closeModal() {
        this.modalContent.classList.remove('scale-100', 'opacity-100');
        this.modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            this.modal.classList.add('hidden');
        }, 300);
    }

    resetForm() {
        this.form.reset();
        this.updateCharCount();
        this.resetRating();
        this.checkAuthStatus();
    }

    resetRating() {
        const stars = document.querySelectorAll('#quickRatingStars button');
        stars.forEach((star, index) => {
            const icon = star.querySelector('i');
            icon.className = 'far fa-star';
            star.classList.remove('text-amber-400');
            star.classList.add('text-gray-300');
        });
        document.getElementById('quickRatingInput').value = '';
    }

    updateCharCount() {
        const count = this.quickComment.value.length;
        this.charCount.textContent = count;
        
        // Change color based on character count
        if (count > 180) {
            this.charCount.classList.add('text-red-500');
            this.charCount.classList.remove('text-gray-500', 'text-amber-500');
        } else if (count > 0) {
            this.charCount.classList.add('text-amber-500');
            this.charCount.classList.remove('text-gray-500', 'text-red-500');
        } else {
            this.charCount.classList.add('text-gray-500');
            this.charCount.classList.remove('text-amber-500', 'text-red-500');
        }
    }

    checkAuthStatus() {
        // Check if user is logged in
        const isLoggedIn = document.querySelector('meta[name="user-auth"]')?.getAttribute('content') === 'true';
        
        if (isLoggedIn) {
            this.guestNameField.classList.add('hidden');
            this.loginPrompt.classList.remove('hidden');
        } else {
            this.guestNameField.classList.remove('hidden');
            this.loginPrompt.classList.add('hidden');
        }
    }

    submitReview(e) {
        e.preventDefault();
        
        const formData = new FormData(this.form);
        const rating = formData.get('rating');
        const comment = formData.get('comment');

        // Validasi
        if (!rating) {
            this.showNotification('Harap berikan rating terlebih dahulu', 'error');
            return;
        }

        if (!comment.trim()) {
            this.showNotification('Harap tulis komentar terlebih dahulu', 'error');
            return;
        }

        // Simulasi pengiriman data
        this.sendReviewToServer(formData);
    }

    async sendReviewToServer(formData) {
        try {
            // Show loading state
            const submitBtn = this.form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
            submitBtn.disabled = true;

            // AJAX call ke endpoint review
            const response = await fetch('/reviews', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: formData
            });

            const result = await response.json();

            if (response.ok) {
                this.showNotification('Review berhasil dikirim! Terima kasih atas feedback Anda.', 'success');
                this.closeModal();
            } else {
                throw new Error(result.message || 'Terjadi kesalahan');
            }

        } catch (error) {
            console.error('Error submitting review:', error);
            this.showNotification('Terjadi kesalahan saat mengirim review. Silakan coba lagi.', 'error');
        } finally {
            // Reset button state
            const submitBtn = this.form.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Kirim Review';
            submitBtn.disabled = false;
        }
    }

    showNotification(message, type = 'info') {
        // Remove existing notification
        const existingNotification = document.querySelector('.quick-review-notification');
        if (existingNotification) {
            existingNotification.remove();
        }

        // Create notification
        const notification = document.createElement('div');
        notification.className = `quick-review-notification fixed top-4 right-4 z-50 px-6 py-4 rounded-2xl shadow-2xl transform transition-all duration-300 translate-x-full ${
            type === 'success' ? 'bg-green-500 text-white' :
            type === 'error' ? 'bg-red-500 text-white' :
            'bg-blue-500 text-white'
        }`;
        notification.innerHTML = `
            <div class="flex items-center space-x-3">
                <i class="fas ${
                    type === 'success' ? 'fa-check-circle' :
                    type === 'error' ? 'fa-exclamation-circle' :
                    'fa-info-circle'
                }"></i>
                <span class="font-semibold">${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 5000);
    }
}

// Global function untuk rating stars
function setQuickRating(rating) {
    // Update hidden input
    document.getElementById('quickRatingInput').value = rating;
    
    // Update stars display
    const stars = document.querySelectorAll('#quickRatingStars button');
    stars.forEach((star, index) => {
        const icon = star.querySelector('i');
        if (index < rating) {
            icon.className = 'fas fa-star';
            star.classList.add('text-amber-400');
            star.classList.remove('text-gray-300');
        } else {
            icon.className = 'far fa-star';
            star.classList.remove('text-amber-400');
            star.classList.add('text-gray-300');
        }
    });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quick Review jika modal ada di halaman
    if (document.getElementById('quickReviewModal')) {
        new QuickReview();
    }
    
    // Add CSS for animations
    const style = document.createElement('style');
    style.textContent = `
        .quick-review-notification {
            transition: transform 0.3s ease-in-out;
        }
    `;
    document.head.appendChild(style);
});
});