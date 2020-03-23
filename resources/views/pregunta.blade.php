@extends('layouts.appcoronavirus')

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
        body form .inputfield label,
        .select2-container--default .select2-selection--single .select2-selection__placeholder{color:#999!important;}
    </style>
@endsection

@section('initlink')
<h2>Preguntas</h2>
<a href="https://www.veracruzmunicipio.gob.mx/acciones-coronavirus" class="small">Regresar a sitio de acciones contra coronavirus</a>
@endsection

@section('titlebig')
@if($tipo=="show")
<h5>Editando</h5>
<h1>Pregunta {{$pregunta->id_pregunta}}</h1>
@else
<h5>Captura de</h5>
<h1>Pregunta</h1>
@endif
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


            
            <form class="mt-45" id="form" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                @csrf
                <div class="main-primary col-sm-8 col-md-8 col-xs-12 br-5 p15 mb-30 col-sm-offset-2">
                    <h3 class="header3">Bienvenido a la @if($tipo=="show") edición @else captura @endif de pregunta @if($tipo=="show") {{$pregunta->id_pregunta}} @endif</h3>                    
                    
                    <p class="descriptionsection">Por favor llene todos los campos marcados <mark></mark> para poder brindar un mejor servicio.</p>
                     
                    

                    <label class="titlesection"><b>1</b><span>Datos generales</span></label> 
                    
                    
                    <div class="inputfield">                        
                        <input type="number" class="texto" min="1" required name="orden" />
                        <label>Orden <mark></mark></label>
                    </div>
                    
                    <div class="inputfield">                        
                        <textarea type="text" class="texto"  minlength="2" required name="pregunta" rows="2"></textarea>
                        <label>Pregunta <mark></mark></label>
                    </div> 
                    <div class="inputfield">                        
                        <textarea type="text" class="texto"  minlength="2"  name="respuesta" required rows="10"></textarea>
                        <label>Respuesta<mark></mark></label>
                    </div> 
                    
                    
                    
                    @if($tipo=="tosave")
                        <input type="hidden" name="typepost" value="save" /> 
                    @else 
                        <input type="hidden" name="typepost" value="edit"/> 
                        <input type="hidden" name="id_pregunta" value="{{$pregunta->id_pregunta}}"/> 
                    @endif

                    <!--<span class="etiqueta"><b class="notavailable"></b> Los campos marcados son obligatorios.</span>-->
                    <input type="submit" class="btn btn-primary submit" value="Confirmar">
                </div>
            </form> 
            
                    
        </div>
    </div>
@endsection

@section('page-js-script')
    
  <!--maps-->
  
      
  <script>
    
    $(document).ready(function(){
      
      $(".loading-main").fadeOut();

      @if($tipo=="show")
        $("[name='orden']").val('{!!$pregunta->orden!!}');
        $("[name='pregunta']").val('{!!$pregunta->pregunta!!}');
        $("[name='respuesta']").val('{!!$pregunta->respuesta!!}');
      @endif

      $('.tooltip').tooltipster({theme: 'tooltipster-noir'});
      $("select").select2({placeholder: "Seleccione un valor"});

      //click on label over input field
      $("body").on('click','.inputfield label', function(event) {
        $(this).parent().find("input,textarea").focus();
      });      

      /*****ALERT***/       
      //click alert message to close
      $("body").on('click','.responsemessage', function(){
          $this=$(this);
          $this.slideUp().removeClass("showed");
      });

      
      $("#form").on('submit', function(){
        var form = $('#form')[0];
        var data = new FormData(form);
        $.ajax({
            enctype: 'multipart/form-data',
            processData: false,  
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('preguntasave')}}", 
            type : "POST", 
            dataType : 'json', 
            contentType: false,
            cache: false,
            data : data,
            beforeSend: function(){ $(".loading-main").fadeIn(); },
            success : function(result) {                     
                $(".loading-main").fadeOut();
                if(result.error=="true"){
                    $(".responsemessage").addClass("errorresponse");
                }else{  
                    $(".responsemessage").removeClass("errorresponse");
                }
                $('#form').trigger("reset");
                @if($tipo=="tosave")
                $(".responsemessage").addClass("showed").html(result.description).slideDown(); 
                @else 
                    $(".responsemessage").addClass("showed").html(result.description).slideDown(1000,function(){
                        if(result.error!="true"){
                            location.reload();
                        }
                    }); 
                @endif             
            },
            error: function(xhr, resp, text) {
                var error = xhr.responseJSON.message.slice(0, 75);
                var linea = xhr.responseJSON.line;

                $(".loading-main").fadeOut();
                $(".responsemessage").addClass("errorresponse");
                $(".responsemessage").addClass("showed").html("Ocurrió un error guardando la pregunta: "+error+". Línea: "+linea).slideDown();
            }
        });
        return false;
      });

      


    });

    

  </script>
@endsection

