<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display admin overview dashboard with store telemetry.
     */
    public function index(): View
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        $totalProducts = Product::count();
        $totalCategories = Category::count();

        // Recent 7 orders
        $recentOrders = Order::with('items')->latest()->take(7)->get();

        // Top 5 sneakers
        $topProducts = Product::withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->take(5)
            ->get();

        // Status counts map for quick progress breakdown
        $statusCounts = [
            'pending' => $pendingOrders,
            'processing' => $processingOrders,
            'shipped' => $shippedOrders,
            'delivered' => $deliveredOrders,
            'cancelled' => $cancelledOrders,
        ];

        return view('admin.dashboard', [
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'pendingOrders' => $pendingOrders,
            'processingOrders' => $processingOrders,
            'shippedOrders' => $shippedOrders,
            'deliveredOrders' => $deliveredOrders,
            'cancelledOrders' => $cancelledOrders,
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'recentOrders' => $recentOrders,
            'topProducts' => $topProducts,
            'statusCounts' => $statusCounts,
        ]);
    }
}
