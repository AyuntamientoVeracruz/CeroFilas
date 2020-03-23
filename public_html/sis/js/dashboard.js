//variables de inicio de contador y otras
var startTime;
var timer;
//WEB READY
$(document).ready(function() {

    $("select").select2();
    
    //get assignment from tramitador
    function startgetassignment() {
      getassignment = setInterval(getAssignment, 1000 * 5 * 1); // every 5 seconds
    }
    //start at beginning
    startgetassignment();
    //function to get assignment from tramitador
    function getAssignment() {
        //si esta disponible, vamos a buscar
        if($("#availability").is(':checked')){
            $.ajax({
                url: getassignmenturl,
                type: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function(result) { 
					$(".loading-main").fadeOut();
                    if(result.error=="true"){
                        $(".responsemessage").addClass("errorresponse");
                        $(".responsemessage").addClass("showed").html(result.description).slideDown();
                    }
                    else{
                        if(result.asignacion.enproceso=="si"){
                            //showing divs with info
                            startTime=result.asignacion.turno.fechahora_inicio;
                            clearInterval(timer);

                            $("#form-response,#info-turno").removeClass("hide");
                            $("#info-empty").addClass("hide");
                            $('[data-summary="turno"]').find("b").html(result.asignacion.turno.folio);
                            $('[data-summary="tramite"]').find("p b").html(result.asignacion.tramite.nombre_tramite);
                            $('[data-summary="nombre"]').find("p b").html(result.asignacion.turno.nombre_ciudadano);
                            var hora=result.asignacion.turno.fechahora_inicio.split(" ");
                            $('[data-summary="hora"]').find("p b").html(hora[1]);
                            $('#curp').val(result.asignacion.turno.curp);
                            $('#email').val('');
                            $('#email').attr('readonly',false);
                            if(result.asignacion.cita){
                                if(result.asignacion.cita.email!=null){
                                    $('#email').val(result.asignacion.cita.email);
                                    $('#email').attr('readonly',true);
                                }
                            }
                            $('#turno').val(result.asignacion.turno.id_turno);
                            if(result.asignacion.cita){
                                $("#cita").html("Con cita");
                                $("#cita").attr("data-original-title","Folio "+result.asignacion.cita.folio);
                                moment.locale('es');
                                $fecha = moment(result.asignacion.cita.fechahora,'YYYY-MM-DD H:i:s').format('ddd, D MMM, YYYY @ H:mm');
                                $("#cita").attr("data-content","Fecha/hora: <b>"+$fecha+"</b><br>CURP: <b>"+result.asignacion.cita.curp+"</b>");
                                //$('[data-toggle="popover"]').popover({placement: 'top',html:false});
                            }
                            else{
                                $("#cita").html("Sin cita");
                            }                                              
                            //no seguir buscando asignaciones
                            clearInterval(getassignment);
                            //disable availability button
                            $(".mask").removeClass("hide");
                            let audio = new Audio(sonidonotificacion);
                            audio.play();
                            countdown();
                        }
                    }
                },
                error: function(xhr, resp, text) {  
					$(".loading-main").fadeOut();              
                    //$(".responsemessage").addClass("errorresponse");
                    //$(".responsemessage").addClass("showed").html("Ocurrió un error inesperado cargando asignación").slideDown();
                }    
            });
        }
    }
	if($("#availability").is(':checked')){
		$(".loading-main").fadeIn();
		getAssignment();
	}
	else{
		$(".loading-main").fadeOut();
	}

    //loader fadeout
    //$(".loading-main").fadeOut();
    /*****ALERT***/		
	//click alert message to close
	$("body").on('click','.responsemessage', function(){
		$this=$(this);
		$this.slideUp().removeClass("showed");
	});

	/*****DASHBOARD***/	
    //change disponibilidad
    $("#availability").click(function() {
    	$this=$(this);
		$.ajax({
        	headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            url: setavailabilityurl, 
            type : "POST", 
            data: $("#form-availability").serialize(),
            beforeSend: function(){ $(".loading-main").fadeIn(); },
            success : function(result) {            	     
				$(".loading-main").fadeOut();
				if(result.error=="true"){
					$(".responsemessage").addClass("errorresponse");
					$(".responsemessage").addClass("showed").html(result.description).slideDown();

                    if($this.is(':checked')){
                        $this.prop('checked', false);
                    }
                    else{
                        $this.prop('checked', true);
                    }
				}		
				else{										
					if(result.user.disponibleturno=="si"){
			    		$(".switchcontainer small").html("Disponible").addClass("blueish");
			    	}
			    	else{
			    		$(".switchcontainer small").html("No disponible").removeClass("blueish");
			    	}
				}													
            },
            error: function(xhr, resp, text) {
            	$(".loading-main").fadeOut();
            	$(".responsemessage").addClass("errorresponse");
				$(".responsemessage").addClass("showed").html("Ocurrió un error inesperado, intenta más tarde").slideDown();
            }
        });
    });

    //confirmar y pausar button
    $("#confirmarypausarbutton").click(function() {
        $("#confirmarypausar").val("si");
        if(!$('#form-response')[0].checkValidity()){
            $("#form-response")[0].reportValidity();
        }
        else{
            executeSave();
        }
    });

    //confirmar button
    $("#confirmarbutton").click(function() {
        $("#confirmarypausar").val("no");
        if(!$('#form-response')[0].checkValidity()){
            $("#form-response")[0].reportValidity();
        }
        else{
            executeSave();
        }
    });

    //click on view historial
    $("#historial").click(function() {

        $("select").wrap('<div class="containercombo"></div>');
        $("select").select2();
        $(".select2-container").css({"width":"100%","max-width":"100%","float":"right"});

        if($("#curp").val()!=""){
            $("#oficina").select2('val',oficina);
            gethistorial();
        }
        else{
            $(".responsemessage").addClass("errorresponse");
            $(".responsemessage").addClass("showed").html("Para ver historial es necesario indique el CURP.").slideDown();
            return false;
        }
    });


    //change oficina
    $("#oficina").change(function() {
        gethistorial();
    });

    //function to gethistorial
    function gethistorial(){
        $.ajax({
            url: gethistorialurl+"/"+$("#curp").val()+"/"+$("#oficina").val(),
            type: 'get',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(){ $(".loading-main").fadeIn(); $("#myModal").find(".modal-body .historial").html("<br><center>Cargando...</center><br>");   },
            success : function(result) {
                $(".loading-main").fadeOut();
                $("#myModal").find(".modal-body .historial").html("");   
                if(result.error=="true"){
                    $(".responsemessage").addClass("errorresponse");
                    $(".responsemessage").addClass("showed").html(result.description).slideDown();
                }
                else{
                    if(result.historico.length==0){
                        $("#myModal").find(".modal-body .historial").html("<br><center>Este CURP no cuenta con historial para esta oficina</center><br>");        
                    }   
                    else{                                
                        for(i=0;i<result.historico.length;i++){
                            var historico = '<div class="summarycontainer"><div class="summary">';
                                historico +='   <div class="image"><i class="far fa-file-alt"></i></div>';
                                historico +='    <p class="text sel-service">Trámite: <b>'+result.historico[i].nombre_tramite+'</b></p>';
                                historico +='</div>';
                                historico +='<div class="summary" >';
                                historico +='   <div class="image"><i class="far fa-user"></i></div>';
                                historico +='   <p class="text sel-service">Tramitador: <b>'+result.historico[i].nombre+'</b></p>';
                                historico +='</div>';
                                historico +='<div class="summary">';
                                historico +='   <div class="image"><i class="far fa-clock"></i></div>';
                                moment.locale('es');
                                $fecha = moment(result.historico[i].fechahora_inicio,'YYYY-MM-DD H:i:s').format('ddd, D MMMM, YYYY @ H:mm:ss');
                                historico +='   <p class="text sel-service">Fecha/Hora: <b>'+$fecha+'</b></p>';
                                historico +='</div>';
                                historico +='<div class="summary">';
                                historico +='   <p class="text sel-service observaciones"><b>Observaciones</b>: '+result.historico[i].observaciones+'</p>';
                                historico +='</div></div>';
                            $("#myModal").find(".modal-body .historial").append(historico);
                        }
                    } 
                }
            },
            error: function(xhr, resp, text) {                
                $(".responsemessage").addClass("errorresponse");
                $(".responsemessage").addClass("showed").html("Ocurrió un error inesperado cargando historial").slideDown();
            }    
        });
    }

    //guardar atencion al ciudadano
    function executeSave(){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: attendingturnurl, 
            type : "POST", 
            data: $("#form-response").serialize(),
            beforeSend: function(){ $(".loading-main").fadeIn(); },
            success : function(result) {                     
                $(".loading-main").fadeOut();
                if(result.error=="true"){
                    $(".responsemessage").addClass("errorresponse");
                    $(".responsemessage").addClass("showed").html(result.description).slideDown();
                }       
                else{                      
                    $(".responsemessage").removeClass("errorresponse");
                    $(".responsemessage").addClass("showed").html(result.description).slideDown();    

                    //seteamos la disponibilidad segun sea el caso                 
                    if(result.user.disponibleturno=="si"){
                        $(".switchcontainer small").html("Disponible").addClass("blueish");
                        $("#availability").prop('checked', true);
                    }
                    else{
                        $(".switchcontainer small").html("No disponible").removeClass("blueish");
                        $("#availability").prop('checked', false);
                    }
                    $("#curp").val("");
                    $("#email").val("");
                    $("#observaciones").val("");
                    $("#estatus").select2('val','finalizado');
                    $("#form-response,#info-turno").addClass("hide");
                    $("#info-empty").removeClass("hide");
                    //no seguir buscando asignaciones
                    getassignment = setInterval(getAssignment, 1000 * 5 * 1); // every 5 seconds
                    //disable availability button
                    $(".mask").addClass("hide");
                }                                                   
            },
            error: function(xhr, resp, text) {
                $(".loading-main").fadeOut();
                $(".responsemessage").addClass("errorresponse");
                $(".responsemessage").addClass("showed").html("Ocurrió un error inesperado, intenta más tarde").slideDown();
            }
        });
    }

});



function countdown(){

    $(".timerareacontainer").html("");
    $(".timerareacontainer").append("<p class='timerarea'/>");
    
    var now;
    var min=0;
    var sec=0;
    var remainer=0;
    var time=0;
    var arraytime=[];

    now = new Date().getTime() / 1000;
    startTime = new Date(startTime) / 1000;            
    sec = parseInt(now - startTime);
    time=sec/60;
    arraytime=time.toString().split(".");
    min=arraytime[0]; 
    if(arraytime.length>1){
        remainer = "."+arraytime[1];
    }
    else{
        remainer = 0;
    }
    sec= parseInt(remainer*60);
    
    timer = setInterval(function() {
      sec = parseInt(sec) + 1;
      if (sec > 59) {
        min = parseInt(min) + 1;
        sec = 0;
      }
      if (sec < 10 && sec.length != 2){ sec = '0' + sec; }     
      if (min < 10 && min.length != 2){min = '0' + min;}
      $('.timerarea').html(min + ':' + sec).fadeIn();      
    }, 1000);
}
