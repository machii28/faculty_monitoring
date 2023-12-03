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
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('attendances');

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->date('booking_date');
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('subject_id');
            $table->string('start_booking_time')->nullable();
            $table->string('end_booking_time')->nullable();
            $table->timestamps();
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->boolean('is_occupied')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('user_id');
            $table->string('year');
            $table->string('semester');
            $table->timestamps();
        });

        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->date('date_clocked_in')->nullable();
            $table->timestamps();
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('is_occupied');
        });
    }
};
