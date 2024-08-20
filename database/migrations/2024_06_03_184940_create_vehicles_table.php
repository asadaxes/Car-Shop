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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dealer_id')->constrained('users');
            $table->foreignId('brand_id')->constrained('brands');
            $table->string('model');
            $table->foreignId('category_id')->constrained('vehicles_categories');
            $table->text('images')->nullable();
            $table->json('features')->nullable();
            $table->json('details')->nullable();
            $table->text('description')->nullable();
            $table->integer('price')->nullable();
            $table->string('mileage')->nullable();
            $table->string('fuel_type')->nullable();
            $table->enum('condition', ['new', 'used', 'recondition', 'modified'])->nullable();
            $table->string('exterior_color')->nullable();
            $table->string('interior_color')->nullable();
            $table->string('engine')->nullable();
            $table->string('drivetrain')->nullable();
            $table->integer('model_year')->nullable();
            $table->integer('registration_year')->nullable();
            $table->enum('status', ['temp', 'active', 'closed', 'sold'])->default('temp');
            $table->string('slug')->nullable();
            $table->timestamp('publish_date')->comment('Publish Date in Asia/Dhaka timezone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};