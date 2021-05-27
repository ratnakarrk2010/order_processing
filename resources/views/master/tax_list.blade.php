@include('common.header')
<script>
    let dataTable = null;
</script>
<script src="{!! asset('js/tax/tax.js') !!}"></script>
<script>
$(function() {
       $("#taxTable").DataTable({
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
            <h4>Tax Details</h4>
        </div>
        <div class="card-block">
                <div class="row">
                    <div class="col-sm-10"></div>
                    
                    <div class="col-sm-2">
                     <a href="#" class="btn btn-app btn_export" id="addTax"><i class="ion-android-add-circle"></i></i>&nbsp;Add New</a>

                    </div>
                </div><br>
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <div class="table-responsive">
            <table class="table table-bordered table-striped table-vcenter" id="taxTable">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Tax Name</th>
                        <th class="">Tax Value</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($allTaxes as $tax)
                    <tr class="data-row">
                        <td>{{$loop->index+1}}</td>
                        <td>{{$tax->tax_name}}</td>
                        <td>{{$tax->tax_value}}</td>
                        <td>
                            <div class="">
                                <input type="hidden" id="taxId{{$loop->index}}" value="{{$tax->id}}" row_num="{{$loop->index}}">
                                <input type="hidden" id="taxName{{$loop->index}}" value="{{$tax->tax_name}}" row_num="{{$loop->index}}">
                                <input type="hidden" id="taxValue{{$loop->index}}" value="{{$tax->tax_value}}" row_num="{{$loop->index}}">
                                <button class="btn btn-xs btn-success btnEditTax" type="button" id="btnEditTax{{$loop->index}}" data-toggle="tooltip" row_num="{{$loop->index}}" tax-id="{{$tax->id}}" title="Edit Tax"><i class="ion-edit"></i></button>                                  
                                <button class="btn btn-xs btn-danger btnRemoveTax" type="button" data-toggle="tooltip" title="Remove Tax" tax-id="{{$tax->id}}"><i class="ion-close"></i></button>
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


    <!-- role Modal -->
    <div class="modal fade" id="tax_add" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top modal-md">
            <div class="modal-content ">
                <div class="card-header bg-green bg-inverse">
                    <h4>Add New Tax</h4>
                    <ul class="card-actions">
                        <li>
                            <button data-dismiss="modal" type="button" id="btnCloseTaxModal"><i class="ion-close"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="card-block">
                    <form class="form-horizontal m-t-sm" action="{{url('/save/tax')}}" method="post" id="taxDetailsFormID" name="taxDetailsForm">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="form-material">
                                
                                    <input class="form-control" type="text" id="tax_name" name="tax_name" placeholder="Please enter tax name"/>
                                    <label for="tax_name" class="required">Tax Name</label>
                                    <div class="field-error" id="tax_name_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-material">
                                <input class="form-control" type="text" id="tax_value" name="tax_value" rows="1" placeholder="Tax Value">
                                <label for="tax_value" class="required">Tax Value</label>
                                <div class="field-error" id="tax_value_error"></div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group m-b-0">
                            <div class="col-sm-9">
                                <button class="btn btn-app" type="button" name="btnSubmit" id="btnTaxSubmit">Submit</button>
                                <button class="btn btn-danger" type="button" name="btnCancelTax" id="btnCancelTax">Cancel</button>
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
    <div class="modal fade" id="tax_edit" data-backdrop="static" class="" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top modal-md">
            <div class="modal-content ">
                <div class="card-header bg-green bg-inverse">
                    <h4>Update Tax Details</h4>
                    <ul class="card-actions">
                        <li>
                            <button data-dismiss="modal" type="button" id="taxMasterClose"><i class="ion-close"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="card-block">
                    <form class="form-horizontal m-t-sm" action="{{url('/update/tax')}}" method="post" id="taxEditFormID" name="taxEditForm">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="form-material">
                                <input type="hidden" id="tax_id_edit" name="id"/>
                                    <input class="form-control" type="text" id="tax_name_edit" name="tax_name"/>
                                    <label for="tax_name_edit" class="required">Tax Name</label>
                                    <div class="field-error" id="tax_name_edit_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-material">
                                <input class="form-control" type="text" id="tax_value_edit" name="tax_value" rows="1" placeholder="Tax Value">
                                <label for="tax_value">Tax Value</label>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group m-b-0">
                            <div class="col-sm-9">
                                <button class="btn btn-app" type="button" name="btnEditSubmit" id="btnEditTax">Update</button>
                                <button class="btn btn-danger" type="button" name="btnCancelEditTax" id="btnCancelEditTax">Cancel</button>
                            </div>
                        </div>
                        <div id="loader_edit">
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
