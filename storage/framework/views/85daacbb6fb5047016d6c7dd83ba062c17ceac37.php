<?php $__env->startSection('page-style-files'); ?>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <!--main booking-->
    <link rel="stylesheet" href="<?php echo e(url('/css/app.css')); ?>" type="text/css" media="all">
    <style type="text/css">
    .sincitavisor close,.concitavisor label close{ right:auto; left:10px}
    .concitavisor label search{ left:auto; right:10px}
    .sincitavisor close i,.concitavisor label close i,.concitavisor label search i{ margin-bottom: 20px; font-size: 40px }
    .sincitavisor close k,.concitavisor label close k,.concitavisor label search k{ line-height: 20px; font-size: 14px; color:#fff; position: absolute; left: 0px; width: 100%; text-align: center; bottom:5px;}
    .fullscreencontainer{ background: #212F4D }
    em{ color:#E0B54B; font-style: normal; }
    label em{color:#000;}
    </style>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-155250227-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-155250227-1');
</script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <span class="nombreoficina"><?php echo e(__('lblKiosk1')); ?>: <b><?php echo e($oOficina->nombre_oficina); ?></b></span>

    <div class="responsemessage"></div>

    <div class="fullscreencontainer">        
        <span class="logocontainer"><img src="<?php echo e(url('/images/logo.png')); ?>" class="logo"></span>
        <span class="descriptioncontainer"><h1><?php echo e(__('lblKiosk2')); ?></h1><p><?php echo e(__('lblKiosk3')); ?></p></span>
        <span class="buttonscontainer">
            <a href="#" class="concita"><?php echo e(__('lblKiosk4')); ?></a>
            <a href="#" class="sincita"><?php echo e(__('lblKiosk5')); ?></a>
        </span>
         
    </div>  

    <div class="miniscreencontainer">
        <close><i class="fa fa-times"></i></close>        
        <span class="descriptioncontainer"><h1 id="confirmationtype"></h1><p><?php echo e(__('lblKiosk6')); ?></p></span>
        <span class="confirmacioncontainer">
            <h1 id="turno"></h1>
            <b><k id="tiempoaproximado"></k></b>
        </span>
    </div>

    <div class="minisearchcontainer">
        <close><i class="fa fa-times"></i></close>  
        <form id="search-form">      
            <p class="descriptionsection"><?php echo e(__('lblKiosk7')); ?> <em>*</em></p>
            <div class="inputfield">            
                <input type="text" class="texto" id="search" autocomplete="off" name="search" placeholder="<?php echo e(__('lblKiosk7')); ?>" 
                minlength="6" required="">
                <label><?php echo e(__('lblKiosk8')); ?> <em><?php echo e(__('lblKiosk9')); ?></em></label>                          
            </div>
            <input type="submit" value="<?php echo e(__('lblKiosk10')); ?>" class="btn btn-primary" id="buttonbuscar">  
        </form>
    </div>

    <div class="concitavisor">
        <video id="preview" playsinline autoplay muted ></video>
        <label><?php echo e(__('lblKiosk11')); ?> <close><i class="fa fa-chevron-left"></i> <k><?php echo e(__('lblKiosk12')); ?></k></close> <search><i class="fa fa-search"></i> <k><?php echo e(__('lblKiosk13')); ?></k></search></label>
    </div>

    <div class="sincitavisor">
        <close><i class="fa fa-chevron-left"></i> <k><?php echo e(__('lblKiosk12')); ?></k></close>
        <form id="turno-form">
            <label class="titlesection" data-section="1"><b>1</b><span><?php echo e(__('lblKiosk14')); ?></span></label>
            <p class="descriptionsection"><?php echo e(__('lblKiosk15')); ?></p>
            <!--mostrar solo tramites correspondientes de la dependencia, por lo que la url de waitingroom nos va a indicar la dependencia donde estamos ubicados-->
            <select class="form-control mb-30 select2-single" id="tramite" required="" name="tramite">
                <option value=""><?php echo e(__('lblKiosk16')); ?></option> 
                <?php $__currentLoopData = $tramites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tramite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value='<?php echo e($tramite["id_tramite"]); ?>'><?php echo e($tramite["nombre_tramite"]); ?></option>        
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                    
            </select>

            <div class="w50 first">
                <label class="titlesection" data-section="2"><b>2</b><span><?php echo e(__('lblKiosk17')); ?></span></label>
                <p class="descriptionsection"><?php echo e(__('lblKiosk17')); ?>.</p>
                <div class="inputfield">
                    <input type="text" class="texto capitalize" id="nombre" autocomplete="off" name="nombre" placeholder="<?php echo e(__('lblKiosk19')); ?>" minlength="2" required="">
                    <label><?php echo e(__('lblKiosk20')); ?> </label>
                </div>  
            </div>  

            <div class="w50 last">
                <label class="titlesection" data-section="3"><b>3</b><span><?php echo e(__('lblKiosk21')); ?></span></label>
                <p class="descriptionsection"><?php echo e(__('lblKiosk22')); ?><.</p>
                <div class="inputfield">
                    <input type="text" class="texto uppercase" id="curp" autocomplete="off" name="curp" placeholder="<?php echo e(__('lbldigits')); ?>" minlength="9" maxlength="9">
                    <label><?php echo e(__('lblKiosk23')); ?> </label>
                </div>  
            </div>

            <input type="submit" value="<?php echo e(__('lblKiosk24')); ?>" class="enviar">
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js-script'); ?>
    <!--cam-->
    <script src="<?php echo e(url('/js/instascan.min.js')); ?>" type="text/javascript"></script>
    <!--booking script-->
    <script type="text/javascript">
        var confirmationqrurl = "<?php echo e(route('kioskconfirmationqr', app()->getLocale())); ?>/<?php echo e($oOficina->id_oficina); ?>";
        var searchcitabytexturl = "<?php echo e(route('kiosksearchcitabytext', app()->getLocale())); ?>/<?php echo e($oOficina->id_oficina); ?>";
        var manualturnurl = "<?php echo e(route('kioskmanualturn', app()->getLocale())); ?>";
        var gettramitesbykioskourl = "<?php echo e(route('gettramitesbykiosko', app()->getLocale())); ?>/<?php echo e($oOficina->id_oficina); ?>";
        var oficina=<?php echo e($oOficina->id_oficina); ?>;
       
        var lblKiosk16="<?php echo e(__('lblKiosk16')); ?>"; 
    </script>
   
    <script src="<?php echo e(url('/js/waitingroom.js')); ?>" type="text/javascript"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.kiosk', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>