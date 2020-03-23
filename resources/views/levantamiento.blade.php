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
    </style>
@endsection

@section('initlink')
<h2>Levantamiento</h2>
<a href="https://www.veracruzmunicipio.gob.mx" class="small">Regresar a sitio del municipio</a>
@endsection

@section('titlebig')
<h5>Formulario de</h5>
<h1>Levantamiento</h1>
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

            @if($tipo=='tosave')
            <form class="mt-45" id="levantamiento-form" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                @csrf
                <div class="main-primary col-sm-8 col-md-8 col-xs-12 br-5 p15 mb-30 col-sm-offset-2">
                    <h3 class="header3">Bienvenido a la captura de levantamiento!</h3>                    
                    @if(isset($error))
                    <span class="errored">{{$error}}</span>
                    @endif
                    <p class="descriptionsection">Por favor llene todos los campos marcados <mark></mark> para poder brindar un mejor servicio.</p>
                    


                    <label class="titlesection"><b>1</b><span>Datos generales</span></label>                    
                    <div class="inputfield">                        
                        <input type="text" class="texto"  minlength="2" required name="direccion_elabora" />
                        <label>Dirección o área que elabora <mark></mark></label>
                    </div>  
                    <div class="inputfield">                        
                        <input type="text" class="texto capitalize"  minlength="2" required name="nombre_registra" />
                        <label>Nombre quien registra <mark></mark></label>
                    </div> 
                    <div class="col-sm-6 col-xs-12 pl0">
                        <div class="inputfield">
                            <input type="text" class="texto" minlength="2" required name="cargo">
                            <label>Cargo <mark></mark></label>
                        </div>
                    </div> 
                    <div class="col-sm-6 col-xs-12 pr0">
                        <div class="inputfield">
                            <input type="number" class="texto" minlength="10" maxlength="10" placeholder="Número a 10 dígitos" required name="telefono">
                            <label>Teléfono <mark></mark></label>
                        </div>
                    </div> 



                    <label class="titlesection"><b>2</b><span>Datos de equipamiento</span></label>  
                    <div class="inputfield">                        
                        <input type="text" class="texto"  minlength="2"  name="clave_catastral" />
                        <label>Clave catastral </label>
                    </div>  
                    <div class="col-sm-6 col-xs-12 pl0">
                        <label>Subsistema <span class="tooltip" title="Subsistema al que pertenece equipamiento"><i class="fa fa-question"></i></span><mark></mark></label>
                        <select class="form-control mb-30 select2-single" required name="subsistema">
                            <option value="">Seleccione un valor</option>
                            @if(count($subsistemas)> 0 )
                                @foreach($subsistemas as $subsistema)            
                                <option value="{{$subsistema->subsistema}}">{{$subsistema->subsistema}}</option>                                  
                                @endforeach
                            @endif                
                        </select>                            
                    </div> 
                    <div class="col-sm-6 col-xs-12 pr0">
                        <label>Elemento <span class="tooltip" title="Clasificación que le corresponde al equipamiento"><i class="fa fa-question"></i></span><mark></mark></label>
                        <select class="form-control mb-30 select2-single" required name="elemento" disabled="">
                            <option value="">Seleccione un valor</option>    
                            @if(count($elementos)> 0 )
                                @foreach($elementos as $elemento)            
                                <option value="{{$elemento->elemento}}" 
                                    data-subsistema="{{$elemento->subsistema}}" 
                                    data-ubs="{{$elemento->ubs}}"
                                    data-capacidad-ubs="{{$elemento->capacidad_diseno_ubs}}"
                                    data-radio="{{$elemento->radio_cobertura}}"
                                >{{$elemento->elemento}}</option>
                                @endforeach
                            @endif                                      
                        </select>
                    </div> 
                    <div class="inputfield">                        
                        <input type="text" class="texto"  minlength="2" required name="nombre_equipamiento" />
                        <label>Nombre <span class="tooltip" title="Corresponde al nombre con el que es conocido la institución, parque, escuela, mercado o cualquier elemento del que se trate"><i class="fa fa-question"></i></span><mark></mark></label>
                    </div>

                    <div class="inputfield claveescolar">                        
                        <input type="text" class="texto"  minlength="2" name="clave_escolar" />
                        <label>Clave Escolar </label>
                    </div>

                    <div class="col-sm-6 col-xs-12 pl0">
                        <label>Inicio de actividades <mark></mark></label>
                        <select class="form-control mb-30 select2-single" required name="inicio_actividades">
                            <option value="">Seleccione un valor</option>
                            <option value="00:00:00">12:00 a.m.</option>
                            <option value="01:00:00">01:00 a.m.</option>
                            <option value="02:00:00">02:00 a.m.</option>
                            <option value="03:00:00">03:00 a.m.</option> 
                            <option value="04:00:00">04:00 a.m.</option>
                            <option value="05:00:00">05:00 a.m.</option>   
                            <option value="06:00:00">06:00 a.m.</option> 
                            <option value="07:00:00">07:00 a.m.</option>
                            <option value="08:00:00">08:00 a.m.</option>
                            <option value="09:00:00">09:00 a.m.</option>
                            <option value="10:00:00">10:00 a.m.</option>
                            <option value="11:00:00">11:00 a.m.</option>
                            <option value="12:00:00">12:00 p.m.</option>
                            <option value="13:00:00">01:00 p.m.</option>
                            <option value="14:00:00">02:00 p.m.</option>
                            <option value="15:00:00">03:00 p.m.</option>
                            <option value="16:00:00">04:00 p.m.</option>
                            <option value="17:00:00">05:00 p.m.</option>
                            <option value="18:00:00">06:00 p.m.</option>
                            <option value="19:00:00">07:00 p.m.</option>
                            <option value="20:00:00">08:00 p.m.</option>
                            <option value="21:00:00">09:00 p.m.</option>
                            <option value="22:00:00">10:00 p.m.</option> 
                            <option value="23:00:00">11:00 p.m.</option> 
                            <option value="24:00:00">12:00 a.m.</option>           
                        </select>                            
                    </div> 
                    <div class="col-sm-6 col-xs-12 pr0">
                        <label>Término de actividades <mark></mark></label>
                        <select class="form-control mb-30 select2-single" required name="termino_actividades">
                            <option value="">Seleccione un valor</option>   
                            <option value="00:00:00">12:00 a.m.</option>
                            <option value="01:00:00">01:00 a.m.</option>
                            <option value="02:00:00">02:00 a.m.</option>
                            <option value="03:00:00">03:00 a.m.</option> 
                            <option value="04:00:00">04:00 a.m.</option>
                            <option value="05:00:00">05:00 a.m.</option>   
                            <option value="06:00:00">06:00 a.m.</option> 
                            <option value="07:00:00">07:00 a.m.</option>
                            <option value="08:00:00">08:00 a.m.</option>
                            <option value="09:00:00">09:00 a.m.</option>
                            <option value="10:00:00">10:00 a.m.</option>
                            <option value="11:00:00">11:00 a.m.</option>
                            <option value="12:00:00">12:00 p.m.</option>
                            <option value="13:00:00">01:00 p.m.</option>
                            <option value="14:00:00">02:00 p.m.</option>
                            <option value="15:00:00">03:00 p.m.</option>
                            <option value="16:00:00">04:00 p.m.</option>
                            <option value="17:00:00">05:00 p.m.</option>
                            <option value="18:00:00">06:00 p.m.</option>
                            <option value="19:00:00">07:00 p.m.</option>
                            <option value="20:00:00">08:00 p.m.</option>
                            <option value="21:00:00">09:00 p.m.</option>
                            <option value="22:00:00">10:00 p.m.</option> 
                            <option value="23:00:00">11:00 p.m.</option>   
                            <option value="24:00:00">12:00 a.m.</option>          
                        </select>
                    </div>  
                    <div class="col-sm-12 col-xs-12 pl0" style="margin-bottom: 20px">  
                        <label>Foto de fachada principal (JPG,JPEG,PNG,GIF - Máx: 10MB)<mark></mark></label>                    
                        <input type="file" required name="foto_fachada" />                        
                    </div>                
                    <div class="col-sm-12 col-xs-12 pl0" style="margin-bottom: 10px">
                        <label>Marcar croquis de ubicación <mark></mark></label>     
                        <div id='map_canvas' style="margin-bottom: 15px"></div>
                        <!--<div id="current">Sin elegir ubicación, arrastra el pin a la ubicación del predio...</div>-->
                        <div class="inputfield actived">     
                            <input type="text" class="texto" name="ubicacion_croquis_lat_lon" readonly="" placeholder="Sin elegir ubicación, arrastra el pin dentro del mapa indicando la ubicación del predio..."  required minlength="2">
                            <label>Latitud y longitud del predio <mark></mark></label>
                        </div>
                    </div>   
                    <div class="inputfield">                        
                        <input type="text" class="texto"  minlength="2" required name="entidad_federal_opera" />
                        <label>Entidad federal, estatal o dirección municipal que opera o administra el uso de esta instalación <mark></mark></label>
                    </div>  
                    <div class="inputfield">                        
                        <input type="text" class="texto"  minlength="2" required name="entidad_federal_mantenimiento" />
                        <label>Entidad federal, estatal o dirección municipal que se encarga de su mantenimiento <mark></mark></label>
                    </div>       


                    <label class="titlesection"><b>3</b><span>Dirección y datos de contacto</span></label>                                        
                    <div style="float: left; width: 100%">
                        <div class="col-sm-2 col-xs-12 pl0">
                            <!--<label>Tipo <mark></mark></label>-->
                            <select class="form-control mb-30 select2-single" required name="tipo_vialidad">
                                <!--<option value="">Seleccione un valor</option>-->   
                                <option value="Av">Av.</option> 
                                <option value="Calle">Calle</option>
                                <option value="Andador">Andador</option>
                                <option value="Blvd">Blvd.</option> 
                                <option value="Circuito">Circuito</option>           
                            </select>
                        </div>
                        <div class="col-sm-7 col-xs-12 pr0">
                            <div class="inputfield">                        
                                <input type="text" class="texto"  required name="nombre_vialidad" />
                                <label>Nombre vialidad <mark></mark></label>
                            </div> 
                        </div>
                        <div class="col-sm-3 col-xs-12 pr0">
                            <div class="inputfield">
                                <input type="text" class="texto" required name="numero_oficial">
                                <label>No. Oficial <mark></mark></label>
                            </div>
                        </div> 
                    </div>
                    <div class="col-sm-6 col-xs-12 pl0">
                        <div class="inputfield">                        
                            <input type="text" class="texto"  required name="entre_calle1" />
                            <label>Entre calle <mark></mark></label>
                        </div> 
                    </div>
                    <div class="col-sm-6 col-xs-12 pr0">
                        <div class="inputfield">
                            <input type="text" class="texto" required name="entre_calle2">
                            <label>Y calle <mark></mark></label>
                        </div>
                    </div>                    
                    <div class="col-sm-3 col-xs-12 pl0">
                        <label>Código Postal <mark></mark></label>
                        <select class="form-control mb-30 select2-single" required name="cp">
                            <option value="">Seleccione un valor</option>
                            @if(count($codigospostales)> 0 )
                                @foreach($codigospostales as $codigospostal)            
                                <option value="{{$codigospostal->d_codigo}}">{{$codigospostal->d_codigo}}</option>                                  
                                @endforeach
                            @endif                
                        </select> 
                    </div>
                    <div class="col-sm-9 col-xs-12 pr0">
                        <label>Colonia <mark></mark></label>
                        <select class="form-control mb-30 select2-single" required name="colonia" disabled="">
                            <option value="">Seleccione un valor</option>
                            @if(count($colonias)> 0 )
                                @foreach($colonias as $colonia)            
                                <option value="{{$colonia->id_codigopostal}}" data-cp="{{$colonia->d_codigo}}">{{$colonia->d_asenta}}</option>
                                @endforeach
                            @endif                
                        </select> 
                    </div>
                    <div class="col-sm-6 col-xs-12 pl0">
                        <div class="inputfield">                        
                            <input type="number" class="texto"  required name="telefono_contacto" />
                            <label>Teléfono <mark></mark></label>
                        </div> 
                    </div>
                    <div class="col-sm-6 col-xs-12 pr0">
                        <div class="inputfield">
                            <input type="number" class="texto" required name="celular_contacto">
                            <label>Celular <mark></mark></label>
                        </div>
                    </div>
                    <div class="inputfield">
                        <input type="email" class="texto" required name="email_contacto">
                        <label>Email (a este mail se enviará confirmación)<mark></mark></label>
                    </div>

                    <label class="titlesection"><b>4</b><span>Unidades Básicas de Servicio</span></label>                                        
                    <div class="col-sm-6 col-xs-12 pl0">
                            <div class="inputfield actived">                        
                            <input type="text" class="texto" required name="ubs" readonly="" />
                            <label>Unidad Básica de Servicio - UBS <span class="tooltip" title="Información que se llena al indicar subsistema y elemento"><i class="fa fa-question"></i></span><mark></mark></label>
                        </div>  
                    </div>
                    <div class="col-sm-6 col-xs-12 pr0">
                        <div class="inputfield">                        
                            <input type="number" class="texto"  required name="num_ubs" />
                            <label>No. de UBS con que cuenta la instalación <mark></mark></label>
                        </div> 
                    </div>
                    <div class="col-sm-6 col-xs-12 pl0">
                        <div class="inputfield">
                            <input type="number" class="texto" required name="num_usuarios">
                            <label>No. de usuarios totales por día <mark></mark></label>
                        </div>
                    </div> 
                    <div class="col-sm-6 col-xs-12 pr0">
                        <div class="inputfield actived">
                            <input type="number" class="texto" required name="num_usuarios_ubs" readonly="">
                            <label>No. de Usuarios por UBS - capacidad instalada <span class="tooltip" title="Información que se calcula al indicar No. UBS y usuarios"><i class="fa fa-question"></i></span><mark></mark></label>
                        </div>
                    </div> 
                    <div style="display: none">
                        <div class="col-sm-6 col-xs-12 pl0">
                            <div class="inputfield actived">
                                <input type="hidden" class="texto" name="radio_cobertura" readonly="">
                                <label>Radio de cobertura <mark></mark></label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12 pr0">
                            <div class="inputfield actived">
                                <input type="hidden" class="texto" name="capacidad_ubs" disabled="">
                                <label>Capacidad UBS esperada </label>
                            </div>
                        </div> 
                    </div>
                    


                    <label class="titlesection"><b>5</b><span><mark></mark> Conectividad y accesibilidad</span></label> 
                    <div class="radio text-left">
                      <label><input type="radio" name="conectividad_accesibilidad" required value="vialidad_principal">El inmueble se ubica en una vialidad principal</label><br>
                      <label><input type="radio" name="conectividad_accesibilidad" required value="50_200_vialidad_principal">El inmueble se ubica de 50 a 200m de una vialidad principal</label><br>
                      <label><input type="radio" name="conectividad_accesibilidad" required value="201_500_vialidad_principal">El inmueble se ubica de 201 a 500m de una vialidad principal</label>
                    </div>



                    <label class="titlesection"><b>6</b><span><mark></mark> Recubrimiento de vialidad en la que se ubica la fachada o acceso al inmueble</span></label> 
                    <div class="radio text-left">
                        <label><input type="radio" name="recubrimiento_vialidad" required value="concreto">Concreto</label><br>
                        <label><input type="radio" name="recubrimiento_vialidad" required value="asfalto">Asfalto</label><br>
                        <label><input type="radio" name="recubrimiento_vialidad" required value="adoquin">Adoquín</label><br>
                        <label><input type="radio" name="recubrimiento_vialidad" required value="empedraro">Empedrado (piedra bola, chinos u otros)</label><br>
                        <label><input type="radio" name="recubrimiento_vialidad" required value="terraplen">Terracería con escoria o material granular</label><br>
                        <label><input type="radio" name="recubrimiento_vialidad" required value="tierra">Tierra natural</label>
                    </div>
                    <label style="float:left;">Estado de conservación de vialidad <mark></mark></label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="estado_vialidad" required value="Bueno">Bueno</label>
                        <label style="margin-right: 10px"><input type="radio" name="estado_vialidad" required value="Regular" >Regular</label>
                        <label><input type="radio" name="estado_vialidad" required value="Malo">Malo</label>
                    </div>



                    <label class="titlesection"><b>7</b><span>Acceso al transporte público</span></label> 
                    <label style="float: left;">La parada de autobús más cercana al inmueble se ubica en: <mark></mark></label>
                    <div class="radio text-left">
                        <label><input type="radio" name="acceso_transporte" required value="misma_cuadra">En la misma cuadra en la que está la fachada del inmueble</label><br>
                        <label><input type="radio" name="acceso_transporte" required value="50_200">Entre 50 y 200m de distancia de donde se ubica el inmueble </label><br>
                        <label><input type="radio" name="acceso_transporte" required value="201_500">Entre 200 y 500m de distancia de donde se ubica el inmueble</label>
                    </div>
                    <div class="col-sm-7 col-xs-12 pl0">
                        <label>Ruta de transporte a la que se refiere: <mark></mark></label>
                        <div class="inputfield">                        
                            <input type="text" class="texto"  minlength="2" required name="nombre_ruta1" />
                            <label>Nombre <mark></mark></label>
                        </div>
                    </div>  
                    <div class="col-sm-5 col-xs-12 pr0">
                        <label>Tiempo prom. de espera: <mark></mark></label>
                        <select class="form-control mb-30 select2-single" required name="tiempo_ruta1">
                            <option value="">Seleccione un valor</option>   
                            <option value="5">5 min.</option> 
                            <option value="10">10 min</option>
                            <option value="15">15 min</option>
                            <option value="20">20 min</option>
                            <option value="25">25 min</option>
                            <option value="30">30 min</option>
                            <option value="-1">más de 30 min</option>
                        </select>
                    </div>
                    <div class="col-sm-7 col-xs-12 pl0">
                        <label>Otra ruta a menos de 500m de distancia: </label>
                        <div class="inputfield">                        
                            <input type="text" class="texto"  minlength="2" name="nombre_ruta2" />
                            <label>Nombre </label>
                        </div>
                    </div>  
                    <div class="col-sm-5 col-xs-12 pr0">
                        <label>Tiempo prom. de espera: </label>
                        <select class="form-control mb-30 select2-single" name="tiempo_ruta2">
                            <option value="">Seleccione un valor</option>   
                            <option value="5">5 min.</option> 
                            <option value="10">10 min</option>
                            <option value="15">15 min</option>
                            <option value="20">20 min</option>
                            <option value="25">25 min</option>
                            <option value="30">30 min</option>
                            <option value="-1">más de 30 min</option>
                        </select>
                    </div>
                    <div class="col-sm-7 col-xs-12 pl0">
                        <label>Otra ruta a menos de 500m de distancia: </label>
                        <div class="inputfield">                        
                            <input type="text" class="texto" minlength="2" name="nombre_ruta3" />
                            <label>Nombre </label>
                        </div>
                    </div>  
                    <div class="col-sm-5 col-xs-12 pr0">
                        <label>Tiempo prom. de espera: </label>
                        <select class="form-control mb-30 select2-single" name="tiempo_ruta3">
                            <option value="">Seleccione un valor</option>   
                            <option value="5">5 min.</option> 
                            <option value="10">10 min</option>
                            <option value="15">15 min</option>
                            <option value="20">20 min</option>
                            <option value="25">25 min</option>
                            <option value="30">30 min</option>
                            <option value="-1">más de 30 min</option>
                        </select>
                    </div> 
                    <label style="float: left">¿Es fácil tomar un taxi desde el inmueble? <mark></mark></label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="facil_taxi" required value="si">Sí</label>
                        <label ><input type="radio" name="facil_taxi" required value="no">No</label>
                    </div> 
                    <label style="float: left">Tiempo promedio de espera para tomar un taxi <mark></mark></label>
                    <select class="form-control mb-30 select2-single" name="tiempo_taxi" required>
                        <option value="">Seleccione un valor</option>   
                        <option value="5">5 min.</option> 
                        <option value="10">10 min</option>
                        <option value="15">15 min</option>
                        <option value="20">20 min</option>
                        <option value="25">25 min</option>
                        <option value="30">30 min</option>
                        <option value="-1">más de 30 min</option>
                    </select>  



                    <label class="titlesection"><b>8</b><span>Infraestructura y servicios</span></label> 

                    <div class="fleft">    
                        <label>¿El inmueble cuenta con agua potable (Servicio de agua potable entubada proveniente de la red)? <mark></mark></label>
                        <div class="radio text-center">
                            <label style="margin-right: 10px"><input type="radio" name="servicio_agua_potable" required value="si">Si</label>
                            <label style="margin-right: 10px"><input type="radio" name="servicio_agua_potable" required value="no">No</label>
                            <label><input type="radio" name="servicio_agua_potable" required value="no_necesario">No necesario <span class="tooltip" title="Se marca esta casilla cuando para su buen funcionamiento, el equipamiento no requiere que exista este servicio en el predio, por lo tanto, no cuenta con él, al margen de que sí haya disponibilidad en la zona"><i class="fa fa-question"></i></span></label>
                        </div>
                    </div>    

                        <div class="fleft dnone" data-agua-level1="si">    
                            <label>¿El servicio es continuo? <mark></mark></label>
                            <div class="radio text-center">
                                <label style="margin-right: 10px"><input type="radio" name="servicio_continuo_agua"  value="si">Si</label>
                                <label style="margin-right: 10px"><input type="radio" name="servicio_continuo_agua"  value="no">No</label>
                            </div>

                            <div class="fleft dnone" data-agua-level2="si">
                                <label>Calidad en el servicio de agua potable<mark></mark></label>
                                <div class="radio text-center">
                                    <label style="margin-right: 10px"><input type="radio" name="calida_servicio_agua"  value="Bueno">Bueno</label>
                                    <label style="margin-right: 10px"><input type="radio" name="calida_servicio_agua"  value="Regular">Regular</label>
                                    <label><input type="radio" name="calida_servicio_agua" value="Malo">Malo</label>
                                </div>
                            </div>

                            <div class="fleft dnone" data-agua-level2="no">
                                <label>¿Por qué no? <mark></mark></label>
                                <div class="inputfield">                        
                                    <input type="text" class="texto" minlength="2" name="servico_continuo_agua_no" />
                                    <label>Escriba la razón por que no es continua el agua <mark></mark></label>
                                </div>
                            </div>                                 

                            <div class="inputfield">                        
                                <input type="number" class="texto" name="consumo_promedio_mensual_agua" />
                                <label>Consumo promedio mensual en m3 <mark></mark></label>
                            </div>

                        </div>
                             
                        <div class="fleft dnone" data-agua-level1="no">    
                            <label>Forma de abastecimiento en caso de que el servicio sea necesario <mark></mark></label>
                            <select class="form-control mb-30 select2-single" name="forma_abastesimiento_agua" >
                                <option value="">Seleccione un valor</option>   
                                <option value="pozo_predio">Pozo en predio</option> 
                                <option value="pipa">Pipa</option>
                                <option value="otros">Otros</option>
                            </select> 
                            <div class="inputfield">                        
                                <input type="number" class="texto" name="consumo_promedio_mensual_agua" />
                                <label>Consumo promedio mensual en m3 <mark></mark></label>
                            </div> 
                        </div>   


                    <div class="fleft">    
                        <label>¿El inmueble cuenta con drenaje sanitario (Conexión a red de drenaje municipal)? <mark></mark></label>
                        <div class="radio text-center">
                            <label style="margin-right: 10px"><input type="radio" name="drenaje_sanitario" required value="si">Si</label>
                            <label style="margin-right: 10px"><input type="radio" name="drenaje_sanitario" required value="no">No</label>
                            <label><input type="radio" name="drenaje_sanitario" required value="no_necesario">No necesario</label>
                        </div>
                    </div>   

                        <div class="fleft dnone" data-drenaje-level1="si">    
                            <label>Calidad en el servicio de drenaje sanitario<mark></mark></label>
                            <div class="radio text-center">
                                <label style="margin-right: 10px"><input type="radio" name="calidad_servicio_drenaje"  value="Bueno">Bueno</label>
                                <label style="margin-right: 10px"><input type="radio" name="calidad_servicio_drenaje"  value="Regular">Regular</label>
                                <label style="margin-right: 10px"><input type="radio" name="calidad_servicio_drenaje"  value="Malo">Malo</label>
                            </div>
                        </div>

                        <div class="fleft dnone" data-drenaje-level1="no">    
                            <label>Especifique sistema de drenaje con que cuenta el predio <mark></mark></label>
                            <select class="form-control mb-30 select2-single" name="especifique_sistema_drenaje" >
                                <option value="">Seleccione un valor</option>   
                                <option value="fosa_septica">Fosa séptica</option> 
                                <option value="biodigestor">Biodigestor</option>
                                <option value="otros">Otros</option>
                            </select> 
                        </div>

                    
                    <div class="fleft">    
                        <label>¿El inmueble cuenta con energía eléctrica? <mark></mark></label>
                        <div class="radio text-center">
                            <label style="margin-right: 10px"><input type="radio" name="energia_electica" required value="si">Si</label>
                            <label style="margin-right: 10px"><input type="radio" name="energia_electica" required value="no">No</label>
                            <label><input type="radio" name="energia_electica" required value="no_necesario">No necesario</label>
                        </div>
                    </div>   

                        <div class="fleft dnone" data-energia-level1="si">    
                            <label>Calidad en el servicio de energía eléctrica<mark></mark></label>
                            <div class="radio text-center">
                                <label style="margin-right: 10px"><input type="radio" name="calidad_iluminacion" value="bueno">Bueno</label>
                                <label style="margin-right: 10px"><input type="radio" name="calidad_iluminacion" value="regular">Regular</label>
                                <label style="margin-right: 10px"><input type="radio" name="calidad_iluminacion" value="malo">Malo</label>
                            </div>
                        </div>

                        <div class="fleft dnone" data-energia-level1="no">    
                            <div class="inputfield">                        
                                <input type="text" class="texto" name="energia_electica_no" minlength="2" />
                                <label>¿Por qué motivo no cuenta con energía eléctrica? <mark></mark></label>
                            </div> 
                        </div>    

                    <div class="fleft">    
                        <label>¿El inmueble cuenta con suficiente iluminación de sus áreas comunes, pasillos y demás? </label>
                        <div class="radio text-center">
                            <label style="margin-right: 10px"><input type="radio" name="iluminacion_suficiente" value="si">Si</label>
                            <label style="margin-right: 10px"><input type="radio" name="iluminacion_suficiente" value="no">No</label>
                        </div>
                    </div>   

                     

                    <label>¿La manzana en la que se ubica el predio cuenta con alumbrado público? <mark></mark></label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="alumbrado_manzana" required value="si">Si</label>
                        <label style="margin-right: 10px"><input type="radio" name="alumbrado_manzana" required value="no">No</label>
                        <label><input type="radio" name="alumbrado_manzana" required value="no_necesario">No necesario</label>
                    </div>
                    <label style="float: left">¿Se cuenta con alumbrado público hasta el punto más cercano de transporte público? <mark></mark></label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="alumbrado_transporte" required value="si">Si</label>
                        <label style="margin-right: 10px"><input type="radio" name="alumbrado_transporte" required value="no">No</label>
                        <label><input type="radio" name="alumbrado_transporte" required value="no_necesario">No necesario</label>
                    </div>
                    <label style="float: left">¿El alumbrado público se encuentra en buenas condiciones? <mark></mark></label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="alumbrado_condiciones" required value="si">Si</label>
                        <label style="margin-right: 10px"><input type="radio" name="alumbrado_condiciones" required value="no">No</label>
                        <label><input type="radio" name="alumbrado_condiciones" required value="no_necesario">No necesario</label>
                    </div>
                    <label style="float: left">¿Cuenta con servicio de telefonía para las labores administrativas del inmueble? <mark></mark></label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="telefonia" required value="si">Si</label>
                        <label style="margin-right: 10px"><input type="radio" name="telefonia" required value="no">No</label>
                        <label><input type="radio" name="telefonia" required value="no_necesario">No necesario</label>
                    </div>
                    <label style="float: left">¿Cuenta con servicio de internet para sus administrativos? <mark></mark></label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="internet_administrativos" required value="si">Si</label>
                        <label style="margin-right: 10px"><input type="radio" name="internet_administrativos" required value="no">No</label>
                        <label><input type="radio" name="internet_administrativos" required value="no_necesario">No necesario</label>
                    </div>
                    <label style="float: left">¿Cuenta con servicio de internet gratuito disponible para sus usuarios? <mark></mark></label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="internet_usuarios" required value="si">Si</label>
                        <label style="margin-right: 10px"><input type="radio" name="internet_usuarios" required value="no">No</label>
                        <label><input type="radio" name="internet_usuarios" required value="no_necesario">No necesario</label>
                    </div>
                    <label style="float: left">¿El inmueble cuenta con el servicio de recolección de basura? <mark></mark></label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="recoleccion_basura" required value="si">Si</label>
                        <label style="margin-right: 10px"><input type="radio" name="recoleccion_basura" required value="no">No</label>
                        <label><input type="radio" name="recoleccion_basura" required value="no_necesario">No necesario</label>
                    </div>
                    <label style="float: left">¿Cuenta con vigilancia diurna? <mark></mark></label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="vigilancia_diurna" required value="si">Si</label>
                        <label style="margin-right: 10px"><input type="radio" name="vigilancia_diurna" required value="no">No</label>
                        <label><input type="radio" name="vigilancia_diurna" required value="no_necesario">No necesario</label>
                    </div>
                    <label style="float: left">¿Cuenta con vigilancia nocturna? <mark></mark></label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="vigilancia_nocturna" required value="si">Si</label>
                        <label style="margin-right: 10px"><input type="radio" name="vigilancia_nocturna" required value="no">No</label>
                        <label><input type="radio" name="vigilancia_nocturna" required value="no_necesario">No necesario</label>
                    </div>
                    <label style="float: left">¿El inmueble cuenta con personal administrativo o de mantenimiento encargado de procurar su buen funcionamiento cada día? <mark></mark></label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="personal_mantenimiento" required value="si">Si</label>
                        <label style="margin-right: 10px"><input type="radio" name="personal_mantenimiento" required value="no">No</label>
                        <label><input type="radio" name="personal_mantenimiento" required value="no_necesario">No necesario</label>
                    </div>



                    <label class="titlesection"><b>9</b><span>Características de la construcción</span></label> 
                    <label style="float: left; font-weight: normal; width: 100%">
                    En términos generales, la construcción se encuentra en las siguientes condiciones</label>
                    <label style="float: left">Muros </label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="muros"  value="bueno">Bueno</label>
                        <label style="margin-right: 10px"><input type="radio" name="muros"  value="regular" >Regular</label>
                        <label><input type="radio" name="muros"  value="malo">Malo</label>
                    </div>  
                    <div class="inputfield">                        
                        <input type="texto" class="texto" name="muros_nota"/>
                        <label>Notas </label>
                    </div>

                    <label style="float: left">Pisos</label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="pisos"  value="bueno">Bueno</label>
                        <label style="margin-right: 10px"><input type="radio" name="pisos"  value="regular" >Regular</label>
                        <label><input type="radio" name="pisos"  value="malo">Malo</label>
                    </div> 
                    <div class="inputfield">                        
                        <input type="texto" class="texto" name="pisos_nota"/>
                        <label>Notas </label>
                    </div>    

                    <label style="float: left">Techos</label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="techos"  value="bueno">Bueno</label>
                        <label style="margin-right: 10px"><input type="radio" name="techos"  value="regular" >Regular</label>
                        <label><input type="radio" name="techos"  value="malo">Malo</label>
                    </div>  
                    <div class="inputfield">                        
                        <input type="texto" class="texto" name="techos_nota"/>
                        <label>Notas </label>
                    </div> 


                    <label class="titlesection"><b>10</b><span>Servicios sanitarios</span></label>                    
                    <label style="float: left">El inmueble cuenta con servicio sanitario para los usuarios <mark></mark></label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="sanitario_usuarios" required value="si">Sí</label>
                        <label style="margin-right: 10px"><input type="radio" name="sanitario_usuarios" required value="no">No</label>
                        <label><input type="radio" name="sanitario_usuarios" required value="no_necesario">No necesario</label>
                    </div>  
                    <label style="float: left">¿El servicio sanitario está separado por género?</label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="sanitario_generos"  value="si">Sí</label>
                        <label style="margin-right: 10px"><input type="radio" name="sanitario_generos"  value="no" >No</label>
                    </div> 
                    <label style="float: left">¿Con cuántos servicios o wc para mujeres cuenta el inmueble? <mark></mark></label>
                    <div class="inputfield">                        
                        <input type="number" class="texto" name="wc_mujeres" required/>
                        <label>Cantidad <mark></mark></label>
                    </div>
                    <label style="float: left">¿Con cuántos servicios o wc para hombres cuenta el inmueble? <mark></mark></label>
                    <div class="inputfield">                        
                        <input type="number" class="texto" name="wc_hombres" required/>
                        <label>Cantidad <mark></mark></label>
                    </div>
                    <label style="float: left">¿Con cuántos servicios o wc mixtos cuenta el inmueble? <mark></mark></label>
                    <div class="inputfield">                        
                        <input type="number" class="texto" name="wc_mixtos" required/>
                        <label>Cantidad <mark></mark></label>
                    </div>
                    <label style="float: left">¿El inmueble cuenta con servicio sanitario para el personal administrativo o de mantenimiento? <mark></mark></label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="sanitario_personal" required value="si">Sí</label>
                        <label style="margin-right: 10px"><input type="radio" name="sanitario_personal" required value="no">No</label>
                        <label><input type="radio" name="sanitario_personal" required value="no_necesario">No necesario</label>
                    </div> 
                    <label style="float: left">¿El personal acude a los mismos servicios sanitarios que los usuarios del inmueble? <mark></mark></label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="sanitario_compartido" required value="si">Sí</label>
                        <label style="margin-right: 10px"><input type="radio" name="sanitario_compartido" required value="no">No</label>
                        <label><input type="radio" name="sanitario_compartido" required value="no_necesario">No necesario</label>
                    </div> 
                    <label style="float: left">¿Con cuántos servicios o wc para personal administrativo-mujeres cuenta el inmueble? <mark></mark></label>
                    <div class="inputfield">                        
                        <input type="number" class="texto" name="wc_personal_mujeres" required/>
                        <label>Cantidad <mark></mark></label>
                    </div>
                    <label style="float: left">¿Con cuántos servicios o wc para personal administrativo-hombres cuenta el inmueble? <mark></mark></label>
                    <div class="inputfield">                        
                        <input type="number" class="texto" name="wc_personal_hombres" required/>
                        <label>Cantidad <mark></mark></label>
                    </div>
                    <label style="float: left">¿Con cuántos servicios o wc personal administrativo-mixtos cuenta el inmueble? <mark></mark></label>
                    <div class="inputfield">                        
                        <input type="number" class="texto" name="wc_personal_mixto" required/>
                        <label>Cantidad <mark></mark></label>
                    </div>

                    <label class="titlesection"><b>11</b><span>Espacios o áreas específicas con las que cuenta el inmueble</span></label>                  
                    <div class="col-sm-5 col-xs-12 pl0">
                        <div class="inputfield">
                            <input type="number" class="texto" required name="metros_cuadrados_predio">
                            <label>M2 aproximados que tiene el predio <mark></mark></label>
                        </div>
                    </div> 
                    <div class="col-sm-7 col-xs-12 pr0">
                        <div class="inputfield ">
                            <input type="number" class="texto" required name="numero_cajones_estacionamiento_usuarios">
                            <label>No. de cajones de estacionamiento para usuarios <mark></mark></label>
                        </div>
                    </div>     
                    <div class="col-sm-7 col-xs-12 pl0">
                        <div class="inputfield">
                            <input type="number" class="texto" required name="numero_cajones_estacionamiento_empleados">
                            <label>No. de cajones de estacionamiento para empleados <mark></mark></label>
                        </div>
                    </div>

                    <label class="titlesection"><b>12</b><span>Áreas deportivas</span></label> 
                    <label style="float: left">¿El inmueble cuenta con canchas deportivas o áreas para disciplinas deportivas?     <mark></mark></label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="cuenta_areas_deportivas" required value="si">Sí</label>
                        <label ><input type="radio" name="cuenta_areas_deportivas" required value="no">No</label>
                    </div>

                        <div class="fleft dnone" data-areas-level1="si">                                
                            <a href="#" class="btn btn-warning btn-sm" id="addareasdeportivas">Agregar nueva área deportiva</a>
                            <div class="areasdeportivas_grid">                                  
                            </div>
                        </div>

                    <label class="titlesection"><b>13</b><span>Áreas verdes y vegetación</span></label> 
                    <label style="float: left">¿El inmueble cuenta con áreas verdes?     <mark></mark></label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="cuenta_areas_verdes" required value="si">Sí</label>
                        <label ><input type="radio" name="cuenta_areas_verdes" required value="no">No</label>
                    </div>
                    <label style="float: left">¿Cuál es el estado de conservación de las áreas verdes?</label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="estado_areas_verdes" value="bueno">Bueno</label>
                        <label style="margin-right: 10px"><input type="radio" name="estado_areas_verdes" value="regular">Regular</label>
                        <label ><input type="radio" name="estado_areas_verdes" value="malo">Malo</label>
                    </div>
                    <label style="float: left">¿Hay árboles dentro del predio?     <mark></mark></label>
                    <div class="radio text-center">
                        <label style="margin-right: 10px"><input type="radio" name="arboles_dentro_predio" required value="si">Sí</label>
                        <label ><input type="radio" name="arboles_dentro_predio" required value="no">No</label>
                    </div>
                    <label style="float: left">¿Cuántos arboles dentro del predio hay? <mark></mark></label>
                    <div class="inputfield">                        
                        <input type="number" class="texto" name="cuantos_arboles" required/>
                        <label>Cantidad <mark></mark></label>
                    </div>

                        <div class="fleft dnone" data-arboles-level1="si">    
                            <label style="float:left; width: 100%">Si es posible, especifique la especie de los árboles: </label>
                            <a href="#" class="btn btn-warning btn-sm" id="addarbol">Agregar nuevo árbol</a>
                            <div class="arboles_grid">  
                                
                            </div>
                        </div>

                    <!--<span class="etiqueta"><b class="notavailable"></b> Los campos marcados son obligatorios.</span>-->
                    <input type="submit" class="btn btn-primary submit" value="Confirmar">
                </div>
            </form> 
            @endif
            @if($tipo=='show')
            <div class="mt-45">
                
                <div class="main-primary col-sm-8 col-md-8 col-xs-12 br-5 p15 mb-30 col-sm-offset-2">
                                                                       
                </div>

            </div> 
            @endif
                    
        </div>
    </div>
