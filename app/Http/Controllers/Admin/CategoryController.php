<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories with product counts.
     */
    public function index(): View
    {
        $categories = Category::withCount('products')->orderBy('sort_order')->get();

        return view('admin.categories.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name_ar' => ['required', 'string', 'max:100'],
            'name_en' => ['required', 'string', 'max:100'],
            'image' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $slug = Str::slug($validated['name_en']);
        if (Category::where('slug', $slug)->exists()) {
            $slug .= '-'.time();
        }

        Category::create([
            'slug' => $slug,
            'name_ar' => $validated['name_ar'],
            'name_en' => $validated['name_en'],
            'image' => $validated['image'] ?? 'images/store/products/air-jordan-1-retro.jpg',
            'sort_order' => $validated['sort_order'] ?? (Category::max('sort_order') + 1),
        ]);

        return back()->with('success', 'تم إضافة التصنيف بنجاح!');
    }

    /**
     * Update an existing category.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name_ar' => ['required', 'string', 'max:100'],
            'name_en' => ['required', 'string', 'max:100'],
            'image' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $category->update($validated);

        return back()->with('success', 'تم تحديث بيانات التصنيف بنجاح!');
    }

    /**
     * Delete an existing category.
     */
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف التصنيف لأنه يحتوي على أحذية ومنتجات مسجلة.');
        }

        $category->delete();

        return back()->with('success', 'تم حذف التصنيف بنجاح.');
    }
}
