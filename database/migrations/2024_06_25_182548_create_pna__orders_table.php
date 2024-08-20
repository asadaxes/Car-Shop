<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePnaOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('pna__orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->unsignedBigInteger('pna_id');
            $table->foreign('pna_id')->references('id')->on('part_and_accessories');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('amount');
            $table->integer('quantity');
            $table->enum('delivery_method', ['pay_with_ssl', 'cash_on_delivery']);
            $table->json('shipping_address');
            $table->enum('deliver_status', ['preparing', 'on_the_way', 'delivered'])->default('preparing');
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->timestamp('issued_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pna_orders');
    }
}