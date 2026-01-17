<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title')->default('My Creator Site');
            $table->string('site_tagline')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('currency_symbol')->default('$');
            $table->string('category')->nullable();
            $table->json('theme_config')->nullable(); 
            $table->json('features')->nullable();     
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
