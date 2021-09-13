@extends('layouts.headerauth')

@section('page-style-files')
<link rel="stylesheet" href="{{url('/sis/vendors/css/summernote.css')}}" type="text/css" media="screen">
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
@endsection

@section('content')
  <!-- Main content -->
  <main class="main">

    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <!--<li class="breadcrumb-item"><a href="#">Admin</a></li>-->
      <li class="breadcrumb-item active">Trámites</li>
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
                          data-oficina     = @if($data['rol']=='admin_oficina') "{{$data['oficina']}}" @else ""  @endif
                          data-title  = "Nuevo trámite">Crear nuevo trámite <i class="icon-arrow-right"></i></a>
                      </div>
                      <div @if($data['rol'] == 'superadmin') class="col-lg-4 col-md-12" @else class="col-lg-1" @endif>
                        @if($data['rol'] == 'superadmin')
                        <div style="margin-top: 2px">
                          <select  name="oficina" id="oficina">
                              <option value="">Todas las oficinas</option>
                              @if(count($dependenciascombo)> 0 )
                                @foreach($dependenciascombo as $dependencia)                                          
                                  @foreach($dependencia->oficinas as $oficina)
                                    <option value="{{$oficina->id_oficina}}" @if($filtersoficina==$oficina->id_oficina) selected="" @endif>{{$oficina->nombre_oficina}}</option>
                                  @endforeach
                                @endforeach
                              @endif  
                          </select>
                        </div>
                        @endif
                      </div>
                      <div @if($data['rol'] == 'superadmin') class="col-lg-0 col-md-0 lc" @else class="col-lg-3 lc" @endif>
                        
                        

                      </div>
                      <div class="col-lg-5">
                        <div class="input-group">
                          <input type="text" id="searchPars" name="searchPars" class="form-control" placeholder= "Buscar por nombre" value = "{{$filterstexto}}">
                          <span class="input-group-prepend">
                            <button type="submit" class="btn btn-secondary btn-search"><i class="fa fa-search"></i><span>Buscar</span></button>
                          </span>
                        </div>
                      </div>
                  </div>
              </form>                                                        
            </div>
          </div>
            
          <!--<form action="{{route('usuarios/csv', app()->getLocale())}}" method="get" class="form-horizontal tabsearch" style="width:100%; float:left">
              <div class="form-group row" style="float:right; margin-top:10px; margin-bottom:10px">
                  <div class="col-md-6">
                        <button type="submit" class="btn btn-warning btn-search" style="border-radius:4px">Descarga CSV usuarios <i class="fa fa-download"></i></button>
                    </div>
              </div>
          </form>-->

          <div class="cardsoutside">

            @if(count($dependencias)> 0 )
              @foreach($dependencias as $dependencia)                                          
                @foreach($dependencia->oficinas as $oficina)  
                  <div class="card">
                       
                      <div class="card-header">
                        <h5 style="margin-bottom:0px">Oficina {{$oficina->nombre_oficina}}</h5>
                      </div>

                      <div class="card-body">

                          <div class="col-sm-12 table-responsive">

                            <table class="table  table-striped">
                                  <thead>
                                    @if(count($oficina->tramites)> 0 )
                                    <tr>                                                                                  
                                      <th>Acciones</th>                                        
                                      <th>Estatus</th>
                                      <th>Nombre</th>
                                      <th>Requisitos</th> 
                                      <th class="text-right">Tiempo (min)</th> 
                                      <th class="text-right">Costo(s)</th>
                                      <th class="text-center">Código</th>                                          
                                    </tr>
                                    @endif
                                  </thead>
                                  <tbody>
                                  @if(count($oficina->tramites)> 0 )                                        
                                      @foreach($oficina->tramites as $tramite)                                                 
                                        <tr>                                            
                                            <td style="padding-right:0px">
                                              <div style="float:left; width:185px">
                                                <a href="#" class="btn btn-warning btn-sm float-left open-modal" 
                                                  data-toggle       = "modal" 
                                                  data-target       = "#myModal"
                                                  data-action       = "update"
                                                  data-id           = "{{$tramite->id_tramite}}"
                                                  data-title        = "Editando: {{$tramite->nombre_tramite}}"
                                                  data-nombre       = "{{$tramite->nombre_tramite}}"  
                                                  data-requisitos   = "{{$tramite->requisitos}}" 
                                                  data-tiempo       = "{{$tramite->tiempo_minutos}}" 
                                                  data-costo        = "{{$tramite->costo}}"
                                                  data-codigo       = "{{$tramite->codigo}}" 
                                                  data-dependencia  = "{{$tramite->dependencia_id}}"
                                                  data-warning      = "{{$tramite->warning_message}}"
                                                >Editar</a>
                                                                                                    
                                                <a href="#" 
                                                  class="btn @if($tramite->estatus=="activo") btn-success @else btn-secondary @endif btn-sm open-modalTramitexoficina"
                                                  style="margin-left:10px; margin-top:0px; float:left" 
                                                  data-toggle           = "modal"
                                                  data-target           = "#myModalTramitexoficina"
                                                  data-action           = @if($tramite->estatus=='activo') "update" @else "store" @endif
                                                  data-id               = "{{$tramite->id_tramitesxoficinas}}"  
                                                  data-title            = "@if($tramite->estatus!='activo') Activar @else Editar @endif trámite para: {{$oficina->nombre_oficina}}"
                                                  data-tramite          = "{{$tramite->id_tramite}}"                                                  
                                                  data-oficina          = "{{$tramite->oficina_id}}" 
                                                  data-fecha            = "{{$tramite->apply_date}}" 
                                                  >@if($tramite->estatus=="activo") <small>Aplica: {{$tramite->fecha}}</small> @else Activar @endif</a>
                                                
                                                @if($data['rol']=="superadmin")
                                                <form id="fr_tramite{{$tramite->id_tramite}}" action="{{route('tramites/destroy', app()->getLocale())}}" name="_method" method="post" style="float:left">
                                                  <a href="#" 
                                                  class="btn btn-danger btn-sm"
                                                  style="margin-top:10px; float:left" 
                                                  data-toggle           = "confirmation"
                                                  data-id               = "{{$tramite->id_tramite}}"
                                                  data-btn-ok-label     = "Aceptar" 
                                                  data-btn-ok-icon      = "fa fa-remove"
                                                  data-btn-ok-class     = "btn btn-danger btn-sm"
                                                  data-btn-cancel-label = "Cancelar"
                                                  data-btn-cancel-icon  = "fa fa-chevron-circle-left"
                                                  data-btn-cancel-class = "btn btn-sm btn-warning"
                                                  data-title            = "Desea borrar este trámite?"
                                                  data-target           = "#removeTramite"
                                                  data-placement        = "left" 
                                                  data-singleton        = "true" 
                                                  data-type             = "tramite" 
                                                  >Eliminar</a>
                                                  @csrf
                                                  <input type="hidden" name="id_tramite" value="{{$tramite->id_tramite}}"/>
                                                </form>       
                                                @endif
                                                      
                                              </div>
                                            </td>
                                                                                           
                                            <td style="text-transform: capitalize"><div style="float:left; width:100px">{{$tramite->estatus}}</div></td> 
                                            <td style="text-transform: capitalize"><div style="float:left; width:160px">{{$tramite->nombre_tramite}}</div></td>
                                            <td style="text-transform: capitalize"><div class="hidefield"><clicker>↓ Mostrar más</clicker><div>{!! nl2br($tramite->requisitos) !!}</div></div></td>
                                            <td style="text-transform: capitalize; text-align: right;">{{$tramite->tiempo_minutos}}</td>
                                            <td style="text-transform: capitalize; text-align: right;">{{$tramite->costo}}</td>
                                            <td style="text-transform: capitalize; text-align: center;">{{$tramite->codigo}}</td>
                                                                                            
                                        </tr>
                                                                                                                                                                                                                    
                                      @endforeach                                                                                  
                                  @else
                                    <span>No tienes ningún trámite aún.</span>
                                  @endif
                                  </tbody>
                            </table>

                          </div>

                      </div>
                      
                  </div>
                @endforeach
              @endforeach
            @endif  

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
              <label for="company">Nombre trámite:</label>
              <input type="text" class="form-control" id="fnombre" name="nombre" placeholder="Ingresa nombre del trámite" required maxlength="300"/>
            </div>
            
            <div class="form-group">
              <label for="street">Requisitos:</label>
              <textarea class="form-control" id="frequisitos" name="requisitos" placeholder="Ingresa requisitos" rows="5" ></textarea>
            </div>

            <div class="form-group">
              <label for="street">Costo(s):</label>
              <input type="text" class="form-control" id="fcosto" name="costo" placeholder="Describe el costo o costos, indicando a cada uno su signo de pesos" required="" />
            </div>

            <div class="row" style="margin-left: -15px; margin-right: -15px">
              <div class="form-group col-sm-6">
                <label for="street">Tiempo (min):</label>
                <input type="number" class="form-control" id="ftiempo" name="tiempo" placeholder="0" required="" />
              </div>
        
              <div class="form-group col-sm-6 codigocontainer">
                <label for="street">Código:</label>
                <input type="text" class="form-control text-uppercase" id="fcodigo" name="codigo" placeholder="XXXX" required="" minlength="4" maxlength="4" />
                <error><i class="fa fa-times"></i></error>
                <ok><i class="fa fa-check"></i></ok>
              </div>  

            </div>

            <div class="form-group">
              <label for="company">Mensaje de alerta:</label>
              <input type="text" class="form-control" id="fwarning" name="warning_message" placeholder="Ingresa texto de alerta" maxlength="100"/>
            </div>
                
            <div class="row">
              <div class="form-group col-sm-12 plr0">
                <label for="company">Dependencia:</label>
                <select id="fdependencia" name="dependencia" required>
                  <option value="">Seleccione una dependencia</option>  
                  @if(count($dependencias)> 0 )
                    @foreach($dependencias as $dependencia)                                                                
                        <option value="{{$dependencia->id_dependencia}}">{{$dependencia->nombre_dependencia}}</option>                     
                    @endforeach
                  @endif
                </select>
              </div>
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
              <label for="company">Fecha aplicación:</label>
              <input type="date" class="form-control" id="ffecha" name="fecha" required/>
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
  
  
  <script src="{{url('/sis/vendors/js/summernote.min.js')}}"></script>   

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
          @if($data['rol'] == 'admin_oficina')
          modal.find('#fdependencia').select2('val',"{{$data['dependencia']->dependencia_id}}");
          $("#fdependencia").select2("readonly", true);
          @endif          
          modal.find('form').attr('action','{{route("tramites/store", app()->getLocale())}}');
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
          @if($data['rol'] == 'admin_oficina')
          $("#fdependencia").select2("readonly", true);
          @endif   
          modal.find('form').attr('action','{{route("tramites/update", app()->getLocale())}}');
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
          dt=new Date(dt.setMonth(dt.getMonth() + 3)); 
          function appendLeadingZeroes(n){
            if(n <= 9){
              return "0" + n;
            }
            return n;
          }  
          modal.find('#ffecha').val(dt.getFullYear() + "-" + appendLeadingZeroes(dt.getMonth()+1) + "-" + appendLeadingZeroes(dt.getDate()) );   
          modal.find('form').attr('action','{{route("tramites/oficinastore", app()->getLocale())}}');          
        }
        else if ($(this).data('action') == "update"){  
          modal.find('#id_tramite').val($(this).data('tramite'));
          modal.find('#id_oficina').val($(this).data('oficina'));
          modal.find('#id_tramitesxoficinas').val($(this).data('id'));
          modal.find('#ffecha').val($(this).data('fecha'));          
          modal.find('form').attr('action','{{route("tramites/oficinaupdate", app()->getLocale())}}');
        }
      });  


      //send unique code and validate
      $("#fcodigo").keyup(function(){
        $this=$(this);
        //console.log($this.val().length);
        if($this.val().length==4){
          $.ajax({
              url: "{{route('getcodetramite', app()->getLocale())}}"+"/"+$this.val(), 
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
      $("clicker").click(function (e) {
        $(this).parent().toggleClass("opened");
        if($(this).parent().hasClass("opened")){
          $(this).html("↑ Mostrar menos");
        }
        else{
          $(this).html("↓ Mostrar más");
        }
      });

    });
  </script>
@endsection
