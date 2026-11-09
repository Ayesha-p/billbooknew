@extends('layouts.app')
@section('title', 'Customers')
@section('content')
<div class="flex justify-between items-center mb-6">
  <h1 class="text-2xl font-bold">Customers</h1>
  <a href="{{ route('customers.create') }}" class="bg-indigo-700 text-white px-4 py-2 rounded text-sm">Customer add karein</a>
</div>
<div class="bg-white border rounded-lg divide-y">
  @forelse($customers as $c)
    <div class="p-4 flex justify-between items-center">
      <div><div class="font-medium">{{ $c->name }}</div><div class="text-sm text-gray-500">{{ $c->email }} {{ $c->phone }}</div></div>
      <div class="flex gap-4 text-sm">
        <a href="{{ route('customers.edit', $c) }}" class="text-indigo-700">Edit</a>
        <form method="POST" action="{{ route('customers.destroy', $c) }}" onsubmit="return confirm('Customer aur uske invoices delete honge. Pakka?')">@csrf @method('DELETE')<button class="text-red-600">Delete</button></form>
      </div>
    </div>
  @empty
    <div class="p-8 text-center text-gray-500">Abhi koi customer nahi. Pehla customer add karein.</div>
  @endforelse
</div>
@endsection
