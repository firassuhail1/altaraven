<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->date('event_date');
            $table->time('event_time')->nullable();
            $table->string('venue')->nullable();
            $table->string('city');
            $table->string('country')->default('Indonesia');
            $table->string('ticket_url')->nullable();
            $table->string('poster_image')->nullable();
            $table->enum('status', ['upcoming', 'past', 'cancelled'])->default('upcoming');
            $table->boolean('is_featured')->default(false);
            $table->decimal('ticket_price', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
