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
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,900%7CRoboto+Slab:300,400%7CRoboto+Mono:400" />

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
        <script src="{!! asset('js/toggle.js') !!}"></script>
        <link rel="stylesheet" href="{!! asset('theme/assets/js/plugins/select2/select2.min.css') !!}" />
        <link rel="stylesheet" href="{!! asset('theme/assets/js/plugins/select2/select2-bootstrap.css') !!}" />
        <script src="{!! asset('theme/assets/js/plugins/select2/select2.full.min.js') !!}"></script>
        <script>
            let isRoleEdit = false;
            const baseURL = "{{ url('/') }}";
            const shouldShowPopupOnValidation = true;
            const publicBaseURL = "{{ url('/public/index.php/') }}";
			const loggedInUserRole = Number("{{ Session::get('loggedInUserRole') }}");
            function getBaseURL() {
                if (window.location.hostname === "localhost" || window.location.hostname === "127.0.0.1") {
                    return "{{ url('/') }}";
                } else {
                    return "{{ url('/public/index.php/') }}";
                }
            }
            window.history.forward();
            function noBack() {
                window.history.forward();
            }
            window.onload = noBack();
            window.onunload = function () { null }; 
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
            .width_250{
                width:250px ;
            }
            .width_0{
                width:0px ;
            }
            .margin_left_0{
                padding-left:0px !important;
            }
            .margin_left_250{
                padding-left:250px !important;
            }
         
            fieldset {
            background-color: #eeeeee;
            border: 1px solid #c0c0c0;
            margin: 0 2px;
            padding: 0.35em 0.625em 0.75em
            }

            legend {
            background-color: gray;
            color: white;
            padding: 5px 10px;
            }
    
   
    @media all and (min-width: 0) and (max-width: 767px) {
        .width_250{
            width:250px;
            z-index:5;
        }
        .width_0{
            width:0px;
        }
        .margin_left_0{
            padding-left:0px !important;
        }
        .margin_left_250{
            padding-left:0px;
        }
    
        .back_gr{
            background: #0000007a;
            z-index: 5;;
        }
       
       
    }


        </style>
    </head>

    <body class="app-ui layout-has-drawer layout-has-fixed-header" id="layout-has-drawer">
        <div class="app-layout-canvas">
            <div class="app-layout-container">
            