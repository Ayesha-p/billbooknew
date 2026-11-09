@extends('layouts.app')
@section('title', 'Naya invoice')
@section('content')
<h1 class="text-2xl font-bold mb-6">Naya invoice <span class="text-gray-400 text-lg">{{ $number }}</span></h1>
<form method="POST" action="{{ route('invoices.store') }}" class="bg-white border rounded-lg p-6 max-w-3xl space-y-5"
      x-data="{ items: [{description:'', qty:1, unit_price:0}], get total(){ return this.items.reduce((s,i)=>s+i.qty*i.unit_price,0) } }">
  @csrf
  <div class="grid sm:grid-cols-3 gap-4">
    <label class="text-sm">Customer
      <select name="customer_id" class="mt-1 w-full border rounded px-3 py-2">
        @foreach($customers as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
      </select>
    </label>
    <label class="text-sm">Issue date<input type="date" name="issue_date" value="{{ now()->toDateString() }}" class="mt-1 w-full border rounded px-3 py-2"></label>
    <label class="text-sm">Due date<input type="date" name="due_date" value="{{ now()->addDays(15)->toDateString() }}" class="mt-1 w-full border rounded px-3 py-2"></label>
  </div>
  <div class="space-y-2">
    <template x-for="(item, idx) in items" :key="idx">
      <div class="grid grid-cols-12 gap-2">
        <input class="col-span-6 border rounded px-3 py-2" placeholder="Tafseel" :name="`items[${idx}][description]`" x-model="item.description" required>
        <input class="col-span-2 border rounded px-3 py-2" type="number" min="1" :name="`items[${idx}][qty]`" x-model.number="item.qty">
        <input class="col-span-3 border rounded px-3 py-2" type="number" min="0" step="0.01" :name="`items[${idx}][unit_price]`" x-model.number="item.unit_price">
        <button type="button" class="col-span-1 text-red-600" @click="items.length > 1 && items.splice(idx,1)">✕</button>
      </div>
    </template>
    <button type="button" class="text-sm text-indigo-700" @click="items.push({description:'', qty:1, unit_price:0})">+ Item add karein</button>
  </div>
  <label class="block text-sm">Notes<textarea name="notes" rows="2" class="mt-1 w-full border rounded px-3 py-2"></textarea></label>
  @if($errors->any())<div class="text-sm text-red-600">{{ $errors->first() }}</div>@endif
  <div class="flex items-center justify-between">
    <div class="font-semibold">Total: Rs <span x-text="total.toLocaleString()"></span></div>
    <button class="bg-indigo-700 text-white px-5 py-2 rounded">Invoice banayein</button>
  </div>
</form>
@endsection
