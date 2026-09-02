<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('courier_name')->nullable()->after('payment_status'); // steadfast, pathao, redx, paperfly, dhl
            $table->string('consignment_id')->nullable()->after('courier_name');
            $table->string('tracking_code')->nullable()->after('consignment_id');
            $table->string('courier_status')->default('unassigned')->after('tracking_code'); // unassigned, booked, in_transit, delivered, returned, cancelled
            $table->decimal('courier_charge', 10, 2)->default(0)->after('courier_status');
            $table->integer('fraud_risk_score')->default(5)->after('courier_charge'); // 0-100 (higher = riskier)
            $table->string('fraud_status')->default('safe')->after('fraud_risk_score'); // safe, review, high_risk, blacklisted
            $table->text('fraud_notes')->nullable()->after('fraud_status');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'courier_name',
                'consignment_id',
                'tracking_code',
                'courier_status',
                'courier_charge',
                'fraud_risk_score',
                'fraud_status',
                'fraud_notes'
            ]);
        });
    }
};