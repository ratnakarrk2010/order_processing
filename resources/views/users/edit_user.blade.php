@include('common.header')
<script src="{!! asset('js/users/user_form_validations.js') !!}"></script>
<script src="{!! asset('js/users/user.js') !!}"></script>
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
                    <h4>Edit New User</h4>
                </div>
                <hr />
                <div class="card-block">
                    <form class="form-horizontal m-t-sm" action="{{ url('/users/update') }}" method="post" id="editUserFormId"  name="editUserForm">
                    <input type="hidden" id="userId" name="id" class="form-control" value="{{ isset($usersData->id) ? $usersData ->id: ''}}">

                    {{ csrf_field() }}
                    @include('common.flash-message')

                        <div class="form-group">
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <select class="form-control" id="role_id" name="role_id" size="1">
                                        <option value="">---Select---</option>
                                        @if(isset($allRoles))
                                            @foreach($allRoles as $role)
                                            @if (isset($usersData->role_id) && ($role->id == $usersData->role_id))
                                            <option value="{{ $role->id }}" selected="selected">{{ $role->role_name }}</option>
                                            @else
                                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                            @endif
                                            @endforeach
                                        @endif

                                      
                                    </select>
                                    <label for="user_role" class="required">Role</label>
                                    <div class="field-error" id="role_id_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="First_Name" name="first_name"
                                     placeholder="Please enter First Name" value="{{ $usersData->first_name}}">
                                    <label for="First_Name">First Name</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="Last_Name" name="last_name"
                                     placeholder="Please enter Last Name" value="{{ $usersData->last_name}}">
                                    <label for="Last_Name">Last Name</label>
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group">
                        <div class="col-sm-6">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="username_edit" name="username" 
                                    placeholder="Please enter user name" value="{{ $usersData->username}}" />
                                    <label for="username" class="required" >User Name</label>
                                    <div class="field-error" id="username_edit_error"></div>
                                </div>
                            </div>
                           
                           
                            <div class="col-sm-6">
                                <div class="form-material">
                                    <input class="form-control" type="email" id="email" name="email" 
                                    placeholder="Please enter email"  value="{{ $usersData->email}}">
                                    <label for="email">Email</label>
                                </div>
                            </div>
                        </div>
                        <!-- can u plz call mw -->
                        <div class="form-group m-b-0">
                            <div class="col-sm-9">
                                <button class="btn btn-app" type="button" name="btnUpdateUser" id="btnUpdateUser">Update</button>
                                <a href="/all/user" ><button class="btn btn-app-red	" type="button" id="">Cancel</button></a>
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