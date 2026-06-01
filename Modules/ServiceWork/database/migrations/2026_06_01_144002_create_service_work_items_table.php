<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_work_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_work_category_id')->constrained('service_work_categories')->cascadeOnDelete();
            $table->json('title');
            $table->json('subtitle')->nullable();
            $table->json('content')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_work_items');
    }
};
