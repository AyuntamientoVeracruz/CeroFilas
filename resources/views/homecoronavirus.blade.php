@extends('layouts.appcoronavirus')

@section('page-style-files')
    <!--main booking-->
    <link rel="stylesheet" href="{{url('/css/app.css')}}" type="text/css" media="all">
    <style type="text/css">
        
        .p15{width: 100%; float: left}
        .main-left{ width: calc(65.3333% - 20px) }
        
        .main-right{ width: calc(36.6666% - 20px) }
        
        quote{ background: none; color: #222; padding:0px; }
            quote b,quote a{color:#337ab7!important}
        .titlesection b i{ line-height: 30px }
        .etiqueta{margin-top: 0px; margin-bottom: 0px}
        .main-left .descriptionsection{ margin-bottom: 0px }
        .wrappercontainer{
            height: auto;
            min-height: 270px;
        }
       
        @media only screen and (max-width: 992px){
            .main-left,.main-right{ width: 100% }
            .wrappercontainer{ height: auto }
        } 
        
        table td, dd {
            padding: 12px;
            vertical-align: top;
            line-height: 1 !important;border:0 !important;
        }
        table, dl {
            border: 1px solid rgba(153,153,153,.2);
            width: 100%;
            margin: 0 0 30px;
            padding: 0;
            border-collapse: collapse;
            border:0 !important;
        }
        table img {
            max-width: 100%;
            height: auto;
            display: block;
        }
        .question{ float:left; width:100%; margin-top:10px;}
        .panel-heading{ padding-left:0px; padding-right:0px; border-top:1px solid #ccc; padding-top:20px;}
        .panel-title {
            font-size: 22px;
            font-family: 'NeoSans' !important;
            color: #2A324F; font-weight:700; padding:0px; padding-right:50px; line-height:28px;
        }
        .panel-subtitle{font-size: 18px;
            font-family: 'NeoSans' !important;
            color: #2A324F; font-weight:700; padding:0px; line-height:24px; margin-top:20px; margin-bottom:5px;}
        .panel-heading span{ cursor:pointer; padding-right:10px;}
        .myVideo{ width:100%; float:left; margin-top:0px; margin-bottom:30px;}
        
    </style>
@endsection

@section('initlink')
<h2>Inicio</h2>
<a href="https://www.veracruzmunicipio.gob.mx" class="small">Regresar a sitio de Veracruz Municipio</a>
@endsection

@section('titlebig')

<h5>Acciones vs</h5>
<h1>Coronavirus</h1>

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
                    <h3 class="header3">Información, recomendaciones y medidas de prevención</h3>
                    
                    <quote>El DNU 297/2020 establece el aislamiento social, preventivo y obligatorio hasta el 31 de marzo de 2020 para todas las personas que se encuentren en el país.</quote>
                    
                    <!--<quote style="margin-bottom: 6px; margin-top: 20px"><b>¿Aliquam sed lectus quam?.</b> PonemosMauris tincidunt, arcu ut convallis <a href="#" target="_blank">Link de enlace</a> condimentum sodales.</quote>-->        
                    
                    <h3 class="panel-subtitle">Medidas adicionales por la pandemia de COVID-19</h3>
                    <video class="myVideo" src="../videos/covid19_fernando.mp4" controls></video>
                    
                    <h3 class="panel-subtitle">Medidas adoptadas por el Covid-19</h3>
                    <video class="myVideo" src="../videos/covid19_fernando2.mp4" controls></video>
                    
                    @if($preguntas->count()>0)
                        @foreach($preguntas as $pregunta)
                            
                            <div class="question">
                                <div class="panel-heading">
                                    <h3 class="panel-title">{!!$pregunta->pregunta!!}</h3>
                                    <span style="margin-top: -30px;" class="pull-right"><i class="fa fa-chevron-up"></i></span>
                                </div>
                                <div class="panel-body">
                                    {!!$pregunta->respuesta!!}
                                </div>
                            </div>
                        @endforeach
                    @else
                    <span style="margin-top: 40px; margin-bottom: 40px; width: 100%; float: left"><center>- Sin preguntas creados -</center></span>    
                    @endif
                    
                    
                </div>

                <div class="anchor"></div>
                <div class="main-right col-sm-5 col-md-5 col-xs-12 br-5 mb-30 ">
                    <h3 class="header3">¿Aún tienes dudas?</h3>

                    <div class="p15">

                        <div class="menu-enlaces-container">
                        
                            <div class="table-responsive-xl">
                              <table style="    font-size: 13px;" class="table">
                                <tbody><tr>
                                    <td style="display: block;width: 45px;position: relative;margin-left: -10px;"><img alt="Ayuntamiento de veracruz" src="https://www.veracruzmunicipio.gob.mx/wp-content/themes/gob_ver2019/images/cuatro.png"></td>
                                    <td style="padding-left: 0px;">(229) 200 22 73 </td>
                                </tr>
                                <tr>
                                    <td style="display: block;width: 45px;position: relative;margin-left: -10px;"><img alt="Ayuntamiento de veracruz" src="https://www.veracruzmunicipio.gob.mx/wp-content/themes/gob_ver2019/images/cinco.png"></td>
                                    <td style="padding-left: 0px;">proteccivil@veracruzmunicipio.gob.mx</td>
                                </tr>
                                <tr>
                                    <td style="display: block;width: 45px;position: relative;margin-left: -10px;"><img alt="Ayuntamiento de veracruz" src="https://www.veracruzmunicipio.gob.mx/wp-content/themes/gob_ver2019/images/seis.png"></td>
                                    <td style="padding-left: 0px;">Dirección de Protección Civil<br><span style="font-size: 10px;"><i>Palacio Municipal, Av. Ignacio Zaragoza S/N entre Miguel Lerdo de Tejada y Gutierrez Zamora, Col. Centro, C.P. 91700</i></span></td>
                                </tr>
                              </tbody></table>
                            </div>
                            
                        </div>   

                    </div>
                    
                    <div style="height:600px;overflow-y: auto;margin-top:0px; padding-top:20px; border-top:1px solid #ccc; float:left; margin-left:15px;
                    margin-bottom:15px">
                    <a class="twitter-timeline" href="https://twitter.com/AyuntamientoVer?ref_src=twsrc%5Etfw">Tweets by AyuntamientoVer</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
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

      
      $(".panel-body").slideUp();
      $(".panel-heading").find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
      $(".panel-heading").addClass("collapsed");
      
      $(document).on('click', '.panel-heading span', function(e){
          if($(this).closest('.panel-heading').hasClass("collapsed")){
            $(this).closest('.panel-heading').removeClass("collapsed"); 
            $(this).closest(".question").find(".panel-body").slideDown();
            $(this).find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
          }
          else{
            $(this).closest('.panel-heading').addClass("collapsed"); 
            $(this).closest(".question").find(".panel-body").slideUp();
            $(this).find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
          }
      });
    
    
    });

  </script>
@endsection

