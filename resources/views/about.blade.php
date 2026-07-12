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
            video.addEventListener('play', () => {
                overlay.classList.add('opacity-0', 'pointer-events-none');
                video.setAttribute('controls', 'true');
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
    });
</script>
@endpush