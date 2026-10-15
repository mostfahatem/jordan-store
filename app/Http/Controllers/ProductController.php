<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Product detail page with the interactive 3D viewer.
     */
    public function show(Product|string $product): View
    {
        if (is_string($product)) {
            $product = Product::query()->where('slug', $product)->firstOrFail();
        }

        $product->load('category');

        return view('store.product', [
            'product' => $product,
            'related' => Product::query()
                ->whereKeyNot($product->id)
                ->where(fn ($query) => $query->where('category_id', $product->category_id)->orWhere('garment', $product->garment))
                ->take(4)
                ->get(),
        ]);
    }
}
