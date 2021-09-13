@extends('layouts.app')

@section('page-style-files')
    <!--main booking-->
    <link rel="stylesheet" href="{{url('/css/app.css')}}" type="text/css" media="all">
    <style type="text/css">
        .requisito span stronger{ background: #eee; padding: 7px; color: #000; font-size: 12px; border-radius:5px;  width: 100%; margin-bottom: 20px;
            margin-top: 20px; display: block; font-weight: bold}
            .requisito span stronger i{ font-weight: normal; font-style: normal}
            .btnrequisitos{display: block; width: 126px;  padding: 2px 4px; font-size: 10px; text-transform: none!important}
                .btnrequisitos i{ font-size: 6px; float: left; margin-top: 5px; margin-bottom: 10px }
        .requisito span a{ font-weight: bold; text-decoration: underline; }
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

@section('initlink')
<a href="{{route('/', app()->getLocale())}}" class="small">Regresar a inicio</a>
@endsection

@section('titlebig')
<h5>Cero Filas</h5>
<h1>Crear Cita</h1>
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

            <form id="cita-form">

                <div class="main-left col-sm-7 col-md-7 col-xs-12 br-5 p15 mb-30">
                    <h3 class="header3">Pasos para solicitar cita</h3>
                    
                    <quote>Antes de empezar, ten a la mano tu <b>CURP</b>, ya que es necesario para el registro, tiene un tiempo límite de 5 minutos para completarlo. Si no lo tienes, <a href="https://www.gob.mx/curp/" target="_blank" rel="noopener noreferrer">encuéntralo aquí.</a></quote>

                    <label class="titlesection" data-section="1"><b>1</b><span>¿Qué trámite vas a realizar?</span></label>
                    <p class="descriptionsection">Selecciona el trámite que necesitas. Importante leer el apartado REQUISITOS.</p>
                    <select class="form-control mb-30 select2-single" id="tramite" required="" name="tramite">
                        <option value="">Seleccione un valor</option>              
                    </select>

                    <label class="titlesection" data-section="2"><b>2</b><span>¿Dónde quieres tu cita?</span></label>
                    <p class="descriptionsection">Selecciona el lugar para realizar el trámite.</p>
                    <select class="form-control mb-30" id="lugarcita" required="" name="lugar-cita" disabled="">
                        <option value="">Seleccione un valor</option>                        
                    </select>

                    <label class="titlesection" data-section="3"><b>3</b><span>¿Cuándo quieres tu cita?</span></label>  
                    <p class="descriptionsection">Indica en el calendario la fecha y selecciona la hora en que deseas tu cita.</p>

                    <div class="calendar-wrapper cal_info hiddened">
                        <input type="hidden" name="fechahora" id="fechahora">
                        <div class="calendar-header">
                            <a class="previous-date" href="#" data-date=""><i class="fas fa-chevron-left"></i></a>                
                            <div class="calendar-title">Mes no seleccionado</div>
                            <div class="calendar-year">Año no seleccionado</div>
                            <a class="next-date" href="#" data-date=""><i class="fas fa-chevron-right"></i></a>
                        </div>
                        <div class="calendar-body">
                            <div class="weekdays fl">
                                <div class="ct-day"><span>Lun</span></div>
                                <div class="ct-day"><span>Mar</span></div>
                                <div class="ct-day"><span>Mie</span></div>
                                <div class="ct-day"><span>Jue</span></div>
                                <div class="ct-day"><span>Vie</span></div>
                                <div class="ct-day"><span>Sab</span></div>
                                <div class="ct-day ct-last-day"><span>Dom</span></div>
                            </div>
                            <div id="datesarea" class="dates"></div>        
                            <div class="hours">
                                <label>Horarios disponibles</label>
                                <small></small>
                                <div>
                                    
                                </div>
                            </div>
                                    
                            <div class="today-date">
                                <span class="labeled">Fecha/Hora elegida</span>
                                <div class="ct-selected-date-view">
                                    <span class="add_date ct-date-selected"><i class="far fa-calendar"></i> <fecha></fecha></span>
                                    <span class="add_time ct-time-selected"><i class="far fa-clock"></i> <hora></hora></span>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <span class="etiqueta"><b class="available"></b> Día con horas disponibles</span>
                    <span class="etiqueta etiqueta-right"><b class="notavailable"></b> Día sin horas disponibles</span>

                    <label class="titlesection" data-section="4"><b>4</b><span>¿Quién quiere la cita?</span></label>    
                    <p class="descriptionsection">Importante que los datos pertenezcan a la persona que acudirá a la cita. Los datos del nombre y apellido sin acentos.</p>

                    <div class="inputfield">
                        <input type="text" class="texto capitalize" id="username" required="" autocomplete="off" name="nombre" minlength="2">
                        <label>Nombre(s) <mark></mark></label>
                    </div>
                    <div class="col-sm-6 col-xs-12 pl0">
                        <div class="inputfield">
                            <input type="text" class="texto capitalize" id="apellidopaterno" required="" autocomplete="off" name="apellido-paterno" minlength="2">
                            <label>Apellido Paterno <mark></mark></label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12 pr0">
                        <div class="inputfield">
                            <input type="text" class="texto capitalize" id="apellidomaterno" required="" autocomplete="off" name="apellido-materno" minlength="2">
                            <label>Apellido Materno <mark></mark></label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12 pl0">
                        <div class="inputfield">
                            <input type="email" class="texto" id="email" autocomplete="off" name="email" placeholder="ingrese email válido, ej.: mail@dominio.com">
                            <label>Email </label>
                        </div>
                    </div>
                    <div class="col-sm-7 col-xs-12 pl0">
                        <div class="inputfield">
                            <input type="tel" class="texto" id="telefono" autocomplete="off" name="telefono" placeholder="ingrese teléfono válido a 10 dígitos, ej.: 2291234567" maxlength="10">
                            <label>Teléfono </label>
                        </div>
                    </div>
                    <div class="col-sm-5 col-xs-12 pr0">
                        <div class="inputfield">
                            <input type="text" class="texto uppercase" id="curp" required="" autocomplete="off" name="curp" placeholder="18 dígitos" minlength="18" maxlength="18">
                            <label>CURP <mark></mark></label>
                        </div>
                   </div>
                   <span class="etiqueta"><b class="notavailable"></b> Los campos marcados son obligatorios. Si no completas la información, no puedes guardar la cita.</span>

                   <input type='submit' class='btn btn-primary submit' value='Confirmar' disabled="" />

                </div>

                <div class="anchor"></div>
                <div class="main-right col-sm-4 col-md-4 col-xs-12 br-5 mb-30 summary-scroll">
                    <h3 class="header3">Resumen de cita</h3>
                    <div class="summary-wrapper">
                        <div class="summary" data-summary="tramite"><div class="image"><i class="far fa-file-alt"></i></div><p class="text sel-service"><noselected>Trámite</noselected></p></div>
                        <div class="summary" data-summary="oficina"><div class="image"><i class="far fa-building"></i></div><p class="text sel-service"><noselected>Lugar</noselected></p></div>
                        <div class="summary" data-summary="fechahora"><div class="image"><i class="far fa-calendar"></i></div><p class="text sel-service"><noselected>Fecha y hora</noselected></p></div>
                        <div class="summary" data-summary="nombre"><div class="image"><i class="far fa-user"></i></div><p class="text sel-service"><noselected>Nombre completo</noselected></p></div>
                        <div class="summary" data-summary="email"><div class="image"><i class="far fa-envelope"></i></div><p class="text sel-service lowercase"><noselected>Email</noselected></p></div>
                        <div class="summary" data-summary="curp"><div class="image"><i class="far fa-id-card"></i></div><p class="text sel-service uppercase"><noselected>CURP</noselected></p></div>
                        <div class="summary" data-summary="telefono"><div class="image"><i class="fa fa-phone"></i></div><p class="text sel-service uppercase"><noselected>Teléfono</noselected></p></div>
                        <div class="map"><div id="map"></div></div>
                        <div class="timerareacontainer"></div>    
                    </div>
                </div>

            </form> 
                    
        </div>
    </div>
@endsection

@section('page-js-script')
    <!--maps-->
    <script src="https://maps.googleapis.com/maps/api/js?key={{$googlemapskey}}&callback=initMap"  defer></script>
    
    <!--booking script-->
    <script type="text/javascript">
        var gettramitesurl = "{{route('gettramites', app()->getLocale())}}";
        var getoficinasurl = "{{route('getoficinas', app()->getLocale())}}";
        var getavailabledaysurl = "{{route('getavailabledays', app()->getLocale())}}";
        var getavailablehoursurl = "{{route('getavailablehours', app()->getLocale())}}";
        var savedateurl = "{{route('savedate', app()->getLocale())}}";
        var holdingdateurl = "{{route('holdingcita', app()->getLocale())}}";
        var removeholdingcitaurl = "{{route('removeholdingcita', app()->getLocale())}}";
    </script>
    <script src="{{url('/js/booking.js')}}" type="text/javascript"></script>
@endsection

