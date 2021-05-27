 <!-- Drawer -->
 <aside class="app-layout-drawer" id="app-layout-drawer">

<!-- Drawer scroll area -->
<div class="app-layout-drawer-scroll">
    <!-- Drawer logo -->
    <div id="logo" class="drawer-header">
        <a href="{{ url('/dashboard') }}"><img class="img-responsive" src="{!! asset('theme/assets/img/logo/logo.png') !!}" title="AppUI" alt="AppUI" /></a>
    </div>

    <!-- Drawer navigation -->
    <nav class="drawer-main">
        <!--a href="javascript:void(0)" id="closeBtn" class="closebtn" onclick="closeNav()" style="font-size:35px;float:right;margin-top: -34%;margin-right: 5%;">&times;</a>-->
        <ul class="nav nav-drawer">
       
            <li class="nav-item nav-drawer-header">Apps</li>
           @if(Session::get("loggedInUserRole") == 1 || Session::get("loggedInUserRole") == 7)
            <li class="nav-item active">
                <a href="{{ url('/dashboard') }}"><i class="ion-ios-speedometer-outline"></i> Dashboard</a>
            </li>
        
            <li class="nav-item nav-drawer-header">Components</li>
            <li class="nav-item nav-item-has-subnav">
                <a href="javascript:void(0)"><i class="ion-ios-calculator-outline"></i>Master</a>
                <ul class="nav nav-subnav">

                    <li>
                        <a href="{{ url('/role/list') }}">All Roles</a>
                    </li>
                    <li>
                        <a href="{{ url('/paymentterms/list') }}">All Payment Terms</a>
                    </li>

                </ul>
            </li>

            <li class="nav-item nav-item-has-subnav">
                <a href="javascript:void(0)"><i class="ion-ios-calculator-outline"></i>Users</a>
                <ul class="nav nav-subnav">

                    <li>
                        <a href="{{ url('/add/user') }}">Add Users</a>
                    </li>

                    <li>
                        <a href="{{ url('/all/user') }}">All Users</a>
                    </li>
                                   

                </ul>
            </li>

            <li class="nav-item nav-item-has-subnav">
                <a href="javascript:void(0)"><i class="ion-ios-compose-outline"></i> Customer/Client</a>
                <ul class="nav nav-subnav">

                    <li>
                        <a href="{{ url('/add/customer') }}">Add Customer</a>
                    </li>

                    <li>
                        <a href="{{ url('/all/customer') }}">All Customer</a>
                    </li>
                </ul>
            </li>
            @endif
            <li class="nav-item nav-item-has-subnav">
                <a href="javascript:void(0)"><i class="ion-ios-list-outline"></i>Order</a>
                <ul class="nav nav-subnav">
                    @if(Session::get("loggedInUserRole") == 2 || Session::get("loggedInUserRole") == 1 || Session::get("loggedInUserRole") == 6 || Session::get("loggedInUserRole") == 7)
                    <li>
                        <a href="{{url('/add/order') }}">Add New Order</a>
                    </li>
                    @endif
                    @if(Session::get("loggedInUserRole") == 1 || Session::get("loggedInUserRole") == 6 ||Session::get("loggedInUserRole") == 7)
                    <li>
                        <a href="{{url('/all/orders') }}">Manage Order</a>
                    </li>
                    @endif
                    @if(Session::get("loggedInUserRole") == 5 || Session::get("loggedInUserRole") == 1 || Session::get("loggedInUserRole") == 7)
                    <li>
                        <a href="{{ url('/add/installation') }} ">Add Installation Details</a>
                    </li>
                    @endif
                    @if(Session::get("loggedInUserRole") == 1 || Session::get("loggedInUserRole") == 4 || Session::get("loggedInUserRole") == 7)
                    <li>
                        <a href="{{ url('/add/paymentdetails')}}">Add Payment Details</a>
                    </li>
                    @endif
                </ul>
            </li>
          


        </ul>
    </nav>
    <!-- End drawer navigation -->

    <div class="drawer-footer">
        <p class="copyright">EVISKA &copy;</p>
        <a href="#" target="_blank" rel="nofollow">Securing trust</a>
    </div>
</div>
<!-- End drawer scroll area -->
</aside>
<!-- End drawer -->

                <!-- Header -->
                <header class="app-layout-header" id="app-layout-header">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">
                            <span style="font-size:25px;cursor:pointer" class="hidden-xs hidden-sm" onclick="openNav()">&#9776;</span>
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar-collapse" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
				            </button>
                                <button class="pull-left hidden-lg hidden-md navbar-toggle" type="button" data-toggle="layout" data-action="sidebar_toggle">
					<span class="sr-only">Toggle drawer</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
                <span class="navbar-page-title">
                    EVISKA (Security trust)
				</span>
                </div>

                            <div class="collapse navbar-collapse" id="header-navbar-collapse">
                                <!-- Header search form 
                                <form class="navbar-form navbar-left app-search-form" role="search">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control" type="search" id="search-input" placeholder="Search..." />
                                            <span class="input-group-btn">
								                <button class="btn" type="button"><i class="ion-ios-search-strong"></i></button>
							                </span>
                                        </div>
                                    </div>
                                </form>-->


                                <ul class="nav navbar-nav navbar-right navbar-toolbar hidden-sm">
                                   
                                   
                                    <li class="dropdown dropdown-profile">
                                        <a href="javascript:void(0)" data-toggle="dropdown">
                                            <span class="m-r-sm">{{ Session::get("userFullName")}} <span class="caret"></span></span>
                                            <img class="img-avatar img-avatar-48" src="{!! asset('theme/assets/img/avatars/avatar3.jpg') !!}" alt="User profile pic" />
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li class="dropdown-header">
                                                My Account
                                            </li>
                                            <li>
                                                <a href="{{ url('/users/profile')}}">Profile</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/logout') }}">Logout</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <!-- .navbar-right -->
                            </div>
                        </div>
                        <!-- .container-fluid -->
                    </nav>
                    <!-- .navbar-default -->
                </header>
                <!-- End header -->