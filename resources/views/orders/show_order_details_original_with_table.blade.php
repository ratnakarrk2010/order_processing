@include('common.header')
<script src="{!! asset('js/order/installation_form.js') !!}"></script>
@include('common.sidebar')
<style>
    .greyClass{
        background-color: #eeeeee38;
    }    
    

</style>
<main class="app-layout-content" id="app-layout-content">

<!-- Page Content -->
<div class="container-fluid p-y-md">
    <!-- Dynamic Table Full -->
    <div class="card">
        <div class="card-header">
            <h4><center>Order Processing Details</center></h4>
        </div>
        <div class="card-block">
               
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <div class="table-responsive">
            <table class="table table-bordered table-vcenter" id="installationTable">
               
                <tbody>
                    <tr>
                        <th class="greyClass">OPF No.</th>
                        @if(isset($orderDetails))
                        <td>{{ $orderDetails->opf_no}}</td>
                        <th class="greyClass">OPF Date</th>
                        <td>{{date('d/m/Y', strtotime($orderDetails->opf_date))}}</td>
                        <th class="greyClass">PO NO</th>
                        <td>{{ $orderDetails->po_no}}</td>
                      
                    </tr>
                    <tr>
                        <th class="greyClass">Client Name</th>
                        <td colspan="3">{{ $orderDetails->client_name}}</td>
                        <th class="greyClass">PO Date</th>
                        <td>{{date('d/m/Y', strtotime($orderDetails->po_date))}}</td>
                    </tr>
                    <tr>
                        <th class="greyClass">Address</th>
                        <td colspan="5">{{ $orderDetails->address}}</td>
                    </tr>
                    <tr>
                        <th class="greyClass" rowspan="{{sizeof($installationAddresses) + 1}}">Installation Address</th>
                    </tr>
                    @foreach ($installationAddresses as $installationAddress)
                    <tr>
                        <td colspan="5">{{ $installationAddress->installation_address}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th class="greyClass">Contact Persons</th>
                        <td colspan="3">{{ $orderDetails->contact_person1}}</td>
                        <td colspan="2">{{ $orderDetails->contact_person2}}</td>
                    </tr>     
                    <tr>
                        <th class="greyClass">Contact Numbers</th>
                        <td colspan="3">{{ $orderDetails->contact1}}</td>
                        <td colspan="2">{{ $orderDetails->contact2}} </td>
                    </tr>
                    <tr>
                        <th class="greyClass">Email Id</th>
                        <td colspan="5">{{ $orderDetails->email_id}}</td>
                    </tr>  
                    <tr>
                        <th class="greyClass">Order Collected By</th>
                        <td colspan="3">{{ $orderDetails->order_collected_by}}</td>
                        <th class="">Waranty Period</th>
                        <td>{{ $orderDetails->warranty_period}}</td>
                    </tr>   
                    <!--<tr>
                        <th class="greyClass">Payment Terms</th>
                        <td colspan="5">80% advance 20% against delivery </td>
                    </tr>
                    <tr>
                        <th class="greyClass">Payment Received</th>
                        <td colspan="5"></td>
                    </tr>-->
                    <tr class="greyClass">
                        <th>Sr.No</th>
                        <th colspan="2">Payment Terms</th>
                        <th>Payment Received</th>
                        <th>Balance Payment</th>
                        <th>Payment Received Date</th>
                        
                        <tbody>
                        @if(isset($paymentArr) && $paymentArr != null)
                            @foreach($paymentArr as $payment)
                                <tr>
                                    <td>{{ $payment->id}}</td>
                                    <td colspan="2">{{ $payment->payment_terms}}</td>
                                    <td>{{ $payment->payment_received}}</td>
                                    <td>{{ $payment->balance_payment}}</td>
                                    <td>{{ $payment->payment_received_date}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </tr> 
                    <tr>
                        <th class="greyClass">Invoice Number</th>
                        <td colspan="3">{{ $orderDetails->invoice_no}}</td>
                        <th class="greyClass">Invoice Date</th>
                        <td>{{ $orderDetails->invoice_date}}</td>
                    </tr>
                    <tr>
                        <th class="greyClass">Name & Signature of Sale Initiator</th>
                        <td colspan="3">{{ $orderDetails->sales_initiator_by}}</td>
                        <th class="greyClass">Approved & Accepted By</th>
                        <td>{{ $orderDetails->approved_by}}</td>
                    </tr>   
                    <tr>
                        <th class="greyClass">Total PO Value</th>
                        <td colspan="5">{{ $orderDetails->total_po_value}}</td>
                    </tr>
                    <tr>
                        <th colspan="6"class="greyClass"><center>This section to be enetered after receipt of Purchase Order</center></th>
                    </tr>
                    <tr>
                        <th class="greyClass"> Material  Procurement Date</th>
                        <td colspan="5">{{ $orderDetails->material_procurement_date}}</td>
                    </tr>
                    <tr>
                        <th class="greyClass">QC / In House Testing  results</th>
                        <td colspan="5">{{ $orderDetails->qc_testting_result}}</td>
                    </tr>
                    <tr>
                        <th class="greyClass">Dispatch Date</th>
                        <td colspan="1">{{ $orderDetails->dispatch_date}}</td>
                        <th colspan="4"class=""><center>By Courier / Hand Delivery</center></th>
                    </tr>
                    @endif  
                    <tr class="greyClass">
                        <th>Material</th>
                        <th>Quantity</th>
                        <th colspan="2">DC & Dt</th>
                        <th colspan="2">Product Serial No</th>
                        <tbody>
                        @if(isset($orderDetailsArr))
                            @foreach($orderDetailsArr as $orderDt)
                                <tr>
                                    <td>{{ $orderDt->materials}}</td>
                                    <td >{{ $orderDt->quantity}}</td>
                                    <td colspan="2">{{ $orderDt->dc_no}} , {{ $orderDt->dc_date}}</td>
                                    <td colspan="2">{{ $orderDt->product_serial_no}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </tr> 
                    @if(isset($installationDetailsArr) && $installationDetailsArr != null)
                    <tr>
                        <th class="greyClass">Installation Start Date</th>
                        <td colspan="">{{$installationDetailsArr->installation_start_date}}</td>
                        <th class="greyClass">Installation Completion Date</th>
                        <td>{{$installationDetailsArr->installation_completion_date}}</td>
                        <th class="greyClass">Completion Certificate collected on</th>
                        <td>{{$installationDetailsArr->installation_completion_date}}</td>
                    </tr> 
                    @endif
                    @if(isset($orderDetails))  
                    <tr>
                        <th class="greyClass">Remark if any</th>
                        <td colspan="5">{{ $orderDetails->remarks}}</td>
                    </tr>
                    <tr>
                        <th colspan="2" class="greyClass">Signature of Project Executive</th>
                        <td ></td>
                        <th colspan="3"><center><br>Signature of CS Manager</center></th>
                        
                    </tr> 
                    @endif 
                </tbody>
            </table>
            </div>
            <div class="row">
                <div class="col-sm-10"></div>
                
                <div class="col-sm-2">
                    <a href="{{ url('/all/orders')}}" class="btn btn-app btn-primary" style="float:right;"><i class="ion-android-arrow-back"></i>&nbsp;Back</a>
                </div>
            </div>
        </div>
        <!-- .card-block -->
    </div>
    <!-- .card -->
    <!-- End Dynamic Table Full -->


</div>
<!-- .container-fluid -->
</main>
@include('common.footer')