@extends('layouts.app')
@section('title', 'Produk Telur')
@section('top_heading', 'Manajemen Produk')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
    <div><h1 class="page-title">Produk Telur</h1><div class="page-subtitle">Kelola katalog, harga, dan persediaan telur.</div></div>
    <a href="{{ route('products.create') }}" class="btn btn-green rounded-3 px-3 py-2"><i class="bi bi-plus-lg me-2"></i>Tambah Produk</a>
</div>
<div class="card-clean p-3 p-md-4">
    <form method="GET" class="row g-2 mb-3">
        <div class="col-12 col-md-8"><input class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari nama produk atau SKU..."></div>
        <div class="col-6 col-md-2"><button class="btn btn-light border w-100 rounded-3"><i class="bi bi-search me-1"></i> Cari</button></div>
        <div class="col-6 col-md-2"><a href="{{ route('products.index') }}" class="btn btn-light border w-100 rounded-3">Reset</a></div>
    </form>
    <div class="table-responsive"><table class="table">
        <thead><tr><th>Produk</th><th>SKU</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
        <tbody>
        @forelse($products as $product)
            <tr>
                <td><div class="fw-bold">{{ $product->name }}</div><div class="small text-secondary">{{ $product->unit }}</div></td>
                <td>{{ $product->sku }}</td><td>{{ $product->category }}</td>
                <td class="text-nowrap">Rp {{ number_format($product->price,0,',','.') }}</td>
                <td>{{ number_format($product->stock,0,',','.') }} {{ $product->unit }}</td>
                <td>@if($product->is_low_stock)<span class="badge text-bg-warning">Stok Menipis</span>@else<span class="badge badge-soft">Tersedia</span>@endif</td>
                <td class="text-end text-nowrap">
                    <a href="{{ route('products.edit',$product) }}" class="btn btn-sm btn-light border" title="Edit"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('products.destroy',$product) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                        @csrf @method('DELETE')<button class="btn btn-sm btn-light border text-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty<tr><td colspan="7" class="text-center text-secondary py-5">Belum ada produk. Tambahkan produk pertama.</td></tr>@endforelse
        </tbody>
    </table></div>
    <div class="mt-3">{{ $products->links() }}</div>
</div>
@endsection