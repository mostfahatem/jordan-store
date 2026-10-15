<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_home_page_returns_successful_response_and_renders_categories(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('NOVA');
        $response->assertViewHas(['categories', 'featured', 'newArrivals']);
    }

    public function test_shop_page_renders_products_and_filters(): void
    {
        $response = $this->get(route('shop'));

        $response->assertOk();
        $response->assertViewHas(['products', 'categories', 'colors']);
    }

    public function test_shop_filters_by_category(): void
    {
        $category = Category::query()->first();
        $this->assertNotNull($category);

        $response = $this->get(route('shop', ['category' => $category->slug]));

        $response->assertOk();
        $response->assertViewHas('products');
    }

    public function test_shop_filters_by_garment(): void
    {
        $response = $this->get(route('shop', ['garment' => 'hoodie']));

        $response->assertOk();
        $products = $response->viewData('products');
        foreach ($products as $prod) {
            $this->assertSame('hoodie', $prod->garment);
        }
    }

    public function test_product_detail_page_loads_with_storefront_data(): void
    {
        $product = Product::query()->first();
        $this->assertNotNull($product);

        $response = $this->get(route('products.show', $product));

        $response->assertOk();
        $response->assertSee($product->name);
        $response->assertViewHas(['product', 'related']);
    }

    public function test_language_toggle_switches_locale_in_session(): void
    {
        $response = $this->get(route('locale', 'en'));

        $response->assertRedirect();
        $response->assertSessionHas('locale', 'en');

        $response2 = $this->get(route('locale', 'ar'));
        $response2->assertRedirect();
        $response2->assertSessionHas('locale', 'ar');
    }

    public function test_commercial_presentation_page_loads_successfully(): void
    {
        $response = $this->get(route('presentation'));

        $response->assertOk();
        $response->assertSee('JORDAN');
        $response->assertSee('FLIGHT OS');
    }

    public function test_demo_admin_login_redirects_and_authenticates_admin(): void
    {
        $response = $this->get(route('demo.admin-login'));

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }
}
