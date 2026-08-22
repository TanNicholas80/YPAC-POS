@extends('layouts.guest')

@section('title', 'Tentang Kami - KUBE YPAC')

@section('content')
    <!-- Section 1 & 2: Header / Intro & Quote & Philosophy Grid -->
    @include('about.sections.intro')

    <!-- Section 3: Pendiri (Founder) -->
    @include('about.sections.founder')

    <!-- Section 4: Visi, Misi & Tujuan (with Metrik blocks) -->
    @include('about.sections.vision_mission')

    <!-- Section 5: Video (Virtual Tour) -->
    @include('about.sections.video_tour')

    <!-- Section 6: CTA Section -->
    @include('about.sections.cta')
@endsection

@push('styles')
<style>
    /* Sembunyikan tombol volume dan slider mute pada kontrol video browser */
    #virtual-tour-video::-webkit-media-controls-volume-control-container,
    #virtual-tour-video::-webkit-media-controls-mute-button,
    #virtual-tour-video::-webkit-media-controls-volume-slider {
        display: none !important;
    }
</style>
@endpush

@push('scripts')
<script>
    function switchTab(activeTab) {
        // Tab classes configuration map
        const tabs = {
            visi: {
                btnId: 'tab-btn-visi',
                contentId: 'tab-content-visi',
                activeClass: 'bg-[#0073E2] text-white shadow-md shadow-blue-100 border-transparent',
                inactiveClass: 'bg-gray-100 text-gray-600 border-transparent hover:bg-gray-200 hover:text-gray-800'
            },
            misi: {
                btnId: 'tab-btn-misi',
                contentId: 'tab-content-misi',
                activeClass: 'bg-[#e23cbf] text-white shadow-md shadow-pink-100 border-transparent',
                inactiveClass: 'bg-gray-100 text-gray-600 border-transparent hover:bg-gray-200 hover:text-gray-800'
            },
            tujuan: {
                btnId: 'tab-btn-tujuan',
                contentId: 'tab-content-tujuan',
                activeClass: 'bg-[#f97316] text-white shadow-md shadow-orange-100 border-transparent',
                inactiveClass: 'bg-gray-100 text-gray-600 border-transparent hover:bg-gray-200 hover:text-gray-800'
            }
        };

        // Update classes and visibility for each tab
        Object.keys(tabs).forEach(key => {
            const btn = document.getElementById(tabs[key].btnId);
            const content = document.getElementById(tabs[key].contentId);

            if (!btn || !content) return;

            if (key === activeTab) {
                // Set active classes on the button
                btn.className = `px-6 py-3 rounded-full text-sm sm:text-base font-bold transition-all duration-300 border cursor-pointer ${tabs[key].activeClass}`;
                
                // Show the content card with active scale/opacity classes
                content.classList.remove('hidden', 'opacity-0', 'scale-95');
                content.classList.add('block', 'opacity-100', 'scale-100');
            } else {
                // Set inactive classes on the button
                btn.className = `px-6 py-3 rounded-full text-sm sm:text-base font-bold transition-all duration-300 border cursor-pointer ${tabs[key].inactiveClass}`;
                
                // Hide the content card
                content.classList.remove('block', 'opacity-100', 'scale-100');
                content.classList.add('hidden', 'opacity-0', 'scale-95');
            }
        });
    }

    // Video custom overlay controls
    function togglePlay() {
        const video = document.getElementById('virtual-tour-video');
        const overlay = document.getElementById('video-overlay');
        if (!video || !overlay) return;

        if (video.paused) {
            video.play();
        } else {
            video.pause();
        }
    }

    // Register video event listeners
    document.addEventListener('DOMContentLoaded', () => {
        const video = document.getElementById('virtual-tour-video');
        const overlay = document.getElementById('video-overlay');

        if (video && overlay) {
            video.muted = true;
            video.volume = 0;

            video.addEventListener('play', () => {
                video.muted = true;
                video.volume = 0;
                overlay.classList.add('opacity-0', 'pointer-events-none');
                video.setAttribute('controls', 'true');
            });

            video.addEventListener('volumechange', () => {
                if (!video.muted || video.volume > 0) {
                    video.muted = true;
                    video.volume = 0;
                }
            });

            video.addEventListener('pause', () => {
                overlay.classList.remove('opacity-0', 'pointer-events-none');
                video.removeAttribute('controls');
            });

            // Toggle play/pause by clicking on the video area directly
            video.addEventListener('click', () => {
                if (!video.paused) {
                    video.pause();
                }
            });
        }

        // GSAP ScrollTrigger Animations
        const checkGsap = setInterval(() => {
            if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
                clearInterval(checkGsap);
                initGSAPAnimations();
            }
        }, 50);

        function initGSAPAnimations() {
            // 1. Intro Section Header Animation
            gsap.from(".intro-header", {
                y: 50,
                opacity: 0,
                duration: 1.2,
                ease: "power3.out"
            });

            // 2. Intro Image Animation (scale & fade)
            gsap.from(".intro-image-wrapper", {
                scale: 0.85,
                opacity: 0,
                duration: 1.5,
                ease: "power2.out",
                scrollTrigger: {
                    trigger: ".intro-image-wrapper",
                    start: "top 85%",
                    toggleActions: "play none none none"
                }
            });

            // 3. Intro Quote Text Animation
            gsap.from(".intro-text-column", {
                x: 40,
                opacity: 0,
                duration: 1.2,
                ease: "power2.out",
                scrollTrigger: {
                    trigger: ".intro-text-column",
                    start: "top 85%",
                    toggleActions: "play none none none"
                }
            });

            // 4. Founder Section Text
            gsap.from(".founder-text-column", {
                x: -50,
                opacity: 0,
                duration: 1.2,
                ease: "power2.out",
                scrollTrigger: {
                    trigger: ".founder-text-column",
                    start: "top 80%",
                    toggleActions: "play none none none"
                }
            });

            // 5. Founder Section Image and Badge
            gsap.from(".founder-image-wrapper", {
                x: 50,
                opacity: 0,
                duration: 1.2,
                ease: "power2.out",
                scrollTrigger: {
                    trigger: ".founder-image-wrapper",
                    start: "top 80%",
                    toggleActions: "play none none none"
                }
            });

            // 6. Vision/Mission Tab Section Entrance
            gsap.from(".vision-tabs-container", {
                y: 30,
                opacity: 0,
                duration: 1,
                ease: "power2.out",
                scrollTrigger: {
                    trigger: ".vision-tabs-container",
                    start: "top 80%",
                    toggleActions: "play none none none"
                }
            });

            // 7. Achievement Metrics - Count Up Year (1953)
            gsap.from(".stat-counter-year", {
                textContent: 0,
                duration: 2,
                ease: "power1.out",
                snap: { textContent: 1 },
                scrollTrigger: {
                    trigger: ".stats-container",
                    start: "top 85%",
                    toggleActions: "play none none none"
                }
            });

            // 8. Achievement Metrics - Count Up Branches (16)
            gsap.from(".stat-counter-branches", {
                textContent: 0,
                duration: 2,
                ease: "power1.out",
                snap: { textContent: 1 },
                scrollTrigger: {
                    trigger: ".stats-container",
                    start: "top 85%",
                    toggleActions: "play none none none"
                }
            });

            // 9. Achievement Metrics - Staggered entrance for stat boxes
            gsap.from(".stat-box", {
                y: 30,
                opacity: 0,
                duration: 1,
                stagger: 0.2,
                ease: "power2.out",
                scrollTrigger: {
                    trigger: ".stats-container",
                    start: "top 85%",
                    toggleActions: "play none none none"
                }
            });

            // 10. Video Tour Animation
            gsap.from(".video-tour-container", {
                scale: 0.9,
                opacity: 0,
                duration: 1.2,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: ".video-tour-container",
                    start: "top 80%",
                    toggleActions: "play none none none"
                }
            });

            // 11. CTA Section Animations
            gsap.from(".cta-section-anim", {
                y: 40,
                opacity: 0,
                duration: 1.2,
                ease: "power2.out",
                scrollTrigger: {
                    trigger: ".cta-section-anim",
                    start: "top 80%",
                    toggleActions: "play none none none"
                }
            });
        }
    });
</script>
@endpush