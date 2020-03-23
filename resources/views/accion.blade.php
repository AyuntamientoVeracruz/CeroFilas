@extends('layouts.applevantamiento')

@section('page-style-files')
    <!--main booking-->
    <link rel="stylesheet" href="{{url('/css/app.css')}}" type="text/css" media="all">
    <style type="text/css">
        body{ font-size: 13px }
        .headerwrapper .textcontainer{ text-align: center}
        .main-primary {
            box-shadow: 0 4px 4px #ccc;
            background: #fff;
        }
        .main-primary h3.header3 {
            margin-bottom: 20px;
            margin-left: -15px;
            margin-right: -15px;
            width: calc(100% + 30px);
            padding-top: 0px;
        }
        div.radio{ float: left; width: 100% }
        .stars{ float: left; width: 100%; height: auto; text-align: center; margin-bottom: 10px; position: relative}
            .stars.withopaque:before{ position: absolute; left: 0px; width: 100%; height: 100%; top:0px; z-index: 2; content:"";}
        .titlesection span{ text-transform: none }
        textarea{color:#333;}
            textarea::placeholder{color:#ccc}

        .starrr {
          display: inline-block; position: relative;}
          .starrr a {
            font-size: 25px;
            padding: 0 3px;
            cursor: pointer;
            color: #FFD119;
            text-decoration: none; position: relative; z-index: 1}   
            .your-choice-was{ margin-top: 10px; float: left; text-align: center; width: 100%; margin-bottom: 0px;display: none; } 
            #star2_input{ position: absolute; left: 0px; width: 100%; height: 1px; bottom:0px; opacity:0; z-index: 0}
        @media only screen and (max-width: 490px){
            .titlesection span{ font-size: 12px; line-height: 20px }
            .stars{ margin-bottom: 20px }
        }
        .mt-45{ margin-top: -45px; z-index: 2; height: auto; float: left; width: 100%; position: relative}
        .errored{ width: 100%; text-align: center; width: 100%; color:#cc0000; margin-bottom: 20px; margin-top: 20px; font-size: 13px}
        .descriptionsection {color:#222;}
        .descriptionsection2{margin-left: 40px; margin-top: -10px; float: left; margin-bottom: 10px; font-size:13px}
        .megaquote{ background: #eee; padding:15px; border-radius:4px; text-align: center}
        .etiqueta{ line-height: 20px }
        .radio{ margin-bottom: 20px }
        select.form-control{ height: 50px }
        .titlesection{ margin-top: 30px }
        .mb-30{ margin-bottom: 20px }
        .inputfield label{ font-weight: normal}
        #map_canvas {
            width: 100%;
            height: 300px; float:left; background: #ccc
        }
        #current {
            padding-top: 15px; width: 100%; float:left; color:#cc0000;
        }

        form .actived input.texto{color:#000;}
        .select2-container--default .select2-selection--single .select2-selection__arrow{ height: 46px }
        .select2-container--default .select2-selection--single .select2-selection__rendered{ line-height: 50px }    
        .select2-container .select2-selection--single{ height: 50px }   
        .select2-container--default .select2-results__option[aria-disabled=true] { display: none;}
        .fleft{ width:100%; float:left; }
        .dnone{ display: none }
        .arboles_grid,.areasdeportivas_grid{width: 100%; float: left}
            .arboles_grid .arbol,.areasdeportivas_grid .arbol{width: 100%; float: left; margin-top: 15px}
            .arbol{ position: relative; width: 100%; float: left}
                .removeitem{ position: absolute; left: -5px; top: 33px; color: #c00; font-size: 20px; z-index: 99}
                .removeitem i{float: left; width: 100%}
            label .tooltip{ position: static; opacity:1; float: right; margin-left: 10px}    
            label .tooltip i.fa{ width:18px; height: 18px; background: #eee; color:#aaa; border:1px solid #ccc; border-radius:15px; text-align: center; font-size: 9px; line-height: 15px }
        .claveescolar{ display: none }   
        .errorresponse{ font-size: 9.5px }
        body form .inputfield label,
        .select2-container--default .select2-selection--single .select2-selection__placeholder{color:#999!important;}
    </style>
@endsection

@section('initlink')
<h2>Acciones</h2>
<a href="https://www.veracruzmunicipio.gob.mx" class="small">Regresar a sitio del municipio</a>
@endsection

@section('titlebig')
@if($tipo=="show")
<h5>Editando</h5>
<h1>Acción {{$accion->id}}</h1>
@else
<h5>Captura de</h5>
<h1>Acción</h1>
@endif
@endsection

@section('content')
    <div class="loading-main">
        <div class="loader">Cargando...</div>
    </div>

    <div class="responsemessage"></div>

    <div class="requisitoscontainer-holder">
        <div class="requisitoscontainer">
        </div>
    </div>

    <div class="wrappercontainer">
        
        <div class="container">


            
            <form class="mt-45" id="accion-form" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                @csrf
                <div class="main-primary col-sm-8 col-md-8 col-xs-12 br-5 p15 mb-30 col-sm-offset-2">
                    <h3 class="header3">Bienvenido a la @if($tipo=="show") edición @else captura @endif de acción @if($tipo=="show") {{$accion->id}} @endif</h3>                    
                    
                    <p class="descriptionsection">Por favor llene todos los campos marcados <mark></mark> para poder brindar un mejor servicio.</p>
                     
                    @if($tipo=="show")
                    
                    <a href="{{route('listadoacciones')}}" class="btn btn-primary btn-block" style="float: left; width: 50%; margin-top: 0px;margin-right: 10px">← Listado de acciones</a>
                    <a href="{{route('crearaccion')}}" class="btn btn-warning btn-block" style="float: left; width: calc(50% - 10px); margin-top: 0px">+ Crear acción</a>
                    @else
                    <a href="{{route('listadoacciones')}}" class="btn btn-primary btn-block" style="float: left; width: 50%">← Listado de acciones</a>
                    @endif

                    <label class="titlesection"><b>1</b><span>Datos generales</span></label>                    
                    <div class="inputfield">                        
                        <textarea type="text" class="texto capitalize"  minlength="2" required name="nombre" rows="3" style="height: auto"></textarea>
                        <label>Nombre de la acción <mark></mark></label>
                    </div> 
                    <div class="inputfield">                        
                        <input type="text" class="texto"  minlength="2"  name="descripcion" required />
                        <label>Descripción de la acción <mark></mark></label>
                    </div> 
                    <div class="inputfield">                        
                        <textarea type="text" class="texto capitalize"  minlength="2" name="compromiso" rows="3" style="height: auto"></textarea>
                        <label>Compromiso</label>
                    </div>
                    <div class="col-sm-7 col-xs-12 pl0"> 
                        <label>Tipo de acción <mark></mark></label>
                        <select class="form-control mb-30 select2-single" required name="tipo">
                            <option value="">Seleccione un valor</option>
                            <option value="Atención">Atención</option>
                            <option value="Luminaria">Luminaria</option>
                            <option value="Prevención">Prevención</option>
                            <option value="Profesionalización">Profesionalización</option> 
                        </select>
                    </div> 
                    <div class="col-sm-5 col-xs-12 pr0"> 
                        <label>Etapa de la acción<mark></mark></label>
                        <select class="form-control mb-30 select2-single" required name="etapa">
                            <option value="">Seleccione un valor</option>
                            <option value="En proyecto">En proyecto</option>
                            <option value="En proceso">En proceso</option>
                            <option value="En ejecucion">En ejecucion</option>
                            <option value="Finalizada">Finalizada</option>       
                        </select>
                    </div>  
                    <div class="col-sm-4 col-xs-12 pl0">
                        <label>Año<mark></mark></label>
                        <select class="form-control mb-30 select2-single" required name="comuna">
                            <option value="">Seleccione un valor</option>
                            <option value="1">2018</option>
                            <option value="2">2019</option>
                            <option value="3">2020</option>
                            <option value="4">2021</option>       
                        </select>
                    </div>     
                    <div class="col-sm-8 col-xs-12 pr0">
                        <label>Area responsable<mark></mark></label>
                        <select class="form-control mb-30 select2-single" required name="area_responsable">
                            <option value="">Seleccione un valor</option>
                            <option value="DIF e IMMUVER">DIF e IMMUVER</option>
                            <option value="DIRECCIÓN DE SERVICIOS MUNICIPALES">DIRECCIÓN DE SERVICIOS MUNICIPALES</option>
                            <option value="IMMUVER">IMMUVER</option>
                            <option value="Obras Públicas y Desarrollo Urbano">Obras Públicas y Desarrollo Urbano</option>   
                            <option value="Proteccion Civil e IMMUVER">Proteccion Civil e IMMUVER</option>
                            <option value="U. C. Colón e IMMUVER">U. C. Colón e IMMUVER</option>
                            <option value="UV e IMMUVER">UV e IMMUVER</option>
                            <option value="Policía Municipal">Policía Municipal</option>
                        </select>
                    </div> 
                    <div class="col-sm-6 col-xs-12 pl0">
                        <div class="inputfield">
                            <input type="number" class="texto" name="porcentaje_avance" min="0" max="100">
                            <label>Porcentaje avance</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12 pr0">
                        <div class="inputfield">
                            <input type="number" class="texto" name="mano_obra" min="0" >
                            <label>Mano de obra (No. personas)</label>
                        </div>
                    </div>   
                    <div class="col-sm-6 col-xs-12 pl0">
                        <div class="inputfield">
                            <input type="number" class="texto"  name="plazo_meses" step="any" min="0">
                            <label>Plazo meses (No. meses)</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12 pr0">
                        <div class="inputfield">
                            <input type="number" class="texto"  name="benficiarios" min="0">
                            <label>Beneficiarios (No. personas)</label>
                        </div>
                    </div> 
                    <div class="col-sm-6 col-xs-12 pl0">
                        <div class="inputfield">                        
                            <input type="date" class="texto" name="fecha_inicio" />
                            <label>Fecha Inicio</label>
                        </div> 
                    </div>
                    <div class="col-sm-6 col-xs-12 pr0">
                        <div class="inputfield">
                            <input type="date" class="texto" name="fecha_fin_inicial">
                            <label>Fecha Fin</label>
                        </div>
                    </div>
                    


                    <label class="titlesection"><b>2</b><span>Datos financieros y contrato</span></label>                     
                    <div class="col-sm-6 col-xs-12 pl0">
                        <div class="inputfield">
                            <input type="number" class="texto" required name="monto_contrato" min="0" step="any">
                            <label>Monto contrato (pesos)<mark></mark></label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12 pr0">
                        <div class="inputfield">
                            <input type="text" class="texto" name="nro_contratacion" minlength="2">
                            <label>Número contrato</label>
                        </div>
                    </div>
                    <div class="col-sm-8 col-xs-12 pl0">
                        <label>Tipo de contratación</label>
                        <select class="form-control mb-30 select2-single" name="contratacion_tipo">
                            <option value="">Seleccione un valor</option>
                            <option value="Adjudicacion Directa">Adjudicación Directa</option>
                            <option value="Invitacion A Cuando Menos 3 Personas">Invitacion A Cuando Menos 3 Personas</option>
                            <option value="Licitacion Pública Estatal">Licitacion Pública Estatal</option>
                            <option value="Licitacion Pública Nacional">Licitacion Pública Nacional</option>  
                            <option value="Licitacion Pública General">Licitacion Pública General</option>  
                        </select>
                    </div>
                    <div class="col-sm-4 col-xs-12 pr0">
                        <label>Año licitación</label>
                        <select class="form-control mb-30 select2-single" name="licitacion_anio">
                            <option value="">Seleccione un valor</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="201">2021</option>       
                        </select>
                    </div> 
                    
                    <div class="inputfield">
                        <input type="text" class="texto"  name="financiamiento" minlength="2">
                        <label>Financiamiento</label>
                    </div>
                    

                                        

                    <label class="titlesection"><b>3</b><span>Dirección y datos de contacto</span></label>
                    <div style="float: left; width: 100%">                                                
                        <div class="inputfield">                        
                            <input type="text" class="texto" name="calle_1" minlength="2" />
                            <label>Calle</label>
                        </div> 
                    
                        <div class="inputfield">
                            <input type="text" class="texto" name="direccion" minlength="2">
                            <label>Dirección</label>
                        </div>                        
                    </div>
                    <div class="col-sm-12 col-xs-12" style="padding-left: 0px; padding-right: 0px">
                        <label>Colonia</label>
                        <select class="form-control mb-30 select2-single" name="barrio" >
                            <option value="">Seleccione un valor</option>
                            @if(count($colonias)> 0 )
                                @foreach($colonias as $colonia)            
                                <option value="{{$colonia->d_asenta}}">{{$colonia->d_asenta}}</option>
                                @endforeach
                            @endif    
                            <option value="Cardenista Antonio Luna">Cardenista Antonio Luna</option>
                            <option value="Bahía Libre Casas Fantasma">Bahía Libre Casas Fantasma</option>
                            <option value="Rosa Borunda">Rosa Borunda</option>
                            <option value="Salvador Díaz Mirón">Salvador Díaz Mirón</option>
                            <option value="Varias">Varias colonias</option>
                            <option value="Zona Norte">Zona Norte</option> 
                            <option value="Zona Oriente">Zona Oriente</option>       
                            <option value="Zona Poniente">Zona Poniente</option>       
                            <option value="Zona Sur">Zona Sur</option>      
                            <option value="Zona por definir">Zona por definir</option>        
                        </select> 
                    </div>
                    <div class="col-sm-12 col-xs-12 pl0" style="margin-bottom: 10px">
                        <label>Marcar croquis de ubicación <mark></mark></label>     
                        <div id='map_canvas' style="margin-bottom: 15px"></div>
                        <!--<div id="current">Sin elegir ubicación, arrastra el pin a la ubicación del predio...</div>-->
                        <div class="inputfield actived">     
                            <input type="text" class="texto" name="lat_lng" placeholder="Sin ubicación seleccionada, arrastra el pin dentro del mapa indicando la ubicación de la acción..."  required minlength="2" style="pointer-events: none;">
                            <label>Latitud y longitud de la acción <mark></mark></label>
                        </div>
                    </div>  



                    <label class="titlesection"><b>4</b><span>Fotos de acción</span></label>  

                    @if($tipo=="show") 
                        <div class="col-xs-12  pl0">
                            <div class="col-xs-2 pl0" style="margin-bottom: 20px">
                                @if($accion->imagen_1!="")<img src="{{$accion->imagen_1}}" style="width: 100%; border-radius:4px">@endif
                            </div>
                            <div class="col-xs-10 pr0" style="margin-bottom: 20px">  
                                <label>Foto principal (1) (JPG,JPEG,PNG,GIF - Máx: 10MB)</label>                    
                                <input type="file" name="imagen_1"/>                        
                            </div>
                        </div> 
                        <div class="col-xs-12  pl0">
                            <div class="col-xs-2 pl0" style="margin-bottom: 20px">
                                @if($accion->imagen_2!="")<img src="{{$accion->imagen_2}}" style="width: 100%; border-radius:4px">@endif
                            </div>
                            <div class="col-xs-10 pr0" style="margin-bottom: 20px">    
                                <label>Foto secundaria (2) (JPG,JPEG,PNG,GIF - Máx: 10MB)</label>                    
                                <input type="file" name="imagen_2" />                        
                            </div>
                        </div>   
                        <div class="col-xs-12  pl0">
                            <div class="col-xs-2 pl0" style="margin-bottom: 20px">
                                @if($accion->imagen_3!="")<img src="{{$accion->imagen_3}}" style="width: 100%; border-radius:4px">@endif
                            </div>
                            <div class="col-xs-10 pr0" style="margin-bottom: 20px">  
                                <label>Foto secundaria (3) (JPG,JPEG,PNG,GIF - Máx: 10MB)</label>                    
                                <input type="file" name="imagen_3" />                        
                            </div>
                        </div> 
                        <div class="col-xs-12  pl0">
                            <div class="col-xs-2 pl0" style="margin-bottom: 20px">
                                @if($accion->imagen_4!="")<img src="{{$accion->imagen_4}}" style="width: 100%; border-radius:4px">@endif
                            </div>
                            <div class="col-xs-10 pr0" style="margin-bottom: 20px">
                                <label>Foto secundaria (4) (JPG,JPEG,PNG,GIF - Máx: 10MB)</label>                    
                                <input type="file" name="imagen_4" />                        
                            </div>
                        </div>  
                    @else
                        <div class="col-sm-12 col-xs-12 pl0" style="margin-bottom: 20px">  
                            <label>Foto principal (1) (JPG,JPEG,PNG,GIF - Máx: 10MB)</label>                    
                            <input type="file" name="imagen_1"/>                        
                        </div> 
                        <div class="col-sm-12 col-xs-12 pl0" style="margin-bottom: 20px">  
                            <label>Foto secundaria (2) (JPG,JPEG,PNG,GIF - Máx: 10MB)</label>                    
                            <input type="file" name="imagen_2" />                        
                        </div>  
                        <div class="col-sm-12 col-xs-12 pl0" style="margin-bottom: 20px">  
                            <label>Foto secundaria (3) (JPG,JPEG,PNG,GIF - Máx: 10MB)</label>                    
                            <input type="file" name="imagen_3" />                        
                        </div>  
                        <div class="col-sm-12 col-xs-12 pl0" style="margin-bottom: 20px">  
                            <label>Foto secundaria (4) (JPG,JPEG,PNG,GIF - Máx: 10MB)</label>                    
                            <input type="file" name="imagen_4" />                        
                        </div>
                    @endif 
                    
                    @if($tipo=="tosave")
                        <input type="hidden" name="typepost" value="save" /> 
                    @else 
                        <input type="hidden" name="typepost" value="edit"/> 
                        <input type="hidden" name="id" value="{{$accion->id}}"/> 
                    @endif

                    <!--<span class="etiqueta"><b class="notavailable"></b> Los campos marcados son obligatorios.</span>-->
                    <input type="submit" class="btn btn-primary submit" value="Confirmar">
                </div>
            </form> 
            
                    
        </div>
    </div>
@endsection

@section('page-js-script')
    
  <!--maps-->
  <script src="https://maps.googleapis.com/maps/api/js?key={{$googlemapskey}}&callback=initMap"  defer></script>
      
  <script>
    
    $(document).ready(function(){
      
      $(".loading-main").fadeOut();

      @if($tipo=="show")
        $("[name='nombre']").val('{!!$accion->nombre!!}');
        $("[name='descripcion']").val('{!!$accion->descripcion!!}');
        $("[name='compromiso']").val('{!!$accion->compromiso!!}');
        $("[name='tipo']").val('{!!$accion->tipo!!}');
        $("[name='etapa']").val('{!!$accion->etapa!!}');
        $("[name='comuna']").val('{!!$accion->comuna!!}');
        $("[name='area_responsable']").val('{!!$accion->area_responsable!!}');        
        $("[name='porcentaje_avance']").val('{!!$accion->porcentaje_avance!!}');
        $("[name='mano_obra']").val('{!!$accion->mano_obra!!}');
        $("[name='plazo_meses']").val('{!!$accion->plazo_meses!!}');
        $("[name='benficiarios']").val('{!!$accion->benficiarios!!}');
        $("[name='fecha_inicio']").val('{!!$accion->fecha_inicio!!}');
        $("[name='fecha_fin_inicial']").val('{!!$accion->fecha_fin_inicial!!}');
        $("[name='monto_contrato']").val('{!!$accion->monto_contrato!!}');
        $("[name='nro_contratacion']").val('{!!$accion->nro_contratacion!!}');
        $("[name='contratacion_tipo']").val('{!!$accion->contratacion_tipo!!}');
        $("[name='licitacion_anio']").val('{!!$accion->licitacion_anio!!}');
        $("[name='financiamiento']").val('{!!$accion->financiamiento!!}');
        $("[name='calle_1']").val('{!!$accion->calle_1!!}');
        $("[name='direccion']").val('{!!$accion->direccion!!}');
        $("[name='barrio']").val('{!!$accion->barrio!!}');
        $("[name='lat_lng']").val('{!!$accion->lat!!},{!!$accion->lng!!}'); //setear en mapa tambien
        //foto1
        //foto2
        //foto3
        //foto4
      @endif

      $('.tooltip').tooltipster({theme: 'tooltipster-noir'});
      $("select").select2({placeholder: "Seleccione un valor"});

      //click on label over input field
      $("body").on('click','.inputfield label', function(event) {
        $(this).parent().find("input,textarea").focus();
      });      

      /*****ALERT***/       
      //click alert message to close
      $("body").on('click','.responsemessage', function(){
          $this=$(this);
          $this.slideUp().removeClass("showed");
      });

      
      $("#accion-form").on('submit', function(){
        var form = $('#accion-form')[0];
        var data = new FormData(form);
        $.ajax({
            enctype: 'multipart/form-data',
            processData: false,  
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('accionsave')}}", 
            type : "POST", 
            dataType : 'json', 
            contentType: false,
            cache: false,
            data : data,
            beforeSend: function(){ $(".loading-main").fadeIn(); },
            success : function(result) {                     
                $(".loading-main").fadeOut();
                if(result.error=="true"){
                    $(".responsemessage").addClass("errorresponse");
                }else{  
                    $(".responsemessage").removeClass("errorresponse");
                }
                $('#accion-form').trigger("reset");
                @if($tipo=="tosave")
                $(".responsemessage").addClass("showed").html(result.description).slideDown(); 
                @else 
                    $(".responsemessage").addClass("showed").html(result.description).slideDown(1000,function(){
                        if(result.error!="true"){
                            location.reload();
                        }
                    }); 
                @endif             
            },
            error: function(xhr, resp, text) {
                var error = xhr.responseJSON.message.slice(0, 75);
                var linea = xhr.responseJSON.line;

                $(".loading-main").fadeOut();
                $(".responsemessage").addClass("errorresponse");
                $(".responsemessage").addClass("showed").html("Ocurrió un error guardando la acción: "+error+". Línea: "+linea).slideDown();
            }
        });
        return false;
      });

      


    });

    function initMap() {    
        var map = new google.maps.Map(document.getElementById('map_canvas'), {
            zoom: 18,
            center: new google.maps.LatLng(@if($tipo=="show") {{$accion->lat}},{{$accion->lng}} @else 19.1952535, -96.1478962 @endif),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var myMarker = new google.maps.Marker({
            position: new google.maps.LatLng(@if($tipo=="show") {{$accion->lat}},{{$accion->lng}} @else 19.1952535, -96.1478962 @endif),
            draggable: true
        });
        google.maps.event.addListener(myMarker, 'dragend', function (evt) {
            //document.getElementById('current').innerHTML = '<p>Marcador movido: Lat: ' + evt.latLng.lat().toFixed(3) + ' Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
            $("input[name='lat_lng']").val(evt.latLng.lat()+","+evt.latLng.lng());
            map.setCenter(myMarker.position);
        });
        google.maps.event.addListener(myMarker, 'dragstart', function (evt) {
            //document.getElementById('current').innerHTML = '<p>Moviendo marcador...</p>';
        });
        map.setCenter(myMarker.position);
        myMarker.setMap(map);
    }

  </script>
@endsection

