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
        // Work Method Section (Single Record)
        Schema::create('work_method_sections', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('steps')->nullable(); // Repeater: number, title, description
            $table->timestamps();
        });

        // CTA Section (Single Record)
        Schema::create('cta_sections', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('subtitle')->nullable();
            $table->json('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cta_sections');
        Schema::dropIfExists('work_method_sections');
    }
};
