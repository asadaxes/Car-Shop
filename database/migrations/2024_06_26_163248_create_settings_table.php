<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('favicon')->nullable();
            $table->string('logo_site')->nullable();
            $table->string('logo_admin')->nullable();
            $table->string('title_site')->nullable();
            $table->string('title_admin')->nullable();
            $table->string('footer_copyright')->nullable();
            $table->text('footer_description')->nullable();
            $table->string('footer_link_1')->nullable();
            $table->string('footer_link_2')->nullable();
            $table->string('footer_link_3')->nullable();
            $table->string('contact_address')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->json('social_ids')->nullable();
            $table->string('ga_id')->nullable();
            $table->string('meta_author')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};