<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Handle order submission from checkout form.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:150'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'customer_email' => ['nullable', 'email', 'max:150'],
            'governorate' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'shipping_address' => ['required', 'string', 'max:500'],
            'payment_method' => ['required', 'string', 'in:cod,instapay,card'],
            'promo_code' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required'],
            'items.*.name' => ['required', 'string'],
            'items.*.size' => ['required', 'string'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.color' => ['nullable', 'array'],
            'items.*.image' => ['nullable', 'string'],
        ]);

        return DB::transaction(function () use ($validated): JsonResponse {
            $subtotal = 0;
            $itemsData = [];

            foreach ($validated['items'] as $item) {
                $qty = (int) $item['quantity'];
                $price = (float) $item['price'];
                $itemTotal = $price * $qty;
                $subtotal += $itemTotal;

                // Match with product if available
                $productId = is_numeric($item['id']) ? (int) $item['id'] : null;
                if ($productId && ! Product::where('id', $productId)->exists()) {
                    $productId = null;
                }

                $colorLabel = $item['color']['label'] ?? 'Default';
                $colorHex = $item['color']['hex'] ?? '#16161a';

                $itemsData[] = [
                    'product_id' => $productId,
                    'product_name' => $item['name'],
                    'product_image' => $item['image'] ?? 'images/store/products/air-jordan-1-retro.jpg',
                    'size' => $item['size'],
                    'color_label' => $colorLabel,
                    'color_hex' => $colorHex,
                    'price' => $price,
                    'quantity' => $qty,
                    'total' => $itemTotal,
                ];
            }

            // Calculate discount (JORDAN20 or NOVA20 provides 20% off)
            $discount = 0;
            $promo = strtoupper(trim((string) ($validated['promo_code'] ?? '')));
            if (in_array($promo, ['JORDAN20', 'NOVA20'], true)) {
                $discount = round($subtotal * 0.20, 2);
            }

            // Free shipping threshold: 2,000 EGP
            $shippingFee = ($subtotal >= 2000 || $subtotal <= 0) ? 0 : 75;
            $total = max(0, $subtotal - $discount + $shippingFee);

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'] ?? null,
                'governorate' => $validated['governorate'],
                'city' => $validated['city'],
                'shipping_address' => $validated['shipping_address'],
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_method'] === 'cod' ? 'pending' : 'paid',
                'status' => 'pending',
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping_fee' => $shippingFee,
                'total' => $total,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($itemsData as $itemRow) {
                $order->items()->create($itemRow);
            }

            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء طلبك بنجاح!',
                'order_number' => $order->order_number,
                'redirect_url' => route('orders.confirmation', $order->order_number),
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'status' => $order->status,
                    'total' => $order->total,
                ],
            ]);
        });
    }
}
