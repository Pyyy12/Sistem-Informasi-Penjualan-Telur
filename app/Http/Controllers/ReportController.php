<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $query = Sale::with('items')->orderByDesc('sold_at');

        if (!empty($validated['start_date'])) {
            $query->whereDate('sold_at', '>=', $validated['start_date']);
        }
        if (!empty($validated['end_date'])) {
            $query->whereDate('sold_at', '<=', $validated['end_date']);
        }

        $sales = $query->paginate(15)->withQueryString();
        $totalRevenue = (clone $query)->sum('total');
        $totalTransactions = (clone $query)->count();

        return view('reports.index', compact('sales', 'totalRevenue', 'totalTransactions'));
    }
}