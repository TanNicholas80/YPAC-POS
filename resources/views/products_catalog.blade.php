@extends('layouts.guest')

@section('title', 'Katalog Produk - KUBE YPAC')

@section('content')
    <!-- Catalog Section Component -->
    @include('products.sections.catalog')
@endsection

@push('scripts')
    <!-- Catalog Filtering JavaScript -->
    <script>
        let selectedCategory = 'all';

        // Filter by typing name
        function filterCatalog() {
            const query = document.getElementById('catalog-search').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.product-card-item');
            let visibleCount = 0;

            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                const category = card.getAttribute('data-category');

                const matchesSearch = name.includes(query);
                const matchesCategory = (selectedCategory === 'all' || category === selectedCategory);

                if (matchesSearch && matchesCategory) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            // Toggle empty state if no products are visible
            const emptyResults = document.getElementById('catalog-empty-results');
            const grid = document.getElementById('catalog-grid');

            if (visibleCount === 0) {
                emptyResults.classList.remove('hidden');
                grid.classList.add('hidden');
            } else {
                emptyResults.classList.add('hidden');
                grid.classList.remove('hidden');
            }
        }

        // Filter by clicking category pills
        function filterCategory(categorySlug, buttonElement) {
            selectedCategory = categorySlug;

            // Update active state of buttons
            const buttons = document.querySelectorAll('.category-filter-btn');
            buttons.forEach(btn => {
                btn.className = "category-filter-btn px-5 py-2.5 rounded-full text-xs font-bold transition-all border cursor-pointer bg-white text-gray-600 border-gray-250 hover:bg-gray-50 hover:text-gray-900";
            });

            // Active button styling
            buttonElement.className = "category-filter-btn px-5 py-2.5 rounded-full text-xs font-bold transition-all border cursor-pointer bg-[#0073E2] text-white border-transparent shadow-md shadow-blue-100";

            // Run filter logic
            filterCatalog();
        }

        // Reset search field and active category filters
        function resetFilters() {
            document.getElementById('catalog-search').value = '';
            selectedCategory = 'all';
            
            const allBtn = document.getElementById('category-all-btn');
            filterCategory('all', allBtn);
        }

        // GSAP ScrollTrigger Animations
        document.addEventListener('DOMContentLoaded', () => {
            const checkGsap = setInterval(() => {
                if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
                    clearInterval(checkGsap);
                    initGSAPAnimations();
                }
            }, 50);

            function initGSAPAnimations() {
                // 1. Catalog Title Header Animation
                gsap.from(".catalog-header", {
                    y: 40,
                    opacity: 0,
                    duration: 1,
                    ease: "power3.out"
                });

                // 2. Search & Filter Bar Animation
                gsap.from(".catalog-controls", {
                    y: 20,
                    opacity: 0,
                    duration: 1,
                    delay: 0.2,
                    ease: "power3.out"
                });

                // 3. Product Cards Staggered Animation
                gsap.from(".product-card-item", {
                    y: 40,
                    opacity: 0,
                    duration: 0.8,
                    stagger: 0.1,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: "#catalog-grid",
                        start: "top 90%",
                        toggleActions: "play none none none"
                    }
                });
            }
        });
    </script>
@endpush
