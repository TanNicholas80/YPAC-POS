@extends('layouts.guest')

@section('title', 'Hubungi Kami - KUBE YPAC')

@section('content')
    <!-- Main Contact Page Content component -->
    @include('contact.sections.form_info')
@endsection

@push('scripts')
    <script>
        // Dynamically toggle select font color depending on selection state
        function updateSelectColor() {
            const select = document.getElementById('contact-topic');
            if (!select) return;
            if (select.value) {
                select.classList.remove('text-gray-400');
                select.classList.add('text-gray-800');
            } else {
                select.classList.remove('text-gray-800');
                select.classList.add('text-gray-400');
            }
        }

        // Document ready handler to read query parameters for auto-selection
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const topicParam = urlParams.get('topik');
            const topicSelect = document.getElementById('contact-topic');

            if (topicSelect && topicParam) {
                if (topicParam === 'instansi') {
                    topicSelect.value = 'Kerja Sama Instansi';
                } else if (topicParam === 'donasi') {
                    topicSelect.value = 'Donasi';
                } else if (topicParam === 'magang') {
                    topicSelect.value = 'Magang';
                } else if (topicParam === 'bulk' || topicParam === 'pesanan') {
                    topicSelect.value = 'Pesanan Jumlah Besar';
                }

                // If a topic was successfully auto-selected, update the font color
                updateSelectColor();
            }

            // GSAP ScrollTrigger Animations
            const checkGsap = setInterval(() => {
                if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
                    clearInterval(checkGsap);
                    initGSAPAnimations();
                }
            }, 50);

            function initGSAPAnimations() {
                // 1. Contact Header Animation (slide-down & fade)
                gsap.from(".contact-header", {
                    y: -40,
                    opacity: 0,
                    duration: 1.2,
                    ease: "power3.out"
                });

                // 2. Contact Info Column Animation (slide-in from left)
                gsap.from(".contact-info-column", {
                    x: -50,
                    opacity: 0,
                    duration: 1.2,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: ".contact-info-column",
                        start: "top 80%",
                        toggleActions: "play none none none"
                    }
                });

                // 3. Contact Form Card Animation (slide-in from right)
                gsap.from(".contact-form-column", {
                    x: 50,
                    opacity: 0,
                    duration: 1.2,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: ".contact-form-column",
                        start: "top 80%",
                        toggleActions: "play none none none"
                    }
                });
            }
        });
    </script>
@endpush