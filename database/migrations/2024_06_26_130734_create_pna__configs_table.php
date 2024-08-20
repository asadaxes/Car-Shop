<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pna__configs', function (Blueprint $table) {
            $table->id();
            $table->integer('delivery_charge_inside')->default(0);
            $table->integer('delivery_charge_outside')->default(0);
            $table->integer('tax')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pna__configs');
    }
};