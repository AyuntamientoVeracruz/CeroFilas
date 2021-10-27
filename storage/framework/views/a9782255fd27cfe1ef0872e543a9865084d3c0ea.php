

<?php $__env->startSection('page-style-files'); ?>
<link rel="stylesheet" href="<?php echo e(url('/sis/vendors/css/summernote.css')); ?>" type="text/css" media="screen">
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
  .panel-heading.note-toolbar{background: #eee; border-bottom: 1px solid #ccc; position: relative!important; width: 100%!important}
  .link-dialog{ background: rgba(0,0,0,0.5) }
  .modal-footer input.btn{border-radius: 4px!important;}

  .hidefield{float:left; width:400px; height: 90px;  position: relative; transition:0.2s;}
    .hidefield div{ width: 100%; float:left; height: 70px; overflow: hidden; transition:0.2s; }
    .hidefield clicker{ width: 100%; height: 20px; text-align: center; position: absolute; left:0px; bottom:0px; font-weight: bold; cursor: pointer;
    border-top:1px solid rgba(0,0,0,0.2); line-height: 20px; transition:0.2s}
    .hidefield.opened{ height: auto; padding-bottom: 30px }
      .hidefield.opened div{ height: auto;  }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <!-- Main content -->
  <main class="main">

    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <!--<li class="breadcrumb-item"><a href="#">Admin</a></li>-->
      <li class="breadcrumb-item active"><?php echo e(__('lblProcedures1')); ?></li>
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
                      <div class="col-lg-3">
                          <a class="btn btn-warning btn-search open-modal" href="#" data-toggle="modal" data-target="#myModal"
                          data-action = "store"
                          data-oficina     = <?php if($data['rol']=='admin_oficina'): ?> "<?php echo e($data['oficina']); ?>" <?php else: ?> ""  <?php endif; ?>
                          data-title  = "Nuevo trámite"><?php echo e(__('lblProcedures2')); ?> <i class="icon-arrow-right"></i></a>
                      </div>
                      <div <?php if($data['rol'] == 'superadmin'): ?> class="col-lg-4 col-md-12" <?php else: ?> class="col-lg-1" <?php endif; ?>>
                        <?php if($data['rol'] == 'superadmin'): ?>
                        <div style="margin-top: 2px">
                          <select  name="oficina" id="oficina">
                              <option value=""><?php echo e(__('lblProcedures3')); ?></option>
                              <?php if(count($dependenciascombo)> 0 ): ?>
                                <?php $__currentLoopData = $dependenciascombo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dependencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                          
                                  <?php $__currentLoopData = $dependencia->oficinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oficina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($oficina->id_oficina); ?>" <?php if($filtersoficina==$oficina->id_oficina): ?> selected="" <?php endif; ?>><?php echo e($oficina->nombre_oficina); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <?php endif; ?>  
                          </select>
                        </div>
                        <?php endif; ?>
                      </div>
                      <div <?php if($data['rol'] == 'superadmin'): ?> class="col-lg-0 col-md-0 lc" <?php else: ?> class="col-lg-3 lc" <?php endif; ?>>
                        
                        

                      </div>
                      <div class="col-lg-5">
                        <div class="input-group">
                          <input type="text" id="searchPars" name="searchPars" class="form-control" placeholder= "<?php echo e(__('lblProcedures4')); ?>" value = "<?php echo e($filterstexto); ?>">
                          <span class="input-group-prepend">
                            <button type="submit" class="btn btn-secondary btn-search"><i class="fa fa-search"></i><span><?php echo e(__('lblProcedures5')); ?></span></button>
                          </span>
                        </div>
                      </div>
                  </div>
              </form>                                                        
            </div>
          </div>
            
          <!--<form action="<?php echo e(route('usuarios/csv', app()->getLocale())); ?>" method="get" class="form-horizontal tabsearch" style="width:100%; float:left">
              <div class="form-group row" style="float:right; margin-top:10px; margin-bottom:10px">
                  <div class="col-md-6">
                        <button type="submit" class="btn btn-warning btn-search" style="border-radius:4px">Descarga CSV usuarios <i class="fa fa-download"></i></button>
                    </div>
              </div>
          </form>-->

          <div class="cardsoutside">

            <?php if(count($dependencias)> 0 ): ?>
              <?php $__currentLoopData = $dependencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dependencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                          
                <?php $__currentLoopData = $dependencia->oficinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oficina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                  <div class="card">
                       
                      <div class="card-header">
                        <h5 style="margin-bottom:0px"><?php echo e(__('lblProcedures6')); ?> <?php echo e($oficina->nombre_oficina); ?></h5>
                      </div>

                      <div class="card-body">

                          <div class="col-sm-12 table-responsive">

                            <table class="table  table-striped">
                                  <thead>
                                    <?php if(count($oficina->tramites)> 0 ): ?>
                                    <tr>                                                                                  
                                      <th><?php echo e(__('lblProcedures7')); ?></th>                                        
                                      <th><?php echo e(__('lblProcedures8')); ?></th>
                                      <th><?php echo e(__('lblProcedures9')); ?></th>
                                      <th><?php echo e(__('lblProcedures10')); ?></th> 
                                      <th class="text-right"><?php echo e(__('lblProcedures11')); ?></th> 
                                      <th class="text-right"><?php echo e(__('lblProcedures12')); ?></th>
                                      <th class="text-center"><?php echo e(__('lblProcedures13')); ?></th>                                          
                                    </tr>
                                    <?php endif; ?>
                                  </thead>
                                  <tbody>
                                  <?php if(count($oficina->tramites)> 0 ): ?>                                        
                                      <?php $__currentLoopData = $oficina->tramites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tramite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                 
                                        <tr>                                            
                                            <td style="padding-right:0px">
                                              <div style="float:left; width:185px">
                                                <a href="#" class="btn btn-warning btn-sm float-left open-modal" 
                                                  data-toggle       = "modal" 
                                                  data-target       = "#myModal"
                                                  data-action       = "update"
                                                  data-id           = "<?php echo e($tramite->id_tramite); ?>"
                                                  data-title        = "<?php echo e(__('lblProcedures14')); ?>: <?php echo e($tramite->nombre_tramite); ?>"
                                                  data-nombre       = "<?php echo e($tramite->nombre_tramite); ?>"  
                                                  data-requisitos   = "<?php echo e($tramite->requisitos); ?>" 
                                                  data-tiempo       = "<?php echo e($tramite->tiempo_minutos); ?>" 
                                                  data-costo        = "<?php echo e($tramite->costo); ?>"
                                                  data-codigo       = "<?php echo e($tramite->codigo); ?>" 
                                                  data-dependencia  = "<?php echo e($tramite->dependencia_id); ?>"
                                                  data-warning      = "<?php echo e($tramite->warning_message); ?>"
                                                ><?php echo e(__('lblProcedures33')); ?></a>
                                                                                                    
                                                <a href="#" 
                                                  class="btn <?php if($tramite->estatus=="activo"): ?> btn-success <?php else: ?> btn-secondary <?php endif; ?> btn-sm open-modalTramitexoficina"
                                                  style="margin-left:10px; margin-top:0px; float:left" 
                                                  data-toggle           = "modal"
                                                  data-target           = "#myModalTramitexoficina"
                                                  data-action           = <?php if($tramite->estatus=='activo'): ?> "update" <?php else: ?> "store" <?php endif; ?>
                                                  data-id               = "<?php echo e($tramite->id_tramitesxoficinas); ?>"  
                                                  data-title            = "<?php if($tramite->estatus!='activo'): ?> <?php echo e(__('lblProcedures31')); ?> <?php else: ?> <?php echo e(__('lblProcedures33')); ?> <?php endif; ?> <?php echo e(__('lblProcedures36')); ?> <?php echo e($oficina->nombre_oficina); ?>"
                                                  data-tramite          = "<?php echo e($tramite->id_tramite); ?>"                                                  
                                                  data-oficina          = "<?php echo e($tramite->oficina_id); ?>" 
                                                  data-fecha            = "<?php echo e($tramite->apply_date); ?>" 
                                                  ><?php if($tramite->estatus=="activo"): ?> <small><?php echo e(__('lblProcedures32')); ?>: <?php echo e($tramite->fecha); ?></small> <?php else: ?> <?php echo e(__('lblProcedures31')); ?> <?php endif; ?></a>
                                                
                                                <?php if($data['rol']=="superadmin"): ?>
                                                <form id="fr_tramite<?php echo e($tramite->id_tramite); ?>" action="<?php echo e(route('tramites/destroy', app()->getLocale())); ?>" name="_method" method="post" style="float:left">
                                                  <a href="#" 
                                                  class="btn btn-danger btn-sm"
                                                  style="margin-top:10px; float:left" 
                                                  data-toggle           = "confirmation"
                                                  data-id               = "<?php echo e($tramite->id_tramite); ?>"
                                                  data-btn-ok-label     = "<?php echo e(__('lblProcedures15')); ?>" 
                                                  data-btn-ok-icon      = "fa fa-remove"
                                                  data-btn-ok-class     = "btn btn-danger btn-sm"
                                                  data-btn-cancel-label = "<?php echo e(__('lblProcedures16')); ?>"
                                                  data-btn-cancel-icon  = "fa fa-chevron-circle-left"
                                                  data-btn-cancel-class = "btn btn-sm btn-warning"
                                                  data-title            = "<?php echo e(__('lblProcedures17')); ?>"
                                                  data-target           = "#removeTramite"
                                                  data-placement        = "left" 
                                                  data-singleton        = "true" 
                                                  data-type             = "tramite" 
                                                  ><?php echo e(__('lblProcedures18')); ?></a>
                                                  <?php echo csrf_field(); ?>
                                                  <input type="hidden" name="id_tramite" value="<?php echo e($tramite->id_tramite); ?>"/>
                                                </form>       
                                                <?php endif; ?>
                                                      
                                              </div>
                                            </td>

                                          
                                                                                           
                                            <td style="text-transform: capitalize"><div style="float:left; width:100px"> <?php if($tramite->estatus =="activo"): ?>  <?php echo e(__('lblStatusActive')); ?> <?php else: ?>  <?php echo e(__('lblStatusDesactive')); ?> <?php endif; ?> </div></td> 
                                            <td style="text-transform: capitalize"><div style="float:left; width:160px"><?php echo e($tramite->nombre_tramite); ?></div></td>
                                            <td style="text-transform: capitalize"><div class="hidefield"><clicker>↓ <?php echo e(__('lblProcedures34')); ?></clicker><div><?php echo nl2br($tramite->requisitos); ?></div></div></td>
                                            <td style="text-transform: capitalize; text-align: right;"><?php echo e($tramite->tiempo_minutos); ?></td>
                                            <td style="text-transform: capitalize; text-align: right;"><?php echo e($tramite->costo); ?></td>
                                            <td style="text-transform: capitalize; text-align: center;"><?php echo e($tramite->codigo); ?></td>
                                                                                            
                                        </tr>
                                                                                                                                                                                                                    
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                                                                  
                                  <?php else: ?>
                                    <span>No tienes ningún trámite aún.</span>
                                  <?php endif; ?>
                                  </tbody>
                            </table>

                          </div>

                      </div>
                      
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            
            <input type="hidden" id="id_tramite" name="id_tramite"  />
            <input type="hidden" id="id_oficina" name="id_oficina"  />            

            <div class="form-group">
              <label for="company"><?php echo e(__('lblProcedures20')); ?></label>
              <input type="text" class="form-control" id="fnombre" name="nombre" placeholder="<?php echo e(__('lblProcedures19')); ?>" required maxlength="300"/>
            </div>
            
            <div class="form-group">
              <label for="street"><?php echo e(__('lblProcedures21')); ?>:</label>
              <textarea class="form-control" id="frequisitos" name="requisitos" placeholder="<?php echo e(__('lblProcedures22')); ?>" rows="5" ></textarea>
            </div>

            <div class="form-group">
              <label for="street"><?php echo e(__('lblProcedures12')); ?></label>
              <input type="text" class="form-control" id="fcosto" name="costo" placeholder="<?php echo e(__('lblProcedures23')); ?>" required="" />
            </div>

            <div class="row" style="margin-left: -15px; margin-right: -15px">
              <div class="form-group col-sm-6">
                <label for="street"><?php echo e(__('lblProcedures11')); ?></label>
                <input type="number" class="form-control" id="ftiempo" name="tiempo" placeholder="0" required="" />
              </div>
        
              <div class="form-group col-sm-6 codigocontainer">
                <label for="street"><?php echo e(__('lblProcedures13')); ?></label>
                <input type="text" class="form-control text-uppercase" id="fcodigo" name="codigo" placeholder="XXXX" required="" minlength="4" maxlength="4" />
                <error><i class="fa fa-times"></i></error>
                <ok><i class="fa fa-check"></i></ok>
              </div>  

            </div>

            <div class="form-group">
              <label for="company"><?php echo e(__('lblProcedures24')); ?></label>
              <input type="text" class="form-control" id="fwarning" name="warning_message" placeholder="<?php echo e(__('lblProcedures25')); ?>" maxlength="100"/>
            </div>
                
            <div class="row">
              <div class="form-group col-sm-12 plr0">
                <label for="company"><?php echo e(__('lblProcedures26')); ?>:</label>
                <select id="fdependencia" name="dependencia" required>
                  <option value=""><?php echo e(__('lblProcedures27')); ?></option>  
                  <?php if(count($dependencias)> 0 ): ?>
                    <?php $__currentLoopData = $dependencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dependencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                                
                        <option value="<?php echo e($dependencia->id_dependencia); ?>"><?php echo e($dependencia->nombre_dependencia); ?></option>                     
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                </select>
              </div>
            </div>
            
        </div>
        <div class="modal-footer">
          <?php echo csrf_field(); ?>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('lblProcedures28')); ?></button>
          <button type="submit" class="btn btn-warning"><?php echo e(__('lblProcedures29')); ?></button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->



  <!--  Modal for insert or edit tramite  -->
  <div class="modal fade" id="myModalTramitexoficina"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
            
            <input type="hidden" id="id_tramite" name="id_tramite"  />
            <input type="hidden" id="id_oficina" name="id_oficina"  />            
            <input type="hidden" id="id_tramitesxoficinas" name="id_tramitesxoficinas">

            <div class="form-group">
              <label for="company"><?php echo e(__('lblProcedures30')); ?></label>
              <input type="date" class="form-control" id="ffecha" name="fecha" required/>
            </div>
                                                    
            
        </div>
        <div class="modal-footer">
          <?php echo csrf_field(); ?>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('lblProcedures28')); ?></button>
          <button type="submit" class="btn btn-warning"><?php echo e(__('lblProcedures29')); ?></button>
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
  
  
  <script src="<?php echo e(url('/sis/vendors/js/summernote.min.js')); ?>"></script>   

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

        $('#frequisitos').summernote({
          height:100,
          dialogsInBody: true,
          toolbar: [         
            ['font', ['bold', 'underline']],         
            ['insert', ['link']]
          ],
          popover: {
             image: [],
             link: [],
             air: []
          }
        });

        // Get the modal by ID
        var modal = $('#myModal');
        modal.find('#modaltitle').text($(this).data('title'));
        
        $("#fdependencia").select2();
        $(".select2-container").css({"width":"100%","max-width":"100%","float":"right"});

        if ($(this).data('action') == "store"){
          modal.find('#id_oficina').val($(this).data('oficina'));
          modal.find('#id_tramite').val("");
          modal.find('#fnombre').val("");
          //modal.find('#frequisitos').val("");
          modal.find('#frequisitos').summernote('code','');
          modal.find('#ftiempo').val("");
          modal.find('#fcosto').val("");
          modal.find('#fcodigo').val("");
          modal.find('#fwarning').val("");
          modal.find('#fdependencia').select2('val','');          
          <?php if($data['rol'] == 'admin_oficina'): ?>
          modal.find('#fdependencia').select2('val',"<?php echo e($data['dependencia']->dependencia_id); ?>");
          $("#fdependencia").select2("readonly", true);
          <?php endif; ?>          
          modal.find('form').attr('action','<?php echo e(route("tramites/store", app()->getLocale())); ?>');
        }
        else if ($(this).data('action') == "update"){  
          modal.find('#id_oficina').val("");          
          modal.find('#id_tramite').val($(this).data('id'));
          modal.find('#fnombre').val($(this).data('nombre'));
          //modal.find('#frequisitos').val($(this).data('requisitos')); 
          modal.find('#frequisitos').summernote('code', $(this).data('requisitos').replace(/\n/g, "<br />"));
          modal.find('#ftiempo').val($(this).data('tiempo'));
          modal.find('#fcosto').val($(this).data('costo'));
          modal.find('#fcodigo').val($(this).data('codigo'));
          modal.find('#fwarning').val($(this).data('warning'));
          modal.find('#fdependencia').select2('val',$(this).data('dependencia'));         
          <?php if($data['rol'] == 'admin_oficina'): ?>
          $("#fdependencia").select2("readonly", true);
          <?php endif; ?>   
          modal.find('form').attr('action','<?php echo e(route("tramites/update", app()->getLocale())); ?>');
        }
      });
      //new/edit tramite x oficina
      $("a.open-modalTramitexoficina").click(function (e) {
        e.preventDefault();
        // Get the modal by ID
        var modal = $('#myModalTramitexoficina');
        modal.find('#modaltitle').text($(this).data('title'));

        if ($(this).data('action') == "store"){
          modal.find('#id_tramite').val($(this).data('tramite'));
          modal.find('#id_oficina').val($(this).data('oficina'));
          modal.find('#id_tramitesxoficinas').val("");
          //setting date to 3 months after
          var dt = new Date();          
          //dt=new Date(dt.setMonth(dt.getMonth() + 3)); 
          function appendLeadingZeroes(n){
            if(n <= 9){
              return "0" + n;
            }
            return n;
          }  
          modal.find('#ffecha').val(dt.getFullYear() + "-" + appendLeadingZeroes(dt.getMonth()+1) + "-" + appendLeadingZeroes(dt.getDate()) );   
          
          modal.find('form').attr('action','<?php echo e(route("tramites/oficinastore", app()->getLocale())); ?>');          
        }
        else if ($(this).data('action') == "update"){  
          modal.find('#id_tramite').val($(this).data('tramite'));
          modal.find('#id_oficina').val($(this).data('oficina'));
          modal.find('#id_tramitesxoficinas').val($(this).data('id'));
          modal.find('#ffecha').val($(this).data('fecha'));          
          modal.find('form').attr('action','<?php echo e(route("tramites/oficinaupdate", app()->getLocale())); ?>');
        }
      });  


      //send unique code and validate
      $("#fcodigo").keyup(function(){
        $this=$(this);
        //console.log($this.val().length);
        if($this.val().length==4){
          $.ajax({
              url: "<?php echo e(route('getcodetramite', app()->getLocale())); ?>"+"/"+$this.val(), 
              type: "GET",
              dataType : 'json', 
              beforeSend: function(){ $(".loading-main").fadeIn(); },
              success : function(result) {
                $(".loading-main").fadeOut();
                if(result.error=="true"){
                  $(".responsemessage").addClass("errorresponse");
                  $(".responsemessage").addClass("showed").html(result.description).slideDown();
                  $("#myModal").find('button[type="submit"]').prop("disabled",true); 
                  $(".codigocontainer").find("ok").hide();  
                  $(".codigocontainer").find("error").show();               
                }   
                else{
                  $("#myModal").find('button[type="submit"]').prop("disabled",false);
                  $(".codigocontainer").find("error").hide();  
                  $(".codigocontainer").find("ok").show();  
                }
              },
              error: function(xhr, resp, text) {
                $(".loading-main").fadeOut();
                $(".responsemessage").addClass("errorresponse");
                $(".responsemessage").addClass("showed").html("Ocurrió un error validando código, intenta más tarde").slideDown();
              } 
          });
        } 
      });
      //click alert message to close
      $("body").on('click','.responsemessage', function(){
        $this=$(this);
        $this.slideUp().removeClass("showed");
      });


      //new/edit tramite x oficina
      let showLess='<?php echo e(__('lblProcedures35')); ?>';
      let showMore='<?php echo e(__('lblProcedures34')); ?>';
      $("clicker").click(function (e) {
        $(this).parent().toggleClass("opened");
        if($(this).parent().hasClass("opened")){
          $(this).html(`${showLess}`);
        }
        else{
          $(this).html(`${showMore}`);
        }
      });

    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.headerauth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>