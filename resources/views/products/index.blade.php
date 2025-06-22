@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Inventory Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
          
            <div class="card mb-4">
            
                <div class="card-header pb-0 p-3">
                                <div class="row">
                                    <div class="col-6 d-flex align-items-center">
                                        <h6 class="mb-0">Product Listing</h6>
                                    </div>
                                    <div class="col-6 text-end">
                                        <a class="btn bg-gradient-dark mb-0" href="{{ route('products.create') }}"><i
                                                class="fas fa-plus"></i>&nbsp;&nbsp;Add New Product</a>
                                    </div>
                                </div>
                  </div>
                <div class="card-body px-0 pt-0 pb-2">
                <hr class="horizontal dark">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id ="table_format">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" scope="col">Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" scope="col">SKU
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" scope="col">Price
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" scope="col">Quantity
                                    </th>
                                   
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" data-orderable="false">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                @foreach($products  as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <!-- <div>
                                                <img src="./img/team-1.jpg" class="avatar me-3" alt="image">
                                            </div> -->
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{$product->id}}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{$product->name}}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{$product->sku }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">&#8377;{{ number_format($product->price, 2) }}</p>
                                    </td>

                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{$product->quantity}}</p>
                                    </td>
                                   
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                        <a href="{{route('products.edit',$product->id )}}"> <p class="text-sm font-weight-bold mb-0">Edit</p></a>
                                           

                                        <a href="#" onclick="event.preventDefault();
                                        if(confirm('Are you sure you want to delete this product')){ document.getElementById('delete-form{{$product->id}}').submit();}">

                                          <p class="text-sm font-weight-bold mb-0 ps-2">Delete</p>
                                      </a>



                                      <form method="POST" id="delete-form{{$product->id}}" action="{{route('products.destroy',$product->id)}}" style="display:none">
                                          @csrf
                                          @method('delete')

                                      </form>
                                        </div>
                                    </td>
                                    
                                    </tr>
                                    @endforeach
                                
                       
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')


<script>



$(document).ready(function() {
    var dataTable = $('#table_format').DataTable( {                                 
        "ordering": true,                 
        "info":     true,
        "lengthChange": false,
        "sDom":     'ltipr'
    } );

    // $("#filterbox").keyup(function() {
    //     dataTable.search(this.value).draw();
    // });    
});


</script>





@endpush

