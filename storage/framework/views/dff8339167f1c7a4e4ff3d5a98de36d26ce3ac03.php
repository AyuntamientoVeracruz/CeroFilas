<?php $__env->startSection('page-style-files'); ?>
<style type="text/css">
  tr.hide{ display:none; background:#fff!important}
  tr.open{ display:table-row}
  .tramites{ cursor:pointer}
  .modal-body label{ margin-bottom:0.2rem; font-weight:500}
  .modal-body input::placeholder{ color:#aaa}
  .direcciones table td{ font-size:12px}
  .tab-content{ border-radius:5px; }
  .tabsearch .row{ margin-left: -15px; margin-right: -15px }
  .trfirst th{border-bottom:0px none!important; padding-bottom: 0px!important}
  .trfirst th.text-center{border-bottom:1px solid #a4b7c1!important; border-left:5px solid #fff!important; border-right:5px solid #fff!important; padding-bottom: 3px!important;
    text-transform: uppercase; color:#777;}
  .trfirst th.text-center.light{border-bottom:1px solid #eee!important}
  th{ white-space: nowrap; }
  .containercombo select{ display: block!important; width: 0px; height: 0px; overflow: hidden; float: left; padding: 0px; margin: 0px }
  @media (max-width: 991px){
    .tabsearch .form-group .col-lg-2.col-md-6{ margin-top: 15px; margin-bottom: 15px }
    .tabsearch .form-group .col-lg-3.lc{ margin-top: 15px; margin-bottom: 15px }
  }
  @media (max-width: 767px){
    .tabsearch .form-group .col-lg-2.col-md-6{ margin-top: 15px; margin-bottom: 15px }
    .tabsearch .form-group .col-lg-2.col-md-6.lc{ margin-top: 0px }
  }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <!-- Main content -->
  <main class="main">

    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <!--<li class="breadcrumb-item"><a href="#">Admin</a></li>-->
      <li class="breadcrumb-item active">   <?php echo e(__('lblUnits1')); ?></li>
    </ol>

    <div class="container-fluid">

      <div class="animated fadeIn cards">
    
        <div class="col-md-12 valoracion pasos direcciones">
          <!--This will print succes or error message after doing a DB transaction-->
          <?php if(\Session::has('success')): ?>
          <div class="alert alert-success">
            <?php echo e(\Session::get('success')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <?php endif; ?>
          <?php if(\Session::has('errors')): ?>
          <div class="alert alert-danger">
            <?php echo e(\Session::get('errors')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <?php endif; ?>
          <div class="tab-content">
            <div class="tab-pane active">
              <form method="get" class="form-horizontal tabsearch">
                  <div class="form-group row">
                      <div class="col-lg-4">
                          <a class="btn btn-warning btn-search open-modal" href="#" data-toggle="modal" data-target="#myModal"
                          data-action = "store"                          
                          data-title  = "<?php echo e(__('lblUnits19')); ?>">   <?php echo e(__('lblUnits2')); ?> <i class="icon-arrow-right"></i></a>
                      </div>
                      <div class="col-lg-3 col-md-12">
                        
                        <div style="margin-top: 2px">
                          <select  name="dependencia" id="dependencia">
                              <option value=""><?php echo e(__('lblUnits3')); ?></option>
                              <?php if(count($dependenciascombo)> 0 ): ?>
                                <?php $__currentLoopData = $dependenciascombo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dependencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                                            
                                  <option value="<?php echo e($dependencia->id_dependencia); ?>" <?php if($filtersdependencia==$dependencia->id_dependencia): ?> selected="" <?php endif; ?>><?php echo e($dependencia->nombre_dependencia); ?></option>                                  
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <?php endif; ?>  
                          </select>
                        </div>
                        
                      </div>
                      
                      <div class="col-lg-5">
                        <div class="input-group">
                          <input type="text" id="searchPars" name="searchPars" class="form-control" placeholder= "<?php echo e(__('lblUnits4')); ?> " value = "<?php echo e($filterstexto); ?>">
                          <span class="input-group-prepend">
                            <button type="submit" class="btn btn-secondary btn-search"><i class="fa fa-search"></i><span><?php echo e(__('btnUnits')); ?></span></button>
                          </span>
                        </div>
                      </div>
                  </div>
              </form>                                                        
            </div>
          </div>
                      
          <div class="cardsoutside">

            <?php if(count($dependencias)> 0 ): ?>
              <?php $__currentLoopData = $dependencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dependencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                          
                  
                  <div class="card">
                       
                      <div class="card-header">
                        <h5 style="margin-bottom:0px">
                          <a href="#" class="btn btn-secondary btn-sm float-left open-modal br" style="margin-top: 1px; margin-right: 10px" 
                            data-toggle       = "modal" 
                            data-target       = "#myModal"
                            data-action       = "update"
                            data-id           = "<?php echo e($dependencia->id_dependencia); ?>"
                            data-title        = "<?php echo e(__('lblUnits10')); ?>: <?php echo e($dependencia->nombre_dependencia); ?>"
                            data-nombre       = "<?php echo e($dependencia->nombre_dependencia); ?>" 
                          ><?php echo e(__('btnUnits4')); ?></a>
                          <form id="fr_dependencia<?php echo e($dependencia->id_dependencia); ?>" action="<?php echo e(route('dependencias/destroy', app()->getLocale())); ?>" name="_method" 
                            method="post" style="float:left">
                            <a href="#" 
                            class="btn btn-danger btn-sm float-left br"
                            style="margin-right:10px; margin-top:1px; float:left" 
                            data-toggle           = "confirmation"
                            data-id               = "<?php echo e($dependencia->id_dependencia); ?>"                                                  
                            data-btn-ok-label     = "<?php echo e(__('lblUnits11')); ?>"
                            data-btn-ok-icon      = "fa fa-remove"
                            data-btn-ok-class     = "btn btn-danger btn-sm"
                            data-btn-cancel-label = "<?php echo e(__('lblUnits23')); ?>"
                            data-btn-cancel-icon  = "fa fa-chevron-circle-left"
                            data-btn-cancel-class = "btn btn-sm btn-warning"
                            data-title            = "<?php echo e(__('lblUnits22')); ?>"
                            data-target           = "#removeDependencia"
                            data-placement        = "left" 
                            data-singleton        = "true"
                            data-type             = "dependencia" 
                            ><?php echo e(__('btnUnits5')); ?></a>
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id_dependencia" value="<?php echo e($dependencia->id_dependencia); ?>"/>
                          </form>
                          <k style="float: left"><?php echo e($dependencia->nombre_dependencia); ?></k></h5>
                      </div>

                      <div class="card-body">

                          <a class="btn btn-warning btn-search open-modalOficina br float-right" href="#" data-toggle="modal" data-target="#myModalOficina"
                          data-action = "store" style="margin-right: 15px; margin-bottom:15px"    
                          data-dependencia = "<?php echo e($dependencia->id_dependencia); ?>"                     
                          data-title  = "<?php echo e(__('lblUnits18')); ?>"><?php echo e(__('lblUnits5')); ?> <i class="icon-arrow-right"></i></a>

                          <div class="col-sm-12 table-responsive">

                            <table class="table  table-striped">
                                  <thead>
                                    <?php if(count($dependencia->oficinas)> 0 ): ?>
                                    <tr>                                                                                  
                                      <th><?php echo e(__('lblUnits6')); ?></th> 
                                      <th><?php echo e(__('lblUnits7')); ?></th>
                                      <th><?php echo e(__('lblUnits8')); ?></th> 
                                      <th><?php echo e(__('lblUnits9')); ?></th>                                          
                                    </tr>
                                    <?php endif; ?>
                                  </thead>
                                  <tbody>
                                  <?php if(count($dependencia->oficinas)> 0 ): ?>                                        
                                      <?php $__currentLoopData = $dependencia->oficinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oficina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                 
                                        <tr>                                            
                                            <td style="padding-right:0px">
                                              <div style="float:left; width:140px">
                                                                                                                                                    
                                                <a href="#" 
                                                  class="btn btn-secondary btn-sm open-modalOficina"
                                                  style="margin-left:10px; margin-top:0px; float:left" 
                                                  data-toggle           = "modal"
                                                  data-target           = "#myModalOficina"
                                                  data-action           = "update"
                                                  data-id               = "<?php echo e($oficina->id_oficina); ?>"  
                                                  data-title            = "<?php echo e(__('lblUnits21')); ?>: <?php echo e($oficina->nombre_oficina); ?>"
                                                  data-nombre           = "<?php echo e($oficina->nombre_oficina); ?>"                                                  
                                                  data-coords           = "<?php echo e($oficina->coords); ?>" 
                                                  data-direccion        = "<?php echo e($oficina->direccion); ?>" 
                                                  data-dependencia      = "<?php echo e($oficina->dependencia_id); ?>" 
                                                  ><?php echo e(__('btnUnits4')); ?></a>
                                                  
                                                  <form id="fr_oficina<?php echo e($oficina->id_oficina); ?>" action="<?php echo e(route('oficinas/destroy', app()->getLocale())); ?>" name="_method" 
                                                    method="post" style="float:left">
                                                    <a href="#" 
                                                    class="btn btn-danger btn-sm"
                                                    style="margin-left:10px; margin-top:0px; float:left" 
                                                    data-toggle           = "confirmation"
                                                    data-id               = "<?php echo e($oficina->id_oficina); ?>"                                                  
                                                    data-btn-ok-label     = "<?php echo e(__('lblUnits11')); ?>"
                                                    data-btn-ok-icon      = "fa fa-remove"
                                                    data-btn-ok-class     = "btn btn-danger btn-sm"
                                                    data-btn-cancel-label = "<?php echo e(__('lblUnits23')); ?>"
                                                    data-btn-cancel-icon  = "fa fa-chevron-circle-left"
                                                    data-btn-cancel-class = "btn btn-sm btn-warning"
                                                    data-title            = "<?php echo e(__('lblUnits22')); ?>"
                                                    data-target           = "#removeOficina"
                                                    data-placement        = "left" 
                                                    data-singleton        = "true"
                                                    data-type             = "oficina"><?php echo e(__('btnUnits5')); ?></a>
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="id_oficina" value="<?php echo e($oficina->id_oficina); ?>"/>
                                                  </form>      

                                              </div>
                                            </td>
                                                                                           
                                            <td ><div style="float:left; width:160px"><?php echo e($oficina->nombre_oficina); ?></div></td> 
                                            <td ><div style="float:left; width:130px"><?php echo e($oficina->coords); ?></div></td>
                                            <td ><div style="float:left; width:200px"><?php echo e($oficina->direccion); ?></div></td>
                                                                                            
                                        </tr>
                                                                                                                                                                                                                    
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                                                                  
                                  <?php else: ?>
                                    <span><?php echo e(__('lblUnits17')); ?></span>
                                  <?php endif; ?>
                                  </tbody>
                            </table>

                          </div>

                      </div>
                      
                  </div>
                
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>  

          </div>

        </div>  

      </div>

    </div>
    
  </main>

  

  <!--  Modal for insert or edit tramite  -->
  <div class="modal fade" id="myModal"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="modaltitle" class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form class="form-control values" method="post">
        <div id="myModalControl" class="modal-body">
            
            <input type="hidden" id="id_dependencia" name="id_dependencia"  />            

            <div class="form-group">
              <label for="company">   <?php echo e(__('lblUnits12')); ?></label>
              <input type="text" class="form-control" id="fnombre" name="nombre" placeholder="" required maxlength="100"/>
            </div>                        
            
        </div>
        <div class="modal-footer">
          <?php echo csrf_field(); ?>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('btnUnits2')); ?></button>
          <button type="submit" class="btn btn-warning"><?php echo e(__('btnUnits3')); ?></button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->



  <!--  Modal for insert or edit tramite  -->
  <div class="modal fade" id="myModalOficina"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="modaltitle" class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form class="form-control values" method="post">
        <div id="myModalControl" class="modal-body">
            
            <input type="hidden" id="id_dependencia" name="id_dependencia"  />            
            <input type="hidden" id="id_oficina" name="id_oficina">
            
            <div class="form-group">
              <label for="company"><?php echo e(__('lblUnits14')); ?></label>
              <input type="text" class="form-control" id="fnombre" name="nombre" placeholder="<?php echo e(__('lblUnits15')); ?>" required maxlength="100"/>
            </div>   

            <div class="form-group">
              <label for="company"><?php echo e(__('lblUnits8')); ?>:</label>
              <input type="text" class="form-control" id="fcoords" name="coords" placeholder="0,0" required maxlength="100"/>
            </div> 

            <div class="form-group">
              <label for="company"><?php echo e(__('lblUnits9')); ?>:</label>
              <textarea class="form-control" id="fdireccion" name="direccion" placeholder="<?php echo e(__('lblUnits16')); ?>" required maxlength="100" rows="2" ></textarea>
            </div>                          
            
        </div>
        <div class="modal-footer">
          <?php echo csrf_field(); ?>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('btnUnits2')); ?></button>
          <button type="submit" class="btn btn-warning"><?php echo e(__('btnUnits3')); ?></button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->  


<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js-script'); ?>
    
  <script>
    $(document).ready(function(){

      $(".loading-main").fadeOut();
      $("select").wrap('<div class="containercombo"></div>');
      $("select").select2();
      $(".select2-container").css({"width":"100%","max-width":"100%","float":"right"});
      //confirmation to delete
      $('[data-toggle="confirmation"]').confirmation({
        rootSelector: '[data-toggle="confirmation"]',
        onConfirm: function (event, element) {
          $("#fr_"+$(this).data("type")+$(this).data("id")).submit();
        }
      });      
      //new/edit tramite
      $("a.open-modal").click(function (e) {
        e.preventDefault();
        // Get the modal by ID
        var modal = $('#myModal');
        modal.find('#modaltitle').text($(this).data('title'));
        
        if ($(this).data('action') == "store"){
          modal.find('#id_dependencia').val("");
          modal.find('#fnombre').val("");          
          modal.find('form').attr('action','<?php echo e(route("dependencias/store", app()->getLocale())); ?>');
        }
        else if ($(this).data('action') == "update"){                   
          modal.find('#id_dependencia').val($(this).data('id'));
          modal.find('#fnombre').val($(this).data('nombre'));                  
          modal.find('form').attr('action','<?php echo e(route("dependencias/update", app()->getLocale())); ?>');
        }
      });
      //new/edit tramite x oficina
      $("a.open-modalOficina").click(function (e) {
        e.preventDefault();
        // Get the modal by ID
        var modal = $('#myModalOficina');
        modal.find('#modaltitle').text($(this).data('title'));

        if ($(this).data('action') == "store"){   
          modal.find('#id_dependencia').val($(this).data('dependencia'));        
          modal.find('#id_oficina').val(""); 
          modal.find('#fnombre').val("");
          modal.find('#fcoords').val("");
          modal.find('#fdireccion').val("");             
          modal.find('form').attr('action','<?php echo e(route("oficinas/store", app()->getLocale())); ?>');          
        }
        else if ($(this).data('action') == "update"){  
          modal.find('#id_dependencia').val($(this).data('dependencia'));   
          modal.find('#id_oficina').val($(this).data('id'));    
          modal.find('#fnombre').val($(this).data('nombre'));
          modal.find('#fcoords').val($(this).data('coords'));
          modal.find('#fdireccion').val($(this).data('direccion'));    
          modal.find('form').attr('action','<?php echo e(route("oficinas/update", app()->getLocale())); ?>');
        }
      });         

    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.headerauth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>