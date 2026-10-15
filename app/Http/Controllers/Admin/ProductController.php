<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of sneakers/products.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $categoryId = $request->input('category_id');

        $query = Product::with('category')->latest();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                    ->orWhere('name_en', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name_ar')->get();

        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories,
            'search' => $search,
            'categoryId' => $categoryId,
        ]);
    }

    /**
     * Show form to create a new sneaker.
     */
    public function create(): View
    {
        $categories = Category::all();

        return view('admin.products.create', [
            'categories' => $categories,
            'defaultSizes' => ['40', '41', '42', '43', '44', '45'],
        ]);
    }

    /**
     * Store a newly created sneaker.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name_ar' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:1'],
            'old_price' => ['nullable', 'numeric', 'gte:price'],
            'description_ar' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'material_ar' => ['nullable', 'string', 'max:255'],
            'material_en' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'string', 'max:500'],
            'sizes' => ['required', 'array', 'min:1'],
            'colors' => ['nullable', 'array'],
            'is_featured' => ['nullable', 'boolean'],
            'is_new' => ['nullable', 'boolean'],
            'rating' => ['nullable', 'numeric', 'min:1', 'max:5'],
        ]);

        $baseSlug = Str::slug($validated['name_en']);
        $slug = $baseSlug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $colors = $validated['colors'] ?? ['red', 'black', 'white'];

        Product::create([
            'category_id' => $validated['category_id'],
            'slug' => $slug,
            'garment' => 'shoe',
            'name_ar' => $validated['name_ar'],
            'name_en' => $validated['name_en'],
            'description_ar' => $validated['description_ar'],
            'description_en' => $validated['description_en'],
            'material_ar' => $validated['material_ar'] ?? 'جلد طبيعي ومطاط عالي الثبات',
            'material_en' => $validated['material_en'] ?? 'Genuine leather & rubber outsole',
            'price' => $validated['price'],
            'old_price' => $validated['old_price'] ?? null,
            'image' => $validated['image'],
            'sizes' => $validated['sizes'],
            'colors' => $colors,
            'is_featured' => $request->boolean('is_featured'),
            'is_new' => $request->boolean('is_new', true),
            'rating' => $validated['rating'] ?? 5.0,
            'reviews_count' => random_int(20, 150),
            'stock' => 50,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'تم إضافة السنيكرز بنجاح إلى المتجر!');
    }

    /**
     * Show form to edit an existing sneaker.
     */
    public function edit(Product $product): View
    {
        $categories = Category::all();

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'defaultSizes' => ['40', '41', '42', '43', '44', '45'],
        ]);
    }

    /**
     * Update an existing sneaker.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name_ar' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:1'],
            'old_price' => ['nullable', 'numeric'],
            'description_ar' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'material_ar' => ['nullable', 'string', 'max:255'],
            'material_en' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'string', 'max:500'],
            'sizes' => ['required', 'array', 'min:1'],
            'colors' => ['nullable', 'array'],
            'is_featured' => ['nullable', 'boolean'],
            'is_new' => ['nullable', 'boolean'],
            'rating' => ['nullable', 'numeric', 'min:1', 'max:5'],
        ]);

        $colors = $validated['colors'] ?? $product->colors;

        $product->update([
            'category_id' => $validated['category_id'],
            'name_ar' => $validated['name_ar'],
            'name_en' => $validated['name_en'],
            'description_ar' => $validated['description_ar'],
            'description_en' => $validated['description_en'],
            'material_ar' => $validated['material_ar'] ?? $product->material_ar,
            'material_en' => $validated['material_en'] ?? $product->material_en,
            'price' => $validated['price'],
            'old_price' => $validated['old_price'] ?? null,
            'image' => $validated['image'],
            'sizes' => $validated['sizes'],
            'colors' => $colors,
            'is_featured' => $request->boolean('is_featured'),
            'is_new' => $request->boolean('is_new'),
            'rating' => $validated['rating'] ?? $product->rating,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'تم تحديث بيانات السنيكرز بنجاح!');
    }

    /**
     * Delete an existing sneaker.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $name = $product->name_ar;
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', "تم حذف المنتج {$name} من المتجر بنجاح.");
    }
}
