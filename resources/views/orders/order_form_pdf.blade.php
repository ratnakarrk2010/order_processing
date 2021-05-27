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
                        <td>{{date('d/m/Y', strtotime($orderDetails->opf_date))}}</td>
                        <th class="greyClass">PO NO</th>
                        <td>{{ $orderDetails->po_no}}</td>
                    </tr>
                    <tr class="tableRow">
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
                    @foreach($installationAddresses as $installationAddress)
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
                    <tr class="greyClass">
                        <th>Invoice&nbsp;No</th>
                        <th>Invoice&nbsp;Date</th>
                        <th>Payment&nbsp;Terms</th>
                        <th>Payment&nbsp;Received</th>
                        <th>Balance&nbsp;Payment</th>
                        <th>Payment&nbsp;Received Date</th>
                        
                        <tbody>
                        @if(isset($paymentArr) && $paymentArr != null)
                            @foreach($paymentArr as $payment)
                                <tr>
                                 
                                    <td style="text-align:center;">{{ $payment->invoice_no }}</td>
                                    <td style="text-align:center;">{{ date('d/m/Y', strtotime($payment->invoice_date)) }}</td>
                                    <td style="text-align:center;">{{ $payment->payment_terms }}</td>
                                    <td style="text-align:center;">{{ $payment->payment_received }}</td>
                                    <td style="text-align:center;">{{ $payment->balance_payment }}</td>
                                    <td style="text-align:center;">{{ date('d/m/Y', strtotime($payment->payment_received_date)) }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </tr>
                    <tr class="greyClass">
                        <th>Invoice&nbsp;No</th>
                        <th>Invoice&nbsp;Date</th>
                        <th>DC No</th>
                        <th>DC Date</th>
                        <th colspan="2">Product Serial Number</th>
                        
                        <tbody>
                        @if(isset($paymentArr) && $paymentArr != null)
                            @foreach($paymentArr as $payment)
                                <tr>
                                 
                                    <td style="text-align:center;">{{ $payment->invoice_no }}</td>
                                    <td style="text-align:center;">{{ date('d/m/Y', strtotime($payment->invoice_date)) }}</td>
                                    <td style="text-align:center;">{{ $payment->dc_no}}</td>
                                    <td style="text-align:center;">{{ date('d/m/Y', strtotime($payment->dc_date)) }}</td>
                                    <td style="text-align:center;" colspan="2">{{ $payment->product_serial_no }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </tr>
                   <!-- <tr>
                        <th class="greyClass">Invoice Number</th>
                        <td colspan="3">{{ $orderDetails->invoice_no}}</td>
                        <th class="greyClass">Invoice Date</th>
                        <td>{{ $orderDetails->invoice_date}}</td>
                    </tr>-->
                    <tr>
                        <th class="greyClass">Name & Signature of Sale Initiator</th>
                        <td colspan="3">{{ $orderDetails->sales_initiator_by}}</td>
                        <th class="greyClass">Approved / Rejected By</th>
                        <td>{{ $orderDetails->approved_by}}</td>
                    </tr>   
                    <tr>
                        <th class="greyClass">Total PO Value</th>
                        <td colspan="5">{{ $orderDetails->total_order_amount}}</td>
                    </tr>
                    <tr>
                        <th colspan="6"class="greyClass"><center>This section to be enetered after receipt of Purchase Order</center></th>
                    </tr>
                    <tr>
                        <th class="greyClass"> Material  Procurement Date</th>
                        <td colspan="5">{{date('d/m/Y', strtotime($orderDetails->material_procurement_date))}}</td>
                    </tr>
                    <tr>
                        <th class="greyClass">QC / In House Testing  results</th>
                        <td colspan="5">{{ $orderDetails->qc_testting_result}}</td>
                    </tr>
                    <tr>
                        <th class="greyClass">Dispatch Date</th>
                        <td colspan="1">{{date('d/m/Y', strtotime($orderDetails->dispatch_date))}}</td>
                        <th colspan="4"class=""><center>By Courier / Hand Delivery</center></th>
                    </tr>
                    <tr class="greyClass">
                        <th colspan="3">Material</th>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Quantity</th>
                        <tbody>
                        @if(isset($orderDetailsArr))
                            @foreach($orderDetailsArr as $orderDt)
                                <tr>
                                    <td style="text-align:center;" colspan="3">{{ $orderDt->materials }}</td>
                                    <td style="text-align:center;">{{ $orderDt->quantity }}</td>
                                    <td style="text-align:center;">{{ $orderDt->make }}</td>
                                    <td style="text-align:center;">{{ $orderDt->model }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </tr> 
                    @if(isset($installationDetailsArr) && $installationDetailsArr != null)
                    <tr>
                        <th class="greyClass">Installation Start Date</th>
                        <td colspan="">{{date('d/m/Y', strtotime($installationDetailsArr->installation_start_date))}}</td>
                        <th class="greyClass">Installation Completion Date</th>
                        <td>{{date('d/m/Y', strtotime($installationDetailsArr->installation_completion_date))}}</td>
                        <th class="greyClass">Installation Service Completed?</th>
                        <td>{{ $installationDetailsArr->installation_serivice_completed}}</td>
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
