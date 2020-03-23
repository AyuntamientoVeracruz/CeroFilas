<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" href="{{url('/sis/img/favicon.ico')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Citas para trámites</title>
    <!--bootstrap main-->
    <link rel="stylesheet" href="{{url('/css/bootstrap.css')}}" type="text/css" media="all">
    <!--tooltip-->
    <link rel="stylesheet" href="{{url('/css/tooltipster.bundle.min.css')}}" type="text/css" media="all" />
    <!--fontawesome-->
    <link rel="stylesheet" href="{{url('/css/all.css')}}" type="text/css" media="all">
    <!--combobox (select2)-->
    <link rel="stylesheet" href="{{url('/css/select2.min.css')}}">
    @yield('page-style-files')
</head>

<body class="fullscreen">
    <div class="loading-main">
        <div class="loader">Cargando...</div>
    </div>  

    @yield('content')   

    <script src="{{url('/js/jquery-2.1.4.min.js')}}" type="text/javascript"></script>
    <!--time (moment)-->
    <script src="{{url('/js/moment.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/js/moment-with-locales.min.js')}}" type="text/javascript"></script>
    <!--combobox search (select2)-->
    <script src="{{url('/js/select2.full.js')}}"></script>        
    
    @yield('page-js-script')

</body>
</html>
