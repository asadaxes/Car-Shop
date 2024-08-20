<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('part_and_accessories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['Parts', 'Accessories']);
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->integer('regular_price')->nullable();
            $table->integer('sale_price')->nullable();
            $table->integer('quantity')->default(0);
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('has_warranty')->default(false);
            $table->integer('reviews')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamp('publish_date');
            $table->foreign('brand_id')->references('id')->on('pna__brands')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('pna__categories')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('part_and_accessories');
    }
};