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
<h2>Pagos por kiosko</h2>
<a href="https://www.veracruzmunicipio.gob.mx" class="small">Regresar a sitio del municipio</a>
@endsection

@section('titlebig')
<h5>Listado de</h5>
<h1>Pagos por Kiosko</h1>
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

            
            <form class="mt-45" id="levantamiento-form" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                
                <div class="main-primary col-sm-10 col-md-10 col-xs-12 br-5 p15 mb-30 col-sm-offset-1">
                    <h3 class="header3">Bienvenido al listado de pagos por kiosko!</h3>                    
                    
                    @if ($pagos->count())                    
                        <a href="{{route('descargarpagoskiosko')}}" class="btn btn-primary btn-block">Descargar CSV de pagos</a>

                        <table class="table table-responsive" style="margin-top: 20px">
                            <thead>
                                <th>Fecha</th>
                                <th>Estatus</th>
                                <th>ControlNumber</th>
                                <th>Autorización</th>
                                <th>Clave catastral</th>
                                <th>Nombre</th>
                                <th class="text-right">Monto (MXN)</th>
                                <th>Modo</th>
                            </thead>    
                        @foreach($pagos as $pago)
                            <tr>
                                <td>{{$pago->created_at}}</td>
                                <td alt="{{$pago->error_mensaje}}" title="{{$pago->error_mensaje}}">{{$pago->status}}</td>
                                <td>{{$pago->control_number}}</td>
                                <td>{{$pago->codigo_autorizacion}}</td>
                                <td>{{$pago->clave_catastral}}</td>
                                <td>{{$pago->nombre}}</td>
                                <td class="text-right">${{$pago->monto}}</td>
                                <td>{{$pago->modo}}</td>
                            </tr>    
                        @endforeach
                        </table>

                    @else
                        <center>Sin pagos</center>
                    @endif


                    
                </div>
            </form> 
            
                    
        </div>
    </div>
@endsection

@section('page-js-script')
  <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5e150ac87e39ea1242a38769/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->    
  <script>
    
    $(document).ready(function(){
      //window.print();
      $(".loading-main").fadeOut();

      $('.tooltip').tooltipster({theme: 'tooltipster-noir'});
    
    });

  </script>
@endsection

