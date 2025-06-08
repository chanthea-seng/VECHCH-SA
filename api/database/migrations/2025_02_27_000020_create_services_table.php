<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->unsignedTinyInteger('id', true)->primary();
            $table->string('name')->nullable();
            $table->string('local_name')->nullable();
            $table->text('description')->nullable();
            $table->text('local_description')->nullable();
            $table->tinyInteger('service_type')->comment('0 meeting doctor 1 for check up, 2 for vaccine');
            $table->text('instruction')->nullable();
            $table->text('local_instruction')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
