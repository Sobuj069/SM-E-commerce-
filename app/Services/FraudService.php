<?php

namespace App\Services;

use App\Models\FraudBlacklist;
use App\Models\Order;

class FraudService
{
    /**
     * Analyze an order for potential fraud / delivery risk
     */
    public function analyzeOrder(Order $order): array
    {
        $riskScore = 5; // Base safe score
        $reasons = [];

        // 1. Check blacklist
        $isBlacklisted = FraudBlacklist::where('phone', $order->customer_phone)
            ->orWhere('email', $order->customer_email)
            ->first();

        if ($isBlacklisted) {
            $riskScore = 95;
            $reasons[] = "Blacklisted Contact: " . ($isBlacklisted->reason ?? 'Flagged as repeated scam/returner');
            return [
                'score' => $riskScore,
                'status' => 'blacklisted',
                'reasons' => $reasons,
                'success_rate' => 0,
                'total_orders' => 1,
            ];
        }

        // 2. Check previous order history for this phone
        $history = Order::where('customer_phone', $order->customer_phone)
            ->where('id', '!=', $order->id)
            ->get();

        $totalHistory = $history->count();
        $cancelledCount = $history->whereIn('order_status', ['cancelled', 'returned'])->count();
        $deliveredCount = $history->where('order_status', 'delivered')->count();

        if ($totalHistory > 0) {
            $returnRate = ($cancelledCount / $totalHistory) * 100;
            if ($returnRate > 50) {
                $riskScore += 45;
                $reasons[] = "High Return History: {$cancelledCount} of {$totalHistory} orders were cancelled/returned ({$returnRate}%)";
            } elseif ($deliveredCount >= 2) {
                $riskScore = max(0, $riskScore - 10);
                $reasons[] = "Verified Loyal Customer: {$deliveredCount} successfully delivered orders";
            }
        }

        // 3. Check high order amount
        if ($order->total_amount > 500) {
            $riskScore += 15;
            $reasons[] = "High Value Cash on Delivery order (\${$order->total_amount})";
        }

        // 4. Check incomplete address
        if (strlen($order->shipping_address) < 10) {
            $riskScore += 25;
            $reasons[] = "Short / Potentially Incomplete Shipping Address";
        }

        // Determine status tag
        $status = 'safe';
        if ($riskScore >= 70) {
            $status = 'high_risk';
        } elseif ($riskScore >= 35) {
            $status = 'review';
        }

        $successRate = $totalHistory > 0 ? round(($deliveredCount / $totalHistory) * 100) : 100;

        return [
            'score' => min(100, $riskScore),
            'status' => $status,
            'reasons' => $reasons,
            'success_rate' => $successRate,
            'total_orders' => $totalHistory,
        ];
    }
}