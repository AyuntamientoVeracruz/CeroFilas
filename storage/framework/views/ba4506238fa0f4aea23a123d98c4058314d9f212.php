<?php $__env->startSection('page-style-files'); ?>
    <!--main booking-->
    <link rel="stylesheet" href="<?php echo e(url('/css/app.css')); ?>" type="text/css" media="all">
    <style type="text/css">
        .requisito span stronger{ background: #eee; padding: 7px; color: #000; font-size: 12px; border-radius:5px;  width: 100%; margin-bottom: 20px;
            margin-top: 20px; display: block; font-weight: bold}
            .requisito span stronger i{ font-weight: normal; font-style: normal}
            .btnrequisitos{display: block; width: 126px;  padding: 2px 4px; font-size: 10px; text-transform: none!important}
                .btnrequisitos i{ font-size: 6px; float: left; margin-top: 5px; margin-bottom: 10px }
        .requisito span a{ font-weight: bold; text-decoration: underline; }

        .select2-container--default .select2-results__option[aria-disabled=true]{ display: none }
        .timerarea:after{content:"<?php echo e(__('lblCreateAppointment53')); ?>"; color: #999;
        position: absolute; width: calc(100% - 20px); text-align: center; font-size: 8px;
        font-weight: normal; left: 10px; background: #fff;
        bottom: -10px; height: 20px; line-height: 12px; padding-left: 5px; padding-right: 5px}

        .timerarea:before{content:"<?php echo e(__('lblCreateAppointment54')); ?>"; color: #999;
position: absolute; width: 120px; text-align: center; font-size: 9px;
font-weight: normal; left: calc(50% - 60px); background: #fff;
top: -10px; height: 20px; line-height: 20px; text-transform: uppercase;}
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
<a href="<?php echo e(route('/', app()->getLocale())); ?>" class="small"><?php echo e(__('btn1')); ?></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('titlebig'); ?>
<h5> <?php echo e(__('lblCreateAppointment1')); ?></h5>
<h1><?php echo e(__('lblCreateAppointment2')); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="loading-main">
        <div class="loader"> <?php echo e(__('lblLoading')); ?></div>
    </div>

    <div class="responsemessage"></div>

    <div class="responsemessage2"></div>

    <div class="requisitoscontainer-holder">
        <div class="requisitoscontainer">
        </div>
    </div>

    <div class="wrappercontainer">
        
        <div class="container">

            <form id="cita-form">

                <div class="main-left col-sm-7 col-md-7 col-xs-12 br-5 p15 mb-30">
                    <h3 class="header3"> <?php echo e(__('lblCreateAppointment3')); ?></h3>
                    
                    <quote><?php echo e(__('lblCreateAppointment4')); ?> <a  target="_blank" rel="noopener noreferrer"></a></quote>

                    <label class="titlesection" data-section="1"><b>1</b><span><?php echo e(__('lblCreateAppointment6')); ?></span></label>
                    <p class="descriptionsection"><?php echo e(__('lblCreateAppointment7')); ?></p>
                    <select class="form-control mb-30 select2-single" id="tramite" required="" name="tramite">
                        <option value=""><?php echo e(__('lblCreateAppointment8')); ?></option>              
                    </select>

                    <label class="titlesection" data-section="2"><b>2</b><span><?php echo e(__('lblCreateAppointment9')); ?></span></label>
                    <p class="descriptionsection"><?php echo e(__('lblCreateAppointment10')); ?>.</p>
                    <select class="form-control mb-30" id="lugarcita" required="" name="lugar-cita" disabled="">
                        <option value=""><?php echo e(__('lblCreateAppointment8')); ?></option>                        
                    </select>

                    <label class="titlesection" data-section="3"><b>3</b><span>><?php echo e(__('lblCreateAppointment11')); ?></span></label>  
                    <p class="descriptionsection"><?php echo e(__('lblCreateAppointment12')); ?></p>

                    <div class="calendar-wrapper cal_info hiddened">
                        <input type="hidden" name="fechahora" id="fechahora">
                        <div class="calendar-header">
                            <a class="previous-date" href="#" data-date=""><i class="fas fa-chevron-left"></i></a>                
                            <div class="calendar-title"><?php echo e(__('lblCreateAppointment13')); ?></div>
                            <div class="calendar-year"><?php echo e(__('lblCreateAppointment14')); ?></div>
                            <a class="next-date" href="#" data-date=""><i class="fas fa-chevron-right"></i></a>
                        </div>
                        <div class="calendar-body">
                            <div class="weekdays fl">
                                <div class="ct-day"><span><?php echo e(__('lblCreateAppointment15')); ?></span></div>
                                <div class="ct-day"><span><?php echo e(__('lblCreateAppointment16')); ?></span></div>
                                <div class="ct-day"><span><?php echo e(__('lblCreateAppointment17')); ?></span></div>
                                <div class="ct-day"><span><?php echo e(__('lblCreateAppointment18')); ?></span></div>
                                <div class="ct-day"><span><?php echo e(__('lblCreateAppointment19')); ?></span></div>
                                <div class="ct-day"><span><?php echo e(__('lblCreateAppointment20')); ?></span></div>
                                <div class="ct-day ct-last-day"><span><?php echo e(__('lblCreateAppointment21')); ?></span></div>
                            </div>
                            <div id="datesarea" class="dates"></div>        
                            <div class="hours">
                                <label><?php echo e(__('lblCreateAppointment22')); ?></label>
                                <small></small>
                                <div>
                                    
                                </div>
                            </div>
                                    
                            <div class="today-date">
                                <span class="labeled"><?php echo e(__('lblCreateAppointment23')); ?></span>
                                <div class="ct-selected-date-view">
                                    <span class="add_date ct-date-selected"><i class="far fa-calendar"></i> <fecha></fecha></span>
                                    <span class="add_time ct-time-selected"><i class="far fa-clock"></i> <hora></hora></span>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <span class="etiqueta"><b class="available"></b> <?php echo e(__('lblCreateAppointment24')); ?></span>
                    <span class="etiqueta etiqueta-right"><b class="notavailable"></b> <?php echo e(__('lblCreateAppointment25')); ?></span>

                    <label class="titlesection" data-section="4"><b>4</b><span><?php echo e(__('lblCreateAppointment26')); ?></span></label>    
                    <p class="descriptionsection"><?php echo e(__('lblCreateAppointment27')); ?></p>

                    <div class="inputfield">
                        <input type="text" class="texto capitalize" id="username" required="" autocomplete="off" name="nombre" minlength="2">
                        <label><?php echo e(__('lblCreateAppointment28')); ?> <mark></mark></label>
                    </div>
                    <div class="col-sm-6 col-xs-12 pl0">
                        <div class="inputfield">
                            <input type="text" class="texto capitalize" id="apellidopaterno" required="" autocomplete="off" name="apellido-paterno" minlength="2">
                            <label><?php echo e(__('lblCreateAppointment29')); ?> <mark></mark></label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12 pr0">
                        <div class="inputfield">
                            <input type="text" class="texto capitalize" id="apellidomaterno"  autocomplete="off" name="apellido-materno" minlength="2">
                            <label><?php echo e(__('lblCreateAppointment30')); ?> </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12 pl0">
                        <div class="inputfield">
                            <input type="email" class="texto" id="email" autocomplete="off" name="email" placeholder="mail@dominio.com">
                            <label><?php echo e(__('lblCreateAppointment31')); ?> </label>
                        </div>
                    </div>
                    <div class="col-sm-7 col-xs-12 pl0">
                        <div class="inputfield">
                            <input type="tel" class="texto" id="telefono" autocomplete="off" name="telefono" placeholder="2291234567" maxlength="10">
                            <label><?php echo e(__('lblCreateAppointment32')); ?> </label>
                        </div>
                    </div>
                    <div class="col-sm-5 col-xs-12 pr0">
                        <div class="inputfield">
                            <input type="text" class="texto uppercase" id="curp" required="" autocomplete="off" name="curp" placeholder="<?php echo e(__('lblCreateAppointment33')); ?>" minlength="9" maxlength="9">
                            <label><?php echo e(__('lblCreateAppointment33')); ?> <mark></mark></label>
                        </div>
                   </div>
                   <span class="etiqueta"><b class="notavailable"></b> <?php echo e(__('lblCreateAppointment34')); ?> </span>

                   <input type='submit' class='btn btn-primary submit' value="<?php echo e(__('lblCreateAppointment35')); ?>" disabled="" />

                </div>

                <div class="anchor"></div>
                <div class="main-right col-sm-4 col-md-4 col-xs-12 br-5 mb-30 summary-scroll">
                    <h3 class="header3"><?php echo e(__('lblCreateAppointment36')); ?></h3>
                    <div class="summary-wrapper">
                        
                        <div class="summary" data-summary="tramite"><div class="image"><i class="far fa-file-alt"></i></div><p class="text sel-service"><noselected><?php echo e(__('lblCreateAppointment36')); ?> </noselected></p></div>
                        <div class="summary" data-summary="oficina"><div class="image"><i class="far fa-building"></i></div><p class="text sel-service"><noselected><?php echo e(__('lblCreateAppointment37')); ?> </noselected></p></div>
                        <div class="summary" data-summary="fechahora"><div class="image"><i class="far fa-calendar"></i></div><p class="text sel-service"><noselected><?php echo e(__('lblCreateAppointment38')); ?> </noselected></p></div>
                        <div class="summary" data-summary="nombre"><div class="image"><i class="far fa-user"></i></div><p class="text sel-service"><noselected><?php echo e(__('lblCreateAppointment39')); ?> </noselected></p></div>
                        <div class="summary" data-summary="email"><div class="image"><i class="far fa-envelope"></i></div><p class="text sel-service lowercase"><noselected><?php echo e(__('lblCreateAppointment40')); ?> </noselected></p></div>
                        <div class="summary" data-summary="curp"><div class="image"><i class="far fa-id-card"></i></div><p class="text sel-service uppercase"><noselected><?php echo e(__('lblCreateAppointment41')); ?> </noselected></p></div>
                        <div class="summary" data-summary="telefono"><div class="image"><i class="fa fa-phone"></i></div><p class="text sel-service uppercase"><noselected><?php echo e(__('lblCreateAppointment42')); ?> </noselected></p></div>
                        <div class="map"><div id="map"></div></div>
                        <div class="timerareacontainer"></div>    
                    </div>
                </div>

            </form> 
                    
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js-script'); ?>
    <!--maps-->
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e($googlemapskey); ?>&callback=initMap"  defer></script>
   

