<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('client_type')->default('customer')->after('email');
            $table->string('phone', 191)->nullable()->after('client_type');
            $table->string('city')->nullable()->after('phone');
            $table->string('company_name')->nullable()->after('name');
            $table->text('company_bio')->nullable()->after('company_name');
            $table->string('commercial_register')->nullable()->after('company_bio');
            $table->string('profile_image_path')->nullable()->after('password');
            $table->timestamp('terms_accepted_at')->nullable()->after('remember_token');

            $table->unique('phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['phone']);

            $table->dropColumn([
                'client_type',
                'phone',
                'city',
                'company_name',
                'company_bio',
                'commercial_register',
                'profile_image_path',
                'terms_accepted_at',
            ]);
        });
    }
};

