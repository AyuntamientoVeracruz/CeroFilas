<!DOCTYPE html>
<html>
<head>
    <title><?php echo e(__('titleRequesting')); ?></title>
</head>

<body>

<div style="width:100%; background:#fff; padding:0px; color:#333; font-family:Arial,'Century Gothic',Tahoma; margin-bottom:10px; font-size:12px;max-width:647px; margin:0 auto">								
								    
    <div>
        <h1 style="font-size:18px"><?php echo e(__('Hello ')); ?> <?php echo e($turno->nombre_ciudadano); ?>!</h1>        
        <p style="font-size:13px"><?php echo e(__('lblRequesting1')); ?> <b><?php echo e($turno->fechahora_inicio); ?></b> <?php echo e(__('lblRequesting2')); ?> <b>"<?php echo e($turno->nombre_tramite); ?>"</b>, <?php echo e(__('lblRequesting3')); ?>  <b><?php echo e($turno->nombre); ?></b>  <?php echo e(__('lblRequesting4')); ?></p>        
        <br>
        <center><a href="<?php echo e(route('valoracionindex', app()->getLocale())); ?>/<?php echo e($foliovaloracion); ?>" style="border-radius:4px; color:#333; display:inline-block; text-decoration:none; background-color:#F1C81E; border-top:10px solid #F1C81E; border-right:18px solid #F1C81E; border-bottom:10px solid #F1C81E; border-left:18px solid #F1C81E; font-size:13px"><?php echo e(__('lblRequesting5')); ?></a></center>
        <br>
        <p style="font-size:13px"><?php echo e(__('lblRequesting6')); ?></p>  
    </div>
    
    <p style="border-top:1px solid #ccc; padding-top:10px; font-size:11px; color:#999999"><?php echo e(__('lblRequesting7')); ?>: <?php echo e(route('valoracionindex',app()->getLocale())); ?>/<?php echo e($foliovaloracion); ?></p> 
</div>

</body>

</html>
