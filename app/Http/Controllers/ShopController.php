<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ShopController extends Controller
{
    /**
     * Product listing with search, filters, sorting and pagination.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'exists:categories,slug'],
            'garment' => ['nullable', Rule::in(Product::GARMENTS)],
            'size' => ['nullable', Rule::in(['38', '39', '40', '41', '42', '43', '44', '45', '46', 'XS', 'S', 'M', 'L', 'XL', 'XXL'])],
            'color' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'min' => ['nullable', 'numeric', 'min:0'],
            'max' => ['nullable', 'numeric', 'min:0'],
            'sort' => ['nullable', Rule::in(['newest', 'price_asc', 'price_desc', 'popular'])],
        ]);

        $products = Product::query()
            ->with('category')
            ->filter($filters)
            ->paginate(9)
            ->withQueryString();

        return view('store.shop', [
            'products' => $products,
            'filters' => $filters,
            'categories' => Category::query()->orderBy('sort_order')->get(),
            'colors' => $this->availableColors(),
            'priceCeiling' => (int) ceil((float) Product::query()->max('price')),
        ]);
    }

    /**
     * Distinct colours across the catalogue for the colour filter.
     *
     * @return Collection<int, array{hex: string, label: string}>
     */
    private function availableColors(): Collection
    {
        return Product::query()
            ->get(['colors'])
            ->flatMap(fn (Product $product): array => $product->localized_colors)
            ->unique('hex')
            ->values();
    }
}
