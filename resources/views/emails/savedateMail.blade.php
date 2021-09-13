@extends(isset($tipo) ? 'layouts.app' : 'layouts.empty')

@if(isset($tipo))
    @section('page-style-files')
        <link rel="stylesheet" href="{{url('/css/app.css')}}" type="text/css" media="screen">
        <style type="text/css">
            p{ font-size: 12px!important } 
            .containerwhite{float: left; width: 100%; background:#fff; margin-top: -45px; position: relative; z-index: 2; margin-bottom: 45px;
                box-shadow: 0 4px 4px #ccc; padding:0px; border-radius:5px; padding: 45px;
                max-width: 750px; margin-left: 125px}
            @media only screen and (max-width: 899px){
            footer .container{ height: auto!important }
            }
            .no-print{margin-top: 0px; width: 100%; text-align: center; float: left; height: auto; border-bottom: 1px solid #ccc; padding-bottom: 45px}
            .headerwrapper .textcontainer{ text-align: center}
            .qrcontainer{text-align: right; padding-right: 6%}
            @media only screen and (max-width: 1128px){
                .containerwhite{ margin-left:0%; max-width: 100%}
                .qrcontainer{text-align: right; padding-right: 5.9%}
            }
            @media only screen and (max-width: 828px){
                .qrcontainer{text-align: center; padding-right: 0px; width: 100%!important}
                .infocontainer{ width: 100%!important }
            }  
            .infocontainer div a{ font-weight: bold; text-decoration: underline; color:#337ab7!important;}          
        </style>
        <style type="text/css" media="print"> 
             body {font-family: 'NeoSans',Helvetica, sans-serif}
            .no-print,.headerwrapper,footer{display: none !important}
            .containerwhite{ padding:0px; margin-top: 0px; margin-bottom: 0px; margin-left: 0px; max-width: auto}
            @if($statuscita=="cancelada")
            .containerwhite:before{content: "Cancelada"; position: absolute; left: 200px; top: 400px; font-size: 70px; font-weight: bold;
             -webkit-transform: rotate(-45deg); -moz-transform: rotate(-45deg); text-align: center; opacity:0.7;}
            @endif
        </style>
        @if($tipo=="confirmacion")
        <script>window.print();</script>
        @endif
        <script src="{{url('/sis/vendors/js/jquery.min.js')}}" type="text/javascript"></script>
        <script src="{{url('/js/xepOnline.jqPlugin.js')}}" type="text/javascript"></script>
    @endsection    

@else
  <html>    
    <head>  
    <style type="text/css">
        .no-print,.headerwrapper,footer,.footerin{display: none !important}
        .qrcontainer{text-align: center; padding-right: 0px; width: 100%!important}
        .infocontainer div a{ font-weight: bold; text-decoration: underline}
        div[class$="footerin"],div[class$="headerwrapper"]{display: none !important}
    </style> 
    </head>
    <body>
@endif 
    
    @if(isset($tipo))
        @section('initlink')
        <a href="{{route('/', app()->getLocale())}}" class="small">Regresar a inicio</a>
        @endsection
        @section('titlebig')
        <h1>Impresión</h1>
        @endsection
    @endif
    
    @if(isset($tipo))
    @section('content')
    @endif

    @if(isset($tipo))
    <div class="wrappercontainer">
    <div class="container">
    <div class="containerwhite">
        <div class="no-print">
            @if($statuscita!="cancelada")
                <a href="javascript:void(0)" onclick="return xepOnline.Formatter.Format('printable',{render:'download',filename: 'confirmacion-{{$folio}}',embedLocalImages: 'true'});" 
                style="background:#E0B54B; border-radius:4px; height: 30px; line-height: 30px; padding:10px; color:#000; text-decoration: none; 
                font-family: Arial; font-size:12px">Descargar</a>
                <a href="javascript:void(0)" onclick="window.print();" 
                style="background:#222; border-radius:4px; height: 30px; line-height: 30px; padding:10px; color:#fff; text-decoration: none; 
                font-family: Arial; font-size:12px; margin-left: 20px">Imprimir</a>
                @if($tipo=="search")            
                <a href="javascript:void(0)" onclick='document.getElementById("form-folio").submit();' 
                style="background:#cc0000; border-radius:4px; height: 30px; line-height: 30px; padding:10px; color:#fff; text-decoration: none; 
                font-family: Arial; font-size:12px; margin-left: 20px">Cancelar</a>
                <form id="form-folio" method="post" action="{{route('cancelarcita', app()->getLocale())}}">
                    @csrf
                    <input type="hidden" value="{{$folio}}" id="folio" name="folio">
                </form>
                @endif
            @else
                <h2 style="color:#cc0000; text-transform: capitalize; margin-top:0px; margin-bottom: 0px">{{$statuscita}}</h2>
            @endif
        </div>
    @endif

    <div style="width:100%;background:#fff;padding:0px;color:#333333;font-family:Helvetica,Arial,Tahoma;margin-bottom:10px;font-size:12px;
    max-width:@if(isset($tipo)) 100% @else 647px @endif;margin:0 auto" id="printable">                

        <div style="width: 100%;  display: block">

            <!--<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="border:0px none;margin:0px;border-collapse:collapse;padding:0px; background-color:#ffffff;width:100%; border-bottom:1px solid #ccc; float: left; margin-bottom: 10px">
                <tbody valign="middle" style="border:none; margin:0px; padding:0px">
                    <tr height="25" valign="middle" style="border:none; margin:0px; padding:0px; height:25px">
                        <td colspan="2" class="x_footer-bottom-padding" height="25" valign="middle" style="border:none; margin:0px; padding:0px; height:25px"></td>
                    </tr>
                    <tr valign="middle" style="border:none; margin:0px; padding:0px">                        
                        <td valign="middle" style="border:none; margin:0px; padding:0px; text-align:center" width="25%">
                            <img src="{{url('/images/logo-white.png')}}" style="width:100%" />
                        </td>
                        <td valign="middle" style="border:none; margin:0px; padding:0px; text-align:center" width="75%">
                            <span style="color:#212F4D; font-weight: 500; text-transform: uppercase;  font-size: 20px; letter-spacing: 1px">
                                <span style="width: 100%; display: block; text-align: center;">Citas para trámites</span>
                                <span style="font-size: 12px; letter-spacing: 3px; width: 100%; text-align: center; display: block">@if(isset($recordatorio)) Recordatorio @else Alta @endif de cita</span>
                            </span>
                        </td>                        
                    </tr>
                    <tr height="25" valign="middle" style="border:none; margin:0px; padding:0px; height:25px">
                        <td colspan="2" class="x_footer-bottom-padding" height="25" valign="middle" style="border:none; margin:0px; padding:0px; height:25px">
                        </td>
                     </tr>
                </tbody>
            </table>-->
            <div style="width: 100%; display: block; float: left; height: 120px; margin-bottom: 10px; border-bottom:1px solid #ccc">
                <div style=" margin-top: 25px; margin-bottom: 25px; width: 100%; height: 70px; float:left">
                    <div style="width: 25%; float: left; text-align: center;height: 70px"><img src="{{url('/images/logo-white.png')}}" style="max-width:100%; max-height: 100%" /></div>
                    <div style="width: 75%; float: left; height: 70px">
                        <span style="color:#212F4D; font-weight: 500; text-transform: uppercase;  font-size: 20px; letter-spacing: 1px; margin-top: 10px; width: 100%; display: block">
                            <span style="width: 100%; display: block; text-align: center;">Citas para trámites</span>
                            <span style="font-size: 12px; letter-spacing: 3px; width: 100%; text-align: center; display: block">@if(isset($recordatorio)&&$recordatorio==true) Recordatorio @else Alta @endif de cita</span>
                        </span>
                    </div>
                </div>
            </div>
            
            <div style="width: 100%; display: block; float:left">
                               
                <h1 style="font-size:18px; margin-top: 20px">Hola {{$nombre["text"]}}!</h1> 
                <p style="font-size:13px; margin-bottom:0px">@if(isset($recordatorio)&&$recordatorio==true) Te recordamos que mañana tienes una cita para trámite. @else Hemos recibido con éxito tu solicitud de cita. @endif <b>No olvides asistir 10 minutos antes de la fecha/hora reservada. Al llegar a tu cita no olvides confirmar tu asistencia en recepción haciendo Check-in, llevando contigo el folio o QR, así como los requisitos del trámite. En caso que necesites hacerlo, puedes cancelar tu cita <a href="{{route('/', app()->getLocale())}}">aquí</a> indicando tu folio.</b></p>
                <div style="float: left; width:100%; text-align: center; margin-bottom: 20px; margin-top: 20px">Folio:
                    <b style="font-size: 35px; width: 100%; text-align: center;display: block; line-height: 35px">{{$folio}}</b>
                </div>
                
                <div style="width:100%; margin-bottom: 0px; margin-top: 20px; display: block">                
                    
                    <div style="float: left; width: @if(isset($print)) 50% @else 100% @endif" class="qrcontainer"> 
                        <span style="width: 100%; display: block; text-align: center;">Código QR:</span>                    
                        <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=foliodecitagenerado:{{$folio}}&choe=UTF-8&chld=|1"/>                   
                    </div>
                                            
                    <div style="margin-bottom:10px; line-height: 20px; float:left; @if(isset($print)) width: 320px; @else width:100%; @endif" class="infocontainer"> 
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block">Te compartimos los datos que guardamos de la cita:</div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b>Trámite:</b> {{$tramite["text"]}}</div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b>Oficina:</b> {{$oficina["text"]}}</div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b>Dirección oficina:</b> {{$oficina["direccion"]}}</div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b>Fecha/Hora:</b> {{$fechahora["text"]}}</div>
                        @if($email["value"]!="") <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b>Email:</b> {{$email["value"]}}</div> @endif
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b>CURP:</b> {{$curp["value"]}}</div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b>Costo(s):</b> {{$tramite["costo"]}}</div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b>Requisitos del Trámite:</b></div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block; line-height: 15px">{!! nl2br($tramite["requisitos"]) !!}</div>
                        <br><br>
                    </div> 
                </div>

            </div>
        
        </div>

        <div style="width: 100%; text-align: center; margin-top: 0px; margin-bottom: 0px; display: block; float: left">
            <div style="width:100%; margin-bottom: 5px; margin-top: 0px; display: block">Mapa de ubicación:</div>                 
            <img src='https://maps.googleapis.com/maps/api/staticmap?center={{trim($oficina["coords"])}}&zoom=17&size=640x230&scale=1&maptype=roadmap&markers={{trim($oficina["coords"])}}&key={{trim($googlemapskey->service_key)}}' width="100%" alt="mapa" style="max-width: 640px" />                    
        </div>

        @if(!isset($tipo))            
        <table class="x_footer-root" dir="" width="100%" cellpadding="0" cellspacing="0" bgcolor="#eee" 
        style="border:none; margin:0px; border-collapse:collapse; padding:0px; background-color:#eee; width:100%">
            <tbody valign="middle" style="border:none; margin:0px; padding:0px">
                
                <tr class="x_footer-top-padding" height="12" valign="middle" style="border:none; margin:0px; padding:0px; height:12px">
                    <td colspan="3" class="x_footer-top-padding" height="25" valign="middle" style="border:none; margin:0px; padding:0px; height:25px">
                    </td>
                </tr>
                <tr valign="middle" style="border:none; margin:0px; padding:0px">
                    <td width="6.25%" valign="middle" style="border:none; margin:0px; padding:0px; width:6.25%">
                    </td>
                    <td class="x_font" valign="middle" align="initial" style="border:none; margin:0px; padding:0px; font-weight:400; text-decoration:none; letter-spacing:0.15px; color:rgb(136,137,140); font-size:11px; line-height:1.65em; text-align:initial">Recuerda asistir 10 minutos antes de la fecha/hora reservada. Lleva contigo el folio o QR, así como los requisitos del trámite. No respondas este correo.</td>
                    <td width="6.25%" valign="middle" style="border:none; margin:0px; padding:0px; width:6.25%">
                    </td>
                </tr>
                <tr class="x_footer-top-padding" height="12" valign="middle" style="border:none; margin:0px; padding:0px; height:12px">
                    <td colspan="3" class="x_footer-top-padding" height="12" valign="middle" style="border:none; margin:0px; padding:0px; height:12px">
                    </td>
                </tr>
                <tr valign="middle" style="border:none; margin:0px; padding:0px">
                    <td width="6.25%" valign="middle" style="border:none; margin:0px; padding:0px; width:6.25%">
                    </td>
                    <td valign="middle" style="border:none; margin:0px; padding:0px">
                    <hr bgcolor="#999999" style="border:none; margin:0px; padding:0px; background-color:#999999; height:1px">
                    </td>
                    <td width="6.25%" valign="middle" style="border:none; margin:0px; padding:0px; width:6.25%">
                    </td>
                </tr>
                <tr class="x_footer-bottom-padding" height="15" valign="middle" style="border:none; margin:0px; padding:0px; height:15px">
                    <td colspan="3" class="x_footer-bottom-padding" height="15" valign="middle" style="border:none; margin:0px; padding:0px; height:15px">
                    </td>
                </tr>
                
                
                <tr valign="middle" style="border:none; margin:0px; padding:0px">
                    <td width="6.25%" valign="middle" style="border:none; margin:0px; padding:0px; width:6.25%">
                    </td>
                    <td class="x_font x_font-small" valign="middle" align="initial" style="border:none; margin:0px; padding:0px; font-weight:400; text-decoration:none; letter-spacing:0.15px; color:rgb(136,137,140); line-height:1.65em; text-align:initial; font-size:11px">
                    &copy; 2019 Ayuntamiento de Veracruz</td>
                    <td width="6.25%" valign="middle" style="border:none; margin:0px; padding:0px; width:6.25%">
                    </td>
                </tr>
                <tr height="20" valign="middle" style="border:none; margin:0px; padding:0px; height:20px">
                    <td colspan="3" class="x_footer-bottom-padding" height="25" valign="middle" style="border:none; margin:0px; padding:0px; height:25px">
                    </td>
                </tr>
            </tbody>
        </table>
        @endif

    </div>    
    
    @if(isset($tipo))
    </div>
    </div>
    </div>
    @endif

    @if(isset($tipo))
    @endsection
    @endif

@if(!isset($tipo))            
        </body>
    </html>
@endif
