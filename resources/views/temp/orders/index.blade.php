@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Sales Orders'])
    <div class="row mt-4 mx-4">
        <div class="col-12">

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
          
            <div class="card mb-4">
            
                <div class="card-header pb-0 p-3">
                                <div class="row">
                                    <div class="col-6 d-flex align-items-center">
                                        <h6 class="mb-0">Sales Orders</h6>
                                    </div>
                                    <div class="col-6 text-end">
                                        <a class="btn bg-gradient-dark mb-0" href="{{ route('orders.create') }}"><i
                                                class="fas fa-plus"></i>&nbsp;&nbsp;Create New Order</a>
                                    </div>
                                </div>
                  </div>
                <div class="card-body px-0 pt-0 pb-2">
                <hr class="horizontal dark">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id ="table_format">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Order ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" scope="col">Customer Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" scope="col">Customer Email
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" scope="col">Total Amount
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" scope="col">Status
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" scope="col">Order Date
                                    </th>
                                     <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" data-orderable="false">
                                    PDF</th>
                                   
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" data-orderable="false">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                @foreach($orders  as $order)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <!-- <div>
                                                <img src="./img/team-1.jpg" class="avatar me-3" alt="image">
                                            </div> -->
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{$order->id}}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{$order->customer_name}}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{$order->customer_email }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">&#8377;{{ number_format($order->total_amount, 2) }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0"><span class="badge {{ $order->status == 'completed' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucfirst($order->status) }}</span></p>
                                    </td>

                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $order->created_at->format('M d, Y H:i A') }}</p>
                                    </td>
                                     <td class="align-middle text-end">
                                    <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                        <a href="{{route('order.pdf',$order->id)}}" title="Download Order Pdf">
                                            <p class="text-sm font-weight-bold mb-0"><i class="ni ni-single-copy-04"></i></p>
                                        </a>
                                       
                                    </div>
                                </td>
                                   
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                        <a href="{{ route('orders.show', $order->id) }}"> <p class="text-sm font-weight-bold mb-0">View Details</p></a>
                                           

                                     
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

