<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // User receiving the notification
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->onDelete('cascade'); // Related booking
            $table->tinyInteger('type')->default(0)->nullable()->comment('0 for booking, 1 for medical record,2 for invoice, 3 for general');
            $table->tinyInteger('is_read')->nullable()->default(0);
            $table->tinyInteger('is_approve')->nullable()->default(0);
            $table->string('title');
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
