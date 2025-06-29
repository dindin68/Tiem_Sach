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
        Schema::create('address', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('customer_id', 50);
            $table->string('phone', 20);
            $table->string('recipient_name', 100);
            $table->string('house_number', 50);
            $table->string('ward', 100);
            $table->string('district', 100);
            $table->string('city', 100);
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address');
    }
};
