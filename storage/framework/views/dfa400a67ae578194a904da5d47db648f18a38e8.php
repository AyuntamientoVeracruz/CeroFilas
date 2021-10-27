<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" href="<?php echo e(url('/sis/img/favicon.ico')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(__('lblAppointments')); ?></title>
    <!--bootstrap main-->
    <link rel="stylesheet" href="<?php echo e(url('/css/bootstrap.css')); ?>" type="text/css" media="all">
    <!--tooltip-->
    <link rel="stylesheet" href="<?php echo e(url('/css/tooltipster.bundle.min.css')); ?>" type="text/css" media="all" />
    <!--fontawesome-->
    <link rel="stylesheet" href="<?php echo e(url('/css/all.css')); ?>" type="text/css" media="all">
    <!--combobox (select2)-->
    <link rel="stylesheet" href="<?php echo e(url('/css/select2.min.css')); ?>">
    <?php echo $__env->yieldContent('page-style-files'); ?>
    <style type="text/css">
        .footerin{ width:100%; float: left; height: 100% }
    </style>
</head>

<body id="home"> 

    <div class="headerwrapper">
        <div class="container">
            <header>                    
                <a href="https://www.veracruzmunicipio.gob.mx" class="logoheadercontainer"><img src="<?php echo e(url('/images/logo.png')); ?>" class="logo"></a>                    
                <div class="col-sm-4">
                    <h2><?php echo e(__('titlesite')); ?></h2>
                    <?php echo $__env->yieldContent('initlink'); ?>
                </div>
                <div class="menucontainer">
                    <ul class="menu">
                        <li><a href="<?php echo e(route('faq', app()->getLocale())); ?>"><?php echo e(__('faq')); ?></a></li>
                        <li>
                            <label for="idioma" style="color: #E0B54B; font-size: 12px; text-transform: uppercase;"><?php echo e(__('language')); ?>:</label>
                            <select name="idioma" onchange="location = this.value;">
                                <option value="<?php echo e(route(Route::currentRouteName(), 'es')); ?>" <?php if( app()->getLocale() == "es" ): ?> selected <?php endif; ?>>ES</option>
                                <option value="<?php echo e(route(Route::currentRouteName(), 'en')); ?>" <?php if( app()->getLocale() == "en" ): ?> selected <?php endif; ?>>EN</option>
                            </select>
                        </li>
                        <!--<li><a href="">Contacto</a></li>-->
                        <!--<li class="rounded"><a href="">Iniciar sesión</a></li>-->
                    </ul>
                </div>
            </header>
            <div class="textcontainer">                
                <?php echo $__env->yieldContent('titlebig'); ?> 
            </div>
        </div>
    </div>

    <?php echo $__env->yieldContent('content'); ?>   

    <footer>
        <div class="footerin">
            <div class="container">
                <div class="col-sm-3 logofootercontainer">
                    <img src="<?php echo e(url('/images/logo-footer.jpg')); ?>" class="logofooter">
                </div>
                <div class="col-sm-5">
                    <b><?php echo e(__('lblfooter1')); ?> <br>
                    <?php echo e(__('lblfooter2')); ?> <br>
                    <?php echo e(__('lblfooter3')); ?></span></b>
                    
                </div>
                <div class="col-sm-4 bggray">
                    <p> <?php echo e(__('lblfooter4')); ?> <a href="#"> <?php echo e(__('lblfooter5')); ?></a><br><a href="#"> <?php echo e(__('lblfooter6')); ?></a></p>
                </div>
            </div>
        </div>
    </footer>

    <script src="<?php echo e(url('/js/jquery-2.1.4.min.js')); ?>" type="text/javascript"></script>
    <!--tooltip-->
    <script src="<?php echo e(url('/js/tooltipster.bundle.min.js')); ?>" type="text/javascript"></script>
    <!--time (moment)-->
    <script src="<?php echo e(url('/js/moment.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('/js/moment-with-locales.min.js')); ?>" type="text/javascript"></script>
    <!--combobox search (select2)-->
   
    <script type="text/javascript">  
     var lblPlacheHolderSearch="<?php echo e(__('lblPlacheHolderSearch')); ?>"; 

        

    </script>

<script src="<?php echo e(url('/js/select2.full.js')); ?>"></script>      
    
    <?php echo $__env->yieldContent('page-js-script'); ?>

</body>
</html>
