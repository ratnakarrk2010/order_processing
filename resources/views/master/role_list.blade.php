@include('common.header')
<script>
    let dataTable = null;
</script>
<script src="{!! asset('js/role/role.js') !!}"></script>
<script>
$(function() {
       $("#roleTable").DataTable({
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
            <h4>Role Details</h4>
        </div>
        <div class="card-block">
                <div class="row">
                    <div class="col-sm-10"></div>
                    
                    <div class="col-sm-2">
                     <a href="#" class="btn btn-app btn_export" id="addRole"><i class="ion-android-add-circle"></i></i>&nbsp;Add New</a>

                    </div>
                </div><br>
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <div class="table-responsive">
            <table class="table table-bordered table-striped table-vcenter" id="roleTable">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Role Name</th>
                        <th class="">Role Description</th>
                        <!-- th class="">Created By</th -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($allRoles as $role)
                    <tr class="data-row">
                        <td>{{$loop->index+1}}</td>
                        <td>{{$role->role_name}}</td>
                        <td>{{$role->role_description}}</td>
                        <!-- td>//$role->first_name$role->last_name</td -->
                        <td>
                            <div class="">
                                <input type="hidden" id="roleId{{$loop->index}}" value="{{$role->id}}" row_num="{{$loop->index}}">
                                <input type="hidden" id="roleName{{$loop->index}}" value="{{$role->role_name}}" row_num="{{$loop->index}}">
                                <input type="hidden" id="roleDescription{{$loop->index}}" value="{{$role->role_description}}" row_num="{{$loop->index}}">
                                <button class="btn btn-xs btn-success btnEditRole" type="button" id="btnEditRole{{$loop->index}}" data-toggle="tooltip" row_num="{{$loop->index}}" role-id="{{$role->id}}" title="Edit Role"><i class="ion-edit"></i></button>                                  
                                <button class="btn btn-xs btn-danger btnRemoveRole" type="button" data-toggle="tooltip" title="Remove Role" role-id="{{$role->id}}"><i class="ion-close"></i></button>
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
    <div class="modal fade" id="role_add" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top modal-md">
            <div class="modal-content ">
                <div class="card-header bg-green bg-inverse">
                    <h4>Add New Role</h4>
                    <ul class="card-actions">
                        <li>
                            <button data-dismiss="modal" type="button" id="btnCloseRoleModal"><i class="ion-close"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="card-block">
                    <form class="form-horizontal m-t-sm" action="{{url('/save/role')}}" method="post" id="roleDetailsFormID" name="roleDetailsForm">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="form-material">
                                
                                    <input class="form-control" type="text" id="role_name" name="role_name" placeholder="Please enter role name"/>
                                    <label for="invoice_no" class="required">Role Name</label>
                                    <div class="field-error" id="role_name_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-material">
                                <textarea class="form-control" id="role_description" name="role_description" rows="1" placeholder="Role Description" style="resize: none;"></textarea>
                                <label for="role_description">Role Description</label>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group m-b-0">
                            <div class="col-sm-9">
                                <button class="btn btn-app" type="button" name="btnSubmit" id="btnRoleSubmit">Submit</button>
                                <button class="btn btn-danger" type="button" name="btnCancelRole" id="btnCancelRole">Cancel</button>
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
    <div class="modal fade" id="role_edit" data-backdrop="static" class="" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top modal-md">
            <div class="modal-content ">
                <div class="card-header bg-green bg-inverse">
                    <h4>Update Role Details</h4>
                    <ul class="card-actions">
                        <li>
                            <button data-dismiss="modal" type="button" id="roleMasterClose"><i class="ion-close"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="card-block">
                    <form class="form-horizontal m-t-sm" action="{{url('/update/role')}}" method="post" id="roleEditFormID" name="roleEditForm">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="form-material">
                                <input type="hidden" id="role_id_edit" name="id"/>
                                    <input class="form-control" type="text" id="role_name_edit" name="role_name"/>
                                    <label for="role_name_edit" class="required">Role Name</label>
                                    <div class="field-error" id="role_name_edit_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-material">
                                <textarea class="form-control" id="role_description_edit" name="role_description" rows="1" placeholder="Role Description" style="resize: none;"></textarea>
                                <label for="role_description">Role Description</label>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group m-b-0">
                            <div class="col-sm-9">
                                <button class="btn btn-app" type="button" name="btnEditSubmit" id="btnEditRole">Update</button>
                                <button class="btn btn-danger" type="button" name="btnCancelEditRole" id="btnCancelEditRole">Cancel</button>
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
