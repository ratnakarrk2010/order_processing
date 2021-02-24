<!DOCTYPE html>

<html class="app-ui">

    <head>
        <!-- Meta -->
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

        <!-- Document title -->
        <title>Dashboard | Eviska</title>

        <meta name="description" content="AppUI - Admin Dashboard Template & UI Framework" />
        <meta name="author" content="rustheme" />
        <meta name="robots" content="noindex, nofollow" />

        <!-- Favicons -->
        <link rel="apple-touch-icon" href="{!! asset('theme/assets/img/favicons/apple-touch-icon.png') !!}" />
        <link rel="icon" href="{!! asset('theme/assets/img/favicons/favicon.ico') !!}" />

        <!-- Google fonts -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,900%7CRoboto+Slab:300,400%7CRoboto+Mono:400" />

        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="{!! asset('theme/assets/js/plugins/slick/slick.min.css') !!}" />
        <link rel="stylesheet" href="{!! asset('theme/assets/js/plugins/slick/slick-theme.min.css') !!}" />

        <!-- AppUI CSS stylesheets -->
        <link rel="stylesheet" id="css-font-awesome" href="{!! asset('theme/assets/css/font-awesome.css') !!}" />
        <link rel="stylesheet" id="css-ionicons" href="{!! asset('theme/assets/css/ionicons.css') !!}" />
        <link rel="stylesheet" id="css-bootstrap" href="{!! asset('theme/assets/css/bootstrap.css') !!}" />
        <link rel="stylesheet" id="css-app" href="{!! asset('theme/assets/css/app.css') !!}" />
        <link rel="stylesheet" id="css-app-custom" href="{!! asset('theme/assets/css/app-custom.css') !!}" />
        <link rel="stylesheet" id="css-app" href="{!! asset('theme/assets/css/form.css') !!}" />
        <script src="{!! asset('theme/assets/js/core/jquery.min.js') !!}"></script>
        <script src="{!! asset('theme/assets/js/core/bootstrap.min.js') !!}"></script>
        <script src="{!! asset('theme/assets/js/core/jquery.slimscroll.min.js') !!}"></script>
        <script src="{!! asset('theme/assets/js/core/jquery.scrollLock.min.js') !!}"></script>
        <script src="{!! asset('theme/assets/js/core/jquery.placeholder.min.js') !!}"></script>
        <script src="{!! asset('theme/assets/js/app.js') !!}"></script>
        <script src="{!! asset('theme/assets/js/app-custom.js') !!}"></script>
        <script src="{!! asset('js/lib/lodash.min.js') !!}"></script>
        <script src="{!! asset('js/lib/moment.min.js') !!}"></script>
        <script src="{!! asset('js/utils.js') !!}"></script>
        <link rel="stylesheet" href="{!! asset('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') !!}">
        <link rel="stylesheet" href="{!! asset('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') !!}">

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.8/css/fixedHeader.bootstrap.min.css">
        <link rel="stylesheet" id="css-app" href="{!! asset('theme/assets/css/toggle.css') !!}" />
        
      <!-- DataTables -->
        <script src="{!! asset('theme/plugins/datatables/jquery.dataTables.min.js') !!}"></script>
        <script src="{!! asset('theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') !!}"></script>
        <script src="{!! asset('theme/plugins/datatables-responsive/js/dataTables.responsive.min.js') !!}"></script>
        <script src="{!! asset('theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') !!}"></script>
        <script src="https://cdn.datatables.net/fixedheader/3.1.8/js/dataTables.fixedHeader.min.js"></script>
          <!-- Page JS Plugins -->
        <!-- Page JS Code -->
        <script src="{!! asset('theme/assets/js/pages/form_table.js')!!}"></script>
        <script src="{!! asset('js/lib/axios.min.js') !!}"></script>
        <script src="{!! asset('js/lib/bootbox.min.js') !!}"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script>
            $(document).ready(function() {
                //var id = $.session.get('loggedInUserId');
               // console.log("id==>"+id);
            });

            const baseURL = "{{ url('/') }}";

            function openNav() {
                document.getElementById("app-layout-drawer").style.width = "250px";
                document.getElementById("app-layout-content").style.paddingLeft = "240px";
                
            }

            function closeNav() {
                document.getElementById("app-layout-drawer").style.width = "0";
                document.getElementById("app-layout-content").style.paddingLeft = "0px";
                document.getElementById("layout-has-drawer").style.paddingLeft = "0px";
                document.getElementById("app-layout-header").style.paddingLeft = "0px";
              
                //layout-has-drawer .app-layout-header
            }
            

           
        </script>
        <!-- End Stylesheets -->
        <style>
            form label.required:after {
                color: red;
                content: " *";
            }

           
            .success{
                color: green !important;
                font-size:85%!important;;
                margin-top: 0px !important;;
            }

            .error {
                color: red;
                margin-top:-2%;
            }

            .field-error {
                color: #FF0000;
                font-size:85%;
            }

            .highlight_error {
                border: 1px solid #FF0000
            }
           
        </style>
    </head>

    <body class="app-ui layout-has-drawer layout-has-fixed-header" id="layout-has-drawer">
        <div class="app-layout-canvas">
            <div class="app-layout-container">
            