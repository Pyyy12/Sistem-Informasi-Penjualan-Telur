@extends('layouts.app')
@section('title', 'Penjualan')
@section('top_heading', 'Riwayat Penjualan')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4"><div><h1 class="page-title">Riwayat Penjualan</h1><div class="page-subtitle">Lihat dan periksa transaksi yang pernah dilakukan.</div></div><a href="{{ route('sales.create') }}" class="btn btn-green rounded-3 px-3 py-2"><i class="bi bi-plus-lg me-2"></i>Transaksi Baru</a></div>
<div class="card-clean p-3 p-md-4"><div class="table-responsive"><table class="table mb-0">
<thead><tr><th>Invoice</th><th>Pelanggan</th><th>Tanggal</th><th>Item</th><th>Pembayaran</th><th>Total</th><th></th></tr></thead>
<tbody>
@forelse($sales as $sale)
<tr><td class="fw-bold text-success">{{ $sale->invoice_number }}</td><td>{{ $sale->customer_name }}</td><td class="text-nowrap">{{ $sale->sold_at->format('d/m/Y H:i') }}</td><td>{{ $sale->items->sum('quantity') }} unit</td><td><span class="badge badge-soft">{{ $sale->payment_method }}</span></td><td class="fw-bold text-nowrap">Rp {{ number_format($sale->total,0,',','.') }}</td><td><a href="{{ route('sales.show',$sale) }}" class="btn btn-sm btn-light border">Detail</a></td></tr>
@empty<tr><td colspan="7" class="text-center text-secondary py-5">Belum ada transaksi.</td></tr>@endforelse
</tbody></table></div><div class="mt-3">{{ $sales->links() }}</div></div>
@endsection