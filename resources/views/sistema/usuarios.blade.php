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
  .table th, .table td{ line-height: 15px }
</style>
@endsection

@section('content')
  <!-- Main content -->
  <main class="main">

    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <!--<li class="breadcrumb-item"><a href="#">Admin</a></li>-->
      <li class="breadcrumb-item active">Usuarios</li>
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
                          data-action ="store"
                          data-id     = ""
                          data-title ="Nuevo usuario">Crear nuevo usuario <i class="icon-arrow-right"></i></a>
                      </div>
                      <div @if($data['rol'] == 'superadmin') class="col-lg-2 col-md-6" @else class="col-lg-1" @endif>
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
                      <div @if($data['rol'] == 'superadmin') class="col-lg-2 col-md-6 lc" @else class="col-lg-3 lc" @endif>
                        
                        <div style="margin-top: 2px">
                          <select  name="tipousuario" id="tipousuario">
                              <option value="">Todos los tipos de usuario</option>  
                              <option value="admin_oficina" @if($filterstipousuario=='admin_oficina') selected="" @endif>Administrador Oficina</option>
                              <option value="kiosko" @if($filterstipousuario=='kiosko') selected="" @endif>Kiosko</option>
                              <option value="tramitador" @if($filterstipousuario=='tramitador') selected="" @endif>Asesor</option>
                              @if($data['rol'] == 'superadmin')<option value="superadmin" @if($filterstipousuario=='superadmin') selected="" @endif>Webmaster</option>@endif  
                          </select>
                        </div>

                      </div>
                      <div class="col-lg-5">
                        <div class="input-group">
                          <input type="text" id="searchPars" name="searchPars" class="form-control" placeholder= "Buscar por nombre ó email" value = "{{$filterstexto}}">
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
                                    @if(count($oficina->usuarios)> 0 )
                                    <tr>                                            
                                      <th>Trámites</th>
                                      <th>Acciones</th>                                        
                                      <th>Estatus</th>
                                      <th>Tipo de usuario</th>
                                      <th>Nombre</th>
                                      <th>Disponible</th> 
                                      <th>Email</th>                                       
                                    </tr>
                                    @endif
                                  </thead>
                                  <tbody>
                                  @if(count($oficina->usuarios)> 0 )                                        
                                      @foreach($oficina->usuarios as $usuario)                                                 
                                        <tr>
                                            @if($usuario->tipo_user=="tramitador")
                                              <td class="text-center tramites" style="width: 130px">
                                                 <a href="#" class="btn btn-sm btn-secondary">
                                                  <i class="fa fa-chevron-down"></i> <k>Trámites <sup>{{$usuario['TOTALTRAMITES']}}</sup></k></a>
                                              </td> 
                                            @else
                                              <td style="width: 130px"></td>
                                            @endif 
                                            <td style="padding-right:0px">
                                              <div style="float:left; width:235px">
                                                <a href="#" class="btn btn-warning btn-sm float-left open-modal" 
                                                  data-toggle    = "modal" 
                                                  data-target    = "#myModal"
                                                  data-action    = "update"
                                                  data-id        = "{{$usuario['id_user']}}"
                                                  data-title     = "Editando: {{$usuario['nombre']}}"                                                     
                                                  data-tipouser  = "{{$usuario['tipo_user']}}" 
                                                  data-estatus   = "{{$usuario['estatus']}}"             
                                                  data-email     = "{{$usuario['email']}}"
                                                  data-nombre    = "{{$usuario['nombre']}}"  
                                                  data-oficina   = "{{$usuario['oficina_id']}}" 
                                                  data-disponible= "{{$usuario['disponibleturno']}}"
                                                  @if($usuario['id_user']==$data["user"]->id_user)
                                                  data-actualuser= "1"
                                                  @else
                                                  data-actualuser= "0"
                                                  @endif
                                                 >Editar</a>

                                                <a href="{{route('ausenciasusuarios', app()->getLocale())}}/{{$usuario['id_user']}}" class="btn btn-secondary btn-sm float-left" style="margin-left: 10px">Ausencias</a>  

                                                @if($usuario['id_user']!=$data["user"]->id_user)                                                    
                                                <form id="fr_user{{$usuario['id_user']}}" action="{{route('usuarios/destroy', app()->getLocale())}}" name="_method" method="post" style="float:left">
                                                  <a href="#" 
                                                  class="btn btn-danger btn-sm"
                                                  style="margin-left:10px; margin-top:0px; float:left" 
                                                  data-toggle           = "confirmation"
                                                  data-id               = "{{$usuario['id_user']}}"                                                  
                                                  data-btn-ok-label     = "Aceptar" 
                                                  data-btn-ok-icon      = "fa fa-remove"
                                                  data-btn-ok-class     = "btn btn-danger btn-sm"
                                                  data-btn-cancel-label = "Cancelar"
                                                  data-btn-cancel-icon  = "fa fa-chevron-circle-left"
                                                  data-btn-cancel-class = "btn btn-sm btn-warning"
                                                  data-title            = "Desea @if($usuario['estatus']=='activo') desactivar @else activar @endif el usuario?"
                                                  data-target           = "#removeUser"
                                                  data-placement        = "top" 
                                                  data-singleton        = "true"
                                                  data-type             = "user" 
                                                  >@if($usuario['estatus']=="activo") Desactivar @else Activar @endif</a>
                                                  @csrf
                                                  <input type="hidden" name="id_user" value="{{$usuario['id_user']}}"/>
                                                  <input type="hidden" name="estatus" value="{{$usuario['estatus']}}"/>
                                                </form>
                                                @endif
                                              </div>
                                            </td>
                                                                                           
                                            <td style="text-transform: capitalize">{{$usuario['estatus']}}</td>
                                            <td style="text-transform: capitalize">@if($usuario['tipo_user'] == 'tramitador') Asesor @endif @if($usuario['tipo_user']=='admin_oficina') Administrador Oficina @endif @if($usuario['tipo_user']=='kiosko') Kiosko @endif @if($usuario['tipo_user']=='superadmin') Webmaster @endif</td>
                                            <td style="text-transform: capitalize"><div style="float:left; width:140px"><a href="{{route('perfiltramitador', app()->getLocale())}}/{{$usuario['id_user']}}">{{$usuario['nombre']}}</a></div></td>
                                            <td style="text-transform: capitalize">{{$usuario['disponibleturno']}}</td>
                                            <td><a href="mailto:{{$usuario['EMAIL']}}" target="_blank"><div style="float:left; width:220px">{{$usuario['email']}}</div></a></td>
                                                                                            
                                        </tr>
                                        
                                        <tr class="hide">
                                          <td class="text-center">
                                            <a class="btn btn-sm btn-warning  open-modaltramite" href="#" data-toggle="modal" data-target="#myModalTramite"
                                            data-action ="store" data-idusuario="{{$usuario['id_user']}}" data-oficina="{{$usuario['oficina_id']}}" data-action ="store" data-title="Nuevo trámite de: {{$usuario['nombre']}}">Nuevo trámite</a>
                                          </td>
                                          <td colspan="6">
                                            @if(count($usuario['TRAMITES'])>0)                                                                                                                          
                                              <table class="table" style="background:#fff!important">
                                                  <thead>
                                                      <tr style="background:#fff!important" class="trfirst">
                                                          <th></th>
                                                          <th>Trámite</th>
                                                          <th colspan="2" class="text-center">Lunes</th>
                                                          <th colspan="2" class="text-center light">Martes</th>
                                                          <th colspan="2" class="text-center">Miércoles</th>
                                                          <th colspan="2" class="text-center light">Jueves</th>
                                                          <th colspan="2" class="text-center">Viernes</th>
                                                          <th colspan="2" class="text-center light">Sábado</th>
                                                          <th></th>                                                              
                                                      </tr>
                                                      <tr style="background:#fff!important">
                                                          <th class="text-center">Acciones</th>
                                                          <th class="searchtramitecontainer"><input type="text" class="form-control searchtramite" placeholder="Buscar trámite"><close><i class="fa fa-times"></i></close></th>
                                                          <th>Hora Inicio</th>
                                                          <th>Hora Fin</th>
                                                          <th>Hora Inicio</th>
                                                          <th>Hora Fin</th>
                                                          <th>Hora Inicio</th>
                                                          <th>Hora Fin</th>
                                                          <th>Hora Inicio</th>
                                                          <th>Hora Fin</th>
                                                          <th>Hora Inicio</th>
                                                          <th>Hora Fin</th>
                                                          <th>Hora Inicio</th>
                                                          <th>Hora Fin</th>
                                                          <th>Actualizado</th>                                                              
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                            @foreach($usuario['TRAMITES'] as $tramite) 
                                               <tr style="background:#fff!important">
                                                  <td>
                                                    <div style="float:left; width:135px">
                                                      <a href="#" class="btn btn-warning btn-sm float-left open-modaltramite" 
                                                        data-toggle           = "modal" 
                                                        data-target           = "#myModalTramite"
                                                        data-action           = "update"
                                                        data-id               = "{{$tramite->id_tramitesxusers}}"
                                                        data-idusuario        = "{{$usuario['id_user']}}"
                                                        data-title            = "Editar trámite de: {{$usuario['nombre']}}"                                                     
                                                        data-tramite          = "{{$tramite->tramite_id}}"
                                                        data-lunesinicio      = "{{$tramite->lunes_inicio}}"
                                                        data-lunesfin         = "{{$tramite->lunes_fin}}"
                                                        data-martesinicio     = "{{$tramite->martes_inicio}}"
                                                        data-martesfin        = "{{$tramite->martes_fin}}"
                                                        data-miercolesinicio  = "{{$tramite->miercoles_inicio}}"
                                                        data-miercolesfin     = "{{$tramite->miercoles_fin}}"
                                                        data-juevesinicio     = "{{$tramite->jueves_inicio}}"
                                                        data-juevesfin        = "{{$tramite->jueves_fin}}"
                                                        data-viernesinicio    = "{{$tramite->viernes_inicio}}"
                                                        data-viernesfin       = "{{$tramite->viernes_fin}}"
                                                        data-sabadoinicio     = "{{$tramite->sabado_inicio}}"
                                                        data-sabadofin        = "{{$tramite->sabado_fin}}"
                                                        data-oficina          = "{{$usuario['oficina_id']}}"
                                                      >Editar</a>
                                                                                                          
                                                      <form id="fr_tramitexuser{{$tramite->id_tramitesxusers}}" action="{{route('usuarios/destroytramitexuser', app()->getLocale())}}" name="_method" method="post" style="float:left">
                                                        <a href="#" 
                                                        class="btn btn-danger btn-sm"
                                                        style="margin-left:10px; margin-top:0px; float:left" 
                                                        data-toggle           = "confirmation"
                                                        data-id               = "{{$tramite->id_tramitesxusers}}"
                                                        data-btn-ok-label     = "Aceptar" 
                                                        data-btn-ok-icon      = "fa fa-remove"
                                                        data-btn-ok-class     = "btn btn-danger btn-sm"
                                                        data-btn-cancel-label = "Cancelar"
                                                        data-btn-cancel-icon  = "fa fa-chevron-circle-left"
                                                        data-btn-cancel-class = "btn btn-sm btn-warning"
                                                        data-title            = "Desea borrar el trámite para: {{$usuario['nombre']}}?"
                                                        data-target           = "#removeTramitexUser"
                                                        data-placement        = "top" 
                                                        data-singleton        = "true" 
                                                        data-type             = "tramitexuser" 
                                                        >Eliminar</a>
                                                        @csrf
                                                        <input type="hidden" name="id_tramitexuser" value="{{$tramite->id_tramitesxusers}}"/>
                                                      </form>
                                                    </div>
                                                  </td>
                                                  <td class="nombretramite">{{$tramite->nombre_tramite}}</td>
                                                  <td class="text-center">{{$tramite->lunes_inicio}}</td>
                                                  <td class="text-center">{{$tramite->lunes_fin}}</td>
                                                  <td class="text-center">{{$tramite->martes_inicio}}</td>
                                                  <td class="text-center">{{$tramite->martes_fin}}</td>
                                                  <td class="text-center">{{$tramite->miercoles_inicio}}</td>
                                                  <td class="text-center">{{$tramite->miercoles_fin}}</td>
                                                  <td class="text-center">{{$tramite->jueves_inicio}}</td>
                                                  <td class="text-center">{{$tramite->jueves_fin}}</td>
                                                  <td class="text-center">{{$tramite->viernes_inicio}}</td>
                                                  <td class="text-center">{{$tramite->viernes_fin}}</td>
                                                  <td class="text-center">{{$tramite->sabado_inicio}}</td>
                                                  <td class="text-center">{{$tramite->sabado_fin}}</td>
                                                  <td>{{$tramite->updated_at}}</td>                                                      
                                               </tr>
                                            @endforeach
                                                  </tbody>
                                              </table>                                                                                                                  
                                            @endif
                                            </td>
                                        </tr>                                                                                                                                    
                                      @endforeach                                                                                  
                                  @else
                                    <span>No tienes ningún usuario aún.</span>
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
                <label for="company">Tipo de usuario:</label>
                <select id="ftipousuario" name="tipousuario" required>
                  <option value="">Seleccione un tipo de usuario</option>  
                  <option value="admin_oficina">Administrador Oficina</option>
                  <option value="kiosko">Kiosko</option>
                  <option value="tramitador">Asesor</option>
                  @if($data['rol'] == 'superadmin')<option value="superadmin">Webmaster</option>@endif    
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="company">Nombre completo:</label>
              <input type="text" class="form-control" id="fnombre" name="nombre" placeholder="Ingresa nombre completo" required maxlength="100"/>
            </div>
            
            <div class="form-group">
              <label for="street">Email:</label>
              <input type="email" class="form-control" id="femail" name="email" placeholder="Ingresa email" />
            </div>
            
            <div class="form-group" id="passgroup">
              <label for="street">Password:</label>
              <input type="password" class="form-control" id="fpassword" name="password" placeholder="Ingresa password" maxlength="100" minlength=6/>
            </div>
            
            <div class="form-group" id="newpassgroup">
              <label for="street">Nuevo Password:</label>
              <input type="password" class="form-control" id="fnewpassword" name="newpassword" placeholder="Ingresa nuevo password" maxlength="100" minlength=6/>
            </div>

            <div class="row">
              <div class="form-group col-sm-12 plr0">
                <label for="company">Oficina:</label>
                <select id="foficina" name="oficina" required>
                  <option value="">Seleccione una oficina</option>  
                  @if(count($dependencias)> 0 )
                    @foreach($dependencias as $dependencia)                                          
                      @foreach($dependencia->oficinas as $oficina) 
                        <option value="{{$oficina->id_oficina}}">{{$oficina->nombre_oficina}}</option>
                      @endforeach
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
            <!--/.row-->
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
                <label for="company">Trámite:</label>
                <select id="ftramite" name="tramite" required>
                  <option value="">Seleccione un trámite</option> 

                  @if(count($dependencias)> 0 )
                    @foreach($dependencias as $dependencia)                                          
                      @foreach($dependencia->oficinas as $oficina) 
                          @foreach($oficina->tramites as $tramite) 
                            <option value="{{$tramite->id_tramite}}" data-oficina="{{$oficina->id_oficina}}">{{$tramite->nombre_tramite}}</option>
                          @endforeach
                      @endforeach
                    @endforeach
                  @endif
                                          
                </select>
              </div>
            </div>

            <div class="form-group col-sm-6">
              <label for="company">Lunes Inicio:</label>
              <input type="time" class="form-control" id="flunesinicio" name="lunes_inicio"  />
            </div>
            <div class="form-group col-sm-6">
              <label for="company">Lunes Fin:</label>
              <input type="time" class="form-control" id="flunesfin" name="lunes_fin" />
            </div>
            <div class="form-group col-sm-6">
              <label for="company">Martes Inicio:</label>
              <input type="time" class="form-control" id="fmartesinicio" name="martes_inicio"  />
            </div>
            <div class="form-group col-sm-6">
              <label for="company">Martes Fin:</label>
              <input type="time" class="form-control" id="fmartesfin" name="martes_fin"  />
            </div>
            <div class="form-group col-sm-6">
              <label for="company">Miércoles Inicio:</label>
              <input type="time" class="form-control" id="fmiercolesinicio" name="miercoles_inicio"   />
            </div>
            <div class="form-group col-sm-6">
              <label for="company">Miércoles Fin:</label>
              <input type="time" class="form-control" id="fmiercolesfin" name="miercoles_fin"  />
            </div>
            <div class="form-group col-sm-6">
              <label for="company">Jueves Inicio:</label>
              <input type="time" class="form-control" id="fjuevesinicio" name="jueves_inicio"   />
            </div>
            <div class="form-group col-sm-6">
              <label for="company">Jueves Fin:</label>
              <input type="time" class="form-control" id="fjuevesfin" name="jueves_fin"  />
            </div>
            <div class="form-group col-sm-6">
              <label for="company">Viernes Inicio:</label>
              <input type="time" class="form-control" id="fviernesinicio" name="viernes_inicio"   />
            </div>
            <div class="form-group col-sm-6">
              <label for="company">Viernes Fin:</label>
              <input type="time" class="form-control" id="fviernesfin" name="viernes_fin"  />
            </div>
            <div class="form-group col-sm-6">
              <label for="company">Sábado Inicio:</label>
              <input type="time" class="form-control" id="fsabadoinicio" name="sabado_inicio"   />
            </div>
            <div class="form-group col-sm-6">
              <label for="company">Sábado Fin:</label>
              <input type="time" class="form-control" id="fsabadofin" name="sabado_fin"  />
            </div>
            
            <!--/.row-->
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
          @if($data['rol'] == 'admin_oficina')
          modal.find('#foficina').select2('val',"{{$data['user']->oficina_id}}");
          $("#foficina").select2("readonly", true);
          @endif          
          modal.find('#ftipousuario').select2("readonly", false);
          modal.find('#femail').attr("readonly",false);
          modal.find('form').attr('action','{{route("usuarios/store", app()->getLocale())}}');
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
          @if($data['rol'] == 'admin_oficina')
          $("#foficina").select2("readonly", true);
          @endif   
          modal.find('form').attr('action','{{route("usuarios/update", app()->getLocale())}}');
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
          modal.find('form').attr('action','{{route("usuarios/storetramitexuser", app()->getLocale())}}');
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

          modal.find('form').attr('action','{{route("usuarios/updatetramitexuser", app()->getLocale())}}');
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
@endsection
