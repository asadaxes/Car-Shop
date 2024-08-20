<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->string('whatsapp_no')->nullable();
            $table->string('password');
            $table->string('avatar')->default('users/default_avatar.png');
            $table->string('flag')->default('default_flag')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('gender')->nullable();
            $table->string('birth_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_admin')->default(false);
            $table->string('joined_date');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}