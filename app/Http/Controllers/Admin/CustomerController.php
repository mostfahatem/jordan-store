<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Display a listing of unique store customers and their order history.
     */
    public function index(): View
    {
        $customers = Order::select(
            'customer_phone',
            DB::raw('MAX(customer_name) as customer_name'),
            DB::raw('MAX(customer_email) as customer_email'),
            DB::raw('MAX(governorate) as governorate'),
            DB::raw('MAX(city) as city'),
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('SUM(total) as total_spent'),
            DB::raw('MAX(created_at) as last_order_date')
        )
            ->groupBy('customer_phone')
            ->orderByDesc('total_spent')
            ->paginate(15);

        return view('admin.customers.index', [
            'customers' => $customers,
        ]);
    }
}
