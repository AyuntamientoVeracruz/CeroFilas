<?php $__env->startSection('page-style-files'); ?>
    <!--main booking-->
    
    <link rel="stylesheet" href="<?php echo e(url('/css/app.css')); ?>" type="text/css" media="all">
    <style type="text/css">
        .p15{width: 100%; float: left}
        .main-left{ width: calc(58.3333% - 20px) }
        quote{ background: none; color: #222; padding:0px; }
            quote b,quote a{color:#337ab7!important}
        .titlesection b i{ line-height: 30px }
        .etiqueta{margin-top: 0px; margin-bottom: 0px}
        .main-left .descriptionsection{ margin-bottom: 0px }
        .wrappercontainer{
            height: calc(100vh - 380px - 110px);
            min-height: 270px;
        }
       
        @media  only screen and (max-width: 992px){
            .main-left,.main-right{ width: 100% }
            .wrappercontainer{ height: auto }
        }        
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

<?php $__env->startSection('initlink'); ?>
<a href="https://www.veracruzmunicipio.gob.mx" class="small"><?php echo e(__('btn1')); ?></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('titlebig'); ?>
<h5><?php echo e(__('lblIndex1')); ?></h5>
<h1><?php echo e(__('lblIndex2')); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="loading-main">
        <div class="loader"><?php echo e(__('lblLoading')); ?></div>
    </div>

    <div class="responsemessage"></div>

    <div class="requisitoscontainer-holder">
        <div class="requisitoscontainer">
        </div>
    </div>

    <div class="wrappercontainer">
        
        <div class="container">

            <form id="cita-form" method="post" action="<?php echo e(route('getcita', app()->getLocale())); ?>">

                <div class="main-left col-sm-7 col-md-7 col-xs-12 br-5 p15 mb-30">
                    <h3 class="header3"><?php echo e(__('lblIndex14')); ?></h3>
                    
                    <quote><?php echo e(__('lblIndex3')); ?> <a href="#" target="_blank" rel="noopener noreferrer"></a></quote>

                    <label class="titlesection" style="margin-bottom: 0px"><b><i class="far fa-id-card"></i></b><span><?php echo e(__('lblIndex5')); ?></span></label>
                                        
                    <a class="btn btn-primary submit" href="<?php echo e(route('crearcita', app()->getLocale())); ?>"><?php echo e(__('lblIndex6')); ?></a>    
                    
                    <quote style="margin-bottom: 6px; margin-top: 20px"><?php echo e(__('lblIndex7')); ?> <a href="<?php echo e(url('/pdf/guia-de-usuario.pdf')); ?>" target="_blank"><?php echo e(__('lblIndex8')); ?> </a> <?php echo e(__('lblIndex9')); ?> </quote>        

                </div>

                <div class="anchor"></div>
                <div class="main-right col-sm-5 col-md-5 col-xs-12 br-5 mb-30 ">
                    <h3 class="header3"><?php echo e(__('lblIndex10')); ?></h3>

                    <div class="p15">

                        <label class="titlesection"><b><i class="fa fa-search"></i></b><span><?php echo e(__('lblIndex11')); ?></span></label>
                        <p class="descriptionsection"><?php echo e(__('lblIndex12')); ?></p>    
                        <?php echo csrf_field(); ?>
                        <div class="inputfield">
                            <input type="text" class="texto" id="folio" required="" autocomplete="off" name="folio" minlength="8" maxlength="8">
                            <label><?php echo e(__('lblIndexBlade28')); ?> <mark></mark></label>
                        </div>
                        
                        <span class="etiqueta"><b class="notavailable"></b> 
                        <?php if($errors->any()): ?>
                        <k style="color:#cc0000"><?php echo e($errors->first()); ?></k>
                        <?php else: ?>
                        <?php echo e(__('lblIndex13')); ?>

                        <?php endif; ?>
                        </span>

                        <input type="submit" class="btn btn-primary submit" value="<?php echo e(__('btnCancel')); ?>">    

                    </div>

                </div>

            </form> 
                    
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js-script'); ?>
    
    <script>
    $(document).ready(function(){
      $(".loading-main").fadeOut();
      //click on label over input field
      $(".inputfield label").on('click', function(event) {
        $(this).parent().find("input,textarea").focus();
      });
    });
    </script>
    
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>