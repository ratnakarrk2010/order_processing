<!DOCTYPE html>

<html class="app-ui">

    <head>
        <!-- Meta -->
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

        <!-- Document title -->
        <title>Login</title>

        <meta name="description" content="AppUI - Frontend Template & UI Framework" />
        <meta name="robots" content="noindex, nofollow" />

        <!-- Favicons -->
        <link rel="apple-touch-icon" href="{!! asset('theme/assets/img/favicons/apple-touch-icon.png') !!}" />
        <link rel="icon" href="{!! asset('theme//assets/img/favicons/favicon.ico') !!}" />

        <!-- Google fonts -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,900%7CRoboto+Slab:300,400%7CRoboto+Mono:400" />

        <!-- AppUI CSS stylesheets -->
        <link rel="stylesheet" id="css-font-awesome" href="{!! asset('theme/assets/css/font-awesome.css') !!}" />
        <link rel="stylesheet" id="css-ionicons" href="{!! asset('theme/assets/css/ionicons.css') !!}" />
        <link rel="stylesheet" id="css-bootstrap" href="{!! asset('theme/assets/css/bootstrap.css') !!}" />
        <link rel="stylesheet" id="css-app" href="{!! asset('theme/assets/css/app.css') !!}" />
        <link rel="stylesheet" id="css-app-custom" href="{!! asset('theme/assets/css/app-custom.css') !!}" />
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
        <style>
        form label.required:after {
            color: red;
            content: " *";
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        .field-error {
            color: #FF0000;
            font-size:85%;
        }

        .highlight_error {
            border: 1px solid #FF0000
        }
    </style>
        <!-- End Stylesheets -->
    </head>

    <body class="app-ui">
        <div class="app-layout-canvas">
            <div class="app-layout-container">

                <!-- Header -->
                <header class="app-layout-header">
                    <nav class="navbar navbar-default p-y">
                        <div class="container">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar-collapse" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
                                <!-- Header logo -->
                                <a class="navbar-brand" href="javascript:void(0)">
                                    <img class="img-responsive" src="{!! asset('theme/assets/img/logo/logo.png') !!}" title="AppUI" alt="AppUI" />
                                </a>
                            </div>

                            <div class="collapse navbar-collapse" id="header-navbar-collapse">
                                <!-- Header search form -->
                                <form class="navbar-form navbar-right app-search-form">
                                    <p><b>Email:</b> test@gmail.com&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<b>Mobile:</b> 888888888</p>
                                    </form>

                              
                                <!-- End header navigation menu -->
                            </div>
                        </div>
                        <!-- .container -->
                    </nav>
                    <!-- .navbar -->
                </header>
                <!-- End header -->

              
                    <!-- End Page header -->
