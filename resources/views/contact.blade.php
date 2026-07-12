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
        });
    </script>
@endpush