<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Site attributes
            $table->string('name')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('email')->nullable();
            $table->text('footer_text')->nullable();
            $table->boolean('multipage')->default(0);

            // Social Media
            $table->boolean('show_social_in_nav')->default(0);
            $table->boolean('esoteric_social')->default(0);
            $table->string('social_phone')->nullable();
            $table->string('social_email')->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_twitter')->nullable();
            $table->string('social_linkedin')->nullable();
            $table->string('social_youtube')->nullable();
            $table->string('social_pinterest')->nullable();
            $table->string('social_bandcamp')->nullable();
            $table->string('social_houzz')->nullable();

            // Appearance
            $table->string('theme')->nullable();
            $table->string('nav_type')->default('pages');
            $table->boolean('transparent_nav')->default(0);
            $table->string('layout')->nullable();

            // Components
            $table->boolean('projects')->default(0);
            $table->boolean('custom_js')->default(0);

            // Google
            $table->boolean('google_analytics')->default(0);
            $table->string('tracking_id')->nullable();
            $table->boolean('google_ads')->default(0);
            $table->string('google_ads_client')->nullable();
            $table->string('google_ads_slot')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
