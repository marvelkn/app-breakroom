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
        Schema::create('loyalty_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('required_points');
            $table->decimal('table_discount_percentage', 5, 2)->default(0);
            $table->decimal('food_discount_percentage', 5, 2)->default(0);
            $table->decimal('product_discount_percentage', 5, 2)->default(0);
            $table->decimal('points_multiplier', 3, 2)->default(1.00);
            $table->text('benefits')->nullable();
            $table->timestamps();
        });
        
        DB::table('loyalty_tiers')->insert([
            [
                'name' => 'Bronze',
                'required_points' => 0,
                'table_discount_percentage' => 0,
                'food_discount_percentage' => 0,
                'product_discount_percentage' => 0,
                'points_multiplier' => 1.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Silver',
                'required_points' => 500,
                'table_discount_percentage' => 5,
                'food_discount_percentage' => 5,
                'product_discount_percentage' => 5,
                'points_multiplier' => 1.25,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Gold',
                'required_points' => 1500,
                'table_discount_percentage' => 10,
                'food_discount_percentage' => 10,
                'product_discount_percentage' => 10,
                'points_multiplier' => 1.50,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Platinum',
                'required_points' => 3000,
                'table_discount_percentage' => 15,
                'food_discount_percentage' => 15,
                'product_discount_percentage' => 15,
                'points_multiplier' => 2.00,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_tiers');
    }
};
