<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
use Illuminate\Http\Request;

use App\Multa;
use App\Uma;
use App\Feriado;

use DateTime;
//use Illuminate\Support\Facades\Validator;
use DB;
use Helper;
//use Redirect;
//use App\Mail\SavelevantamientoMail;
//use Illuminate\Support\Facades\Mail;
use Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class TransitoController extends Controller
{
    
	public function __construct(){ }


    /**
     * listado de articulos transito

	   Método GET
	   https://cerofilas.veracruzmunicipio.gob.mx/multas/articulos-multa/{clave?}
	   donde {clave?} es la clave de artículo y es opcional

     */	
    public function getArticulosMulta($cvearticulo=false){
    	try {
	    	//obtener clave, articulo y descripcion de las multas	
	    	$multas = Multa::select('clave','articulo','descripcion')->where('estatus','A');
	    	
	    	if($cvearticulo){ //si nos manda el parametro de clave articulo, entonces filtramos por la clave
	    		$multas = $multas->where('clave',$cvearticulo);	    		
	    	}	
	    	$multas = $multas->get();

	    	if(count($multas)>0){
	    		$errorboolean="false";	    		
	    	}
	    	else{
	    		$errorboolean="true";	
	    	}	
	    	$description=count($multas)." Multa(s) encontrada(s)";	

	    	//por cada multa, vamos a transformar a UTF-8 para imprimir acentos y otros caracteres especiales    	
	    	foreach($multas as $multa){    					
				$multa['articulo']=mb_convert_encoding($multa['articulo'], 'UTF-8', 'UTF-8');
				$multa['descripcion']=mb_convert_encoding($multa['descripcion'], 'UTF-8', 'UTF-8');				
			}

		} catch (Exception $e) {			
			//ocurrió un error
			$multas=[];
			$errorboolean="true";
			$description="Ocurrió un error, intenta más tarde. Error:".$e;
		
		} 		
		//regresamos la respuesta en formato json
		return response()->json([
		    'error' => $errorboolean,
		    'description' => $description,
		    'multas' => $multas
		], 200, [], JSON_UNESCAPED_UNICODE);
    }


    /**
     * obtener monto de multa
		
		Método POST
	    https://cerofilas.veracruzmunicipio.gob.mx/multas/obtenermulta?clave={MUTR-#}&fecha={AAAA-MM-DD}&agravante={1 o vacío}

		clave = codigo clave de la multa (formato: MUTR-#)
    	fecha = fecha en que la multa fue ejecutada (formato: AAAA-MM-DD)
    	agravante = 1 o nulo para saber si aplica agravante o no (formato: 1 o vacío)	

    	header
    	incluir token: a1a09df74a235deee6db95a9511a728fc9812dd2

    	Hasta 120 peticiones por minuto

     */	
    public function getMontoMulta(Request $request){


    	//inicia try
    	try {	    			

    		
	    	$fecha 		 = request()->fecha;			
	    	$articulos 	 = request()->articulos;	
	    	$agravante 	 = request()->agravante;    	
	    	$multa	 	 = [];	    		    	

	    	//validando fecha, si la fecha no es válida
    		if(\DateTime::createFromFormat('Y-m-d', $fecha) === false){    			
				$errorboolean	= "true";
				$description	= "Multa no calculada. La fecha ingresada es inválida.";
    		}
    		//si la fecha es válida
    		else{

    			//seteando jsonarticulos con el array de articulos obtenido
		    	$jsonarticulos = $articulos;	
    			//obtener fecha actual
    			$diaactual 			= date('Y-m-d');
    			//obtener uma de fecha actual										
		    	$uma = Uma::select('monto')->where('fechainicio','<=',$diaactual)->where('fechafin','>=',$diaactual)->first(); 

		    	//si hay uma para la fecha actual, regresamos la multa
				if(count($uma)>0){
		    			
		    		//si hay al menos un elemento en jsonarticulos	
			    	if(count($jsonarticulos)>0){
						$multa["articulos"]=[];

						//retornando que no hay error    		
		    			$errorboolean="false";
						$description="Multa calculada";		
						$vaciarmulta=0;
						//recorriendo articulos
			    		foreach($jsonarticulos as $i => $v)
			            {
			            	//si en la posicion del array articulos actual tiene clave y agravante
			            	if (array_key_exists('clave', $v)) {

				            	//obteniendo clave articulo
				                $cvearticulo = $v['clave'];				                

				                //buscamos la multa por la clave	
						    	$multaarticulo = Multa::select('clave','articulo','descripcion','umas','alcohol')->where('clave',$cvearticulo)->where('estatus','A')->first();
						    	//si la clave existe, regresamos valores en multa
						    	if(count($multaarticulo)>0){	
						    		
						    		//regresar valores inputeados				    		
						    		$multaarticulo['agravante']	= $agravante;						    		
						    		//inicializando monto
						    		$monto=0;	
						    		$total=0;
						    		$descuento=0;																    		
						    		//valor uma						    		
					    			$multaarticulo['valoruma']=number_format($uma['monto'],2,'.', '');	
					    			//obteniendo multa sin descuento
					    			$montosindescuento = $uma['monto']*$multaarticulo['umas'];
					    			//obtener cuantos registros de dias feriados hubo desde fecha de multa hasta dia actual
					    			$from = date($fecha);
									$to = date('Y-m-d');
					    			$feriados = Feriado::whereBetween('fecha',[$from, $to])->count(); 

					    			//calculando los dias habiles que han pasado desde el dia de la multa
					    			$start = new DateTime($fecha);
									$end = new DateTime(date('Y-m-d'));
									//$end->modify('+1 day');
									$interval = $end->diff($start);
									// dias totales
									$days = $interval->days;
									$multaarticulo['diasnaturales']=$days;
									// create an iterateable period of date (P1D equates to 1 day)
									$period = new \DatePeriod($start, new \DateInterval('P1D'), $end);
									// best stored as array, so you can add more than one					
									foreach($period as $dt) {
									    $curr = $dt->format('D');
									    // eliminar sábados y domingos como hábiles
									    if ($curr == 'Sat' || $curr == 'Sun') {
									        $days--;
									    }					    
									}
									//restando a los dias los feriados
									$multaarticulo['diassinfinesdesemana']=$days;
									$multaarticulo['feriados']=$feriados;
									$diashabiles=$days-$feriados;
									//seteando dias con los dias calculados
									$multaarticulo['diashabiles']=$diashabiles;

					    			//si aplica articulo con alcohol o agravente o ya se paso del tiempo, no hay descuento	    			
					    			if($multaarticulo['alcohol']=='SI' || $agravante=="1" || $multaarticulo['diashabiles']>5){
					    				$monto = $montosindescuento;
					    				$descuento = 0;
					    				$total = $monto - $descuento; 
					    				$labeldescuento = "SIN DESCUENTO";
					    			}//si no aplica lo anterior, si hay descuento
					    			else{
					    				$descuento = $montosindescuento/2;
					    				$monto = $montosindescuento;
					    				$total = $monto - $descuento;
					    				$labeldescuento = "DESCUENTO 50%";
					    			}
						    		//seteando monto y retornando exitoso
						    		$multaarticulo['subtotal'] = number_format($monto,2,'.', '');
						    		$multaarticulo['descuento'] = number_format($descuento,2,'.','');
						    		$multaarticulo['total'] = number_format($total,2,'.','');
						    		$multaarticulo['labeldescuento'] = $labeldescuento;
						    		//agregando el articulo al array articulos de multa
						    		array_push($multa["articulos"], $multaarticulo);							    		
																									
								}//si no existe el codigo, no podemos regresar un monto de multa
								else{
									$multaarticulo=[];			
									$multaarticulo['clave'] = $cvearticulo;	
									$multaarticulo['error'] = "Clave de artículo incorrecto.";	
									array_push($multa["articulos"], $multaarticulo);
									$errorboolean="true";
									$description="Multa no calculada. Hay artículos con clave incorrecta.";	
									$vaciarmulta=1;
								}	
							}
							//si no tiene los elementos el articulo (clave y agravante)
							else{
								$multaarticulo=[];			
								$multaarticulo['error'] = "El elemento artículo no cuenta con los elementos necesarios.";	
								array_push($multa["articulos"], $multaarticulo);	
								$errorboolean="true";
								$description="Multa no calculada. Hay artículos que no cuentan con los elementos necesarios.";		
								$vaciarmulta=1;								
							}		
			            }
			            $montomaximo=0;
			            $subtotalmaximo=0; 
			            $articulomaximo="";
			            $clavemaximo="";
			            $descripcionmaximo="";
			            $labeldescuentomaximo="";
			            $descuentomaximo=0; 
			            
			            //obtener monto maximo
			            foreach($multa["articulos"] as $i => $v){
			            	if (isset($v['total'])){
				            	if($v['total']>$montomaximo){
				            		$subtotalmaximo 	= $v['subtotal'];
				            		$montomaximo 		= $v['total'];
				            		$articulomaximo		= $v['articulo'];
				            		$clavemaximo		= $v['clave'];
				            		$descripcionmaximo	= $v['descripcion'];
				            		$descuentomaximo	= $v['descuento'];
				            		$labeldescuentomaximo=$v['labeldescuento'];
				            	}	
			            	}
			            	else{
			            		if (isset($v['clave'])){
			            			$description = $description." (".$v['clave'].")";
			            			$vaciarmulta=1;
			            		}
			            	}
			            }	
						//setting new array multa			            
			            $multa['clave']			= $clavemaximo;
			            $multa['articulo']		= $articulomaximo;		
			            $multa['descripcion']	= $descripcionmaximo;
			            $multa['labeldescuento']= $labeldescuentomaximo;
			            $multa['subtotal']		= $subtotalmaximo;	
			            $multa['descuento']		= $descuentomaximo;	
			            $multa['total']			= $montomaximo;		
			            $multa['agravante']	    = $agravante;
			            
			            //agregando fecha a multa
			            $multa['fecha']			= $fecha;
			            //si hubo un error, entonces vaciamos multa
			            if($vaciarmulta==1){
			            	$multa=[];
			            }		            
			            //eliminar articulos
			            unset($multa["articulos"]);
			            
			    	}
			    	//si no hay articulos que calcular
			    	else{
			    		$multa=[];
						$errorboolean="true";
						$description="Multa no calculada. No se incluyeron artículos.";
			    	}

			    }//si no hay uma para la fecha actual, no calculamos la multa 
				else{
					$multa=[];
					$errorboolean="true";
					$description="Multa no calculada. No hay monto de UMA para la fecha actual.";
				}

			}

    	}//finaliza try
    	catch (Exception $e) {						
			$multa=[];
			$errorboolean="true";
			$description="Ocurrió un error, intenta más tarde. Error:".$e;		
		} 		

		return response()->json([
		    'error' => $errorboolean,
		    'description' => $description,
		    'multa' => $multa
		], 200, [], JSON_UNESCAPED_UNICODE); 
    }

    


}