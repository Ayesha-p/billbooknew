@extends('layouts.app')
@section('title', 'Customer')
@section('content')
<h1 class="text-2xl font-bold mb-6">{{ $customer->exists ? 'Customer edit karein' : 'Naya customer' }}</h1>
<form method="POST" action="{{ $customer->exists ? route('customers.update', $customer) : route('customers.store') }}" class="bg-white border rounded-lg p-6 max-w-lg space-y-4">
  @csrf
  @if($customer->exists) @method('PUT') @endif
  @foreach(['name' => 'Naam', 'email' => 'Email', 'phone' => 'Phone', 'address' => 'Address'] as $f => $label)
    <label class="block text-sm">{{ $label }}
      <input name="{{ $f }}" value="{{ old($f, $customer->$f) }}" class="mt-1 w-full border rounded px-3 py-2">
      @error($f)<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
    </label>
  @endforeach
  <button class="bg-indigo-700 text-white px-5 py-2 rounded">Save karein</button>
</form>
@endsection
