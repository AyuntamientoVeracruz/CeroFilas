//variables de inicio de contador y otras
var durationminutes=lbltimer;// 5;
var duration = moment.duration({'minutes': durationminutes,'seconds': 00});
var timestamp = new Date(0, 0, 0, 2, 10, 30);
var startTime;
let elapsedSeconds = 0;
var interval = 1;
var timer;
var toptoview=10;
var json = {};
var ip;
var mesanio="";
var holdingfolio="";
var etiquetaIdioma="";

//WEB READY
$(document).ready(function() {

	function lengauje($msg){
		etiquetaIdioma=$msg;
	}

	//refresh token
	setInterval(keepTokenAlive, 1000 * 60 * 710); // every 710 mins
	function keepTokenAlive() {
        $.ajax({
            url: '/keep-token-alive',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).then(function (result) {
            
        });
    }

	//hide loader
	//$(".loading-main").fadeOut();
	/*$.getJSON("https://api.ipify.org/?format=json",function(e){ip=e.ip;});*/

	/*****INICIO***/	
	//getting listado de tramites
	gettramites();

	/*****SIDEBAR***/	
	//sidebar fixed
	var $sidebar = $(".summary-scroll"),
                $window = $(window),
                offset = $sidebar.offset();
    //function to reallocate sidebar
	function sidebar_relocate() {
	    var window_top = $(window).scrollTop();
	    var footer_top = $("footer").offset().top;
	    var div_top = $(".anchor").offset().top;
	    var div_height = $(".summary-scroll").height();
	    var padding = 30;

	    if (window_top + div_height > footer_top - padding){	          
	    	$('.summary-scroll').addClass('stick');
		}    
	    else if (window_top > div_top) {
	        $('.summary-scroll').removeClass('stick');
	        $sidebar.stop().animate({
				marginTop: ($window.scrollTop() - offset.top) + 20
			});
	    } else {
	        $('.summary-scroll').removeClass('stick');
	    	$sidebar.stop().animate({
				marginTop: 0
			});
	    }
	}  
    //scrolled window
	$(window).scroll(sidebar_relocate);
	//click helper on sidebar to go to section
	$("body").on('click','[data-summary]', function(){
		$this=$(this);
		if($this.data("summary")=="oficina"){goto("[data-section='2']");$("#lugarcita").focus();}
		if($this.data("summary")=="fechahora"){goto("[data-section='3']");}
		if($this.data("summary")=="nombre"){goto("[data-section='4']");$("#username").focus();}
		if($this.data("summary")=="email"){goto("[data-section='4']");$("#email").focus();}
		if($this.data("summary")=="curp"){goto("[data-section='4']");$("#curp").focus();}
	});


	/*****TRAMITE***/	
	//change tramite
    $("#tramite").change(function() {
    	$this=$(this).find("option:selected");
    	$.ajax({
	        url: getoficinasurl+"/"+$this.val(), 
	        type: "GET",
	        //data: "tramite="+$this.val(),
	        dataType : 'json', 
	        beforeSend: function(){ $(".loading-main").fadeIn(); },
	        success : function(result) {            	     				
				
				
				var oficinas = $("#lugarcita");
				oficinas.find('option').remove();
				oficinas.append('<option value="">'+lblSelectOption+'</option>');
				for (var i=0; i<result.oficinas.length; i++) {			  
			      oficinas.append('<option value="'+result.oficinas[i].id_oficina+'" data-position="'+result.oficinas[i].coords+'" data-direccion="'+result.oficinas[i].direccion+'">'+result.oficinas[i].nombre_oficina+'</option>');
			    }	
			    $("#lugarcita").select2({
					placeholder: lblSelectOption,
					templateResult: formatOficinaAddress,
					matcher: matchCustom
				});
				printsummaryvariable("oficina","<noselected>"+lblCreateAppointment38+"</noselected>");
				hideMap();
				printsummaryvariable("tramite", $this.text(), $this.val());  
				goto("[data-section='2']");	  	
				$("#lugarcita").prop('disabled', false);	
				limpiarfecha();
				$(".calendar-wrapper").addClass("hiddened");
				$("#datesarea").html("");
				$(".calendar-header .calendar-title").html(lblCreateAppointment46);
				$(".calendar-header .calendar-year").html(lblCreateAppointment47);
				$(".loading-main").fadeOut();

				$(".summary[data-summary='tramite']").find("p").append("<a href='#' class='btn btn-sm btn-primary btnrequisitos'><i class='fa fa-plus'></i> "+lblCreateAppointment45+"</a>");	

				$(".requisito").hide();
				$(".requisitoscontainer-holder").show();
				$("#requisito"+$this.val()).show();
				$("body").addClass("open-modal");

	        },
	        error: function(xhr, resp, text) {
	        	$(".loading-main").fadeOut();
	        	$(".responsemessage").addClass("errorresponse");
				$(".responsemessage").addClass("showed").html(lblErrorLoading).slideDown();
	        }
	    });	
    });

    $("body").on('click','.btnrequisitos',function(){
    	$(".requisitoscontainer-holder").show();
    	$("body").addClass("open-modal");
    	return false;
    });	

    /*****OFICINA***/	
    //change lugar cita
    $("#lugarcita").change(function() {
    	$this=$(this).find("option:selected");
    	
    	//data from oficina to show
		printsummaryvariable("oficina", $this.text(), $this.val(), $this.data("position"));   
	    goto("[data-section='3']");	    
	    $(".map").slideDown();
	    addMarker($this.data("position"));	
	    limpiarfecha();	
	    $(".calendar-wrapper").addClass("hiddened");
		$("#datesarea").html("");
		$(".calendar-header .calendar-title").html(lblCreateAppointment46);
		$(".calendar-header .calendar-year").html(lblCreateAppointment47);	
	    //llamando el llenado de fechas de calendario, se manda null para obtener el mes actual	
    	getfechas();	
    	$(".calendar-wrapper").removeClass("hiddened");
    	
    });

    /*****CALENDAR***/	
    //tooltip for dia on calendar	
	$("body").on("click",'.ct-week.notavailable,.ct-week.hide_previous_dates',function(){
		return false;
	});

	//click next date icon
	$("body").on('click','.previous-date', function(){
		$this=$(this);
		var fechaanterior=$this.attr("data-date").split("-");
		getfechas(fechaanterior[0],fechaanterior[1]);
		return false;
	});

	//click next date icon
	$("body").on('click','.next-date', function(){
		$this=$(this);
		var fechasiguiente=$this.attr("data-date").split("-");
		getfechas(fechasiguiente[0],fechasiguiente[1]);
		return false;
	});

	//click dia disponible on calendar
	$("body").on("click",'.ct-week.available',function(){
		$this=$(this);
				
		var oficina=json.oficina.value;
		var tramite=json.tramite.value;
		var fecha=$this.attr("data-date").split("-");		
		var armedurl = getavailablehoursurl+"/"+oficina+"/"+tramite+"/"+fecha[2]+"/"+fecha[1]+"/"+fecha[0];

		console.log(armedurl);
		
		//getting listado de horas disponibles de la fecha seleccionada
		$.ajax({
	        url: armedurl, 
	        type : "GET", 
	        dataType : 'json', 
	        beforeSend: function(){ $(".loading-main").fadeIn(); },
	        success : function(result) {       
	        		
				var hoursarea = $(".hours div");								//dates area div
				hoursarea.html("");												//limpiamos datesarea				
				/*var horarios = Object.keys(result.horas.horarios).map(function(key) {return [key, result.horas.horarios[key]];});*/
				var horas=0;
				//por cada una de las horas				
				for (var key in result.horas[0].horarios) {
					hoursarea.append('<a href="#" data-time="'+key+'">'+key+'</a>');
					horas++;
				}	
				if(horas==0){
					hoursarea.append('<span class="nohoras">'+lblCreateAppointment48+'</span>');
				}				
				$(".ct-week").removeClass("selected");							//quitamos la seleccion al dia que tenga seleccion
				$this.addClass("selected");										//ponemos seleccion al dia seleccionado
				unselectday();													
				$(".hours").slideDown().addClass("active").fadeOut(350).fadeIn(350).fadeOut(350).fadeIn(350);	//mostramos hours area
				goto(".ct-week.available.selected");							//desplazamos hacia abajo un poco
				
				$(".hours small").html(lblCreateAppointment52+" "+result.horaejecucion+'</small>');

				$(".loading-main").fadeOut();
	        },
	        error: function(xhr, resp, text) {
	        	$(".loading-main").fadeOut();
	        	$(".responsemessage").addClass("errorresponse");
				$(".responsemessage").addClass("showed").html(lblErrorLoading).slideDown();
	        }
	    });


		return false;
	});

	//click hora disponible for dia on calendar
	$("body").on("click",'.hours a',function(){
		$this=$(this);
		//$(".loading-main").fadeIn(100,function(){	//ajaxcall
			$(".hours a").removeClass("selected");
			//$this.addClass("selected");
			$fecha = $(".ct-week.selected").data("date");
			$fechadate = $fecha;
			//moment.locale('es');
			$fecha = moment($fecha,'YYYY-MM-DD').format('ddd, D MMMM, YYYY');		
			$hora = $this.data("time");			
			$(".ct-selected-date-view").find("fecha").html($fecha);
			$(".ct-selected-date-view").find("hora").html($hora);
			//printsummaryvariable("fechahora", $fecha+" @ "+$hora, $fechadate+" "+$hora);
			$(".today-date").slideDown();
			clearcountdown(false, $fechadate+" "+$hora, $fecha+" @ "+$hora,$this);						
			//$(".loading-main").fadeOut();	//ajax call end
		//});	
		return false;
	});

	/*****DATOS DE USUARIO***/	
	//click on label over input field
	$(".inputfield label").on('click', function(event) {
		$(this).parent().find("input,textarea").focus();
	});

	//cuando teclean nombre y/o apellidos
	$("#username,#apellidopaterno,#apellidomaterno").on("change paste keyup", function() {
	   writename();
	   showbuttontosend();
	});

	//cuando teclean email o curp
	$("#email,#curp,#telefono").on("change paste keyup", function() {
	//$("#curp").on("change paste keyup", function() {	   
	   writevalue();
	   showbuttontosend();
	});

	
	/*****ALERT***/		
	//click alert message to close
	$("body").on('click','.responsemessage', function(){
		$this=$(this);
		$this.slideUp().removeClass("showed");
	});



	/*****CITA***/		
	//guardando cita
	$("#cita-form").on('submit', function(){
        $.ajax({
        	headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            url: savedateurl, 
            type : "POST", 
            dataType : 'json', 
            data : json, 
            beforeSend: function(){ $(".loading-main").fadeIn(); },
            success : function(result) {            	     
				$(".loading-main").fadeOut();
				if(result.error=="true"){
					$(".responsemessage").addClass("errorresponse");
					$(".responsemessage").addClass("showed").html(result.description).slideDown();
				}else{
					resetform();   
					$(".responsemessage").removeClass("errorresponse");
					$(".responsemessage2").addClass("showed").html(result.description).slideDown();	
				}
							
            },
            error: function(xhr, resp, text) {
            	$(".loading-main").fadeOut();
            	$(".responsemessage").addClass("errorresponse");
				$(".responsemessage").addClass("showed").html(lblCreateAppointment49).slideDown();
                //console.log(xhr, resp, text);
            }
        });
        return false;
    });


	//requisitos
	$("body").on('click','.buttonaccept', function(){
		$this=$(this);
		$this.closest('.requisitoscontainer-holder').hide();
		$("body").removeClass("open-modal");
	});

});


/*****HELPER FUNCTIONS***/
//function contador
function countdown(){
	startTime = new Date().getTime() / 1000;
	elapsedSeconds = 0;
	var now;

    document.addEventListener("visibilitychange", () => {
    	if (!document.hidden) {
     		now = new Date().getTime() / 1000;
      		elapsedSeconds = parseInt(now - startTime);
      		duration = moment.duration({'minutes': durationminutes,'seconds': 00});
      		duration = moment.duration(duration.asSeconds() - elapsedSeconds , 'seconds');
    	}
  	});

    timer = setInterval(function() {
      timestamp = new Date(timestamp.getTime() + interval * 1000);
      duration = moment.duration(duration.asSeconds() - interval, 'seconds');
      var min = duration.minutes();
      var sec = duration.seconds();
      sec -= 1;
      if (min < 0) return clearInterval(timer);
      if (min < 10 && min.length != 2) min = '0' + min;
      if (sec < 0 && min != 0) {
        min -= 1;
        sec = 59;
      } else if (sec < 10 && sec.length != 2) sec = '0' + sec;
      $('.timerarea').html(min + ':' + sec).fadeIn();
      if (min == 0 && sec == 0){
        limpiarfecha();
      }
    }, 1000);
}
//function clear contador
function clearcountdown(boolean,fechahora,fechahoraformatted,button){

	clearInterval(timer);
	duration = moment.duration({'minutes': durationminutes,'seconds': 00});
	timestamp = new Date(0, 0, 0, 2, 10, 30);
	interval = 1;
	$(".timerarea").fadeOut().remove();
	if(boolean){ 
		$(".ct-week").removeClass("selected");
	}	
	//liberar de la base de datos la cita (servicio que libere de la base de datos)
	$.ajax({
    	headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
        url: removeholdingcitaurl, 
        type : "POST", 
        dataType : 'json', 
        data : "holdingfolio="+holdingfolio, 
        beforeSend: function(){ $(".loading-main").fadeIn(); },
        success : function(result) {            	     
			$(".loading-main").fadeOut();
			if(result.error=="true"){
				$(".responsemessage").addClass("errorresponse");
				$(".responsemessage").addClass("showed").html(result.description).slideDown();
			}		
			else{

				$("#fechahora").val("");
				//si hay fechahora, quiere decir que fue invocado al seleccionar nueva fechahora
				if(fechahora){
					printsummaryvariable("fechahora", fechahoraformatted, fechahora);
					button.addClass("selected");
					//llamar al servicio de holding date
					$.ajax({
			        	headers: {
						    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
			            url: holdingdateurl, 
			            type : "POST", 
			            dataType : 'json', 
			            data : json, 
			            beforeSend: function(){ $(".loading-main").fadeIn(); },
			            success : function(result) {            	     
							$(".loading-main").fadeOut();
							if(result.error=="true"){
								$(".responsemessage").addClass("errorresponse");
								$(".responsemessage").addClass("showed").html(result.description).slideDown();
								$(".today-date").slideUp();
								$(".hours a").removeClass("selected");
								json.fechahora="";
								json.holdingfolio="";
								printsummaryvariable("fechahora", "<noselected>"+lblCreateAppointment39+"</noselected>");
							}		
							else{
								holdingfolio=result.holdingcita.folio;							
								var auxjson={};
								auxjson["value"] = holdingfolio;		
								json["holdingfolio"]=auxjson;	
								$("#fechahora").val(fechahora);								
								if($('.timerarea').length === 0) {
									$(".summary-scroll .timerareacontainer").append("<p class='timerarea'/>");				
								}			
								countdown();			
								showbuttontosend();
								$(".hours").removeClass("active");
								goto("[data-section='4']");
								$("#username").focus();
							}													
			            },
			            error: function(xhr, resp, text) {
			            	$(".loading-main").fadeOut();
			            	$(".responsemessage").addClass("errorresponse");
							$(".responsemessage").addClass("showed").html(lblCreateAppointment50).slideDown();
			            }
			        });
					
				}else{
					json.fechahora="";
					json.holdingfolio="";
					holdingfolio="";
				}

			}								
        },
        statusCode: {
        	302:function(responseObject, textStatus, jqXHR) {
        		$(".loading-main").fadeOut();
        		$(".responsemessage").addClass("errorresponse");
				$(".responsemessage").addClass("showed").html(responseObject.responseJSON.error).slideDown();
        	}
        },
        error: function(xhr, resp, text) {
        	$(".loading-main").fadeOut();
        	$(".responsemessage").addClass("errorresponse");
			$(".responsemessage").addClass("showed").html(lblCreateAppointment51).slideDown();
            //console.log(xhr, resp, text);
        }
    });

	
	
}
//function scroll to element
function goto(element){	
	$("html,body").animate({ scrollTop: $(element).offset().top - toptoview}, 600);
	//console.log($(element).offset().top - toptoview);
}
//function unselectday
function unselectday(){
	$(".hours a").removeClass("selected");
	$(".hours").slideUp();
	$(".today-date").slideUp();
}
//function to write name on sidebar
function writename(){
	var nombre = $("#username").val();
	var apellidopaterno = $("#apellidopaterno").val();
	var apellidomaterno = $("#apellidomaterno").val();
	//if(nombre==""&&apellidopaterno==""&&apellidomaterno==""){
	if(nombre==""&&apellidopaterno==""){	
		printsummaryvariable("nombre", "<noselected>"+lblCreateAppointment40+"</noselected>");  
	}
	else{
		printsummaryvariable("nombre", nombre+" "+apellidopaterno+" "+apellidomaterno, nombre+"#"+apellidopaterno+"#"+apellidomaterno);
	}
}
//function to write values on sidebar
function writevalue(){
	var email = $("#email").val();
	var curp = $("#curp").val();
	var telefono = $("#telefono").val();		
	if(email==""){
		//console.log("here");
		printsummaryvariable("email", "<noselected>"+lblCreateAppointment41+"</noselected>");  
	}
	else{
		//console.log("nothere");
		printsummaryvariable("email", email, email);
	}
	if(curp==""){
		printsummaryvariable("curp", "<noselected>"+lblCreateAppointment42+"</noselected>");  
	}
	else{
		printsummaryvariable("curp", curp, curp);
	}
	if(telefono==""){
		//console.log("here");
		printsummaryvariable("telefono", "<noselected>"+lblCreateAppointment43+"</noselected>");  
	}
	else{
		//console.log("nothere");
		printsummaryvariable("telefono", telefono, telefono);
	}
}
//function to print variable on sidebar
function printsummaryvariable(variable, text, value, coords){
	$(".summary[data-summary='"+variable+"']").find(".text").html(text); 
	if(text.indexOf("<noselected>") == -1){
		//console.log("entra"+variable);
		var auxjson={};
		//auxjson["text"] = text;
		if(value){auxjson["value"] = value;}
		//if(coords){auxjson["coords"] = coords;}		
		json[variable]=auxjson;
	} 
	else{
		//console.log("noentra"+variable);
		var auxjson={};
		if(!value){auxjson["value"] = ""; json[variable]=auxjson;}
	}
}
//function showbutton to send
function showbuttontosend(){
	//if(($("#lugarcita").val()!="")&&($("#username").val()!="")&&($("#apellidopaterno").val()!="")&&($("#apellidomaterno").val()!="")&&($("#fechahora").val()!="")&&($("#email").val()!="")&&($("#curp").val()!="")){
	//if(($("#lugarcita").val()!="")&&($("#username").val()!="")&&($("#apellidopaterno").val()!="")&&($("#apellidomaterno").val()!="")&&($("#fechahora").val()!="")&&($("#curp").val()!="")){
	if(($("#lugarcita").val()!="")&&($("#username").val()!="")&&($("#apellidopaterno").val()!="")&&($("#fechahora").val()!="")&&($("#curp").val()!="")){	
		//if($('.submit').length === 0) {
			//$(".main-left").append("<input type='submit' class='btn btn-primary submit' value='Confirmar'/>");				
		//}
		$(".submit").prop( "disabled", false );	
	}
	else{
		//$(".submit").fadeOut().remove();
		$(".submit").prop( "disabled", true );	
	}
}
//limpiar fecha
function limpiarfecha(){	

	$("#fechahora").val("");
	printsummaryvariable("fechahora", "<noselected>"+lblCreateAppointment39+"</noselected>");
    clearcountdown(true);
    unselectday();
    showbuttontosend();
}

//function to reset form
function resetform(){	
	gettramites();		
	$("#lugarcita").val('').select2({
		placeholder: lblSelectOption,
		templateResult: formatOficinaAddress,
		matcher: matchCustom
	});
	printsummaryvariable("tramite","<noselected>"+lblCreateAppointment37+"</noselected>");
	printsummaryvariable("oficina","<noselected>"+lblCreateAppointment38+"</noselected>");
	hideMap();	
	$("#lugarcita").prop('disabled', 'disabled');		
	limpiarfecha();
	$(".calendar-wrapper").addClass("hiddened");
	$("#datesarea").html("");
	$(".calendar-header .calendar-title").html(lblCreateAppointment46);
	$(".calendar-header .calendar-year").html(lblCreateAppointment47);	
	$("#username").val('');
	$("#apellidopaterno").val('');
	$("#apellidomaterno").val('');
	$("#username").change();
	$("#apellidopaterno").change();
	$("#apellidomaterno").change();
	$("#email").val('');
	$("#curp").val('');
	$("#telefono").val('');
	$("#email").change();
	$("#curp").change();
	$("#telefono").change();
	$("html, body").animate({ scrollTop: 0 }, "slow");
	holdingfolio="";
	json={};
	json = new Object; 
}

/****TRAMITES***/
function gettramites(){
	$.ajax({
        url: gettramitesurl, 
        type : "GET", 
        dataType : 'json', 
        beforeSend: function(){ $(".loading-main").fadeIn(); },
        success : function(result) {            	     			
			var tramites = $("#tramite");
			var requisitoscontainer = $(".requisitoscontainer");
			tramites.find('optgroup').remove();
			tramites.find('option').remove();
			tramites.append('<option value="">'+lblSelectOption+'</option>');			
			var nombre_dependencia="";
			var optgroup = "";
			for (var i=0; i<result.tramites.length; i++) {	
			  if(result.tramites[i].nombre_dependencia!=nombre_dependencia){		
			  		nombre_dependencia=result.tramites[i].nombre_dependencia;	
			  		optgroup = $('<optgroup label="'+nombre_dependencia+'"></optgroup>');
			  		tramites.append(optgroup);
			  }	
		      optgroup.append('<option value="'+result.tramites[i].id_tramite+'">'+result.tramites[i].nombre_tramite+'</option>');
		      if(result.tramites[i].warning_message!=null){
		      	var warningmessage="<strong>"+result.tramites[i].warning_message+"</strong>";
		      }
		      else{
		      	var warningmessage="";
		      }
			  
			  var costo="<stronger><i>"+msglblCost+":</i> "+result.tramites[i].costo+"</stronger>";
		      requisitoscontainer.append("<div class='requisito' id='requisito"+result.tramites[i].id_tramite+"'><h1>"+lblProcedureRequirement+"</h1><span>"+warningmessage+result.tramites[i].requisitos.replace(/\n/g, "<br />")+costo+"</span><center><p class='buttonaccept'>"+lblIAgree+"</p></center></div>");
		      
		    }	
		    $("#tramite").select2({
				placeholder: lblSelectOption
			});			
			$(".loading-main").fadeOut();
        },
        error: function(xhr, resp, text) {
        	$(".loading-main").fadeOut();
        	$(".responsemessage").addClass("errorresponse");
			$(".responsemessage").addClass("showed").html(lblErrorLoading).slideDown();
        }
    });	
}

/****FECHAS***/
function getfechas(mes, anio){
	console.log("mes:"+mes);
	console.log("año:"+anio);
	var oficina=json.oficina.value;
	var tramite=json.tramite.value;
	if(mes&&anio){
		var armedurl = getavailabledaysurl+"/"+oficina+"/"+tramite+"/"+mes+"/"+anio;
	}
	else{
		var armedurl = getavailabledaysurl+"/"+oficina+"/"+tramite;
	}
	console.log(armedurl);
	
	//getting listado de fechas disponibles del mes actual
	$.ajax({
        url: armedurl, 
        type : "GET", 
        dataType : 'json', 
        beforeSend: function(){ $(".loading-main").fadeIn(); },
        success : function(result) {            	     			
			var datesarea = $("#datesarea");								//dates area div
			datesarea.html("");												//limpiamos datesarea
			//por cada una de las fechas
			for (var i=0; i<result.fechas.length; i++) {	
				var diadisponible=result.fechas[i].availableday;			//obtener si el dia esta disponible		
				var fechasdisponibles=result.fechas[i].availabledates;		//total de horas disponibles para ese dia
				//si tiene horas disponibles lo marcamos como available, si no no
				if(fechasdisponibles==0){var stringavailable="notavailable";}else{var stringavailable="available";}		
				var fecha = result.fechas[i].date;							//obtenemos la fecha completa del dia
				var dia = result.fechas[i].dia;								//obtenemos el numero de dia
				var numerodiasemana = result.fechas[i].dayofweek;			//obtenemos el numero de dia respecto a la semana 1-7 (lun-dom)
				//si es el dia1 y este no es el dia 1 de la semana 			//imprimimos celdas vacias si el dia 1 no es lunes
				if(i==0&&numerodiasemana>1){							
					//imprimir espacios de dias previos
					for(var j=1;j<numerodiasemana;j++){
						datesarea.append('<div class="ct-week hide_previous_dates"></div>');
					}
				}
				//si el dia esta disponible (con o sin fechas disponibles)	lo agregamos
				if(diadisponible){
					datesarea.append('<div title="'+fechasdisponibles+' '+lblAvailable+'<br><small class=ultimact>'+lblCreateAppointment52+' '+result.horaejecucion+'</small>" class="ct-week '+stringavailable+'" data-date="'+fecha+'"><a href="#"><span>'+dia+'</span></a></div>');
				}
				else{	//si no es un dia disponible
					datesarea.append('<div class="ct-week hide_previous_dates"><a href="#"><span>'+dia+'</span></a></div>');
				}
			}
			$('.ct-week').tooltipster({contentAsHTML: true,animation: 'grow',delay: 20,theme: 'tooltipster-borderless',trigger: 'hover'});	//setting tooltip
			$(".calendar-title").html(result.meselegido.mes[1]);			//seteamos el titulo del mes
			$(".calendar-year").html(result.meselegido.anio);				//seteamos el anio
			$(".calendar-header .previous-date").attr("data-date", result.mesanterior.mes+"-"+result.mesanterior.anio);	//arrow previousdate get mes/anio	
			$(".calendar-header .next-date").attr("data-date", result.messiguiente.mes+"-"+result.messiguiente.anio);	//arrow nextdate get mes/anio	

			$(".hours a").removeClass("selected");
			$(".hours").slideUp();

			//si el mes anterior es menor al mes actual, ocultamos el boton de regresar
			if(result.backmonth=="false"){
				$(".calendar-header .previous-date").hide();	
			}
			else{
				$(".calendar-header .previous-date").show();
			}

			//si el mes siguiente es maximo 2 meses el mes actual, ocultamos el boton de siguiente
			if(result.nextmonth=="false"){
				$(".calendar-header .next-date").hide();	
			}
			else{
				$(".calendar-header .next-date").show();
			}

			$(".loading-main").fadeOut();
        },
        error: function(xhr, resp, text) {
        	$(".loading-main").fadeOut();
        	$(".responsemessage").addClass("errorresponse");
			$(".responsemessage").addClass("showed").html(lblErrorLoading).slideDown();
        }
    });
}

/*template select2 oficina-direccion*/
function formatOficinaAddress (oficina) {
  if (!oficina.element) {
    return oficina.text;
  }
  //var baseUrl = "/user/pages/images/flags";
  var $oficina = $(
    '<span><b>' + oficina.text + '</b> ' + oficina.element.dataset.direccion + '</span>'
  );
  //console.log(oficina);
  return $oficina;
};
function matchCustom(params, data) {
    // If there are no search terms, return all of the data
    if ($.trim(params.term) === '') {
      return data;
    }

    // Do not display the item if there is no 'text' property
    if (!data.element.dataset.direccion) {
      return null;
    }
    //console.log(data);
    // `params.term` should be the term that is used for searching
    // `data.text` is the text that is displayed for the data object
    if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) > -1 || data.element.dataset.direccion.toUpperCase().indexOf(params.term.toUpperCase()) > -1) {
      var modifiedData = $.extend({}, data, true);
      modifiedData.text;// += ' (matched)';

      // You can return modified objects from here
      // This includes matching the `children` how you want in nested data sets
      return modifiedData;
    }

    // Return `null` if the term should not be displayed
    return null;
}

