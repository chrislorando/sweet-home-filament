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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'provider'])->default('provider')->after('email');
            $table->string('company_name')->nullable()->after('role');
            $table->text('description')->nullable()->after('company_name');
            $table->string('address')->nullable()->after('description');
            $table->string('services')->nullable()->after('address');
            $table->string('phone')->nullable()->after('services');
            $table->string('website')->nullable()->after('phone');
            $table->string('avatar')->nullable()->after('website');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'company_name',
                'description',
                'address',
                'services',
                'phone',
                'website',
                'avatar',
            ]);
        });
    }
};
