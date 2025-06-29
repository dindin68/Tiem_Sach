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
        Schema::create('order_item', function (Blueprint $table) {
            $table->string('order_id', 50);
            $table->string('book_id', 50);
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity');
            $table->decimal('amount', 10, 2);
            $table->text('notice')->nullable();
            $table->primary(['order_id', 'book_id']);
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('book_id')->references('id')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item');
    }
};
