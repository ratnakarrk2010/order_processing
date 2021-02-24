@include('common.header')
@include('common.sidebar')
<script src="{!! asset('js/dashboard/dashboard.js') !!}"></script>
<main class="app-layout-content" id="app-layout-content">

<!-- Page Content -->
<div class="container-fluid p-y-md">
    <!-- Stats -->
    <div class="row">
        
        <div class="col-sm-6 col-lg-4">
        @if(Session::get("loggedInUserRole") == 1 || Session::get("loggedInUserRole") == 7)
            <a class="card bg-blue bg-inverse" href="javascript:void(0)" id="clientMaster" >
            <div class="card-block clearfix">
                    <div class="pull-right">
                        <p class="h6 text-muted m-t-0 m-b-xs">Client Master</p>
                        <p class="h3 m-t-sm m-b-0">{{ $allcustomers}}</p>
                    </div>
                    <div class="pull-left m-r">
                        <span class="img-avatar img-avatar-48 bg-gray-light-o"><i class="ion-ios-people	fa-1-5x"></i></span>
                    </div>
                </div>
            </a>
        @else
            <a class="card bg-blue bg-inverse" href="javascript:void(0)" id="" >
                <div class="card-block clearfix">
                    <div class="pull-right">
                        <p class="h6 text-muted m-t-0 m-b-xs">Client Master</p>
                        <p class="h3 m-t-sm m-b-0">{{ $allcustomers}}</p>
                    </div>
                    <div class="pull-left m-r">
                        <span class="img-avatar img-avatar-48 bg-gray-light-o"><i class="ion-ios-people	fa-1-5x"></i></span>
                    </div>
                </div>
            </a>
        @endif
        </div>
        <!-- .col-sm-6 -->
        <div class="col-sm-6 col-lg-4">
        @if(Session::get("loggedInUserRole") == 1 || Session::get("loggedInUserRole") == 7)
            <a class="card" href="javascript:void(0)" id="orderList">
            <div class="card-block clearfix">
                    <div class="pull-right">
                        <p class="h6 text-muted m-t-0 m-b-xs">Total Orders(Per Finantial Year)</p>
                        <p class="h3 text-blue m-t-sm m-b-0">{{ $allorders }}</p>
                    </div>
                    <div class="pull-left m-r">
                        <span class="img-avatar img-avatar-48 bg-blue bg-inverse"><i class="ion-ios-bell fa-1-5x"></i></span>
                    </div>
                </div>
            </a>
        @else 
        <a class="card" href="javascript:void(0)">
                <div class="card-block clearfix">
                    <div class="pull-right">
                        <p class="h6 text-muted m-t-0 m-b-xs">Total Orders(Per Finantial Year)</p>
                        <p class="h3 text-blue m-t-sm m-b-0">{{ $allorders }}</p>
                    </div>
                    <div class="pull-left m-r">
                        <span class="img-avatar img-avatar-48 bg-blue bg-inverse"><i class="ion-ios-bell fa-1-5x"></i></span>
                    </div>
                </div>
            </a>
        @endif
        </div>
        <!-- .col-sm-6 -->
        <div class="col-sm-6 col-lg-4">
        @if(Session::get("loggedInUserRole") == 1 || Session::get("loggedInUserRole") == 7)
            <a class="card bg-purple bg-inverse" href="javascript:void(0)" id="pendingOrderList">
            <div class="card-block clearfix">
                    <div class="pull-right">
                        <p class="h6 text-muted m-t-0 m-b-xs">Pending Orders</p>
                        <p class="h3 m-t-sm m-b-0">{{ $allPendingOrders }}</p>
                    </div>
                    <div class="pull-left m-r">
                        <span class="img-avatar img-avatar-48 bg-gray-light-o"><i class="ion-ios-email fa-1-5x"></i></span>
                    </div>
                </div>
            </a>
        @else
            <a class="card bg-purple bg-inverse" href="javascript:void(0)">
                <div class="card-block clearfix">
                    <div class="pull-right">
                        <p class="h6 text-muted m-t-0 m-b-xs">Pending Orders</p>
                        <p class="h3 m-t-sm m-b-0">{{ $allPendingOrders }}</p>
                    </div>
                    <div class="pull-left m-r">
                        <span class="img-avatar img-avatar-48 bg-gray-light-o"><i class="ion-ios-email fa-1-5x"></i></span>
                    </div>
                </div>
            </a>
            @endif
        </div>
        <!-- .col-sm-6 -->
    </div>
    <!-- .row -->
    <!-- End stats -->
    <!--Display customer List-->
    <div class="card" id="displayCustomerList">
            <div class="card-header">
                <h4>Customer List</h4>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-sm-10"></div>
                    
                    <div class="col-sm-2">
                     <a href="{{ url('/customer_export/excel')}}" class="btn btn-app btn_export"><i class="fa fa-file-excel-o"></i>&nbsp;Export</a>

                    </div>
                </div><br>
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
                <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter" id="customerTable">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Name</th>
                            <th>Customer&nbsp;Type</th>
                            <th class="">Email</th>
                            <th class="">Address</th>
                            <th class="">Person1</th>
                            <th class="">Contact1</th>
                                                                               
                            <th style="width: 10%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($customerList as $customer)
                    <input type="hidden" value="{{$customer->id}}" name="id" id="customerId{{$loop->index}}">
                        <tr>
                            <td class="text-center">{{$loop->index + 1}}</td>
                            <td class="">{{$customer->client_name}}</td>
                            <td class="">{{$customer->type_of_customer}}</td>
                            <td class="">{{$customer->email_id}}</td>
                            <td class="">{{$customer->address}}</td>
                            <td class="">{{$customer->contact1}}</td>
                            <td class="">{{$customer->contact_person1}}</td>
                          
                            <td class="text-center">
                                <div class="">
                                   
                                    <a href="{{ url('/customer/edit/'.$customer->id) }}" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" title="Edit Customer"><i class="ion-edit"></i></a>                                    
                                    <button class="btn btn-xs btn-danger btnRemoveCustomer" type="button" data-toggle="tooltip" title="Remove Customer" customer-id="{{ $customer->id }}"><i class="ion-close"></i></button>
									
                                </div>
                            </td>
                        </tr>
                     @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            <!-- .card-block -->
        </div>
        <!-- .card -->
    <!--End Customer List-->
    <!-- Dynamic Table Order List Full -->
    <div class="card" id="displayOrderList">
            <div class="card-header">
                <h4>Order List</h4>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-sm-10"></div>
                    
                    <div class="col-sm-2">
                     <a href="{{url('/order_export/excel')}}" class="btn btn-app btn_export"><i class="fa fa-file-excel-o"></i>&nbsp;Export</a>

                    </div>
                </div><br>
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
                <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter" id="orderId">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Client&nbsp;Name</th>
                            <th>OPF&nbsp;No</th>
                            <th>OPF&nbsp;Date</th>
                            <th>PO&nbsp;No</th>
							<th>Address</th>
                            <th>Approved&nbsp;By</th> 
                                                         
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orderList as $order)
                    <input type="hidden" value="{{$order->id}}" name="id" id="orderId{{$loop->index}}">
                        <tr>
                            <td class="text-center">{{$loop->index + 1}}</td>
                            <td class="">{{$order->client_name}}</td>
                            <td class="">{{$order->opf_no}}</td>
                            <td class="">{{$order->opf_date}}</td>
                            <td class="">{{$order->po_no}}</td>
							<td class="">{{$order->installation_address}}</td>
                            <td class="">{{$order->approved_by}}</td>
                           
                            <td class="text-center">
                                <div class="">
                                   
                                    <a href="{{ url('/order/edit/'.$order->id) }}" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" title="Edit Order"><i class="ion-edit"></i></a>                                    
                                    <button class="btn btn-xs btn-danger btnRemoveOrder" type="button" data-toggle="tooltip" title="Remove Order" order-id="{{ $order->id }}"><i class="ion-close"></i></button>
                                    <a href="{{ url('/order/details/'.$order->id) }}"  class="btn btn-xs btn-primary" type="button" data-toggle="tooltip" title="View Details"><i class="ion-eye"></i></a>
									 <a href="{{ url('/download/pdf/'.$order->id) }}"  class="btn btn-xs btn-danger" type="button" data-toggle="tooltip" title="PDF"><i class="fa fa-file-pdf-o"></i></a>
                                </div>
                            </td>
                        </tr>
                     @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            <!-- .card-block -->
        </div>
        <!-- .card -->
         <!-- End Dynamic Table Order List Full -->
        <!-- Dynamic Table Order List Full -->
        <div class="card" id="displayPendingOrderList">
            <div class="card-header">
                <h4>Pending Order List</h4>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-sm-10"></div>
                    
                    <div class="col-sm-2">
                     <a href="{{url('/order_export/excel')}}" class="btn btn-app btn_export"><i class="fa fa-file-excel-o"></i>&nbsp;Export</a>

                    </div>
                </div><br>
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
                <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter" id="orderId">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Client&nbsp;Name</th>
                            <th>OPF&nbsp;No</th>
                            <th>OPF&nbsp;Date</th>
                            <th>PO&nbsp;No</th>
							<th>Address</th>
                            <th>Approved&nbsp;By</th> 
                                                         
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($pendinOrderList as $pendingOrder)
                    <input type="hidden" value="{{$pendingOrder->id}}" name="id" id="pendingOrderId{{$loop->index}}">
                        <tr>
                            <td class="text-center">{{$loop->index + 1}}</td>
                            <td class="hidden-xs">{{$pendingOrder->client_name}}</td>
                            <td class="">{{$pendingOrder->opf_no}}</td>
                            <td class="">{{$pendingOrder->opf_date}}</td>
                            <td class="">{{$pendingOrder->po_no}}</td>
						   <td class="">{{$pendingOrder->installation_address}}</td>
                            <td class="">{{$pendingOrder->approved_by}}</td>
                           
                            <td class="text-center">
                                <div class="">
                                   
                                    <a href="{{ url('/order/edit/'.$pendingOrder->id) }}" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" title="Edit Order"><i class="ion-edit"></i></a>                                    
                                    <button class="btn btn-xs btn-danger btnRemoveOrder" type="button" data-toggle="tooltip" title="Remove Order" order-id="{{ $pendingOrder->id }}"><i class="ion-close"></i></button>
                                    <a href="{{ url('/order/details/'.$pendingOrder->id) }}"  class="btn btn-xs btn-primary" type="button" data-toggle="tooltip" title="View Details"><i class="ion-eye"></i></a>
                                </div>
                            </td>
                        </tr>
                     @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            <!-- .card-block -->
        </div>
        <!-- .card -->
         <!-- End Dynamic Table Order List Full -->

    <!-- .row -->
</div>
<!-- .container-fluid -->
<!-- End Page Content -->

</main>

@include('common.footer')