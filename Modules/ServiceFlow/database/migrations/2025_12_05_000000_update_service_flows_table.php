<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_flows', function (Blueprint $table) {
            if (! Schema::hasColumn('service_flows', 'step_number')) {
                $table->unsignedTinyInteger('step_number')->default(1)->after('id');
            }

            if (! Schema::hasColumn('service_flows', 'sort_order')) {
                $table->unsignedInteger('sort_order')->default(0)->after('step_number');
            }
        });

        Schema::dropIfExists('service_flow_steps');
    }

    public function down(): void
    {
        Schema::table('service_flows', function (Blueprint $table) {
            if (Schema::hasColumn('service_flows', 'sort_order')) {
                $table->dropColumn('sort_order');
            }

            if (Schema::hasColumn('service_flows', 'step_number')) {
                $table->dropColumn('step_number');
            }
        });

        Schema::create('service_flow_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_flow_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->unsignedTinyInteger('step_number')->index();
            $table->json('title');
            $table->json('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();

            $table->unique(['service_flow_id', 'step_number']);
        });
    }
};







