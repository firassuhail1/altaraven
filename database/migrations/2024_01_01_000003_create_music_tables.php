<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Albums
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->year('release_year');
            $table->string('spotify_album_id')->nullable(); // Spotify album ID
            $table->string('spotify_embed_url')->nullable();
            $table->enum('type', ['album', 'ep', 'single'])->default('album');
            $table->boolean('is_featured')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Tracks
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('duration')->nullable(); // e.g. "4:32"
            $table->integer('track_number')->default(1);
            $table->string('spotify_track_id')->nullable();
            $table->string('spotify_embed_url')->nullable();
            $table->string('cover_image')->nullable(); // override album cover
            $table->year('release_year')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracks');
        Schema::dropIfExists('albums');
    }
};
