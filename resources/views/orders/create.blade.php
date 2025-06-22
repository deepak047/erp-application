@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Create New Sales Order'])
    <div class="row mt-4 mx-4">
        <!-- <div class="col-12"> -->
           
            <div class="card mb-4">
            
             
                   
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Create New Sales Order</p>
                                <a class="btn btn-primary btn-sm ms-auto"  href="{{ route('orders.index') }}"><i
                                            ></i>&nbsp;&nbsp;Back</a>
                            
                            </div>
                        </div>
                          @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('order_creation_error'))
                            <div class="alert alert-danger">
                                {{ session('order_creation_error') }}
                            </div>
                        @endif
                        <div class="card-body">
                        <form role="form" method="POST" action="{{ route('orders.store') }}" enctype="multipart/form-data">
                        @csrf
                            <p class="text-uppercase text-sm">Order Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Customer Name</label>
                                        <input class="form-control" type="text"  min="3" placeholder="Customer Name" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Customer Email</label>
                                        <input class="form-control" type="text"  min="3" placeholder="Customer Email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required>
                                    </div>
                                </div>

                              

                               
                            </div>
                            <hr class="horizontal dark">
                            <h3>Order Items</h3>
                            <div class="row">
                                <div id="product-items">
                                    
                                    @if (old('products'))
                                        @foreach (old('products') as $index => $oldItem)
                                            <div class="row mb-3 product-item" data-index="{{ $index }}">
                                                <div class="col-md-6">
                                                    <label for="product_id_{{ $index }}" class="form-label">Product</label>
                                                    <select class="form-select product-select" id="product_id_{{ $index }}" name="products[{{ $index }}][id]" required>
                                                        <option value="">Select a Product</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->quantity }}" {{ $product->id == $oldItem['id'] ? 'selected' : '' }}>
                                                                {{ $product->name }} (SKU: {{ $product->sku }}, Price: &#8377;{{ number_format($product->price, 2) }}, Stock: {{ $product->quantity }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback product-stock-error" style="display:none;"></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="quantity_{{ $index }}" class="form-label">Quantity</label>
                                                    <input type="number" class="form-control item-quantity" id="quantity_{{ $index }}" name="products[{{ $index }}][quantity]" value="{{ old('products.'.$index.'.quantity') }}" min="1" required>
                                                </div>
                                                <div class="col-md-2 d-flex align-items-end">
                                                    <button type="button" class="btn btn-danger remove-item-btn">Remove</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        
                                        <div class="row mb-3 product-item" data-index="0">
                                            <div class="col-md-6">
                                                <label for="product_id_0" class="form-label">Product</label>
                                                <select class="form-select product-select" id="product_id_0" name="products[0][id]" required>
                                                    <option value="">Select a Product</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->quantity }}">
                                                            {{ $product->name }} (SKU: {{ $product->sku }}, Price: &#8377;{{ number_format($product->price, 2) }}, Stock: {{ $product->quantity }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback product-stock-error" style="display:none;"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="quantity_0" class="form-label">Quantity</label>
                                                <input type="number" class="form-control item-quantity" id="quantity_0" name="products[0][quantity]" value="1" min="1" required>
                                            </div>
                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger remove-item-btn">Remove</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <button type="button" class="btn btn-secondary mb-3" id="add-product-btn">Add Another Product</button>

                                <div class="mb-3">
                                    <p><strong>Calculated Total: &#8377;<span id="calculated-total">0.00</span></strong></p>
                                </div>
                               

                               
                            </div>
                            <hr class="horizontal dark">
                        
                            <div class="row">
                               

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">Place Order</button>
                                </div>
                            </div>
                          </form>
                        </div>
                  
            
                </div>
            </div>
        <!-- </div> -->
    </div>
@endsection


@push('js')


 <script>
        document.addEventListener('DOMContentLoaded', function () {
            let itemIndex = document.querySelectorAll('.product-item').length;
            if (itemIndex === 0) { // If no old products, start with index 0
                itemIndex = 0;
            } else {
                // Find the highest existing index to ensure unique names
                let existingIndexes = Array.from(document.querySelectorAll('.product-item')).map(item => parseInt(item.dataset.index));
                itemIndex = Math.max(...existingIndexes) + 1;
            }

            const productItemsContainer = document.getElementById('product-items');
            const addProductBtn = document.getElementById('add-product-btn');
            const calculatedTotalSpan = document.getElementById('calculated-total');

            // Function to update the calculated total
            function updateCalculatedTotal() {
                let total = 0;
                document.querySelectorAll('.product-item').forEach(function(itemDiv) {
                    const selectElement = itemDiv.querySelector('.product-select');
                    const quantityElement = itemDiv.querySelector('.item-quantity');

                    const selectedOption = selectElement.options[selectElement.selectedIndex];
                    const price = parseFloat(selectedOption.dataset.price || 0);
                    const quantity = parseInt(quantityElement.value || 0);

                    total += price * quantity;
                });
                calculatedTotalSpan.textContent = total.toFixed(2);
            }

            // Function to check stock availability and update UI
            function checkStock(selectElement, quantityElement) {
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                const availableStock = parseInt(selectedOption.dataset.stock || 0);
                const requestedQuantity = parseInt(quantityElement.value || 0);
                const stockErrorDiv = selectElement.nextElementSibling; // The invalid-feedback div

                if (selectedOption.value && requestedQuantity > availableStock) {
                    quantityElement.classList.add('is-invalid');
                    stockErrorDiv.textContent = `Only ${availableStock} in stock.`;
                    stockErrorDiv.style.display = 'block';
                    return false;
                } else {
                    quantityElement.classList.remove('is-invalid');
                    stockErrorDiv.style.display = 'none';
                    return true;
                }
            }

            // Initial calculation on page load
            updateCalculatedTotal();
            document.querySelectorAll('.product-item').forEach(function(itemDiv) {
                const selectElement = itemDiv.querySelector('.product-select');
                const quantityElement = itemDiv.querySelector('.item-quantity');
                checkStock(selectElement, quantityElement);
            });


            // Add new product item
            addProductBtn.addEventListener('click', function () {
                const newIndex = itemIndex++;
                const newItemHtml = `
                    <div class="row mb-3 product-item" data-index="${newIndex}">
                        <div class="col-md-6">
                            <label for="product_id_${newIndex}" class="form-label">Product</label>
                            <select class="form-select product-select" id="product_id_${newIndex}" name="products[${newIndex}][id]" required>
                                <option value="">Select a Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->quantity }}">
                                        {{ $product->name }} (SKU: {{ $product->sku }}, Price: &#8377;{{ number_format($product->price, 2) }}, Stock: {{ $product->quantity }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback product-stock-error" style="display:none;"></div>
                        </div>
                        <div class="col-md-3">
                            <label for="quantity_${newIndex}" class="form-label">Quantity</label>
                            <input type="number" class="form-control item-quantity" id="quantity_${newIndex}" name="products[${newIndex}][quantity]" value="1" min="1" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-item-btn">Remove</button>
                        </div>
                    </div>
                `;
                productItemsContainer.insertAdjacentHTML('beforeend', newItemHtml);
            });

            // Event delegation for dynamically added elements
            productItemsContainer.addEventListener('change', function (event) {
                if (event.target.classList.contains('product-select')) {
                    const quantityElement = event.target.closest('.product-item').querySelector('.item-quantity');
                    checkStock(event.target, quantityElement); // Check stock when product changes
                    updateCalculatedTotal(); // Update total
                }
            });

            productItemsContainer.addEventListener('input', function (event) {
                if (event.target.classList.contains('item-quantity')) {
                    const selectElement = event.target.closest('.product-item').querySelector('.product-select');
                    checkStock(selectElement, event.target); // Check stock when quantity changes
                    updateCalculatedTotal(); // Update total
                }
            });

            productItemsContainer.addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-item-btn')) {
                    event.target.closest('.product-item').remove();
                    updateCalculatedTotal(); // Update total after removing item
                }
            });
        });
    </script>


@endpush
