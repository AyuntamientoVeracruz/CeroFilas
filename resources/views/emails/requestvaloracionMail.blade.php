<!DOCTYPE html>
<html>
<head>
    <title>{{ __('titleRequesting') }}</title>
</head>

<body>

<div style="width:100%; background:#fff; padding:0px; color:#333; font-family:Arial,'Century Gothic',Tahoma; margin-bottom:10px; font-size:12px;max-width:647px; margin:0 auto">								
								    
    <div>
        <h1 style="font-size:18px">{{ __('Hello ') }} {{$turno->nombre_ciudadano}}!</h1>        
        <p style="font-size:13px">{{ __('lblRequesting1') }} <b>{{$turno->fechahora_inicio}}</b> {{ __('lblRequesting2') }} <b>"{{$turno->nombre_tramite}}"</b>, {{ __('lblRequesting3') }}  <b>{{$turno->nombre}}</b>  {{ __('lblRequesting4') }}</p>        
        <br>
        <center><a href="{{route('valoracionindex', app()->getLocale())}}/{{$foliovaloracion}}" style="border-radius:4px; color:#333; display:inline-block; text-decoration:none; background-color:#F1C81E; border-top:10px solid #F1C81E; border-right:18px solid #F1C81E; border-bottom:10px solid #F1C81E; border-left:18px solid #F1C81E; font-size:13px">{{ __('lblRequesting5') }}</a></center>
        <br>
        <p style="font-size:13px">{{ __('lblRequesting6') }}</p>  
    </div>
    
    <p style="border-top:1px solid #ccc; padding-top:10px; font-size:11px; color:#999999">{{ __('lblRequesting7') }}: {{route('valoracionindex',app()->getLocale())}}/{{$foliovaloracion}}</p> 
</div>

</body>

</html>
