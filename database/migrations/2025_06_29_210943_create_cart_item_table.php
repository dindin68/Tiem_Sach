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
            Schema::create('cart_item', function (Blueprint $table) {
            $table->string('cart_id');
            $table->string('book_id');
            $table->integer('quantity');
            $table->decimal('amount', 10, 2);
            $table->text('notice')->nullable();
            $table->primary(['cart_id', 'book_id']);
            $table->foreign('cart_id')->references('id')->on('cart')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_item');
    }
};