</script>
    
    <!--booking script-->
    <script type="text/javascript">
        var gettramitesurl = "<?php echo e(route('gettramites', app()->getLocale())); ?>";
        var getoficinasurl = "<?php echo e(route('getoficinas', app()->getLocale())); ?>";
        var getavailabledaysurl = "<?php echo e(route('getavailabledays', app()->getLocale())); ?>";
        var getavailablehoursurl = "<?php echo e(route('getavailablehours', app()->getLocale())); ?>";
        var savedateurl = "<?php echo e(route('savedate', app()->getLocale())); ?>";
        var holdingdateurl = "<?php echo e(route('holdingcita', app()->getLocale())); ?>";
        var removeholdingcitaurl = "<?php echo e(route('removeholdingcita', app()->getLocale())); ?>";


        var msglblCost = "<?php echo e(__('lblCost')); ?>"; 
        var lblSelectOption="<?php echo e(__('lblSelectOption')); ?>"; 
        var lblProcedureRequirement="<?php echo e(__('lblProcedureRequirement')); ?>"; 
        var lblIAgree="<?php echo e(__('lblIAgree')); ?>"; 
        var lblErrorLoading="<?php echo e(__('lblErrorLoading')); ?>";
        var lblAvailable="<?php echo e(__('lblAvailable')); ?>"; 
        var lblCreateAppointment37="<?php echo e(__('lblCreateAppointment37')); ?>"; 
        var lblCreateAppointment39="<?php echo e(__('lblCreateAppointment39')); ?>"; 
        var lblCreateAppointment38="<?php echo e(__('lblCreateAppointment38')); ?>";
        var lblCreateAppointment40="<?php echo e(__('lblCreateAppointment40')); ?>"; 
        var lblCreateAppointment41="<?php echo e(__('lblCreateAppointment41')); ?>"; 
        var lblCreateAppointment42="<?php echo e(__('lblCreateAppointment42')); ?>";
        var lblCreateAppointment43="<?php echo e(__('lblCreateAppointment43')); ?>";
        var lblCreateAppointment45="<?php echo e(__('lblCreateAppointment45')); ?>"; 
        var lblCreateAppointment46="<?php echo e(__('lblCreateAppointment46')); ?>"; 
        var lblCreateAppointment47="<?php echo e(__('lblCreateAppointment47')); ?>"; 
        var lblCreateAppointment48="<?php echo e(__('lblCreateAppointment48')); ?>"; 
        var lblCreateAppointment49="<?php echo e(__('lblCreateAppointment49')); ?>"; 
        var lblCreateAppointment50="<?php echo e(__('lblCreateAppointment50')); ?>"; 
        var lblCreateAppointment51="<?php echo e(__('lblCreateAppointment51')); ?>"; 
        var lblCreateAppointment52="<?php echo e(__('lblCreateAppointment52')); ?>";
        var lbltimer=<?php echo e($timer); ?>;
      
        console.log(lbltimer);
    </script>
    <script src="<?php echo e(url('/js/booking.js')); ?>" type="text/javascript"></script>
   
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>