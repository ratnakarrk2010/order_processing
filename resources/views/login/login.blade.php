@include('common.login-header')
<script src="{!! asset('js/login/login_form_validations.js') !!}"></script>
<script src="{!! asset('js/login/login.js') !!}"></script>
<script>
$(document).ready(function() {
    $('input').on('keypress', (event)=> {
    if(event.which === 13){
        $('#btnLogin').click();
    }
    });
});

</script>


<main class="app-layout-content">
  <!-- Page header -->
  <div class="page-header bg-green bg-inverse">
   <div class="container">
         <!-- Section Content -->
         <div class="p-y-lg text-center">
            <h1 class="display-2">My Account Login</h1>
           
         </div>
         <!-- End Section Content -->
   </div>
</div>
<!-- Page content -->
<div class="page-content">
    <div class="container">
        <div class="row">
        <div class="col-md-3"></div>
            <!-- Login card -->
            <div class="col-md-6">
                <div class="card">
                    <h3 class="card-header h4">Login</h3>
                    <div class="card-block">
                        <form action="{{ url('/login') }}" method="post" id="loginFormID" name="loginForm">
                        @if(isset($error_message)) 
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $error_message }}</strong>
                        </div>
                        @endif
                        {{ csrf_field() }}
                        @include('common.flash-message')
                            <div class="form-group">
                                <label for="payment_terms" class="required">Username</label>
                                <input type="username" class="form-control" id="username" name="username" placeholder="Username" />
                                <div class="field-error" id="username_error"></div>
                            </div>
                            <div class="form-group">
                                <label class="required" for="frontend_login_password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
                                <div class="field-error" id="password_error"></div>
                            </div>
                            <!--<div class="form-group">
                                <label for="frontend_login_remember" class="css-input switch switch-sm switch-app">
                                 <input type="checkbox" id="remember_me" name="remember_me"/><span></span> Remember me</a>
                               </label>
                            </div>-->
                            <button type="button" class="btn btn-app btn-block" id="btnLogin">Login</button>
                            <div id="loader">
                                <img class="loading-img" src="{!! asset('img/ajax-loader.gif') !!}">
                            </div>
                        </form>
                    </div>
                   
                    <!-- .card-block -->
                </div>
                <!-- .card -->
            </div>
            <!-- .col-md-6 -->
            <!-- End login -->
            <div class="col-md-3"></div>
           

        </div>
        <!-- .row -->
    </div>
    <!-- .container -->
</div>
<!-- End page content -->



</main>
@include('common.login-footer')