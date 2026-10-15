<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    protected function getAdminUser(): User
    {
        return User::firstOrCreate(
            ['email' => 'admin@jordan.com'],
            [
                'name' => 'Jordan Admin',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]
        );
    }

    public function test_unauthenticated_user_cannot_access_admin_dashboard_and_is_redirected_to_admin_login(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_non_admin_user_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->make([
            'is_admin' => false,
        ]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertForbidden();
    }

    public function test_admin_user_can_login_via_admin_login_page(): void
    {
        $admin = $this->getAdminUser();

        $response = $this->post(route('admin.login.submit'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_admin_can_view_dashboard_metrics(): void
    {
        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('مؤشرات الأداء والمبيعات الحية');
        $response->assertViewHas(['totalOrders', 'totalRevenue', 'recentOrders', 'topProducts']);
    }

    public function test_admin_can_view_and_filter_orders(): void
    {
        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->get(route('admin.orders.index'));

        $response->assertOk();
        $response->assertViewHas('orders');

        $filtered = $this->actingAs($admin)->get(route('admin.orders.index', ['status' => 'pending']));
        $filtered->assertOk();
    }

    public function test_admin_can_view_order_details_and_invoice(): void
    {
        $admin = $this->getAdminUser();
        $order = Order::query()->first();
        $this->assertNotNull($order);

        $showResponse = $this->actingAs($admin)->get(route('admin.orders.show', $order));
        $showResponse->assertOk();
        $showResponse->assertSee($order->order_number);

        $invoiceResponse = $this->actingAs($admin)->get(route('admin.orders.invoice', $order));
        $invoiceResponse->assertOk();
        $invoiceResponse->assertSee($order->order_number);
    }

    public function test_admin_can_update_order_status(): void
    {
        $admin = $this->getAdminUser();
        $order = Order::query()->first();
        $this->assertNotNull($order);

        $response = $this->actingAs($admin)->patch(route('admin.orders.update-status', $order), [
            'status' => 'processing',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'processing',
        ]);
    }

    public function test_admin_can_view_products_and_categories_and_customers(): void
    {
        $admin = $this->getAdminUser();

        $products = $this->actingAs($admin)->get(route('admin.products.index'));
        $products->assertOk();

        $categories = $this->actingAs($admin)->get(route('admin.categories.index'));
        $categories->assertOk();

        $customers = $this->actingAs($admin)->get(route('admin.customers.index'));
        $customers->assertOk();
    }
}
