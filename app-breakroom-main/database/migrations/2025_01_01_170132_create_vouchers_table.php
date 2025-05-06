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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('voucher_type', ['table_discount', 'food_discount', 'product_discount']);
            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->integer('discount_value'); 
            $table->integer('points_required');
            $table->integer('min_purchase')->nullable();
            $table->integer('max_discount')->nullable();
            $table->integer('validity_days');
            $table->boolean('is_active')->default(true);
            $table->integer('stock')->default(-1)->comment('-1 is unlimited'); // -1 for unlimited
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
