<!DOCTYPE html>
<html>
<head>
    <title>Solicitando valoración</title>
</head>

<body>

<div style="width:100%; background:#fff; padding:0px; color:#333; font-family:Arial,'Century Gothic',Tahoma; margin-bottom:10px; font-size:12px;max-width:647px; margin:0 auto">								
								    
    <div>
        <h1 style="font-size:18px">Hola {{$turno->nombre_ciudadano}}!</h1>        
        <p style="font-size:13px">Con base a tu visita del <b>{{$turno->fechahora_inicio}}</b> para el trámite <b>"{{$turno->nombre_tramite}}"</b>, para mejorar nuestro servicio de atención, te solicitamos evalues al asesor <b>{{$turno->nombre}}</b> en el siguiente enlace.</p>        
        <br>
        <center><a href="{{route('valoracionindex', app()->getLocale())}}/{{$foliovaloracion}}" style="border-radius:4px; color:#333; display:inline-block; text-decoration:none; background-color:#F1C81E; border-top:10px solid #F1C81E; border-right:18px solid #F1C81E; border-bottom:10px solid #F1C81E; border-left:18px solid #F1C81E; font-size:13px">Evaluar</a></center>
        <br>
        <p style="font-size:13px">Por favor haz click en el link para evaluar.</p>  
    </div>
    
    <p style="border-top:1px solid #ccc; padding-top:10px; font-size:11px; color:#999999">Si estás teniendo problemas dando click en el botón de "Evaluar", copia y pega la URL a continuación en tu navegador web: {{route('valoracionindex',app()->getLocale())}}/{{$foliovaloracion}}</p> 
</div>

</body>

</html>
