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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('address');
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->decimal('size', 10, 2)->nullable();
            $table->decimal('rooms', 3, 1)->nullable();
            $table->foreignId('location_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('draft');
            $table->text('rejection_notes')->nullable();
            $table->string('condition')->nullable();
            $table->string('property_type')->nullable();
            $table->string('availability')->nullable();
            $table->decimal('living_area', 10, 2)->nullable();
            $table->decimal('cubic_area', 10, 2)->nullable();
            $table->decimal('plot_size', 10, 2)->nullable();
            $table->year('construction_year')->nullable();
            $table->string('immocode')->nullable();
            $table->string('property_number')->nullable();
            $table->string('document')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
