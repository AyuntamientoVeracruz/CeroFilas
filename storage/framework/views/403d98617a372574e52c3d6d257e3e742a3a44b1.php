<!DOCTYPE html>
<html lang="en">

  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="Cerofilas">
    
    <link rel="shortcut icon" href="<?php echo e(url('/sis/img/favicon.ico')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(__('lblCeroFilas')); ?></title>
    <!-- Icons -->
    <link href="<?php echo e(url('/sis/vendors/css/flag-icon.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(url('/css/all.css')); ?>" type="text/css" media="all">
    <link href="<?php echo e(url('/sis/vendors/css/simple-line-icons.min.css')); ?>" rel="stylesheet">
    <!-- Main styles for this application -->
    <link rel="stylesheet" href="<?php echo e(url('/css/bootstrap-datepicker.min.css')); ?>" />
    <link href="<?php echo e(url('/sis/css/style.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(url('/sis/vendors/css/select2.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(url('/css/lightbox.min.css')); ?>" rel="stylesheet">
    <?php echo $__env->yieldContent('page-style-files'); ?>
  </head>

  <body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">


    <div class="loading-main">
        <div class="loader"><?php echo e(__('lblLoading')); ?></div>
    </div>

    <div class="responsemessage"></div>

    <header class="app-header navbar">

      <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="<?php echo e(route('sistema', app()->getLocale())); ?>"></a>
      <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
        <span class="navbar-toggler-icon"></span>
      </button>


      <ul class="nav navbar-nav ml-auto">        
        <li class="nav-item dropdown">
          <a class="nav-link wavatar" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <span class="img-avatar" style="width:35px; overflow:hidden; float:left;border-radius:50%"><img src="<?php echo e(url('/sis/img/user.svg')); ?>" style="width:100%"></span> 
            <span style="float:right; text-align:right; line-height:18px"><?php echo e($data['name']); ?><br>
              <b style="font-size:11px"><?php if( $data['rol'] == 'tramitador'): ?> Asesor <?php endif; ?> <?php if( $data['rol'] == 'admin_oficina'): ?> Administrador Oficina <?php endif; ?> <?php if( $data['rol'] == 'superadmin'): ?> Superadministrador <?php endif; ?> <?php if( $data['rol'] == 'kiosko'): ?> Kiosko <?php endif; ?></b>
            </span>
          </a>

          <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-header text-center">
              <strong>Cuenta</strong>
            </div>
            <!--<a class="dropdown-item" href="#"><i class="icon-user"></i> Perfil</a>-->          
            <div class="divider"></div>                      	
            <a class="dropdown-item" href="<?php echo e(route('logout', app()->getLocale())); ?>">
              <i class="icon-lock"></i> <?php echo e(__('lblLogout')); ?>

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
              <a class="nav-link" href="<?php echo e(route('sistema', app()->getLocale())); ?>"><i class="icon-speedometer"></i>  <?php echo e(__('lblDashboard')); ?></a>
            </li>
            <?php if( $data['rol'] == 'admin_oficina' || $data['rol'] == 'superadmin'): ?>            
              <li class="nav-title">
              <?php echo e(__('lblCatalogs')); ?>

              </li>
              <?php if($data['rol'] == 'superadmin'): ?>
                <li class="nav-item">
                  <a href="<?php echo e(route('dependencias', app()->getLocale())); ?>" class="nav-link"><i class="far fa-building"></i> <?php echo e(__('lblUnits')); ?></a>
                </li>
              <?php endif; ?>            
              <li class="nav-item">
                <a href="<?php echo e(route('tramites', app()->getLocale())); ?>" class="nav-link"><i class="far fa-file-alt"></i> <?php echo e(__('lblFormalities')); ?></a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('usuarios', app()->getLocale())); ?>" class="nav-link"><i class="far fa-user"></i> <?php echo e(__('lblUsers')); ?></a>
              </li>           
            <?php endif; ?> 
            <?php if($data['rol'] == 'tramitador'): ?>
            <li class="nav-item">
              <a href="<?php echo e(route('viewerturnoscitas', app()->getLocale())); ?>" class="nav-link"><i class="fa fa-list"></i> <?php echo e(__('lblAppointmentViewer')); ?></a>
            </li>
            <?php endif; ?>             
            <li class="nav-title">
            <?php echo e(__('lblConfiguration')); ?>

            </li>		      
            <li class="nav-item">
              <a href="<?php echo e(route('perfil', app()->getLocale())); ?>" class="nav-link"><i class="far fa-id-card"></i> <?php echo e(__('lblProfile')); ?></a>
            </li>         
  		      <li class="nav-item">
              <a class="nav-link" href="<?php echo e(route('logout',app()->getLocale())); ?>" >
                <i class="icon-lock"></i> <?php echo e(__('lblLogout')); ?>

              </a>
            </li>	
          </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
      </div>

  <!--*******************************************************************************************-->

          <?php echo $__env->yieldContent('content'); ?>

  <!--*******************************************************************************************-->

          

    </div>

    <footer class="app-footer">
      <span><a href="http://www.veracruzmunicipio.gob.mx">CeroFilas</a> © <?php echo e(__('lblAllRightsReserved')); ?></span>
    </footer>

    <!-- Bootstrap and necessary plugins -->
    <script src="<?php echo e(url('/sis/vendors/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(url('/sis/vendors/js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(url('/sis/vendors/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(url('/sis/vendors/js/bootstrap-confirmation.min.js')); ?>"></script>
    <script src="<?php echo e(url('/sis/vendors/js/pace.min.js')); ?>"></script>
    <script src="<?php echo e(url('/sis/vendors/js/select2.js')); ?>"></script>
    <!-- CoreUI main scripts -->
    <script src="<?php echo e(url('/sis/js/app.js')); ?>"></script>
    <!-- Plugins and scripts required by this views -->
    <!-- Custom scripts required by this view -->
    <!--for combo autocomplete-->    
    
    <!--others-->
    <script src="<?php echo e(url('/sis/js/views/popovers.js')); ?>"></script>
    <script src="<?php echo e(url('/js/moment.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('/js/moment-with-locales.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('/sis/vendors/js/bootstrap-datepicker.min.js')); ?>"></script>   
    <script src="<?php echo e(url('/sis/vendors/js/bootstrap-datepicker.es.min.js')); ?>"></script> 
    <!--<script src="<?php echo e(url('/sis/vendors/js/lightbox.min.js')); ?>"></script>-->
    <?php echo $__env->yieldContent('page-js-script'); ?>

  </body>

</html>
