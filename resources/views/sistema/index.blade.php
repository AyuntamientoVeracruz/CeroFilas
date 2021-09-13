@extends('layouts.headerauth')

@section('content')
  <style type="text/css">
      .timerarea:before{ font-size:8px;}
  </style>    
  <!-- Main content -->
  <main class="main">

    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <div class="container-fluid">

      <div class="animated fadeIn cards">

        
          <div class="col-lg-3 col-md-4">
            <div class="card cardswitch">  
              <div class="card-header">
                <i class="fa fa-check-square-o"></i>Disponibilidad
              </div>
              <div class="card-body">
                <span class="mask hide"></span>
                <div class="switchcontainer">
                  <form id="form-availability">
                    <label class="switch">
                      <input type="checkbox" id="availability" name="availability" @if($data['disponibilidad']=='si') checked @endif>
                      <span class="slider round"></span>
                    </label>
                  </form>
                  @if($data['disponibilidad']=='si')<small class="blueish"> Disponible </small>@else <small> No disponible </small> @endif
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-9 col-md-8 " id="info-empty">
            <div>
              <span><i class="fa fa-exclamation-triangle"></i><span>Sin atención a ciudadano</span></span>
            </div>
          </div>

          <div class="col-lg-9 col-md-8 hide" id="info-turno">
            <div class="card non-cardswitch">  
              <div class="card-header">
                <span data-summary="turno"><i class="far fa-calendar"></i> Turno: <b></b></span>
                <span href="#" class="badge badge-secondary ml10" data-toggle="popover" id="cita">Con cita</span>
                <a href="#" data-toggle="modal" data-target="#myModal" class="float-right" id="historial">Ver historial</a>                
              </div>
              <div class="card-body">
                <div class="switchcontainer">
                  <div class="summary" data-summary="tramite">
                    <div class="image"><i class="far fa-file-alt"></i></div>
                    <p class="text sel-service">Trámite: <b></b></p>
                  </div>
                  <div class="summary" data-summary="nombre">
                    <div class="image"><i class="far fa-user"></i></div>
                    <p class="text sel-service">Nombre: <b></b></p>
                  </div>
                  <div class="summary summaryhour" data-summary="hora" >
                    <div class="image"><i class="far fa-clock"></i></div>
                    <p class="text sel-service">Hora de Inicio: <b></b></p>
                    <div class="timerareacontainer"></div>   
                  </div>

                </div>
              </div>
            </div>
          </div>

          <form id="form-response" class="w100 hide">
            <input type="hidden" name="turno" id="turno"> 
            <input type="hidden" name="confirmarypausar" id="confirmarypausar">   
            <div class="col-lg-12 col-md-12">            
              <label class="w100"><b>RESEÑA DE ATENCIÓN</b> <small class="float-right">Este campo es obligatorio</small></label>
              <textarea class="form-control" placeholder="Escribe una reseña de la asesoría/atención brindada al ciudadano." rows="5" required name="observaciones"
              id="observaciones"></textarea>            
            </div>
            <div class="col-lg-6 col-md-12 mt20">              
              <div class="input-prepend input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text bgtrb0 pl0">CURP</span>
                </div>
                <input type="text" class="form-control br text-uppercase" placeholder="Ingrese CURP del ciudadano" name="curp" id="curp" >  
              </div>
              <quote>Apoye al ciudadano con el <b>CURP</b>, es requerido para el historial, <a href="https://www.gob.mx/curp/" target="_blank" rel="noopener noreferrer">encuéntralo aquí.</a></quote>
            </div>

            <div class="col-lg-6 col-md-12 mt20">              
              <div class="input-prepend input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text bgtrb0 pl0">EMAIL</span>
                </div>
                <input type="email" class="form-control br" placeholder="Ingrese E-MAIL del ciudadano" name="email" id="email" >  
              </div>              
            </div>  

            <div style="float: left; width: 100%">  
              <div class="col-lg-4 col-md-4 col-sm-5 mt20">              
                <div class="input-prepend input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text bgtrb0 pl0">Estatus</span>
                  </div>
                  <select  name="estatus" required="" id="estatus">
                    <option value="finalizado">Finalizado</option>
                    <option value="cancelado">Cancelado</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 mt20"> 
                <input type="button" class="btn btn-warning br btn-block" value="Confirmar y pausar" id="confirmarypausarbutton">
              </div>
              <div class="col-lg-4 col-md-4 col-sm-3 mt20"> 
                <input type="button" class="btn btn-primary br btn-block" value="Confirmar" id="confirmarbutton">
              </div>
            </div>

          </form>  

        

      </div>

    </div>
    
  </main>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Historial de ciudadano</h4>
          
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          
          <div class="historial-oficina">
            <select name="oficina" id="oficina">
                <option value="">Todas las oficinas</option>
                @if(count($dependenciascombo)> 0 )
                  @foreach($dependenciascombo as $dependencia)                                          
                    @foreach($dependencia->oficinas as $oficina)
                      <option value="{{$oficina->id_oficina}}" @if($data['oficina']==$oficina->id_oficina) selected="" @endif>{{$oficina->nombre_oficina}}</option>
                    @endforeach
                  @endforeach
                @endif  
            </select>
          </div>

          <div class="historial">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

@endsection

@section('page-js-script')
  <script type="text/javascript">
      var setavailabilityurl = "{{route('setavailability', app()->getLocale())}}";
      var getassignmenturl = "{{route('getassignment', app()->getLocale())}}";
      var gethistorialurl = "{{route('gethistorial', app()->getLocale())}}";
      var attendingturnurl = "{{route('attendingturn',app()->getLocale())}}";
      var oficina="{{$data['oficina']}}";
      var sonidonotificacion="{{url('/sis/mp3/notificacion.mp3')}}";
  </script>
  <script src="{{url('/sis/js/dashboard.js')}}" type="text/javascript"></script>
@endsection
