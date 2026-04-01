<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('base_price', 10, 2);
            $table->string('category')->default('apparel'); // apparel, accessories, vinyl, etc.
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // Product images (multiple)
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->boolean('is_primary')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Product variants (size + type + color combination)
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('size')->nullable();        // S, M, L, XL, XXL, One Size
            $table->string('type')->nullable();        // Short Sleeve, Long Sleeve, Hoodie, etc.
            $table->string('color')->nullable();       // Black, White, Red, etc.
            $table->string('color_hex')->nullable();   // #000000
            $table->string('custom_option')->nullable(); // any custom variant
            $table->decimal('price_modifier', 8, 2)->default(0); // +/- from base price
            $table->string('sku')->unique()->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Stock per variant (manual control)
        Schema::create('variant_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variant_id')->constrained('product_variants')->cascadeOnDelete();
            $table->integer('quantity')->default(0);
            $table->integer('low_stock_threshold')->default(5);
            $table->timestamps();
        });

        // Stock adjustment log
        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variant_id')->constrained('product_variants')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // admin who did it
            $table->integer('quantity_change'); // positive = add, negative = reduce
            $table->integer('quantity_before');
            $table->integer('quantity_after');
            $table->string('reason')->nullable(); // 'manual add', 'order', etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_adjustments');
        Schema::dropIfExists('variant_stocks');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
    }
};
