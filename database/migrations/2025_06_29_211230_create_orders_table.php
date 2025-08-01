<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id', 50);
            $table->dateTime('date_order');
            $table->string('status', 50);
            $table->decimal('shipping_fee', 10, 2);
            $table->decimal('total_cost', 10, 2);
            $table->text('notice')->nullable();
           $table->foreignId('address_id')->constrained('addresses')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
