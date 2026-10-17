@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('top_heading', 'Detail Transaksi')
@section('content')
<div class="d-flex justify-content-between align-items-end gap-3 flex-wrap mb-4 no-print"><div><a href="{{ route('sales.index') }}" class="text-success text-decoration-none small fw-bold"><i class="bi bi-arrow-left me-1"></i>Kembali</a><h1 class="page-title mt-2">Detail Transaksi</h1></div><button onclick="window.print()" class="btn btn-light border rounded-3"><i class="bi bi-printer me-2"></i>Cetak Invoice</button></div>
<div class="card-clean p-3 p-md-5">
    <div class="d-flex justify-content-between flex-wrap gap-3 border-bottom pb-4 mb-4"><div><div class="text-success fw-bold fs-4"><i class="bi bi-egg-fried me-2"></i>EggStore</div><div class="text-secondary small">Invoice Penjualan Telur</div></div><div class="text-md-end"><div class="text-secondary small">Nomor Invoice</div><div class="fw-bold fs-5">{{ $sale->invoice_number }}</div><div class="small text-secondary">{{ $sale->sold_at->format('d/m/Y H:i') }}</div></div></div>
    <div class="row g-3 mb-4"><div class="col-12 col-md-6"><div class="small text-secondary">Pelanggan</div><div class="fw-bold">{{ $sale->customer_name }}</div></div><div class="col-12 col-md-6"><div class="small text-secondary">Metode pembayaran</div><div class="fw-bold">{{ $sale->payment_method }} · {{ $sale->payment_status }}</div></div></div>
    <div class="table-responsive"><table class="table"><thead><tr><th>Produk</th><th>Harga</th><th>Jumlah</th><th class="text-end">Subtotal</th></tr></thead><tbody>
    @foreach($sale->items as $item)<tr><td>{{ $item->product_name }}</td><td>Rp {{ number_format($item->unit_price,0,',','.') }}</td><td>{{ $item->quantity }}</td><td class="text-end">Rp {{ number_format($item->line_total,0,',','.') }}</td></tr>@endforeach
    </tbody></table></div>
    <div class="row justify-content-end"><div class="col-12 col-md-6 col-lg-5"><div class="d-flex justify-content-between py-2"><span class="text-secondary">Subtotal</span><span>Rp {{ number_format($sale->subtotal,0,',','.') }}</span></div><div class="d-flex justify-content-between py-2"><span class="text-secondary">Diskon</span><span>Rp {{ number_format($sale->discount,0,',','.') }}</span></div><div class="d-flex justify-content-between border-top pt-3 mt-2"><strong>Total</strong><strong class="text-success fs-4">Rp {{ number_format($sale->total,0,',','.') }}</strong></div></div></div>
    @if($sale->notes)<div class="mt-4 small"><strong>Catatan:</strong> {{ $sale->notes }}</div>@endif
    <div class="text-center text-secondary small mt-5">Terima kasih telah berbelanja di EggStore.</div>
</div>
@endsection