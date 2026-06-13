<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('about_pages');
        Schema::dropIfExists('case_studies');
        Schema::dropIfExists('cta_sections');
        Schema::dropIfExists('hero_sections');
        Schema::dropIfExists('home_stats');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('project_requests');
        Schema::dropIfExists('service_categories');
        Schema::dropIfExists('service_work');
        Schema::dropIfExists('service_work_categories');
        Schema::dropIfExists('service_work_items');
        Schema::dropIfExists('services');
        Schema::dropIfExists('why_us_sections');
        Schema::dropIfExists('work_method_sections');
        Schema::dropIfExists('works');

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback needed for dropping unused old tables
    }
};
