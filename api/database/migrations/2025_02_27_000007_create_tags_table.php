<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->unsignedTinyInteger('id', true)->primary();
            $table->string('name')->unique();
            $table->string('local_name')->unique();
            $table->tinyInteger('content_type')->comment('1 for article tag, 2 for disease tag');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
