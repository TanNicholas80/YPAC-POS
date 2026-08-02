@extends('layouts.app')

@section('title', 'Tracking Status Transaksi WA - SIKAS YPAC')

@section('content')
    <div class="flex-1 p-6 md:p-8 space-y-6 relative pb-28">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-gray-400 font-bold uppercase tracking-wider mb-1.5">
                    <a href="{{ route('dashboard') }}" class="hover:text-[#0073E2]">Dashboard</a>
                    <span>/</span>
                    <span class="text-gray-500">Tracking Transaksi WA</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Tracking Status Transaksi WA</h1>
                <p class="text-gray-500 text-sm mt-0.5">Pantau bukti pembayaran pelanggan, perbarui status pengiriman secara individu / masal, dan follow-up WhatsApp.</p>
            </div>
        </div>

        @if(session('success'))
            <!-- Alert Success -->
            <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl flex items-center gap-3 font-semibold text-sm shadow-sm animate-fade-in">
                <i data-lucide="check-circle" class="w-5 h-5 text-green-600 flex-shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <!-- Alert Errors -->
            <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl flex flex-col gap-1 font-semibold text-sm shadow-sm">
                @foreach ($errors->all() as $error)
                    <div class="flex items-center gap-3">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Filter Tabs & Search -->
        <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 pb-4">
                <!-- Delivery Status Tabs -->
                <div class="flex flex-wrap items-center bg-gray-50 p-1.5 rounded-2xl border border-gray-200/60 gap-1">
                    <a href="{{ route('admin.approvals.index', ['delivery_status' => 'all', 'search' => request('search')]) }}" 
                       class="px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all {{ $deliveryStatus === 'all' ? 'bg-white text-gray-900 shadow-xs' : 'text-gray-500 hover:text-gray-800' }}">
                        Semua
                    </a>
                    <a href="{{ route('admin.approvals.index', ['delivery_status' => 'belum_dikirim', 'search' => request('search')]) }}" 
                       class="px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all flex items-center gap-1.5 {{ $deliveryStatus === 'belum_dikirim' ? 'bg-white text-amber-600 shadow-xs' : 'text-gray-500 hover:text-gray-800' }}">
                        <span>Belum Dikirim</span>
                        @php
                            $bCount = \App\Models\Transaction::where('is_whatsapp', true)->where('delivery_status', 'belum_dikirim')->count();
                        @endphp
                        @if($bCount > 0)
                            <span class="bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full text-[10px] font-extrabold">{{ $bCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.approvals.index', ['delivery_status' => 'sedang_dikirim', 'search' => request('search')]) }}" 
                       class="px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all {{ $deliveryStatus === 'sedang_dikirim' ? 'bg-white text-blue-600 shadow-xs' : 'text-gray-500 hover:text-gray-800' }}">
                        Sedang Dikirim
                    </a>
                    <a href="{{ route('admin.approvals.index', ['delivery_status' => 'sudah_terkirim', 'search' => request('search')]) }}" 
                       class="px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all {{ $deliveryStatus === 'sudah_terkirim' ? 'bg-white text-green-600 shadow-xs' : 'text-gray-500 hover:text-gray-800' }}">
                        Sudah Terkirim
                    </a>
                </div>

                <!-- Search Form -->
                <form action="{{ route('admin.approvals.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
                    <input type="hidden" name="delivery_status" value="{{ $deliveryStatus }}">
                    <div class="relative w-full sm:w-64">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                            <i data-lucide="search" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pemesan / invoice..."
                            class="w-full pl-10 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-2xl text-xs focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-gray-800">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-[#0073E2] hover:bg-blue-600 text-white font-bold text-xs rounded-xl shadow-xs transition-colors cursor-pointer">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.approvals.index', ['delivery_status' => $deliveryStatus]) }}" class="p-2 bg-gray-150 hover:bg-gray-200 text-gray-600 rounded-xl transition-colors" title="Reset">
                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                        </a>
                    @endif
                </form>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto -mx-6">
                <div class="inline-block min-w-full align-middle px-6">
                    <div class="overflow-hidden border border-gray-100 rounded-2xl">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50/75">
                                <tr>
                                    <th scope="col" class="py-4 px-4 text-center w-10">
                                        <input type="checkbox" id="select-all-trx" onchange="toggleSelectAll(this)" 
                                            class="w-4 h-4 text-[#0073E2] bg-white border-gray-300 rounded focus:ring-[#0073E2] cursor-pointer">
                                    </th>
                                    <th scope="col" class="py-4 px-6 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Invoice</th>
                                    <th scope="col" class="py-4 px-6 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pelanggan & Alamat</th>
                                    <th scope="col" class="py-4 px-6 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Metode Bayar</th>
                                    <th scope="col" class="py-4 px-6 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="py-4 px-6 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status Pengiriman</th>
                                    <th scope="col" class="py-4 px-6 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi & Follow-Up</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($transactions as $trx)
                                    @php
                                        $waUrl = \App\Http\Controllers\AdminApprovalController::generateWhatsAppUrl($trx);
                                    @endphp
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <!-- Checkbox -->
                                        <td class="py-4 px-4 text-center">
                                            <input type="checkbox" name="transaction_ids[]" value="{{ $trx->id }}" onchange="updateBulkBarState()"
                                                class="trx-checkbox w-4 h-4 text-[#0073E2] bg-white border-gray-300 rounded focus:ring-[#0073E2] cursor-pointer"
                                                data-invoice="{{ $trx->invoice_number }}"
                                                data-customer="{{ $trx->customer_name }}"
                                                data-phone="{{ $trx->customer_phone ?? '' }}"
                                                data-waurl="{{ $waUrl ?? '' }}">
                                        </td>
                                        <!-- Invoice -->
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            <span class="font-extrabold text-gray-900 text-sm tracking-tight block">{{ $trx->invoice_number }}</span>
                                            <span class="text-[10px] text-gray-400 font-semibold">{{ $trx->created_at->format('d/m/Y H:i') }}</span>
                                        </td>
                                        <!-- Customer -->
                                        <td class="py-4 px-6">
                                            <div class="max-w-[220px]">
                                                <p class="font-bold text-gray-900 text-sm truncate">{{ $trx->customer_name }}</p>
                                                @if($trx->customer_phone)
                                                    <p class="text-xs font-bold text-[#0073E2] flex items-center gap-1 mt-0.5">
                                                        <i data-lucide="phone" class="w-3 h-3"></i>
                                                        <span>{{ $trx->customer_phone }}</span>
                                                    </p>
                                                @endif
                                                <p class="text-xs text-gray-400 truncate mt-0.5" title="{{ $trx->customer_address }}">
                                                    {{ $trx->customer_address }}
                                                </p>
                                            </div>
                                        </td>
                                        <!-- Payment Method & Proof -->
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            <span class="text-xs font-extrabold text-gray-800 uppercase block">
                                                {{ $trx->payment_method === 'transfer_bank' ? 'Bank Jateng' : 'QRIS' }}
                                            </span>
                                            @if($trx->payment_proof)
                                                <span class="text-[10px] text-green-600 font-bold flex items-center gap-1 mt-0.5">
                                                    <i data-lucide="check" class="w-3 h-3"></i> Bukti Ada
                                                </span>
                                            @else
                                                <span class="text-[10px] text-gray-400 italic">Belum Upload</span>
                                            @endif
                                        </td>
                                        <!-- Total Payment -->
                                        <td class="py-4 px-6 whitespace-nowrap text-right">
                                            <span class="font-extrabold text-[#0073E2] text-sm">Rp {{ number_format($trx->total, 0, ',', '.') }}</span>
                                            <p class="text-[10px] text-gray-400 mt-0.5">Termasuk PPN 10%</p>
                                        </td>
                                        <!-- Delivery Status Select -->
                                        <td class="py-4 px-6 whitespace-nowrap text-center">
                                            <form action="{{ route('admin.approvals.delivery_status', $trx->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <select name="delivery_status" onchange="this.form.submit()" 
                                                    class="text-xs font-extrabold px-3 py-1.5 rounded-xl border transition-all cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#0073E2]
                                                    {{ $trx->delivery_status === 'belum_dikirim' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                                                    {{ $trx->delivery_status === 'sedang_dikirim' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                                    {{ $trx->delivery_status === 'sudah_terkirim' ? 'bg-green-50 text-green-700 border-green-200' : '' }}">
                                                    <option value="belum_dikirim" {{ $trx->delivery_status === 'belum_dikirim' ? 'selected' : '' }}>⏳ Belum Dikirim</option>
                                                    <option value="sedang_dikirim" {{ $trx->delivery_status === 'sedang_dikirim' ? 'selected' : '' }}>🚚 Sedang Dikirim</option>
                                                    <option value="sudah_terkirim" {{ $trx->delivery_status === 'sudah_terkirim' ? 'selected' : '' }}>✅ Sudah Terkirim</option>
                                                </select>
                                            </form>
                                        </td>
                                        <!-- Action Buttons -->
                                        <td class="py-4 px-6 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center gap-1.5">
                                                @if($waUrl)
                                                    <a href="{{ $waUrl }}" target="_blank" title="Chat Customer WhatsApp"
                                                        class="p-2 bg-green-50 hover:bg-green-600 text-green-700 hover:text-white border border-green-200 rounded-xl transition-all font-bold text-xs flex items-center gap-1 shadow-2xs">
                                                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                                                        <span class="hidden xl:inline">Chat WA</span>
                                                    </a>
                                                @endif
                                                <a href="{{ route('admin.approvals.show', $trx->id) }}" 
                                                   class="p-2 bg-[#0073E2] hover:bg-blue-600 text-white font-bold text-xs rounded-xl shadow-2xs transition-all flex items-center gap-1">
                                                    <span>Detail</span>
                                                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-12 px-6 text-center text-gray-400 font-medium">
                                            <div class="flex flex-col items-center justify-center space-y-3">
                                                <div class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-300">
                                                    <i data-lucide="inbox" class="w-7 h-7"></i>
                                                </div>
                                                <p class="text-sm">Tidak ada transaksi ditemukan.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pt-4">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>

    <!-- STICKY FLOATING BULK ACTION BAR -->
    <div id="bulk-action-bar" class="fixed bottom-6 inset-x-6 md:inset-x-auto md:left-1/2 md:-translate-x-1/2 z-40 hidden transition-all duration-300 transform translate-y-full">
        <div class="bg-gray-900/95 backdrop-blur-md text-white p-4 rounded-3xl shadow-2xl border border-gray-800 flex flex-wrap items-center justify-between gap-4 max-w-2xl w-full">
            <div class="flex items-center gap-3">
                <span class="bg-[#0073E2] text-white text-xs font-black px-3 py-1 rounded-full" id="bulk-selected-count">0</span>
                <span class="text-xs md:text-sm font-extrabold text-gray-200">Transaksi Dipilih</span>
            </div>

            <div class="flex items-center gap-2.5">
                <select id="bulk-delivery-status" 
                    class="bg-gray-800 text-white border border-gray-700 text-xs font-bold px-3 py-2 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0073E2] cursor-pointer">
                    <option value="belum_dikirim">⏳ Status: Belum Dikirim</option>
                    <option value="sedang_dikirim" selected>🚚 Status: Sedang Dikirim</option>
                    <option value="sudah_terkirim">✅ Status: Sudah Terkirim</option>
                </select>

                <button type="button" onclick="submitBulkUpdate()" 
                    class="px-4 py-2 bg-green-600 hover:bg-green-500 active:scale-[0.98] text-white font-extrabold text-xs rounded-xl shadow-lg transition-all flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    <span>Perbarui & Chat WA</span>
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL ANTREAN CHAT WA MASAL -->
    <div id="bulk-wa-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-xl w-full border border-gray-100 shadow-2xl relative my-8 space-y-6 animate-in fade-in zoom-in duration-200">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-2xl bg-green-50 flex items-center justify-center text-green-600">
                        <i data-lucide="message-square" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-900">Antrean Follow-Up WhatsApp</h3>
                        <p class="text-xs text-gray-500">Klik tombol hijau untuk mengirim pesan ke customer secara berurutan.</p>
                    </div>
                </div>
                <button type="button" onclick="closeBulkWaModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg transition-colors cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Queue Items List -->
            <div id="bulk-wa-queue-list" class="space-y-3 max-h-96 overflow-y-auto pr-1">
                <!-- Items populated dynamically via JS -->
            </div>

            <div class="border-t border-gray-100 pt-4 flex justify-end">
                <button type="button" onclick="closeBulkWaModal()" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition-colors cursor-pointer">
                    Tutup Antrean
                </button>
            </div>
        </div>
    </div>

    <script>
        // Checkbox Select All Handler
        function toggleSelectAll(masterCheckbox) {
            const checkboxes = document.querySelectorAll('.trx-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = masterCheckbox.checked;
            });
            updateBulkBarState();
        }

        // Toggle Floating Bulk Bar
        function updateBulkBarState() {
            const checkedCount = document.querySelectorAll('.trx-checkbox:checked').length;
            const bulkBar = document.getElementById('bulk-action-bar');
            const countBadge = document.getElementById('bulk-selected-count');
            const selectAllCb = document.getElementById('select-all-trx');

            countBadge.textContent = checkedCount;

            if (checkedCount > 0) {
                bulkBar.classList.remove('hidden', 'translate-y-full');
            } else {
                bulkBar.classList.add('translate-y-full');
                setTimeout(() => {
                    if (document.querySelectorAll('.trx-checkbox:checked').length === 0) {
                        bulkBar.classList.add('hidden');
                    }
                }, 300);
            }

            // Sync master select all checkbox state
            const totalCbs = document.querySelectorAll('.trx-checkbox').length;
            if (selectAllCb) {
                selectAllCb.checked = (totalCbs > 0 && checkedCount === totalCbs);
            }
        }

        // Submit Bulk Status Update AJAX
        function submitBulkUpdate() {
            const checkedCbs = Array.from(document.querySelectorAll('.trx-checkbox:checked'));
            const ids = checkedCbs.map(cb => cb.value);
            const deliveryStatus = document.getElementById('bulk-delivery-status').value;

            if (ids.length === 0) {
                Swal.fire({
                    title: 'Pilih Transaksi',
                    text: 'Centang minimal satu transaksi terlebih dahulu.',
                    icon: 'warning',
                    confirmButtonColor: '#0073E2',
                    customClass: { popup: 'rounded-3xl' }
                });
                return;
            }

            Swal.fire({
                title: `Update ${ids.length} Transaksi?`,
                text: 'Status pengiriman seluruh transaksi yang dipilih akan diperbarui di database.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Perbarui & Buka WA!',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-3xl' }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();

                    fetch("{{ route('admin.approvals.bulk_delivery_status') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            transaction_ids: ids,
                            delivery_status: deliveryStatus
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        Swal.close();
                        if (data.success) {
                            renderWaQueueModal(data.queue);
                        } else {
                            Swal.fire({
                                title: 'Gagal',
                                text: data.message || 'Terjadi kesalahan saat mengupdate transaksi.',
                                icon: 'error',
                                confirmButtonColor: '#0073E2',
                                customClass: { popup: 'rounded-3xl' }
                            });
                        }
                    })
                    .catch(err => {
                        Swal.close();
                        Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan koneksi server.',
                            icon: 'error',
                            confirmButtonColor: '#0073E2',
                            customClass: { popup: 'rounded-3xl' }
                        });
                    });
                }
            });
        }

        // Render & Open WA Queue Modal
        function renderWaQueueModal(queue) {
            const queueList = document.getElementById('bulk-wa-queue-list');
            queueList.innerHTML = '';

            queue.forEach((item, index) => {
                const el = document.createElement('div');
                el.className = 'p-4 bg-gray-50 border border-gray-150 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-3';
                
                let badgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
                let statusLabel = '⏳ Belum Dikirim';
                if (item.delivery_status === 'sedang_dikirim') {
                    badgeClass = 'bg-blue-50 text-blue-700 border-blue-200';
                    statusLabel = '🚚 Sedang Dikirim';
                } else if (item.delivery_status === 'sudah_terkirim') {
                    badgeClass = 'bg-green-50 text-green-700 border-green-200';
                    statusLabel = '✅ Sudah Terkirim';
                }

                el.innerHTML = `
                    <div class="space-y-0.5">
                        <div class="flex items-center gap-2">
                            <span class="font-extrabold text-gray-900 text-sm">${item.customer_name}</span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full border ${badgeClass}">${statusLabel}</span>
                        </div>
                        <p class="text-xs font-semibold text-gray-500">Invoice: <span class="font-bold text-gray-800">${item.invoice_number}</span></p>
                        <p class="text-xs text-[#0073E2] font-bold">WA: ${item.customer_phone || 'Tidak Ada Nomor'}</p>
                    </div>
                    <div>
                        ${item.whatsapp_url ? `
                            <a href="${item.whatsapp_url}" target="_blank" onclick="markWaSent(this)"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-extrabold text-xs rounded-xl shadow-xs transition-all flex items-center gap-1.5 cursor-pointer">
                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                                <span>Kirim Chat WA</span>
                            </a>
                        ` : `
                            <span class="text-xs text-gray-400 italic">No WA Tidak Ada</span>
                        `}
                    </div>
                `;
                queueList.appendChild(el);
            });

            if (window.lucide) lucide.createIcons();

            document.getElementById('bulk-wa-modal').classList.remove('hidden');
        }

        function markWaSent(btn) {
            btn.className = 'px-4 py-2 bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition-all flex items-center gap-1.5 cursor-default';
            btn.innerHTML = `<i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i> <span>Terkirim</span>`;
            if (window.lucide) lucide.createIcons();
        }

        function closeBulkWaModal() {
            document.getElementById('bulk-wa-modal').classList.add('hidden');
            window.location.reload();
        }
    </script>
@endsection
