@extends('layouts.kiosk')

@section('page-style-files')
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <!--main booking-->
    <link rel="stylesheet" href="{{url('/css/app.css')}}" type="text/css" media="all">
    <style type="text/css">
    .sincitavisor close,.concitavisor label close{ right:auto; left:10px}
    .concitavisor label search{ left:auto; right:10px}
    .sincitavisor close i,.concitavisor label close i,.concitavisor label search i{ margin-bottom: 20px; font-size: 40px }
    .sincitavisor close k,.concitavisor label close k,.concitavisor label search k{ line-height: 20px; font-size: 14px; color:#fff; position: absolute; left: 0px; width: 100%; text-align: center; bottom:5px;}
    .fullscreencontainer{ background: #212F4D }
    em{ color:#E0B54B; font-style: normal; }
    label em{color:#000;}
    </style>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-155250227-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-155250227-1');
</script>

@endsection

@section('content')
    <span class="nombreoficina">Oficina: <b>{{$oOficina->nombre_oficina}}</b></span>

    <div class="responsemessage"></div>

    <div class="fullscreencontainer">        
        <span class="logocontainer"><img src="{{url('/images/logo.png')}}" class="logo"></span>
        <span class="descriptioncontainer"><h1>Selecciona</h1><p>Si registraste una cita, selecciona con cita. Si no registraste ninguna cita, selecciona sin cita. En ambos casos al finalizar se te indicará el tiempo de espera.</p></span>
        <span class="buttonscontainer">
            <a href="#" class="concita">Con cita</a>
            <a href="#" class="sincita">Sin cita</a>
        </span>
         
    </div>  

    <div class="miniscreencontainer">
        <close><i class="fa fa-times"></i></close>        
        <span class="descriptioncontainer"><h1 id="confirmationtype"></h1><p>Por favor espere su turno:</p></span>
        <span class="confirmacioncontainer">
            <h1 id="turno"></h1>
            <b><k id="tiempoaproximado"></k></b>
        </span>
    </div>

    <div class="minisearchcontainer">
        <close><i class="fa fa-times"></i></close>  
        <form id="search-form">      
            <p class="descriptionsection">Escribe nombre completo, curp o folio <em>*</em></p>
            <div class="inputfield">            
                <input type="text" class="texto" id="search" autocomplete="off" name="search" placeholder="Escribe tu nombre completo, curp o folio de cita" 
                minlength="6" required="">
                <label>Nombre, curp o folio <em>(* si registraste más de 1 cita para el día de hoy, ingresa Folio)</em></label>                          
            </div>
            <input type="submit" value="Buscar" class="btn btn-primary" id="buttonbuscar">  
        </form>
    </div>

    <div class="concitavisor">
        <video id="preview" playsinline autoplay muted ></video>
        <label>Escanea Código QR <close><i class="fa fa-chevron-left"></i> <k>Regresar</k></close> <search><i class="fa fa-search"></i> <k>Buscador</k></search></label>
    </div>

    <div class="sincitavisor">
        <close><i class="fa fa-chevron-left"></i> <k>Regresar</k></close>
        <form id="turno-form">
            <label class="titlesection" data-section="1"><b>1</b><span>¿Qué trámite vas a realizar?</span></label>
            <p class="descriptionsection">Para iniciar, es necesario indiques el trámite que necesitas.</p>
            <!--mostrar solo tramites correspondientes de la dependencia, por lo que la url de waitingroom nos va a indicar la dependencia donde estamos ubicados-->
            <select class="form-control mb-30 select2-single" id="tramite" required="" name="tramite">
                <option value="">Seleccione un trámite</option> 
                @foreach($tramites as $tramite)
                    <option value='{{$tramite["id_tramite"]}}'>{{$tramite["nombre_tramite"]}}</option>        
                @endforeach                                    
            </select>

            <div class="w50 first">
                <label class="titlesection" data-section="2"><b>2</b><span>¿Cuál es tu nombre?</span></label>
                <p class="descriptionsection">Es necesario indiques tu nombre.</p>
                <div class="inputfield">
                    <input type="text" class="texto capitalize" id="nombre" autocomplete="off" name="nombre" placeholder="Escribe tu nombre completo" minlength="2" required="">
                    <label>NOMBRE COMPLETO </label>
                </div>  
            </div>  

            <div class="w50 last">
                <label class="titlesection" data-section="3"><b>3</b><span>¿Cuál es tu CURP?</span></label>
                <p class="descriptionsection">Es necesario indiques tu CURP.</p>
                <div class="inputfield">
                    <input type="text" class="texto uppercase" id="curp" autocomplete="off" name="curp" placeholder="18 dígitos" minlength="18" maxlength="18">
                    <label>CURP </label>
                </div>  
            </div>

            <input type="submit" value="Crear turno" class="enviar">
        </form>
    </div>
@endsection

@section('page-js-script')
    <!--cam-->
    <script src="{{url('/js/instascan.min.js')}}" type="text/javascript"></script>
    <!--booking script-->
    <script type="text/javascript">
        var confirmationqrurl = "{{route('kioskconfirmationqr', app()->getLocale())}}/{{$oOficina->id_oficina}}";
        var searchcitabytexturl = "{{route('kiosksearchcitabytext', app()->getLocale())}}/{{$oOficina->id_oficina}}";
        var manualturnurl = "{{route('kioskmanualturn', app()->getLocale())}}";
        var gettramitesbykioskourl = "{{route('gettramitesbykiosko', app()->getLocale())}}/{{$oOficina->id_oficina}}";
        var oficina={{$oOficina->id_oficina}};
    </script>
    <script src="{{url('/js/waitingroom.js')}}" type="text/javascript"></script>
@endsection

