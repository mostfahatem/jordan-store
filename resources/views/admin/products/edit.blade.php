@extends('admin.layout')

@section('title', 'تعديل السنيكرز: ' . $product->name . ' | JORDAN PRODUCTS')

@php
    $isAr = app()->getLocale() === 'ar';
@endphp

@section('admin_content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between border-b border-white/10 pb-4">
        <div>
            <a href="{{ route('admin.products.index') }}" class="text-xs font-mono text-gray-400 hover:text-white transition">
                ← {{ $isAr ? 'العودة لقائمة الأحذية' : 'Back to sneakers' }}
            </a>
            <h1 class="text-2xl font-black text-white mt-1">
                {{ $isAr ? 'تعديل بيانات السنيكرز' : 'Edit Sneaker Details' }}
            </h1>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('products.show', $product) }}" target="_blank" class="px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 text-white text-xs font-mono font-bold transition flex items-center gap-1.5">
                <span>👁️</span>
                <span>{{ $isAr ? 'معاينة بالمتجر' : 'View in Store' }}</span>
            </a>
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="p-6 sm:p-8 rounded-3xl bg-[#0d0d16] border border-white/10 shadow-2xl">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Category & Visibility -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-mono font-bold text-gray-300 mb-1.5">
                        {{ $isAr ? 'التصنيف *' : 'Category *' }}
                    </label>
                    <select name="category_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/15 text-xs text-white focus:outline-none focus:border-red-500 font-mono">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $isAr ? $cat->name_ar : $cat->name_en }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold text-gray-300 mb-1.5">
                        {{ $isAr ? 'السعر (ج.م) *' : 'Price (EGP) *' }}
                    </label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="1" step="0.01" class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/15 text-xs text-white focus:outline-none focus:border-red-500 font-mono" />
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold text-gray-300 mb-1.5">
                        {{ $isAr ? 'السعر القديم قبل الخصم (اختياري)' : 'Old Price (Optional)' }}
                    </label>
                    <input type="number" name="old_price" value="{{ old('old_price', $product->old_price) }}" min="1" step="0.01" class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/15 text-xs text-white focus:outline-none focus:border-red-500 font-mono" />
                </div>
            </div>

            <!-- Names AR / EN -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-mono font-bold text-gray-300 mb-1.5">
                        {{ $isAr ? 'اسم الحذاء بالعربية *' : 'Sneaker Name (AR) *' }}
                    </label>
                    <input type="text" name="name_ar" value="{{ old('name_ar', $product->name_ar) }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/15 text-xs text-white focus:outline-none focus:border-red-500" />
                </div>
                <div>
                    <label class="block text-xs font-mono font-bold text-gray-300 mb-1.5">
                        {{ $isAr ? 'اسم الحذاء بالإنجليزية *' : 'Sneaker Name (EN) *' }}
                    </label>
                    <input type="text" name="name_en" value="{{ old('name_en', $product->name_en) }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/15 text-xs text-white focus:outline-none focus:border-red-500" />
                </div>
            </div>

            <!-- Descriptions AR / EN -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-mono font-bold text-gray-300 mb-1.5">
                        {{ $isAr ? 'الوصف بالعربية *' : 'Description (AR) *' }}
                    </label>
                    <textarea name="description_ar" rows="3" required class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/15 text-xs text-white focus:outline-none focus:border-red-500 leading-relaxed">{{ old('description_ar', $product->description_ar) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-mono font-bold text-gray-300 mb-1.5">
                        {{ $isAr ? 'الوصف بالإنجليزية *' : 'Description (EN) *' }}
                    </label>
                    <textarea name="description_en" rows="3" required class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/15 text-xs text-white focus:outline-none focus:border-red-500 leading-relaxed">{{ old('description_en', $product->description_en) }}</textarea>
                </div>
            </div>

            <!-- Image Asset Path / URL -->
            <div>
                <label class="block text-xs font-mono font-bold text-gray-300 mb-1.5">
                    {{ $isAr ? 'مسار أو رابط صورة السنيكرز (Image Path) *' : 'Sneaker Image Path *' }}
                </label>
                <div class="flex items-center gap-4">
                    <div class="w-16 h-14 rounded-xl bg-black/60 border border-white/10 p-1 flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset($product->image) }}" alt="Preview" class="w-full h-full object-contain filter drop-shadow" />
                    </div>
                    <input type="text" name="image" value="{{ old('image', $product->image) }}" required class="flex-1 px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/15 text-xs text-white focus:outline-none focus:border-red-500 font-mono" />
                </div>
            </div>

            <!-- Sizes Selection -->
            <div>
                <label class="block text-xs font-mono font-bold text-gray-300 mb-2">
                    {{ $isAr ? 'المقاسات الأوروبية المتاحة (EU Sizes) *' : 'Available Sizes (EU) *' }}
                </label>
                <div class="flex flex-wrap items-center gap-3">
                    @php
                        $activeSizes = is_array($product->sizes) ? $product->sizes : [];
                    @endphp
                    @foreach($defaultSizes as $size)
                        <label class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 hover:border-red-500/50 cursor-pointer text-xs font-mono text-gray-200">
                            <input type="checkbox" name="sizes[]" value="{{ $size }}" {{ in_array($size, $activeSizes) ? 'checked' : '' }} class="rounded text-red-600 focus:ring-0" />
                            <span>EU {{ $size }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Flags (New Drop, Featured) -->
            <div class="flex flex-wrap items-center gap-6 pt-2 border-t border-white/5 text-xs">
                <label class="flex items-center gap-2 cursor-pointer text-gray-300 hover:text-white">
                    <input type="checkbox" name="is_new" value="1" {{ $product->is_new ? 'checked' : '' }} class="rounded text-cyan-400 focus:ring-0" />
                    <span>{{ $isAr ? 'تمييز كإصدار جديد (New Drop)' : 'Mark as New Drop' }}</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer text-gray-300 hover:text-white">
                    <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="rounded text-red-600 focus:ring-0" />
                    <span>{{ $isAr ? 'عرض في الصفحة الرئيسية (Featured)' : 'Show on Homepage (Featured)' }}</span>
                </label>
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-white/10 flex items-center justify-end gap-3">
                <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-gray-300 text-xs font-mono transition">
                    {{ $isAr ? 'إلغاء' : 'Cancel' }}
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-mono font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-red-600/20 cursor-pointer">
                    {{ $isAr ? 'تحديث بيانات الحذاء ✓' : 'Save Changes ✓' }}
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
