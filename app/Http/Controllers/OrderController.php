<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\OrderStoreRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf as PDF; 

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        if(auth()->user()->hasRole('Admin')){

            $orders = Order::with('items.product')->orderBy('created_at', 'desc')->get();

        }else{
           $orders = Order::with('items.product')->where('user_id',auth()->user()->id)->orderBy('created_at', 'desc')->get(); 
        }
        
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $products = Product::where('quantity', '>', 0)->get(); // Only show products in stock
        return view('orders.create', compact('products'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(OrderStoreRequest $request)
    {
        $selectedProductIds = [];
        foreach ($request->products as $index => $item) {
            $productId = $item['id'];
            if (in_array($productId, $selectedProductIds)) {
               
                throw ValidationException::withMessages([
                    "products.{$index}.id" => "This product has been selected multiple times."
                ])->redirectTo(route('orders.create')); // Redirect back to form
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

                // Decrease product stock
                $product->decrement('quantity', $item['quantity']);
            }

            $order = Order::create([
                'user_id' => Auth::id(), 
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'status' => 'completed', // Completed status
                'total_amount' => $totalAmount,
            ]);

            $order->items()->createMany($orderItemsData); 

            DB::commit();
            // return redirect()->route('orders.show', $order->id)->with('success', 'Order created successfully!');
            return redirect()->route('orders.index')->with('success', 'Order created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['order_creation_error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load('items.product'); 
        return view('orders.show', compact('order'));
    }

    public function orderPdf(Order $order)
    {

        try{
            $reportHtml = view('pdf.order',compact('order'))->render();

             $pdf = PDF::loadHTML($reportHtml);
             
             
             return $pdf->download('order.pdf');

            } catch(\Exception $e) {
                            
                return redirect()->back()->withInput()->withErrors(['order_creation_error' => $e->getMessage()]);
            }

    }

}