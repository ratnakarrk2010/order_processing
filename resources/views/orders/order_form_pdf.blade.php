 <style>
    .greyClass{
        background-color: #eeeeee38;
    }
    .table.dataTable {
        clear: both;
        margin-top: 6px !important;
        margin-bottom: 6px !important;
        max-width: none !important;
        border-collapse: separate !important;
        border-spacing: 0;
    }
    .table-bordered {
        border: 1px solid #eee;
    }
    .tableRow{
        border: 1px solid #000;
        height:100px !important;
    }
    .table-bordered > tbody > tr > th{
        border: 1px solid #000;
        height:31px !important;
    }
    .table > tbody > tr > td {
        border: 1px solid #000;
    }
    


    
</style>
<div class="container-fluid p-y-md">
<div class="card">
        <div class="card-header">
            <h3><center>Order Processing Details</center></h3>
        </div>
        <div class="card-block">
        <div class="table-responsive">
            <table class="table table-bordered table-vcenter dataTable">
               
                <tbody>
                    <tr id="rowId">
                        <th class="greyClass" >OPF No.</th>
                        <td>{{ $orderDetails->opf_no}}</td>
                        <th class="greyClass">OPF Date</th>
                        <td>{{ $orderDetails->opf_date}}</td>
                        <th class="greyClass">PO NO</th>
                        <td>{{ $orderDetails->po_no}}</td>
                    </tr>
                    <tr class="tableRow">
                        <th class="greyClass">Client Name</th>
                        <td colspan="3">{{ $orderDetails->client_name}}</td>
                        <th class="greyClass">PO Date</th>
                        <td>{{ $orderDetails->po_date}}</td>
                    </tr>
                    <tr>
                        <th class="greyClass">Address</th>
                        <td colspan="5">{{ $orderDetails->address}}</td>
                    </tr>
                    <tr>
                        <th class="greyClass">Installation Address</th>
                        <td colspan="5">{{ $orderDetails->installation_address}}</td>
                    </tr>
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
                                    <td style="text-align:center;">{{ $payment->id}}</td>
                                    <td style="text-align:center;" colspan="2">{{ $payment->payment_terms}}</td>
                                    <td style="text-align:center;">{{ $payment->payment_received}}</td>
                                    <td style="text-align:center;">{{ $payment->balance_payment}}</td>
                                    <td style="text-align:center;">{{ $payment->payment_received_date}}</td>
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
                    <tr class="greyClass">
                        <th>Material</th>
                        <th>Quantity</th>
                        <th colspan="2">DC & Dt</th>
                        <th colspan="2">Product Serial No</th>
                        <tbody>
                        @if(isset($orderDetailsArr))
                            @foreach($orderDetailsArr as $orderDt)
                                <tr>
                                    <td style="text-align:center;">{{ $orderDt->materials}}</td>
                                    <td style="text-align:center;">{{ $orderDt->quantity}}</td>
                                    <td style="text-align:center;" colspan="2">{{ $orderDt->dc_no}} , {{ $orderDt->dc_date}}</td>
                                    <td style="text-align:center;" colspan="2">{{ $orderDt->product_serial_no}}</td>
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
        </div>
</div>
    
</div>
