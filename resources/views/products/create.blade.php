@extends('layouts.app')
@php($isEdit = $product->exists)
@section('title', $isEdit ? 'Edit Produk' : 'Tambah Produk')
@section('top_heading', 'Form Produk')
@section('content')
<div class="mb-4"><a href="{{ route('products.index') }}" class="text-success text-decoration-none small fw-bold"><i class="bi bi-arrow-left me-1"></i>Kembali ke Produk</a><h1 class="page-title mt-2">{{ $isEdit ? 'Edit Produk' : 'Tambah Produk Baru' }}</h1><div class="page-subtitle">Lengkapi informasi produk dan stok telur.</div></div>
<form method="POST" action="{{ $isEdit ? route('products.update',$product) : route('products.store') }}">
    @csrf @if($isEdit) @method('PUT') @endif
    <div class="card-clean p-3 p-md-4">
        <div class="row g-3">
            <div class="col-12 col-md-6"><label class="form-label fw-semibold">Nama Produk *</label><input name="name" class="form-control" value="{{ old('name',$product->name) }}" required placeholder="Contoh: Telur Ayam Negeri"></div>
            <div class="col-12 col-md-6"><label class="form-label fw-semibold">SKU / Kode Produk *</label><input name="sku" class="form-control" value="{{ old('sku',$product->sku) }}" required placeholder="TEL-001"></div>
            <div class="col-12 col-md-6"><label class="form-label fw-semibold">Kategori *</label><select name="category" class="form-select" required>@foreach(['Telur Ayam','Telur Bebek','Telur Puyuh','Lainnya'] as $cat)<option value="{{ $cat }}" @selected(old('category',$product->category ?: 'Telur Ayam') === $cat)>{{ $cat }}</option>@endforeach</select></div>
            <div class="col-12 col-md-6"><label class="form-label fw-semibold">Satuan *</label><select name="unit" class="form-select" required>@foreach(['butir','kg','rak','peti'] as $unit)<option value="{{ $unit }}" @selected(old('unit',$product->unit ?: 'kg') === $unit)>{{ ucfirst($unit) }}</option>@endforeach</select></div>
            <div class="col-12 col-md-4"><label class="form-label fw-semibold">Harga per satuan (Rp) *</label><input type="number" name="price" class="form-control" min="0" step="0.01" value="{{ old('price',$product->price) }}" required></div>
            <div class="col-12 col-md-4"><label class="form-label fw-semibold">Stok tersedia *</label><input type="number" name="stock" class="form-control" min="0" value="{{ old('stock',$product->stock ?? 0) }}" required></div>
            <div class="col-12 col-md-4"><label class="form-label fw-semibold">Batas minimum stok *</label><input type="number" name="minimum_stock" class="form-control" min="0" value="{{ old('minimum_stock',$product->minimum_stock ?? 10) }}" required></div>
            <div class="col-12"><label class="form-label fw-semibold">Deskripsi</label><textarea name="description" rows="3" class="form-control" placeholder="Catatan tambahan (opsional)">{{ old('description',$product->description) }}</textarea></div>
        </div>
        <div class="d-flex flex-wrap justify-content-end gap-2 mt-4"><a href="{{ route('products.index') }}" class="btn btn-light border rounded-3 px-4">Batal</a><button class="btn btn-green rounded-3 px-4"><i class="bi bi-check2 me-1"></i>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Produk' }}</button></div>
    </div>
</form>
@endsection