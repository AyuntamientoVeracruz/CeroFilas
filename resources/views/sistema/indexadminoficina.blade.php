@extends('layouts.headerauth')

@section('page-style-files')
<style type="text/css">
.table th, .table td{    padding: 0.45rem 0.35rem; font-size: 12.5px}
  tr.hide{ display:none; background:#fff!important}
  tr.open{ display:table-row}
  table th {
      border-top: 0px none!important;
      padding-top: 0px!important;
  }
  .datepicker{ padding: 8px!important }
  .turnos-table{height: calc(95vh - 318px);min-height: 430px}
  .ultima{ font-size: 11px; color:#999}
  .filtersizquierdo {
    width: calc(71% - 40.25px)
  }
  .filtersderecho{
    width: 29%
  }
  .calendar{ width: 115px }
    .calendar .input-group > .form-control{ padding: 0.375rem 0.375rem; font-size: 0.75rem }
  .calendarto{ width: 130px }
  .calendarto .input-group-text{ font-size: 10px }
  .table td k{ font-size: 10px }
  @media (max-width: 767px){
    .filtersderecho{
    width:100%
    }
    .filtersizquierdo{
          width: calc(100% - 40.25px);
    }
    .calendar{ float: left }
  }
  @media (max-width: 575px){
    .filtersizquierdo{ position: relative; height: 80px }
    .calendar{ position: absolute; left: -50px; top: 50px; width: 49%; margin-top: 0px!important; }
    .calendarto{ left: auto; right: 0px; margin-left: 0px; width: 55%}
  }
  @media (max-width: 470px){
    .calendar{margin-left: 10px!important}
    .calendarto{ margin-left: 0px!important}
  }
  @media (max-width: 374px){
    .calendar{ width: calc(100vw - 100px) }
    .filtersizquierdo{ height: 120px }
    .calendarto{ top: 95px }
  }
  td div .badge-warning{ font-style: normal }
</style>
@endsection

@section('content')
  <!-- Main content -->
  <main class="main">

    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <!--<li class="breadcrumb-item"><a href="#">Admin</a></li>-->
      <li class="breadcrumb-item active">@if($tipo=='admin') Dashboard @else Visor de turnos/citas @endif</li>
    </ol>

    <div class="container-fluid">

      <div class="animated fadeIn cards">
        
          <div class="col-lg-12">              
            <div class="card table-container">                 
                <div class="card-header">
                  <h7>
                    <form id="searchturnoscitas" action="{{route('sistema', app()->getLocale())}}">
                      <k class="lh30">
                        <a href="#" class="btn btn-sm btn-primary br redobutton"><i class="fa fa-redo"></i></a>
                        <div class="filtersizquierdo">
                          <span class="float-left labeled" >Viendo:</span>
                          <div class="notlabeled">
                            <select class="float-left wauto br" name="tipo" id="tipo" >
                                <option value="turnos" selected="">Turnos</option>
                                <option value="citas">Citas</option>                              
                            </select>

                            <div class="calendar">  
                              <div class="input-prepend input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                                <input id="datetimepickers" class="form-control" size="11" type="text" placeholder="YYYY-MM-DD" name="datetimepickers" autocomplete="off"
                                value="{{date('Y-m-d')}}" readonly="">
                              </div>
                            </div>

                            <div class="calendar calendarto">  
                              <div class="input-prepend input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">Hasta</span>
                                </div>
                                <input id="datetimepickers2" class="form-control" size="11" type="text" placeholder="YYYY-MM-DD" name="datetimepickers2" autocomplete="off"
                                value="{{date('Y-m-d')}}" readonly="">
                              </div>
                            </div>   

                          </div>                               

                        </div>

                        <div class="filtersderecho">
                          <span class="float-left labeled" >Estatus:</span>
                          <div class="notlabeled">
                            <select class="float-left  br" name="estatus" id="estatus" >
                                <option value="">Todos los turnos</option>
                                <option value="creado" selected>Check-In</option>
                                <option value="enproceso">En proceso</option> 
                                <option value="finalizado">Finalizados</option> 
                                <option value="cancelado">Cancelados</option>                             
                            </select>  
                          </div>                      
                        </div>
                      </k>  
                    </form>                  
                  </h7>
                </div>
                <div class="card-body">
                  <div class="table-responsive turnos-table">
                    <table class="table  table-striped">
                      <thead>                        
                        <tr> 
                          <th></th>                                                      
                          <th>Estatus</th>
                          <th><b class="hour">Check-In</b></th>
                          <th>Trámite</th>
                          <th>Asesor</th> 
                          <th>Ciudadano</th>                                    
                        </tr>                        
                      </thead>
                      <tbody>

                        @if(count($turnos)> 0 )
                          @foreach($turnos as $turno)
                            <tr>                                            
                              <td class="tramites">                                
                                <a href="#" class="btn btn-secondary br btn-sm"><i class="fa fa-chevron-down"></i></a>                               
                              </td>                                                                             
                              <td style="text-transform: capitalize"><span class="badge badge-sm 
                                @if($turno->estatus=='creado') badge-primary @endif
                                @if($turno->estatus=='enproceso') badge-warning @endif
                                @if($turno->estatus=='finalizado') badge-success @endif
                                @if($turno->estatus=='cancelado') badge-danger @endif
                                ">@if($turno->estatus=='creado') Check-In @else {{$turno->estatus}} @endif</span></td> 
                              <td style="white-space: nowrap;"><i class="far fa-clock"></i> {{$turno->creado}}<br><k>{{$turno->fechacreado}}</k></td>                              
                              <td><div style="float:left; width:150px">{{$turno->nombre_tramite}}</div></td>
                              <td style="text-transform: capitalize">
                                <div style="float:left; width:210px">
                                  @if($turno->user_id=="")
                                    @if($tipo=='admin')
                                      <select class="usuario float-right w100 br" data-turno="{{$turno->id_turno}}">
                                        <option value="">Seleccione un asesor</option>
                                      @foreach($usuarios as $usuario)
                                        <option value="{{$usuario->id_user}}">{{$usuario->nombre}}</option>
                                      @endforeach
                                      </select>
                                    @else
                                    ---
                                    @endif
                                  @else
                                    <input type="text" class="form-control br" disabled="" value="{{$turno->nombre}}">
                                  @endif
                                  
                                </div>
                              </td>
                              <td style="text-transform: capitalize"><div style="float:left; width:150px">{{$turno->nombre_ciudadano}}</div></td>
                            </tr>

                            <tr class="hide">
                              <td colspan="6">
                                <div style="width: calc(100% - 80px); float: right">
                                  <table class="table" style="background:#fff!important">
                                      <thead>
                                        <tr style="background:#fff!important">
                                          <th>Folio Cita</th>
                                          <th>Folio Turno</th>
                                          <th>CURP</th>
                                          
                                          <th>Hora Inicio</th>
                                          <th>Hora Fin</th>
                                          <th>Observaciones</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr style="background:#fff!important">
                                          <td>@if($turno->cita!=""){{$turno->cita}}@else---@endif</td>
                                          <td>{{$turno->folio}}</td>
                                          <td>{{$turno->curp}}</td>

                                          <td>@if($turno->inicio!=""){{$turno->inicio}}@else---@endif</td>
                                          <td>@if($turno->fin!=""){{$turno->fin}}@else---@endif</td>
                                          <td><div style="float:left; width:200px">@if($tipo=='admin') @if($turno->observaciones!=""){!!nl2br($turno->observaciones)!!}@else --- @endif @else <i class="badge badge-sm badge-warning">Disponible sólo para administrador</i> @endif</div></td>
                                        </tr>
                                      </tbody>
                                  </table>
                                </div>
                              </td>
                            </tr>
                          @endforeach
                        @else
                          <tr><td colspan="6" style="text-align: center">No tienes turnos.</td></tr>
                        @endif 
                      </tbody>
                    </table>
                  </div>
                  <span class="ultima">Última fecha de actualización: <b>{{$ultimaactualizacion}}</b></span>
                </div>                                
            </div> 
          </div>

          



      </div>

    </div>

  </main>

  

@endsection

@section('page-js-script')
  <script>
    $(document).ready(function(){
      $(".loading-main").fadeOut();
      
      $("select").wrap('<div class="containercombo"></div>');
      $("select").select2();
      $(".select2-container").css({"width":"100%","max-width":"100%","float":"right"});

      $('#datetimepickers').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es',autoclose:true,
        daysOfWeekDisabled:[0],
        todayBtn: false
      });  

      $('#datetimepickers2').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es',autoclose:true,
        daysOfWeekDisabled:[0],
        todayBtn: false
      }); 
        
      //expand detalles  
      $("body").on("click",'.tramites',function (e) {
        if($(this).parent().next().children().length>0){
          $(this).parent().next().toggleClass("open");
          $(this).toggleClass("open");
        }
        return false;
      });

      //cambiamos estatus o fecha
      $("#tipo").change(function(){
        if($("#tipo").val()=="turnos"){
          getturnos();
        }
        else{
          getcitas();
        }
      });

      //cambiamos estatus o fecha
      $("#estatus,#datetimepickers,#datetimepickers2").change(function(){
        if($("#tipo").val()=="turnos"){
          getturnos();
        }
        else{
          getcitas();
        }
      });
      //refrescamos el contenido
      $(".redobutton").click(function(){
        if($("#tipo").val()=="turnos"){
          getturnos();
        }
        else{
          getcitas();
        }
        return false;
      });

      /*****ALERT***/   
      //click alert message to close
      $("body").on('click','.responsemessage', function(){
        $this=$(this);
        $this.slideUp().removeClass("showed");
      });

      //cambiamos asesor
      $("body").on("change",'.usuario',function(){
        $this=$(this);
        $turno=$(this).attr("data-turno");
        $option=$(this).find("option:selected");
        $.ajax({
          url: "{{route('updateturnos', app()->getLocale())}}/"+$turno+"/"+$option.val(), 
          type: "GET",
          dataType : 'json', 
          beforeSend: function(){ $(".loading-main").fadeIn(); },
          success : function(result) {
            //console.log(result);
            $(".loading-main").fadeOut();
            if(result.error=="true"){
              $(".responsemessage").addClass("errorresponse");
            }else{               
              $(".responsemessage").removeClass("errorresponse");
              //$this.select2("readonly",true);
            }           
            $(".responsemessage").addClass("showed").html(result.description).slideDown();
            getturnos();  
          },
          error: function(xhr, resp, text) {
            $(".loading-main").fadeOut();
            $(".responsemessage").addClass("errorresponse");
            $(".responsemessage").addClass("showed").html("Ocurrió un error asignando al asesor, intenta más tarde").slideDown();
          }
        });
      });

    });

    function getturnos(){

      $estatus=$("#estatus").val();
      $("#estatus")
              .find('option')
              .remove()
              .end()              
              .append('<option value="">Todos los turnos</option>')
              .append('<option value="creado">Check-In</option>')
              .append('<option value="enproceso">En proceso</option>')
              .append('<option value="finalizado">Finalizados</option>')
              .append('<option value="cancelado">Cancelados</option>');
              //.val($estatus);
      $("#estatus").select2('val',$estatus);

      $.ajax({
          url: "{{route('getturnos', app()->getLocale())}}/{{$data['rol']}}/{{$data['oficina']}}/"+$("#datetimepickers").val()+"@"+$("#datetimepickers2").val()+"/"+$("#estatus").val(), 
          type: "GET",
          dataType : 'json', 
          beforeSend: function(){ $(".loading-main").fadeIn(); },
          success : function(result) {                          
            
            $(".ultima b").html(moment().format('YYYY-MM-DD HH:m:s'));

            $(".turnos-table tbody").html("");
            var printrow;

            if(result.length>0){
              for (var i=0; i<result.length; i++) {
                printrow = printrow + `
                <tr>                                            
                  <td class="tramites">                                
                    <a href="#" class="btn btn-secondary br btn-sm"><i class="fa fa-chevron-down"></i></a>                               
                  </td>                                                                             
                  <td style="text-transform: capitalize"><span class="badge badge-sm `; 
                    if(result[i].estatus=='creado'){ printrow = printrow + `badge-primary`; }
                    if(result[i].estatus=='enproceso'){ printrow = printrow + `badge-warning`; }
                    if(result[i].estatus=='finalizado'){ printrow = printrow + `badge-success`; }
                    if(result[i].estatus=='cancelado'){ printrow = printrow + `badge-danger`; }
                printrow = printrow + `
                    ">`;if(result[i].estatus=='creado'){printrow = printrow + `Check-In`;}else{printrow = printrow + result[i].estatus;} printrow = printrow + `</span></td> 
                  <td style="white-space: nowrap;"><i class="far fa-clock"></i> `+result[i].creado+`<br><k>`+result[i].fechacreado+`</k></td>                              
                  <td><div style="float:left; width:150px">`+result[i].nombre_tramite+`</div></td>
                  <td style="text-transform: capitalize">
                    <div style="float:left; width:210px">`;
                      if(result[i].user_id==null){
                        @if($tipo=='admin')
                        printrow = printrow + `
                        <select class="usuario float-right w100 br" data-turno="`+result[i].id_turno+`">
                          <option value="">Seleccione un asesor</option>`;
                        @foreach($usuarios as $usuario)
                          printrow = printrow + `
                          <option value="{{$usuario->id_user}}">{{$usuario->nombre}}</option>`;
                        @endforeach
                        printrow = printrow + `</select>`;
                        @else
                        printrow = printrow + `---`;
                        @endif
                      }else{
                        printrow = printrow + `<input type="text" class="form-control br" disabled="" value="`+result[i].nombre+`">`;
                      } 
                printrow = printrow + `      
                    </div>
                  </td>
                  <td style="text-transform: capitalize"><div style="float:left; width:150px">`+result[i].nombre_ciudadano+`</div></td>
                </tr>
                <tr class="hide">
                  <td colspan="6">
                    <div style="width: calc(100% - 80px); float: right">
                      <table class="table" style="background:#fff!important">
                          <thead>
                            <tr style="background:#fff!important">
                              <th>Folio Cita</th>
                              <th>Folio Turno</th>
                              <th>CURP</th>
                              <th>Hora Inicio</th>
                              <th>Hora Fin</th>
                              <th>Observaciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr style="background:#fff!important">
                              <td>`;if(result[i].cita==null){printrow = printrow + `---`;}else{printrow = printrow + result[i].cita;} printrow = printrow + `</td>
                              <td>`;if(result[i].folio==null){printrow = printrow + `---`;}else{printrow = printrow + result[i].folio;} printrow = printrow + `</td>
                              <td>`;if(result[i].curp==null){printrow = printrow + `---`;}else{printrow = printrow + result[i].curp;} printrow = printrow + `</td>
                              <td>`;if(result[i].inicio==null){printrow = printrow + `---`;}else{printrow = printrow + result[i].inicio;} printrow = printrow + `</td>
                              <td>`;if(result[i].fin==null){printrow = printrow + `---`;}else{printrow = printrow + result[i].fin;} printrow = printrow + `</td>
                              <td><div style="float:left; width:200px">`;@if($tipo=='admin') if(result[i].observaciones==null){printrow = printrow + `---`;}else{printrow = printrow + result[i].observaciones.replace(/\n/g, "<br />");} @else printrow = printrow + `<i class="badge badge-sm badge-warning">Disponible solo para administrador</i>`; @endif printrow = printrow + `</div></td>
                            </tr>
                          </tbody>
                      </table>
                    </div>
                  </td>
                </tr>`;
              }
              $(".turnos-table tbody").html(printrow);
              $("select").wrap('<div class="containercombo"></div>');
              $("select").select2();
              $(".select2-container").css({"width":"100%","max-width":"100%","float":"right"});
            }
            else{
              $(".turnos-table tbody").html("<tr><td colspan='6' style='text-align: center'>No tienes turnos.</td></tr>");
            }
            
            $(".hour").html("Check-In");

            $(".loading-main").fadeOut();

          },
          error: function(xhr, resp, text) {
            $(".loading-main").fadeOut();
            $(".responsemessage").addClass("errorresponse");
            $(".responsemessage").addClass("showed").html("Ocurrió un error cargando turnos, intenta más tarde").slideDown();
          }
      });
    }




    function getcitas(){

      $estatus=$("#estatus").val();
      $("#estatus")
              .find('option')
              .remove()
              .end()
              .append('<option value="">Todas las citas</option>')
              .append('<option value="creado">Pendientes</option>')
              .append('<option value="check-in">Check-In</option>')
              .append('<option value="enproceso">En proceso</option>')
              .append('<option value="finalizado">Finalizadas</option>');
              //.append('<option value="cancelado">Cancelado</option>');
              //.val($estatus);
      $("#estatus").select2('val',$estatus);

      $.ajax({
          url: "{{route('getcitas', app()->getLocale())}}/{{$data['rol']}}/{{$data['oficina']}}/"+$("#datetimepickers").val()+"@"+$("#datetimepickers2").val()+"/"+$("#estatus").val(), 
          type: "GET",
          dataType : 'json', 
          beforeSend: function(){ $(".loading-main").fadeIn(); },
          success : function(result) {                          
            
            $(".ultima b").html(moment().format('YYYY-MM-DD HH:m:s'));

            $(".turnos-table tbody").html("");
            var printrow;
            //console.log(result);
            if(result.length>0){

              for (var i=0; i<result.length; i++) {
                printrow = printrow + `
                <tr>                                            
                  <td class="tramites">                                
                    <a href="#" class="btn btn-secondary br btn-sm"><i class="fa fa-chevron-down"></i></a>                               
                  </td>                                                                             
                  <td style="text-transform: capitalize"><span class="badge badge-sm `; 
                    if(result[i].estatus=='creado'){ printrow = printrow + `badge-secondary`; }
                    if(result[i].estatus=='enproceso'){ printrow = printrow + `badge-warning`; }
                    if(result[i].estatus=='finalizado'){ printrow = printrow + `badge-success`; }
                    if(result[i].estatus=='cancelado'){ printrow = printrow + `badge-danger`; }
                    if(result[i].estatus=='check-in'){ printrow = printrow + `badge-primary`; }
                printrow = printrow + `
                    ">`;if(result[i].estatus=='creado'){printrow = printrow + `Pendiente`;}else{
                          if(result[i].estatus=='finalizado'){printrow = printrow + `Finalizada`;}
                          else{printrow = printrow + result[i].estatus;}
                        }
                printrow = printrow + `</span></td> 
                  <td style="white-space: nowrap;"><i class="far fa-clock"></i> `+result[i].creado+`<br><k>`+result[i].fechacreado+`</k></td>                              
                  <td><div style="float:left; width:150px">`+result[i].nombre_tramite+`</div></td>
                  <td style="text-transform: capitalize">`;if(result[i].turno.length==0){printrow = printrow + `---`;}else{printrow = printrow + result[i].turno[0].nombre;} printrow = printrow + `</td>
                  <td style="text-transform: capitalize"><div style="float:left; width:150px">`+result[i].nombre_ciudadano+" "+result[i].appaterno_ciudadano+" "+result[i].apmaterno_ciudadano+`</div></td>
                </tr>
                <tr class="hide">
                  <td colspan="6">
                    <div style="width: calc(100% - 80px); float: right">
                      <table class="table" style="background:#fff!important">
                          <thead>
                            <tr style="background:#fff!important">
                              <th>Folio Cita</th>
                              <th>Folio Turno</th>
                              <th>CURP</th>
                              <th>Teléfono</th>
                              <th>Hora Inicio</th>
                              <th>Hora Fin</th>
                              <th>Observaciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr style="background:#fff!important">
                              <td>`;if(result[i].cita==null){printrow = printrow + `---`;}else{printrow = printrow + result[i].cita;} printrow = printrow + `</td>
                              <td>`;if(result[i].turno.length==0){printrow = printrow + `---`;}else{printrow = printrow + result[i].turno[0].folio;} printrow = printrow + `</td>
                              <td>`;if(result[i].turno.length==0){printrow = printrow + `---`;}else{printrow = printrow + result[i].turno[0].curp;} printrow = printrow + `</td>
                              <td>`;if(result[i].telefono==null){printrow = printrow + `---`;}else{printrow = printrow + result[i].telefono;} printrow = printrow + `</td>
                              <td>`;if(result[i].turno.length==0){printrow = printrow + `---`;}else{printrow = printrow + result[i].turno[0].fechahora_inicio;} printrow = printrow + `</td>
                              <td>`;if(result[i].turno.length==0){printrow = printrow + `---`;}else{printrow = printrow + result[i].turno[0].fechahora_fin;} printrow = printrow + `</td>
                              <td><div style="float:left; width:200px">`;@if($tipo=='admin')if(result[i].turno.length==0){printrow = printrow + `---`;}else{printrow = printrow + result[i].turno[0].observaciones.replace(/\n/g, "<br />");} @else printrow = printrow + `<i class="badge badge-sm badge-warning">Disponible solo para administrador</i>`; @endif printrow = printrow + `</div></td>
                            </tr>
                          </tbody>
                      </table>
                    </div>
                  </td>
                </tr>`;
              }
              $(".turnos-table tbody").html(printrow);
              $("select").wrap('<div class="containercombo"></div>');
              $("select").select2();
              $(".select2-container").css({"width":"100%","max-width":"100%","float":"right"});
            }
            else{
              $(".turnos-table tbody").html("<tr><td colspan='6' style='text-align: center'>No tienes citas.</td></tr>");
            }
            
            $(".hour").html("Hora Cita");            
            $(".loading-main").fadeOut();

          },
          error: function(xhr, resp, text) {
            $(".loading-main").fadeOut();
            $(".responsemessage").addClass("errorresponse");
            $(".responsemessage").addClass("showed").html("Ocurrió un error cargando citas, intenta más tarde").slideDown();
          }
      });
    }

  </script>
@endsection
