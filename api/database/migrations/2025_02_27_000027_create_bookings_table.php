<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('local_name');
            $table->date('dob');
            $table->unsignedTinyInteger('gender')
                ->comment('0: Unknown, 1: Male, 2: Female, 3: Other');
            $table->string('phone_number', 15);
            $table->string('email')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('sub_service_id')->nullable();
            $table->tinyInteger('service_type')->nullable()->default(0)->comment('0 for doctorm, 1 for checkup, 2 for vaccine');
            $table->dateTime('appointment_time');
            $table->text('description')->nullable();
            $table->text('file')->nullable();
            $table->text('paymentImage')->nullable();
            $table->unsignedTinyInteger('booking_status')
                ->comment('0: Pending, 1: Approved, 2: Rejected, 3: Cancelled');
            $table->boolean('is_complete')->default(false);
            $table->boolean('is_remove')->default(false);
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('doctor_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('sub_service_id')
                ->references('id')
                ->on('sub_services')
                ->onDelete('SET NULL');
            ;

            $table->unique(['doctor_id', 'appointment_time'], 'doctor_time_unique')
                ->whereNotNull('doctor_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
