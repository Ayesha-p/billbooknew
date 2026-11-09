<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
  h1 { margin: 0; color: #312e81; }
  table { width: 100%; border-collapse: collapse; margin-top: 20px; }
  th { background: #eef2ff; text-align: left; }
  th, td { padding: 8px; border-bottom: 1px solid #ddd; }
  .r { text-align: right; }
  .total { margin-top: 16px; text-align: right; font-size: 15px; font-weight: bold; }
</style>
</head>
<body>
  <h1>INVOICE</h1>
  <p>{{ $invoice->number }} &nbsp;|&nbsp; Status: {{ strtoupper($invoice->status) }}</p>
  <p><b>Bill to:</b> {{ $invoice->customer->name }}<br>{{ $invoice->customer->address }}<br>{{ $invoice->customer->phone }}</p>
  <p>Issue: {{ $invoice->issue_date->format('d M Y') }} &nbsp; Due: {{ $invoice->due_date->format('d M Y') }}</p>
  <table>
    <thead><tr><th>Description</th><th>Qty</th><th class="r">Price</th><th class="r">Total</th></tr></thead>
    <tbody>
    @foreach($invoice->items as $it)
      <tr><td>{{ $it->description }}</td><td>{{ $it->qty }}</td><td class="r">{{ number_format($it->unit_price) }}</td><td class="r">{{ number_format($it->line_total) }}</td></tr>
    @endforeach
    </tbody>
  </table>
  <div class="total">Total: Rs {{ number_format($invoice->total) }}</div>
  @if($invoice->notes)<p>{{ $invoice->notes }}</p>@endif
</body>
</html>
