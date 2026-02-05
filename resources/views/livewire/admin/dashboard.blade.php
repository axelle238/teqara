<div>
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Card Pendapatan -->
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="truncate text-sm font-medium text-slate-500">Total Pendapatan</dt>
                            <dd>
                                <div class="text-lg font-bold text-slate-900">{{ 'Rp ' . number_format($totalPendapatan, 0, ',', '.') }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Pesanan Baru -->
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="truncate text-sm font-medium text-slate-500">Pesanan Perlu Proses</dt>
                            <dd>
                                <div class="text-lg font-bold text-slate-900">{{ $pesananBaru }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Stok Menipis -->
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="truncate text-sm font-medium text-slate-500">Produk Stok Menipis</dt>
                            <dd>
                                <div class="text-lg font-bold text-slate-900">{{ $stokMenipis }} Item</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Analitik -->
    <div class="mt-8 grid grid-cols-1 gap-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <h3 class="text-lg font-bold text-slate-900 mb-6">Tren Penjualan (7 Hari Terakhir)</h3>
            <div id="grafik-penjualan"></div>
        </div>
    </div>

    <!-- Tabel Pesanan Terbaru -->
    <div class="mt-8">
        <h3 class="text-lg font-bold leading-6 text-slate-900 mb-4">Aktivitas Pesanan Terbaru</h3>
        <div class="overflow-hidden rounded-xl shadow ring-1 ring-slate-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-slate-300">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6">Invoice</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Pelanggan</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Total</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Status</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @foreach($pesananTerbaru as $pesanan)
                    <tr>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-bold text-slate-900 sm:pl-6">
                            {{ $pesanan->nomor_invoice }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                            {{ $pesanan->pengguna->nama }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                            {{ 'Rp ' . number_format($pesanan->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                            <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $pesanan->status_pesanan === 'selesai' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ strtoupper($pesanan->status_pesanan) }}
                            </span>
                        </td>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <a href="/admin/pesanan/{{ $pesanan->id }}" wire:navigate class="text-cyan-600 hover:text-cyan-900">Kelola</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:navigated', () => {
            const options = {
                series: [{
                    name: 'Omzet Penjualan',
                    data: @json($dataTren)
                }],
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif'
                },
                colors: ['#0891b2'],
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                xaxis: {
                    categories: @json($labelTren),
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return "Rp " + value.toLocaleString('id-ID');
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (value) {
                            return "Rp " + value.toLocaleString('id-ID');
                        }
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#grafik-penjualan"), options);
            chart.render();
        });
    </script>
</div>