<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('invoices', function (Blueprint $t) {
            $t->id();
            $t->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $t->string('number')->unique();
            $t->date('issue_date');
            $t->date('due_date');
            $t->string('status')->default('unpaid'); // unpaid, paid
            $t->text('notes')->nullable();
            $t->timestamps();
        });
        Schema::create('invoice_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $t->string('description');
            $t->unsignedInteger('qty')->default(1);
            $t->decimal('unit_price', 12, 2);
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
    }
};
