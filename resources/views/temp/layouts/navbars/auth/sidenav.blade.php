<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('home') }}" target="_blank">
            <!-- <img src="./img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo"> -->
            <span class="ms-1 font-weight-bold">ERP Application</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        @if(auth()->check())
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-3 d-flex align-items-center">
                <!-- <div class="ps-4">
                    <i class="fab fa-laravel" style="color: #f4645f;"></i>
                </div> -->
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0"></h6>
            </li>

          

            @if (auth()->user()->hasRole('Admin'))
          
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'products') == true ? 'active' : '' }}" href="{{ route('products.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-building text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Inventory Management</span>
                </a>
            </li>
           
            @endif
          

            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'orders') == true ? 'active' : '' }}" href="{{ route('orders.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-money-coins text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sales Orders</span>
                </a>
            </li>

         

          
      
        </ul>
        @endif
    </div>
  
</aside>
