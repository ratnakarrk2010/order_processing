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

        $(document).ready(function() {
            $(".form-group .form-control").blur(function() {
                if ($(this).val() != "") {
                    $(this).siblings("label").addClass("active");
                } else {
                    $(this).siblings("label").removeClass("active");
                }
            });
        });
    

</script>
<style>
     .form-group {
            position: relative;
        }
        label {
            position: absolute;
            left: 2%;
            top: 18%;
            transition: all .3s;
            color: #999;
            font-weight: normal;
        }
      .form-control:focus~label {
                left: 1.5%;
                top: -28%;
                background: #fff;
                padding: 0 5px;
                color: #0275d8!important;
            }
        
        label.active {
            left: 1.5%;
            top: -28%;
            background: #fff;
            padding: 0 5px;
        }

        .form-control:focus {
            border: 1.5px solid#0275d8 !important;
        }
</style>


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
        <div class="col-md-4"></div>
            <!-- Login card -->
            <div class="col-md-4">
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
                          
                               
                                <input type="username" class="form-control" id="username" name="username" autofocus  />
                                <label for="payment_terms" class="required ">Username</label>
                                <div class="field-error" id="username_error"></div>
                           
                            </div>
                            <div class="form-group">
                            
                             
                                <input type="password" class="form-control" id="password" name="password"  />
                                <label for="frontend_login_password" class="required">Password</label>
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
            <div class="col-md-4"></div>
           

        </div>
        <!-- .row -->
    </div>
    <!-- .container -->
</div>
<!-- End page content -->



</main>
@include('common.login-footer')