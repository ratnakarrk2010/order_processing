@include('common.header')
<script>
    let dataTable = null;
</script>
<script src="{!! asset('js/menu/role_menu_map.js') !!}"></script>
<script>
$(function() {
       $("#menuMapTable").DataTable({
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
            <h4>Role Menu Mapping</h4>
        </div>
        <div class="card-block">
                <div class="row">
                    <div class="col-sm-10"></div>
                    
                    <div class="col-sm-2">
                     <a href="#" class="btn btn-app btn_export" id="addRoleMenuMap"><i class="ion-android-add-circle"></i></i>&nbsp;Add New</a>

                    </div>
                </div><br>
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <div class="table-responsive">
            <table class="table table-bordered table-striped table-vcenter" id="menuMapTable">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Menu Name</th>
                        <th class="">RoleName</th>
                        <th class="">Status</th>
                        <th class="">Created By</th> 
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($menuMappingList as $menuList)
                    <tr class="data-row">
                        <td>{{$loop->index+1}}</td>
                        <td>{{$menuList->menu_name}}</td>
                        <td>{{$menuList->role_name}}</td>
                        @if($menuList->mapping_status == 0)
                        <td style="color:#fd5e5e;"><b>Inactive</b></td>
                        @elseif($menuList->mapping_status == 1) 
                        <td style="color:#7dc855;"><b>Active</b></td>
                        @elseif($menuList->mapping_status == null) 
                        <td></td>
                        @endif
                        <td>{{$menuList->first_name}} {{$menuList->last_name}}</td>
                        <td>
                            <div class="">
                                <input type="hidden" id="roleMenuMapId{{$loop->index}}" value="{{$menuList->id}}" row_num="{{$loop->index}}">
                                <input type="hidden" id="roleID{{$loop->index}}" value="{{$menuList->role_id}}" row_num="{{$loop->index}}">
                                <input type="hidden" id="menuId{{$loop->index}}" value="{{$menuList->menu_id}}" row_num="{{$loop->index}}">
                                <input type="hidden" id="mappinStatus{{$loop->index}}" value="{{$menuList->mapping_status}}" row_num="{{$loop->index}}">
                                <input type="hidden" id="subMenu{{$loop->index}}" value="{{$menuList->menu_id}}" row_num="{{$loop->index}}">
                                
                                
                                <!--<button class="btn btn-xs btn-success btnEditMenuMap" type="button" id="btnEditMenuMap{{$loop->index}}" data-toggle="tooltip" row_num="{{$loop->index}}" menu-map-id="{{$menuList->id}}" title="Edit Menu Mapping"><i class="ion-edit"></i></button>-->
                                <button class="btn btn-xs btn-danger btnRemoveMenuMap" type="button" data-toggle="tooltip" title="Remove Menu Map" menu-map-id="{{$menuList->id}}"><i class="ion-close"></i></button>
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
    <div class="modal fade" id="menu_map_add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top modal-md">
            <div class="modal-content ">
                <div class="card-header bg-green bg-inverse">
                    <h4>Add Role Menu Mapping</h4>
                    <ul class="card-actions">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="ion-close"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="card-block">
                    <form class="form-horizontal m-t-sm" action="{{url('/save/rolemenu/map')}}" method="post" id="menuMapFormID" name="menuMapForm">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <!--<input class="form-control" type="text" id="menu_type" name="menu_type" placeholder="Please enter menu type"/>-->
                                    <select class="form-control" id="role_id" name="role_id" size="1">
                                    <option value="">---Select---</option>
                                        @if(isset($allRoles))
                                        {{ $allRoles }}
                                            @foreach($allRoles as $role)
                                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="role_id" class="required">Role</label>
                                    <div class="field-error" id="role_id_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <select class="form-control" id="menu_id" name="menu_id" size="1">
                                        <option value="">---Select---</option>
                                        @if(isset($allMenusMaster))
                                            @foreach($allMenusMaster as $menu)
                                            <option value="{{$menu->id}}">{{ $menu -> menu_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="menu_id" class="required">Menu Name</label>
                                    <div class="field-error" id="menu_id_error"></div>
                                </div>
                            </div>
                         
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <select class="form-control" id="subMenu" name="menu_id" size="1">
                                        <option value="0">---Select---</option>                   
                                    </select>
                                    <label for="submenu" class="required">Sub Menu</label>
                                    <div class="field-error" id="subMenu_error"></div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group m-b-0">
                            <div class="col-sm-9">
                                <button class="btn btn-app" type="button" name="btnSubmit" id="btnSubmitMenuMap">Submit</button>
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
    <div class="modal fade" id="menu_map_edit" class="" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <form class="form-horizontal m-t-sm" action="{{url('/update/role/menumap')}}" method="post" id="menuMapEditFormID" name="menuMapEditForm">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input type="hidden" id="role_menu_map_id" name="id" >
                                    <select class="form-control" id="role_id_edit" name="role_id" size="1">
                                    <option value="">---Select---</option>
                                        @if(isset($allRoles))
                                        {{ $allRoles }}
                                            @foreach($allRoles as $role)
                                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="role_id" class="required">Role</label>
                                    <div class="field-error" id="role_id_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <select class="form-control" id="menu_id_edit" name="menu_id" size="1">
                                        <option value="">---Select---</option>
                                        @if(isset($allMenusMaster))
                                            @foreach($allMenusMaster as $menu)
                                            <option value="{{$menu->id}}">{{ $menu -> menu_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="menu_id" class="required">Menu Name</label>
                                    <div class="field-error" id="menu_id_error"></div>
                                </div>
                            </div>
                           
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <select class="form-control" id="subMenuEdit" name="menu_id" size="1">
                                        <option value="">---Select---</option>
                                       
                                    </select>
                                    <label for="subMenuEdit" class="required">Sub Menu</label>
                                    <div class="field-error" id="mapping_status_error"></div>
                                </div>
                            </div>
                            
                        </div>
                       
                        <div class="form-group m-b-0">
                            <div class="col-sm-9">
                                <button class="btn btn-app" type="button" name="" id="btnEditMapSubmit">Update</button>
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
