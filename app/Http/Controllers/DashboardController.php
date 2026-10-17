<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $monthStart = Carbon::now()->startOfMonth();

        $todayRevenue = Sale::whereDate('sold_at', $today)->sum('total');
        $todayTransactions = Sale::whereDate('sold_at', $today)->count();
        $monthRevenue = Sale::where('sold_at', '>=', $monthStart)->sum('total');
        $stockProducts = Product::count();
        $lowStockCount = Product::whereColumn('stock', '<=', 'minimum_stock')->count();
        $eggsSoldToday = SaleItem::whereHas('sale', fn ($q) => $q->whereDate('sold_at', $today))
            ->sum('quantity');

        // 7 hari terakhir, termasuk tanggal hari ini; tanggal tanpa transaksi tetap bernilai 0.
        $chartLabels = [];
        $chartRevenue = [];
        $chartQuantities = [];
        $daily = Sale::query()
            ->selectRaw('DATE(sold_at) as day, SUM(total) as revenue')
            ->whereBetween('sold_at', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->groupBy(DB::raw('DATE(sold_at)'))
            ->pluck('revenue', 'day');

        $quantityDaily = SaleItem::query()
            ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->selectRaw('DATE(sales.sold_at) as day, SUM(sale_items.quantity) as qty')
            ->whereBetween('sales.sold_at', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->groupBy(DB::raw('DATE(sales.sold_at)'))
            ->pluck('qty', 'day');

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $chartLabels[] = Carbon::parse($date)->translatedFormat('d M');
            $chartRevenue[] = (float) ($daily[$date] ?? 0);
            $chartQuantities[] = (int) ($quantityDaily[$date] ?? 0);
        }

        $recentSales = Sale::with('items')->latest('sold_at')->take(6)->get();
        $lowStockProducts = Product::whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')->take(5)->get();

        $bestSellers = SaleItem::select('product_name', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_name')->orderByDesc('total_qty')->take(5)->get();

        return view('dashboard.index', compact(
            'todayRevenue', 'todayTransactions', 'monthRevenue', 'stockProducts',
            'lowStockCount', 'eggsSoldToday', 'chartLabels', 'chartRevenue',
            'chartQuantities', 'recentSales', 'lowStockProducts', 'bestSellers'
        ));
    }
}