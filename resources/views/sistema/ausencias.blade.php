@extends('layouts.headerauth')

@section('page-style-files')
<!--<link rel="stylesheet" href="{{url('/sis/vendors/css/bootstrap-datetimepicker.css')}}" type="text/css" media="all">-->
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
  .leftfilter{ padding-right: 0px; padding-left: 0px }
    .leftfilter .input-group-text{ border-radius:4px 0px 0px 4px; }
    .leftfilter .form-control{ border-right: 0px none }
  .rightfilter{ padding-left: 0px; padding-right: 0px}

  @media (max-width: 991px){
    .leftfilter{ margin-top: 15px }
    .rightfilter{ margin-top: 15px }
  }
  @media (max-width: 767px){
    .leftfilter .form-control{ border-right: 1px solid #c2cfd6; border-radius: 0px 4px 4px 0px;}
    .rightfilter{ margin-top: 0px }
    .rightfilter .input-group-text{ border-radius:4px 0px 0px 4px; }
  }
  @media (max-width: 374px){
    .rightfilter .input-group-text,.leftfilter .input-group-text{ font-size:10px; }
  }
  .datepicker{ padding: 8px!important }
</style>
@endsection

@section('content')
  <!-- Main content -->
  <main class="main">

    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <!--<li class="breadcrumb-item"><a href="#">Admin</a></li>-->
      <li class="breadcrumb-item"><a href="route('usuarios', app()->getLocale())">Usuarios</a></li>
      <li class="breadcrumb-item active">Ausencias</li>
    </ol>

    <div class="container-fluid">

      <div class="animated fadeIn cards">
    
        <div class="col-md-12 valoracion pasos direcciones">
          <!--This will print succes or error message after doing a DB transaction-->
          @if (\Session::has('success'))
          <div class="alert alert-success">
            {{ \Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
          @if (\Session::has('errors'))
          <div class="alert alert-danger">
            {{ \Session::get('errors') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
          <div class="tab-content">
            <div class="tab-pane active">
              <form method="get" class="form-horizontal tabsearch">
                  <div class="form-group row">
                      <div class="col-lg-3">
                          <a class="btn btn-warning btn-search open-modal" href="#" data-toggle="modal" data-target="#myModal"
                          data-action = "store"
                          data-usuario= "{{$usuario->id_user}}"
                          data-title  = "Nueva ausencia">Crear nueva ausencia <i class="icon-arrow-right"></i></a>
                      </div>
                      <div class="col-lg-9 col-md-12 ">
                        <div class="col-md-6 separator leftfilter">
                            <div class="input-prepend input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-calendar" style="margin-right:10px"></i> Desde f. inicio</span>
                              </div>
                              <input id="datetimepicker1" class="form-control" size="16" type="text" placeholder="YYYY-MM-DD" required value="{{$filtersfecha1}}"
                               name="filtersfecha1" autocomplete="off">
                              </div>
                            </div>

                           <div class="col-md-6 separator rightfilter">
                            <div class="input-prepend input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">Hasta f. inicio</span>
                              </div>
                              <input id="datetimepicker2" class="form-control" size="16" type="text" placeholder="YYYY-MM-DD" required value="{{$filtersfecha2}}"
                               name="filtersfecha2" autocomplete="off">
                              <span class="input-group-append">
                                <button class="btn btn-primary buttonclick" type="submit"><i class="fa fa-search"></i></button>
                              </span>
                            </div>
                        </div>
                      </div>
                      
                      
                  </div>
              </form>                                                        
            </div>
          </div>
                      

          <div class="cardsoutside">
                                                               
              <div class="card">
                   
                  <div class="card-header">
                    <h5 style="margin-bottom:0px">Ausencias de {{$usuario->nombre}}</h5>
                  </div>

                  <div class="card-body">

                      <div class="col-sm-12 table-responsive">

                        <table class="table  table-striped">
                              <thead>
                                @if(count($ausencias)> 0 )
                                <tr>                                                                                  
                                  <th>Acciones</th>                                        
                                  <th>Fecha Inicio</th>
                                  <th>Fecha Fin</th>   
                                  <th>Motivo</th>                                                                  
                                </tr>
                                @endif
                              </thead>
                              <tbody>
                              @if(count($ausencias)> 0 )                                        
                                  @php
                                  $ausenciastring="";
                                  @endphp
                                  @foreach($ausencias as $ausencia) 
                                    @php
                                        if($ausenciastring!=$ausencia->fecha_iniciotoorder){
                                            $ausenciastring=$ausencia->fecha_iniciotoorder;
                                            echo "<tr><td colspan='4' style='background: #fff; padding:0px'>
                                              <div class='text-uppercase' style='background:#fff; border:1px solid #fff; margin-top:15px;
                                            width: 100%; float: left; padding:10px; border-bottom:0px none; font-size:15px; font-weight: 500'>$ausenciastring</div></td></tr>";
                                        }
                                    @endphp
                                                                                    
                                    <tr>                                            
                                        <td style="padding-right:0px">
                                          <div style="float:left; width:165px">
                                            <a href="#" class="btn btn-warning btn-sm float-left open-modal" 
                                              data-toggle       = "modal" 
                                              data-target       = "#myModal"
                                              data-action       = "update"
                                              data-id           = "{{$ausencia->id_ausencia}}"
                                              data-title        = "Editando ausencia"
                                              data-fechainicio  = "{{$ausencia->fecha_inicioparsed}}"  
                                              data-fechafin     = "{{$ausencia->fecha_finparsed}}" 
                                              data-usuario      = "{{$ausencia->user_id}}"
                                              data-motivo       = "{{$ausencia->motivo}}" 
                                            >Editar</a> 

                                            <form id="fr_ausencia{{$ausencia->id_ausencia}}" action="{{route('ausencias/destroy', app()->getLocale())}}" name="_method" method="post" style="float:left">
                                              <a href="#" 
                                              class="btn btn-danger btn-sm"
                                              style="margin-left:10px; margin-top:0px; float:left" 
                                              data-toggle           = "confirmation"
                                              data-id               = "{{$ausencia->id_ausencia}}"
                                              data-btn-ok-label     = "Aceptar" 
                                              data-btn-ok-icon      = "fa fa-remove"
                                              data-btn-ok-class     = "btn btn-danger btn-sm"
                                              data-btn-cancel-label = "Cancelar"
                                              data-btn-cancel-icon  = "fa fa-chevron-circle-left"
                                              data-btn-cancel-class = "btn btn-sm btn-warning"
                                              data-title            = "Desea borrar esta ausencia?"
                                              data-target           = "#removeAusencia"
                                              data-placement        = "left" 
                                              data-singleton        = "true" 
                                              data-type             = "ausencia" 
                                              >Eliminar</a>
                                              @csrf
                                              <input type="hidden" name="id_ausencia" value="{{$ausencia->id_ausencia}}"/>
                                            </form>

                                          </div>
                                        </td>
                                                                                       
                                        <td ><div style="float:left; width:150px; text-transform: capitalize;">{{$ausencia->fecha_iniciohuman}}</div></td> 
                                        <td ><div style="float:left; width:150px; text-transform: capitalize;">{{$ausencia->fecha_finhuman}}</div></td>
                                        <td ><div style="float:left; width:250px; text-transform: capitalize;">{{$ausencia->motivo}}</div></td>
                                                                                        
                                    </tr>
                                                                                                                                                                                                                
                                  @endforeach                                                                                  
                              @else
                                <span>No tienes ninguna ausencia para este usuario aún.</span>
                              @endif
                              </tbody>
                        </table>

                      </div>

                  </div>
                  
              </div>
                
               

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
            
            <input type="hidden" id="id_usuario" name="id_usuario"  />
            <input type="hidden" id="id_ausencia" name="id_ausencia"  />            

            <div class="form-group">
              <label for="company">Fecha Inicio:</label>
              <input type="datetime-local" class="form-control" id="ffechainicio" name="fechainicio"  required/>
            </div>
                        
            <div class="form-group">
              <label for="company">Fecha Fin:</label>
              <input type="datetime-local" class="form-control" id="ffechafin" name="fechafin"  required />
            </div>

            <div class="form-group">
              <label for="company">Motivo:</label>
              <input type="text" class="form-control" id="motivo" name="motivo"  required />
            </div>
                            
            
        </div>
        <div class="modal-footer">
          @csrf
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-warning">Guardar</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->



  


@endsection

@section('page-js-script')
  <!--<script src="{{url('/sis/vendors/js/bootstrap-datetimepicker.js')}}" type="text/javascript"></script> --> 
  <script>
    $(document).ready(function(){
        
      $('#datetimepicker1').datepicker({
        format: 'yyyy-mm-dd',
        useCurrent:false,
        language: 'es',autoclose:true,
        daysOfWeekDisabled:[0]
      });
      $('#datetimepicker2').datepicker({
        format: 'yyyy-mm-dd',
        useCurrent:false,
        language: 'es',autoclose:true,
        daysOfWeekDisabled:[0]
      });
      $("#datetimepicker1").on("change", function (e) {
        $('#datetimepicker2').datepicker("update",$("#datetimepicker1").val()).datepicker('setStartDate', $("#datetimepicker1").val());
      });
      

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
          modal.find('#id_usuario').val($(this).data('usuario'));
          modal.find('#id_ausencia').val("");
          modal.find('#ffechainicio').val("");
          modal.find('#ffechafin').val("");                                       
          modal.find('#motivo').val("");
          modal.find('form').attr('action','{{route("ausencias/store", app()->getLocale())}}');
        }
        else if ($(this).data('action') == "update"){            
          modal.find('#id_ausencia').val($(this).data('id'));
          modal.find('#id_usuario').val($(this).data('usuario'));
          modal.find('#ffechainicio').val($(this).data('fechainicio'));
          modal.find('#ffechafin').val($(this).data('fechafin'));    
          modal.find('#motivo').val($(this).data('motivo'));        
          modal.find('form').attr('action','{{route("ausencias/update", app()->getLocale())}}');
        }
      });
      
      //click alert message to close
      $("body").on('click','.responsemessage', function(){
        $this=$(this);
        $this.slideUp().removeClass("showed");
      });


    });
  </script>
@endsection
