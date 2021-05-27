@include('common.header')
<script src="{!! asset('js/order/installation_form.js') !!}"></script>
@include('common.sidebar')
<style>
    .greyClass{
        background-color: #eeeeee38;
    }    
        .row {
            margin-left: 0px !important;
            margin-right: 0px !important;
        }
        .rowFontSize{
            font-size:85%;
        }

        label {
            font-weight: 500 !important;
        }
        .padding_border{
            padding:1em 0em 1em 0.5em;
            border: 1px solid #eee;
        }
        .background_gry{
            background: #fbfbfb;
        }
        .font_weight{
            font-weight: 500;
        }
       
        .div_height{height: 70px;}
        .div_height_58{height: 49px;}
        .div_span{
            position: absolute;
            top: 35%;
        }
        .padding_l_r{
            padding-left: 0px;
            padding-right: 0px;
        }
         .border_row{
            border:1px solid #f4f4f4
         }
         .border_bottom{
             border-bottom: 0px solid !important;
         }
        @media (min-width: 320px) and (max-width: 767px) {
            .m_div_span{
            position: absolute;
            top: 35%;
            }
            .padding_right_10{
                padding-right:10px;
            }
            .m_height_82{
                height:82px;
            }
            .min-height-common {
                height:98px;
            }
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
            <div class="row rowFontSize">
                <div class="col-xs-6 col-sm-2  padding_border background_gry ">
                    <span class="font_weight">Opf No</span>
                </div>
                <div class="col-xs-6 col-sm-2  padding_border">
                    <span>{{ $orderDetails->opf_no}}</span>
                </div>
                <div class="col-xs-6 col-sm-2 padding_border background_gry">
                    <span class="font_weight">Opf Date</span>
                </div>
                <div class="col-xs-6 col-sm-2 padding_border ">
                    <span>{{date('d/m/Y', strtotime($orderDetails->opf_date))}}</span>
                </div>
                <div class="col-xs-6 col-sm-2 padding_border background_gry">
                    <span class="font_weight">Po No</span>
                </div>
                <div class="col-xs-6 col-sm-2 padding_border ">
                    <span>{{ $orderDetails->po_no}}</span>
                </div>
            </div>
            <div class="row rowFontSize">
                <div class="col-xs-6 col-sm-2 padding_border background_gry">
                    <span class="font_weight">Client Name</span>

                </div>
                <div class="col-xs-6 col-sm-6 padding_border">
                    <span>{{ $orderDetails->client_name}}</span>
                </div>
                <div class="col-xs-6 col-sm-2 padding_border background_gry">
                    <span class="font_weight">Po Date</span>

                </div>
                <div class="col-xs-6 col-sm-2 padding_border">
                    <span>{{date('d/m/Y', strtotime($orderDetails->po_date))}}</span>
                </div>

            </div>
            <div class="row border_row rowFontSize">
                <div class="col-xs-6 col-sm-2  m_height_82 padding_border border_bottom background_gry">
                    <span class="font_weight">Address</span>

                </div>
                <div class="col-xs-6 col-sm-10 padding_border border_bottom">
                    <span>{{ $orderDetails->address}}</span>
                </div>

            </div>
            <div class="row rowFontSize border_row">
                <div class="col-xs-6 col-sm-2 background_gry min-height-common padding_border border_bottom" rowspan="{{sizeof($installationAddresses) + 1}}">
                    <span class="font_weight">Installation Address</span>
                </div>
                <div class="col-xs-6 col-sm-10 padding_l_r ">
                    <div class="row">
                        @foreach ($installationAddresses as $installationAddress)
                        <div class=" col-sm-12 padding_border ">
                            <span>{{ $installationAddress->installation_address}}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- @foreach ($installationAddresses as $installationAddress)
                <div class="col-xs-6 col-sm-10 padding_border">
                    <span>{{ $installationAddress->installation_address}}</span>
                </div>
                @endforeach -->
            </div>
                <div class="row rowFontSize border_row">
                    <div class="col-xs-4 col-sm-2 m_height_82 background_gry padding_border border_bottom">
                        <span class="font_weight">Contact Persons</span>

                    </div>
                    <div class="col-xs-4 col-sm-5 padding_border border_bottom m_height_82">
                        <span class="m_div_span">{{ $orderDetails->contact_person1}}</span>
                    </div>
                    <div class="col-xs-4 col-sm-5 padding_border border_bottom m_height_82">
                        <span class="m_div_span">{{$orderDetails->contact_person2}}</span>
                    </div>
                </div>
                <div class="row rowFontSize border_row">
                    <div class="col-xs-4 col-sm-2 m_height_82 background_gry padding_border border_bottom">
                        <span class="font_weight">Contact Number</span>

                    </div>
                    <div class="col-xs-4 col-sm-5 padding_border border_bottom m_height_82">
                        <span class="m_div_span">{{ $orderDetails->contact1}}</span>
                    </div>
                    <div class="col-xs-4 col-sm-5 padding_border border_bottom m_height_82">
                        <span class="m_div_span">{{ $orderDetails->contact2}}</span>
                    </div>
                </div>
                <div class="row rowFontSize">
                    <div class="col-xs-6 col-sm-2 background_gry  padding_border">
                        <span class="font_weight">Email Id</span>

                    </div>
                    <div class="col-xs-6 col-sm-10 padding_border">
                        <span>{{ $orderDetails->email_id}}</span>
                    </div>
                    
                </div>
                <div class="row rowFontSize">
                    <div class="col-xs-6 col-sm-2 background_gry padding_border">
                        <span class="font_weight">Order Collected By</span>

                    </div>
                    <div class="col-xs-6 col-sm-6 padding_border">
                        <span>{{ $orderDetails->order_collected_by}}</span>
                    </div>
                    <div class="col-xs-6 col-sm-2 padding_border">
                        <span class="font_weight">Waranty Period</span>
                    </div>
                    <div class="col-xs-6 col-sm-2 padding_border">
                        <span>{{ $orderDetails->warranty_period}}</span>
                    </div>
                    
                </div>
                
                <div class="row rowFontSize table-responsive">
                    <table class="table table-bordered table-vcenter customeTbl">
                    <tr class="greyClass">
                        <th>Sr.No</th>
                        <th>Invoice&nbsp;No</th>
                        <th>Invoice&nbsp;Date</th>
                        <th>DC No</th>
                        <th>DC Date</th>
                        <th>Product SrNo.</th>
                        <th>Payment Terms</th>
                        <th>Payment&nbsp;Received</th>
                        <th>Balance&nbsp;Payment</th>
                        <th>Payment&nbsp;Received Date</th>
                        
                        <tbody>
                        @if(isset($paymentArr) && $paymentArr != null)
                            @foreach($paymentArr as $payment)
                                <tr>
                                    <td>{{ $payment->id}}</td>
                                    <td>{{ $payment->invoice_no}}</td>
                                    <td>{{ date('d/m/Y', strtotime($payment->invoice_date)) }}</td>
                                    <td>{{ $payment->dc_no }}</td>
                                    <td>{{ $payment->dc_date != null ? "  " . date('d/m/Y', strtotime($payment->dc_date)) : '' }}</td>
                                    <td>{{ $payment->product_serial_no }}</td>
                                    <td>{{ $payment->payment_terms }}</td>
                                    <td>{{ $payment->payment_received }}</td>
                                    <td>{{ $payment->balance_payment }}</td>
                                    <td>{{ date('d/m/Y', strtotime($payment->payment_received_date)) }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </tr> 
                    </table>
                </div>
                
                <div class="row rowFontSize">
                    <div class="col-xs-6 col-sm-2 padding_border background_gry">
                        <span class="font_weight">Name & Signature of Sale Initiator</span>

                    </div>
                    <div class="col-xs-6 col-sm-6 padding_border div_height">
                        <span class="div_span">{{ $orderDetails->sales_initiator_by}}</span>
                    </div>
                    
                    <div class="col-xs-6 col-sm-2 div_height padding_border background_gry">
                        <span class="font_weight">Approved & Accepted By</span>
                    </div>
                    <div class="col-xs-6 col-sm-2 padding_border div_height">
                        <span class="div_span">{{ $orderDetails->approved_by}}</span>
                    </div>
                    
                </div>
                <div class="row rowFontSize">
                    <div class="col-xs-6 col-sm-2 padding_border background_gry">
                        <span class="font_weight">Total PO Value</span>
                    </div>
                    <div class="col-xs-6 col-sm-10 padding_border">
                        <span>{{ $orderDetails->total_order_amount}}</span>
                    </div>
                </div>
                <div class="row rowFontSize">
                    <div class=" col-sm-12 padding_border background_gry" style="text-align: center;">
                        <span class="font_weight">This section to be enetered after receipt of Purchase Order</span>
                    </div>
                    
                </div>
                <div class="row rowFontSize">
                    <div class="col-xs-6 col-sm-2 padding_border background_gry">
                        <span class="font_weight">Material Procurement Date</span>
                    </div>
                    <div class="col-xs-6 col-sm-10 padding_border div_height">
                        <span class="div_span">{{date('d/m/Y', strtotime($orderDetails->material_procurement_date))}}</span>
                    </div>
                </div>
                <div class="row rowFontSize">
                    <div class="col-xs-6 col-sm-2 padding_border background_gry">
                        <span class="font_weight ">QC / In House Testing results</span>
                    </div>
                    <div class="col-xs-6 col-sm-10 padding_border div_height">
                        <span class="div_span">{{ $orderDetails->qc_testting_result}}</span>
                    </div>
                </div>
                <div class="row rowFontSize ">
                    <div class="col-xs-3 col-sm-2 m_height_82 padding_border background_gry">
                        <span class="font_weight">Dispatch Date</span>
                    </div>
                    <div class="col-xs-4 col-sm-2 padding_border m_height_82">
                        <span class="m_div_span">{{date('d/m/Y', strtotime($orderDetails->dispatch_date))}}</span>
                    </div>
                    <div class="col-xs-5 col-sm-8 padding_border padding_right_10 m_height_82" style='text-align: center; '>
                        <span class="font_weight">By Courier / Hand Delivery</span>
                    </div>
                </div>
                <div class="row rowFontSize table-responsive">
                    <table class="table table-bordered table-vcenter customeTbl" >
                        <tr>
                            <thead>
                                <th class="greyClass">Material</th>
                                <th class="greyClass" colspan="5">Make</th>
                                <th class="greyClass" colspan="2">Model</th>
                                <th class="greyClass" colspan="5">Quantity</th>
                            </thead>
                            <tbody>
                            @if(isset($orderDetailsArr))
                                @foreach($orderDetailsArr as $orderDt)
                                    <tr>
                                        <td>{{ $orderDt->materials }}</td>
                                        <td colspan="5">{{ $orderDt->make }}</td>
                                        <td colspan="2">{{ $orderDt->model }}</td>
                                        <td colspan="5">{{ $orderDt->quantity }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </tr> 
                    </table>
                </div>
                @if(isset($installationDetailsArr) && $installationDetailsArr != null)
                <div class="row rowFontSize">
                    <div class="col-xs-6 col-sm-2 padding_border background_gry div_height">
                        <span class="font_weight div_span">Installation Start Date</span>
                    </div>
                    <div class="col-xs-6 col-sm-2 padding_border div_height">
                        <span class="div_span">{{date('d/m/Y', strtotime($installationDetailsArr->installation_start_date))}}</span>
                    </div>
                    <div class="col-xs-6 col-sm-2 padding_border background_gry div_height">
                        <span class="font_weight ">Installation Completion Date</span>
                    </div>
                    <div class="col-xs-6 col-sm-2 padding_border div_height">
                        <span class="div_span">{{date('d/m/Y', strtotime($installationDetailsArr->installation_completion_date))}}</span>
                    </div>
                    <div class="col-xs-6 col-sm-2 padding_border background_gry div_height">
                        <span class="font_weight">Installation Documentation Completed?</span>
                    </div>
                    <div class="col-xs-6 col-sm-2 padding_border div_height">
                        <span class="div_span">{{ $installationDetailsArr->installation_serivice_completed}}</span>
                    </div>
                </div>
                @endif
                <div class="row rowFontSize border_row">
                    <div class="col-xs-6 col-sm-2 padding_border background_gry border_bottom">
                        <span class="font_weight">Remark if any</span>
                    </div>
                    <div class="col-xs-6 col-sm-10 padding_border border_bottom" style="border:0px solid">
                        <span>{{ $orderDetails->remarks}}</span>
                    </div>
                    
                </div>
                <div class="row rowFontSize">
                    <div class=" col-sm-4 padding_border background_gry">
                        <span class="font_weight">Signature of Project Executive</span>
                    </div>
                    <div class=" col-sm-2 padding_border div_height_58">
                        <span class="div_span"></span>
                    </div>
                    <div class=" col-sm-6 padding_border ">
                        <span class="font_weight">Signature of CS Manager</span>
                    </div>
                    
                </div>
                <br>
                <div class="row rowFontSize">
                    <div class="col-sm-10"></div>
                    <div class="col-sm-2" style="padding-right: 0px;">
                    @if(Session::get('loggedInUserRole') == 1 || Session::get('loggedInUserRole') == 6 || Session::get('loggedInUserRole') == 7)
                        <a href="{{ url('/all/orders')}}" class="btn btn-app btn-primary" style="float:right;"><i class="ion-android-arrow-back"></i>&nbsp;Back</a>
                    @elseif(Session::get('loggedInUserRole') == 2)
                        <a href="{{ url('/dashboard')}}" class="btn btn-app btn-primary" style="float:right;"><i class="ion-android-arrow-back"></i>&nbsp;Back</a>
                    @endif
                    @if(Session::get('loggedInUserRole') == 5)
                        <a href="{{ url('/add/installation')}}" class="btn btn-app btn-primary" style="float:right;"><i class="ion-android-arrow-back"></i>&nbsp;Back</a>
                    @endif
                    @if(Session::get('loggedInUserRole') == 4)
                        <a href="{{ url('add/paymentdetails')}}" class="btn btn-app btn-primary" style="float:right;"><i class="ion-android-arrow-back"></i>&nbsp;Back</a>
                    @endif
                    </div>
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