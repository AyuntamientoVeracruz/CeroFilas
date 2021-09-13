<!DOCTYPE html>
<html>
<head>
    <title>Reseteando Password</title>
</head>

<body>

<div style="width:100%; background:#fff; padding:0px; color:#333; font-family:Arial,'Century Gothic',Tahoma; margin-bottom:10px; font-size:12px;max-width:647px; margin:0 auto">								
								    
    <div>
        <h1 style="font-size:18px">Hola {{$user['NOMBRE']}}!</h1>        
        <p style="font-size:13px">Bienvenido de vuelta. Hemos creado un nuevo password asociado a este correo electrónico.</p>
        <br><br>
        <center><b style="font-size:20px">{{$newpass}}</b></center>
        <br><br>
        <center><a href="{{route('login', app()->getLocale())}}" style="border-radius:4px; color:#333; display:inline-block; text-decoration:none; background-color:#F1C81E; border-top:10px solid #F1C81E; border-right:18px solid #F1C81E; border-bottom:10px solid #F1C81E; border-left:18px solid #F1C81E; font-size:13px">Ingresar al sistema</a></center>
        <br>
        <p style="font-size:13px">Por favor haz click en el link para entrar, e ingresa tu mail y nuevo password de acceso. A partir de ahora este es tu nuevo password. Una vez que ingreses, puedes cambiar tu password en tu perfil.</p>  
    </div>
    
    <p style="border-top:1px solid #ccc; padding-top:10px; font-size:11px; color:#999999">Si estás teniendo problemas dando click en el botón de "Ingresar al sistema", copia y pega la URL a continuación en tu navegador web: {{route('login', app()->getLocale())}}</p> 
</div>

</body>

</html>
