@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid py-4">
        <div class="row">
     
            @php
            if(auth()->user()->hasRole('Admin')){
             $order = App\Models\Order::where('status','completed')->get();
            }else{
             $order = App\Models\Order::where('user_id',auth()->user()->id)->where('status','completed')->get();
            }
            
            @endphp
            @if($order)
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Orders</p>
                                    <h5 class="font-weight-bolder">
                                        {{$order->count()}}
                                    </h5>
                                   <!--  <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">+3%</span>
                                        since last week
                                    </p> -->
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
         
            
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Sales</p>
                                    <h5 class="font-weight-bolder">
                                        ₹{{$order->sum('total_amount')}}
                                    </h5>
                                   <!--  <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">+5%</span> than last month
                                    </p> -->
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif 
        </div>

        <div class="row mt-4">
           
            <!-- <div class="col-lg-5">
                <div class="card card-carousel overflow-hidden h-100 p-0"> -->
                    <!-- <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel"> -->
                        <!-- <div class="carousel-inner border-radius-lg h-100"> -->
                            <!-- <div class="carousel-item h-100 active" style="background-image: url('./img/carousel-1.jpg');
            background-size: cover;">
                                <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                    <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                        <i class="ni ni-camera-compact text-dark opacity-10"></i>
                                    </div>
                                    <h5 class="text-white mb-1">Get started with Argon</h5>
                                    <p>There’s nothing I really wanted to do in life that I wasn’t able to get good at.</p>
                                </div>
                            </div> -->
                            <!-- <div class="carousel-item h-100" style="background-image: url('./img/carousel-2.jpg');
            background-size: cover;">
                                <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                    <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                        <i class="ni ni-bulb-61 text-dark opacity-10"></i>
                                    </div>
                                    <h5 class="text-white mb-1">Faster way to create web pages</h5>
                                    <p>That’s my skill. I’m not really specifically talented at anything except for the
                                        ability to learn.</p>
                                </div>
                            </div> -->
                            <!-- <div class="carousel-item h-100" style="background-image: url('./img/carousel-3.jpg');
            background-size: cover;">
                                <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                    <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                        <i class="ni ni-trophy text-dark opacity-10"></i>
                                    </div>
                                    <h5 class="text-white mb-1">Share with us your design tips!</h5>
                                    <p>Don’t be afraid to be wrong because you can’t learn anything from a compliment.</p>
                                </div>
                            </div> -->
                        <!-- </div> -->
                        <!-- <button class="carousel-control-prev w-5 me-3" type="button"
                            data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next w-5 me-3" type="button"
                            data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div> -->
                <!-- </div>
            </div> -->
        <!-- </div> -->
        <div class="row mt-4">
             @if(auth()->user()->hasRole('Admin'))
              @php
            $products = App\Models\Product::where('quantity', '<=', 10)->get();
            @endphp
            @if($products->count() > 0)
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Low stock alerts</h6>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            @foreach($products  as $product)
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                        <i class="ni ni-mobile-button text-white opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">{{$product->name}}</h6>
                                        <span class="text-xs">{{$product->quantity}} in stock</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <a
                                        class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto" href="{{ route('products.index') }}"><i
                                            class="ni ni-bold-right" aria-hidden="true"></i></a>
                                </div>
                            </li>
                            @endforeach
                          
                           
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            @endif
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection



