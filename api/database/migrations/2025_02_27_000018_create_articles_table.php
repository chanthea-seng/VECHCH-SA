<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedTinyInteger('category_id')->nullable();
            $table->string('title')->nullable();
            $table->string('thumbnail')->default('no_thumbnail.jpg');
            $table->mediumText('short_description')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('is_published')->default(false)->index();
            $table->timestamp('published_at')->nullable();
            $table->bigInteger('view')->nullable()->default(0);
            $table->unsignedTinyInteger('type')->comment('1 for articles, 2 for disease');
            $table->timestamps();

            $table->foreign('doctor_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
