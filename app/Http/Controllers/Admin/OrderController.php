<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of orders with filters and search.
     */
    public function index(Request $request): View
    {
        $status = $request->input('status');
        $search = trim((string) $request->input('search'));

        $query = Order::with('items')->latest();

        if ($status && in_array($status, ['pending', 'processing', 'shipped', 'delivered', 'cancelled'], true)) {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(12)->withQueryString();

        $statusTotals = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', [
            'orders' => $orders,
            'currentStatus' => $status,
            'search' => $search,
            'statusTotals' => $statusTotals,
        ]);
    }

    /**
     * Display single order details.
     */
    public function show(Order $order): View
    {
        $order->load('items.product');

        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }

    /**
     * Update order status & payment status.
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,processing,shipped,delivered,cancelled'],
            'payment_status' => ['nullable', 'string', 'in:pending,paid,failed'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        if (empty($validated['payment_status'])) {
            unset($validated['payment_status']);
        }

        $order->update($validated);

        return back()->with('success', 'تم تحديث حالة الطلب '.$order->order_number.' بنجاح!');
    }

    /**
     * Display printable invoice receipt.
     */
    public function invoice(Order $order): View
    {
        $order->load('items.product');

        return view('admin.orders.invoice', [
            'order' => $order,
        ]);
    }

    /**
     * Delete an order.
     */
    public function destroy(Order $order): RedirectResponse
    {
        $orderNumber = $order->order_number;
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', "تم حذف الطلب {$orderNumber} بنجاح.");
    }
}
