<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('slug');
            $table->string('title')->default('Section Title')->nullable();
            $table->text('body')->nullable();
            $table->string('type')->nullable();
            $table->integer('weight')->nullable();
            $table->foreignId('page_id')->nullable()->references('id')->on('pages');
            $table->string('image_ids')->nullable();
            $table->boolean('collapsible_body')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
