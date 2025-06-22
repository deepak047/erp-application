<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class SalesOrderApiController extends Controller
{
     public function store(Request $request)
    {
        
        try {
            $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
                'products' => 'required|array|min:1', 
                'products.*.id' => 'required|exists:products,id', 
                'products.*.quantity' => 'required|integer|min:1',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        }

       
        $selectedProductIds = [];
        foreach ($request->products as $index => $item) {
            $productId = $item['id'];
            if (in_array($productId, $selectedProductIds)) {
                return response()->json([
                    'message' => 'Validation error',
                    'errors' => ["products.{$index}.id" => "This product has been selected multiple times."]
                ], 422);
            }
            $selectedProductIds[] = $productId;
        }

      
        DB::beginTransaction();

        try {
            $totalAmount = 0;
            $orderItemsData = [];

          
            foreach ($request->products as $item) {
                $product = Product::find($item['id']);

               
                if (!$product) {
                    throw new \Exception("Product with ID {$item['id']} not found.");
                }

               
                if ($product->quantity < $item['quantity']) {
                    throw new \Exception("Not enough stock for product '{$product->name}'. Available: {$product->quantity}, Requested: {$item['quantity']}.");
                }

                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name, 
                    'product_sku' => $product->sku,   
                    'unit_price' => $product->price,  
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                    'created_at' => now(), 
                    'updated_at' => now(),
                ];

               
                $product->decrement('quantity', $item['quantity']);
            }

            
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'status' => 'completed', 
                'total_amount' => $totalAmount,
            ]);

           
            $order->items()->createMany($orderItemsData);

            
            DB::commit();

           
            $order->load('items.product');
            return response()->json([
                'message' => 'Sales order created successfully!',
                'order' => $order
            ], 201); 
        } catch (\Exception $e) {
            
            DB::rollBack();

           
            return response()->json([
                'message' => 'Failed to create sales order.',
                'error' => $e->getMessage()
            ], 500); 
        }
    }

    public function index()
    {
        $orders = Order::with('items.product')->orderBy('created_at', 'desc')->get();
        return response()->json($orders);
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return response()->json($order);
    }

   
  } 

