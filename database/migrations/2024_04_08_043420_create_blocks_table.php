<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('type')->nullable();
            $table->string('location')->nullable();
            $table->text('body')->nullable();
            $table->integer('weight')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
