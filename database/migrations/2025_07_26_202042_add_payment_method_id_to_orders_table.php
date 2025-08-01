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
    Schema::table('orders', function (Blueprint $table) {
        $table->string('payment_method_id', 5)->nullable()->after('status');
        $table->foreign('payment_method_id')->references('id')->on('payment_method');
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropForeign(['payment_method_id']);
        $table->dropColumn('payment_method_id');
    });
}

};
