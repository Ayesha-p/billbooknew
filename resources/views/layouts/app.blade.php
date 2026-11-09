<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'BillBook')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen">
<div class="md:flex min-h-screen">
  <aside class="md:w-56 bg-indigo-950 text-indigo-100 p-4 md:min-h-screen">
    <div class="font-bold text-xl text-white mb-6">BillBook</div>
    <nav class="flex md:flex-col gap-1 text-sm">
      <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded hover:bg-indigo-900">Dashboard</a>
      <a href="{{ route('invoices.index') }}" class="px-3 py-2 rounded hover:bg-indigo-900">Invoices</a>
      <a href="{{ route('customers.index') }}" class="px-3 py-2 rounded hover:bg-indigo-900">Customers</a>
      <form method="POST" action="{{ route('logout') }}" class="md:mt-6">@csrf<button class="px-3 py-2 text-indigo-300">Logout</button></form>
    </nav>
  </aside>
  <main class="flex-1 p-6">
    @if(session('ok'))<div class="mb-4 rounded bg-green-50 text-green-800 px-4 py-2 text-sm">{{ session('ok') }}</div>@endif
    @yield('content')
  </main>
</div>
</body>
</html>
