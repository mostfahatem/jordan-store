<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use Tests\TestCase;

class OrderSystemTest extends TestCase
{
    public function test_can_place_order_successfully(): void
    {
        $product = Product::query()->first();
        $this->assertNotNull($product);

        $payload = [
            'customer_name' => 'مصطفى حاتم',
            'customer_phone' => '01012345678',
            'customer_email' => 'mostafa@example.com',
            'governorate' => 'Cairo',
            'city' => 'المعادي',
            'shipping_address' => 'شارع 9، عمارة 12، الدور الرابع',
            'payment_method' => 'cod',
            'promo_code' => 'JORDAN20',
            'notes' => 'يرجى الاتصال قبل الوصول بنصف ساعة',
            'items' => [
                [
                    'id' => $product->id,
                    'name' => $product->name,
                    'size' => '42',
                    'price' => $product->price,
                    'quantity' => 1,
                    'color' => [
                        'name' => 'Chicago Red',
                        'hex' => '#dc2626',
                        'label' => 'شيكاغو أحمر',
                    ],
                    'image' => $product->image_url,
                ],
            ],
        ];

        $response = $this->postJson(route('checkout.store'), $payload);

        $response->assertOk()
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'order_number',
                'redirect_url',
                'order' => [
                    'id',
                    'order_number',
                    'status',
                    'total',
                ],
            ]);

        $orderNumber = $response->json('order_number');
        $this->assertStringStartsWith('JRD-', $orderNumber);

        $this->assertDatabaseHas('orders', [
            'order_number' => $orderNumber,
            'customer_name' => 'مصطفى حاتم',
            'customer_phone' => '01012345678',
            'payment_method' => 'cod',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'size' => '42',
        ]);
    }

    public function test_checkout_validation_fails_with_missing_required_fields(): void
    {
        $response = $this->postJson(route('checkout.store'), [
            'customer_name' => '',
            'items' => [],
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['customer_name', 'customer_phone', 'governorate', 'city', 'shipping_address', 'payment_method', 'items']);
    }

    public function test_order_confirmation_page_displays_order_details(): void
    {
        $order = Order::query()->first();
        $this->assertNotNull($order);

        $response = $this->get(route('orders.confirmation', $order->order_number));

        $response->assertOk();
        $response->assertSee($order->order_number);
        $response->assertSee($order->customer_name);
    }

    public function test_track_order_page_finds_order_by_number_and_phone(): void
    {
        $order = Order::query()->first();
        $this->assertNotNull($order);

        $response = $this->get(route('orders.track', [
            'q' => $order->order_number,
        ]));

        $response->assertOk();
        $response->assertSee($order->order_number);
        $response->assertSee($order->status_label);
    }

    public function test_track_order_page_shows_error_when_order_not_found(): void
    {
        $response = $this->get(route('orders.track', [
            'q' => 'JRD-999999',
        ]));

        $response->assertOk();
        $response->assertSee('لم نعثر على أي شحنة مطابقة للبيانات المدخلة');
    }
}
