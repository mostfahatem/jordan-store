<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderConfirmationController extends Controller
{
    /**
     * Display order confirmation screen after checkout.
     */
    public function show(string $orderNumber): View
    {
        $order = Order::with('items.product')->where('order_number', $orderNumber)->firstOrFail();

        return view('store.order-confirmation', [
            'order' => $order,
        ]);
    }

    /**
     * Display customer order tracking search page.
     */
    public function track(Request $request): View
    {
        $query = trim((string) $request->input('q'));
        $order = null;

        if ($query !== '') {
            $order = Order::with('items.product')
                ->where('order_number', $query)
                ->orWhere('customer_phone', $query)
                ->latest()
                ->first();
        }

        return view('store.order-track', [
            'order' => $order,
            'query' => $query,
        ]);
    }
}
