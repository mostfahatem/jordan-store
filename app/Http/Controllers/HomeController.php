<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Landing page with the 3D hero, categories and featured products.
     */
    public function index(): View
    {
        return view('store.home', [
            'categories' => Category::query()->withCount('products')->orderBy('sort_order')->get(),
            'featured' => Product::query()->featured()->latest('id')->take(8)->get(),
            'newArrivals' => Product::query()->where('is_new', true)->latest('id')->take(4)->get(),
        ]);
    }
}
