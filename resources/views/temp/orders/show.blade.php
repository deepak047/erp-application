@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'View Order'])
    <div class="row mt-4 mx-4">
        <!-- <div class="col-12"> -->
           
            <div class="card mb-4">
            
             
                   
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Order Details - #{{ $order->id }}</p>
                                <a class="btn btn-primary btn-sm ms-auto"  href="{{ route('orders.index') }}"><i
                                            ></i>&nbsp;&nbsp;Back</a>
                            
                            </div>
                        </div>
                        
                      
                        <div class="card-body">
                        <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
                        <p><strong>Customer Email:</strong> {{ $order->customer_email }}</p>
                        <p><strong>Order Status:</strong> <span class="badge {{ $order->status == 'completed' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucfirst($order->status) }}</span></p>
                        <p><strong>Total Amount:</strong> &#8377;{{ number_format($order->total_amount, 2) }}</p>
                        <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i A') }}</p>
                        @if ($order->user)
                            <p><strong>Placed By User:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
                        @endif
                        </div>

                        <div class="card">
                            <div class="card-header">
                                Order Items
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>SKU</th>
                                            <th>Unit Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($order->items as $item)
                                            <tr>
                                                <td>{{ $item->product_name }}</td>
                                                <td>{{ $item->product_sku }}</td>
                                                <td>&#8377;{{ number_format($item->unit_price, 2) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>&#8377;{{ number_format($item->subtotal, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No items in this order.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                  
            
                </div>
            </div>
        <!-- </div> -->
    </div>
@endsection
