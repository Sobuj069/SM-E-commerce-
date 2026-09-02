<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courier_settings', function (Blueprint $table) {
            $table->id();
            $table->string('provider'); // steadfast, pathao, redx, paperfly, dhl
            $table->string('api_key')->nullable();
            $table->string('secret_key')->nullable();
            $table->string('client_id')->nullable();
            $table->string('sender_name')->nullable();
            $table->string('sender_phone')->nullable();
            $table->string('sender_address')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        Schema::create('fraud_blacklists', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable()->index();
            $table->string('email')->nullable()->index();
            $table->string('ip_address')->nullable()->index();
            $table->string('reason')->nullable();
            $table->string('blocked_by')->default('Admin');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fraud_blacklists');
        Schema::dropIfExists('courier_settings');
    }
};