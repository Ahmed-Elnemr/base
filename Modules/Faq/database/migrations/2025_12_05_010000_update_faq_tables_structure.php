<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faq_sections', function (Blueprint $table) {
            if (Schema::hasColumn('faq_sections', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });

        Schema::table('faq_items', function (Blueprint $table) {
            if (Schema::hasColumn('faq_items', 'faq_section_id')) {
                $table->dropForeign(['faq_section_id']);
                $table->dropColumn('faq_section_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('faq_sections', function (Blueprint $table) {
            if (! Schema::hasColumn('faq_sections', 'is_active')) {
                $table->boolean('is_active')->default(true)->index();
            }
        });

        Schema::table('faq_items', function (Blueprint $table) {
            if (! Schema::hasColumn('faq_items', 'faq_section_id')) {
                $table->foreignId('faq_section_id')
                    ->nullable()
                    ->constrained()
                    ->cascadeOnDelete();
            }
        });
    }
};








