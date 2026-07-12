@extends('layouts.guest')

@section('content')
    <!-- Hero Section Component -->
    @include('landing.sections.hero')

    <!-- Keunggulan Section Component -->
    @include('landing.sections.keunggulan')

    <!-- Tentang Kami Detail Component (Links to /tentang-kami) -->
    @include('landing.sections.about')

    <!-- Produk Unggulan Component -->
    @include('landing.sections.featured_products')

    <!-- Cara Mendukung Component -->
    @include('landing.sections.cara_mendukung')

    <!-- Panduan Cara Pemesanan Component -->
    @include('landing.sections.panduan_pemesanan')

    <!-- Testimoni Pembeli Component -->
    @include('landing.sections.testimonials')

    <!-- Kenali Para Pembuatnya Component -->
    @include('landing.sections.creators')

    <!-- Lebih Dari Sekedar Belanja Component -->
    @include('landing.sections.cta')
@endsection

@push('scripts')
    <script>
        // GSAP ScrollTrigger Animations for Landing Page
        document.addEventListener('DOMContentLoaded', () => {
            const checkGsap = setInterval(() => {
                if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
                    clearInterval(checkGsap);
                    initGSAPAnimations();
                }
            }, 50);

            function initGSAPAnimations() {
                // 1. Hero Section Text (fade & slide-right)
                gsap.from(".hero-text-column", {
                    x: -50,
                    opacity: 0,
                    duration: 1.2,
                    ease: "power3.out"
                });

                // 2. Hero Section Image (fade & scale-up)
                gsap.from(".hero-image-column", {
                    scale: 0.9,
                    opacity: 0,
                    duration: 1.5,
                    ease: "power2.out",
                    delay: 0.2
                });

                // 3. Keunggulan Banner (scroll triggered zoom-in)
                gsap.from(".keunggulan-banner", {
                    y: 30,
                    opacity: 0,
                    duration: 1,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: ".keunggulan-banner",
                        start: "top 90%",
                        toggleActions: "play none none none"
                    }
                });

                // 4. Landing About Image (scroll triggered slide-left)
                gsap.from(".landing-about-image-column", {
                    x: -50,
                    opacity: 0,
                    duration: 1.2,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: ".landing-about-image-column",
                        start: "top 80%",
                        toggleActions: "play none none none"
                    }
                });

                // 5. Landing About Text (scroll triggered slide-right)
                gsap.from(".landing-about-text-column", {
                    x: 50,
                    opacity: 0,
                    duration: 1.2,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: ".landing-about-text-column",
                        start: "top 80%",
                        toggleActions: "play none none none"
                    }
                });

                // 6. Featured Products Header
                gsap.from(".featured-products-header", {
                    y: 20,
                    opacity: 0,
                    duration: 1,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: ".featured-products-header",
                        start: "top 85%",
                        toggleActions: "play none none none"
                    }
                });

                // 7. Featured Products Cards (staggered entrance)
                if (document.querySelectorAll(".featured-product-card-item").length > 0) {
                    gsap.from(".featured-product-card-item", {
                        y: 40,
                        opacity: 0,
                        duration: 0.8,
                        stagger: 0.15,
                        ease: "power2.out",
                        scrollTrigger: {
                            trigger: ".featured-products-grid",
                            start: "top 85%",
                            toggleActions: "play none none none"
                        }
                    });
                }

                // 8. Cara Mendukung Header
                gsap.from(".support-header", {
                    y: 30,
                    opacity: 0,
                    duration: 1,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: ".support-header",
                        start: "top 85%",
                        toggleActions: "play none none none"
                    }
                });

                // 9. Cara Mendukung Cards (staggered entrance)
                if (document.querySelectorAll(".support-card-item").length > 0) {
                    gsap.from(".support-card-item", {
                        y: 40,
                        opacity: 0,
                        duration: 0.8,
                        stagger: 0.15,
                        ease: "power2.out",
                        scrollTrigger: {
                            trigger: ".support-grid",
                            start: "top 85%",
                            toggleActions: "play none none none"
                        }
                    });
                }

                // 10. Panduan Pemesanan Header
                gsap.from(".steps-header", {
                    y: 30,
                    opacity: 0,
                    duration: 1,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: ".steps-header",
                        start: "top 85%",
                        toggleActions: "play none none none"
                    }
                });

                // 11. Panduan Pemesanan Steps (staggered entrance)
                if (document.querySelectorAll(".step-item").length > 0) {
                    gsap.from(".step-item", {
                        y: 40,
                        opacity: 0,
                        duration: 0.8,
                        stagger: 0.15,
                        ease: "power2.out",
                        scrollTrigger: {
                            trigger: ".steps-grid",
                            start: "top 85%",
                            toggleActions: "play none none none"
                        }
                    });
                }

                // 12. Testimoni Pembeli Header
                gsap.from(".testimonial-header", {
                    y: 30,
                    opacity: 0,
                    duration: 1,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: ".testimonial-header",
                        start: "top 85%",
                        toggleActions: "play none none none"
                    }
                });

                // 13. Testimoni Pembeli Cards (staggered entrance)
                if (document.querySelectorAll(".testimonial-card-item").length > 0) {
                    gsap.from(".testimonial-card-item", {
                        y: 40,
                        opacity: 0,
                        duration: 0.8,
                        stagger: 0.15,
                        ease: "power2.out",
                        scrollTrigger: {
                            trigger: ".testimonial-grid",
                            start: "top 85%",
                            toggleActions: "play none none none"
                        }
                    });
                }

                // 14. Creators Header
                gsap.from(".creators-header", {
                    y: 30,
                    opacity: 0,
                    duration: 1,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: ".creators-header",
                        start: "top 85%",
                        toggleActions: "play none none none"
                    }
                });

                // 15. Creators Cards (staggered entrance)
                if (document.querySelectorAll(".creator-card-item").length > 0) {
                    gsap.from(".creator-card-item", {
                        y: 40,
                        opacity: 0,
                        duration: 0.8,
                        stagger: 0.2,
                        ease: "power2.out",
                        scrollTrigger: {
                            trigger: ".creators-grid",
                            start: "top 85%",
                            toggleActions: "play none none none"
                        }
                    });
                }

                // 16. Landing CTA Card entrance (scroll triggered slide-up)
                gsap.from(".landing-cta-card", {
                    y: 40,
                    opacity: 0,
                    duration: 1.2,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: ".landing-cta-card",
                        start: "top 85%",
                        toggleActions: "play none none none"
                    }
                });
            }
        });
    </script>
@endpush