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
        Schema::create('table_bookings', function (Blueprint $table) {
            // $table->id();
            // $table->unsignedBigInteger('user_id');
            // $table->unsignedBigInteger('table_id');
            // $table->dateTime('booking_time');
            // $table->integer('duration')->comment('in minutes');
            // $table->dateTime('started_at')->nullable();
            // $table->string('status')->default('pending')->comment('pending, active, completed, cancelled');
            // $table->tinyInteger('is_active')->default(false);
            // $table->timestamps();
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('table_id')->references('id')->on('tables')->onDelete('cascade');

            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('table_id');
            $table->dateTime('booking_time');
            $table->string('booking_type')->comment('3-hour-package, open');
            $table->integer('duration')->nullable()->comment('in minutes');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->integer('final_duration')->nullable()->comment('in minutes');
            $table->string('status')->default('pending')->comment('pending, active, completed, cancelled');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('table_id')->references('id')->on('tables')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_bookings');
    }
};
