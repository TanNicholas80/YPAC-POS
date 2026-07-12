@extends('layouts.app')

@section('title', 'Pembayaran QRIS - SIKAS YPAC')

@section('content')
<div class="flex-1 flex flex-col p-6 overflow-y-auto bg-[#F5F8FC]">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('sales.index') }}" class="flex items-center gap-2 text-[#0073E2] hover:text-blue-600 transition-colors font-bold text-sm">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
            <span class="text-lg">Pembayaran QRIS</span>
        </a>
    </div>

    <!-- Inner Card container -->
    <div class="max-w-md w-full mx-auto bg-white border border-gray-100 rounded-3xl p-8 shadow-sm flex flex-col items-center">
        
        <h2 class="text-xl font-bold text-gray-900 text-center mb-1">Pembayaran QRIS</h2>
        <span class="text-xs text-gray-400 font-semibold mb-3 uppercase tracking-wider block text-center">SIKAS YPAC</span>
        
        <span class="text-3xl font-extrabold text-[#0073E2] mb-6 block text-center">
            Rp {{ number_format($total, 0, ',', '.') }}
        </span>

        <!-- Tab Selection Navigation -->
        <div class="w-full flex border-b border-gray-100 mb-6">
            <button type="button" onclick="switchTab('scan')" id="tab-btn-scan"
                class="flex-1 pb-3 text-sm font-bold text-[#0073E2] border-b-2 border-[#0073E2] transition-all cursor-pointer">
                Scan QRIS
            </button>
            <button type="button" onclick="switchTab('screenshot')" id="tab-btn-screenshot"
                class="flex-1 pb-3 text-sm font-bold text-gray-400 border-b-2 border-transparent hover:text-gray-600 transition-all cursor-pointer">
                Bukti Screenshot
            </button>
        </div>

        <!-- Checkout Form -->
        <form action="{{ route('sales.checkout') }}" method="POST" enctype="multipart/form-data" id="qris-checkout-form" class="w-full space-y-6 flex flex-col items-center">
            @csrf
            
            <!-- Tab Content 1: Scan QRIS -->
            <div id="tab-content-scan" class="w-full flex flex-col items-center space-y-6">
                <!-- SVG QR Code visualization -->
                <div class="p-4 border border-gray-100 bg-white rounded-2xl flex flex-col items-center shadow-inner">
                    <svg width="180" height="180" viewBox="0 0 100 100" class="text-gray-900">
                        <rect width="100" height="100" fill="#ffffff"/>
                        <!-- Outline boxes (QR pattern style) -->
                        <rect x="5" y="5" width="20" height="20" fill="none" stroke="currentColor" stroke-width="4"/>
                        <rect x="10" y="10" width="10" height="10" fill="currentColor"/>
                        <rect x="75" y="5" width="20" height="20" fill="none" stroke="currentColor" stroke-width="4"/>
                        <rect x="80" y="10" width="10" height="10" fill="currentColor"/>
                        <rect x="5" y="75" width="20" height="20" fill="none" stroke="currentColor" stroke-width="4"/>
                        <rect x="10" y="80" width="10" height="10" fill="currentColor"/>
                        <!-- Random QR dots -->
                        <rect x="35" y="15" width="6" height="6" fill="currentColor"/>
                        <rect x="50" y="10" width="6" height="6" fill="currentColor"/>
                        <rect x="40" y="30" width="12" height="6" fill="currentColor"/>
                        <rect x="15" y="45" width="6" height="12" fill="currentColor"/>
                        <rect x="30" y="50" width="6" height="6" fill="currentColor"/>
                        <rect x="55" y="45" width="18" height="6" fill="currentColor"/>
                        <rect x="45" y="60" width="6" height="18" fill="currentColor"/>
                        <rect x="75" y="40" width="12" height="12" fill="currentColor"/>
                        <rect x="80" y="65" width="12" height="6" fill="currentColor"/>
                        <rect x="85" y="80" width="10" height="10" fill="currentColor"/>
                        <rect x="45" y="85" width="6" height="6" fill="currentColor"/>
                        <rect x="60" y="75" width="6" height="12" fill="currentColor"/>
                    </svg>
                    <span class="text-[10px] text-gray-400 font-bold tracking-widest mt-2 uppercase">NMID : ID1234567890</span>
                </div>
                
                <p class="text-xs text-gray-500 text-center leading-relaxed max-w-xs">
                    Silakan scan kode QR untuk membayar
                </p>
            </div>

            <!-- Tab Content 2: Bukti Screenshot / Kamera -->
            <div id="tab-content-screenshot" class="w-full hidden flex flex-col items-center space-y-4">
                <!-- Image Upload Zone -->
                <div id="qris-drop-zone" class="w-full aspect-video border-2 border-dashed border-gray-200 rounded-2xl flex flex-col items-center justify-center p-4 text-center relative overflow-hidden bg-gray-50/50 transition-all">
                    <div id="upload-placeholder" class="space-y-2 flex flex-col items-center">
                        <i data-lucide="image-up" class="w-10 h-10 text-gray-400"></i>
                        <span class="text-xs font-bold text-gray-505 block">Belum ada bukti pembayaran</span>
                        <span class="text-[10px] text-gray-400">Pilih berkas, ambil foto, atau seret & jatuhkan gambar disini</span>
                    </div>

                    <!-- Image Preview -->
                    <img id="image-preview" src="#" alt="Preview Bukti" class="absolute inset-0 w-full h-full object-contain p-2 hidden bg-white">
                </div>

                <!-- Input Buttons -->
                <div class="w-full flex gap-3">
                    <button type="button" onclick="document.getElementById('payment_proof_file').click()" class="flex-1 py-3 bg-gray-50 border border-gray-150 hover:bg-gray-100 text-gray-700 font-bold rounded-2xl text-xs flex items-center justify-center gap-2 transition-colors cursor-pointer">
                        <i data-lucide="image" class="w-4 h-4 text-gray-500"></i>
                        <span>Upload File</span>
                    </button>
                    <button type="button" onclick="startCamera()" class="flex-1 py-3 bg-gray-50 border border-gray-150 hover:bg-gray-100 text-gray-700 font-bold rounded-2xl text-xs flex items-center justify-center gap-2 transition-colors cursor-pointer">
                        <i data-lucide="camera" class="w-4 h-4 text-gray-500"></i>
                        <span>Ambil Foto</span>
                    </button>
                </div>

                <!-- Hidden file input -->
                <input type="file" name="payment_proof" id="payment_proof_file" accept="image/*" class="hidden" onchange="handleImageSelect(this)">
                
                <p class="text-xs text-gray-500 text-center leading-relaxed max-w-xs">
                    Unggah tangkapan layar (screenshot), ambil foto langsung, atau seret file gambar ke kotak di atas.
                </p>
            </div>

            <!-- Action Submit Button (Hidden in Scan tab by default) -->
            <button type="submit" id="btn-submit-qris" style="display: none;"
                class="w-full py-4 bg-gray-200 text-gray-400 font-bold rounded-2xl shadow-none cursor-not-allowed transition-all flex items-center justify-center gap-2 text-base pointer-events-none">
                <i data-lucide="alert-circle" class="w-5 h-5" id="submit-btn-icon"></i>
                <span id="submit-btn-text">Upload Bukti untuk Melanjutkan</span>
            </button>
        </form>
    </div>
</div>

<!-- CAMERA STREAM MODAL -->
<div id="camera-modal" class="fixed inset-0 z-50 bg-black/85 backdrop-blur-xs flex flex-col items-center justify-center p-4 hidden" onclick="event.target.id === 'camera-modal' ? stopCamera() : null">
    <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden flex flex-col transform transition-all duration-300">
        <!-- Modal Header -->
        <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <div>
                <h3 class="text-base font-black text-gray-900">Kamera Pengambil Bukti</h3>
                <span class="text-xs text-gray-400 font-bold block mt-0.5">Posisikan bukti pembayaran di dalam kamera</span>
            </div>
            <button type="button" onclick="stopCamera()" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Video stream -->
        <div class="p-5 bg-black flex items-center justify-center relative aspect-video w-full">
            <video id="camera-feed" autoplay playsinline class="w-full h-full object-cover rounded-2xl"></video>
            <canvas id="camera-canvas" class="hidden"></canvas>
            
            <!-- Switch Camera overlay button -->
            <button type="button" onclick="toggleCameraFacing()" class="absolute bottom-8 right-8 p-3.5 bg-white/20 hover:bg-white/35 backdrop-blur-md rounded-full text-white transition-all cursor-pointer" title="Putar Kamera">
                <i data-lucide="switch-camera" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Modal Footer -->
        <div class="p-5 border-t border-gray-100 flex items-center justify-between bg-gray-50/50 gap-3">
            <button type="button" onclick="stopCamera()" class="px-5 py-3 bg-gray-200 hover:bg-gray-300 text-gray-750 font-bold text-xs rounded-xl transition-colors cursor-pointer">
                Batal
            </button>
            <button type="button" onclick="capturePhoto()" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold text-xs rounded-xl shadow-md transition-colors flex items-center gap-2 cursor-pointer">
                <i data-lucide="camera" class="w-4 h-4"></i>
                <span>Ambil Foto</span>
            </button>
        </div>
    </div>
</div>

<script>
    let activeTab = 'scan';
    let cameraStream = null;
    let currentFacingMode = 'environment'; // default to back camera

    // Initialize drag and drop on load
    document.addEventListener("DOMContentLoaded", () => {
        const dropZone = document.getElementById('qris-drop-zone');
        if (dropZone) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, e => {
                    e.preventDefault();
                    e.stopPropagation();
                }, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => {
                    dropZone.classList.add('border-[#0073E2]', 'bg-blue-50/20');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => {
                    dropZone.classList.remove('border-[#0073E2]', 'bg-blue-50/20');
                }, false);
            });

            dropZone.addEventListener('drop', e => {
                const dt = e.dataTransfer;
                const files = dt.files;
                const fileInput = document.getElementById('payment_proof_file');
                
                if (files && files.length > 0) {
                    fileInput.files = files;
                    handleImageSelect(fileInput);
                }
            }, false);
        }
    });

    function switchTab(tab) {
        activeTab = tab;

        const btnScan = document.getElementById('tab-btn-scan');
        const btnScreenshot = document.getElementById('tab-btn-screenshot');
        const contentScan = document.getElementById('tab-content-scan');
        const contentScreenshot = document.getElementById('tab-content-screenshot');
        const btnSubmit = document.getElementById('btn-submit-qris');

        if (tab === 'scan') {
            btnScan.className = "flex-1 pb-3 text-sm font-bold text-[#0073E2] border-b-2 border-[#0073E2] transition-all cursor-pointer";
            btnScreenshot.className = "flex-1 pb-3 text-sm font-bold text-gray-400 border-b-2 border-transparent hover:text-gray-600 transition-all cursor-pointer";
            
            contentScan.style.display = 'flex';
            contentScreenshot.style.display = 'none';

            // Hide the submit button on the scan tab
            btnSubmit.style.display = 'none';
            stopCamera();
        } else {
            btnScreenshot.className = "flex-1 pb-3 text-sm font-bold text-[#0073E2] border-b-2 border-[#0073E2] transition-all cursor-pointer";
            btnScan.className = "flex-1 pb-3 text-sm font-bold text-gray-400 border-b-2 border-transparent hover:text-gray-600 transition-all cursor-pointer";
            
            contentScreenshot.style.display = 'flex';
            contentScan.style.display = 'none';

            // Show submit button and set its state
            btnSubmit.style.display = 'flex';
            checkFileUploadedState();
        }
        lucide.createIcons();
    }

    // Camera Access Functions
    function startCamera() {
        const video = document.getElementById('camera-feed');
        const constraints = {
            video: {
                facingMode: currentFacingMode
            },
            audio: false
        };
        
        navigator.mediaDevices.getUserMedia(constraints)
            .then(s => {
                cameraStream = s;
                video.srcObject = cameraStream;
                video.play();
                document.getElementById('camera-modal').classList.remove('hidden');
                lucide.createIcons();
            })
            .catch(err => {
                Swal.fire({
                    title: 'Akses Kamera Gagal',
                    text: 'Gagal mengakses kamera perangkat. Pastikan izin kamera telah diberikan atau coba gunakan opsi Upload File.',
                    icon: 'error',
                    confirmButtonColor: '#0073E2',
                    customClass: { popup: 'rounded-3xl' }
                });
            });
    }

    function stopCamera() {
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
            cameraStream = null;
        }
        document.getElementById('camera-modal').classList.add('hidden');
    }

    function toggleCameraFacing() {
        currentFacingMode = (currentFacingMode === 'environment') ? 'user' : 'environment';
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
            startCamera();
        }
    }

    function capturePhoto() {
        const video = document.getElementById('camera-feed');
        const canvas = document.getElementById('camera-canvas');
        const context = canvas.getContext('2d');
        
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        canvas.toBlob(blob => {
            const file = new File([blob], "qris_camera_capture.png", { type: "image/png" });
            const dt = new DataTransfer();
            dt.items.add(file);
            
            const fileInput = document.getElementById('payment_proof_file');
            fileInput.files = dt.files;
            
            handleImageSelect(fileInput);
            stopCamera();
        }, 'image/png');
    }

    // Handle File select
    function handleImageSelect(input) {
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('upload-placeholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                
                checkFileUploadedState();
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Toggle button state on Tab 2 based on file existence
    function checkFileUploadedState() {
        const fileInput = document.getElementById('payment_proof_file');
        const btnSubmit = document.getElementById('btn-submit-qris');
        const submitIcon = document.getElementById('submit-btn-icon');
        const submitText = document.getElementById('submit-btn-text');

        const hasFile = fileInput.files && fileInput.files[0];

        if (hasFile) {
            submitIcon.className = "w-5 h-5";
            submitIcon.setAttribute('data-lucide', 'check-circle');
            submitText.innerText = "Konfirmasi Pembayaran";
            btnSubmit.className = "w-full py-4 bg-green-600 hover:bg-green-700 active:scale-[0.98] text-white font-bold rounded-2xl shadow-lg shadow-green-150 transition-all flex items-center justify-center gap-2 text-base cursor-pointer pointer-events-auto";
        } else {
            submitIcon.className = "w-5 h-5";
            submitIcon.setAttribute('data-lucide', 'alert-circle');
            submitText.innerText = "Upload Bukti untuk Melanjutkan";
            btnSubmit.className = "w-full py-4 bg-gray-200 text-gray-400 font-bold rounded-2xl shadow-none cursor-not-allowed transition-all flex items-center justify-center gap-2 text-base pointer-events-none";
        }
        lucide.createIcons();
    }

    // Prevent submission on Tab 2 if file is not selected
    document.getElementById('qris-checkout-form').addEventListener('submit', function(e) {
        if (activeTab === 'scan') {
            e.preventDefault();
            Swal.fire({
                title: 'Bukti Pembayaran Diperlukan',
                text: 'Silakan pindah ke tab Bukti Screenshot dan unggah/foto bukti pembayaran terlebih dahulu.',
                icon: 'warning',
                confirmButtonColor: '#0073E2',
                customClass: { popup: 'rounded-3xl' }
            });
        } else {
            const fileInput = document.getElementById('payment_proof_file');
            const hasFile = fileInput.files && fileInput.files[0];
            if (!hasFile) {
                e.preventDefault();
                Swal.fire({
                    title: 'Bukti Pembayaran Diperlukan',
                    text: 'Silakan unggah atau ambil foto bukti screenshot pembayaran QRIS terlebih dahulu.',
                    icon: 'warning',
                    confirmButtonColor: '#0073E2',
                    customClass: { popup: 'rounded-3xl' }
                });
            }
        }
    });
</script>
@endsection
