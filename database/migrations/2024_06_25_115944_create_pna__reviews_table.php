<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pna__reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pna_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('rating', [1, 2, 3, 4, 5]);
            $table->text('feedback')->nullable();
            $table->timestamp('issued_at');
            $table->foreign('pna_id')->references('id')->on('part_and_accessories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pna__reviews');
    }
};