<?php $__env->startSection('page-style-files'); ?>
  <style type="text/css">
    .cardsoutside .card-body span.response{ border-bottom:1px solid rgba(0, 0, 0, 0.1); padding-bottom:1.5em; margin-bottom:1.5em; width:100%; float:left}
    .cardsoutside .card-body span.response:last-child{ border-bottom:0px none; padding-bottom:0em; margin-bottom:0em}
    .sendmessage textarea {
      height: 120px;
      font-size: 12px;
      padding: 12px;
      outline: none;
      -webkit-box-shadow: none;
      -moz-box-shadow: none;
      box-shadow: none;
    }
    .help-block{ color:#aaa; font-size:11px; margin-top:7px}
    .card .avatar{ background:#fff}
    .card .avatar img{ width:100%}
    .modal-body input::placeholder{ color:#aaa}
    .modal-body label{ margin-bottom:0.2rem; font-weight:500}
    .form-group{ margin-bottom:0.6rem}
    quote{ float: left; color: #F1C81E; font-weight: bold; margin:0px; margin-right: 10px}
    .responsesmall{ margin-bottom: 5px; float: left; width: 100% }
      .responsesmall b{ text-transform: capitalize; }
      .mt4{ margin-top: 6px }
    .stared{color:#F1C81E!important; font-size: 16px}
    stars{ float: right}
      @media  only screen and (max-width: 374px){
        .pasos .card-header h5{ font-size: 1rem }
      }
      .row{ margin-left: -15px; margin-right: -15px }
      fecha{ float: right; position: relative; padding-top:5px; font-size: 11px;}
        fecha small{color: #F1C81E; position: absolute;top: -9px; font-size: 9px; right: 0px}
      #results{ width: 100%; float: left}
      .showmorecontainer{ border-top: 1px solid #ccc; padding-top: 20px; margin-top: 20px; float: left!important; width: 100%; text-align: center;}
  </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Main content -->
    <main class="main">

      <!-- Breadcrumb -->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <?php if($tipo=='user'): ?><li class="breadcrumb-item active"><?php echo e(__('lblProfile1')); ?></li><?php endif; ?>
        <?php if($tipo=='tramitador'): ?><li class="breadcrumb-item active"><a href="<?php echo e(route('usuarios', app()->getLocale())); ?>"><?php echo e(__('lblProfile2')); ?></a></li> <li class="breadcrumb-item active"><?php echo e(__('lblProfile1')); ?></li><?php endif; ?>

      </ol>

      <div class="container-fluid">

        <div class="animated fadeIn">

          <!--/.row-->
			<div class="row">
                <div class="col-md-12 valoracion pasos direcciones perfil">
                  <!--This will print succes or error message after doing a DB transaction-->
                  <?php if(\Session::has('success')): ?>
                    <div class="alert alert-success">
                    <?php echo e(\Session::get('success')); ?>

                  </div>
                  <?php endif; ?>
                  <?php if(\Session::has('errors')): ?>
                    <div class="alert alert-warning">
                    <?php echo e(\Session::get('errors')); ?>

                  </div>
                  <?php endif; ?>
                    <div class="cardsoutside">
                        <div <?php if( $user['rol'] == 'tramitador'): ?> class="col-lg-4 col-md-5 float-left" <?php else: ?> class="col-lg-4 col-md-6 float-left offset-lg-4 offset-md-3" <?php endif; ?>>
                           <div class="card card-user">
                               <div class="image"><img src="<?php echo e(url('/images/bg.jpg')); ?>" alt="..."></div>
                               <div class="content">
                                  <div class="author">
                                    <span class="avatar border-white"><img src="<?php echo e(url('/sis/img/user.svg')); ?>" /></span>
                                    <h4 class="title"> <?php echo e($user["name"]); ?><br />
                                      <b style="color:rgba(0,0,0,0.6); font-weight:normal; font-size:0.8em"><?php if( $user['rol'] == 'superadmin'): ?> Superadministrador <?php endif; ?> <?php if( $user['rol'] == 'admin_oficina'): ?> <?php echo e(__('lblProfile28')); ?>  <?php endif; ?> <?php if( $user['rol'] == 'tramitador'): ?> <?php echo e(__('lblProfile30')); ?>  <?php endif; ?> <?php if( $user['rol'] == 'kiosko'): ?> <?php echo e(__('lblProfile29')); ?>  <?php endif; ?></b>
                                      <br>
                                      <small><?php echo e(__('lblProfile3')); ?>

                                        
                                          <?php if($user['dependencia']): ?>
                                            <?php echo e($user['dependencia']->nombre_oficina); ?> 
                                          <?php endif; ?>
                                        
                                      </small>                                                                            
                                    </h4>
                                  </div>
                                 
                                  <p class="description text-center" style="margin-bottom: 20px">
                                  	 <i class="icon-envelope-open"></i><a href="mailto:<?php echo e($user['user']->email); ?>" target="_blank" style="color:#151b1e"> <?php echo e($user['user']->email); ?></a><br>
                                     <?php if( $user['rol'] == 'tramitador'): ?> <?php if($user['user']->disponibleturno=="si"): ?> <i class="icon-check"></i> <?php echo e(__('lblProfile27')); ?> <?php else: ?> <i class="icon-close"></i> <?php echo e(__('lblProfile26')); ?>  <?php endif; ?> <br><?php endif; ?>
                                      <?php if($tipo=='user'): ?><br>
                                     <a href="#" data-toggle="modal" data-target="#myModal"  class="btn btn-warning btn-sm open-modal"><?php echo e(__('lblProfile4')); ?></a> <a href="#" data-toggle="modal" data-target="#myModalPassword" class="btn btn-secondary btn-sm"><?php echo e(__('lblProfile5')); ?></a>
                                     <?php endif; ?>  
                                  </p>
                                  
                               </div>
                               
                               
                            </div>
                        </div>

						            <?php if( $user['rol'] == 'tramitador'): ?>
                        <div class="col-lg-8 col-md-7 float-left">
                        	<div class="card">
                            <div class="card-header">
                              <h5 style="margin-bottom:0px"><?php echo e(__('lblProfile6')); ?>

                                <stars>
                                  <?php for($i=1;$i<=$estrellas;$i++): ?>
                                    <i class="fa fa-star stared"></i>
                                  <?php endfor; ?>
                                  <?php for($i=$estrellas+1;$i<=5;$i++): ?>
                                    <i class="far fa-star stared"></i>
                                  <?php endfor; ?>
                                </stars>
                              </h5>
                            </div>
                            <div class="card-body">
                              <div class="col-md-12 float-left">
								                <input type="hidden" value="<?php echo e($offset); ?>" id="offset"> 
                                <input type="hidden" value="<?php echo e($totalvaloraciones); ?>" id="totalvaloraciones">
                                <input type="hidden" value="<?php echo e($user['user']->id_user); ?>" id="tramitador">
                                <?php if(count($valoraciones)> 0 ): ?>
                                    <div id="results">
                                      <?php $__currentLoopData = $valoraciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valoracion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                		  <h6><?php echo e($valoracion->nombre_ciudadano); ?> <span class="float-right badge badge-gray-100 badge-pill morelittle"><k><?php echo e($valoracion->created_at); ?></k></h6>
                                      <span class="responsesmall mt4">
                                        <?php for($i=1;$i<=$valoracion->estrellas;$i++): ?>
                                          <i class="fa fa-star stared"></i>
                                        <?php endfor; ?>
                                        <?php for($i=$valoracion->estrellas+1;$i<=5;$i++): ?>
                                          <i class="far fa-star stared"></i>
                                        <?php endfor; ?>
                                        <fecha><small><?php echo e(__('lblProfile7')); ?></small><?php echo e($valoracion->fecha); ?></fecha>
                                      </span>  
                                      <span class="responsesmall"><quote><?php echo e(__('lblProfile8')); ?></quote> <?php echo e($valoracion->nombre_tramite); ?></span>
                                      <span class="responsesmall"><quote><?php echo e(__('lblProfile9')); ?></quote> <?php echo e(__('lblProfile12')); ?> <b><?php echo e($valoracion->respuesta1); ?></b></span>
                                      <span class="responsesmall"><quote><?php echo e(__('lblProfile10')); ?></quote> <?php echo e(__('lblProfile13')); ?>  <b><?php echo e($valoracion->respuesta2); ?></b></span>
                                      <span class="response"><quote><?php echo e(__('lblProfile11')); ?></quote> <?php if($valoracion->observaciones!=""): ?><?php echo nl2br($valoracion->observaciones); ?><?php else: ?>---<?php endif; ?></span>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                    </div>  
                                    <?php if($totalvaloraciones>$offset): ?>
                                    <div class="showmorecontainer"><a href="#" class="btn btn-sm btn-primary showmore"><?php echo e(__('lblProfile15')); ?></a></div>  
                                    <?php endif; ?>

                                <?php else: ?>
                                    <h6><?php echo e(__('lblProfile14')); ?></h6>                                                                                                                            
                                <?php endif; ?>
                                                            	                                      
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php endif; ?>


                    </div>


                </div>

            </div>
          <!--/.card-->

          <?php if($tipo=='user'): ?>
            <div class="modal fade" id="myModal"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title"><?php echo e(__('lblProfile16')); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <form action="<?php echo e(route('updateperfil', app()->getLocale())); ?>" method="post" enctype="multipart/form-data">
                      <div class="modal-body">

                          <div class="form-group">
                            <label for="company"><?php echo e(__('lblProfile17')); ?></label>
                            <input type="text" class="form-control" id="nombres" name="nombre"  value="<?php echo e($user['user']->nombre); ?>" placeholder="" required>
                          </div>
                          
                          <div class="form-group">
                            <label for="vat"><?php echo e(__('lblProfile18')); ?></label>
                            <input type="text" class="form-control" id="email"  name="email" value= "<?php echo e($user['user']->email); ?>" placeholder="p.e.: mail@dominio.com" readonly="readonly">
                          </div>                                                    

                      </div>
                      <div class="modal-footer">
                        <?php echo csrf_field(); ?>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('lblProfile19')); ?></button>
                        <button type="submit" class="btn btn-warning"><?php echo e(__('lblProfile20')); ?></button>
                      </div>
                    </form>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>



            <div class="modal fade" id="myModalPassword" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title"><?php echo e(__('lblProfile21')); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <form action="<?php echo e(route('updatepassword', app()->getLocale())); ?>" method="post">
                   <div class="modal-body">

                      <div class="form-group">
                        <label for="company"><?php echo e(__('lblProfile22')); ?></label>
                        <input type="password" class="form-control" id="current-password" name="current-password"  placeholder="<?php echo e(__('lblProfile22')); ?>" required>
                      </div>

                      <div class="form-group">
                        <label for="company"><?php echo e(__('lblProfile23')); ?></label>
                        <input type="password" class="form-control" id="pass"  name="pass" placeholder="<?php echo e(__('lblProfile23')); ?>" required>
                      </div>

                      <div class="form-group">
                        <label for="vat"><?php echo e(__('lblProfile24')); ?></label>
                        <input type="password" class="form-control" id="pass_confirmation"  name="pass_confirmation" placeholder="<?php echo e(__('lblProfile24')); ?>" required>
                      </div>

                   </div>
                   <div class="modal-footer">
                    <?php echo csrf_field(); ?>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('lblProfile19')); ?></button>
                    <button type="submit" class="btn btn-warning"><?php echo e(__('lblProfile20')); ?></button>
                   </div>
                 </form>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>

            <!-- /.modal -->
         <?php endif; ?>   

          <!--/.row-->
        </div>

      </div>
      <!-- /.conainer-fluid -->
    </main>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js-script'); ?>
  <script>
  $(document).ready(function(){

      $(".loading-main").fadeOut();

      <?php if($tipo=='user'): ?>
      $(function () {
        $("a.open-modal").click(function (e) {
          e.preventDefault();
          // Get the modal by ID  alert($(this).data('estado'));
          var modal = $('#myModal');
        });
      });
      <?php endif; ?>

      $(".showmore").click(function(){
        $.ajax({
          url: "<?php echo e(route('getevaluaciones', app()->getLocale())); ?>"+"/"+$("#tramitador").val()+"/"+$("#offset").val(), 
          type: "GET",
          dataType : 'json', 
          beforeSend: function(){ $(".loading-main").fadeIn(); },
          success : function(result) {
            $(".loading-main").fadeOut();
            if(result.error=="true"){
              $(".responsemessage").addClass("errorresponse");
              $(".responsemessage").addClass("showed").html(result.description).slideDown();                           
            }   
            else{
              
              for(i=0;i<result.valoraciones.length;i++){

                var printrow = ` 
                <h6>`+result.valoraciones[i].nombre_ciudadano+`<span class="float-right badge badge-gray-100 badge-pill morelittle"><k>`+result.valoraciones[i].created_at+`</k></h6>
                <span class="responsesmall mt4">`;
                  for(j=1;j<=result.valoraciones[i].estrellas;j++){                  
                    printrow = printrow + `<i class="fa fa-star stared"></i>`;
                  }
                  for(j=parseInt(result.valoraciones[i].estrellas)+1;j<=5;j++){                   
                    printrow = printrow + `<i class="far fa-star stared"></i>`;
                  }

                 

                printrow = printrow + `<fecha><small>Fecha/Hora atención</small>`+result.valoraciones[i].fecha+`</fecha>
                </span>  
                <span class="responsesmall"><quote>Trámite</quote> `+result.valoraciones[i].nombre_tramite+`</span>
                <span class="responsesmall"><quote>Pregunta 1</quote> ¿El asesor le atendió de manera cordial? <b>`+result.valoraciones[i].respuesta1+`</b></span>
                <span class="responsesmall"><quote>Pregunta 2</quote> ¿El asesor pudo ayudarle con su problema? <b>`+result.valoraciones[i].respuesta2+`</b></span>
                <span class="response"><quote>Observaciones</quote>`;
                 if(result.valoraciones[i].observaciones!=null){ printrow = printrow + result.valoraciones[i].observaciones.replace(/\n/g, "<br />");}else{printrow = printrow + `---`;}
                printrow = printrow + `</span>`;
                $("#results").append(printrow);  

                $("#offset").val(result.offset);
                if($("#offset").val()==$("#totalvaloraciones").val()){
                  $(".showmorecontainer").hide();
                }

              }

            }
          },
          error: function(xhr, resp, text) {
            $(".loading-main").fadeOut();
            $(".responsemessage").addClass("errorresponse");
            $(".responsemessage").addClass("showed").html("Ocurrió un error validando código, intenta más tarde").slideDown();
          }
        });
      });

  });

  var password = document.getElementById("pass"), confirm_password = document.getElementById("pass_confirmation");
  function validatePassword(){
    if(password.value != confirm_password.value) {
      let msg=
      confirm_password.setCustomValidity("<?php echo e(__('lblProfile25')); ?>");
    } else {
      confirm_password.setCustomValidity('');
    }
  }
  password.onchange = validatePassword;
  confirm_password.onkeyup = validatePassword;

  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.headerauth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>