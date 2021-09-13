@extends('layouts.headerauth')

@section('page-style-files')
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
@endsection

@section('content')
  <!-- Main content -->
  <main class="main">

    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <!--<li class="breadcrumb-item"><a href="#">Admin</a></li>-->
      <li class="breadcrumb-item active">Dependencias</li>
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
                      <div class="col-lg-4">
                          <a class="btn btn-warning btn-search open-modal" href="#" data-toggle="modal" data-target="#myModal"
                          data-action = "store"                          
                          data-title  = "Nueva dependencia">Crear nueva dependencia <i class="icon-arrow-right"></i></a>
                      </div>
                      <div class="col-lg-3 col-md-12">
                        
                        <div style="margin-top: 2px">
                          <select  name="dependencia" id="dependencia">
                              <option value="">Todas las dependencias</option>
                              @if(count($dependenciascombo)> 0 )
                                @foreach($dependenciascombo as $dependencia)                                                                            
                                  <option value="{{$dependencia->id_dependencia}}" @if($filtersdependencia==$dependencia->id_dependencia) selected="" @endif>{{$dependencia->nombre_dependencia}}</option>                                  
                                @endforeach
                              @endif  
                          </select>
                        </div>
                        
                      </div>
                      
                      <div class="col-lg-5">
                        <div class="input-group">
                          <input type="text" id="searchPars" name="searchPars" class="form-control" placeholder= "Buscar por nombre o dirección" value = "{{$filterstexto}}">
                          <span class="input-group-prepend">
                            <button type="submit" class="btn btn-secondary btn-search"><i class="fa fa-search"></i><span>Buscar</span></button>
                          </span>
                        </div>
                      </div>
                  </div>
              </form>                                                        
            </div>
          </div>
                      
          <div class="cardsoutside">

            @if(count($dependencias)> 0 )
              @foreach($dependencias as $dependencia)                                          
                  
                  <div class="card">
                       
                      <div class="card-header">
                        <h5 style="margin-bottom:0px">
                          <a href="#" class="btn btn-secondary btn-sm float-left open-modal br" style="margin-top: 1px; margin-right: 10px" 
                            data-toggle       = "modal" 
                            data-target       = "#myModal"
                            data-action       = "update"
                            data-id           = "{{$dependencia->id_dependencia}}"
                            data-title        = "Editando: {{$dependencia->nombre_dependencia}}"
                            data-nombre       = "{{$dependencia->nombre_dependencia}}" 
                          >Editar</a>
                          <form id="fr_dependencia{{$dependencia->id_dependencia}}" action="{{route('dependencias/destroy', app()->getLocale())}}" name="_method" 
                            method="post" style="float:left">
                            <a href="#" 
                            class="btn btn-danger btn-sm float-left br"
                            style="margin-right:10px; margin-top:1px; float:left" 
                            data-toggle           = "confirmation"
                            data-id               = "{{$dependencia->id_dependencia}}"                                                  
                            data-btn-ok-label     = "Aceptar" 
                            data-btn-ok-icon      = "fa fa-remove"
                            data-btn-ok-class     = "btn btn-danger btn-sm"
                            data-btn-cancel-label = "Cancelar"
                            data-btn-cancel-icon  = "fa fa-chevron-circle-left"
                            data-btn-cancel-class = "btn btn-sm btn-warning"
                            data-title            = "Desea eliminar la dependencia?"
                            data-target           = "#removeDependencia"
                            data-placement        = "left" 
                            data-singleton        = "true"
                            data-type             = "dependencia" 
                            >Eliminar</a>
                            @csrf
                            <input type="hidden" name="id_dependencia" value="{{$dependencia->id_dependencia}}"/>
                          </form>
                          <k style="float: left">{{$dependencia->nombre_dependencia}}</k></h5>
                      </div>

                      <div class="card-body">

                          <a class="btn btn-warning btn-search open-modalOficina br float-right" href="#" data-toggle="modal" data-target="#myModalOficina"
                          data-action = "store" style="margin-right: 15px; margin-bottom:15px"    
                          data-dependencia = "{{$dependencia->id_dependencia}}"                     
                          data-title  = "Nueva oficina">Crear nueva oficina <i class="icon-arrow-right"></i></a>

                          <div class="col-sm-12 table-responsive">

                            <table class="table  table-striped">
                                  <thead>
                                    @if(count($dependencia->oficinas)> 0 )
                                    <tr>                                                                                  
                                      <th>Acciones</th> 
                                      <th>Oficina</th>
                                      <th>Coordenadas</th> 
                                      <th>Dirección</th>                                          
                                    </tr>
                                    @endif
                                  </thead>
                                  <tbody>
                                  @if(count($dependencia->oficinas)> 0 )                                        
                                      @foreach($dependencia->oficinas as $oficina)                                                 
                                        <tr>                                            
                                            <td style="padding-right:0px">
                                              <div style="float:left; width:140px">
                                                                                                                                                    
                                                <a href="#" 
                                                  class="btn btn-secondary btn-sm open-modalOficina"
                                                  style="margin-left:10px; margin-top:0px; float:left" 
                                                  data-toggle           = "modal"
                                                  data-target           = "#myModalOficina"
                                                  data-action           = "update"
                                                  data-id               = "{{$oficina->id_oficina}}"  
                                                  data-title            = "Editando oficina: {{$oficina->nombre_oficina}}"
                                                  data-nombre           = "{{$oficina->nombre_oficina}}"                                                  
                                                  data-coords           = "{{$oficina->coords}}" 
                                                  data-direccion        = "{{$oficina->direccion}}" 
                                                  data-dependencia      = "{{$oficina->dependencia_id}}" 
                                                  >Editar</a>
                                                  
                                                  <form id="fr_oficina{{$oficina->id_oficina}}" action="{{route('oficinas/destroy', app()->getLocale())}}" name="_method" 
                                                    method="post" style="float:left">
                                                    <a href="#" 
                                                    class="btn btn-danger btn-sm"
                                                    style="margin-left:10px; margin-top:0px; float:left" 
                                                    data-toggle           = "confirmation"
                                                    data-id               = "{{$oficina->id_oficina}}"                                                  
                                                    data-btn-ok-label     = "Aceptar" 
                                                    data-btn-ok-icon      = "fa fa-remove"
                                                    data-btn-ok-class     = "btn btn-danger btn-sm"
                                                    data-btn-cancel-label = "Cancelar"
                                                    data-btn-cancel-icon  = "fa fa-chevron-circle-left"
                                                    data-btn-cancel-class = "btn btn-sm btn-warning"
                                                    data-title            = "Desea eliminar la oficina?"
                                                    data-target           = "#removeOficina"
                                                    data-placement        = "left" 
                                                    data-singleton        = "true"
                                                    data-type             = "oficina" 
                                                    >Eliminar</a>
                                                    @csrf
                                                    <input type="hidden" name="id_oficina" value="{{$oficina->id_oficina}}"/>
                                                  </form>      

                                              </div>
                                            </td>
                                                                                           
                                            <td ><div style="float:left; width:160px">{{$oficina->nombre_oficina}}</div></td> 
                                            <td ><div style="float:left; width:130px">{{$oficina->coords}}</div></td>
                                            <td ><div style="float:left; width:200px">{{$oficina->direccion}}</div></td>
                                                                                            
                                        </tr>
                                                                                                                                                                                                                    
                                      @endforeach                                                                                  
                                  @else
                                    <span>No tienes ninguna oficina aún.</span>
                                  @endif
                                  </tbody>
                            </table>

                          </div>

                      </div>
                      
                  </div>
                
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
            
            <input type="hidden" id="id_dependencia" name="id_dependencia"  />            

            <div class="form-group">
              <label for="company">Nombre dependencia:</label>
              <input type="text" class="form-control" id="fnombre" name="nombre" placeholder="Ingresa nombre de la dependencia" required maxlength="100"/>
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
              <label for="company">Nombre oficina:</label>
              <input type="text" class="form-control" id="fnombre" name="nombre" placeholder="Ingresa nombre de la oficina" required maxlength="100"/>
            </div>   

            <div class="form-group">
              <label for="company">Coordenadas:</label>
              <input type="text" class="form-control" id="fcoords" name="coords" placeholder="0,0" required maxlength="100"/>
            </div> 

            <div class="form-group">
              <label for="company">Dirección:</label>
              <textarea class="form-control" id="fdireccion" name="direccion" placeholder="Ingresa dirección de la oficina" required maxlength="100" rows="2" ></textarea>
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
          modal.find('form').attr('action','{{route("dependencias/store", app()->getLocale())}}');
        }
        else if ($(this).data('action') == "update"){                   
          modal.find('#id_dependencia').val($(this).data('id'));
          modal.find('#fnombre').val($(this).data('nombre'));                  
          modal.find('form').attr('action','{{route("dependencias/update", app()->getLocale())}}');
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
          modal.find('form').attr('action','{{route("oficinas/store", app()->getLocale())}}');          
        }
        else if ($(this).data('action') == "update"){  
          modal.find('#id_dependencia').val($(this).data('dependencia'));   
          modal.find('#id_oficina').val($(this).data('id'));    
          modal.find('#fnombre').val($(this).data('nombre'));
          modal.find('#fcoords').val($(this).data('coords'));
          modal.find('#fdireccion').val($(this).data('direccion'));    
          modal.find('form').attr('action','{{route("oficinas/update", app()->getLocale())}}');
        }
      });         

    });
  </script>
@endsection
