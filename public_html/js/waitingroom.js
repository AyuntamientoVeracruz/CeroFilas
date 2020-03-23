//variables de inicio
let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod:3, mirror: false });
var json = {};

$(document).ready(function() {

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
    //INIT ACTIONS
	$(".loading-main").fadeOut();
	//set placeholder 
	$("#tramite").select2( {
		placeholder: "Seleccione trámite"
	});

	/*****ALERT GENERAL***/		
	//click alert message to close
	$("body").on('click','.responsemessage', function(){
		$this=$(this);
		$this.slideUp().removeClass("showed");
	});

	/*****CON CITA QR***/		
	//click on concita button
	$("body").on("click",'a.concita',function(){
		//document.documentElement.webkitRequestFullScreen();
		//document.documentElement.requestFullscreen();
		$this=$(this);
		var reading=1;
		$(".loading-main").fadeIn(100,function(){	//ajaxcall
			//mostrar visor con cita
			$(".concitavisor").show();
			//agregar listener a la camara, cuando detecte un scan de qr, lo envie a la url pertinente (en este caso confirmacion con el id de la cita para poder en esta generar folio de turno)
			scanner.addListener('scan', function (content) {
				//window.location.href=content;
				
				scanner.stop();
				var contenido=content;
				if(reading==1){
					reading=0;	
					//cadenaqr debe medir 28
					if(contenido.length==28){	
						//cadenaqr debe contener :
						var qr=contenido.split(":");
						//cadenaqr primer parte debe ser de 19 caracteres y debe ser foliodecitagenerado 
						if(qr[0].length==19 && qr[0]=="foliodecitagenerado"){
							$.ajax({
					        	headers: {
								    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								},
					            url: confirmationqrurl+"/"+qr[1], 	//el folio de 8 digitos
					            type : "POST",  
					            dataType : 'json', 
					            beforeSend: function(){ scanner.stop();$(".loading-main").fadeIn(); },
					            success : function(result) {  
					            	scanner.stop();          	     
									$(".loading-main").fadeOut();
									$(".concitavisor").hide();								
									if(result.error=="false"){
										$(".miniscreencontainer").addClass("active");
										$("#confirmationtype").html(result.confirmationtype);
										$("#turno").html(result.folio);
										$("#tiempoaproximado").html(result.tiempoaproximado);
									}else{							
				        				$(".responsemessage").addClass("errorresponse");
										$(".responsemessage").addClass("showed").html(result.errordescription).slideDown();	
									}										
					            },
					            error: function(xhr, resp, text) {
					            	scanner.stop();
					            	$(".loading-main").fadeOut();
					            	$(".concitavisor").hide();									            	
					                $(".responsemessage").addClass("errorresponse");
									$(".responsemessage").addClass("showed").html("Ocurrió un error creando el turno, intenta más tarde.").slideDown();
					            }
					        });
					    }
					    else{
							$(".loading-main").fadeOut();
			            	$(".concitavisor").hide();									            	
			                $(".responsemessage").addClass("errorresponse");
							$(".responsemessage").addClass("showed").html("Este no es un QR válido").slideDown();
						}
					}
					else{
						$(".loading-main").fadeOut();
		            	$(".concitavisor").hide();									            	
		                $(".responsemessage").addClass("errorresponse");
						$(".responsemessage").addClass("showed").html("Este no es un QR válido").slideDown();
					}


				}

			});
			Instascan.Camera.getCameras().then(function (cameras) {
				//checando camaras
				if (cameras.length > 0) {
					//alert(cameras.length);
				  var selectedCam = cameras[0];
				  //si hay mas de 1 camara, obtener la camara trasera
				  $.each(cameras, (i, c) => {
						if (c.name.indexOf('back') != -1) {
							selectedCam = c;
							return false;
						}
				   });				
				  //scanner.start(selectedCam);
				  scanner.start(cameras[0]);		//first camera			  
				} else {
				  alert('No cameras found.'); 
				}
			}).catch(function (e) {
				alert('No cameras found.');
			});

			$(".loading-main").fadeOut();//ajax call end
		});

		document.body.requestFullscreen();
		 
		return false;
	});

	//boton cerrar de visor con cita
	$("body").on("click",'.concitavisor close',function(){
		$(".concitavisor").hide();
		scanner.stop();
		$(".minisearchcontainer").removeClass("active");
	});

	//boton cerrar de confirmacion cita
	$("body").on("click",'.miniscreencontainer close',function(){
		$(".miniscreencontainer").removeClass("active");				
	});


	/*****CON CITA BUSCADOR***/		
	//click on concita button
	$("body").on("click",'.concitavisor search',function(){
		$(".minisearchcontainer").addClass("active");
		$("#search").focus().val("");
	});	

	//click on buscar cita por texto button
	$("#search-form").on('submit', function(){
		$.ajax({
        	headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            url: searchcitabytexturl+"/"+$("#search").val(), 	//el texto escrito
            type : "POST",  
            dataType : 'json', 
            beforeSend: function(){ $(".loading-main").fadeIn(); },
            success : function(result) {              	        	     
				$(".loading-main").fadeOut();
				//$(".concitavisor").hide();								
				if(result.error=="false"){
					$(".concitavisor").hide();
					$(".minisearchcontainer").removeClass("active");
					$(".miniscreencontainer").addClass("active");
					$("#confirmationtype").html(result.confirmationtype);
					$("#turno").html(result.folio);
					$("#tiempoaproximado").html(result.tiempoaproximado);
				}else{							
    				$(".responsemessage").addClass("errorresponse");
					$(".responsemessage").addClass("showed").html(result.errordescription).slideDown();	
				}										
            },
            error: function(xhr, resp, text) {            	
            	$(".loading-main").fadeOut();
            	//$(".concitavisor").hide();									            	
                $(".responsemessage").addClass("errorresponse");
				$(".responsemessage").addClass("showed").html("Ocurrió un error creando el turno, intenta más tarde.").slideDown();
            }
        });
        return false;
	});	

	//boton cerrar de buscador de cita
	$("body").on("click",'.minisearchcontainer close',function(){
		$(".minisearchcontainer").removeClass("active");
	});


	/*****SIN CITA***/	
	//click on sincita button
	$("body").on("click",'a.sincita',function(){
		//document.documentElement.webkitRequestFullScreen();
		//document.documentElement.requestFullscreen();
		$this=$(this);
		//invocamos servicio de obtencion de tramites disponibles
		$.ajax({
        	headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            url: gettramitesbykioskourl, 	//el texto escrito
            type : "GET",  
            //dataType : 'json', 
            beforeSend: function(){ $(".loading-main").fadeIn(); },
            success : function(result) {              	        	     
				$(".loading-main").fadeOut();																					
				//mostrar visor sin cita
				$(".sincitavisor").addClass("active");
				$("#tramite")
			              .find('option')
			              .remove()
			              .end()
			              .append('<option value="">Seleccione un trámite</option>'); 
				if(result.length>0){					
			        for(var i=0; i<result.length; i++){
			        	$("#tramite").append('<option value="'+result[i].id_tramite+'">'+result[i].nombre_tramite+'</option>');
			        }         			      	
				}
				$("#tramite").select2();

            },
            error: function(xhr, resp, text) {            	
            	$(".loading-main").fadeOut();									            	
                $(".responsemessage").addClass("errorresponse");
				$(".responsemessage").addClass("showed").html("Ocurrió un error inesperado, intenta más tarde.").slideDown();
            }
        });
		document.body.requestFullscreen();
		
		return false;
	});
	//boton cerrar de visor sin cita
	$("body").on("click",'.sincitavisor close',function(){
		$(".sincitavisor").removeClass("active");
	});

	//click on label over input field
	$(".inputfield label").on('click', function(event) {
		$(this).parent().find("input,textarea").focus();
	});
			
	//guardando turno manual
	$("#turno-form").on('submit', function(){
		//var auxjson={};
		//auxjson["value"] = oficina;
		json["oficina"]=oficina;
		json["tramite"]=$("#tramite option:checked").val();
		json["curp"]=$("#curp").val();
		json["nombre"]=$("#nombre").val();
        $.ajax({
        	headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            url: manualturnurl, 
            type : "POST", 
            dataType : 'json', 
            data : json, 
            beforeSend: function(){ $(".loading-main").fadeIn(); },
            success : function(result) {            	     
				$(".loading-main").fadeOut();											
				if(result.error=="false"){
					$(".sincitavisor").removeClass("active");	
					$(".miniscreencontainer").addClass("active");
					$("#confirmationtype").html(result.confirmationtype);
					$("#turno").html(result.folio);
					$("#tiempoaproximado").html(result.tiempoaproximado);
					$("#curp").val("");
					$("#nombre").val("");
					$("#tramite").val('').select2({
						placeholder: "Seleccione un valor"
					});
				}else{							
    				$(".responsemessage").addClass("errorresponse");
					$(".responsemessage").addClass("showed").html(result.errordescription).slideDown();	
				}				
				//console.log(result);
            },
            error: function(xhr, resp, text) {
            	$(".loading-main").fadeOut();
            	$(".responsemessage").addClass("errorresponse");
				$(".responsemessage").addClass("showed").html("Ocurrió un error creando el turno, intenta más tarde.").slideDown();
				//console.log(xhr, resp, text);
            }
        });
        return false;
    });

});
