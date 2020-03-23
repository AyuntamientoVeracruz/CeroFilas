
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
    
    

    <div style="width:100%;background:#fff;padding:0px;color:#333333;font-family:Helvetica,Arial,Tahoma;margin-bottom:10px;font-size:12px;
    max-width: 647px;margin:0 auto" id="printable">                

        <div style="width: 100%;  display: block">

            
            <div style="width: 100%; display: block; float: left; height: 120px; margin-bottom: 10px; border-bottom:1px solid #ccc">
                <div style=" margin-top: 25px; margin-bottom: 25px; width: 100%; height: 70px; float:left">
                    <div style="width: 25%; float: left; text-align: center;height: 70px"><img src="{{url('/images/logo-white.png')}}" style="max-width:100%; max-height: 100%" /></div>
                    <div style="width: 75%; float: left; height: 70px">
                        <span style="color:#212F4D; font-weight: 500; text-transform: uppercase;  font-size: 20px; letter-spacing: 1px; margin-top: 10px; width: 100%; display: block">
                            <span style="width: 100%; display: block; text-align: center;">Cédula Levantamiento</span>
                            <span style="font-size: 12px; letter-spacing: 3px; width: 100%; text-align: center; display: block">Alta de cédula</span>
                        </span>
                    </div>
                </div>
            </div>
            
            <div style="width: 100%; display: block; float:left">
                               
                <h1 style="font-size:18px; margin-top: 20px">Hola {{$levantamiento->nombre_registra_datos}}!</h1> 
                <p style="font-size:13px; margin-bottom:0px">Hemos recibido con éxito tu captura de levantamiento.</p>
                <div style="float: left; width:100%; text-align: center; margin-bottom: 20px; margin-top: 20px">Folio:
                    <b style="font-size: 35px; width: 100%; text-align: center;display: block; line-height: 35px">{{$levantamiento->folio}}</b>
                </div>
                
                <div style="width:100%; margin-bottom: 0px; margin-top: 20px; display: block">                
                                                                                   
                    <div style="margin-bottom:10px; line-height: 20px; float:left; width:100%;" class="infocontainer"> 
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block">Te compartimos los datos generales de levantamiento:</div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b>Fecha de elaboración:</b> {{$levantamiento->fecha_elaboracion}}</div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b>Dirección o área que elabora:</b> {{$levantamiento->direccion_elabora}}</div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b>Nombre de quien registra los datos:</b> {{$levantamiento->nombre_registra_datos}}</div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b>Cargo:</b> {{$levantamiento->cargo}}</div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b>Teléfono de contacto:</b> {{$levantamiento->tel_contacto}}</div>

                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b>Clave catastral:</b> {{$levantamiento->clave_catastral}}</div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b>Subsistema:</b> {{$levantamiento->subsistema_id}}</div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b>Elemento:</b> {{$levantamiento->elemento_id}}</div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b>Nombre equipamiento:</b> {{$levantamiento->nombre}}</div>
                        <div style="width:100%; margin-bottom: 0px; margin-top: 0px; display: block"><b>Latitud/Longitud:</b> {{$levantamiento->ubicacion_croquis_lat_lon}}</div>
                    </div> 
                </div>

            </div>
        
        </div>

        

                   
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
                    <td class="x_font" valign="middle" align="initial" style="border:none; margin:0px; padding:0px; font-weight:400; text-decoration:none; letter-spacing:0.15px; color:rgb(136,137,140); font-size:11px; line-height:1.65em; text-align:initial">Favor de no responder este correo.</td>
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
        

    </div>    
    
    

              
    </body>
</html>

