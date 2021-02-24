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
                            <!--<th>PO&nbsp;Date</th>-->
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
                            <!--<td class="">{{$order->po_date}}</td>-->
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
        <!-- End Dynamic Table Full -->


    </div>
    <!-- .container-fluid -->
    <!-- End Page Content -->

</main>
@include('common.footer')