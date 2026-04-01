<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('band_info', function (Blueprint $table) {
            $table->id();
            $table->string('band_name')->default('ALTARAVEN');
            $table->string('tagline')->nullable();
            $table->longText('history')->nullable();
            $table->text('description')->nullable();
            $table->string('founded_year')->nullable();
            $table->string('genre')->nullable();
            $table->string('origin')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('hero_video')->nullable();
            $table->json('social_links')->nullable(); // {spotify, instagram, youtube, facebook, tiktok}
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('band_info');
    }
};
