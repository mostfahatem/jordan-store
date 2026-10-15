<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedAttributes;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'category_id', 'name_ar', 'name_en', 'slug', 'description_ar', 'description_en',
    'material_ar', 'material_en', 'price', 'old_price', 'image', 'garment', 'colors',
    'sizes', 'rating', 'reviews_count', 'stock', 'is_featured', 'is_new',
])]
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory, HasLocalizedAttributes;

    /**
     * Garment types supported by the procedural 3D viewer.
     *
     * @var list<string>
     */
    public const GARMENTS = ['shoe', 'tee', 'hoodie', 'sweatshirt', 'jacket', 'pants', 'dress'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'colors' => 'array',
            'sizes' => 'array',
            'price' => 'decimal:2',
            'old_price' => 'decimal:2',
            'rating' => 'float',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
        ];
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return HasMany<OrderItem, $this>
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * @return Attribute<string, never>
     */
    protected function name(): Attribute
    {
        return Attribute::get(fn (): string => (string) $this->localized('name'));
    }

    /**
     * @return Attribute<string, never>
     */
    protected function description(): Attribute
    {
        return Attribute::get(fn (): string => (string) $this->localized('description'));
    }

    /**
     * @return Attribute<string, never>
     */
    protected function material(): Attribute
    {
        return Attribute::get(fn (): string => (string) $this->localized('material'));
    }

    /**
     * Discount percentage when an old price is set.
     *
     * @return Attribute<int|null, never>
     */
    protected function discountPercent(): Attribute
    {
        return Attribute::get(function (): ?int {
            if (! $this->old_price || (float) $this->old_price <= (float) $this->price) {
                return null;
            }

            return (int) round((1 - (float) $this->price / (float) $this->old_price) * 100);
        });
    }

    /**
     * Colors with the label resolved for the active locale.
     *
     * @return Attribute<list<array{hex: string, label: string}>, never>
     */
    protected function localizedColors(): Attribute
    {
        return Attribute::get(fn (): array => collect($this->colors ?? [])
            ->map(fn (array $color): array => [
                'hex' => $color['hex'],
                'label' => $color[app()->getLocale()] ?? $color['ar'],
            ])
            ->values()
            ->all());
    }

    /**
     * Payload consumed by the front-end (cart / 3D viewer).
     *
     * @return array<string, mixed>
     */
    public function toStorefront(): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'price' => (float) $this->price,
            'image' => asset($this->image),
            'garment' => $this->garment,
            'colors' => $this->localized_colors,
            'sizes' => $this->sizes,
            'url' => route('products.show', $this),
        ];
    }

    #[Scope]
    protected function featured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    /**
     * Apply storefront filters coming from the shop page.
     *
     * @param  array{q?: string|null, category?: string|null, garment?: string|null, size?: string|null, color?: string|null, min?: numeric|null, max?: numeric|null, sort?: string|null}  $filters
     */
    #[Scope]
    protected function filter(Builder $query, array $filters): void
    {
        $query
            ->when($filters['q'] ?? null, function (Builder $query, string $term): void {
                $query->where(function (Builder $query) use ($term): void {
                    $query->where('name_ar', 'like', "%{$term}%")
                        ->orWhere('name_en', 'like', "%{$term}%");
                });
            })
            ->when($filters['category'] ?? null, fn (Builder $query, string $slug) => $query->whereRelation('category', 'slug', $slug))
            ->when($filters['garment'] ?? null, fn (Builder $query, string $garment) => $query->where('garment', $garment))
            ->when($filters['size'] ?? null, fn (Builder $query, string $size) => $query->where('sizes', 'like', '%"'.$size.'"%'))
            ->when($filters['color'] ?? null, fn (Builder $query, string $hex) => $query->where('colors', 'like', '%'.$hex.'%'))
            ->when($filters['min'] ?? null, fn (Builder $query, $min) => $query->where('price', '>=', $min))
            ->when($filters['max'] ?? null, fn (Builder $query, $max) => $query->where('price', '<=', $max));

        match ($filters['sort'] ?? 'newest') {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'popular' => $query->orderByDesc('reviews_count'),
            default => $query->latest('id'),
        };
    }
}
