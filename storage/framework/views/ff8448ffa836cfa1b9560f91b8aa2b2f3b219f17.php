<?php if(isset($tipo)): ?>
    <?php $__env->startSection('page-style-files'); ?>
        <link rel="stylesheet" href="<?php echo e(url('/css/app.css')); ?>" type="text/css" media="screen">
        <style type="text/css">
            p{ font-size: 12px!important } 
            .containerwhite{float: left; width: 100%; background:#fff; margin-top: -45px; position: relative; z-index: 2; margin-bottom: 45px;
                box-shadow: 0 4px 4px #ccc; padding:0px; border-radius:5px; padding: 45px;
                max-width: 750px; margin-left: 125px}
            @media  only screen and (max-width: 899px){
            footer .container{ height: auto!important }
            }
            .no-print{margin-top: 0px; width: 100%; text-align: center; float: left; height: auto; border-bottom: 1px solid #ccc; padding-bottom: 45px}
            .headerwrapper .textcontainer{ text-align: center}
            .qrcontainer{text-align: right; padding-right: 6%}
            @media  only screen and (max-width: 1128px){
                .containerwhite{ margin-left:0%; max-width: 100%}
                .qrcontainer{text-align: right; padding-right: 5.9%}
            }
            @media  only screen and (max-width: 828px){
                .qrcontainer{text-align: center; padding-right: 0px; width: 100%!important}
                .infocontainer{ width: 100%!important }
            }  
            .infocontainer div a{ font-weight: bold; text-decoration: underline; color:#337ab7!important;}          
        </style>
        <style type="text/css" media="print"> 
             body {font-family: 'NeoSans',Helvetica, sans-serif}
            .no-print,.headerwrapper,footer{display: none !important}
            .containerwhite{ padding:0px; margin-top: 0px; margin-bottom: 0px; margin-left: 0px; max-width: auto}
            <?php if($statuscita=="cancelada"): ?>
            .containerwhite:before{content: "Cancelada"; position: absolute; left: 200px; top: 400px; font-size: 70px; font-weight: bold;
             -webkit-transform: rotate(-45deg); -moz-transform: rotate(-45deg); text-align: center; opacity:0.7;}
            <?php endif; ?>
        </style>
        <?php if($tipo=="confirmacion"): ?>
        <script>window.print();</script>
        <?php endif; ?>
        <script src="<?php echo e(url('/sis/vendors/js/jquery.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(url('/js/xepOnline.jqPlugin.js')); ?>" type="text/javascript"></script>
    <?php $__env->stopSection(); ?>    

<?php else: ?>
  <html>    
    <head>  
    <style type="text/css">
        .no-print,.headerwrapper,footer,.footerin{display: none !important}
        .qrcontainer{text-align: center; padding-right: 0px; width: 100%!important}
        .infocontainer div a{ font-weight: bold; text-decoration: underline}
        div[class$="footerin"],div[class$="headerwrapper"]{display: none !important}
    </style> 
    </head>
    <body>
<?php endif; ?> 
    
    <?php if(isset($tipo)): ?>
        <?php $__env->startSection('initlink'); ?>
        <a href="<?php echo e(route('/', app()->getLocale())); ?>" class="small"><?php echo e(__('lblSaveDateMail1')); ?></a>
        <?php $__env->stopSection(); ?>
        <?php $__env->startSection('titlebig'); ?>
        <h1><?php echo e(__('lblSaveDateMail2')); ?></h1>
        <?php $__env->stopSection(); ?>
    <?php endif; ?>
    
    <?php if(isset($tipo)): ?>
    <?php $__env->startSection('content'); ?>
    <?php endif; ?>

    <?php if(isset($tipo)): ?>
    <div class="wrappercontainer">
    <div class="container">
    <div class="containerwhite">
        <div class="no-print">
            <?php if($statuscita!="cancelada"): ?>
                <a href="javascript:void(0)" onclick="return xepOnline.Formatter.Format('printable',{render:'download',filename: 'confirmacion-<?php echo e($folio); ?>',embedLocalImages: 'true'});" 
                style="background:#E0B54B; border-radius:4px; height: 30px; line-height: 30px; padding:10px; color:#000; text-decoration: none; 
                font-family: Arial; font-size:12px"><?php echo e(__('lblSaveDateMail3')); ?></a>
                <a href="javascript:void(0)" onclick="window.print();" 
                style="background:#222; border-radius:4px; height: 30px; line-height: 30px; padding:10px; color:#fff; text-decoration: none; 
                font-family: Arial; font-size:12px; margin-left: 20px"><?php echo e(__('lblSaveDateMail2')); ?></a>
                <?php if($tipo=="search"): ?>            
                <a href="javascript:void(0)" onclick='document.getElementById("form-folio").submit();' 
                style="background:#cc0000; border-radius:4px; height: 30px; line-height: 30px; padding:10px; color:#fff; text-decoration: none; 
                font-family: Arial; font-size:12px; margin-left: 20px"><?php echo e(__('lblCancel')); ?></a>
                <form id="form-folio" method="post" action="<?php echo e(route('cancelarcita', app()->getLocale())); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" value="<?php echo e($folio); ?>" id="folio" name="folio">
                </form>
                <?php endif; ?>
            <?php else: ?>
                <h2 style="color:#cc0000; text-transform: capitalize; margin-top:0px; margin-bottom: 0px"><?php echo e(__('lblCancel')); ?></h2>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div style="width:100%;background:#fff;padding:0px;color:#333333;font-family:Helvetica,Arial,Tahoma;margin-bottom:10px;font-size:12px;
    max-width:<?php if(isset($tipo)): ?> 100% <?php else: ?> 647px <?php endif; ?>;margin:0 auto" id="printable">                

        <div style="width: 100%;  display: block">

            <!--<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="border:0px none;margin:0px;border-collapse:collapse;padding:0px; background-color:#ffffff;width:100%; border-bottom:1px solid #ccc; float: left; margin-bottom: 10px">
                <tbody valign="middle" style="border:none; margin:0px; padding:0px">
                    <tr height="25" valign="middle" style="border:none; margin:0px; padding:0px; height:25px">
                        <td colspan="2" class="x_footer-bottom-padding" height="25" valign="middle" style="border:none; margin:0px; padding:0px; height:25px"></td>
                    </tr>
                    <tr valign="middle" style="border:none; margin:0px; padding:0px">                        
                        <td valign="middle" style="border:none; margin:0px; padding:0px; text-align:center" width="25%">
                            <img src="<?php echo e(url('/images/logo-white.png')); ?>" style="width:100%" />
                        </td>
                        <td valign="middle" style="border:none; margin:0px; padding:0px; text-align:center" width="75%">
                            <span style="color:#212F4D; font-weight: 500; text-transform: uppercase;  font-size: 20px; letter-spacing: 1px">
                                <span style="width: 100%; display: block; text-align: center;"><?php echo e(__('lblSaveDateMail21')); ?></span>
                                <span style="font-size: 12px; letter-spacing: 3px; width: 100%; text-align: center; display: block"><?php if(isset($recordatorio)): ?> <?php echo e(__('lblResetMail4')); ?> <?php else: ?> <?php echo e(__('lblSaveDateMail22')); ?> <?php endif; ?> <?php echo e(__('lblSaveDateMail23')); ?></span>
                            </span>
                        </td>                        
                    </tr>
                    <tr height="25" valign="middle" style="border:none; margin:0px; padding:0px; height:25px">
                        <td colspan="2" class="x_footer-bottom-padding" height="25" valign="middle" style="border:none; margin:0px; padding:0px; height:25px">
                        </td>
                     </tr>
                </tbody>
            </table>-->
            <div style="width: 100%; display: block; float: left; height: 120px; margin-bottom: 10px; border-bottom:1px solid #ccc">
                <div style=" margin-top: 25px; margin-bottom: 25px; width: 100%; height: 70px; float:left">
                    <div style="width: 25%; float: left; text-align: center;height: 70px"><img src="<?php echo e(url('/images/logo-white.png')); ?>" style="max-width:100%; max-height: 100%" /></div>
                    <div style="width: 75%; float: left; height: 70px">
                        <span style="color:#212F4D; font-weight: 500; text-transform: uppercase;  font-size: 20px; letter-spacing: 1px; margin-top: 10px; width: 100%; display: block">
                            <span style="width: 100%; display: block; text-align: center;"><?php echo e(__("lblSaveDateMail21")); ?></span>
                            <span style="font-size: 12px; letter-spacing: 3px; width: 100%; text-align: center; display: block"><?php if(isset($recordatorio)&&$recordatorio==true): ?> <?php echo e(__('lblResetMail4')); ?> <?php else: ?> <?php echo e(__('lblSaveDateMail22')); ?> <?php endif; ?> <?php echo e(__('lblSaveDateMail23')); ?></span>
                        </span>
                    </div>
                </div>
            </div>
            
            <div style="width: 100%; display: block; float:left">
                               
                <h1 style="font-size:18px; margin-top: 20px"><?php echo e(__("lblMrs")); ?> <?php echo e($nombre["text"]); ?>!</h1> 
                <p style="font-size:13px; margin-bottom:0px"><?php if(isset($recordatorio)&&$recordatorio==true): ?> <?php echo e(__('lblSaveDateMail7')); ?> <?php else: ?> <?php echo e(__('lblSaveDateMail8')); ?> <?php endif; ?> <b><?php echo e(__('lblSaveDateMail9')); ?><a href="<?php echo e(route('/', app()->getLocale())); ?>"><?php echo e(__('lblSaveDateMail12')); ?></a> <?php echo e(__('lblSaveDateMail10')); ?></b></p>
                <div style="float: left; width:100%; text-align: center; margin-bottom: 20px; margin-top: 20px"><?php echo e(__('lblSaveDateMail11')); ?>

                    <b style="font-size: 35px; width: 100%; text-align: center;display: block; line-height: 35px"><?php echo e($folio); ?></b>
                </div>
                
                <div style="width:100%; margin-bottom: 0px; margin-top: 20px; display: block">                
                    
                    <div style="float: left; width: <?php if(isset($print)): ?> 50% <?php else: ?> 100% <?php endif; ?>" class="qrcontainer"> 
                        <span style="width: 100%; display: block; text-align: center;"><?php echo e(__('lblSaveDateMail13')); ?></span>                    
                        <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=foliodecitagenerado:<?php echo e($folio); ?>&choe=UTF-8&chld=|1"/>                   
                    </div>
                                            
                    <div style="margin-bottom:10px; line-height: 20px; float:left; <?php if(isset($print)): ?> width: 320px; <?php else: ?> width:100%; <?php endif; ?>" class="infocontainer"> 
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><?php echo e(__('lblSaveDateMail14')); ?></div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b><?php echo e(__('lblProcedure')); ?></b> <?php echo e($tramite["text"]); ?></div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b><?php echo e(__('lblOffice')); ?></b> <?php echo e($oficina["text"]); ?></div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b><?php echo e(__('lblOfficeAddress')); ?></b> <?php echo e($oficina["direccion"]); ?></div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b><?php echo e(__('lblDateTime')); ?></b> <?php echo e($fechahora["text"]); ?></div>
                        <?php if($email["value"]!=""): ?> <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b><?php echo e(__('lblEmail')); ?></b> <?php echo e($email["value"]); ?></div> <?php endif; ?>
                    
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b><?php echo e(__('lblCost')); ?></b> <?php echo e($tramite["costo"]); ?></div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b><?php echo e(__('lblProcudereRquirements')); ?></b></div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block; line-height: 15px"><?php echo nl2br($tramite["requisitos"]); ?></div>
                        <br><br>
                    </div> 
                </div>

            </div>
        
        </div>

        <div style="width: 100%; text-align: center; margin-top: 0px; margin-bottom: 0px; display: block; float: left">
            <div style="width:100%; margin-bottom: 5px; margin-top: 0px; display: block"><?php echo e(__('lblLocatioMap')); ?></div>                 
            <img src='https://maps.googleapis.com/maps/api/staticmap?center=<?php echo e(trim($oficina["coords"])); ?>&zoom=17&size=640x230&scale=1&maptype=roadmap&markers=<?php echo e(trim($oficina["coords"])); ?>&key=<?php echo e(trim($googlemapskey->service_key)); ?>' width="100%" alt="mapa" style="max-width: 640px" />                    
        </div>

        <?php if(!isset($tipo)): ?>            
        <table class="x_footer-root" dir="" width="100%" cellpadding="0" cellspacing="0" bgcolor="#eee" 
        style="border:none; margin:0px; border-collapse:collapse; padding:0px; background-color:#eee; width:100%">
            <tbody valign="middle" style="border:none; margin:0px; padding:0px">
                
                <tr class="x_footer-top-padding" height="12" valign="middle" style="border:none; margin:0px; padding:0px; height:12px">
                    <td colspan="3" class="x_footer-top-padding" height="25" valign="middle" style="border:none; margin:0px; padding:0px; height:25px">
                    </td>
                </tr>
                <tr valign="middle" style="border:none; margin:0px; padding:0px">
                    <td width="6.25%" valign="middle" style="border:none; margin:0px; padding:0px; width:6.25%">
                    </td>
                    <td class="x_font" valign="middle" align="initial" style="border:none; margin:0px; padding:0px; font-weight:400; text-decoration:none; letter-spacing:0.15px; color:rgb(136,137,140); font-size:11px; line-height:1.65em; text-align:initial"><?php echo e(__('lblSaveDateMail15')); ?></td>
                    <td width="6.25%" valign="middle" style="border:none; margin:0px; padding:0px; width:6.25%">
                    </td>
                </tr>
                <tr class="x_footer-top-padding" height="12" valign="middle" style="border:none; margin:0px; padding:0px; height:12px">
                    <td colspan="3" class="x_footer-top-padding" height="12" valign="middle" style="border:none; margin:0px; padding:0px; height:12px">
                    </td>
                </tr>
                <tr valign="middle" style="border:none; margin:0px; padding:0px">
                    <td width="6.25%" valign="middle" style="border:none; margin:0px; padding:0px; width:6.25%">
                    </td>
                    <td valign="middle" style="border:none; margin:0px; padding:0px">
                    <hr bgcolor="#999999" style="border:none; margin:0px; padding:0px; background-color:#999999; height:1px">
                    </td>
                    <td width="6.25%" valign="middle" style="border:none; margin:0px; padding:0px; width:6.25%">
                    </td>
                </tr>
                <tr class="x_footer-bottom-padding" height="15" valign="middle" style="border:none; margin:0px; padding:0px; height:15px">
                    <td colspan="3" class="x_footer-bottom-padding" height="15" valign="middle" style="border:none; margin:0px; padding:0px; height:15px">
                    </td>
                </tr>
                
                
                <tr valign="middle" style="border:none; margin:0px; padding:0px">
                    <td width="6.25%" valign="middle" style="border:none; margin:0px; padding:0px; width:6.25%">
                    </td>
                    <td class="x_font x_font-small" valign="middle" align="initial" style="border:none; margin:0px; padding:0px; font-weight:400; text-decoration:none; letter-spacing:0.15px; color:rgb(136,137,140); line-height:1.65em; text-align:initial; font-size:11px">
                    <?php echo e(__('lblSaveDateMail16')); ?></td>
                    <td width="6.25%" valign="middle" style="border:none; margin:0px; padding:0px; width:6.25%">
                    </td>
                </tr>
                <tr height="20" valign="middle" style="border:none; margin:0px; padding:0px; height:20px">
                    <td colspan="3" class="x_footer-bottom-padding" height="25" valign="middle" style="border:none; margin:0px; padding:0px; height:25px">
                    </td>
                </tr>
            </tbody>
        </table>
        <?php endif; ?>

    </div>    
    
    <?php if(isset($tipo)): ?>
    </div>
    </div>
    </div>
    <?php endif; ?>

    <?php if(isset($tipo)): ?>
    <?php $__env->stopSection(); ?>
    <?php endif; ?>

<?php if(!isset($tipo)): ?>            
        </body>
    </html>
<?php endif; ?>

<?php echo $__env->make(isset($tipo) ? 'layouts.app' : 'layouts.empty', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>