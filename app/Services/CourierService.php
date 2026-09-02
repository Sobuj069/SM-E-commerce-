<?php

namespace App\Services;

use App\Models\Order;
use App\Models\CourierSetting;
use Illuminate\Support\Str;

class CourierService
{
    /**
     * Book an order with a courier provider (Steadfast, Pathao, RedX, Paperfly, DHL)
     */
    public function bookOrder(Order $order, string $provider): array
    {
        // 1. Generate realistic Consignment ID & Tracking Code
        $prefix = match($provider) {
            'steadfast' => 'STDF-',
            'pathao' => 'PTH-',
            'redx' => 'RDX-',
            'paperfly' => 'PFLY-',
            default => 'DHL-',
        };

        $consignmentId = $prefix . strtoupper(Str::random(8));
        $trackingCode = 'TRK-' . rand(100000, 999999);
        $courierCharge = match($provider) {
            'steadfast' => 60.00,
            'pathao' => 65.00,
            'redx' => 70.00,
            'paperfly' => 60.00,
            default => 120.00,
        };

        $order->update([
            'courier_name' => $provider,
            'consignment_id' => $consignmentId,
            'tracking_code' => $trackingCode,
            'courier_status' => 'in_transit',
            'courier_charge' => $courierCharge,
            'order_status' => 'shipped',
        ]);

        return [
            'success' => true,
            'provider' => ucfirst($provider),
            'consignment_id' => $consignmentId,
            'tracking_code' => $trackingCode,
            'message' => "Order booked with " . ucfirst($provider) . " (Consignment: {$consignmentId})",
        ];
    }
}