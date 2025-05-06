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
        Schema::table('table_bookings', function (Blueprint $table) {
            //
            $table->integer('original_price')->nullable()->after('duration');
            $table->integer('loyalty_discount')->nullable();
            $table->integer('voucher_discount')->nullable();
            $table->foreignId('used_voucher_id')->nullable()->constrained('user_vouchers');
            $table->integer('final_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('table_bookings', function (Blueprint $table) {
            //
            $table->dropForeign(['used_voucher_id']);
            $table->dropColumn(['original_price', 'loyalty_discount', 'voucher_discount', 'used_voucher_id', 'final_price']);
        });
    }
};
