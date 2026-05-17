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
        // Hero Section (Single Record)
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->longText('title');
            $table->longText('subtitle');
            $table->longText('button_text_1')->nullable();
            $table->longText('button_text_2')->nullable();
            $table->string('button_url_1')->nullable();
            $table->string('button_url_2')->nullable();
            $table->timestamps();
        });

        // Why Us Section (Single Record)
        Schema::create('why_us_sections', function (Blueprint $table) {
            $table->id();
            $table->longText('title');
            $table->longText('content');
            $table->longText('points')->nullable(); // Array of strings
            $table->timestamps();
        });

        // Partners (Multiple Records)
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Stats (Multiple Records)
        Schema::create('home_stats', function (Blueprint $table) {
            $table->id();
            $table->longText('title');
            $table->string('value');
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
        Schema::dropIfExists('home_stats');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('why_us_sections');
        Schema::dropIfExists('hero_sections');
    }
};
