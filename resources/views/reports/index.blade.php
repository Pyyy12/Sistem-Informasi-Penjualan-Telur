@extends('layouts.app')
@section('title', 'Laporan Penjualan')
@section('top_heading', 'Laporan Penjualan')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4"><div><h1 class="page-title">Laporan Penjualan</h1><div class="page-subtitle">Filter transaksi berdasarkan periode dan cetak laporan.</div></div><button onclick="window.print()" class="btn btn-light border rounded-3 no-print"><i class="bi bi-printer me-2"></i>Cetak Laporan</button></div>
<div class="card-clean p-3 p-md-4 mb-3 no-print">
<form method="GET" class="row g-3 align-items-end">
    <div class="col-12 col-md-4"><label class="form-label fw-semibold">Dari tanggal</label><input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}"></div>
    <div class="col-12 col-md-4"><label class="form-label fw-semibold">Sampai tanggal</label><input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}"></div>
    <div class="col-6 col-md-2"><button class="btn btn-green w-100 rounded-3">Terapkan</button></div>
    <div class="col-6 col-md-2"><a href="{{ route('reports.index') }}" class="btn btn-light border w-100 rounded-3">Reset</a></div>
</form>
</div>
<div class="row g-3 mb-3"><div class="col-12 col-md-6"><div class="card-clean stat-card"><div class="stat-label">Total omzet sesuai filter</div><div class="stat-value text-success">Rp {{ number_format($totalRevenue,0,',','.') }}</div></div></div><div class="col-12 col-md-6"><div class="card-clean stat-card"><div class="stat-label">Jumlah transaksi sesuai filter</div><div class="stat-value">{{ number_format($totalTransactions,0,',','.') }}</div></div></div></div>
<div class="card-clean p-3 p-md-4"><div class="table-responsive"><table class="table"><thead><tr><th>Tanggal</th><th>Invoice</th><th>Pelanggan</th><th>Jumlah Unit</th><th>Total</th></tr></thead><tbody>
@forelse($sales as $sale)<tr><td class="text-nowrap">{{ $sale->sold_at->format('d/m/Y H:i') }}</td><td>{{ $sale->invoice_number }}</td><td>{{ $sale->customer_name }}</td><td>{{ $sale->items->sum('quantity') }}</td><td class="fw-bold text-nowrap">Rp {{ number_format($sale->total,0,',','.') }}</td></tr>
@empty<tr><td colspan="5" class="text-center text-secondary py-4">Tidak ada transaksi pada periode ini.</td></tr>@endforelse
</tbody></table></div><div class="mt-3">{{ $sales->links() }}</div></div>
@endsection