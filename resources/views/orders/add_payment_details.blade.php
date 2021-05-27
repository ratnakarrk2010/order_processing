@include('common.header')
<script>
    let dataTable = null;
    let paymentList = [];
    let paymentCalc = {};
</script>
<script src="{!! asset('js/order/payment_form.js') !!}"></script>
<script src="{!! asset('js/order/order_form_validations.js') !!}"></script>
<script src="{!! asset('js/order/order.js') !!}"></script>

<style>
    /*.dataTables_filter { display: none; }*/
    .modal-content {
        /* 80% of window height 
        height: 80% !important;*/
    }
</style>

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
                        <th>Client&nbsp;Name</th>
                        <th class="">OPF&nbsp;No.</th>
                        <th class=" ">OPF&nbsp;Date</th>
                        <th class=" ">PO&nbsp;NO</th>
                        <!--<th class="">Installation Address</th>-->
                        <th>Order&nbsp;Status</th>
                        <th>Approved&nbsp;/Rejected&nbsp;By</th>  
                        <th style="width:15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderList as $order)
                    <input type="hidden" value="{{$order->id}}" name="id" id="orderId{{$loop->index}}">
                    <tr>
                        <td class="text-center">{{$loop->index+1}}</td>
                        <td class="">{{$order->client_name}}</td>
                        <td class="">{{$order->opf_no}}</td>
                        <td class="">{{date('d/m/Y', strtotime($order->opf_date))}}</td>
                        <!--<td class="">{{$order->installation_address}}</td>-->
                        <td class="">{{$order->po_no}}</td>
                        @if ($order->order_status == 0)
                        <td style="color:#337ab7;"><b>Pending</b></td>
                        @elseif ($order->order_status == 1)
                        <td style="color:#7dc855;"><b>Approved</b></td>
                        @elseif ($order->order_status == 2)
                        <td style="color:#fd5e5e;"><b>Rejected</b></td>
                        @endif
                        <td class="">{{$order->approved_by}}</td>
                        <td class="text-center">
                            <div class="">
                                @if($order->is_payment_done == false)
                                <input type="hidden" name="orderId[]" id="orderId{{$loop->index}}" value="{{$order->id}}">
                                <input type="hidden" name="totalPOValue[]" id="totalPOValue{{$loop->index}}" value="{{$order->total_po_value}}">
                                <input type="hidden" name="totalOrderAmount[]" id="totalOrderAmount{{$loop->index}}" value="{{$order->total_order_amount}}">
                                <input type="hidden" name="payment_terms[]" id="payment_terms{{$loop->index}}" value="{{$order->payment_terms}}">
                                <input type="hidden" name="invoice_no[]" id="invoice_no{{$loop->index}}" value="{{$order->invoice_no}}">
								<input type="hidden" name="orderTaxValue[]" id="orderTaxValue{{$loop->index}}" value="{{$order->tax_value}}">
                                <button class="btn btn-xs btn-success btn_payment_details" id="btnAddPaymentDetails{{$loop->index}}" loopIndex="{{$loop->index}}" type="button"><i class="ion-android-add-circle"></i></button> <!-- data-toggle="modal" data-target="#Payment_detail" -->
                                @endif
                                @if ($order->order_status != 1)
                                <a href="{{ url('/order/edit/'.$order->id) }}" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" title="Edit Order"><i class="ion-edit"></i></a>
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
    <div class="modal fade" id="Payment_detail" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top modal-lg">
            <div class="modal-content paymentModalCls ">
                <div class="card-header bg-green bg-inverse">
                    <h4>Payment detail</h4>
                    <ul class="card-actions">
                        <li>
                            <button id="btnClosePaymentModal" type="button"><i class="ion-close"></i></button> <!-- data-dismiss="modal" -->
                        </li>
                    </ul>
                </div>
                <div class="card-block">
                    <form class="form-horizontal m-t-sm" action="{{url('/submit/paymentdetails')}}" method="post" id="paymentDetailsFormID" name="paymentDetailsForm">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-3">
                                <div class="form-material">
                                    <input type="hidden" name="paymentDetailId" id="paymentDetailId" />
                                    <input class="form-control" type="text" id="invoice_no" name="invoice_no"/>
                                    <label for="invoice_no" class="required">Invoice Number</label>
                                    <div class="field-error" id="invoice_no_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-material">
                                    <input class="form-control" type="date" id="invoice_date" name="invoice_date"/>
                                    <label for="invoice_date" class="required">Invoice Date</label>
                                    <div class="field-error" id="invoice_date_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-material">
                                    <input type="hidden" name="paymentOrderId" id="paymentOrderId">
                                    <input type="hidden" name="totalPaymentToBeReceived" id="totalPaymentToBeReceived">
                                    <input type="hidden" name="totalPaymentReceived" id="totalPaymentReceived">
                                    <input class="form-control" type="text" id="payment_terms" name="payment_terms" placeholder="Plaese enter payment term" readonly/>
                                    <label for="payment_terms">Payment Terms</label>
                                </div>
                            </div>
                            <div class="col-sm-3">
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
                                    <input class="form-control" type="text" id="total_po_value" name="total_po_value" readonly />
                                    <label for="total_po_value">Total PO Value</label>
                                    <div class="field-error" id="total_po_value_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="tax_amount" name="tax_amount" readonly />
                                    <label for="tax_amount">Tax Amount</label>
                                    <div class="field-error" id="tax_amount_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="total_order_amount" name="total_order_amount" readonly/>
                                    <label for="total_order_amount" class="required">Total</label>
                                    <div class="field-error" id="total_order_amount_error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>
                                    <h4>By COURIER / HAND DELIVERY:</h4>
                                </legend>
                                <div class="col-sm-4">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="dc_no" name="dc_no" />
                                        <label for="dc_no" class="required">DC No</label>
                                        <div class="field-error" id="dc_no_error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-material">
                                        <input class="form-control" type="date" id="dc_date" name="dc_date" />
                                        <label for="dc_date" class="required">DC Date</label>
                                        <div class="field-error" id="dc_date_error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="product_serial_no" name="product_serial_no" />
                                        <label for="product_serial_no" class="required">Product Serial No.</label>
                                        <div class="field-error" id="product_serial_no_error"></div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group">
							 <div class="col-sm-1">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="taxValue" name="taxValue" readOnly/>
                                    <label for="amount_paid" class="">Tax Val(%)</label>
                                    <div class="field-error" id="tax_value_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="amount_paid" name="amount_paid" placeholder="Plaese enter amount paid" />
                                    <label for="amount_paid" class="required">Amount Paid</label>
                                    <div class="field-error" id="amount_paid_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="taxes" name="taxes" readonly />
                                    <label for="taxes">Tax Amount</label>
                                    <div class="field-error" id="taxes_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="payment_received" name="payment_received" placeholder="Plaese enter payment recived" readonly />
                                    <label for="payment_received" class="required">Total Payment Recived</label>
                                    <div class="field-error" id="payment_received_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="balance_payment" name="balance_payment" placeholder="Balance Payment" readonly />
                                    <label for="balance_payment" class="required">Balance Payment</label>
                                    <div class="field-error" id="balance_payment_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-material">
                                    <input class="form-control" type="date" id="payment_received_date" name="payment_received_date" placeholder="Plaese enter payment date" />
                                    <label for="payment_received_date" class="required">Payment Received Date</label>
                                    <div class="field-error" id="payment_received_date_error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8">
                                <div class="form-material">
                                    <textarea class="form-control" id="payment_remark" name="payment_remark" rows="1" placeholder="Please enter payement Remark" style="resize: none;"></textarea>
                                    <label for="payment_remark" class="">Payment Remark</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group m-b-0">
                            <div class="col-sm-4" id="btnSaveDiv">
                                <button class="btn btn-app" type="button" name="btnSubmit" id="btnSubmit">Submit</button>
                                <button class="btn btn-danger" type="button" name="btnCancelAddPayment" id="btnCancelAddPayment">Cancel</button>
                            </div>
                            <div class="col-sm-4" id="btnEditDiv">
                                <button class="btn btn-app" type="button" name="btnUpdate" id="btnUpdate">Update</button>
                                <button class="btn btn-danger" type="button" name="btnCancelEditPayment" id="btnCancelEditPayment">Cancel Edit</button>
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
                                            <th>Invoice Number</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Taxes</th>
                                            <th>Total</th>
                                            <th>Outstanding</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
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
        <div id="loader_payment">
            <img class="loading-img" src="{!! asset('img/ajax-loader.gif') !!}">
        </div>
    </div>
    <!-- End payment Modal -->

</main>
@include('common.footer')
