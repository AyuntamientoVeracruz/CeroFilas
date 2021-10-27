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
  .table th, .table td{ line-height: 15px }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <!-- Main content -->
  <main class="main">

    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <!--<li class="breadcrumb-item"><a href="#">Admin</a></li>-->
      <li class="breadcrumb-item active"><?php echo e(__('lblUser1')); ?></li>
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
                          data-action ="store"
                          data-id     = ""
                          data-title ="<?php echo e(__('lblUser69')); ?>"><?php echo e(__('lblUser2')); ?> <i class="icon-arrow-right"></i></a>
                      </div>
                      <div <?php if($data['rol'] == 'superadmin'): ?> class="col-lg-2 col-md-6" <?php else: ?> class="col-lg-1" <?php endif; ?>>
                        <?php if($data['rol'] == 'superadmin'): ?>
                        <div style="margin-top: 2px">
                          <select  name="oficina" id="oficina">
                              <option value=""><?php echo e(__('lblUser3')); ?></option>
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
                      <div <?php if($data['rol'] == 'superadmin'): ?> class="col-lg-2 col-md-6 lc" <?php else: ?> class="col-lg-3 lc" <?php endif; ?>>
                        
                        <div style="margin-top: 2px">
                          <select  name="tipousuario" id="tipousuario">
                              <option value=""><?php echo e(__('lblUser4')); ?></option>  
                              <option value="admin_oficina" <?php if($filterstipousuario=='admin_oficina'): ?> selected="" <?php endif; ?>><?php echo e(__('lblUser5')); ?></option>
                              <option value="kiosko" <?php if($filterstipousuario=='kiosko'): ?> selected="" <?php endif; ?>><?php echo e(__('lblUser6')); ?></option>
                              <option value="tramitador" <?php if($filterstipousuario=='tramitador'): ?> selected="" <?php endif; ?>><?php echo e(__('lblUser7')); ?></option>
                              <?php if($data['rol'] == 'superadmin'): ?><option value="superadmin" <?php if($filterstipousuario=='superadmin'): ?> selected="" <?php endif; ?>><?php echo e(__('lblUser8')); ?></option><?php endif; ?>  
                          </select>
                        </div>

                      </div>
                      <div class="col-lg-5">
                        <div class="input-group">
                          <input type="text" id="searchPars" name="searchPars" class="form-control" placeholder= "<?php echo e(__('lblUser9')); ?>" value = "<?php echo e($filterstexto); ?>">
                          <span class="input-group-prepend">
                            <button type="submit" class="btn btn-secondary btn-search"><i class="fa fa-search"></i><span><?php echo e(__('lblUser10')); ?></span></button>
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
                        <h5 style="margin-bottom:0px"><?php echo e(__('lblUser11')); ?> <?php echo e($oficina->nombre_oficina); ?></h5>
                      </div>

                      <div class="card-body">

                          <div class="col-sm-12 table-responsive">

                            <table class="table  table-striped">
                                  <thead>
                                    <?php if(count($oficina->usuarios)> 0 ): ?>
                                    <tr>                                            
                                      <th><?php echo e(__('lblUser12')); ?></th>
                                      <th><?php echo e(__('lblUser13')); ?></th>                                        
                                      <th><?php echo e(__('lblUser14')); ?></th>
                                      <th><?php echo e(__('lblUser15')); ?></th>
                                      <th><?php echo e(__('lblUser16')); ?></th>
                                      <th><?php echo e(__('lblUser17')); ?></th> 
                                      <th><?php echo e(__('lblUser18')); ?></th>                                       
                                    </tr>
                                    <?php endif; ?>
                                  </thead>
                                  <tbody>
                                  <?php if(count($oficina->usuarios)> 0 ): ?>                                        
                                      <?php $__currentLoopData = $oficina->usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                 
                                        <tr>
                                            <?php if($usuario->tipo_user=="tramitador"): ?>
                                              <td class="text-center tramites" style="width: 130px">
                                                 <a href="#" class="btn btn-sm btn-secondary">
                                                  <i class="fa fa-chevron-down"></i> <k><?php echo e(__('lblUser11')); ?> <sup><?php echo e($usuario['TOTALTRAMITES']); ?></sup></k></a>
                                              </td> 
                                            <?php else: ?>
                                              <td style="width: 130px"></td>
                                            <?php endif; ?> 
                                            <td style="padding-right:0px">
                                              <div style="float:left; width:235px">
                                                <a href="#" class="btn btn-warning btn-sm float-left open-modal" 
                                                  data-toggle    = "modal" 
                                                  data-target    = "#myModal"
                                                  data-action    = "update"
                                                  data-id        = "<?php echo e($usuario['id_user']); ?>"
                                                  data-title     = "<?php echo e(__('lblUser19')); ?> : <?php echo e($usuario['nombre']); ?>"                                                     
                                                  data-tipouser  = "<?php echo e($usuario['tipo_user']); ?>" 
                                                  data-estatus   = "<?php echo e($usuario['estatus']); ?>"             
                                                  data-email     = "<?php echo e($usuario['email']); ?>"
                                                  data-nombre    = "<?php echo e($usuario['nombre']); ?>"  
                                                  data-oficina   = "<?php echo e($usuario['oficina_id']); ?>" 
                                                  data-disponible= "<?php echo e($usuario['disponibleturno']); ?>"
                                                  <?php if($usuario['id_user']==$data["user"]->id_user): ?>
                                                  data-actualuser= "1"
                                                  <?php else: ?>
                                                  data-actualuser= "0"
                                                  <?php endif; ?>
                                                 ><?php echo e(__('lblUser19')); ?> </a>

                                                <a href="<?php echo e(route('ausenciasusuarios', app()->getLocale())); ?>/<?php echo e($usuario['id_user']); ?>" class="btn btn-secondary btn-sm float-left" style="margin-left: 10px"><?php echo e(__('lblUser20')); ?></a>  

                                                <?php if($usuario['id_user']!=$data["user"]->id_user): ?>                                                    
                                                <form id="fr_user<?php echo e($usuario['id_user']); ?>" action="<?php echo e(route('usuarios/destroy', app()->getLocale())); ?>" name="_method" method="post" style="float:left">
                                                  <a href="#" 
                                                  class="btn btn-danger btn-sm"
                                                  style="margin-left:10px; margin-top:0px; float:left" 
                                                  data-toggle           = "confirmation"
                                                  data-id               = "<?php echo e($usuario['id_user']); ?>"                                                  
                                                  data-btn-ok-label     = "<?php echo e(__('lblUser71')); ?> "
                                                  data-btn-ok-icon      = "fa fa-remove"
                                                  data-btn-ok-class     = "btn btn-danger btn-sm"
                                                  data-btn-cancel-label = "<?php echo e(__('lblUser72')); ?>"
                                                  data-btn-cancel-icon  = "fa fa-chevron-circle-left"
                                                  data-btn-cancel-class = "btn btn-sm btn-warning"
                                                  data-title            = "<?php echo e(__('lblUser36')); ?> <?php if($usuario['estatus']=='activo'): ?> <?php echo e(__('lblUser37')); ?> <?php else: ?> <?php echo e(__('lblUser39')); ?> <?php endif; ?> <?php echo e(__('lblUser38')); ?>"
                                                  data-target           = "#removeUser"
                                                  data-placement        = "top" 
                                                  data-singleton        = "true"
                                                  data-type             = "user" 
                                                  ><?php if($usuario['estatus']=="activo"): ?> <?php echo e(__('lblUser37')); ?> <?php else: ?> <?php echo e(__('lblUser39')); ?> <?php endif; ?></a>
                                                  <?php echo csrf_field(); ?>
                                                  <input type="hidden" name="id_user" value="<?php echo e($usuario['id_user']); ?>"/>
                                                  <input type="hidden" name="estatus" value="<?php echo e($usuario['estatus']); ?>"/>
                                                </form>
                                                <?php endif; ?>
                                              </div>
                                            </td>
                                                                                           
                                            <td style="text-transform: capitalize"><?php if($usuario['estatus']=="activo"): ?>  <?php echo e(__('lblStatusActive')); ?> <?php else: ?>  <?php echo e(__('lblStatusDesactive')); ?> <?php endif; ?> </td>
                                            <td style="text-transform: capitalize"><?php if($usuario['tipo_user'] == 'tramitador'): ?> Asesor <?php endif; ?> <?php if($usuario['tipo_user']=='admin_oficina'): ?> Administrador Oficina <?php endif; ?> <?php if($usuario['tipo_user']=='kiosko'): ?> Kiosko <?php endif; ?> <?php if($usuario['tipo_user']=='superadmin'): ?> Webmaster <?php endif; ?></td>
                                            <td style="text-transform: capitalize"><div style="float:left; width:140px"><a href=" <?php echo e(route('perfiltramitador', app()->getLocale())); ?>/<?php echo e($usuario['id_user']); ?>"><?php echo e($usuario['nombre']); ?></a></div></td>
                                           
                                            <!-- <a href="<?php echo e(route('perfiltramitador', app()->getLocale())); ?>/<?php echo e($usuario['id_user']); ?>"><?php echo e($usuario['nombre']); ?></a></div></td> -->
                                            <td style="text-transform: capitalize"> <?php if($usuario['disponibleturno']=="si"): ?>  <?php echo e(__('lblUser73')); ?> <?php else: ?>  <?php echo e(__('lblUser74')); ?> <?php endif; ?></td>
                                            <td><a href="mailto:<?php echo e($usuario['EMAIL']); ?>" target="_blank"><div style="float:left; width:220px"><?php echo e($usuario['email']); ?></div></a></td>
                                                                                            
                                        </tr>
                                        
                                        <tr class="hide">
                                          <td class="text-center">
                                            <a class="btn btn-sm btn-warning  open-modaltramite" href="#" data-toggle="modal" data-target="#myModalTramite"
                                            data-action ="store" data-idusuario="<?php echo e($usuario['id_user']); ?>" data-oficina="<?php echo e($usuario['oficina_id']); ?>" data-action ="store" data-title="<?php echo e(__('lblUser21')); ?> de: <?php echo e($usuario['nombre']); ?>"><?php echo e(__('lblUser21')); ?></a>
                                          </td>
                                          <td colspan="6">
                                            <?php if(count($usuario['TRAMITES'])>0): ?>                                                                                                                          
                                              <table class="table" style="background:#fff!important">
                                                  <thead>
                                                      <tr style="background:#fff!important" class="trfirst">
                                                          <th></th>
                                                          <th><?php echo e(__('lblUser33')); ?></th>
                                                          <th colspan="2" class="text-center"><?php echo e(__('lblUser22')); ?></th>
                                                          <th colspan="2" class="text-center light"><?php echo e(__('lblUser23')); ?></th>
                                                          <th colspan="2" class="text-center"><?php echo e(__('lblUser24')); ?></th>
                                                          <th colspan="2" class="text-center light"><?php echo e(__('lblUser25')); ?></th>
                                                          <th colspan="2" class="text-center"><?php echo e(__('lblUser26')); ?></th>
                                                          <th colspan="2" class="text-center light"><?php echo e(__('lblUser27')); ?></th>
                                                          <th></th>                                                              
                                                      </tr>
                                                      <tr style="background:#fff!important">
                                                          <th class="text-center"><?php echo e(__('lblUser28')); ?></th>
                                                          <th class="searchtramitecontainer"><input type="text" class="form-control searchtramite" placeholder="<?php echo e(__('lblUser29')); ?>"><close><i class="fa fa-times"></i></close></th>
                                                          <th><?php echo e(__('lblUser30')); ?></th>
                                                          <th><?php echo e(__('lblUser31')); ?></th>
                                                          <th><?php echo e(__('lblUser30')); ?></th>
                                                          <th><?php echo e(__('lblUser31')); ?></th>
                                                          <th><?php echo e(__('lblUser30')); ?></th>
                                                          <th><?php echo e(__('lblUser31')); ?></th>
                                                          <th><?php echo e(__('lblUser30')); ?></th>
                                                          <th><?php echo e(__('lblUser31')); ?></th>
                                                          <th><?php echo e(__('lblUser30')); ?></th>
                                                          <th><?php echo e(__('lblUser31')); ?></th>
                                                          <th><?php echo e(__('lblUser30')); ?></th>
                                                          <th><?php echo e(__('lblUser31')); ?></th>
                                                          <th><?php echo e(__('lblUser32')); ?></th>                                                              
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                            <?php $__currentLoopData = $usuario['TRAMITES']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tramite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                               <tr style="background:#fff!important">
                                                  <td>
                                                    <div style="float:left; width:135px">
                                                      <a href="#" class="btn btn-warning btn-sm float-left open-modaltramite" 
                                                        data-toggle           = "modal" 
                                                        data-target           = "#myModalTramite"
                                                        data-action           = "update"
                                                        data-id               = "<?php echo e($tramite->id_tramitesxusers); ?>"
                                                        data-idusuario        = "<?php echo e($usuario['id_user']); ?>"
                                                        data-title            = "<?php echo e(__('lblUser70')); ?> <?php echo e($usuario['nombre']); ?>"                                                     
                                                        data-tramite          = "<?php echo e($tramite->tramite_id); ?>"
                                                        data-lunesinicio      = "<?php echo e($tramite->lunes_inicio); ?>"
                                                        data-lunesfin         = "<?php echo e($tramite->lunes_fin); ?>"
                                                        data-martesinicio     = "<?php echo e($tramite->martes_inicio); ?>"
                                                        data-martesfin        = "<?php echo e($tramite->martes_fin); ?>"
                                                        data-miercolesinicio  = "<?php echo e($tramite->miercoles_inicio); ?>"
                                                        data-miercolesfin     = "<?php echo e($tramite->miercoles_fin); ?>"
                                                        data-juevesinicio     = "<?php echo e($tramite->jueves_inicio); ?>"
                                                        data-juevesfin        = "<?php echo e($tramite->jueves_fin); ?>"
                                                        data-viernesinicio    = "<?php echo e($tramite->viernes_inicio); ?>"
                                                        data-viernesfin       = "<?php echo e($tramite->viernes_fin); ?>"
                                                        data-sabadoinicio     = "<?php echo e($tramite->sabado_inicio); ?>"
                                                        data-sabadofin        = "<?php echo e($tramite->sabado_fin); ?>"
                                                        data-oficina          = "<?php echo e($usuario['oficina_id']); ?>"
                                                      ><?php echo e(__('lblUser19')); ?></a>
                                                                                                          
                                                      <form id="fr_tramitexuser<?php echo e($tramite->id_tramitesxusers); ?>" action="<?php echo e(route('usuarios/destroytramitexuser', app()->getLocale())); ?>" name="_method" method="post" style="float:left">
                                                        <a href="#" 
                                                        class="btn btn-danger btn-sm"
                                                        style="margin-left:10px; margin-top:0px; float:left" 
                                                        data-toggle           = "confirmation"
                                                        data-id               = "<?php echo e($tramite->id_tramitesxusers); ?>"
                                                        data-btn-ok-label     = "Aceptar" 
                                                        data-btn-ok-icon      = "fa fa-remove"
                                                        data-btn-ok-class     = "btn btn-danger btn-sm"
                                                        data-btn-cancel-label = "Cancelar"
                                                        data-btn-cancel-icon  = "fa fa-chevron-circle-left"
                                                        data-btn-cancel-class = "btn btn-sm btn-warning"
                                                        data-title            = "Desea borrar el trámite para: <?php echo e($usuario['nombre']); ?>?"
                                                        data-target           = "#removeTramitexUser"
                                                        data-placement        = "top" 
                                                        data-singleton        = "true" 
                                                        data-type             = "tramitexuser" 
                                                        ><?php echo e(__('lblUser34')); ?></a>
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="id_tramitexuser" value="<?php echo e($tramite->id_tramitesxusers); ?>"/>
                                                      </form>
                                                    </div>
                                                  </td>
                                                  <td class="nombretramite"><?php echo e($tramite->nombre_tramite); ?></td>
                                                  <td class="text-center"><?php echo e($tramite->lunes_inicio); ?></td>
                                                  <td class="text-center"><?php echo e($tramite->lunes_fin); ?></td>
                                                  <td class="text-center"><?php echo e($tramite->martes_inicio); ?></td>
                                                  <td class="text-center"><?php echo e($tramite->martes_fin); ?></td>
                                                  <td class="text-center"><?php echo e($tramite->miercoles_inicio); ?></td>
                                                  <td class="text-center"><?php echo e($tramite->miercoles_fin); ?></td>
                                                  <td class="text-center"><?php echo e($tramite->jueves_inicio); ?></td>
                                                  <td class="text-center"><?php echo e($tramite->jueves_fin); ?></td>
                                                  <td class="text-center"><?php echo e($tramite->viernes_inicio); ?></td>
                                                  <td class="text-center"><?php echo e($tramite->viernes_fin); ?></td>
                                                  <td class="text-center"><?php echo e($tramite->sabado_inicio); ?></td>
                                                  <td class="text-center"><?php echo e($tramite->sabado_fin); ?></td>
                                                  <td><?php echo e($tramite->updated_at); ?></td>                                                      
                                               </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                  </tbody>
                                              </table>                                                                                                                  
                                            <?php endif; ?>
                                            </td>
                                        </tr>                                                                                                                                    
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                                                                  
                                  <?php else: ?>
                                    <span><?php echo e(__('lblUser35')); ?></span>
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

  

  <!--  Modal for insert or edit  usuario  -->
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
            
            <input type="hidden" id="id_user" name="id_user"  />

            <div class="row">
              <div class="form-group col-sm-12 plr0">
                <label for="company"><?php echo e(__('lblUser40')); ?></label>
                <select id="ftipousuario" name="tipousuario" required>
                  <option value=""><?php echo e(__('lblUser41')); ?></option>  
                  <option value="admin_oficina"><?php echo e(__('lblUser42')); ?></option>
                  <option value="kiosko"><?php echo e(__('lblUser43')); ?></option>
                  <option value="tramitador"><?php echo e(__('lblUser44')); ?></option>
                  <?php if($data['rol'] == 'superadmin'): ?><option value="superadmin"><?php echo e(__('lblUser45')); ?></option><?php endif; ?>    
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="company"><?php echo e(__('lblUser46')); ?></label>
              <input type="text" class="form-control" id="fnombre" name="nombre" placeholder="<?php echo e(__('lblUser46')); ?>" required maxlength="100"/>
            </div>
            
            <div class="form-group">
              <label for="street"><?php echo e(__('lblUser48')); ?></label>
              <input type="email" class="form-control" id="femail" name="email" placeholder="Ingresa email" />
            </div>
            
            <div class="form-group" id="passgroup">
              <label for="street"><?php echo e(__('lblUser49')); ?></label>
              <input type="password" class="form-control" id="fpassword" name="password" placeholder="<?php echo e(__('lblUser50')); ?>" maxlength="100" minlength=6/>
            </div>
            
            <div class="form-group" id="newpassgroup">
              <label for="street"><?php echo e(__('lblUser48')); ?></label>
              <input type="password" class="form-control" id="fnewpassword" name="newpassword" placeholder="<?php echo e(__('lblUser52')); ?>" maxlength="100" minlength=6/>
            </div>

            <div class="row">
              <div class="form-group col-sm-12 plr0">
                <label for="company"><?php echo e(__('lblUser11')); ?></label>
                <select id="foficina" name="oficina" required>
                  <option value=""><?php echo e(__('lblUser53')); ?></option>  
                  <?php if(count($dependencias)> 0 ): ?>
                    <?php $__currentLoopData = $dependencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dependencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                          
                      <?php $__currentLoopData = $dependencia->oficinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oficina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        <option value="<?php echo e($oficina->id_oficina); ?>"><?php echo e($oficina->nombre_oficina); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                </select>
              </div>
            </div>
            <!--/.row-->
        </div>
        <div class="modal-footer">
          <?php echo csrf_field(); ?>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('lblUser54')); ?></button>
          <button type="submit" class="btn btn-warning"><?php echo e(__('lblUser55')); ?></button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->



  <!--  Modal for insert or edit tramite xusuario  -->
  <div class="modal fade" id="myModalTramite"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
            
            <input type="hidden" id="id_user" name="id_user"  />
            <input type="hidden" id="id_tramitexuser" name="id_tramitexuser"  />

            <div class="row">
              <div class="form-group col-sm-12 plr0">
                <label for="company"><?php echo e(__('lblUser33')); ?></label>
                <select id="ftramite" name="tramite" required>
                  <option value=""><?php echo e(__('lblUser56')); ?></option> 

                  <?php if(count($dependencias)> 0 ): ?>
                    <?php $__currentLoopData = $dependencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dependencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                          
                      <?php $__currentLoopData = $dependencia->oficinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oficina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                          <?php $__currentLoopData = $oficina->tramites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tramite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                            <option value="<?php echo e($tramite->id_tramite); ?>" data-oficina="<?php echo e($oficina->id_oficina); ?>"><?php echo e($tramite->nombre_tramite); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                                          
                </select>
              </div>
            </div>

            <div class="form-group col-sm-6">
              <label for="company"><?php echo e(__('lblUser57')); ?></label>
              <input type="time" class="form-control" id="flunesinicio" name="lunes_inicio"  />
            </div>
            <div class="form-group col-sm-6">
              <label for="company"><?php echo e(__('lblUser58')); ?></label>
              <input type="time" class="form-control" id="flunesfin" name="lunes_fin" />
            </div>
            <div class="form-group col-sm-6">
              <label for="company"><?php echo e(__('lblUser59')); ?></label>
              <input type="time" class="form-control" id="fmartesinicio" name="martes_inicio"  />
            </div>
            <div class="form-group col-sm-6">
              <label for="company"><?php echo e(__('lblUser60')); ?></label>
              <input type="time" class="form-control" id="fmartesfin" name="martes_fin"  />
            </div>
            <div class="form-group col-sm-6">
              <label for="company"><?php echo e(__('lblUser61')); ?></label>
              <input type="time" class="form-control" id="fmiercolesinicio" name="miercoles_inicio"   />
            </div>
            <div class="form-group col-sm-6">
              <label for="company"><?php echo e(__('lblUser62')); ?></label>
              <input type="time" class="form-control" id="fmiercolesfin" name="miercoles_fin"  />
            </div>
            <div class="form-group col-sm-6">
              <label for="company"><?php echo e(__('lblUser63')); ?></label>
              <input type="time" class="form-control" id="fjuevesinicio" name="jueves_inicio"   />
            </div>
            <div class="form-group col-sm-6">
              <label for="company"><?php echo e(__('lblUser64')); ?></label>
              <input type="time" class="form-control" id="fjuevesfin" name="jueves_fin"  />
            </div>
            <div class="form-group col-sm-6">
              <label for="company"><?php echo e(__('lblUser65')); ?></label>
              <input type="time" class="form-control" id="fviernesinicio" name="viernes_inicio"   />
            </div>
            <div class="form-group col-sm-6">
              <label for="company"><?php echo e(__('lblUser66')); ?></label>
              <input type="time" class="form-control" id="fviernesfin" name="viernes_fin"  />
            </div>
            <div class="form-group col-sm-6">
              <label for="company"><?php echo e(__('lblUser67')); ?></label>
              <input type="time" class="form-control" id="fsabadoinicio" name="sabado_inicio"   />
            </div>
            <div class="form-group col-sm-6">
              <label for="company"><?php echo e(__('lblUser68')); ?></label>
              <input type="time" class="form-control" id="fsabadofin" name="sabado_fin"  />
            </div>
            
            <!--/.row-->
        </div>
        <div class="modal-footer">
          <?php echo csrf_field(); ?>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('lblUser54')); ?></button>
          <button type="submit" class="btn btn-warning"><?php echo e(__('lblUser55')); ?></button>
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
      //expand tramites  
      $(".tramites").click(function (e) {
        if($(this).parent().next().children().length>0){
          $(this).parent().next().toggleClass("open");
          $(this).toggleClass("open");
        }
      });
      //new/edit usuario
      $("a.open-modal").click(function (e) {
        e.preventDefault();
        // Get the modal by ID
        var modal = $('#myModal');
        modal.find('#modaltitle').text($(this).data('title'));
        
        $("#foficina").select2();
        $(".select2-container").css({"width":"100%","max-width":"100%","float":"right"});

        if ($(this).data('action') == "store"){
          modal.find('#fnombre').val("");
          modal.find('#femail').val("");
          modal.find('#fpassword').val("");
          modal.find('#passgroup').show();
          modal.find('#newpassgroup').hide();
          modal.find('#foficina').select2('val','');
          modal.find('#ftipousuario').select2('val','');
          <?php if($data['rol'] == 'admin_oficina'): ?>
          modal.find('#foficina').select2('val',"<?php echo e($data['user']->oficina_id); ?>");
          $("#foficina").select2("readonly", true);
          <?php endif; ?>          
          modal.find('#ftipousuario').select2("readonly", false);
          modal.find('#femail').attr("readonly",false);
          modal.find('form').attr('action','<?php echo e(route("usuarios/store", app()->getLocale())); ?>');
        }
        else if ($(this).data('action') == "update"){
          modal.find('#fnombre').val($(this).data('nombre'));
          modal.find('#femail').val($(this).data('email'));
          modal.find('#id_user').val($(this).data('id'));
          modal.find('#passgroup').hide();
          modal.find('#newpassgroup').show(); 
          modal.find('#foficina').select2('val',$(this).data('oficina'));
          modal.find('#ftipousuario').select2('val',$(this).data('tipouser'));
          if($(this).data('actualuser')=="1"){
            modal.find('#ftipousuario').select2("readonly", true);
            modal.find('#femail').attr("readonly",true);
          }
          else{
            modal.find('#ftipousuario').select2("readonly", false);
            modal.find('#femail').attr("readonly",false);
          }
          <?php if($data['rol'] == 'admin_oficina'): ?>
          $("#foficina").select2("readonly", true);
          <?php endif; ?>   
          modal.find('form').attr('action','<?php echo e(route("usuarios/update", app()->getLocale())); ?>');
        }
      });


      //new/edit tramite x usuario
      $("a.open-modaltramite").click(function (e) {
        e.preventDefault();
        // Get the modal by ID
        var modal = $('#myModalTramite');
        modal.find('#modaltitle').text($(this).data('title'));
        
        var oficina=$(this).data('oficina');
        $("#ftramite > option").each(function() {
            if($(this).data('oficina')==oficina){
              $(this).css({"display":""});
            }
            else{
              $(this).css({"display":"none"});
            }
        });

        $("#ftramite").select2();
        $(".select2-container").css({"width":"100%","max-width":"100%","float":"right"});

        if ($(this).data('action') == "store"){
          modal.find('#id_user').val($(this).data('idusuario'));
          modal.find('#ftramite').select2('val',''); 
          modal.find('#flunesinicio').val(""); 
          modal.find('#flunesfin').val(""); 
          modal.find('#fmartesinicio').val("");  
          modal.find('#fmartesfin').val(""); 
          modal.find('#fmiercolesinicio').val(""); 
          modal.find('#fmiercolesfin').val(""); 
          modal.find('#fjuevesinicio').val(""); 
          modal.find('#fjuevesfin').val(""); 
          modal.find('#fviernesinicio').val("");  
          modal.find('#fviernesfin').val(""); 
          modal.find('#fsabadoinicio').val(""); 
          modal.find('#fsabadofin').val(""); 
          modal.find('form').attr('action','<?php echo e(route("usuarios/storetramitexuser", app()->getLocale())); ?>');
        }
        else if ($(this).data('action') == "update"){
          modal.find('#id_user').val($(this).data('idusuario'));
          modal.find('#id_tramitexuser').val($(this).data('id'));
          modal.find('#ftramite').select2('val',$(this).data('tramite'));
          modal.find('#flunesinicio').val($(this).data('lunesinicio')); 
          modal.find('#flunesfin').val($(this).data('lunesfin')); 
          modal.find('#fmartesinicio').val($(this).data('martesinicio')); 
          modal.find('#fmartesfin').val($(this).data('martesfin'));
          modal.find('#fmiercolesinicio').val($(this).data('miercolesinicio')); 
          modal.find('#fmiercolesfin').val($(this).data('miercolesfin'));
          modal.find('#fjuevesinicio').val($(this).data('juevesinicio')); 
          modal.find('#fjuevesfin').val($(this).data('juevesfin'));
          modal.find('#fviernesinicio').val($(this).data('viernesinicio')); 
          modal.find('#fviernesfin').val($(this).data('viernesfin'));
          modal.find('#fsabadoinicio').val($(this).data('sabadoinicio')); 
          modal.find('#fsabadofin').val($(this).data('sabadofin'));  

          modal.find('form').attr('action','<?php echo e(route("usuarios/updatetramitexuser", app()->getLocale())); ?>');
        }
      });

      //filtrating by nombre tramite for each user
      $(".searchtramite").keyup(function(){
        $this=$(this);
        $tableparent = $(this).closest('table');
        $nombrestramite = $tableparent.find(".nombretramite");
        $nombrestramite.closest("tr").hide();
        var value = $this.val().normalize('NFD').replace(/[\u0300-\u036f]/g, "").toUpperCase();        
        if(value!=""){
          $this.parent().find("close").show();
        }
        else{
          $this.parent().find("close").hide();
        }
        var showedcounter=$nombrestramite.length;
        $nombrestramite.each(function() { 
          var texto = $(this).html().normalize('NFD').replace(/[\u0300-\u036f]/g, "").toUpperCase();
          if(texto.indexOf(value)>= 0){
            $(this).closest("tr").show();
            showedcounter--;
          }
        });
        $tableparent.find(".noresults").remove();
        if(showedcounter==$nombrestramite.length){
          $tableparent.append("<tr class='noresults'><td colspan=15>Sin resultados de búsqueda</td></tr>");
        }
        else{
          $tableparent.find(".noresults").remove();
        }
      });
      //removing string to filtrate and show all again
      $(".searchtramitecontainer close").click(function(){
        $this=$(this);
        $this.closest("td").find("input").val("");
        $this.closest("table").find("tr").show();
        $this.hide();
      });

      //validating fechas
      $("#flunesinicio").change(function(){
        if($(this).val()!=""){
          $("#flunesfin").prop('required',true);          
        }
        else{
          $("#flunesfin").prop('required',false);
        }
      });
      $("#flunesfin").change(function(){
        if($(this).val()!=""){
          $("#flunesinicio").prop('required',true);
        }
        else{
          $("#flunesinicio").prop('required',false);
        }
      });
      $("#fmartesinicio").change(function(){
        if($(this).val()!=""){
          $("#fmartesfin").prop('required',true);          
        }
        else{
          $("#fmartesfin").prop('required',false);
        }
      });
      $("#fmartesfin").change(function(){
        if($(this).val()!=""){
          $("#fmartesinicio").prop('required',true);
        }
        else{
          $("#fmartesinicio").prop('required',false);
        }
      });
      $("#fmiercolesinicio").change(function(){
        if($(this).val()!=""){
          $("#fmiercolesfin").prop('required',true);          
        }
        else{
          $("#fmiercolesfin").prop('required',false);
        }
      });
      $("#fmiercolesfin").change(function(){
        if($(this).val()!=""){
          $("#fmiercolesinicio").prop('required',true);
        }
        else{
          $("#fmiercolesinicio").prop('required',false);
        }
      });
      $("#fjuevesinicio").change(function(){
        if($(this).val()!=""){
          $("#fjuevesfin").prop('required',true);          
        }
        else{
          $("#fjuevesfin").prop('required',false);
        }
      });
      $("#fjuevesfin").change(function(){
        if($(this).val()!=""){
          $("#fjuevesinicio").prop('required',true);
        }
        else{
          $("#fjuevesinicio").prop('required',false);
        }
      });
      $("#fviernesinicio").change(function(){
        if($(this).val()!=""){
          $("#fviernesfin").prop('required',true);          
        }
        else{
          $("#fviernesfin").prop('required',false);
        }
      });
      $("#fviernesfin").change(function(){
        if($(this).val()!=""){
          $("#fviernesinicio").prop('required',true);
        }
        else{
          $("#fviernesinicio").prop('required',false);
        }
      });
      $("#fsabadoinicio").change(function(){
        if($(this).val()!=""){
          $("#fsabadofin").prop('required',true);          
        }
        else{
          $("#fsabadofin").prop('required',false);
        }
      });
      $("#fsabadofin").change(function(){
        if($(this).val()!=""){
          $("#fsabadoinicio").prop('required',true);
        }
        else{
          $("#fsabadoinicio").prop('required',false);
        }
      });

      $("#myModalTramite form button[type='submit']").click(function( event ) {
        //lunes        
        if($("#flunesinicio").val()!="" && $("#flunesfin").val()!=""){
          var hora1=$("#flunesinicio").val().split(":");
            var time1=hora1[0]*60+hora1[1];
          var hora2=$("#flunesfin").val().split(":");
            var time2=hora2[0]*60+hora2[1];          
          if(parseInt(time1)>=parseInt(time2)){           
            $("#flunesinicio")[0].setCustomValidity("La hora inicio debe ser menor a la hora fin");       
          }
          else{
            $("#flunesinicio")[0].setCustomValidity('');
          }
        }
        //martes        
        if($("#fmartesinicio").val()!="" && $("#fmartesfin").val()!=""){
          var hora1=$("#fmartesinicio").val().split(":");
            var time1=hora1[0]*60+hora1[1];
          var hora2=$("#fmartesfin").val().split(":");
            var time2=hora2[0]*60+hora2[1];          
          if(parseInt(time1)>=parseInt(time2)){          
            $("#fmartesinicio")[0].setCustomValidity("La hora inicio debe ser menor a la hora fin");       
          }
          else{
            $("#fmartesinicio")[0].setCustomValidity('');
          }
        }
        //miercoles        
        if($("#fmiercolesinicio").val()!="" && $("#fmiercolesfin").val()!=""){
          var hora1=$("#fmiercolesinicio").val().split(":");
            var time1=hora1[0]*60+hora1[1];
          var hora2=$("#fmiercolesfin").val().split(":");
            var time2=hora2[0]*60+hora2[1];          
          if(parseInt(time1)>=parseInt(time2)){            
            $("#fmiercolesinicio")[0].setCustomValidity("La hora inicio debe ser menor a la hora fin");       
          }
          else{
            $("#fmiercolesinicio")[0].setCustomValidity('');
          }
        }
        //jueves        
        if($("#fjuevesinicio").val()!="" && $("#fjuevesfin").val()!=""){
          var hora1=$("#fjuevesinicio").val().split(":");
            var time1=hora1[0]*60+hora1[1];
          var hora2=$("#fjuevesfin").val().split(":");
            var time2=hora2[0]*60+hora2[1];          
          if(parseInt(time1)>=parseInt(time2)){           
            $("#fjuevesinicio")[0].setCustomValidity("La hora inicio debe ser menor a la hora fin");       
          }
          else{
            $("#fjuevesinicio")[0].setCustomValidity('');
          }
        }
        //viernes        
        if($("#fviernesinicio").val()!="" && $("#fviernesfin").val()!=""){
          var hora1=$("#fviernesinicio").val().split(":");
            var time1=hora1[0]*60+hora1[1];
          var hora2=$("#fviernesfin").val().split(":");
            var time2=hora2[0]*60+hora2[1];      
          if(parseInt(time1)>=parseInt(time2)){             
            $("#fviernesinicio")[0].setCustomValidity("La hora inicio debe ser menor a la hora fin");       
          }
          else{
            $("#fviernesinicio")[0].setCustomValidity('');
          }
        }
        //sabado        
        if($("#fsabadoinicio").val()!="" && $("#fsabadofin").val()!=""){
          var hora1=$("#fsabadoinicio").val().split(":");
            var time1=hora1[0]*60+hora1[1];
          var hora2=$("#fsabadofin").val().split(":");
            var time2=hora2[0]*60+hora2[1];          
          if(parseInt(time1)>=parseInt(time2)){        
            $("#fsabadoinicio")[0].setCustomValidity("La hora inicio debe ser menor a la hora fin");       
          }
          else{
            $("#fsabadoinicio")[0].setCustomValidity('');
          }
        }
        
        if ($(this)[0].checkValidity()){
          $(this)[0].reportValidity();
        }
        else{
          $("#myModalTramite form").submit();
        }

      });

    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.headerauth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>