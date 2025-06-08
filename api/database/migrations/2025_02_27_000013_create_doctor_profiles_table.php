<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id', true)->primary();
            $table->text('biography')->nullable();
            $table->json('spoken_languages')->nullable();
            $table->boolean('is_author')->default(false);
            $table->tinyInteger('status')->default(0)->comment("0 for unactive, 1 for active");
            $table->boolean('is_verify')->default(false);
            $table->timestamps();

            $table->unsignedTinyInteger('specialist_id')->nullable();
            $table->unsignedTinyInteger('department_id')->nullable();
            $table->unsignedTinyInteger('center_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('specialist_id')
                ->references('id')
                ->on('specialists')
                ->onDelete('SET NULL');
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('SET NULL');
            $table->foreign('center_id')
                ->references('id')
                ->on('centers')
                ->onDelete('SET NULL');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_profiles');
    }
};
