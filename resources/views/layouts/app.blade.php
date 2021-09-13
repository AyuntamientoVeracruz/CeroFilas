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
    <style type="text/css">
        .footerin{ width:100%; float: left; height: 100% }
    </style>
</head>

<body id="home"> 

    <div class="headerwrapper">
        <div class="container">
            <header>                    
                <a href="https://www.veracruzmunicipio.gob.mx" class="logoheadercontainer"><img src="{{url('/images/logo.png')}}" class="logo"></a>                    
                <div class="col-sm-4">
                    <h2>{{ __('titlesite') }}</h2>
                    @yield('initlink')
                </div>
                <div class="menucontainer">
                    <ul class="menu">
                        <li><a href="{{route('faq', app()->getLocale())}}">{{ __('faq') }}</a></li>
                        <li>
                            <label for="idioma" style="color: #E0B54B; font-size: 12px; text-transform: uppercase;">{{ __('language') }}:</label>
                            <select name="idioma" onchange="location = this.value;">
                                <option value="{{ route(Route::currentRouteName(), 'es') }}" @if( app()->getLocale() == "es" ) selected @endif>ES</option>
                                <option value="{{ route(Route::currentRouteName(), 'en') }}" @if( app()->getLocale() == "en" ) selected @endif>EN</option>
                            </select>
                        </li>
                        <!--<li><a href="">Contacto</a></li>-->
                        <!--<li class="rounded"><a href="">Iniciar sesión</a></li>-->
                    </ul>
                </div>
            </header>
            <div class="textcontainer">                
                @yield('titlebig') 
            </div>
        </div>
    </div>

    @yield('content')   

    <footer>
        <div class="footerin">
            <div class="container">
                <div class="col-sm-3 logofootercontainer">
                    <img src="{{url('/images/logo-footer.jpg')}}" class="logofooter">
                </div>
                <div class="col-sm-5">
                    <b>H. Ayuntamiento de la Ciudad y Puerto de Veracruz.<br><span>Zaragoza esq. M. Molina s/n<br>
                    Col. Centro, Veracruz, Ver. <br>
                    Teléfono: 01 (229) 200.2000.</span></b>
                    
                </div>
                <div class="col-sm-4 bggray">
                    <p>Línea Veracruz <a href="tel:018009999837">01.800.9999.837</a><br><a href="mailto:info@veracruzmunicipio.gob.mx">info@veracruzmunicipio.gob.mx</a></p>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{url('/js/jquery-2.1.4.min.js')}}" type="text/javascript"></script>
    <!--tooltip-->
    <script src="{{url('/js/tooltipster.bundle.min.js')}}" type="text/javascript"></script>
    <!--time (moment)-->
    <script src="{{url('/js/moment.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/js/moment-with-locales.min.js')}}" type="text/javascript"></script>
    <!--combobox search (select2)-->
    <script src="{{url('/js/select2.full.js')}}"></script>    
    
    @yield('page-js-script')

</body>
</html>
