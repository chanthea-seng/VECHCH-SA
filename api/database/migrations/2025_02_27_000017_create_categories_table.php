<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->unsignedTinyInteger('id', true)->primary();
            $table->string('name')->unique();
            $table->string('local_name')->unique();
            $table->tinyInteger('content_type')->comment('1 for article cate, 2 for disease cate');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
