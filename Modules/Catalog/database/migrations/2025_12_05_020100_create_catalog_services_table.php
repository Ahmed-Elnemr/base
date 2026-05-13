<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catalog_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catalog_category_id')
                ->constrained('catalog_categories')
                ->cascadeOnDelete();
            $table->json('title');
            $table->json('content')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('phone')->nullable();
            $table->json('features')->nullable();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalog_services');
    }
};