@endsection

@section('page-js-script')
    
  <!--maps-->
  <script src="https://maps.googleapis.com/maps/api/js?key={{$googlemapskey}}&callback=initMap"  defer></script>
      
  <script>
    
    $(document).ready(function(){
      
      $(".loading-main").fadeOut();

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

      //subsistema  
      $('select[name="subsistema"]').on('change', function() {
          $value = this.value;
          if($value!=""){
            $('select[name="elemento"]').prop('disabled',false);            
          }
          else{
            $('select[name="elemento"]').prop('disabled',true);
          }
          $('select[name="elemento"] option').prop('disabled',true);
          //$('select[name="elemento"] option[value=""]').prop('disabled',false).prop('selected', true);
          $('select[name="elemento"] option[data-subsistema="' + $value + '"]').prop('disabled',false);
          $('select[name="elemento"]').select2({placeholder: "Seleccione un valor"});
        
          if($value=="Educación"){
            $(".claveescolar").show();
            //$('input[name="clave_escolar"]').prop('required',true);
          }
          else{
            $(".claveescolar").hide();
            //$('input[name="clave_escolar"]').prop('required',false);
          }

      });
      
      //elemento
      $('select[name="elemento"]').on('change', function() {
          $ubs = $(this).find("option:selected").attr("data-ubs"); 
          $capacidad_ubs = $(this).find("option:selected").attr("data-capacidad-ubs");
          $radio = $(this).find("option:selected").attr("data-radio");            
          if($ubs!="" && $radio!=""){
            $('input[name="ubs"]').val($ubs);
            $('input[name="capacidad_ubs"]').val($capacidad_ubs);
            $('input[name="radio_cobertura"]').val($radio);
          }
      });
      //cp
      $('select[name="cp"]').on('change', function() {
          $value = this.value;
          if($value!=""){
            $('select[name="colonia"]').prop('disabled',false);            
          }
          else{
            $('select[name="colonia"]').prop('disabled',true);
          }
          $('select[name="colonia"] option').prop('disabled',true);
          //$('select[name="colonia"] option[value=""]').prop('disabled',false).prop('selected', true);
          $('select[name="colonia"] option[data-cp="' + $value + '"]').prop('disabled',false);
          $('select[name="colonia"]').select2({placeholder: "Seleccione un valor"});
      });

      //cuando teclean ubs´s
      $("input[name='num_ubs'],input[name='num_usuarios']").on("change paste keyup", function() {           
           $ubs=$('input[name="num_ubs"]').val(); 
           $usuarios=$('input[name="num_usuarios"]').val();
           if($ubs==0){
                $('input[name="num_usuarios_ubs"]').val(0);
           }
           else{
                $('input[name="num_usuarios_ubs"]').val(parseInt($usuarios/$ubs));
           }
      });

      //agua potable
      $('input[name="servicio_agua_potable"]').on('change', function() {
         $value = this.value;         
         $('div[data-agua-level1]').addClass("dnone");
         $('div[data-agua-level1]').find("input,select").prop('required',false);
         $('div[data-agua-level1="'+$value+'"]').removeClass("dnone");
         $('div[data-agua-level1="'+$value+'"]').find("input,select").prop('required',true);  
         $('div[data-agua-level2="'+$value+'"]').find("input,select").prop('required',false);    
      });
      //agua potable eleccion nivel 2
      $('input[name="servicio_continuo_agua"]').on('change', function() {
         $value = this.value;         
         $('div[data-agua-level2]').addClass("dnone");
         $('div[data-agua-level2]').find("input,select").prop('required',false);  
         $('div[data-agua-level2="'+$value+'"]').removeClass("dnone");
         $('div[data-agua-level2="'+$value+'"]').find("input,select").prop('required',true);  
      });

      //drenaje
      $('input[name="drenaje_sanitario"]').on('change', function() {
         $value = this.value;         
         $('div[data-drenaje-level1]').addClass("dnone");
         $('div[data-drenaje-level1]').find("input,select").prop('required',false);
         $('div[data-drenaje-level1="'+$value+'"]').removeClass("dnone");
         $('div[data-drenaje-level1="'+$value+'"]').find("input,select").prop('required',true);    
      });

      //energia electrica
      $('input[name="energia_electica"]').on('change', function() {
         $value = this.value;         
         $('div[data-energia-level1]').addClass("dnone");
         $('div[data-energia-level1]').find("input,select").prop('required',false);
         $('div[data-energia-level1="'+$value+'"]').removeClass("dnone");
         $('div[data-energia-level1="'+$value+'"]').find("input,select").prop('required',true);    
      });

      //arboles
      $('input[name="arboles_dentro_predio"]').on('change', function() {
        $value = this.value;         
         $('div[data-arboles-level1]').addClass("dnone");
         $('div[data-arboles-level1]').find("input,select").prop('required',false);
         $('div[data-arboles-level1="'+$value+'"]').removeClass("dnone");
         $('div[data-arboles-level1="'+$value+'"]').find("input,select").prop('required',true);    
      });

      //areasdeportivas
      $('input[name="cuenta_areas_deportivas"]').on('change', function() {
         $value = this.value;         
         $('div[data-areas-level1]').addClass("dnone");
         $('div[data-areas-level1]').find("input,select").prop('required',false);
         $('div[data-areas-level1="'+$value+'"]').removeClass("dnone");
         $('div[data-areas-level1="'+$value+'"]').find("input,select").prop('required',true);    
      });


      //remove item (arboles/areasdeportivas)
      $('body').on('click','.removeitem', function() {
        $(this).parent().remove();
        return false;
      });

      //add arboles
      $('#addarbol').on('click', function() {
          var arbolstring="";   
          arbolstring+='  <div class="arbol"><a href="#" class="removeitem"><i class="fa fa-times"></i></a>';
          arbolstring+='      <div class="col-sm-5 col-xs-12">';
          arbolstring+='          <label>Especie de árbol <mark></mark></label>';
          arbolstring+='          <select class="form-control mb-30 select2-single" name="nombre_arbol[]" required>';
          arbolstring+='              <option value="">Seleccione un valor</option>';   
          arbolstring+='              <option value="Almendro">Almendro</option>'; 
          arbolstring+='              <option value="Mulato">Mulato</option>';
          arbolstring+='              <option value="Framboyán">Framboyán</option>';
          arbolstring+='              <option value="Cedro">Cedro</option>';
          arbolstring+='              <option value="Lluvia de oro">Lluvia de oro</option>';
          arbolstring+='              <option value="Caoba">Caoba</option>';
          arbolstring+='              <option value="Súchil">Súchil</option>';
          arbolstring+='              <option value="Limonero">Limonero</option>';
          arbolstring+='              <option value="Nanche">Nanche</option>';
          arbolstring+='              <option value="Aguacate">Aguacate</option>';
          arbolstring+='              <option value="Mago">Mango</option>';
          arbolstring+='              <option value="Naranja">Naranja</option>';
          arbolstring+='              <option value="Copite">Copite</option>';
          arbolstring+='              <option value="Pompo">Pompo</option>';
          arbolstring+='              <option value="Barba de viejo">Barba de viejo</option>';
          arbolstring+='              <option value="Tronador">Tronador</option>';
          arbolstring+='              <option value="Roble rosado">Roble rosado</option>';
          arbolstring+='              <option value="Jobo">Jobo</option>';
          arbolstring+='              <option value="Ciruela">Ciruela</option>';
          arbolstring+='              <option value="Guayaba">Guayaba</option>';
          arbolstring+='              <option value="Ficus">Ficus</option>';
          arbolstring+='              <option value="Áhuehuete">Áhuehuete</option>';
          arbolstring+='              <option value="Garra de tigre">Garra de tigre</option>';
          arbolstring+='              <option value="Casuarina">Casuarina</option>';
          arbolstring+='              <option value="Árbol-Zapote">Zapote</option>';
          arbolstring+='              <option value="Árbol-Pochota o ceiba">Pochota o ceiba</option>';
          arbolstring+='              <option value="Guanacaxtle o parota">Guanacaxtle o parota</option>';
          arbolstring+='              <option value="Neem">Neem</option>';
          arbolstring+='              <option value="Palmeras">Palmeras</option>';
          arbolstring+='              <option value="Palmera cocotera">Palmera cocotera</option>';
          arbolstring+='              <option value="Palmeras varias">Palmeras varias</option>';
          arbolstring+='          </select>'; 
          arbolstring+='      </div>';  
          arbolstring+='      <div class="col-sm-2 col-xs-12">';
          arbolstring+='          <label>Cantidad <mark></mark></label>';
          arbolstring+='          <div class="inputfield">';                        
          arbolstring+='              <input type="number" class="texto" name="cantidad_arbol[]" required/>';
          arbolstring+='              <label>Cuantos</label>';
          arbolstring+='          </div>';
          arbolstring+='      </div>';  
          arbolstring+='      <div class="col-sm-5 col-xs-12">';
          arbolstring+='          <label>Observaciones</label>';
          arbolstring+='          <div class="inputfield">';                        
          arbolstring+='              <input type="texto" class="texto" name="observaciones_arbol[]"/>';
          arbolstring+='              <label>Observaciones</label>';
          arbolstring+='          </div>';
          arbolstring+='      </div>';     
          arbolstring+='  </div>';
          $(".arboles_grid").append(arbolstring);
          return false;
      }); 

      //add areasdeportivas
      $('#addareasdeportivas').on('click', function() {
          var areastring="";   
          areastring+='  <div class="arbol"><a href="#" class="removeitem"><i class="fa fa-times"></i></a>';
          areastring+='      <div class="col-sm-4 col-xs-12">';
          areastring+='          <label>Tipo de cancha o espacio <mark></mark></label>';
          areastring+='          <select class="form-control mb-30 select2-single" name="nombre_areadeportiva[]" required>';
          areastring+='              <option value="">Seleccione un valor</option>';   
          areastring+='              <option value="Futbol">Futbol</option>'; 
          areastring+='              <option value="Básquet">Básquet</option>';
          areastring+='              <option value="Voleibol">Voleibol</option>';
          areastring+='              <option value="Usos múltiples">Usos múltiples</option>';
          areastring+='              <option value="Alberca">Alberca</option>';
          areastring+='              <option value="Ring">Ring</option>';
          areastring+='              <option value="Salón de baile">Salón de baile</option>';
          areastring+='              <option value="Gimnasia">Gimnasia</option>';
          areastring+='              <option value="Tenis">Tenis</option>';
          areastring+='              <option value="Frontón">Frontón</option>';
          areastring+='              <option value="Otros">Otros</option>';
          areastring+='          </select>'; 
          areastring+='      </div>';  
          areastring+='      <div class="col-sm-2 col-xs-12">';
          areastring+='          <label>Cantidad <mark></mark></label>';
          areastring+='          <div class="inputfield">';                        
          areastring+='              <input type="number" class="texto" name="cantidad_areadeportiva[]" required/>';
          areastring+='              <label>Cuantas</label>';
          areastring+='          </div>';
          areastring+='      </div>';  
          areastring+='      <div class="col-sm-3 col-xs-12">';
          areastring+='          <label>Dimensiones</label>';
          areastring+='          <div class="inputfield">';                        
          areastring+='              <input type="number" class="texto" name="largo_areadeportiva[]" required/>';
          areastring+='              <label>Largo <mark></mark></label>';
          areastring+='          </div>';
          areastring+='      </div>'; 
          areastring+='      <div class="col-sm-3 col-xs-12">';
          areastring+='          <label>-</label>';
          areastring+='          <div class="inputfield">';                        
          areastring+='              <input type="number" class="texto" name="ancho_areadeportiva[]" required/>';
          areastring+='              <label>Ancho <mark></mark></label>';
          areastring+='          </div>';
          areastring+='      </div>';    
          areastring+='  </div>';
          $(".areasdeportivas_grid").append(areastring);
          return false;
      });  

      $("#levantamiento-form").on('submit', function(){
        var form = $('#levantamiento-form')[0];
        var data = new FormData(form);
        $.ajax({
            enctype: 'multipart/form-data',
            processData: false,  
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('levantamientosave')}}", 
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
                $(".responsemessage").addClass("showed").html(result.description).slideDown();              
            },
            error: function(xhr, resp, text) {
                //console.log(xhr);
                //console.log(resp);
                //console.log(text);
                var error = xhr.responseJSON.message.slice(0, 75);
                var linea = xhr.responseJSON.line;

                $(".loading-main").fadeOut();
                $(".responsemessage").addClass("errorresponse");
                $(".responsemessage").addClass("showed").html("Ocurrió un error guardando el levantamiento: "+error+". Línea: "+linea).slideDown();
            }
        });
        return false;
      });

      


    });

    function initMap() {    
        var map = new google.maps.Map(document.getElementById('map_canvas'), {
            zoom: 18,
            center: new google.maps.LatLng(19.1952535, -96.1478962),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var myMarker = new google.maps.Marker({
            position: new google.maps.LatLng(19.1952535, -96.1478962),
            draggable: true
        });
        google.maps.event.addListener(myMarker, 'dragend', function (evt) {
            //document.getElementById('current').innerHTML = '<p>Marcador movido: Lat: ' + evt.latLng.lat().toFixed(3) + ' Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
            $("input[name='ubicacion_croquis_lat_lon']").val(evt.latLng.lat()+","+evt.latLng.lng());
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

