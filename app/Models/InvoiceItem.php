<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = ['invoice_id', 'description', 'qty', 'unit_price'];
    public function getLineTotalAttribute() { return $this->qty * $this->unit_price; }
}
