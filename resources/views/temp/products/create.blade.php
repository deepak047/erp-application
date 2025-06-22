@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Create Product'])
    <div class="row mt-4 mx-4">
        <!-- <div class="col-12"> -->
           
            <div class="card mb-4">
            
             
                   
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Create  Product</p>
                                <a class="btn btn-primary btn-sm ms-auto"  href="{{ route('products.index') }}"><i
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
                        <div class="card-body">
                        <form role="form" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                        @csrf
                            <p class="text-uppercase text-sm">Product Information</p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Product Name</label>
                                        <input class="form-control" type="text"  min="3" placeholder="Product Name" id="name" name="name" value="{{ old('name') }}" required >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Product SKU</label>
                                        <input class="form-control" type="text"  min="3" placeholder="Product SKU" id="sku" name="sku" value="{{ old('sku') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Price (INR)</label>
                                        <input class="form-control" type="number" min="1" step="0.01" placeholder="Price (INR)" id="price" name="price" value="{{ old('price') }}" required >
                                    </div>
                                </div>

                               
                            </div>
                            <hr class="horizontal dark">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Quantity</label>
                                        <input class="form-control" type="number"  placeholder="Product Quantity" id="quantity" name="quantity" min="1" value="{{ old('quantity') }}" required >
                                    </div>
                                </div>
                               

                               
                            </div>
                            <hr class="horizontal dark">
                        
                            <div class="row">
                               

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">Save</button>
                                </div>
                            </div>
                          </form>
                        </div>
                  
            
                </div>
            </div>
        <!-- </div> -->
    </div>
@endsection
