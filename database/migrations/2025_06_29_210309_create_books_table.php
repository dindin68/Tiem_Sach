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
        Schema::create('books', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title', 255);
            $table->string('author', 100);
            $table->string('publisher', 100);
            $table->decimal('price', 10, 2);
            $table->integer('stock');
            $table->integer('imported');
            $table->integer('sold');
            $table->string('category_id',50)->nullable();           
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
