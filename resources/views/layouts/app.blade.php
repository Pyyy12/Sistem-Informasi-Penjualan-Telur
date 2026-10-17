<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') | EggStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root{--green:#16794b;--green-dark:#105c38;--mint:#eaf7ef;--ink:#1d2939;--muted:#667085;--surface:#fff;--page:#f5f8f6}
        *{box-sizing:border-box}body{margin:0;background:var(--page);color:var(--ink);font-family:Inter,system-ui,-apple-system,"Segoe UI",sans-serif}
        .app-shell{display:flex;min-height:100vh}.sidebar{width:258px;flex-shrink:0;background:#fff;border-right:1px solid #e7eee9;padding:25px 16px;display:flex;flex-direction:column}
        .brand{display:flex;align-items:center;gap:12px;padding:0 10px 28px;font-size:1.18rem;font-weight:800;color:var(--green-dark);text-decoration:none}
        .brand-icon{width:43px;height:43px;border-radius:14px;background:var(--mint);display:grid;place-items:center;color:var(--green);font-size:1.35rem}
        .nav-caption{font-size:.69rem;text-transform:uppercase;letter-spacing:.12em;color:#98a2b3;font-weight:800;padding:10px 12px}
        .side-link{display:flex;align-items:center;gap:12px;padding:12px 13px;margin:3px 0;border-radius:12px;color:#667085;text-decoration:none;font-size:.91rem;font-weight:600;transition:.2s}
        .side-link i{font-size:1.1rem;width:22px}.side-link:hover{background:#f0f8f3;color:var(--green);transform:translateX(2px)}
        .side-link.active{background:var(--green);color:#fff;box-shadow:0 7px 18px #16794b25}
        .main-area{flex:1;min-width:0}.topbar{height:78px;background:#fff;border-bottom:1px solid #e7eee9;display:flex;align-items:center;justify-content:space-between;padding:0 30px;gap:15px}
        .content-wrap{padding:28px 30px;max-width:1600px;margin:auto}.page-title{font-size:1.65rem;font-weight:800;letter-spacing:-.04em;margin:0}.page-subtitle{color:var(--muted);font-size:.91rem;margin-top:5px}
        .card-clean{background:var(--surface);border:1px solid #e8eee9;border-radius:18px;box-shadow:0 4px 18px #172b1c06}
        .stat-card{padding:21px;height:100%;transition:transform .2s,box-shadow .2s}.stat-card:hover{transform:translateY(-3px);box-shadow:0 12px 28px #172b1c0c}
        .stat-icon{width:46px;height:46px;display:grid;place-items:center;border-radius:14px;background:var(--mint);color:var(--green);font-size:1.3rem}
        .stat-label{font-size:.83rem;color:var(--muted);font-weight:600}.stat-value{font-size:clamp(1.25rem,2vw,1.8rem);font-weight:800;letter-spacing:-.04em;margin-top:12px;overflow-wrap:anywhere}
        .section-heading{font-size:1.02rem;font-weight:800;margin:0}.btn-green{background:var(--green);border-color:var(--green);color:#fff}.btn-green:hover{background:var(--green-dark);border-color:var(--green-dark);color:#fff;box-shadow:0 5px 14px #16794b30}
        .form-control,.form-select{border-color:#dce5df;border-radius:10px;padding:.68rem .8rem}.form-control:focus,.form-select:focus{border-color:#5bb789;box-shadow:0 0 0 .2rem #16794b15}
        .table thead th{background:#f7faf8;color:#667085;font-size:.74rem;text-transform:uppercase;letter-spacing:.04em;font-weight:800;border-bottom:1px solid #e8eee9;white-space:nowrap}
        .table td{vertical-align:middle;padding:.9rem .75rem}.table-responsive{border-radius:14px}.badge-soft{background:#eaf7ef;color:#16794b}.mobile-menu{display:none}
        @media(max-width:991.98px){.sidebar{width:220px}.content-wrap{padding:24px 20px}.topbar{padding:0 20px}}
        @media(max-width:767.98px){.app-shell{display:block}.sidebar{width:100%;padding:12px 14px;border-right:0;border-bottom:1px solid #e7eee9}.brand{padding:0 4px 10px}.sidebar-nav{display:flex;gap:6px;overflow-x:auto;padding-bottom:3px}.nav-caption{display:none}.side-link{white-space:nowrap;padding:9px 12px;font-size:.82rem}.side-link:hover{transform:none}.topbar{height:64px;padding:0 16px}.content-wrap{padding:20px 14px}.page-title{font-size:1.4rem}.stat-card{padding:16px}.hide-mobile{display:none!important}}
        @media(max-width:420px){.stat-value{font-size:1.2rem}.stat-icon{width:39px;height:39px}.content-wrap{padding:16px 10px}.card-clean{border-radius:14px}}
        @media print{.sidebar,.topbar,.no-print,.btn{display:none!important}.app-shell{display:block}.content-wrap{padding:0;max-width:none}body{background:#fff}.card-clean{box-shadow:none;border:1px solid #ddd;break-inside:avoid}.table{font-size:10pt}}
    </style>
    @stack('styles')
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <a class="brand" href="{{ route('dashboard') }}">
            <span class="brand-icon"><i class="bi bi-egg-fried"></i></span>
            <span>Egg<span class="text-success">Store</span></span>
        </a>
        <div class="sidebar-nav">
            <div class="nav-caption">Menu Utama</div>
            <a class="side-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2"></i> Dashboard</a>
            <a class="side-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}"><i class="bi bi-box-seam"></i> Produk Telur</a>
            <a class="side-link {{ request()->routeIs('sales.*') ? 'active' : '' }}" href="{{ route('sales.index') }}"><i class="bi bi-receipt"></i> Penjualan</a>
            <a class="side-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}"><i class="bi bi-bar-chart-line"></i> Laporan</a>
        </div>
        <div class="mt-auto pt-4 px-2 small text-secondary hide-mobile">EggStore · Manajemen penjualan telur</div>
    </aside>
    <main class="main-area">
        <header class="topbar">
            <div>
                <div class="fw-bold">@yield('top_heading', 'Ringkasan Bisnis')</div>
                <div class="small text-secondary">{{ now()->translatedFormat('l, d F Y') }}</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="rounded-circle d-grid place-items-center" style="width:38px;height:38px;background:#eaf7ef;color:#16794b;display:grid;place-items:center"><i class="bi bi-person-fill"></i></span>
                <div class="small"><div class="fw-bold">Administrator</div><div class="text-secondary">Pengelola Toko</div></div>
            </div>
        </header>
        <section class="content-wrap">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger rounded-3"><strong>Periksa kembali data:</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif
            @yield('content')
        </section>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>