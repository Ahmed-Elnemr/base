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
        Schema::create('services', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('service_category_id')->constrained()->cascadeOnDelete();
            $blueprint->json('title');
            $blueprint->string('slug')->unique();
            $blueprint->json('description');
            $blueprint->json('short_description');
            $blueprint->json('stats')->nullable(); // [{"label": "Project", "value": "120+"}]
            $blueprint->json('features')->nullable(); // [{"title": "Strategy", "description": "...", "icon": "..."}]
            $blueprint->json('steps')->nullable(); // [{"title": "Analysis", "description": "..."}]
            $blueprint->json('faqs')->nullable(); // [{"question": "...", "answer": "..."}]
            $blueprint->boolean('is_active')->default(true);
            $blueprint->integer('sort_order')->default(0);
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
