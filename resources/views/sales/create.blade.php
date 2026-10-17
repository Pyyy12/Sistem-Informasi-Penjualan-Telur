@extends('layouts.app')
@section('title', 'Transaksi Baru')
@section('top_heading', 'Transaksi Penjualan')
@section('content')
<div class="mb-4"><a href="{{ route('sales.index') }}" class="text-success text-decoration-none small fw-bold"><i class="bi bi-arrow-left me-1"></i>Kembali ke Penjualan</a><h1 class="page-title mt-2">Transaksi Penjualan Baru</h1><div class="page-subtitle">Pilih produk dan jumlah; stok akan berkurang setelah transaksi berhasil.</div></div>
<form method="POST" action="{{ route('sales.store') }}" id="saleForm">
@csrf
<div class="row g-3">
    <div class="col-12 col-xl-8">
        <div class="card-clean p-3 p-md-4 mb-3">
            <h2 class="section-heading mb-3">Informasi Pelanggan</h2>
            <div class="row g-3">
                <div class="col-12 col-md-6"><label class="form-label fw-semibold">Nama pelanggan *</label><input name="customer_name" class="form-control" required value="{{ old('customer_name','Pelanggan Umum') }}"></div>
                <div class="col-12 col-md-6"><label class="form-label fw-semibold">Metode pembayaran *</label><select name="payment_method" class="form-select" required><option>Tunai</option><option>Transfer</option><option>QRIS</option></select></div>
            </div>
        </div>
        <div class="card-clean p-3 p-md-4">
            <div class="d-flex justify-content-between align-items-center mb-3"><h2 class="section-heading">Item Penjualan</h2><button type="button" id="addItem" class="btn btn-sm btn-light border rounded-3"><i class="bi bi-plus-lg me-1"></i>Tambah item</button></div>
            <div id="itemsContainer"></div>
            <template id="itemTemplate">
                <div class="sale-item border rounded-3 p-3 mb-3">
                    <div class="row g-2 align-items-end">
                        <div class="col-12 col-md-7"><label class="form-label small fw-semibold">Produk</label><select class="form-select product-select" name="items[INDEX][product_id]" required><option value="">Pilih produk...</option>@foreach($products as $product)<option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">{{ $product->name }} — Rp {{ number_format($product->price,0,',','.') }} / {{ $product->unit }} (stok {{ $product->stock }})</option>@endforeach</select></div>
                        <div class="col-8 col-md-3"><label class="form-label small fw-semibold">Jumlah</label><input type="number" class="form-control qty-input" name="items[INDEX][quantity]" value="1" min="1" required></div>
                        <div class="col-4 col-md-2"><button type="button" class="btn btn-outline-danger w-100 remove-item" title="Hapus item"><i class="bi bi-trash"></i></button></div>
                    </div>
                    <div class="d-flex justify-content-between mt-3 small"><span class="text-secondary">Subtotal item</span><strong class="line-total">Rp 0</strong></div>
                </div>
            </template>
        </div>
    </div>
    <div class="col-12 col-xl-4">
        <div class="card-clean p-3 p-md-4">
            <h2 class="section-heading mb-3">Ringkasan Pembayaran</h2>
            <div class="d-flex justify-content-between py-2"><span class="text-secondary">Subtotal</span><strong id="subtotalText">Rp 0</strong></div>
            <label class="form-label fw-semibold mt-2">Diskon (Rp)</label><input type="number" min="0" step="0.01" name="discount" id="discount" value="0" class="form-control">
            <hr><div class="d-flex justify-content-between align-items-center"><span class="fw-bold">Total bayar</span><strong class="fs-4 text-success" id="grandTotal">Rp 0</strong></div>
            <label class="form-label fw-semibold mt-3">Catatan</label><textarea name="notes" rows="2" class="form-control" placeholder="Opsional"></textarea>
            <button class="btn btn-green w-100 rounded-3 py-3 mt-4"><i class="bi bi-check-circle me-2"></i>Simpan Transaksi</button>
            <div class="small text-secondary mt-3"><i class="bi bi-shield-check me-1"></i>Stok dan transaksi diproses bersama agar data tetap konsisten.</div>
        </div>
    </div>
</div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('itemsContainer');
    const template = document.getElementById('itemTemplate');
    const discountInput = document.getElementById('discount');
    let index = 0;
    const rupiah = n => 'Rp ' + Number(n || 0).toLocaleString('id-ID', {maximumFractionDigits: 2});

    function recalculate() {
        let subtotal = 0;
        container.querySelectorAll('.sale-item').forEach(row => {
            const select = row.querySelector('.product-select');
            const option = select.options[select.selectedIndex];
            const price = Number(option?.dataset.price || 0);
            const stock = Number(option?.dataset.stock || 0);
            const qtyInput = row.querySelector('.qty-input');
            const qty = Math.max(0, Number(qtyInput.value || 0));
            qtyInput.max = stock || 1;
            qtyInput.setCustomValidity(qty > stock ? `Stok tersedia hanya ${stock}.` : '');
            const line = price * qty;
            subtotal += line;
            row.querySelector('.line-total').textContent = rupiah(line);
        });
        const discount = Math.max(0, Number(discountInput.value || 0));
        document.getElementById('subtotalText').textContent = rupiah(subtotal);
        document.getElementById('grandTotal').textContent = rupiah(Math.max(0, subtotal - discount));
    }

    function addRow() {
        const html = template.innerHTML.replaceAll('INDEX', index++);
        container.insertAdjacentHTML('beforeend', html);
        const row = container.lastElementChild;
        row.querySelector('.remove-item').addEventListener('click', () => {
            row.remove();
            if (!container.querySelector('.sale-item')) addRow();
            recalculate();
        });
        row.querySelectorAll('select,input').forEach(el => el.addEventListener('input', recalculate));
        recalculate();
    }

    document.getElementById('addItem').addEventListener('click', addRow);
    discountInput.addEventListener('input', recalculate);
    document.getElementById('saleForm').addEventListener('submit', event => {
        recalculate();
        if (!document.getElementById('saleForm').checkValidity()) {
            event.preventDefault();
            document.getElementById('saleForm').reportValidity();
        }
    });
    addRow();
});
</script>
@endpush