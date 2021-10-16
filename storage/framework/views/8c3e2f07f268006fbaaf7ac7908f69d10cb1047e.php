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
</head>

<body class="fullscreen">
    <div class="loading-main">
        <div class="loader"><?php echo e(__('lblLoading')); ?></div>
    </div>  

    <?php echo $__env->yieldContent('content'); ?>   

    <script src="<?php echo e(url('/js/jquery-2.1.4.min.js')); ?>" type="text/javascript"></script>
    <!--time (moment)-->
    <script src="<?php echo e(url('/js/moment.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('/js/moment-with-locales.min.js')); ?>" type="text/javascript"></script>
    
    <script type="text/javascript">  
     var lblPlacheHolderSearch="<?php echo e(__('lblPlacheHolderSearch')); ?>"; 

        

    </script>
    
    <!--combobox search (select2)-->
    <script src="<?php echo e(url('/js/select2.full.js')); ?>"></script>        
    
    <?php echo $__env->yieldContent('page-js-script'); ?>

</body>
</html>
