<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $couponData = session()->get('coupon', null);
        $discount = 0.00;

        if ($couponData) {
            $coupon = Coupon::where('code', $couponData['code'])->first();
            if ($coupon && $coupon->isValid($subtotal)) {
                $discount = $coupon->calculateDiscount($subtotal);
            } else {
                session()->forget('coupon');
                $couponData = null;
            }
        }

        $shipping = $subtotal > 100 || $subtotal == 0 ? 0.00 : 15.00;
        $total = max(0, $subtotal - $discount + $shipping);

        return view('cart.index', compact('cart', 'subtotal', 'shipping', 'discount', 'couponData', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $quantity = (int) $request->input('quantity', 1);
        if ($quantity < 1) $quantity = 1;

        $variantId = $request->input('variant_id');
        $variant = null;
        $price = (float) $product->effective_price;
        $variantName = null;

        if ($variantId) {
            $variant = ProductVariant::where('product_id', $product->id)->find($variantId);
            if ($variant) {
                if ($variant->price) $price = (float) $variant->price;
                $variantName = $variant->name;
            }
        }

        $cartKey = $variantId ? "{$product->id}_{$variantId}" : (string) $product->id;
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'id' => $product->id,
                'cart_key' => $cartKey,
                'variant_id' => $variantId,
                'variant_name' => $variantName,
                'name' => $product->name . ($variantName ? " ({$variantName})" : ''),
                'slug' => $product->slug,
                'price' => $price,
                'image' => $variant?->image ?? $product->image,
                'quantity' => $quantity,
                'sku' => $variant?->sku ?? $product->sku,
            ];
        }

        session()->put('cart', $cart);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cartCount' => array_sum(array_column($cart, 'quantity')),
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request, $id)
    {
        $quantity = (int) $request->input('quantity', 1);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($quantity > 0) {
                $cart[$id]['quantity'] = $quantity;
            } else {
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string|max:30']);
        $code = strtoupper(trim($request->input('code')));

        $cart = session()->get('cart', []);
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        if ($subtotal <= 0) {
            return back()->with('error', 'Your cart is empty.');
        }

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->isValid($subtotal)) {
            return back()->with('error', 'Invalid, expired, or inapplicable promo coupon code.');
        }

        session()->put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => (float) $coupon->value,
        ]);

        return back()->with('success', "Coupon '{$coupon->code}' applied successfully!");
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Coupon removed.');
    }

    public function clear()
    {
        session()->forget(['cart', 'coupon']);
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }
}