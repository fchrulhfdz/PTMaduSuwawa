// Home Page JavaScript
class HomePage {
    constructor() {
        this.filterButtons = document.querySelectorAll('.category-filter');
        this.productCards = document.querySelectorAll('.product-card');
        this.productsContainer = document.getElementById('products-container');
        this.noProducts = document.getElementById('no-products');
        
        this.init();
    }

    init() {
        this.initFilterTabs();
        this.initProductCardHover();
        this.addCSSAnimations();
    }

    initFilterTabs() {
        this.filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                this.handleFilterClick(button);
            });
        });
    }

    handleFilterClick(button) {
        // Update active button with smooth transition
        this.filterButtons.forEach(btn => {
            btn.classList.remove('bg-gradient-to-r', 'from-amber-500', 'to-orange-500', 'text-white', 'shadow-lg');
            btn.classList.add('bg-white', 'text-gray-700', 'border-2', 'border-gray-200', 'shadow-lg');
        });
        
        button.classList.remove('bg-white', 'text-gray-700', 'border-2', 'border-gray-200', 'shadow-lg');
        button.classList.add('bg-gradient-to-r', 'from-amber-500', 'to-orange-500', 'text-white', 'shadow-lg');

        const category = button.getAttribute('data-category');
        this.filterProducts(category);
    }

    filterProducts(category) {
        let visibleProducts = 0;

        // Filter products with fade animation
        this.productCards.forEach(card => {
            if (category === 'all' || card.getAttribute('data-category') === category) {
                card.style.display = 'block';
                card.style.animation = 'fadeIn 0.5s ease-in';
                visibleProducts++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide no products message
        this.toggleNoProductsMessage(visibleProducts);
    }

    toggleNoProductsMessage(visibleProducts) {
        if (visibleProducts === 0) {
            this.productsContainer.style.display = 'none';
            this.noProducts.classList.remove('hidden');
            this.noProducts.style.animation = 'fadeIn 0.5s ease-in';
        } else {
            this.productsContainer.style.display = 'grid';
            this.noProducts.classList.add('hidden');
        }
    }

    initProductCardHover() {
        const productCardsAll = document.querySelectorAll('[data-category]');
        productCardsAll.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-8px)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
            });
        });
    }

    addCSSAnimations() {
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        `;
        document.head.appendChild(style);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new HomePage();
});