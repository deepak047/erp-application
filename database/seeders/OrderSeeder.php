<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $users = User::all();
        $products = Product::all();

        
        if ($products->isEmpty()) {
            $this->command->info('No products found. Please run ProductSeeder first.');
            return;
        }

       
        $statuses = ['pending','completed'];

        // Create 10 dummy orders
        for ($i = 0; $i < 10; $i++) {
            DB::beginTransaction();
            try {
                $customerName = fake()->name();
                $customerEmail = fake()->unique()->safeEmail(); 
                $status = $statuses[array_rand($statuses)];
                $userId = $users->isNotEmpty() ? $users->random()->id : null; 

                $order = Order::create([
                    'user_id' => $userId,
                    'customer_name' => $customerName,
                    'customer_email' => $customerEmail,
                    'status' => $status,
                    'total_amount' => 0, 
                ]);

                $orderTotal = 0;
                $numItems = rand(1, 5); 
                $selectedProductIds = []; 

                for ($j = 0; $j < $numItems; $j++) {
                    $product = null;
                    $attempts = 0;
                   
                    do {
                        $product = $products->random();
                        $attempts++;
                    } while (in_array($product->id, $selectedProductIds) && $attempts < 10); 

                    
                    if (in_array($product->id, $selectedProductIds)) {
                        continue;
                    }

                    $selectedProductIds[] = $product->id; 

                    $quantity = rand(1, 3); 
                    $unitPrice = $product->price;
                    $subtotal = $unitPrice * $quantity;
                    $orderTotal += $subtotal;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_sku' => $product->sku,
                        'unit_price' => $unitPrice,
                        'quantity' => $quantity,
                        'subtotal' => $subtotal,
                    ]);

                   
                }

              
                $order->update(['total_amount' => $orderTotal]);

                DB::commit();
                $this->command->info("Order #{$order->id} created for {$customerName} with total {$orderTotal}.");

            } catch (\Exception $e) {
                DB::rollBack();
                $this->command->error("Error creating order: " . $e->getMessage());
            }
        }
    }
}