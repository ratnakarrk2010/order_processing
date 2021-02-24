@include('common.header')
<script src="{!! asset('js/users/user_form_validations.js') !!}"></script>
<script src="{!! asset('js/users/user.js') !!}"></script>
@include('common.sidebar')

<main class="app-layout-content" id="app-layout-content">

 <!-- Page Content -->
 <div class="container-fluid p-y-md">
                        <div class="card card-profile">
                            <div class="card-profile-img bg-img" style="background-image: url(http://208.109.11.78:8080/theme/assets/img/misc/base_pages_profile_header_bg.jpg);">
                            </div>
                            <div class="card-block card-profile-block text-xs-center text-sm-left">
                                <img class="img-avatar img-avatar-96" src="{!! asset('theme/assets/img/avatars/avatar3.jpg') !!}" alt="" />
                                <div class="profile-info font-500"> {{$usersData->first_name}}  {{$usersData->last_name}}
                                    <div class="small text-muted m-t-xs">{{$usersData->email}}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <ul class="nav nav-tabs nav-stacked">
                                        <li class="active">
                                            <a href="#profile-tab1" data-toggle="tab">Account</a>
                                        </li>
                                        <li>
                                            <a href="#profile-tab3" data-toggle="tab">Change Password</a>
                                        </li>
                                        
                                    </ul>
                                    <!-- .nav-tabs -->
                                </div>
                                <!-- .card -->
                            </div>
                            <!-- .col-md-4 -->

                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-block tab-content">
                                        <!-- Profile tab 1 -->
                                        <div class="tab-pane fade in active" id="profile-tab1">
                                            <form class="fieldset" id="profileUpdateId" name="profileUpdate" method="post" action="{{ url('/update/profile')}}">
                                            <input type="hidden" id="id" name="id"  value="{{ $usersData->id}}"/>
                                            {{ csrf_field() }}
                                            @include('common.flash-message')
                                                <h4 class="m-t-sm m-b">General info</h4>
                                                <div class="form-group row">
                                                    <div class="col-xs-4">
                                                        <label for="exampleInputName1">Role</label>
                                                        <input type="text" class="form-control" id="role_name" name="role_name" readonly value="{{ $usersData->role_name}}"/>
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <label for="exampleInputName1" class="required">First name</label>
                                                        <input type="text" class="form-control" id="first_name" name="first_name"value="{{ $usersData->first_name}}" />
                                                        <div class="field-error" id="first_name_error"></div>
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <label for="exampleInputName2">Last name</label>
                                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                                        value="{{ $usersData->last_name}}"/>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xs-6">
                                                        <label for="exampleInputName1" class="required">Username</label>
                                                        <input type="text" class="form-control" id="username" name="username" value="{{ $usersData->username}}"/>
                                                        <div class="field-error" id="username_error"></div>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <label for="exampleInputName2">Email</label>
                                                        <input type="text" class="form-control" id="email" name="email" value="{{ $usersData->email}}"/>
                                                    </div>
                                                </div>
                                                                                           
                                                <div class="row narrow-gutter">
                                                    <div class="col-xs-6">
                                                        <button type="button" class="btn btn-danger btn-block">Cancel</button>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button type="button" id="btnProfileUpdate" class="btn btn-app btn-block">Save<span class="hidden-xs"> changes</span></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- End profile tab 1 -->
                                     

                                        <!-- Profile tab 3 -->
                                        <div class="tab-pane fade" id="profile-tab3">
                                            <form class="fieldset" method="post" action="{{ url('/change/password') }}" id="changePassFormID" name="changePassForm">
                                            {{ csrf_field() }}
                                            @include('common.flash-message')
                                                <h4 class="m-t-md m-b">Change password</h4>
                                                <div class="form-group row">
                                                    <div class="col-xs-4">
                                                        <label for="exampleInputPassword1" class="required">Confirm current password</label>
                                                        <input type="password" class="form-control" id="password" name="password" />
                                                        <div class="field-error" id="password_error"></div>
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <label for="exampleInputPassword3" class="required">New password</label>
                                                        <input type="password" class="form-control" id="new_password" name="new_password" />
                                                        <div class="field-error" id="new_password_error"></div>
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <label for="exampleInputPassword2" class="required">Confirm new password</label>
                                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" />
                                                        <div class="field-error" id="confirm_password_error"></div>
                                                    </div>
                                                   
                                                </div>
                                                
                                                <div class="row narrow-gutter">
                                                    <div class="col-xs-6">
                                                        <button type="button" class="btn btn-danger btn-block">Cancel</button>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button type="button" id="btnChangePass" class="btn btn-app btn-block">Save<span class="hidden-xs"> changes</span></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- End profile tab 3 -->

                                    </div>
                                    <!-- .card-block .tab-content -->
                                </div>
                                <!-- .card -->
                            </div>
                            <!-- .col-md-8 -->
                        </div>
                        <!-- .row -->
                    </div>
                    <!-- End Page Content -->

</main>

@include('common.footer')