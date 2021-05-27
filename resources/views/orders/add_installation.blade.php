@include('common.header')
<script src="{!! asset('js/order/installation_form.js') !!}"></script>
<script src="{!! asset('js/order/order_form_validations.js') !!}"></script>
<script src="{!! asset('js/order/order.js') !!}"></script>

@include('common.sidebar')
<script>
   
</script>
<main class="app-layout-content" id="app-layout-content">

<!-- Page Content -->
<div class="container-fluid p-y-md">
    <!-- Dynamic Table Full -->
    <div class="card">
        <div class="card-header">
            <h4>Fill Installation Details</h4>
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
            <table class="table table-bordered table-striped table-vcenter" id="installationTable">
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
                        <td class="">{{$order->po_no}}</td>
                        @if ($order->order_status == 0)
                        <td style="color:#337ab7;"><b>Pending</b></td>
                        @elseif ($order->order_status == 1)
                        <td style="color:#7dc855;"><b>Approved</b></td>
                        @elseif ($order->order_status == 2)
                        <td style="color:#fd5e5e;"><b>Rejected</b></td>
                        @endif
                        <!--<td class="">{{$order->installation_address}}</td>-->
                        <td class="">{{$order->approved_by}}</td>
                        <td class="text-center">
                            <div class="">
                                <input type="hidden" value="{{$order->id}}" name="id" id="orderId{{$loop->index}}">
                                @if($order->is_installation_assigned == false && (Session::get("loggedInUserRole") == 1 || Session::get("loggedInUserRole") == 7))
                                    <a class="btn btn-xs btn-success btn_installationAssignedTo" id="btn_installationAssignedTo" loopIndex ="{{$loop->index}}" type="button" data-toggle="tooltip" title="Installtion Assigned To"><i class="fa fa-user"></i></a>
                                @endif
                               @if(($order->is_installation_done == false && $order->is_installation_assigned == true) && (Session::get("loggedInUserRole") == 5 || Session::get("loggedInUserRole") == 7 || Session::get("loggedInUserRole") == 1))
                                <a class="btn btn-xs btn-success btn_installation" id="btnAddInstallation" loopIndex ="{{$loop->index}}" type="button" data-toggle="tooltip" title="Add Installation Details"><i class="ion-android-add-circle"></i></a>
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
<!-- installation Modal -->
<div class="modal fade" id="Installation_detail" tabindex="-1" data-backdrop="static" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top modal-lg">
            <div class="modal-content">
                <div class="card-header  bg-green bg-inverse">
                    <h4>Fill Installation details</h4>
                    <ul class="card-actions">
                        <li>
                            <button data-dismiss="modal" type="button" id="btnAddCloseInstallationModal"><i class="ion-close"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="card-block">

                    <form class="form-horizontal m-t-sm" action="{{ url('/installation/update') }}" method="post" id="installationFormID" name="installationForm">
                    {{ csrf_field() }}
                    @include('common.flash-message')
                    <input type="hidden" name="orderIdToSubmit" id="orderIdToSubmit">

                        <div class="form-group">
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="installation_assigned_to_readonly" name="installation_assigned_to" readonly>
                                    <input type="hidden" id="installation_assigned_to_id_readonly" name="installation_assigned_to_id">
                                    <!--<select class="js-select2 form-control" id="" name="installation_assigned_to_id" style="width: 100%;" data-placeholder="Choose one..">
                                        <option value="">---Select---</option>
                                        @if(isset($installationPersonList))
                                            @foreach($installationPersonList as $installationPerson)
                                            <option value="{{ $installationPerson->id}}">{{ $installationPerson->first_name}} {{ $installationPerson->last_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>-->
                                    <label for="installation_assigned_to" class="">Installation Assigned To</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="date" id="installation_start_date" name="installation_start_date" placeholder="Please enter installation start date" />
                                    <label for="installation_start_date" class="required">Installation Start Date</label>
                                    <div class="field-error" id="installation_start_date_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="date" id="installation_completion_date" name="installation_completion_date" placeholder="Plaese enter installation completion date" />
                                    <label for="installation_completion_date" class="required">Installation Completion date</label>
                                    <div class="field-error" id="installation_completion_date_error"></div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                            <label>Documentation Completed?</label>    
                            
                                <label class="css-input css-radio css-radio-default m-r-sm">
                                    <input type="radio" id="doc_completed_yes"name="doc_completed"  value="Yes"/><span></span> Yes
                                </label>
                                <label class="css-input css-radio css-radio-default">
                                    <input type="radio" id="doc_completed_no" name="doc_completed"  value="No"checked/><span></span> No
                                </label>
                                                          
                            </div>
                            <div class="col-sm-6">
                            <label>Installation Service Completed?</label>    
                            
                                <label class="css-input css-radio css-radio-default m-r-sm">
                                    <input type="radio" id="installation_serivice_completed_yes" name="installation_serivice_completed" value="Yes" /><span></span> Yes
                                </label>
                                <label class="css-input css-radio css-radio-default">
                                    <input type="radio" id="installation_serivice_completed_no" name="installation_serivice_completed" value="No" checked/><span></span> No
                                </label>
                                                          
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <div class="col-sm-9">
                                <button class="btn btn-app" type="button" id="btnSubmit">Submit</button>
                                <button class="btn btn-app-red" type="button" id="btnCancelInstallationModal">Cancel</button>
                            </div>
                        </div>
                        <div id="loader">
                            <img class="loading-img" src="{!! asset('img/ajax-loader.gif') !!}">
                        </div>
                    </form>
                    <!-- closing of form here -->


                </div>
                <!-- card block close here -->

            </div>
        </div>
    </div>
    <!--Installtion Assigned To-->
    <div class="modal fade" id="installtionAssignedToModal" tabindex="-1" data-backdrop="static" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top modal-sm">
            <div class="modal-content">
                <div class="card-header  bg-green bg-inverse">
                    <h4>Assigned Installation Person</h4>
                    <ul class="card-actions">
                        <li>
                            <button data-dismiss="modal" type="button" id="btnAddCloseInstallationAssignedToModal"><i class="ion-close"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="card-block">

                    <form class="form-horizontal m-t-sm" action="{{ url('/installation/assigned') }}" method="post" id="installationAssignedFormID" name="installationAssignedForm">
                    {{ csrf_field() }}
                    @include('common.flash-message')
                    <input type="hidden" name="orderIdToSubmitForAssignedTo" id="orderIdToSubmitForAssignedTo">

                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="form-material">
                                    <input type="hidden" id="installation_assigned_to_setvalue" name="installation_assigned_to">
                                    <select class="js-select2 form-control" id="installation_assigned_to_id" name="installation_assigned_to_id" style="width: 100%;" data-placeholder="Choose one..">
                                        <option value="">---Select---</option>
                                        @if(isset($installationPersonList))
                                            @foreach($installationPersonList as $installationPerson)
                                            <option value="{{ $installationPerson->id}}">{{ $installationPerson->first_name}} {{ $installationPerson->last_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="installation_assigned_to" class="required">Installation Assigned To</label>
                                    <div class="field-error" id="installation_assigned_to_id_error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <div class="col-sm-9">
                                <button class="btn btn-app" type="button" id="btnAssignedTo">Submit</button>
                                <button class="btn btn-app-red" type="button" id="btnCancelAssignedToModal">Cancel</button>
                            </div>
                        </div>
                        <div id="loader_assigned">
                            <img class="loading-img" src="{!! asset('img/ajax-loader.gif') !!}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>
@include('common.footer')
