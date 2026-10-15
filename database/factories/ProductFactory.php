<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'category_id' => Category::factory(),
            'name_ar' => $name,
            'name_en' => Str::title($name),
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1, 99999),
            'description_ar' => fake()->paragraph(),
            'description_en' => fake()->paragraph(),
            'material_ar' => '100% قطن',
            'material_en' => '100% Cotton',
            'price' => fake()->numberBetween(300, 3000),
            'old_price' => null,
            'image' => 'images/store/tee_white.jpg',
            'garment' => fake()->randomElement(Product::GARMENTS),
            'colors' => [['hex' => '#111111', 'ar' => 'أسود', 'en' => 'Black']],
            'sizes' => ['S', 'M', 'L'],
            'rating' => 4.5,
            'reviews_count' => fake()->numberBetween(0, 500),
            'stock' => 50,
            'is_featured' => false,
            'is_new' => false,
        ];
    }

    /**
     * Mark the product as featured on the home page.
     */
    public function featured(): static
    {
        return $this->state(fn (): array => ['is_featured' => true]);
    }
}
