<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('collected_amount', 10, 2)->nullable()->after('total_amount');
            $table->decimal('return_charge', 10, 2)->default(0)->after('courier_charge');
            $table->string('return_reason')->nullable()->after('notes');
            $table->boolean('stock_restored')->default(false)->after('return_reason');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'collected_amount',
                'return_charge',
                'return_reason',
                'stock_restored'
            ]);
        });
    }
};
