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
        Schema::table('properties', function (Blueprint $table) {
            $table->json('maps')->nullable();
            $table->integer('floor')->nullable();
            $table->year('last_renovation')->nullable();
            $table->dropColumn('availability');
        });

        Schema::table('properties', function (Blueprint $table) {
            $table->enum('availability', ['now', 'arrangement'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('maps');
            $table->dropColumn('floor');
            $table->dropColumn('last_renovation');
            $table->dropColumn('availability');
        });

        Schema::table('properties', function (Blueprint $table) {
            $table->string('availability')->nullable();
        });
    }
};
