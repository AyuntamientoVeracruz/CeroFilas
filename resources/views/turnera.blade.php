@extends('layouts.kiosk')

@section('page-style-files')
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <!--main booking-->
    <link rel="stylesheet" href="{{url('/css/app.css')}}" type="text/css" media="all">
    <style type="text/css">
        .sincitavisor close,.concitavisor label close{ right:auto; left:10px}
        .concitavisor label search{ left:auto; right:10px}
        .sincitavisor close i,.concitavisor label close i,.concitavisor label search i{ margin-bottom: 20px; font-size: 40px }
        .sincitavisor close k,.concitavisor label close k,.concitavisor label search k{ line-height: 20px; font-size: 14px; color:#fff; position: absolute; left: 0px; width: 100%; text-align: center; bottom:5px;}
        .fullscreencontainer{ background: #212F4D }
        em{ color:#E0B54B; font-style: normal; }
        label em{color:#000;}
        .fullscreen{ background-image:url({{url('/images/bg-turnera.jpg')}}); background-position:bottom left -30%; background-repeat: no-repeat; background-size:auto 85%}
        .marqueecontainer{background:#151E31; position: fixed; height:55px; width: 100%; left: 0px; bottom:0px}
            #marquee{ color: #fff; line-height: 55px; height: 55px;  font-size: 17px;overflow:hidden;white-space: nowrap}
        .turneracontainer{ position: fixed; width: calc(100% - 80px); height: calc(100% - 55px - 100px); left: 0px; top: 0px; margin:40px}
        .topcontent{ width: 100%; float: left; height: 27%}
            .topleftcontent{width: calc(50% - 40px); float: left; text-align: center; height: 100%;
              display: flex;
              align-items: center;
              flex-direction: column;
              justify-content: center;}
                .topleftcontent img{ width: 100%; max-width: 500px}
                .topleftcontent span{color:#fff; text-transform: uppercase; font-size: 12px; padding-left: 49%; margin-top: -15px; text-align: left; width: 100%}
            .toprightcontent{width: 50%;float: right; height: 100%; position: relative}
                .toprightcontent:before{ width: 100%; position: absolute; left: 0px; bottom:0px; border-radius:10px; background: rgba(0,0,0,0.3); content: ""; 
                height: calc(100% - 40px)}    
                .toprightcontent span{ font-size: 20px; line-height: 40px; position: absolute; color: #FCC50B; font-weight: bold; text-transform:uppercase; top: 0px}
                    .toprightcontent span.spanright{ right: 0px }
                .turno{ width: 100%; float: left; height: 100%; border-radius:10px; padding: 15px;}
                    .nombreturno{width:75%; float: left; display: flex;align-items: center;justify-content: center; color: #212F4D; text-align: center; height: 100%;
                        padding-right: 15px}
                    .ventanillaturno{ width:25%; border-radius:10px; font-weight:bold; line-height: 100%; height: 100%;  float: right;
                    display: flex;align-items: center;justify-content: center; font-size: 7.5vmin}
                    .turnoactual{background: #FCC50B url({{url('/images/bg-turno.png')}});
                    background-position:bottom left -10%; background-repeat: no-repeat; background-size:auto 110%;
                    height: calc(100% - 40px); margin-top: 40px}
                        .turnoactual .ventanillaturno{ background: #fff; color:#212F4D}
                        .turnoactual .nombreturno em{ font-size: 4.8vmin; line-height: 5.7vmin; overflow: hidden;text-overflow: ellipsis; display: -webkit-box;-webkit-box-orient: vertical;
                        -webkit-line-clamp: 2; overflow: hidden;color: #212F4D; white-space: all}

                    .turnoanterior{background: #fff; height: calc(25% - 20px); margin-top: 20px} 
                        .turnoanterior .ventanillaturno{ background: #212F4D; color:#fff; font-size: 5.5vmin}
                        .turnoanterior .nombreturno em{ font-size: 3.5vmin; line-height: 4.2vmin; overflow: hidden;text-overflow: ellipsis; display: -webkit-box;-webkit-box-orient: vertical;
                        -webkit-line-clamp: 2; overflow: hidden;color: #212F4D; white-space: all}   

        .bottomcontent{ width: 100%; float: left; height: 73%; margin-top: 0px}
            .bottomleftcontent{width: calc(60% - 40px); float: left; margin-top: 40px; height: calc(100% - 20px)}
                .bottomleftcontent div{ width: 100%; height: 100%; background: rgba(0,0,0,0.6); float: left; border-radius:10px;overflow: hidden }
            .bottomrightcontent{width: 40%;float: right; height: 100%; position: relative; margin-top: 20px}
                .bottomrightcontent span{ font-size: 15px; line-height: 20px; position: absolute; color: rgba(255,255,255,0.4); font-weight: bold; text-transform:uppercase; top: -10px}
                    .bottomrightcontent span.spanright{ right: 0px }
        .turnoactualcontainer,.turnoanteriorcontainer{ width: 100%; float: left; height: 100%; opacity:0; margin-top: 15px; position: relative; z-index: 1}
            .turnoanteriorcontainer-copy{ width: 100%; height: 100%; position: absolute; left: 0px; bottom:0px;}
            .turnoactualcontainer{transition: 0.25s}
            .turnoanteriorcontainer{transition: 0.35s}

                .bottomrightcontent:before{ width: 100%; position: absolute; left: 0px; bottom:0px; border-radius:10px; background: rgba(0,0,0,0.3); content: ""; 
                height: calc(25% - 20px)} 
                .bottomrightcontent:after{ width: 100%; position: absolute; left: 0px; bottom:calc(25%); border-radius:10px; background: rgba(0,0,0,0.3); content: ""; 
                height: calc(25% - 20px)} 
                .turnoanteriorcontainer-copy:before{ width: 100%; position: absolute; left: 0px; bottom:50%; border-radius:10px; background: rgba(0,0,0,0.3); content: ""; 
                height: calc(25% - 20px)} 
                 .turnoanteriorcontainer-copy:after{ width: 100%; position: absolute; left: 0px; bottom:75%; border-radius:10px; background: rgba(0,0,0,0.3); content: ""; 
                height: calc(25% - 20px)} 

                .turnoactualcontainer.showed,.turnoanteriorcontainer.showed{ margin-top: 0px; opacity:1; }
            #myVideo{ width: 100%; height: 100%; float: left; outline: none; border-radius:10px; overflow: hidden}


    </style>

    
    
@endsection

@section('content')
    
    <div class="turneracontainer">

        <div class="topcontent">
            <div class="topleftcontent">
                <img src="{{url('/images/logo-transparent.png')}}">
                <span>{{$oOficina->nombre_oficina}}</span>
            </div>
            <div class="toprightcontent">
                <span class="spanleft">Turno actual</span>
                <span class="spanright">Ventanilla</span>
                <div class="turnoactualcontainer"></div>
            </div>            
        </div>
        <div class="bottomcontent">
            <div class="bottomleftcontent">
                
                <div>
                    
                    <video id="myVideo" >
                    </video>

                </div>

            </div>
            <div class="bottomrightcontent">
                <span class="spanleft">Turnos anteriores</span>
                <span class="spanright">Ventanilla</span>
                <div class="turnoanteriorcontainer"></div> 
                <div class="turnoanteriorcontainer-copy"></div>                  
            </div>
        </div>
    </div>
    

      

    <div class="marqueecontainer">
        <span id="marquee"></span>
    </div>
@endsection

@section('page-js-script')
    <script>

        var videoSource = new Array();
        /*videoSource[0]='videos/policia-municipal.mp4';
        videoSource[1]='videos/miercoles-ciudadano.mp4';
        videoSource[2]='videos/predial-linea.mp4';*/
        @if($videos->count()>0)
            @php 
                $k=0;
            @endphp
            @foreach($videos as $video)
                videoSource[{{$k}}]='{{$video->urlvideo}}';
                @php 
                    $k++;
                @endphp
            @endforeach
            var videoCount = videoSource.length;
            var k=0;
            document.getElementById("myVideo").setAttribute("src",videoSource[0]);                    
            function videoPlay(videoNum)
            {
                document.getElementById("myVideo").setAttribute("src",videoSource[videoNum]);
                document.getElementById("myVideo").load();
                document.getElementById("myVideo").play();
            }
            document.getElementById('myVideo').addEventListener('ended',myHandler,false);
            function myHandler() {
                k++;
                if(k == videoCount){
                    k = 0;
                    videoPlay(k);
                }
                else{
                    videoPlay(k);
                }
            }      
        @endif
        
        @if($marquesinas->count()>0)
            var textomarquesina="";
            @foreach($marquesinas as $marquesina)
                textomarquesina = textomarquesina + "{{$marquesina->textomarquesina}}" + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            @endforeach
            document.getElementById("marquee").innerHTML = textomarquesina;
        @endif

        window.addEventListener('load', function () {
            function go() {
                i = i < width ? i + step : 1;
                m.style.marginLeft = -i + 'px';
            }
            var i = 0,
                step = 3,
                space = '';
            var m = document.getElementById('marquee');
            var t = m.innerHTML; //text
            m.innerHTML = t + space;
            m.style.position = 'absolute'; // http://stackoverflow.com/questions/2057682/determine-pixel-length-of-string-in-javascript-jquery/2057789#2057789
            var width = (m.clientWidth + 1);
            m.style.position = '';
            m.innerHTML = t + space + t + space + t + space + t + space + t + space + t + space + t + space;
            m.addEventListener('mouseenter', function () {
                step = 0;
            }, true);
            m.addEventListener('mouseleave', function () {
                step = 3;
            }, true);
            var x = setInterval(go, 80);
        }, true);
    </script>
    <script type="text/javascript">
        var sonidonotificacion="{{url('/sis/mp3/notificacion.mp3')}}";
        var turnos=[];
        $(document).ready(function() {
            

            $("#myVideo").click(function(){
                @if($videos->count()>0)
                    document.getElementById("myVideo").play();
                @endif
                getAssignment(); 
            });


            $(".loading-main").fadeOut();
            //get assignment from office
            function startgetassignment() {
              getassignment = setInterval(getAssignment, 1000 * 5 * 1); // every 5 seconds
            }
            //start at beginning
            
            startgetassignment();

            //function to get assignment from tramitador
            function getAssignment() {  

                $.ajax({
                    url: "{{route('getassignmentsfromoffice', app()->getLocale())}}",
                    type: 'get',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function(result) { 
                        $(".loading-main").fadeOut();
                        if(result.error=="true"){
                            
                        }
                        else{
                            //if(result.asignacion.enproceso=="si"){
                                if(result.asignacion.turnos.length>0){
                                    if(JSON.stringify(result.asignacion.turnos)!=JSON.stringify(turnos)){           

                                        $(".turnoactualcontainer").html("");   
                                        $(".turnoanteriorcontainer").html("");                                                        

                                        turnos = result.asignacion.turnos;                                   
                                        let audio = new Audio(sonidonotificacion);
                                        audio.play();
                                        var turnoactual="";
                                        var turnoanterior="";
                                        for(i=0;i<result.asignacion.turnos.length;i++){
                                            if(i==0){
                                                turnoactual = '<div class="turno turnoactual">';
                                                turnoactual +='<p class="nombreturno"><em>'+result.asignacion.turnos[i].nombre_ciudadano+'</em></p>';
                                                turnoactual +='<p class="ventanillaturno">'+result.asignacion.turnos[i].ventanilla+'</p>';    
                                                turnoactual +='</div>';                                            
                                            }
                                            else{
                                                turnoanterior += '<div class="turno turnoanterior">';
                                                turnoanterior +='<p class="nombreturno"><em>'+result.asignacion.turnos[i].nombre_ciudadano+'</em></p>';
                                                turnoanterior +='<p class="ventanillaturno">'+result.asignacion.turnos[i].ventanilla+'</p>';    
                                                turnoanterior +='</div>';
                                            }
                                        }
                                        $(".turnoactualcontainer").html(turnoactual);                                                                    
                                        $(".turnoanteriorcontainer").html(turnoanterior);

                                        $(".turnoactualcontainer").removeClass("showed").delay(100).queue(function(){
                                            $(this).addClass("showed").dequeue();
                                        }); 
                                        $(".turnoanteriorcontainer").removeClass("showed").delay(150).queue(function(){
                                            $(this).addClass("showed").dequeue();
                                        });    

                                        //$(".turnoactualcontainer,.turnoanteriorcontainer").addClass("showed");  
                                    }   
                                }  
                                else{
                                    $(".turnoactualcontainer").removeClass("showed"); 
                                    $(".turnoanteriorcontainer").removeClass("showed");    
                                }                                                              
                                
                            //}
                        }
                    },
                    error: function(xhr, resp, text) {  
                        $(".loading-main").fadeOut();              
                    }    
                });
                
            }

        });
    </script>
    
@endsection

