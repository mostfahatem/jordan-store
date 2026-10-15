<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class PresentationController extends Controller
{
    /**
     * Display the commercial sales pitch presentation deck for prospective buyers.
     */
    public function index(): View
    {
        $sampleOrder = Order::latest()->first();
        $sampleProduct = Product::first();

        return view('presentation', [
            'sampleOrder' => $sampleOrder,
            'sampleProduct' => $sampleProduct,
        ]);
    }
}
