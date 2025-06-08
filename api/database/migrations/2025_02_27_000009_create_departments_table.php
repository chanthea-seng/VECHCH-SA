<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->unsignedTinyInteger('id', true)->primary();
            $table->string('name')->unique();
            $table->string('local_name')->unique();

            $table->unsignedTinyInteger('center_id');
            $table->foreign('center_id')
                ->references('id')
                ->on('centers')
                ->oncadeOnDelete()
                ->cascadeOnUpdate();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
