<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoices.index', ['invoices' => Invoice::with(['customer', 'items'])->latest()->get()]);
    }

    public function create()
    {
        return view('invoices.create', ['customers' => Customer::orderBy('name')->get(), 'number' => Invoice::nextNumber()]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'customer_id' => 'required|exists:customers,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:200',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $invoice = DB::transaction(function () use ($data) {
            $invoice = Invoice::create([
                'customer_id' => $data['customer_id'],
                'number' => Invoice::nextNumber(),
                'issue_date' => $data['issue_date'],
                'due_date' => $data['due_date'],
                'notes' => $data['notes'] ?? null,
            ]);
            $invoice->items()->createMany($data['items']);
            return $invoice;
        });

        return redirect()->route('invoices.show', $invoice)->with('ok', 'Invoice ban gaya.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'items']);
        return view('invoices.show', compact('invoice'));
    }

    public function pdf(Invoice $invoice)
    {
        $invoice->load(['customer', 'items']);
        return Pdf::loadView('invoices.pdf', compact('invoice'))->download($invoice->number . '.pdf');
    }

    public function markPaid(Invoice $invoice)
    {
        $invoice->update(['status' => 'paid']);
        return back()->with('ok', 'Invoice paid mark ho gaya.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('ok', 'Invoice delete ho gaya.');
    }
}
