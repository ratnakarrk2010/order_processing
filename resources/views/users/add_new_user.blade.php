@include('common.header')
<script src="{!! asset('js/users/user_form_validations.js') !!}"></script>
<script src="{!! asset('js/users/user.js') !!}"></script>
<style>
  
</style>
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
                    <h4>Add New User</h4>
                </div>
                <hr />
                <div class="card-block">
                    <form class="form-horizontal m-t-sm" action="{{ url('/save/user') }}" method="post" id="addUserFormID" name="addUserForm">
                    {{ csrf_field() }}
                    @include('common.flash-message')
                   
                        <div class="form-group">
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <select class="form-control" id="role_id" name="role_id" size="1">
                                        <option value="">---Select---</option>
                                        @if(isset($allRoles))
                                        {{ $allRoles }}
                                            @foreach($allRoles as $role)
                                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="user_role" class="required">Role</label>
                                    <div class="field-error" id="role_id_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="First_Name" name="first_name" placeholder="Please enter First Name">
                                    <label class="required" for="First_Name">First Name</label>
                                    <div class="field-error" id="first_name_error"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="Last_Name" name="last_name" placeholder="Please enter Last Name">
                                    <label for="Last_Name">Last Name</label>
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group">
                      
                            <div class="col-sm-4">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="username" name="username" placeholder="Please enter user name" />
                                        <label for="username" class="required" >User Name</label>
                                        <div class="field-error" id="username_error"></div>
                                    </div>
                            </div>
                            <div class="col-sm-4">
                                    <div class="form-material">
                                        <input class="form-control" type="email" id="email" name="email" placeholder="Please enter email">
                                        <label for="email">Email</label>
                                    </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-material">
                                    <input class="form-control" type="password" name="password" id="password" placeholder="Please enter password"/>
                                    <label for="password" class="required">Password</label>
                                    <div class="field-error" id="password_error"></div>
                                </div>
                            </div>
                                                     
                        </div>
                        <div class="form-group m-b-0">
                            <div class="col-sm-9">
                                <button class="btn btn-app" type="button" name="btnAddNewUser" id="btnAddNewUser">Submit</button>
                                <button class="btn btn-app-red	" type="reset" id="">Cancel</button>
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