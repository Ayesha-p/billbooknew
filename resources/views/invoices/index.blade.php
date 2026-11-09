@extends('layouts.app')
@section('title', 'Invoices')
@section('content')
<div class="flex justify-between items-center mb-6">
  <h1 class="text-2xl font-bold">Invoices</h1>
  <a href="{{ route('invoices.create') }}" class="bg-indigo-700 text-white px-4 py-2 rounded text-sm">Naya invoice</a>
</div>
<div class="bg-white border rounded-lg overflow-x-auto">
<table class="w-full text-sm">
  <thead class="bg-gray-100 text-left"><tr><th class="p-3">Number</th><th>Customer</th><th>Due</th><th>Total</th><th>Status</th></tr></thead>
  <tbody class="divide-y">
  @forelse($invoices as $i)
    <tr>
      <td class="p-3"><a class="text-indigo-700 font-medium" href="{{ route('invoices.show', $i) }}">{{ $i->number }}</a></td>
      <td>{{ $i->customer->name }}</td>
      <td>{{ $i->due_date->format('d M Y') }}</td>
      <td>Rs {{ number_format($i->total) }}</td>
      <td><span class="px-2 py-1 rounded text-xs {{ $i->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-700' }}">{{ ucfirst($i->status) }}</span></td>
    </tr>
  @empty
    <tr><td colspan="5" class="p-8 text-center text-gray-500">Koi invoice nahi. Pehla invoice banayein.</td></tr>
  @endforelse
  </tbody>
</table>
</div>
@endsection
