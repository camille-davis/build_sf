<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('slug')->unique();
            $table->string('title')->default('Page Title')->nullable();
            $table->integer('weight')->nullable();
            $table->string('meta_description')->nullable();
            $table->boolean('homepage')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
