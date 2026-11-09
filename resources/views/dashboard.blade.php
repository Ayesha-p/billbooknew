@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard</h1>
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
  <div class="bg-white border rounded-lg p-4"><div class="text-sm text-gray-500">Mila hua (paid)</div><div class="text-2xl font-semibold text-green-700">Rs {{ number_format($totalPaid) }}</div></div>
  <div class="bg-white border rounded-lg p-4"><div class="text-sm text-gray-500">Baqaya (unpaid)</div><div class="text-2xl font-semibold text-red-600">Rs {{ number_format($totalUnpaid) }}</div></div>
  <div class="bg-white border rounded-lg p-4"><div class="text-sm text-gray-500">Invoices</div><div class="text-2xl font-semibold">{{ $invoiceCount }}</div></div>
  <div class="bg-white border rounded-lg p-4"><div class="text-sm text-gray-500">Customers</div><div class="text-2xl font-semibold">{{ $customerCount }}</div></div>
</div>
<div class="bg-white border rounded-lg p-4">
  <div class="font-medium mb-3">Mahana sales (paid invoices)</div>
  <canvas id="sales" height="90"></canvas>
</div>
<script>
new Chart(document.getElementById('sales'), {
  type: 'bar',
  data: { labels: @json($labels), datasets: [{ label: 'Rs', data: @json($sales), backgroundColor: '#4338ca' }] },
  options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});
</script>
@endsection
