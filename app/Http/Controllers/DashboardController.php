<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $invoices = Invoice::with('items')->get();
        $paid = $invoices->where('status', 'paid');

        // Pichhle 6 mahine ki paid sales (DB-agnostic, collection se)
        $months = collect(range(5, 0))->map(fn ($m) => now()->subMonths($m)->startOfMonth());
        $labels = $months->map->format('M Y')->all();
        $sales = $months->map(fn ($m) => $paid
            ->filter(fn ($i) => $i->issue_date->format('Y-m') === $m->format('Y-m'))
            ->sum(fn ($i) => $i->total))->all();

        return view('dashboard', [
            'totalPaid' => $paid->sum(fn ($i) => $i->total),
            'totalUnpaid' => $invoices->where('status', 'unpaid')->sum(fn ($i) => $i->total),
            'invoiceCount' => $invoices->count(),
            'customerCount' => Customer::count(),
            'labels' => $labels,
            'sales' => $sales,
        ]);
    }
}
