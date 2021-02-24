@include('common.header')
<script>
    let dataTable = null;
</script>
<script src="{!! asset('js/order/payment_form.js') !!}"></script>
<script src="{!! asset('js/order/order_form_validations.js') !!}"></script>
<script src="{!! asset('js/order/order.js') !!}"></script>

@include('common.sidebar')
<main class="app-layout-content" id="app-layout-content">

<!-- Page Content -->
<div class="container-fluid p-y-md">
    <!-- Dynamic Table Full -->
    <div class="card">
        <div class="card-header">
            <h4>Fill Payment Details</h4>
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
            <table class="table table-bordered table-striped table-vcenter" id="paymentTable">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Client Name</th>
                        <th class="">OPF No.</th>
                        <th class="">OPF Date</th>
                        <th class="">Installation Address</th>
                        <th class="">Approved By</th> 
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderList as $order)
                    <input type="hidden" value="{{$order->id}}" name="id" id="orderId{{$loop->index}}">
                    <tr>
                        <td class="text-center">{{$loop->index+1}}</td>
                        <td class="">{{$order->client_name}}</td>
                        <td class="">{{$order->opf_no}}</td>
                        <td class="">{{$order->opf_date}}</td>
                        <td class="">{{$order->installation_address}}</td>
                        <td class="">{{$order->approved_by}}</td>
                        <td class="text-center">
                            <div class="">
                                @if($order->is_payment_done == false)
                                <input type="hidden" name="orderId[]" id="orderId{{$loop->index}}" value="{{$order->id}}">
                                <input type="hidden" name="totalPOValue[]" id="totalPOValue{{$loop->index}}" value="{{$order->total_po_value}}">
                                <input type="hidden" name="payment_terms[]" id="payment_terms{{$loop->index}}" value="{{$order->payment_terms}}">
                                <input type="hidden" name="invoice_no[]" id="invoice_no{{$loop->index}}" value="{{$order->invoice_no}}">
                                <button class="btn btn-xs btn-success btn_payment_details" id="btnAddPaymentDetails{{$loop->index}}" loopIndex="{{$loop->index}}" type="button"><i class="ion-android-add-circle"></i></button> <!-- data-toggle="modal" data-target="#Payment_detail" -->
                                @endif
                                <a href="{{ url('/order/details/'.$order->id) }}" class="btn btn-xs btn-primary" type="button" data-toggle="tooltip" title="View Details"><i class="ion-eye"></i></a>
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


    <!-- payment Modal -->
    <div class="modal fade" id="Payment_detail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top modal-lg">
            <div class="modal-content ">
                <div class="card-header bg-green bg-inverse">
                    <h4>Payment detail</h4>
                    <ul class="card-actions">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="ion-close"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="card-block">
                    <form class="form-horizontal m-t-sm" action="{{url('/submit/paymentdetails')}}" method="post" id="paymentDetailsFormID" name="paymentDetailsForm">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="invoice_no" name="invoice_no" readonly/>
                                    <label for="invoice_no">Invoice Number</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input type="hidden" name="paymentOrderId" id="paymentOrderId">
                                    <input type="hidden" name="totalPaymentToBeReceived" id="totalPaymentToBeReceived">
                                    <input type="hidden" name="totalPaymentReceived" id="totalPaymentReceived">
                                    <input class="form-control" type="text" id="payment_terms" name="payment_terms" placeholder="Plaese enter payment term" readonly/>
                                    <label for="payment_terms">Payment Terms</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="os_days" name="os_days" placeholder="Please enter outstanding days">
                                    <label for="os_days" class="required">OS Days</label>
                                    <div class="field-error" id="os_days_error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="payment_received" name="payment_received" placeholder="Plaese enter payment recived" />
                                    <label for="payment_received" class="required">Payment Recived</label>
                                    <div class="field-error" id="payment_received_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="balance_payment" name="balance_payment" placeholder="Balance Payment" readonly />
                                    <label for="balance_payment" class="required">Balance Payment</label>
                                    <div class="field-error" id="balance_payment_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="date" id="payment_received_date" name="payment_received_date" placeholder="Plaese enter payment date" />
                                    <label for="payment_received_date" class="required">Payment Received Date</label>
                                    <div class="field-error" id="payment_received_date_error"></div>

                                </div>
                            </div>

                        </div>
                        

                        <div class="form-group m-b-0">
                            <div class="col-sm-9">
                                <button class="btn btn-app" type="button" name="btnSubmit" id="btnSubmit">Submit</button>
                            </div>
                        </div>

                    </form>

                    <!-- closing of form -->
                    <div class="row" style="margin-top: 2%;">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-vcenter js-dataTable-full" id="orderPaymentDetailsTable">
                                    <thead>
                                        <tr>
                                            <th>Payment Recived</th>
                                            <th>Date</th>
                                            <th>Balance Payment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- closing of card here -->

            </div>
        </div>
    </div>
    <!-- End payment Modal -->

</main>
@include('common.footer')
