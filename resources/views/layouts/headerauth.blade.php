<!DOCTYPE html>
<html lang="en">

  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="Cero Filas // Sistema CRM">
    <meta name="author" content="Angel Cobos www.arkanmedia.com">
    <link rel="shortcut icon" href="{{url('/sis/img/favicon.ico')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cero Filas // Sistema CRM</title>
    <!-- Icons -->
    <link href="{{url('/sis/vendors/css/flag-icon.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/css/all.css')}}" type="text/css" media="all">
    <link href="{{url('/sis/vendors/css/simple-line-icons.min.css')}}" rel="stylesheet">
    <!-- Main styles for this application -->
    <link rel="stylesheet" href="{{url('/css/bootstrap-datepicker.min.css')}}" />
    <link href="{{url('/sis/css/style.css')}}" rel="stylesheet">
    <link href="{{url('/sis/vendors/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{url('/css/lightbox.min.css')}}" rel="stylesheet">
    @yield('page-style-files')
  </head>

  <body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">


    <div class="loading-main">
        <div class="loader">Cargando...</div>
    </div>

    <div class="responsemessage"></div>

    <header class="app-header navbar">

      <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="{{route('sistema', app()->getLocale())}}"></a>
      <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
        <span class="navbar-toggler-icon"></span>
      </button>


      <ul class="nav navbar-nav ml-auto">        
        <li class="nav-item dropdown">
          <a class="nav-link wavatar" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <span class="img-avatar" style="width:35px; overflow:hidden; float:left;border-radius:50%"><img src="{{url('/sis/img/user.svg')}}" style="width:100%"></span> 
            <span style="float:right; text-align:right; line-height:18px">{{ $data['name'] }}<br>
              <b style="font-size:11px">@if( $data['rol'] == 'tramitador') Asesor @endif @if( $data['rol'] == 'admin_oficina') Administrador Oficina @endif @if( $data['rol'] == 'superadmin') Superadministrador @endif @if( $data['rol'] == 'kiosko') Kiosko @endif</b>
            </span>
          </a>

          <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-header text-center">
              <strong>Cuenta</strong>
            </div>
            <!--<a class="dropdown-item" href="#"><i class="icon-user"></i> Perfil</a>-->          
            <div class="divider"></div>                      	
            <a class="dropdown-item" href="{{route('logout', app()->getLocale())}}">
              <i class="icon-lock"></i> Cerrar sesión
            </a>
                                                                              
          </div>
        </li>
      </ul>

    </header>

    <div class="app-body">

      <div class="sidebar">
        <nav class="sidebar-nav">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="{{route('sistema', app()->getLocale())}}"><i class="icon-speedometer"></i> Dashboard</a>
            </li>
            @if( $data['rol'] == 'admin_oficina' || $data['rol'] == 'superadmin')            
              <li class="nav-title">
                Catálogos
              </li>
              @if($data['rol'] == 'superadmin')
                <li class="nav-item">
                  <a href="{{route('dependencias', app()->getLocale())}}" class="nav-link"><i class="far fa-building"></i> Dependencias</a>
                </li>
              @endif            
              <li class="nav-item">
                <a href="{{route('tramites', app()->getLocale())}}" class="nav-link"><i class="far fa-file-alt"></i> Trámites</a>
              </li>
              <li class="nav-item">
                <a href="{{route('usuarios', app()->getLocale())}}" class="nav-link"><i class="far fa-user"></i> Usuarios</a>
              </li>           
            @endif 
            @if($data['rol'] == 'tramitador')
            <li class="nav-item">
              <a href="{{route('viewerturnoscitas', app()->getLocale())}}" class="nav-link"><i class="fa fa-list"></i> Visor de turnos/citas</a>
            </li>
            @endif             
            <li class="nav-title">
              Configuración
            </li>		      
            <li class="nav-item">
              <a href="{{route('perfil', app()->getLocale())}}" class="nav-link"><i class="far fa-id-card"></i> Perfil</a>
            </li>         
  		      <li class="nav-item">
              <a class="nav-link" href="{{route('logout',app()->getLocale())}}" >
                <i class="icon-lock"></i> Cerrar sesión
              </a>
            </li>	
          </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
      </div>

  <!--*******************************************************************************************-->

          @yield('content')

  <!--*******************************************************************************************-->

          

    </div>

    <footer class="app-footer">
      <span><a href="http://www.veracruzmunicipio.gob.mx">CeroFilas</a> © 2019 Todos los derechos reservados.</span>
    </footer>

    <!-- Bootstrap and necessary plugins -->
    <script src="{{url('/sis/vendors/js/jquery.min.js')}}"></script>
    <script src="{{url('/sis/vendors/js/popper.min.js')}}"></script>
    <script src="{{url('/sis/vendors/js/bootstrap.min.js')}}"></script>
    <script src="{{url('/sis/vendors/js/bootstrap-confirmation.min.js')}}"></script>
    <script src="{{url('/sis/vendors/js/pace.min.js')}}"></script>
    <script src="{{url('/sis/vendors/js/select2.js')}}"></script>
    <!-- CoreUI main scripts -->
    <script src="{{url('/sis/js/app.js')}}"></script>
    <!-- Plugins and scripts required by this views -->
    <!-- Custom scripts required by this view -->
    <!--for combo autocomplete-->    
    
    <!--others-->
    <script src="{{url('/sis/js/views/popovers.js')}}"></script>
    <script src="{{url('/js/moment.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/js/moment-with-locales.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/sis/vendors/js/bootstrap-datepicker.min.js')}}"></script>   
    <script src="{{url('/sis/vendors/js/bootstrap-datepicker.es.min.js')}}"></script> 
    <!--<script src="{{url('/sis/vendors/js/lightbox.min.js')}}"></script>-->
    @yield('page-js-script')

  </body>

</html>
