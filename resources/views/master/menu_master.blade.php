@include('common.header')
<script>
    let dataTable = null;
</script>
<script src="{!! asset('js/menu/menu.js') !!}"></script>
<script>
$(function() {
       $("#menuTable").DataTable({
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
                     <a href="#" class="btn btn-app btn_export" id="addMenu"><i class="ion-android-add-circle"></i></i>&nbsp;Add New</a>

                    </div>
                </div><br>
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <div class="table-responsive">
            <table class="table table-bordered table-striped table-vcenter" id="menuTable">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Menu Name</th>
                        <th class="">Menu Path</th>
                        <th class="">Created By</th> 
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($allMenusMaster as $allMenus)
                    <tr class="data-row">
                        <td>{{$loop->index+1}}</td>
                        <td>{{$allMenus->menu_name}}</td>
                        <td>{{$allMenus->menu_path}}</td>
                        <td>{{$allMenus->first_name}} {{$allMenus->last_name}}</td>
                        <td>
                            <div class="">
                                <input type="hidden" id="menuId{{$loop->index}}" value="{{$allMenus->id}}" row_num="{{$loop->index}}">
                                <input type="hidden" id="menuName{{$loop->index}}" value="{{$allMenus->menu_name}}" row_num="{{$loop->index}}">
                                <input type="hidden" id="menuPath{{$loop->index}}" value="{{$allMenus->menu_path}}" row_num="{{$loop->index}}">
                                <input type="hidden" id="menuIcon{{$loop->index}}" value="{{$allMenus->menu_icon}}" row_num="{{$loop->index}}">
                                <input type="hidden" id="menuParent{{$loop->index}}" value="{{$allMenus->id}}" row_num="{{$loop->index}}">
                                <input type="hidden" id="menuType{{$loop->index}}" value="{{$allMenus->menu_type}}" row_num="{{$loop->index}}">

                                <button class="btn btn-xs btn-success btnEditMenu" type="button" id="btnEditMenu{{$loop->index}}" data-toggle="tooltip" row_num="{{$loop->index}}" menu-id="{{$allMenus->id}}" title="Edit Menu"><i class="ion-edit"></i></button>                                  
                                <button class="btn btn-xs btn-danger btnRemoveMenu" type="button" data-toggle="tooltip" title="Remove Menu" role-id="{{$allMenus->id}}"><i class="ion-close"></i></button>
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
    <div class="modal fade" id="menu_add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top modal-md">
            <div class="modal-content ">
                <div class="card-header bg-green bg-inverse">
                    <h4>Add New Role</h4>
                    <ul class="card-actions">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="ion-close"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="card-block">
                    <form class="form-horizontal m-t-sm" action="{{url('/save/role')}}" method="post" id="menuDetailsFormID" name="menuDetailsForm">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="menu_name" name="menu_name" placeholder="Please enter menu name"/>
                                    <label for="menu_name" class="required">Menu Name</label>
                                    <div class="field-error" id="menu_name_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="menu_path" name="menu_path" placeholder="Please enter menu path"/>
                                    <label for="menu_path" class="required">Menu Path</label>
                                    <div class="field-error" id="menu_path_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="menu_icon" name="menu_icon" placeholder="Please enter menu icon"/>
                                    <label for="menu_icon" class="required">Menu Icon</label>
                                    <div class="field-error" id="menu_icon_error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="form-material">
                                    <!--<input class="form-control" type="text" id="menu_type" name="menu_type" placeholder="Please enter menu type"/>-->
                                    <select class="form-control" id="menu_type" name="menu_type" size="1">
                                        <option value="">---Select---</option>
                                        <option value="1">Parent Menu</option>
                                        <option value="2">Sub Menu</option>
                                    </select>
                                    <label for="menu_type" class="required">Menu Type</label>
                                    <div class="field-error" id="menu_type_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-material">
                                    <select class="form-control" id="parent_menu_id" name="parent_menu_id" size="1">
                                        <option value="">---Select---</option>
                                        @foreach($allParentMenus as $pmenu)
                                        <option value="{{$pmenu->id}}">{{ $pmenu -> menu_name}}</option>
                                        @endforeach
                                       
                                    </select>
                                    <label for="menu_path" class="required">Parent Menu</label>
                                    <div class="field-error" id="parent_menu_id_error"></div>
                                </div>
                            </div>
                            
                        </div>
                        
                        
                        <div class="form-group m-b-0">
                            <div class="col-sm-9">
                                <button class="btn btn-app" type="button" name="btnSubmit" id="btnSubmitMenu">Submit</button>
                            </div>
                        </div>

                    </form>
                   
                </div>
                <!-- closing of card here -->

            </div>
        </div>
    </div>
    <!-- End payment Modal -->
    <!-- role Modal -->
    <div class="modal fade" id="menu_edit" class="" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top modal-md">
            <div class="modal-content ">
                <div class="card-header bg-green bg-inverse">
                    <h4>Update Role Details</h4>
                    <ul class="card-actions">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="ion-close"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="card-block">
                    <form class="form-horizontal m-t-sm" action="{{url('/update/role')}}" method="post" id="menuDetailsEditFormID" name="menuDetailsEditForm">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input type="hidden" id="menu_id_edit" name="id"/>
                                    <input class="form-control" type="text" id="menu_name_edit" name="menu_name" placeholder="Please enter menu name"/>
                                    <label for="menu_name" class="required">Menu Name</label>
                                    <div class="field-error" id="menu_name_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="menu_path_edit" name="menu_path" placeholder="Please enter menu path"/>
                                    <label for="menu_path" class="required">Menu Path</label>
                                    <div class="field-error" id="menu_path_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-4s">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="menu_icon_edit" name="menu_icon" placeholder="Please enter menu icon"/>
                                    <label for="menu_icon" class="required">Menu Icon</label>
                                    <div class="field-error" id="menu_icon_error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="form-material">
                                    <!--<input class="form-control" type="text" id="menu_type" name="menu_type" placeholder="Please enter menu type"/>-->
                                    <select class="form-control" id="menu_type_edit" name="menu_type" size="1">
                                        <option value="">---Select---</option>
                                        <option value="1">Parent Menu</option>
                                        <option value="2">Sub Menu</option>
                                    </select>
                                    <label for="menu_type" class="required">Menu Type</label>
                                    <div class="field-error" id="menu_type_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-material">
                                    <select class="form-control" id="parent_menu_id_edit" name="parent_menu_id" size="1">
                                        <option value="">---Select---</option>
                                        @foreach($allParentMenus as $pmenu)
                                        <option value="{{$pmenu->id}}">{{ $pmenu -> menu_name}}</option>
                                        @endforeach
                                       
                                    </select>
                                    <label for="menu_path" class="required">Parent Menu</label>
                                    <div class="field-error" id="parent_menu_id_error"></div>
                                </div>
                            </div>
                            
                        </div>
                        
                        
                        
                        <div class="form-group m-b-0">
                            <div class="col-sm-9">
                                <button class="btn btn-app" type="button" name="btnEditSubmit" id="btnEditRole">Update</button>
                            </div>
                        </div>

                    </form>
                   
                </div>
                <!-- closing of card here -->

            </div>
        </div>
    </div>

</main>
@include('common.footer')
