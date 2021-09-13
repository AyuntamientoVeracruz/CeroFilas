@extends('layouts.app')

@section('page-style-files')
    <!--main booking-->
    <link rel="stylesheet" href="{{url('/css/app.css')}}" type="text/css" media="all">
    <style type="text/css">
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
<h5>Cerofilas</h5>
<h1>Evaluación</h1>
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

            @if($tipo=='show')
            <form class="mt-45" action="{{route('valoracionsave', app()->getLocale())}}" method="post">
                @csrf
                <div class="main-primary col-sm-8 col-md-8 col-xs-12 br-5 p15 mb-30 col-sm-offset-2">
                    <h3 class="header3">Hola {{$turno->nombre_ciudadano}}!</h3>                    
                    @if(isset($error))
                    <span class="errored">{{$error}}</span>
                    @endif
                    <p class="descriptionsection">Para seguir mejorando nuestro servicio, te pedimos evalues la atención brindada por el asesor <b>{{$turno->nombre}}</b> para el trámite <b>{{$turno->nombre_tramite}}</b> en la fecha y hora <b>{{$turno->fechahora_inicio}}</b>.</p>
                    <label class="titlesection" data-section="1"><b>1</b><span><mark></mark> ¿Cómo calificarías la atención?</span></label>
                    <span class="descriptionsection2">Una estrella representa la califación más baja y cinco estrellas la más alta.</span>  
                    <div class="stars">
                        <div class='starrr' id='star1'><input type="text" required id="star2_input" name="estrellas"></div>
                        <div>
                          <span class='your-choice-was'>
                            Tu calificación es de <span class='choice'></span>.
                          </span>
                        </div>
                    </div>
                    <label class="titlesection" data-section="2"><b>2</b><span><mark></mark> ¿El asesor te atendió de manera cordial?</span></label>
                    <div class="radio text-center">
                      <label style="margin-right: 30px"><input type="radio" name="pregunta1" required value="si">Sí</label>
                      <label><input type="radio" name="pregunta1" required value="no">No</label>
                    </div>
                    <label class="titlesection" data-section="3"><b>3</b><span><mark></mark> ¿El asesor pudo ayudarte con tu trámite?</span></label>
                    <div class="radio text-center">
                      <label style="margin-right: 30px"><input type="radio" name="pregunta2" required value="si">Sí</label>
                      <label><input type="radio" name="pregunta2" required value="no">No</label>
                    </div>
                    <label class="titlesection" data-section="4"><b>4</b><span>¿Deseas agregar comentarios adicionales?</span></label> 
                    <span class="descriptionsection2">Esta información es opcional.</span>      
                    <div class="inputfield">
                        <textarea class="texto capitalize" name="observaciones" rows="4" placeholder="Escribe aquí tus comentarios adicionales"></textarea>
                        <!--<label>Comentarios adicionales</label>-->
                    </div>                
                    <span class="etiqueta"><b class="notavailable"></b> Los campos marcados son obligatorios. Si no completas la información, no puedes guardar la evaluación.</span>
                    <input type="submit" class="btn btn-primary submit" value="Confirmar">
                </div>
            </form> 
            @endif
            @if($tipo=='saved')
            <div class="mt-45">
                
                <div class="main-primary col-sm-8 col-md-8 col-xs-12 br-5 p15 mb-30 col-sm-offset-2">
                    <h3 class="header3">Hola {{$turno->nombre_ciudadano}}!</h3>                                        
                    <p class="descriptionsection megaquote">Gracias por tu evaluación al asesor <b>{{$turno->nombre}}</b> para el trámite <b>{{$turno->nombre_tramite}}</b> en la fecha y hora <b>{{$turno->fechahora_inicio}}</b>.<br>Te mostramos los datos de la evaluación.</p>
                    <label class="titlesection" data-section="1"><b>1</b><span> ¿Cómo calificarías la atención?</span></label>
                    <span class="descriptionsection2">Una estrella representa la califación más baja y cinco estrellas la más alta.</span>    
                    <div class="stars withopaque">
                        <div class='starrr' id='star1'><input type="text" required id="star2_input" name="estrellas" value="{{$valoracion->estrellas}}"></div>
                        <div>
                          <span class='your-choice-was' style="display: block">
                            Tu calificación es de <span class='choice'>{{$valoracion->estrellas}}</span>.
                          </span>
                        </div>
                    </div>
                    <label class="titlesection" data-section="2"><b>2</b><span> ¿El asesor te atendió de manera cordial?</span></label>
                    <div class="radio text-center">
                      <label style="margin-right: 30px"><input type="radio" name="pregunta1" value="si" disabled="" @if($valoracion->respuesta1=='si') checked @endif>Si</label>
                      <label><input type="radio" name="pregunta1" value="no" disabled="" @if($valoracion->respuesta1=='no') checked @endif>No</label>
                    </div>
                    <label class="titlesection" data-section="3"><b>3</b><span> ¿El asesor pudo ayudarte con tu trámite?</span></label>
                    <div class="radio text-center">
                      <label style="margin-right: 30px"><input type="radio" name="pregunta2" value="si" disabled="" @if($valoracion->respuesta2=='si') checked @endif>Si</label>
                      <label><input type="radio" name="pregunta2" value="no" disabled="" @if($valoracion->respuesta2=='no') checked @endif>No</label>
                    </div>
                    <label class="titlesection" data-section="4"><b>4</b><span>¿Deseas agregar comentarios adicionales?</span></label> 
                    <span class="descriptionsection2">Esta información es opcional.</span>       
                    <div class="inputfield">
                        <textarea class="texto capitalize" name="observaciones" rows="4" placeholder="Escribe aquí tus comentarios adicionales" disabled="">{!! $valoracion->observaciones !!}</textarea>
                    </div>                
                    
                    
                </div>
            </div> 
            @endif
                    
        </div>
    </div>
