@include('common.header')
<script src="{!! asset('js/menu/menu.js') !!}"></script>
@include('common.sidebar')
<main class="app-layout-content" id="app-layout-content">
    <!-- Page Content -->
    <div class="container-fluid p-y-md">
        <!-- Material Design -->
        <div class="row">
            <div class="col-md-12">
                <!-- Static Labels -->
                <div class="card">
                    <div class="card-header">
                        <h4>Menu Mapping</h4>
                    </div>
                    <hr />
                    <div class="card-block">
                        <form class="form-horizontal m-t-sm" action="{{ url('/map/menu') }}" method="post" id="menuMappingFormId" name="menuMappingForm">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="col-sm-3">
                                <div class="form-material">
                                    <select class="form-control" id="role_id" name="role_id" size="1">
                                        <option value="0">---Select---</option>
                                        @foreach($roles as $role)
                                            @if (isset($selectedRole) && $selectedRole == $role->id)
                                                <option value="{{$role->id}}" selected="selected">{{$role->role_name}}</option>
                                            @else
                                                <option value="{{$role->id}}">{{$role->role_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <label for="role_id" class="required">Role</label>
                                </div>
                                </div>
                                <div class="form-material col-sm-3">
                                    <button type="button" class="btn btn-primary" id="btnGetMenuMapping">Get Menu Mapping</button>
                                    <button type="button" class="btn btn-primary" id="btnReset">Reset</button>
                                </div>
                            </div>
                            <br/><br/>
                        
                            <!-- Drawer navigation -->
							<div id="menu_mapping_div">
                            @if (isset($menus) && sizeof($menus) > 0)
                            <nav class="drawer-main">
                                <!--a href="javascript:void(0)" id="closeBtn" class="closebtn" onclick="closeNav()" style="font-size:35px;float:right;margin-top: -34%;margin-right: 5%;">&times;</a>-->
                                <ul class="nav nav-drawer">
                                    <li class="nav-item nav-drawer-header">Components</li>
                                    @foreach ($menus as $mainMenu)
                                    @if ( count($mainMenu->subMenus) > 0 )
                                    <li class="nav-item nav-item-has-subnav">
                                    @else
                                    <li class="nav-item">
                                    @endif
                                        @if ( count($mainMenu->subMenus) > 0 )
                                        <a href="javascript:void(0)">
                                            <input type="checkbox" name="chkMainMenu[]" id="mainMenu{{$loop->index}}" class="main-menus" 
                                            loop-index="{{ $loop->index }}" value="{{ $mainMenu->id }}"
                                            @if ($mainMenu->mapping_status == 1) checked="checked" @endif)
                                            />
                                            <i class="{{$mainMenu->menu_icon}}"></i>{{ $mainMenu->menu_name}}
                                        </a>
                                        @else
                                        <a href="javascript:void(0)">
                                            <input type="checkbox" name="chkMainMenu[]" id="mainMenu{{$loop->index}}" class="main-menus" 
                                            loop-index="{{ $loop->index }}" value="{{ $mainMenu->id }}" 
                                            @if ($mainMenu->mapping_status == 1) checked="checked" @endif
                                            />
                                            <i class="{{$mainMenu->menu_icon}}"></i>{{ $mainMenu->menu_name}}
                                        </a>
                                        @endif
                                        @if ( count($mainMenu->subMenus) > 0 )
                                        <ul class="nav nav-subnav">
                                            @foreach ($mainMenu->subMenus as $subMenu)
                                            <li>
                                                <a href="javascript:void(0)">
                                                    <input type="checkbox" name="chkSubMenu[]" id="subMenu{{$loop->parent->index . '-' . $loop->index}}" 
                                                        class="sub-menu-{{ $loop->parent->index }} sub-menus"
                                                        loop-index="{{ $loop->index }}"
                                                        main-menu-index="{{ $loop->parent->index }}" value="{{ $subMenu->id }}" 
                                                        @if ($subMenu->mapping_status == 1) checked="checked" @endif
                                                        />
                                                    {{ $subMenu->menu_name }}
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                            </nav>
                            @endif
							</div>
                            <div class="form-group">
                                <div class="form-material col-sm-3">
                                    <button type="button" class="btn btn-success" id="btnUpdateMapping">Update Menu Mapping</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- .card-block -->
                </div>
                <!-- .card -->
                <!-- End Static Labels -->
            </div>
        </div>
        <!-- .row -->
        <!-- End CSS Checkboxes -->
    </div>
    <!-- End Page Content -->
</main>
@include('common.footer')