/*****MAP***/	
var marker=[];
var map;
var geocoder;
var infowindow;
function initMap() {
	var myLatLng = {lat: 19.1952332, lng: -96.1478747};	
	map = new google.maps.Map(document.getElementById('map'), {
	  center: myLatLng,
	  zoom: 12,
	  mapTypeControl: false,
	  fullscreenControlOptions: {
	      position: google.maps.ControlPosition.LEFT_TOP
	  },
	  streetViewControlOptions: {
	      position: google.maps.ControlPosition.RIGHT_TOP
	  }
	});
	geocoder = new google.maps.Geocoder;
	infowindow = new google.maps.InfoWindow;
}
function setMapOnAll(map) {
	for (var i = 0; i < marker.length; i++) {
	  marker[i].setMap(map);
	}
}
function clearMarkers() {
setMapOnAll(null);
}
function hideMap(){
	clearMarkers();
	$(".map").slideUp();
}
function addMarker(position){	
	var positionarray=position.split(",");
	var positionlat=parseFloat(positionarray[0]);
	var positionlng=parseFloat(positionarray[1]);
	position = {lat: positionlat, lng: positionlng};
	clearMarkers();
	marker = [];
	map.setCenter(position);
	window.setTimeout(function() {      
      geocoder.geocode({'location': position}, function(results, status) {
	      if (status === 'OK') {
	        if (results[0]) {	          
	          marker.push(new google.maps.Marker({
		        position: position,
		        map: map,
		        animation: google.maps.Animation.DROP
		      }));
	          infowindow.setContent(results[0].formatted_address);
	          infowindow.open(map, marker[0]);
	          marker[0].addListener('click', function() {
		          infowindow.open(map, marker[0]);
		      });
	        } else {
	          //window.alert('No results found');
	        }
	      } else {
	        //window.alert('Geocoder failed due to: ' + status);
	      }
	  });
    }, 200);
    //infowindow.open(map, marker[0]);
}