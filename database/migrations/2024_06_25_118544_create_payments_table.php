<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('vehicle_id')->nullable();
                $table->string('pna_order_id')->nullable();
                $table->integer('amount');
                $table->string('currency');
                $table->string('tran_id');
                $table->string('status');
                $table->timestamp('issued_at');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('vehicle_id');
            });
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
