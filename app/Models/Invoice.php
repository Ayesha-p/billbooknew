<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['customer_id', 'number', 'issue_date', 'due_date', 'status', 'notes'];
    protected $casts = ['issue_date' => 'date', 'due_date' => 'date'];

    public function customer() { return $this->belongsTo(Customer::class); }
    public function items() { return $this->hasMany(InvoiceItem::class); }

    public function getTotalAttribute() { return $this->items->sum(fn ($i) => $i->qty * $i->unit_price); }

    public static function nextNumber(): string
    {
        return 'INV-' . str_pad((static::max('id') ?? 0) + 1, 4, '0', STR_PAD_LEFT);
    }
}
