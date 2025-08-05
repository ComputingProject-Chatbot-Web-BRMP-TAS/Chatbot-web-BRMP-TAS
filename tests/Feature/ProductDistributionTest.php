<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\RegProvinces;
use App\Models\PlantTypes;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductDistributionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_product_distribution_page()
    {
        // Create admin user
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $response = $this->actingAs($admin)
            ->get('/ADMIN-BRMP-TAS/product-distribution');

        $response->assertStatus(200);
        $response->assertViewIs('admin.product_distribution');
    }

    public function test_product_distribution_shows_correct_data()
    {
        // Create admin user
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        // Create customer user
        $customer = User::factory()->create([
            'role' => 'customer'
        ]);

        // Create plant type
        $plantType = PlantTypes::create([
            'plant_type_name' => 'Padi',
            'comodity' => 'Tanaman Pemanis'
        ]);

        // Create province
        $province = RegProvinces::create([
            'id' => 31,
            'name' => 'DKI JAKARTA'
        ]);

        // Create product
        $product = Product::create([
            'product_name' => 'Benih Padi',
            'description' => 'Benih padi berkualitas tinggi',
            'price_per_unit' => 50000,
            'stock' => 100,
            'minimum_stock' => 10,
            'unit' => 'kg',
            'plant_type_id' => $plantType->plant_type_id
        ]);

        // Create address
        $address = Address::create([
            'user_id' => $customer->user_id,
            'label' => 'Rumah',
            'address' => 'Jl. Test No. 1',
            'latitude' => -6.2088,
            'longitude' => 106.8456,
            'is_primary' => true,
            'recipient_name' => 'Test User',
            'recipient_phone' => '08123456789'
        ]);

        // Create transaction
        $transaction = Transaction::create([
            'user_id' => $customer->user_id,
            'shipping_address_id' => $address->address_id,
            'recipient_name' => 'Test User',
            'recipient_phone' => '08123456789',
            'shipping_address' => 'Jl. Test No. 1',
            'province_id' => '31',
            'total_price' => 100000,
            'order_status' => 'completed',
            'delivery_method' => 'regular',
            'order_date' => now()
        ]);

        // Create transaction item
        TransactionItem::create([
            'transaction_id' => $transaction->transaction_id,
            'product_id' => $product->product_id,
            'quantity' => 2,
            'unit_price' => 50000,
            'subtotal' => 100000
        ]);

        $response = $this->actingAs($admin)
            ->get('/ADMIN-BRMP-TAS/product-distribution');

        $response->assertStatus(200);
        $response->assertViewHas('provinceData');
        $response->assertViewHas('provinceProducts');
    }

    public function test_product_distribution_excludes_cancelled_transactions()
    {
        // Create admin user
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        // Create customer user
        $customer = User::factory()->create([
            'role' => 'customer'
        ]);

        // Create plant type
        $plantType = PlantTypes::create([
            'plant_type_name' => 'Padi',
            'comodity' => 'Tanaman Pemanis'
        ]);

        // Create province
        $province = RegProvinces::create([
            'id' => 31,
            'name' => 'DKI JAKARTA'
        ]);

        // Create address
        $address = \App\Models\Address::create([
            'user_id' => $customer->user_id,
            'label' => 'Rumah',
            'address' => 'Jl. Test No. 1',
            'latitude' => -6.2088,
            'longitude' => 106.8456,
            'is_primary' => true,
            'recipient_name' => 'Test User',
            'recipient_phone' => '08123456789'
        ]);

        // Create product
        $product = Product::create([
            'product_name' => 'Benih Padi',
            'description' => 'Benih padi berkualitas tinggi',
            'price_per_unit' => 50000,
            'stock' => 100,
            'minimum_stock' => 10,
            'unit' => 'kg',
            'plant_type_id' => $plantType->plant_type_id
        ]);

        // Create cancelled transaction
        $cancelledTransaction = Transaction::create([
            'user_id' => $customer->user_id,
            'shipping_address_id' => $address->address_id,
            'recipient_name' => 'Test User',
            'recipient_phone' => '08123456789',
            'shipping_address' => 'Jl. Test No. 1',
            'province_id' => '31',
            'total_price' => 100000,
            'order_status' => 'cancelled',
            'delivery_method' => 'regular',
            'order_date' => now()
        ]);

        // Create transaction item for cancelled transaction
        TransactionItem::create([
            'transaction_id' => $cancelledTransaction->transaction_id,
            'product_id' => $product->product_id,
            'quantity' => 2,
            'unit_price' => 50000,
            'subtotal' => 100000
        ]);

        $response = $this->actingAs($admin)
            ->get('/ADMIN-BRMP-TAS/product-distribution');

        $response->assertStatus(200);
        
        // Get the view data
        $viewData = $response->viewData();
        
        // Assert that cancelled transactions are not included
        $this->assertEmpty($viewData['provinceData']);
    }

    public function test_non_admin_cannot_access_product_distribution()
    {
        // Create regular user
        $user = User::factory()->create([
            'role' => 'customer'
        ]);

        $response = $this->actingAs($user)
            ->get('/ADMIN-BRMP-TAS/product-distribution');

        $response->assertStatus(403);
    }
} 