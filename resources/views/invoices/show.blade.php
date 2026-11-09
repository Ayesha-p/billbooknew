@extends('layouts.app')
@section('title', $invoice->number)
@section('content')
<div class="flex flex-wrap gap-3 justify-between items-center mb-6">
  <h1 class="text-2xl font-bold">{{ $invoice->number }}</h1>
  <div class="flex gap-2 text-sm">
    <a href="{{ route('invoices.pdf', $invoice) }}" class="bg-indigo-700 text-white px-4 py-2 rounded">PDF download</a>
    @if($invoice->status === 'unpaid')
      <form method="POST" action="{{ route('invoices.paid', $invoice) }}">@csrf @method('PATCH')<button class="bg-green-600 text-white px-4 py-2 rounded">Paid mark karein</button></form>
    @endif
    <form method="POST" action="{{ route('invoices.destroy', $invoice) }}" onsubmit="return confirm('Invoice delete karein?')">@csrf @method('DELETE')<button class="border border-red-300 text-red-600 px-4 py-2 rounded">Delete</button></form>
  </div>
</div>
<div class="bg-white border rounded-lg p-6 max-w-3xl">
  <div class="flex justify-between mb-6">
    <div><div class="text-sm text-gray-500">Bill to</div><div class="font-medium">{{ $invoice->customer->name }}</div><div class="text-sm text-gray-500">{{ $invoice->customer->address }}</div></div>
    <div class="text-sm text-right">Issue: {{ $invoice->issue_date->format('d M Y') }}<br>Due: {{ $invoice->due_date->format('d M Y') }}<br>Status: <b>{{ ucfirst($invoice->status) }}</b></div>
  </div>
  <table class="w-full text-sm">
    <thead class="border-b text-left"><tr><th class="py-2">Tafseel</th><th>Qty</th><th>Price</th><th class="text-right">Total</th></tr></thead>
    <tbody>
    @foreach($invoice->items as $it)
      <tr class="border-b"><td class="py-2">{{ $it->description }}</td><td>{{ $it->qty }}</td><td>{{ number_format($it->unit_price) }}</td><td class="text-right">{{ number_format($it->line_total) }}</td></tr>
    @endforeach
    </tbody>
  </table>
  <div class="text-right mt-4 text-lg font-semibold">Total: Rs {{ number_format($invoice->total) }}</div>
  @if($invoice->notes)<p class="mt-4 text-sm text-gray-600">{{ $invoice->notes }}</p>@endif
</div>
@endsection
