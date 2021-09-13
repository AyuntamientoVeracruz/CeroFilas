@extends('layouts.app')

@section('page-style-files')
    <!--main booking-->
    <link rel="stylesheet" href="{{url('/css/app.css')}}" type="text/css" media="all">
    <style type="text/css">
        .p15{width: 100%; float: left}
        .main-left{ width: calc(58.3333% - 20px) }
        quote{ background: none; color: #222; padding:0px; }
            quote b,quote a{color:#337ab7!important}
        .titlesection b i{ line-height: 30px }
        .etiqueta{margin-top: 0px; margin-bottom: 0px}
        .main-left .descriptionsection{ margin-bottom: 0px }
        .wrappercontainer{
            height: calc(100vh - 380px - 110px);
            min-height: 270px;
        }
       
        @media only screen and (max-width: 992px){
            .main-left,.main-right{ width: 100% }
            .wrappercontainer{ height: auto }
        }        
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
<a href="https://www.veracruzmunicipio.gob.mx" class="small">{{ __('btn1') }}</a>
@endsection

@section('titlebig')
<h5>Programa tu cita, gana tiempo y disfruta tu día</h5>
<h1>Bienvenido a Cero Filas</h1>
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

            <form id="cita-form" method="post" action="{{route('getcita', app()->getLocale())}}">

                <div class="main-left col-sm-7 col-md-7 col-xs-12 br-5 p15 mb-30">
                    <h3 class="header3">Crea tu cita</h3>
                    
                    <quote>Antes de empezar, ten a la mano tu <b>CURP</b>, ya que es necesario para el registro, tiene un tiempo límite de 5 minutos para completarlo. Si no lo tienes, <a href="https://www.gob.mx/curp/" target="_blank" rel="noopener noreferrer">encuéntralo aquí.</a></quote>

                    <label class="titlesection" style="margin-bottom: 0px"><b><i class="far fa-id-card"></i></b><span>¿Ya tienes tu CURP a la mano?</span></label>
                                        
                    <a class="btn btn-primary submit" href="{{route('crearcita', app()->getLocale())}}">Registrar cita</a>    
                    
                    <quote style="margin-bottom: 6px; margin-top: 20px"><b>¿Tienes dudas para registrar tu cita?.</b> Ponemos a tu disposición la <a href="{{url('/pdf/guia-de-usuario.pdf')}}" target="_blank">Guía de usuario</a> para registrar tu cita.</quote>        

                </div>

                <div class="anchor"></div>
                <div class="main-right col-sm-5 col-md-5 col-xs-12 br-5 mb-30 ">
                    <h3 class="header3">Consulta o cancela tu cita</h3>

                    <div class="p15">

                        <label class="titlesection"><b><i class="fa fa-search"></i></b><span>Buscar por folio</span></label>
                        <p class="descriptionsection">Escribe el folio de tu cita para poder consultarla.</p>    
                        @csrf
                        <div class="inputfield">
                            <input type="text" class="texto" id="folio" required="" autocomplete="off" name="folio" minlength="8" maxlength="8">
                            <label>Folio <mark></mark></label>
                        </div>
                        
                        <span class="etiqueta"><b class="notavailable"></b> 
                        @if($errors->any())
                        <k style="color:#cc0000">{{$errors->first()}}</k>
                        @else
                        Campo obligatorio para consulta.
                        @endif
                        </span>

                        <input type="submit" class="btn btn-primary submit" value="Consultar/Cancelar cita">    

                    </div>

                </div>

            </form> 
                    
        </div>
    </div>
@endsection

@section('page-js-script')
    
    <script>
    $(document).ready(function(){
      $(".loading-main").fadeOut();
      //click on label over input field
      $(".inputfield label").on('click', function(event) {
        $(this).parent().find("input,textarea").focus();
      });
    });
    </script>
    
@endsection

