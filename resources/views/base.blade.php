<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->

    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .half-col {
            width: 1.4%;
        }

        .medium-col {
            width: 7.5%;
        }

        .body {
            background: url('https://drscdn.500px.org/photo/98384509/m%3D2048/eac292c7cd46de1b237d53618710c541');
            color: white;
        }

        input[type="text"], select
        {
            font-size: 14pt;
            color:white;
            background-color:rgba(0,0,0,0) !important;
            border:none !important;
        }
        select option {
            background: transparent !important;
            /*background: rgba(0,0,0,0);*/
            color:black;
            text-shadow:0 1px 0 rgba(0,0,0,0.4);
        }
        select {
            color: white !important;
            background: transparent !important;
        }
    </style>
</head>
<body class="body">
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
        your browser</a> to improve your experience.</p>
    <![endif]-->
    @yield('content')

    <script src="{{ asset('js/vendor/jquery-1.12.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
</body>
</html>