@endsection

@section('page-js-script')
  <script>
    
    /*stars script*/
    var slice=[].slice;!function(t,n){var r;n.Starrr=r=function(){function n(n,r){var s;(this.options=t.extend({},this.defaults,r),this.$el=n,this.createStars(),this.syncRating(),this.options.readOnly)||(this.$el.on("mouseover.starrr","a",(s=this,function(t){return s.syncRating(s.getStars().index(t.currentTarget)+1)})),this.$el.on("mouseout.starrr",function(t){return function(){return t.syncRating()}}(this)),this.$el.on("click.starrr","a",function(t){return function(n){return n.preventDefault(),t.setRating(t.getStars().index(n.currentTarget)+1)}}(this)),this.$el.on("starrr:change",this.options.change))}return n.prototype.defaults={rating:void 0,max:5,readOnly:!1,emptyClass:"far fa-star",fullClass:"fa fa-star",change:function(t,n){}},n.prototype.getStars=function(){return this.$el.find("a")},n.prototype.createStars=function(){var t,n,r;for(r=[],t=1,n=this.options.max;1<=n?t<=n:t>=n;1<=n?t++:t--)r.push(this.$el.append("<a href='#' />"));return r},n.prototype.setRating=function(t){return this.options.rating===t&&(t=void 0),this.options.rating=t,this.syncRating(),this.$el.trigger("starrr:change",t)},n.prototype.getRating=function(){return this.options.rating},n.prototype.syncRating=function(t){var n,r,s,i,e;for(t||(t=this.options.rating),n=this.getStars(),e=[],r=s=1,i=this.options.max;1<=i?s<=i:s>=i;r=1<=i?++s:--s)e.push(n.eq(r-1).removeClass(t>=r?this.options.emptyClass:this.options.fullClass).addClass(t>=r?this.options.fullClass:this.options.emptyClass));return e},n}(),t.fn.extend({starrr:function(){var n,s;return s=arguments[0],n=2<=arguments.length?slice.call(arguments,1):[],this.each(function(){var i;if((i=t(this).data("starrr"))||t(this).data("starrr",i=new r(t(this),s)),"string"==typeof s)return i[s].apply(i,n)})}})}(window.jQuery,window);

    $(document).ready(function(){
      $(".loading-main").fadeOut();

      //click on label over input field
      $(".inputfield label").on('click', function(event) {
        $(this).parent().find("input,textarea").focus();
      });

      var $s2input = $('#star2_input');
      $('#star1').starrr({
          @if($tipo=='saved') rating: $s2input.val(), @endif  
          change: function(e, value){
            if (value) {
              $('.your-choice-was').show();
              $('.choice').text(value);
            } else {
              $('.your-choice-was').hide();
            }
            $s2input.val(value);
          }
        });

    });



  </script>
@endsection

