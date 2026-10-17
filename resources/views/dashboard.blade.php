@extends('layouts.app')
@section('title', 'Dashboard')
@section('top_heading', 'Dashboard Penjualan')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
    <div><h1 class="page-title">Dashboard Penjualan</h1><div class="page-subtitle">Pantau performa penjualan telur tokomu hari ini.</div></div>
    <a href="{{ route('sales.create') }}" class="btn btn-green rounded-3 px-3 py-2"><i class="bi bi-plus-lg me-2"></i>Transaksi Baru</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3"><div class="card-clean stat-card"><div class="d-flex justify-content-between align-items-center"><span class="stat-label">Omzet Hari Ini</span><span class="stat-icon"><i class="bi bi-wallet2"></i></span></div><div class="stat-value">Rp {{ number_format($todayRevenue,0,',','.') }}</div><div class="small text-secondary mt-2">Total transaksi hari ini</div></div></div>
    <div class="col-12 col-sm-6 col-xl-3"><div class="card-clean stat-card"><div class="d-flex justify-content-between align-items-center"><span class="stat-label">Transaksi Hari Ini</span><span class="stat-icon"><i class="bi bi-receipt"></i></span></div><div class="stat-value">{{ number_format($todayTransactions,0,',','.') }}</div><div class="small text-secondary mt-2">Nota penjualan tercatat</div></div></div>
    <div class="col-12 col-sm-6 col-xl-3"><div class="card-clean stat-card"><div class="d-flex justify-content-between align-items-center"><span class="stat-label">Telur Terjual Hari Ini</span><span class="stat-icon"><i class="bi bi-egg"></i></span></div><div class="stat-value">{{ number_format($eggsSoldToday,0,',','.') }}</div><div class="small text-secondary mt-2">Dalam unit penjualan</div></div></div>
    <div class="col-12 col-sm-6 col-xl-3"><div class="card-clean stat-card"><div class="d-flex justify-content-between align-items-center"><span class="stat-label">Produk & Stok Menipis</span><span class="stat-icon"><i class="bi bi-box-seam"></i></span></div><div class="stat-value">{{ $stockProducts }} <span class="fs-6 text-secondary fw-semibold">produk</span></div><div class="small {{ $lowStockCount ? 'text-danger' : 'text-success' }} mt-2">{{ $lowStockCount }} produk perlu restock</div></div></div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-xl-8">
        <div class="card-clean p-3 p-md-4 h-100">
            <div class="d-flex flex-wrap justify-content-between gap-2 mb-3"><div><h2 class="section-heading">Grafik Penjualan</h2><div class="small text-secondary mt-1">Omzet selama 7 hari terakhir</div></div><span class="badge badge-soft rounded-pill align-self-start px-3 py-2">7 Hari</span></div>
            <div style="height:300px;position:relative"><canvas id="salesChart" aria-label="Grafik omzet penjualan tujuh hari terakhir"></canvas></div>
        </div>
    </div>
    <div class="col-12 col-xl-4">
        <div class="card-clean p-3 p-md-4 h-100">
            <h2 class="section-heading">Produk Stok Menipis</h2><div class="small text-secondary mt-1 mb-3">Periksa produk yang mendekati batas minimum.</div>
            @forelse($lowStockProducts as $product)
                <div class="d-flex align-items-center gap-3 py-3 border-bottom">
                    <div class="stat-icon flex-shrink-0"><i class="bi bi-egg-fried"></i></div>
                    <div class="flex-grow-1 min-w-0"><div class="fw-bold text-truncate">{{ $product->name }}</div><div class="small text-secondary">Min. stok {{ $product->minimum_stock }} {{ $product->unit }}</div></div>
                    <span class="badge text-bg-warning">{{ $product->stock }} {{ $product->unit }}</span>
                </div>
            @empty
                <div class="text-center text-secondary py-5"><i class="bi bi-check-circle fs-2 text-success"></i><p class="mb-0 mt-2">Semua stok aman.</p></div>
            @endforelse
            <a href="{{ route('products.index') }}" class="btn btn-light border rounded-3 w-100 mt-3">Kelola Produk <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-xl-8">
        <div class="card-clean p-3 p-md-4">
            <div class="d-flex justify-content-between align-items-center mb-3"><h2 class="section-heading">Transaksi Terbaru</h2><a href="{{ route('sales.index') }}" class="small text-success text-decoration-none fw-bold">Lihat semua</a></div>
            <div class="table-responsive"><table class="table mb-0">
                <thead><tr><th>No. Invoice</th><th>Pelanggan</th><th>Tanggal</th><th>Total</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($recentSales as $sale)
                    <tr><td><a class="fw-bold text-success text-decoration-none" href="{{ route('sales.show',$sale) }}">{{ $sale->invoice_number }}</a></td><td>{{ $sale->customer_name }}</td><td class="text-nowrap">{{ $sale->sold_at->format('d/m/Y H:i') }}</td><td class="fw-bold text-nowrap">Rp {{ number_format($sale->total,0,',','.') }}</td><td><span class="badge badge-soft">{{ $sale->payment_status }}</span></td></tr>
                @empty
                    <tr><td colspan="5" class="text-center text-secondary py-4">Belum ada transaksi penjualan.</td></tr>
                @endforelse
                </tbody>
            </table></div>
        </div>
    </div>
    <div class="col-12 col-xl-4">
        <div class="card-clean p-3 p-md-4 h-100">
            <h2 class="section-heading">Ringkasan Bulan Ini</h2><div class="small text-secondary mt-1">Akumulasi omzet bulan berjalan</div>
            <div class="stat-value text-success mt-4">Rp {{ number_format($monthRevenue,0,',','.') }}</div>
            <div class="progress mt-3" style="height:8px"><div class="progress-bar" style="width:100%;background:#16794b"></div></div>
            <div class="d-flex justify-content-between small text-secondary mt-2"><span>Bulan {{ now()->translatedFormat('F') }}</span><span>{{ now()->format('Y') }}</span></div>
            <a href="{{ route('reports.index') }}" class="btn btn-light border rounded-3 w-100 mt-4">Buka Laporan <i class="bi bi-arrow-up-right ms-1"></i></a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('salesChart');
    if (!canvas) return;
    const labels = @json($chartLabels);
    const revenue = @json($chartRevenue);
    const quantities = @json($chartQuantities);
    new Chart(canvas, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Omzet (Rp)', data: revenue, yAxisID: 'y',
                borderColor: '#16834f', backgroundColor: 'rgba(22,131,79,.12)',
                borderWidth: 3, fill: true, tension: .38,
                pointRadius: 4, pointHoverRadius: 6, pointBackgroundColor: '#16834f'
            }, {
                label: 'Jumlah unit terjual', data: quantities, yAxisID: 'y1',
                borderColor: '#e5a43b', backgroundColor: '#e5a43b',
                borderWidth: 2, tension: .35, pointRadius: 3, borderDash: [5, 4]
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8, padding: 18 } },
                tooltip: { callbacks: { label: function(ctx) {
                    return ctx.dataset.yAxisID === 'y'
                        ? ctx.dataset.label + ': Rp ' + Number(ctx.raw).toLocaleString('id-ID')
                        : ctx.dataset.label + ': ' + Number(ctx.raw).toLocaleString('id-ID');
                }}}
            },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, position: 'left', ticks: { callback: value => 'Rp ' + Number(value).toLocaleString('id-ID') } },
                y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false }, ticks: { precision: 0 } }
            }
        }
    });
});
</script>
@endpush