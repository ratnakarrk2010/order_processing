@include('common.header')
<script src="{!! asset('js/order/order_form_validations.js') !!}"></script>
<script src="{!! asset('js/order/order.js') !!}"></script>
<script>
    $(function() {
        $("#orderId").DataTable({
            "autoWidth": false,
            "searching": true,
        });
    });
</script>
@include('common.sidebar')
<main class="app-layout-content" id="app-layout-content">

    <!-- Page Content -->
    <div class="container-fluid p-y-md">
        <!-- Dynamic Table Full -->
        <div class="card">
            <div class="card-header">
                <h4>Order List</h4>
            </div>
            <div class="card-block">
                <div class="row">
                                      
                    <div class="col-sm-12 topButtonClass">
                    <a href="{{ url('/add/order') }}" class="btn btn-app"><i class="ion-android-add-circle"></i>&nbsp;Add</a>
                     <a href="{{url('/order_export/excel')}}" class="btn btn-app"><i class="fa fa-file-excel-o"></i>&nbsp;Export</a>

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
                            <!--<th>PO&nbsp;Date</th>-->
                            <!--<th>Address</th>-->
                            <th>Order&nbsp;Status</th>
                            <th>Approved&nbsp;/Rejected&nbsp;By</th> 
                                                        
                            <th style="width:15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orderList as $order)
                    <input type="hidden" value="{{$order->id}}" name="id" id="orderId{{$loop->index}}">
                        @if ($order->order_status == 1)
                        <tr>
                        @elseif ($order->order_status == 2)
                        <tr>
                        @else
                        <tr>
                        @endif
                            <td class="text-center">{{$loop->index + 1}}</td>
                            <td class="">{{$order->client_name}}</td>
                            <td class="">{{$order->opf_no}}</td>
                            <td class="">{{date('d/m/Y', strtotime($order->opf_date))}}</td>
                            <td class="">{{$order->po_no}}</td>
                            <!--<td class="">{{$order->po_date}}</td>-->
                            <!--<td class="">{{$order->installation_address}}</td>-->
                            @if ($order->order_status == 1)
                            <td style="color:#7dc855;"><b>Approved</b></td>
                            @elseif ($order->order_status == 2)
                            <td style="color:#fd5e5e;"><b>Rejected</b></td>
                            @elseif ($order->order_status == 0)
                            <td style="color:#337ab7;"><b>Pending</b></td>
                            @else
                            @endif
                            <td class="">{{$order->approved_by}}</td>
                           
                            <td class="text-center">
                                <div class="">
                                    @if ($order->order_status != 1)
                                    <a href="{{ url('/order/edit/'.$order->id) }}" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" title="Edit Order"><i class="ion-edit"></i></a>                                  
                                    <button class="btn btn-xs btn-danger btnRemoveOrder" type="button" data-toggle="tooltip" title="Remove Order" order-id="{{ $order->id }}"><i class="ion-close"></i></button>
                                    @endif
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
        <!-- End Dynamic Table Full -->


    </div>
    <!-- .container-fluid -->
    <!-- End Page Content -->

</main>
@include('common.footer')