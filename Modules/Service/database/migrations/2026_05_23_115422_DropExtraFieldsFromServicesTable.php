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
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['stats', 'features', 'steps', 'faqs']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->json('stats')->nullable();
            $table->json('features')->nullable();
            $table->json('steps')->nullable();
            $table->json('faqs')->nullable();
        });
    }
};
