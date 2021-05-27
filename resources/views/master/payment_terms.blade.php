@include('common.header')
<script>
    let dataTable = null;
</script>
<script src="{!! asset('js/payment_terms/payment_terms.js') !!}"></script>
<script>
$(function() {
       $("#paymentTermsTable").DataTable({
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
            <h4>Payment Terms Details</h4>
        </div>
        <div class="card-block">
                <div class="row">
                    <div class="col-sm-10"></div>
                    
                    <div class="col-sm-2">
                     <a href="#" class="btn btn-app btn_export" id="addPaymentTerms"><i class="ion-android-add-circle"></i></i>&nbsp;Add New</a>

                    </div>
                </div><br>
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <div class="table-responsive">
            <table class="table table-bordered table-striped table-vcenter" id="paymentTermsTable">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Payment&nbsp;Terms</th>
                        <th>Values</th>
                        <th class="">Created&nbsp;By</th> 
                        <!-- th>Actions</th -->
                    </tr>
                </thead>
                <tbody>
                @foreach($allPaymentTerms as $pt)
                    <tr class="data-row">
                        <td>{{$loop->index+1}}</td>
                        <td>{{$pt->payment_terms}}</td>
                        <td>{{$pt->value_figure}}</td>
                        <td>{{$pt->first_name}} {{$pt->last_name}}</td>
                        <!-- td>
                            <div class="">
                                <input type="hidden" id="paymentTermsId//$loop->index}}" value="$pt->id}}" row_num="$loop->index}}">
                                <input type="hidden" id="paymentTerms//$loop->index}}" value="$pt->payment_terms}}" row_num="$loop->index}}">
                                <input type="hidden" id="paymentTermsValue$loop->index}}" value="$pt->value_figure}}" row_num="$loop->index}}">
                                <button class="btn btn-xs btn-success btnEditPT" type="button" id="btnEditPaymentTerms$loop->index}}" data-toggle="tooltip" row_num="{{$loop->index}}" pt-id="{{$pt->id}}" title="Edit Payment Terms"><i class="ion-edit"></i></button>                                  
                                <button class="btn btn-xs btn-danger btnRemovePaymentTerms" type="button" data-toggle="tooltip" title="Remove Payment Terms" pt-id="{{$pt->id}}"><i class="ion-close"></i></button>
                            </div>
                        </td -->
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
    <!-- role Modal -->
    <div class="modal fade" id="payment_terms_add" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top modal-md">
            <div class="modal-content ">
                <div class="card-header bg-green bg-inverse">
                    <h4>Add New Payment Terms</h4>
                    <ul class="card-actions">
                        <li>
                            <button data-dismiss="modal" type="button" id="btnClosePaymentTermsModal"><i class="ion-close"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="card-block">
                    <form class="form-horizontal m-t-sm" action="{{url('/save/payment/terms')}}" method="post" id="ptDetailsFormID" name="ptDetailsForm">
                        {{ csrf_field() }}
                        <div class="form-group">
                            
                            <div class="col-sm-6">
                                <div class="form-material">
                                <textarea class="form-control" id="payment_terms" name="payment_terms" rows="1" placeholder="Please Enter Payment Terms" style="resize: none;"></textarea>
                                <label for="payment_terms" class="required">Payment Terms</label>
                                <div class="field-error" id="payment_terms_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-material">
                                    <input type="text" class="form-control" id="value_figure" name="value_figure" placeholder="Please Enter Value">
                                    <label for="value_figure" class="">Values (To be added while making OPF) </label>
                                </div>
                            </div>
                        </div>
                                                
                        <div class="form-group m-b-0">
                            <div class="col-sm-9">
                                <button class="btn btn-app" type="button" name="btnSubmit" id="btnPTSubmit">Submit</button>
                                <button class="btn btn-danger" type="button" name="btnCancelPaymentTerms" id="btnCancelPaymentTerms">Cancel</button>
                            </div>
                        </div>
                        <div id="loader">
                            <img class="loading-img" src="{!! asset('img/ajax-loader.gif') !!}">
                        </div>
                    </form>
                   
                </div>
                <!-- closing of card here -->

            </div>
        </div>
    </div>
    <!-- End payment Modal -->
    <!-- role Modal -->
    <div class="modal fade" id="payment_terms_editID" data-backdrop="static" class="" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top modal-md">
            <div class="modal-content ">
                <div class="card-header bg-green bg-inverse">
                    <h4>Update Payment Terms Details</h4>
                    <ul class="card-actions">
                        <li>
                            <button data-dismiss="modal" type="button" id="paymentMasterEditClose"><i class="ion-close"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="card-block">
                    <form class="form-horizontal m-t-sm" action="{{url('/update/payment/terms')}}" method="post" id="ptEditFormID" name="ptEditForm">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="form-material">
                                <input type="hidden" id="payment_terms_id_edit" name="id"/>
                                    <textarea class="form-control" id="payment_terms_edit" name="payment_terms" rows="1" placeholder="Please Enter Payment Terms" style="resize: none;"></textarea>
                                    <label for="payment_terms_edit" class="required">Payment Terms</label>
                                    <div class="field-error" id="payment_terms_edit_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-material">
                                    <input type="text" class="form-control" id="value_figure_edit" name="value_figure" placeholder="Please Enter Value">
                                    <label for="payment_terms_edit" class="">Values(To be added while making OPF) </label>
                                    <div class="field-error" id="payment_terms_edit_error"></div>
                                </div>
                            </div>
                           
                        </div>
                        <div class="form-group m-b-0">
                            <div class="col-sm-9">
                                <button class="btn btn-app" type="button" name="btnEditSubmit" id="btnEditPaymentTerms">Update</button>
                                <button class="btn btn-danger" type="button" name="btnCancelEditPaymentTersm" id="btnCancelEditPaymentTersm">Cancel</button>
                            </div>
                        </div>
                        <div id="loader-edit">
                            <img class="loading-img" src="{!! asset('img/ajax-loader.gif') !!}">
                        </div>
                    </form>
                </div>
                <!-- closing of card here -->
            </div>
        </div>
    </div>

</main>
@include('common.footer')
