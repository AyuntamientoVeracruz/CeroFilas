<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tramite;
use App\Oficina;
use App\Tramitesxoficina;
use App\Ausencia;
use App\Cita;
use App\Holdingcita;
use App\Valoracione;
use App\Mail\SavedateMail;
use DateTime;
use Illuminate\Support\Facades\Mail;
use DB;
use Helper;
use Redirect;

class AppController extends Controller
{
    
	public function __construct(){ }





    /**
     * Show the app home section //SERVICIO PUBLICO
     */
    public function home()
    {		
        return view('index');
    }



    /**
     * Show the FAQ //SERVICIO PUBLICO
     */
    public function faq()
    {		
        return view('faq');
    }



    /**
     * Show the app crearcita section //SERVICIO PUBLICO
     */
    public function crearcita()
    {		
    	$googlemapskey=DB::table('configuraciones')
    					->where('service_name','google_maps')
    					->first();	

        return view('crearcita')
        		->with('googlemapskey',$googlemapskey->service_key);
    }

    /**
     * Show the app crearcita section //SERVICIO PUBLICO
     */
    public function crearcitacopy()
    {		
    	$googlemapskey=DB::table('configuraciones')
    					->where('service_name','google_maps')
    					->first();	

        return view('crearcitacopy')
        		->with('googlemapskey',$googlemapskey->service_key);
    }



     /**
     * Enviar mails de recordatorio //SERVICIO PUBLICO
     */
    public function sendrecordatorios()
    {
    	//obtener las citas del dia siguiente que hayan registrado mail
    	//de cada cita, enviar mail
    	//$citas=Cita::whereRaw('Date(fechahora) = CURDATE()+1')->whereNotNull('email')->get();

    	$citas = DB::table('citas')
    			->leftJoin("tramites",'tramites.id_tramite','=','citas.tramite_id')
    			->leftJoin("oficinas",'oficinas.id_oficina','=','citas.oficina_id')
    			->whereRaw('Date(fechahora) = CURDATE()+1')->whereNotNull('email')
    			->whereNull('statuscita')
    			->select("citas.*","tramites.nombre_tramite","tramites.requisitos","tramites.costo","oficinas.nombre_oficina","oficinas.direccion","oficinas.coords")
    			->get();

    	//$citas=Cita::whereRaw('Date(fechahora) = CURDATE()')->whereNotNull('email')->get();
    	foreach ($citas as $cita) {
    		$folio=$cita->folio;
    		$nombre["text"]=$cita->nombre_ciudadano." ".$cita->appaterno_ciudadano." ".$cita->apmaterno_ciudadano;
			$tramite["text"]=$cita->nombre_tramite;
			$tramite["requisitos"]=$cita->requisitos;
			$tramite["costo"]=$cita->costo;
			$oficina["text"]=$cita->nombre_oficina;
			$oficina["direccion"]=$cita->direccion;
			$oficina["coords"]=$cita->coords;
			$fechahoradate =  DateTime::createFromFormat('Y-m-d H:i:s',$cita->fechahora);
			setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
			$fechahora["text"]= strftime("%d %b, %Y @ %H:%M ",$fechahoradate->getTimestamp());
			$email["value"]=$cita->email;
			$curp["value"]=$cita->curp;			
			$recordatorio=true;
    		Mail::to($email["value"])->send(new SavedateMail($folio,$nombre,$tramite,$oficina,$fechahora,$email,$curp,$recordatorio));	
    	}
    }



    /**
     * Show valoracion to ciudadano
     */	
    public function indexValoracion($foliovaloracion=false){
    	$valoracion=Valoracione::where("folio",$foliovaloracion)->first();    	
    	if(count($valoracion)>0){	
    		$turnocompuesto	= DB::table('turnos')
	    					->leftJoin('tramites','tramites.id_tramite','=','turnos.tramite_id')
	    					->leftJoin('oficinas','oficinas.id_oficina','=','turnos.oficina_id')
	    					->leftJoin('users','users.id_user','=','turnos.user_id')
	    					->where('id_turno',$valoracion->turno_id)
	    					->select('turnos.*','tramites.nombre_tramite','oficinas.nombre_oficina','users.nombre')
	    					->first();
	    	//si la valoracion no esta vacia, vamos a mostrar la vista sin el formulario
	    	if($valoracion->estrellas!="" && $valoracion->respuesta1!=""){
	    		return view('valoracion')
	    			->with('turno',$turnocompuesto)
	    			->with('valoracion',$valoracion)
	    			->with('tipo','saved');	
    		}//si no,  vamos a mostrar la vista con el formulario
    		else{
    			return view('valoracion')
	    			->with('turno',$turnocompuesto)
	    			->with('valoracion',$valoracion)
	    			->with('tipo','show');	
    		}
    	}
    	else{
    		return view('errors.404');
    	}
    }



    /**
     * Save valoracion (guardar valoracion)	//SERVICIO PUBLICO
     */
    public function valoracionsave(Request $request)
    {
    	$url = url()->previous();    	
    	if(strlen ($url)>8){
    		$valoracionfolio = substr(url()->previous(), -8); 
    		$valoracion	= Valoracione::where('folio',$valoracionfolio)->first();
    		if(count($valoracion)>0){

    			$turnocompuesto	= DB::table('turnos')
	    					->leftJoin('tramites','tramites.id_tramite','=','turnos.tramite_id')
	    					->leftJoin('oficinas','oficinas.id_oficina','=','turnos.oficina_id')
	    					->leftJoin('users','users.id_user','=','turnos.user_id')
	    					->where('id_turno',$valoracion->turno_id)
	    					->select('turnos.*','tramites.nombre_tramite','oficinas.nombre_oficina','users.nombre')
	    					->first();

	    		DB::beginTransaction();
				try {			  			
				    //validating info
				    $estrellas=request()->estrellas;
				    $pregunta1=request()->pregunta1;
				    $pregunta2=request()->pregunta2;
				    $observaciones=request()->observaciones;
				    //setting info
				    $valoracion->estrellas=$estrellas;
				    $valoracion->respuesta1=$pregunta1;
				    $valoracion->respuesta2=$pregunta2;
				    $valoracion->observaciones=$observaciones;
				    $valoracion->save();
				    DB::commit();
				    //return success
				    return view('valoracion')
		    			->with('turno',$turnocompuesto)
		    			->with('valoracion',$valoracion)
		    			->with('tipo','saved');
				} catch (Exception $e) {
					DB::rollback();
					return view('valoracion')
		    			->with('turno',$turnocompuesto)
		    			->with('valoracion',$valoracion)
		    			->with('tipo','show')
		    			->with('error','Ocurrió un error en la base de datos, intenta de nuevo.');	
				} 
			}
			else{
				return 'Folio no existe';
			}
    	}
    	else{
    		return 'Folio no existe';
    	}
    	    					
    }



    /**
     * Tener lista de tramites completo/o filtrada por oficina //SERVICIO PUBLICO
     */
    public function gettramites($oficina=false)
    {		    	
    	if($oficina){//si recibimos id oficina
    		if(is_numeric($oficina)){//si es numerico    			
		    	//$oficina = request()->oficina;
		    	//dd($oficina);
	    		$tramitesxoficina = Tramitesxoficina::where("oficina_id",$oficina)
	    				->whereRaw('Date(apply_date) <= CURDATE()')	    				
	    				->get();
	    		//dd($tramitesxoficina);
	    		$index = 0;
		    	if(count($tramitesxoficina)>0){//si tramite por oficina existe
					foreach($tramitesxoficina as $tramitexoficina){    		
						$tramite = Tramite::find($tramitexoficina->tramite_id);
						$tramites[$index]=$tramite;
						$index++;
					}
					//ordenar tramites por nombre de tramite	 			
					usort($tramites, array($this,'compareByName'));
				}
				else{//si el tramite id existe
					$tramites=[];
				}
			}
			else{//si no es numerico, entonces regresar vacio
				$tramites=[];
			}
	    }
	    else{//si no recibimos id oficina
	    	//$tramites = Tramite::orderBy('nombre_tramite','ASC')	    			
	    	//		->get();	
    		$tramites = DB::table('tramites')
    				->select('tramites.*','dependencias.nombre_dependencia')
					->leftJoin('tramitesxoficinas','tramites.id_tramite', '=', 'tramitesxoficinas.tramite_id')
					->leftJoin('dependencias','dependencias.id_dependencia', '=', 'tramites.dependencia_id')
					->whereRaw('Date(apply_date) <= CURDATE()')
					->distinct()
					->orderBy('nombre_dependencia','ASC')	
					->orderBy('nombre_tramite','ASC')	
					->get();
	    }    
        return response()->json([
		    'tramites' => $tramites
		]);
    }//
    /** funcion auxiliar de ordanimiento de array por nombre**/
    private function compareByName($a, $b) {
		return strcmp($a["nombre_tramite"], $b["nombre_tramite"]);
	}



    /**
     * Tener lista de oficinas completo/o filtrada por tramite //SERVICIO PUBLICO
     */	
    public function getoficinas($tramite=false)
    {		
    	if($tramite){//si recibimos id tramite
    		if(is_numeric($tramite)){//si es numerico
	    		$tramite = request()->tramite;
	    		$tramitesxoficina = Tramitesxoficina::where("tramite_id",$tramite)->whereRaw('Date(apply_date) <= CURDATE()')->get();
	    		$index = 0;
		    	if(count($tramitesxoficina)>0){//si el tramite id existe
					foreach($tramitesxoficina as $tramitexoficina){    		
						$oficina = Oficina::find($tramitexoficina->oficina_id);
						$oficinas[$index]=$oficina;
						$index++;
					}
				}
				else{	//si el tramite id no existe
					$oficinas=[];
				}
			}
    		else{	//si no es numerico, entonces regresar vacio
				$oficinas=[];
			}
    	}
    	else{//si no recibimos id tramite
    		$oficinas = Oficina::get();
    	}
    	
        return response()->json([
		    'oficinas' => $oficinas
		]);
    }



	/**
     * Tener lista de dias disponibles por oficina/tramite/mes/anio //SERVICIO PUBLICO
     */	
    public function getavailabledays($oficina=false,$tramite=false,$mes=false,$anio=false)
    {	

    	//obtener fecha actual (anio,mes,dia y fecha:dd-mm-yyyy)
    	$currentyear  = date('Y');
    	$currentmonth = date('m');
    	$currentday   = date('d');
    	$fechaactual = DateTime::createFromFormat('d-m-Y', $currentday.'-'.$currentmonth.'-'.$currentyear);
    	$fechainicialactual = DateTime::createFromFormat('d-m-Y', '01-'.$currentmonth.'-'.$currentyear);
    	//tiempo maximo a ver el futuro de fechas de cita (2 meses adelante)
    	$fecha2mesesadelante =  DateTime::createFromFormat('d-m-Y',date('d-m-Y', strtotime('+3 month', strtotime('01-'.$currentmonth.'-'.$currentyear))));
		
    	//si hay paso de parametro de fecha y es numerica, el mes elegido es el enviado (y el mes no es 13 ni el año 2500)
    	if(is_numeric($mes)&&is_numeric($anio)&&$mes<13&&$anio<2500){      				
	    	$mes=request()->mes;
	    	$anio=request()->anio;	    	
    	}else{ //si no hay paso de parametro o no es numerico, seteamos el mes y año actual
    		$mes  = date('m');
    		$anio = date('Y');
    	}

    	//inicializando mes/anio seleccionado
    	//dia 1 de mes/anio seleccionado
    	$dia1messeleccionado = DateTime::createFromFormat('d-m-Y', '01-'.$mes.'-'.$anio);
    	//dias del mes que vamos a regresar en base a la fecha seleccionada
    	$dias=cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
    	//dia ultimo de mes/anio seleccionado
    	$diaultimomesseleccionado = DateTime::createFromFormat('d-m-Y', $dias.'-'.$mes.'-'.$anio); 
    	//obtener el mes de la fecha seleccionada en español
    	setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
    	$mesnombre=strftime("%B",$dia1messeleccionado->getTimestamp());

    	//para obtener mes/anio anterior
		$fechaanterior =  DateTime::createFromFormat('d-m-Y',date('d-m-Y', strtotime('-1 month', strtotime('01-'.$mes.'-'.$anio))));
    	$mesanterior   = strftime("%m",$fechaanterior->getTimestamp());
    	$anioanterior  = strftime("%Y",$fechaanterior->getTimestamp());

    	//para obtener mes/anio siguiente
    	$fechasiguiente =  DateTime::createFromFormat('d-m-Y',date('d-m-Y', strtotime('+1 month', strtotime('01-'.$mes.'-'.$anio))));
    	$messiguiente   = strftime("%m",$fechasiguiente->getTimestamp());
    	$aniosiguiente  = strftime("%Y",$fechasiguiente->getTimestamp());

    	//para obtener fechainicio y fechafin de las citas a buscar
		//si el mes y anio es el actual, entonces el dia inicial es de la fecha actual				
		if($currentmonth==$mes && $currentyear==$anio){$diainicial=$fechaactual;}
		//si no, entonces dia inicial es el dia 1 del mes seleccionado
		else{$diainicial=$dia1messeleccionado;}
		$diainicialstring = date_format($diainicial, 'Y-m-d');
		$diaultimomesseleccionadostring = date_format($diaultimomesseleccionado, 'Y-m-d');

    	//si hay oficina y tramite como parametro
		if(is_numeric($oficina)&&is_numeric($tramite)){ 	

			/*obteniendo datos base para calculo*/
			$maxtime = self::getmaxtimefortramiteinoficina($oficina);

			//obtener las citas del mes seleccionado en base al diainicial y diaultimomes
			if($fechaactual<=$diaultimomesseleccionado){								
				//obtener las citas del mes seleccionado
				$citas=self::getcitas("mes",$oficina,$diainicialstring,$diaultimomesseleccionadostring,false,false,false); 
				//obtener las ausencias	del mes seleccionado
				$ausencias=self::getausencias("mes",$oficina,$diainicialstring,$diaultimomesseleccionadostring,false,false,false); 										
			}
			else{
				$citas = [];
				$ausencias = [];
				$backmonth="false";
			}		

			//saber si el mes anterior es menor al mes actual, de ser asi, vamos a ocultar el boton de previous month
			if($fechaanterior<$fechainicialactual){
				$backmonth="false";	
			}	//de no ser asi, vamos a mostrar el boton de previous month
			else{
				$backmonth="true";	
			}

			//para ocultar los meses despues de 2 meses del mes actual
			if($fechasiguiente<$fecha2mesesadelante){
				$nextmonth="true";	
			}
			else{
				$nextmonth="false";
			}

			//DB::enableQueryLog();
			//obteniendo los tramitadores por oficina/tramite
			$tramitadores = self::gettramitadores($oficina,$tramite);		
			//return DB::getQueryLog();

			//array de fechas que vamos a retornar (inicializacion)
    		$fechas=[]; 
	    	//llenando array de fechas con los dias
	    	for($i=0;$i<$dias;$i++){
	    		$fechas[$i]=self::getdias($i,$mes,$anio,$fechaactual,$tramitadores,$maxtime,$citas,$ausencias);  			
	    	}

	    }
	    
    	return response()->json([
		    'fechas' => $fechas,
		    'meselegido' => ["mes" => [$mes,$mesnombre], "anio"=>$anio],
		    'mesanterior' => ["mes" => $mesanterior, "anio"=>$anioanterior],
		    'messiguiente' => ["mes" => $messiguiente, "anio"=>$aniosiguiente],
		    'horaejecucion' => date('h:i:s a', time()),
		    'backmonth' => $backmonth,
		    'nextmonth' => $nextmonth
		]);
    }




    /**
     * Tener lista de dias disponibles por oficina/tramite/mes/anio //SERVICIO PUBLICO
     */	
    public function getavailabledayscopy($oficina=false,$tramite=false,$mes=false,$anio=false)
    {	

    	//obtener fecha actual (anio,mes,dia y fecha:dd-mm-yyyy)
    	$currentyear  = date('Y');
    	$currentmonth = date('m');
    	$currentday   = date('d');
    	$fechaactual = DateTime::createFromFormat('d-m-Y', $currentday.'-'.$currentmonth.'-'.$currentyear);
    	$fechainicialactual = DateTime::createFromFormat('d-m-Y', '01-'.$currentmonth.'-'.$currentyear);
    	//tiempo maximo a ver el futuro de fechas de cita (2 meses adelante)
    	$fecha2mesesadelante =  DateTime::createFromFormat('d-m-Y',date('d-m-Y', strtotime('+3 month', strtotime('01-'.$currentmonth.'-'.$currentyear))));
		
    	//si hay paso de parametro de fecha y es numerica, el mes elegido es el enviado (y el mes no es 13 ni el año 2500)
    	if(is_numeric($mes)&&is_numeric($anio)&&$mes<13&&$anio<2500){      				
	    	$mes=request()->mes;
	    	$anio=request()->anio;	    	
    	}else{ //si no hay paso de parametro o no es numerico, seteamos el mes y año actual
    		$mes  = date('m');
    		$anio = date('Y');
    	}

    	//inicializando mes/anio seleccionado
    	//dia 1 de mes/anio seleccionado
    	$dia1messeleccionado = DateTime::createFromFormat('d-m-Y', '01-'.$mes.'-'.$anio);
    	//dias del mes que vamos a regresar en base a la fecha seleccionada
    	$dias=cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
    	//dia ultimo de mes/anio seleccionado
    	$diaultimomesseleccionado = DateTime::createFromFormat('d-m-Y', $dias.'-'.$mes.'-'.$anio); 
    	//obtener el mes de la fecha seleccionada en español
    	setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
    	$mesnombre=strftime("%B",$dia1messeleccionado->getTimestamp());

    	//para obtener mes/anio anterior
		$fechaanterior =  DateTime::createFromFormat('d-m-Y',date('d-m-Y', strtotime('-1 month', strtotime('01-'.$mes.'-'.$anio))));
    	$mesanterior   = strftime("%m",$fechaanterior->getTimestamp());
    	$anioanterior  = strftime("%Y",$fechaanterior->getTimestamp());

    	//para obtener mes/anio siguiente
    	$fechasiguiente =  DateTime::createFromFormat('d-m-Y',date('d-m-Y', strtotime('+1 month', strtotime('01-'.$mes.'-'.$anio))));
    	$messiguiente   = strftime("%m",$fechasiguiente->getTimestamp());
    	$aniosiguiente  = strftime("%Y",$fechasiguiente->getTimestamp());

    	//para obtener fechainicio y fechafin de las citas a buscar
		//si el mes y anio es el actual, entonces el dia inicial es de la fecha actual				
		if($currentmonth==$mes && $currentyear==$anio){$diainicial=$fechaactual;}
		//si no, entonces dia inicial es el dia 1 del mes seleccionado
		else{$diainicial=$dia1messeleccionado;}
		$diainicialstring = date_format($diainicial, 'Y-m-d');
		$diaultimomesseleccionadostring = date_format($diaultimomesseleccionado, 'Y-m-d');

    	//si hay oficina y tramite como parametro
		if(is_numeric($oficina)&&is_numeric($tramite)){ 	

			/*obteniendo datos base para calculo*/
			$maxtime = self::getmaxtimefortramiteinoficina($oficina);

			//obtener las citas del mes seleccionado en base al diainicial y diaultimomes
			if($fechaactual<=$diaultimomesseleccionado){								
				//obtener las citas del mes seleccionado
				$citas=self::getcitascopy("mes",$oficina,$diainicialstring,$diaultimomesseleccionadostring,false,false,false); 
				//obtener las ausencias	del mes seleccionado
				$ausencias=self::getausencias("mes",$oficina,$diainicialstring,$diaultimomesseleccionadostring,false,false,false); 										
			}
			else{
				$citas = [];
				$ausencias = [];
				$backmonth="false";
			}		

			//saber si el mes anterior es menor al mes actual, de ser asi, vamos a ocultar el boton de previous month
			if($fechaanterior<$fechainicialactual){
				$backmonth="false";	
			}	//de no ser asi, vamos a mostrar el boton de previous month
			else{
				$backmonth="true";	
			}

			//para ocultar los meses despues de 2 meses del mes actual
			if($fechasiguiente<$fecha2mesesadelante){
				$nextmonth="true";	
			}
			else{
				$nextmonth="false";
			}

			//DB::enableQueryLog();
			//obteniendo los tramitadores por oficina/tramite
			$tramitadores = self::gettramitadores($oficina,$tramite);
			$arraytramitadores = [];
			foreach ($tramitadores as $tramitador) {
				array_push($arraytramitadores,$tramitador->user_id);
			}	
			$tramitesxusers = self::gettramitesxusers($arraytramitadores);	
			//dd($tramitesxusers);
			//return DB::getQueryLog();

			//array de fechas que vamos a retornar (inicializacion)
    		$fechas=[]; 
	    	//llenando array de fechas con los dias
	    	for($i=0;$i<$dias;$i++){
	    		$fechas[$i]=self::getdiascopy($i,$mes,$anio,$fechaactual,$tramitadores,$maxtime,$citas,$ausencias,$tramitesxusers);  			
	    	}

	    }
	    
    	return response()->json([

    		'maxtime' => $maxtime,
    		'citas' => $citas,	
    		'ausencias' => $ausencias,
    		'tramitadores' => $tramitadores,

		    'fechas' => $fechas,
		    'meselegido' => ["mes" => [$mes,$mesnombre], "anio"=>$anio],
		    'mesanterior' => ["mes" => $mesanterior, "anio"=>$anioanterior],
		    'messiguiente' => ["mes" => $messiguiente, "anio"=>$aniosiguiente],
		    'horaejecucion' => date('h:i:s a', time()),
		    'backmonth' => $backmonth,
		    'nextmonth' => $nextmonth
		]);
    }



	/**
     * Tener lista de horas disponibles por oficina/tramite/dia/mes/anio //SERVICIO PUBLICO
     */	
    public function getavailablehours($oficina=false,$tramite=false,$dia=false,$mes=false,$anio=false)
    {	

    	//obtener fecha actual (anio,mes,dia y fecha:dd-mm-yyyy)
    	$currentyear  = date('Y');
    	$currentmonth = date('m');
    	$currentday   = date('d');
    	$fechaactual = DateTime::createFromFormat('d-m-Y', $currentday.'-'.$currentmonth.'-'.$currentyear);
		
    	//si hay paso de parametro de fecha y es numerica, el mes elegido es el enviado (y el mes no es 13 ni el año 2500)
    	if(is_numeric($mes)&&is_numeric($anio)&&$mes<13&&$anio<2500){      				
	    	$mes=$mes;
	    	$anio=$anio;	    	
    	}else{ //si no hay paso de parametro o no es numerico, seteamos el mes y año actual
    		$mes  = date('m');
    		$anio = date('Y');
    	}    	

    	//array de horas del dia que vamos a retornar (inicializacion)
    	$horas=[];
    	//si hay oficina y tramite como parametro
		if(is_numeric($oficina)&&is_numeric($tramite)){ 	

			/*obteniendo datos base para calculo*/

			//obteniendo el tiempo maximo de tramites en esa oficina
			$maxtime = self::getmaxtimefortramiteinoficina($oficina);	

			//obtener las citas del dia seleccionado
			$citas=self::getcitas("dia",$oficina,false,false,$dia,$mes,$anio); 	

			//obtener las ausencias del dia seleccionado
			$ausencias=self::getausencias("dia",$oficina,false,false,$dia,$mes,$anio); 

			//obteniendo los tramitadores por oficina/tramite
			$tramitadores = self::gettramitadores($oficina,$tramite);	
						
	    	//llenando array de horas con las horas del dia
	    	$horas[0]=self::getdias($dia-1,$mes,$anio,$fechaactual,$tramitadores,$maxtime,$citas,$ausencias);  				    	
	    }
	    
    	return response()->json([
		    'horas' => $horas,		    
		    'horaejecucion' => date('h:i:s a', time())
		]);
    }



	public function getavailablehourscopy($oficina=false,$tramite=false,$dia=false,$mes=false,$anio=false)
    {	

    	//obtener fecha actual (anio,mes,dia y fecha:dd-mm-yyyy)
    	$currentyear  = date('Y');
    	$currentmonth = date('m');
    	$currentday   = date('d');
    	$fechaactual = DateTime::createFromFormat('d-m-Y', $currentday.'-'.$currentmonth.'-'.$currentyear);
		
    	//si hay paso de parametro de fecha y es numerica, el mes elegido es el enviado (y el mes no es 13 ni el año 2500)
    	if(is_numeric($mes)&&is_numeric($anio)&&$mes<13&&$anio<2500){      				
	    	$mes=$mes;
	    	$anio=$anio;	    	
    	}else{ //si no hay paso de parametro o no es numerico, seteamos el mes y año actual
    		$mes  = date('m');
    		$anio = date('Y');
    	}    	

    	//array de horas del dia que vamos a retornar (inicializacion)
    	$horas=[];
    	//si hay oficina y tramite como parametro
		if(is_numeric($oficina)&&is_numeric($tramite)){ 	

			/*obteniendo datos base para calculo*/

			//obteniendo el tiempo maximo de tramites en esa oficina
			$maxtime = self::getmaxtimefortramiteinoficina($oficina);	

			//obtener las citas del dia seleccionado
			$citas=self::getcitascopy("dia",$oficina,false,false,$dia,$mes,$anio); 	

			//obtener las ausencias del dia seleccionado
			$ausencias=self::getausencias("dia",$oficina,false,false,$dia,$mes,$anio); 

			//obteniendo los tramitadores por oficina/tramite
			$tramitadores = self::gettramitadores($oficina,$tramite);	
			$arraytramitadores = [];
			foreach ($tramitadores as $tramitador) {
				array_push($arraytramitadores,$tramitador->user_id);
			}	
			$tramitesxusers = self::gettramitesxusers($arraytramitadores);	

	    	//llenando array de horas con las horas del dia
	    	$horas[0]=self::getdiascopy($dia-1,$mes,$anio,$fechaactual,$tramitadores,$maxtime,$citas,$ausencias,$tramitesxusers);  				    	
	    }
	    
    	return response()->json([

    		'maxtime' => $maxtime,
    		'citas' => $citas,	
    		'ausencias' => $ausencias,
    		'tramitadores' => $tramitadores,

		    'horas' => $horas,		    
		    'horaejecucion' => date('h:i:s a', time())
		]);
    }



	/**
     * Funcion de apoyo para obtener los tramitadores por oficina y tramite, retorna en array
     */
	public function getmaxtimefortramiteinoficina($oficina){

		$maxtime = DB::table('tramites')
						->leftJoin('tramitesxoficinas','tramites.id_tramite', '=', 'tramitesxoficinas.tramite_id')
						->where("oficina_id",$oficina)
						->whereRaw('Date(apply_date) <= CURDATE()')
						->max('tiempo_minutos');	
		return $maxtime;
	}





	/**
     * Funcion de apoyo para obtener los tramitadores por oficina y tramite, retorna en array
     */
	public function gettramitadores($oficina,$tramite){

		/*$tramitadores = DB::table('tramites')
						->join('tramitesxoficinas','tramites.id_tramite', '=', 'tramitesxoficinas.tramite_id')
						->join('tramitesxusers','tramites.id_tramite', '=', 'tramitesxusers.tramite_id')
						->where("oficina_id",$oficina)
						->where("id_tramite",$tramite)
						->get();*/
		$tramitadores = DB::table('tramitesxoficinas')						
						->join('tramitesxusers','tramitesxoficinas.tramite_id', '=', 'tramitesxusers.tramite_id')
						->join('users', function($join){
						    $join->on('tramitesxusers.user_id', '=', 'users.id_user')
						         ->on('users.oficina_id', '=', 'tramitesxoficinas.oficina_id');
						})	
						->where("tramitesxoficinas.oficina_id",$oficina)
						->where("tramitesxoficinas.tramite_id",$tramite)
						->where("users.estatus","activo")
						->whereRaw('Date(apply_date) <= CURDATE()')
						->select('tramitesxusers.*')
						->get();					
		return $tramitadores;
	}
	

	/**
     * Funcion de apoyo para obtener los tramitadores por oficina y tramite, retorna en array
     */
	public function gettramitesxusers($tramitadores){
		
		$tramitesxusers = DB::table('tramitesxusers')													
						->whereIn("tramitesxusers.user_id",$tramitadores)
						->select('tramitesxusers.*')
						->get();					
		return $tramitesxusers;
	}




	/**
     * Funcion de apoyo para obtener las citas por oficina y fecha (pudiendo ser por mes(fechainicio,fechafin) o por dia(dia,mes,anio) $tipo) PRIVADO
     */
	private function getcitas($tipo,$oficina,$fechainicio,$fechafin,$dia,$mes,$anio){

		if($tipo=="dia"){

			$citas = DB::table('citas')
						->select("citas.fechahora",
							DB::raw("DATE_FORMAT(citas.fechahora, '%Y-%m-%d') as fecha"),
							DB::raw("DATE_FORMAT(citas.fechahora, '%H:%i') as hora"))
						->where("oficina_id",$oficina)
						->whereDay('fechahora', '=', $dia)
						->whereMonth('fechahora', '=', $mes)
						->whereYear('fechahora', '=', $anio)
						->whereNull('statuscita')
						->get();
			$citasholding = DB::table('holdingcitas')
						->select("holdingcitas.fechahora",
							DB::raw("DATE_FORMAT(holdingcitas.fechahora, '%Y-%m-%d') as fecha"),
							DB::raw("DATE_FORMAT(holdingcitas.fechahora, '%H:%i') as hora"))
						->where("oficina_id",$oficina)
						->whereDay('fechahora', '=', $dia)
						->whereMonth('fechahora', '=', $mes)
						->whereYear('fechahora', '=', $anio)
						//->union($citas)
						->get();

		}else{

			$citas = DB::table('citas')
						->select("citas.fechahora",
							DB::raw("DATE_FORMAT(citas.fechahora, '%Y-%m-%d') as fecha"),
							DB::raw("DATE_FORMAT(citas.fechahora, '%H:%i') as hora"))
						->where("oficina_id",$oficina)
						->whereDate('fechahora', '>=', $fechainicio)
						->whereDate('fechahora', '<=', $fechafin)
						->whereNull('statuscita')
						->get();
			$citasholding = DB::table('holdingcitas')
						->select("holdingcitas.fechahora",
							DB::raw("DATE_FORMAT(holdingcitas.fechahora, '%Y-%m-%d') as fecha"),
							DB::raw("DATE_FORMAT(holdingcitas.fechahora, '%H:%i') as hora"))
						->where("oficina_id",$oficina)
						->whereDate('fechahora', '>=', $fechainicio)
						->whereDate('fechahora', '<=', $fechafin)
						//->union($citas)
						->get();

		}
		$citasresult = $citas->merge($citasholding)->sortBy('fechahora');
		return $citasresult;
	}






	/**
     * Funcion de apoyo para obtener las citas por oficina y fecha (pudiendo ser por mes(fechainicio,fechafin) o por dia(dia,mes,anio) $tipo) PRIVADO
     */
	private function getcitascopy($tipo,$oficina,$fechainicio,$fechafin,$dia,$mes,$anio){

		if($tipo=="dia"){

			$citas = DB::table('citas')
						->select("citas.fechahora","citas.tramite_id",
							DB::raw("DATE_FORMAT(citas.fechahora, '%Y-%m-%d') as fecha"),
							DB::raw("DATE_FORMAT(citas.fechahora, '%H:%i') as hora"))
						->where("oficina_id",$oficina)
						->whereDay('fechahora', '=', $dia)
						->whereMonth('fechahora', '=', $mes)
						->whereYear('fechahora', '=', $anio)
						->whereNull('statuscita')
						->get();
			$citasholding = DB::table('holdingcitas')
						->select("holdingcitas.fechahora","holdingcitas.tramite_id",
							DB::raw("DATE_FORMAT(holdingcitas.fechahora, '%Y-%m-%d') as fecha"),
							DB::raw("DATE_FORMAT(holdingcitas.fechahora, '%H:%i') as hora"))
						->where("oficina_id",$oficina)
						->whereDay('fechahora', '=', $dia)
						->whereMonth('fechahora', '=', $mes)
						->whereYear('fechahora', '=', $anio)
						//->union($citas)
						->get();

		}else{

			$citas = DB::table('citas')
						->select("citas.fechahora","citas.tramite_id",
							DB::raw("DATE_FORMAT(citas.fechahora, '%Y-%m-%d') as fecha"),
							DB::raw("DATE_FORMAT(citas.fechahora, '%H:%i') as hora"))
						->where("oficina_id",$oficina)
						->whereDate('fechahora', '>=', $fechainicio)
						->whereDate('fechahora', '<=', $fechafin)
						->whereNull('statuscita')
						->get();
			$citasholding = DB::table('holdingcitas')
						->select("holdingcitas.fechahora","holdingcitas.tramite_id",
							DB::raw("DATE_FORMAT(holdingcitas.fechahora, '%Y-%m-%d') as fecha"),
							DB::raw("DATE_FORMAT(holdingcitas.fechahora, '%H:%i') as hora"))
						->where("oficina_id",$oficina)
						->whereDate('fechahora', '>=', $fechainicio)
						->whereDate('fechahora', '<=', $fechafin)
						//->union($citas)
						->get();

		}
		$citasresult = $citas->merge($citasholding);
		//$citasresult = $citasresult->sortBy('fechahora');

		/*$citasresultsorted = $citasresult->sort(function ($a, $b) {

		    return $a->fechahora - $b->fechahora;

		});*/

		return $citasresult;
	}






	/**
     * Funcion de apoyo para obtener las ausencias por oficina y fecha (pudiendo ser por mes(fechainicio,fechafin) o por dia(dia,mes,anio) $tipo)
     */
	public function getausencias($tipo,$oficina,$fechainicio,$fechafin,$dia,$mes,$anio){

		if($tipo=="dia"){
			$fecha=$anio."/".$mes."/".$dia;	
			$ausencias = DB::table('ausencias')
						->select("ausencias.user_id",
							"ausencias.fecha_inicio as fechahorainicio",
							"ausencias.fecha_fin as fechahorafin",
							DB::raw("DATE_FORMAT(ausencias.fecha_inicio, '%Y-%m-%d') as fechainicio"),
							DB::raw("DATE_FORMAT(ausencias.fecha_inicio, '%H:%i') as horainicio"),
							DB::raw("DATE_FORMAT(ausencias.fecha_fin, '%Y-%m-%d') as fechafin"),
							DB::raw("DATE_FORMAT(ausencias.fecha_fin, '%H:%i') as horafin")
							)
						->leftJoin('users','users.id_user', '=', 'ausencias.user_id')
						->where("oficina_id",$oficina)						
						//fechadbinicio es menor a fechaseleccionada y fechadbfin es mayor a fechaseleccionada 
						->where(function ($query) use ($fecha) {
						    $query->whereDate('fecha_inicio', '<=', $fecha)
						          ->whereDate('fecha_fin', '>=', $fecha);
						})							
						->get();

		}else{

			$ausencias = DB::table('ausencias')
						->select("ausencias.user_id",
							"ausencias.fecha_inicio as fechahorainicio",
							"ausencias.fecha_fin as fechahorafin",
							DB::raw("DATE_FORMAT(ausencias.fecha_inicio, '%Y-%m-%d') as fechainicio"),
							DB::raw("DATE_FORMAT(ausencias.fecha_inicio, '%H:%i') as horainicio"),
							DB::raw("DATE_FORMAT(ausencias.fecha_fin, '%Y-%m-%d') as fechafin"),
							DB::raw("DATE_FORMAT(ausencias.fecha_fin, '%H:%i') as horafin")
							)
						->leftJoin('users','users.id_user', '=', 'ausencias.user_id')
						->where("oficina_id",$oficina)
						//fechadbinicio es mayor o igual a fechaseleccionadainicio y fechadbfin es menor o igual a fechaseleccionadafin (fecha inicio y fin dentro del mes)
						->where(function ($query) use ($fechainicio,$fechafin) {
						    $query->whereDate(DB::raw("DATE_FORMAT(ausencias.fecha_inicio, '%Y-%m-%d')"), '>=', $fechainicio)
						          ->whereDate(DB::raw("DATE_FORMAT(ausencias.fecha_fin, '%Y-%m-%d')"), '<=', $fechafin);
						})
						//fechadbinicio es mayor o igual a fechaseleccionadainicio y fechadbinicio es menor o igual a fechaseleccionadafin (fecha inicio dentro del mes y fin fuera del mes)
						->orWhere(function ($query) use ($fechainicio,$fechafin) {
						    $query->whereDate(DB::raw("DATE_FORMAT(ausencias.fecha_inicio, '%Y-%m-%d')"), '>=', $fechainicio)
						          ->whereDate(DB::raw("DATE_FORMAT(ausencias.fecha_inicio, '%Y-%m-%d')"), '<=', $fechafin)
						          ->whereDate(DB::raw("DATE_FORMAT(ausencias.fecha_fin, '%Y-%m-%d')"), '>', $fechafin);
						})	
						//fechadbfin es mayor o igual a fechaseleccionadainicio y fechadbfin es menor o igual a fechaseleccionadafin (fecha inicio fuera del mes y fin dentro del mes)
						->orWhere(function ($query) use ($fechainicio,$fechafin) {
						    $query->whereDate(DB::raw("DATE_FORMAT(ausencias.fecha_fin, '%Y-%m-%d')"), '>=', $fechainicio)
						          ->whereDate(DB::raw("DATE_FORMAT(ausencias.fecha_fin, '%Y-%m-%d')"), '<=', $fechafin)
						          ->whereDate(DB::raw("DATE_FORMAT(ausencias.fecha_inicio, '%Y-%m-%d')"), '<', $fechainicio);
						})	
						//fechadbinicio es menor a fechaseleccionadainicio y fechadbfin es mayor a fechaseleccionadafin (fecha inicio y fin fuera del mes)
						->orWhere(function ($query) use ($fechainicio,$fechafin) {
						    $query->whereDate(DB::raw("DATE_FORMAT(ausencias.fecha_inicio, '%Y-%m-%d')"), '<', $fechainicio)
						          ->whereDate(DB::raw("DATE_FORMAT(ausencias.fecha_fin, '%Y-%m-%d')"), '>', $fechafin);
						})
						->get();

		}		
		return $ausencias;
	}





	/**
     * Funcion de apoyo para calcular los dias (disponibilidades) en base al dia/mes/anio, retorna en array
     */
	private function getdias($i,$mes,$anio,$fechaactual,$tramitadores,$maxtime,$citas,$ausencias){

		$fechas=[];

		$fechaarmada = DateTime::createFromFormat('d-m-Y', ($i+1).'-'.$mes.'-'.$anio);  //armamos fecha del recorrido  		
		$fechaarmadastring = date_format($fechaarmada, 'Y-m-d');						//hacemos string de la fecha armada del recorrido
		$fechas[$i]["dayofweek"] = date('N', strtotime($fechaarmadastring));			//numero de dia de la semana
		$fechas[$i]["date"]=$fechaarmadastring;											//fecha Y-m-d
		$fechas[$i]["dia"]=$i+1;														//numero de dia
		$fechas[$i]["availabledates"]="0";												//fechas disponibles la inicializamos en cero
		if($fechaarmada<$fechaactual){
			$fechas[$i]["availableday"]=false;											//dia no disponible para elegirlo
		}
		else{    		    			    			
			$fechas[$i]["availableday"]=true;											//dia disponible para elegirlo	    			
			$fechas[$i]["horarios"]=[];													//array con horarios y por cada horario tendremos que tramitadores hay disponibles
			//por cada tramitador vamos a obtener los horarios por dia de la semana
			foreach ($tramitadores as $tramitador) {
				//lunes
				if($fechas[$i]["dayofweek"]==1){
					$fechas[$i]["horarios"]=self::gethorarios($tramitador->lunes_inicio,$tramitador->lunes_fin,$maxtime,$fechas[$i],$tramitador->user_id,$ausencias);
				}
				//martes
				if($fechas[$i]["dayofweek"]==2){
					$fechas[$i]["horarios"]=self::gethorarios($tramitador->martes_inicio,$tramitador->martes_fin,$maxtime,$fechas[$i],$tramitador->user_id,$ausencias);
				}
				//miercoles
				if($fechas[$i]["dayofweek"]==3){
					$fechas[$i]["horarios"]=self::gethorarios($tramitador->miercoles_inicio,$tramitador->miercoles_fin,$maxtime,$fechas[$i],$tramitador->user_id,$ausencias);
				}
				//jueves
				if($fechas[$i]["dayofweek"]==4){
					$fechas[$i]["horarios"]=self::gethorarios($tramitador->jueves_inicio,$tramitador->jueves_fin,$maxtime,$fechas[$i],$tramitador->user_id,$ausencias);
				}
				//viernes
				if($fechas[$i]["dayofweek"]==5){
					$fechas[$i]["horarios"]=self::gethorarios($tramitador->viernes_inicio,$tramitador->viernes_fin,$maxtime,$fechas[$i],$tramitador->user_id,$ausencias);
				}
				//sabado
				if($fechas[$i]["dayofweek"]==6){
					$fechas[$i]["horarios"]=self::gethorarios($tramitador->sabado_inicio,$tramitador->sabado_fin,$maxtime,$fechas[$i],$tramitador->user_id,$ausencias);
				}
			}
			$horasdisponibles=0;
			//ahora hay que quitar los tramitadores en base a las citas que ya hay en ese horario
			foreach($fechas[$i]["horarios"] as $elementKey => $element){
				//buscamos si hay citas para ese dia y esa hora, y obtendremos cuantas
				$citasporfechahora=$citas->where('fecha', $fechaarmadastring)->where('hora',$elementKey)->count();
				if($citasporfechahora>0){	//si hay citas 
					for($j=0;$j<$citasporfechahora;$j++) {	//en base al total de citas, removemos de los tramitadores disponibles el total de citas ocupadas
						array_pop($fechas[$i]["horarios"][$elementKey]); //unset($fechas[$i]["horarios"][$elementKey][$j]);
					}	
					//si ese horario aun tiene tramitadores, ese horario se marca como disponible
					if(sizeof($fechas[$i]["horarios"][$elementKey])>0){
						$horasdisponibles++;
					}
					//si ese horario ya no tiene tramitadores, eliminamos el horario
					else{
						unset($fechas[$i]["horarios"][$elementKey]);
					}
				}
				//si no hay citas para ese horario, entonces se marca la hora como disponible
				else{
					if(sizeof($fechas[$i]["horarios"][$elementKey])>0){
						$horasdisponibles++;
					}
					else{
						unset($fechas[$i]["horarios"][$elementKey]);
					}
				}
			}	

			//por cada hora saber si hay al menos 1 tramitador, con eso a esa hora la contamos como disponible
			$fechas[$i]["availabledates"]=$horasdisponibles;
				
		} 
		return $fechas[$i];	//retornamos el array del dia
	}	



	/**
     * Funcion de apoyo para calcular los dias (disponibilidades) en base al dia/mes/anio, retorna en array
     */
	private function getdiascopy($i,$mes,$anio,$fechaactual,$tramitadores,$maxtime,$citas,$ausencias,$tramitesxusers){

		$fechas=[];

		$fechaarmada = DateTime::createFromFormat('d-m-Y', ($i+1).'-'.$mes.'-'.$anio);  //armamos fecha del recorrido  		
		$fechaarmadastring = date_format($fechaarmada, 'Y-m-d');						//hacemos string de la fecha armada del recorrido
		$fechas[$i]["dayofweek"] = date('N', strtotime($fechaarmadastring));			//numero de dia de la semana
		$fechas[$i]["date"]=$fechaarmadastring;											//fecha Y-m-d
		$fechas[$i]["dia"]=$i+1;														//numero de dia
		$fechas[$i]["availabledates"]="0";												//fechas disponibles la inicializamos en cero
		if($fechaarmada<$fechaactual){
			$fechas[$i]["availableday"]=false;											//dia no disponible para elegirlo
		}
		else{    		    			    			
			$fechas[$i]["availableday"]=true;											//dia disponible para elegirlo	    			
			$fechas[$i]["horarios"]=[];													//array con horarios y por cada horario tendremos que tramitadores hay disponibles
			//por cada tramitador vamos a obtener los horarios por dia de la semana
			foreach ($tramitadores as $tramitador) {
				//lunes
				if($fechas[$i]["dayofweek"]==1){
					$tramitesxuserstosend = $tramitesxusers->where('user_id',$tramitador->user_id)->map(function ($item, $key) {
					    return [
					        'fecha_inicio' => $item->lunes_inicio,
					        'fecha_fin' => $item->lunes_fin,
					        'tramite_id' => $item->tramite_id
					    ];
					});					
					$fechas[$i]["horarios"]=self::gethorarioscopy($tramitador->lunes_inicio,$tramitador->lunes_fin,$maxtime,$fechas[$i],$tramitador->user_id,$ausencias,$tramitesxuserstosend);
				}
				//martes
				if($fechas[$i]["dayofweek"]==2){
					$tramitesxuserstosend = $tramitesxusers->where('user_id',$tramitador->user_id)->map(function ($item, $key) {
					    return [
					        'fecha_inicio' => $item->martes_inicio,
					        'fecha_fin' => $item->martes_fin,
					        'tramite_id' => $item->tramite_id
					    ];
					});	
					$fechas[$i]["horarios"]=self::gethorarioscopy($tramitador->martes_inicio,$tramitador->martes_fin,$maxtime,$fechas[$i],$tramitador->user_id,$ausencias,$tramitesxuserstosend);
				}
				//miercoles
				if($fechas[$i]["dayofweek"]==3){
					$tramitesxuserstosend = $tramitesxusers->where('user_id',$tramitador->user_id)->map(function ($item, $key) {
					    return [
					        'fecha_inicio' => $item->miercoles_inicio,
					        'fecha_fin' => $item->miercoles_fin,
					        'tramite_id' => $item->tramite_id
					    ];
					});	
					$fechas[$i]["horarios"]=self::gethorarioscopy($tramitador->miercoles_inicio,$tramitador->miercoles_fin,$maxtime,$fechas[$i],$tramitador->user_id,$ausencias,$tramitesxuserstosend);
				}
				//jueves
				if($fechas[$i]["dayofweek"]==4){
					$tramitesxuserstosend = $tramitesxusers->where('user_id',$tramitador->user_id)->map(function ($item, $key) {
					    return [
					        'fecha_inicio' => $item->jueves_inicio,
					        'fecha_fin' => $item->jueves_fin,
					        'tramite_id' => $item->tramite_id
					    ];
					});	
					$fechas[$i]["horarios"]=self::gethorarioscopy($tramitador->jueves_inicio,$tramitador->jueves_fin,$maxtime,$fechas[$i],$tramitador->user_id,$ausencias,$tramitesxuserstosend);
				}
				//viernes
				if($fechas[$i]["dayofweek"]==5){
					$tramitesxuserstosend = $tramitesxusers->where('user_id',$tramitador->user_id)->map(function ($item, $key) {
					    return [
					        'fecha_inicio' => $item->viernes_inicio,
					        'fecha_fin' => $item->viernes_fin,
					        'tramite_id' => $item->tramite_id
					    ];
					});	
					$fechas[$i]["horarios"]=self::gethorarioscopy($tramitador->viernes_inicio,$tramitador->viernes_fin,$maxtime,$fechas[$i],$tramitador->user_id,$ausencias,$tramitesxuserstosend);
				}
				//sabado
				if($fechas[$i]["dayofweek"]==6){
					$tramitesxuserstosend = $tramitesxusers->where('user_id',$tramitador->user_id)->map(function ($item, $key) {
					    return [
					        'fecha_inicio' => $item->sabado_inicio,
					        'fecha_fin' => $item->sabado_fin,
					        'tramite_id' => $item->tramite_id
					    ];
					});	
					$fechas[$i]["horarios"]=self::gethorarioscopy($tramitador->sabado_inicio,$tramitador->sabado_fin,$maxtime,$fechas[$i],$tramitador->user_id,$ausencias,$tramitesxuserstosend);
				}
			}
			//dd($fechas[$i]["horarios"]);

			$fechas[$i]["horarioscopy"] = $fechas[$i]["horarios"];
            
            $fechas[$i]["borradas"]=[];
            $fechas[$i]["totalcitas"]=0;
            
			$horasdisponibles=0;
			//ahora hay que quitar los tramitadores en base a las citas que ya hay en ese horario
			//de cada elemento de horarios (tramitador), checar si este en sus tramites coincide con las citas
			//$cadena=[];
			foreach($fechas[$i]["horarios"] as $elementKey => $element){
				
				//buscamos si hay citas para ese dia y esa hora, y obtendremos cuantas
				$citasporfechahora=$citas->where('fecha', $fechaarmadastring)->where('hora',$elementKey);				
				if($citasporfechahora->count()>0){	//si hay citas 
					//por cada una de las citas, a partir de la cita obtener el tramite que aplica	
					//$countered=0;
					foreach($citasporfechahora as $citaporfechahora){
					    $fechas[$i]["totalcitas"]=$fechas[$i]["totalcitas"]+1;
					//for($j=0;$j<$citasporfechahora->count();$j++) {	//en base al total de citas, removemos de los tramitadores disponibles el total de citas ocupadas
						if(sizeof($fechas[$i]["horarios"][$elementKey])>0){
							//si el tramite esta dentro de los atendidos por el tramitador
							for($j=0;$j<sizeof($fechas[$i]["horarios"][$elementKey]);$j++) {
								if(sizeof($fechas[$i]["horarios"][$elementKey][$j])>0){	
									//array_push($cadena,$fechas[$i]["horarios"][$elementKey][$j][1]);
									if(in_array($citaporfechahora->tramite_id,$fechas[$i]["horarios"][$elementKey][$j][1])){
									    //array_push($fechas[$i]["borradas"], $fechas[$i]["horarios"][$elementKey][$j][1]);
										array_pop($fechas[$i]["horarios"][$elementKey]); //unset($fechas[$i]["horarios"][$elementKey][$j]);
									
									    $j=sizeof($fechas[$i]["horarios"][$elementKey]);
									}
								}				
							
								/*if(in_array($citaporfechahora->tramite_id,$fechas[$i]["horarios"][$elementKey][$j][1])){						
									array_pop($fechas[$i]["horarios"][$elementKey][$j]); //unset($fechas[$i]["horarios"][$elementKey][$j]);
								}*/
							}			
							
							
						}
											
					}
					//si ese horario aun tiene tramitadores, ese horario se marca como disponible
					if(sizeof($fechas[$i]["horarios"][$elementKey])>0){
						$horasdisponibles++;
					}
					//si ese horario ya no tiene tramitadores, eliminamos el horario
					else{
						unset($fechas[$i]["horarios"][$elementKey]);
					}
				}
				//si no hay citas para ese horario, entonces se marca la hora como disponible
				else{
					if(sizeof($fechas[$i]["horarios"][$elementKey])>0){
						$horasdisponibles++;
					}
					else{
						unset($fechas[$i]["horarios"][$elementKey]);
					}
				}
				//$fechas[$i]["horarios"][$elementKey]["cadena"]=$cadena;		
			}	
			
			//por cada hora saber si hay al menos 1 tramitador, con eso a esa hora la contamos como disponible
			$fechas[$i]["availabledates"]=$horasdisponibles;
			
		} 
		
		return $fechas[$i];	//retornamos el array del dia
	}	




    /**
     * Funcion de apoyo para calcular los horarios en base a la hora de inicio y fin del tramitador y el maxtime de tramites de esa oficina por dia, retorna en array
     */	
    private function gethorarios($horainicio,$horafin,$maxtime,$array,$userid,$ausencias){
    	$segundosinicio=strtotime($horainicio) - strtotime('TODAY');		//convertimos el horario de inicio en segundos
		$segundosfin=strtotime($horafin) - strtotime('TODAY');				//convertimos el horario de fin en segundos
		$segundosincremento=$maxtime*60;		    						//tiempo maximo de minutos a segundos
		$fechahoraactual = new DateTime(date('Y-m-d H:i:s'));				//obtenemos la fechahora actual
		//vamos a recorrer del horarioiniciosegundos a horariofinsegundos aumentado cada segundosincremento para agregar la hora en el array horarios
		for($j=$segundosinicio;$j<$segundosfin;$j=$j+$segundosincremento){				
			$hora=gmdate("H:i", $j);										//volvemos a convertir segundos en horario
			$fechahoraarmada = new DateTime($array["date"]." ".$hora.":00");//armamos la fecha y hora con la hora del recorrido
			if($fechahoraarmada>$fechahoraactual){							//si la fechahora armada es mayor a la fechahora actual si la metemos en horarios
				if(!array_key_exists($hora,$array["horarios"])){			//si no existe dentro de horarios la key horaformateada
					$array["horarios"][$hora]=[];							//creamos la key hora formateada
				}						
				//comparamos si esta hora para este horario el esta disponible, y vemos si retorna un valor	
				$fechaabuscar=$fechahoraarmada->format('Y-m-d H:i:s');
				$ausenciasporfechahora=$ausencias->where('fechahorainicio','<=',$fechaabuscar)->where('fechahorafin','>=',$fechaabuscar)->where('user_id',$userid)->count();

				//si no hay ausencia de ese tramitador, entonces...
				if($ausenciasporfechahora==0){	
					array_push($array["horarios"][$hora],$userid);				//agregamos al tramitador a la key hora dentro de horarios
				}
			}		
		}
		//order array by key (hora)
		ksort($array["horarios"]);//asort($array["horarios"]);
		//dd($array["horarios"]);
		return $array["horarios"];											//retornamos la respuesta que seria un array con horas dentro de horarios
    }


    /**
     * Funcion de apoyo para calcular los horarios en base a la hora de inicio y fin del tramitador y el maxtime de tramites de esa oficina por dia, retorna en array
     */	
    private function gethorarioscopy($horainicio,$horafin,$maxtime,$array,$userid,$ausencias,$tramitesxuserscol){
    	$segundosinicio=strtotime($horainicio) - strtotime('TODAY');		//convertimos el horario de inicio en segundos
		$segundosfin=strtotime($horafin) - strtotime('TODAY');				//convertimos el horario de fin en segundos
		$segundosincremento=$maxtime*60;		    						//tiempo maximo de minutos a segundos
		$fechahoraactual = new DateTime(date('Y-m-d H:i:s'));				//obtenemos la fechahora actual
		//vamos a recorrer del horarioiniciosegundos a horariofinsegundos aumentado cada segundosincremento para agregar la hora en el array horarios
		for($j=$segundosinicio;$j<$segundosfin;$j=$j+$segundosincremento){				
			$hora=gmdate("H:i", $j);										//volvemos a convertir segundos en horario
			$fechahoraarmada = new DateTime($array["date"]." ".$hora.":00");//armamos la fecha y hora con la hora del recorrido
			if($fechahoraarmada>$fechahoraactual){							//si la fechahora armada es mayor a la fechahora actual si la metemos en horarios
				if(!array_key_exists($hora,$array["horarios"])){			//si no existe dentro de horarios la key horaformateada
					$array["horarios"][$hora]=[];							//creamos la key hora formateada
				}						
				//comparamos si esta hora para este horario el esta disponible, y vemos si retorna un valor	
				$fechaabuscar=$fechahoraarmada->format('Y-m-d H:i:s');
				$ausenciasporfechahora=$ausencias->where('fechahorainicio','<=',$fechaabuscar)->where('fechahorafin','>=',$fechaabuscar)->where('user_id',$userid)->count();

				//si no hay ausencia de ese tramitador, entonces...
				if($ausenciasporfechahora==0){	
					//dd($tramitesxuserscol);
					$tramitesxuser=$tramitesxuserscol->where('fecha_inicio','<=',$hora.":00")->where('fecha_fin','>=',$hora.":00");
					//dd($tramitesxuser);
					$arrayuserwithtramites=[];
					foreach ($tramitesxuser as $tramitexuser) {						
						array_push($arrayuserwithtramites,$tramitexuser["tramite_id"]);
					}
					$userarray=array($userid,$arrayuserwithtramites); 					
					array_push($array["horarios"][$hora],$userarray);				//agregamos al tramitador a la key hora dentro de horarios
				}
			}		
		}
		//order array by key (hora)
		ksort($array["horarios"]);//asort($array["horarios"]);
		//dd($array["horarios"]);
		return $array["horarios"];											//retornamos la respuesta que seria un array con horas dentro de horarios
    }
	




    /**
     * holdingcita (guardar previo cita para retener fecha) //SERVICIO PUBLICO
     */
    public function holdingcita(Request $request)
    {
    	DB::beginTransaction();
    	try {
			
	    	$oficina=request()->oficina;
	    	$fechahora=request()->fechahora;
	    	$tramite=request()->tramite;

	    	//validacion si al guardar previo ya no hay disponibilidad por que hayan tardado para dar click a la hora	
	    	
	    	//obtener dia,mes,anio de fechahora  	
	    	$timestamp =strtotime($fechahora["value"].":00");	    	
	    	$dia 	= intval(date("d", $timestamp)); 
	    	$mes 	= intval(date("m", $timestamp));
	    	$anio 	= intval(date("Y", $timestamp));
	    	//obtener hora de fechahora
	    	$fechahoraarray = explode(" ",$fechahora["value"]);
	    	$hora=$fechahoraarray[1];
	    	//obtener horas disponibles del dia  
	    	$horasdisponibles=self::getavailablehours(intval($oficina["value"]),intval($tramite["value"]),$dia,$mes,$anio);
	    	$data 			= $horasdisponibles->getData();
	    	//obtener horarios y horaejecucion
	    	$horaejecucion  = $data->horaejecucion;
	    	$horarios 		= (array) $data->horas[0]->horarios;
	    	$disponible = 0;
	    	//validamos si la hora seleccionada sigue dentro de las horas disponibles, si se encuentra se marca como 1
	    	foreach($horarios as $elementey => $element){
	    		if($elementey==$hora){
	    			$disponible=1;
	    		}
	    	}
	    	//si esta disponible (disponible mayor a 0)
	    	if($disponible>0){
		    	$folio = self::gen_uuid();
		    	$holdingcita= new Holdingcita();			
				$holdingcita->oficina_id	= $oficina["value"];
				$holdingcita->fechahora 	= $fechahora["value"].":00";
				$holdingcita->folio 		= $folio; 							
				$holdingcita->save();

				$errorboolean="false";
				$description="<k>Fecha/hora reservada con éxito</k>"; 
				DB::commit();
			}else{
				$holdingcita=[];
				$errorboolean="true";
				$description="<k>La fecha/hora ya fue reservada por alguien más a ".$horaejecucion.". Intenta con otra fecha/hora.</k>"; 
			}

		} catch (Exception $e) {
			DB::rollback();
			$holdingcita=[];
			$errorboolean="true";
			$description="Ocurrió un error en la base de datos, intenta más tarde. ".$e;

		} 
		return response()->json([
		    'error' => $errorboolean,
		    'description' => $description,
		    'holdingcita' => $holdingcita
		]);
    }




    /**
     * holdingcita (guardar previo cita para retener fecha) //SERVICIO PUBLICO
     */
    public function holdingcitacopy(Request $request)
    {
    	DB::beginTransaction();
    	try {
			
	    	$oficina=request()->oficina;
	    	$fechahora=request()->fechahora;
	    	$tramite=request()->tramite;

	    	//validacion si al guardar previo ya no hay disponibilidad por que hayan tardado para dar click a la hora	
	    	
	    	//obtener dia,mes,anio de fechahora  	
	    	$timestamp =strtotime($fechahora["value"].":00");	    	
	    	$dia 	= intval(date("d", $timestamp)); 
	    	$mes 	= intval(date("m", $timestamp));
	    	$anio 	= intval(date("Y", $timestamp));
	    	//obtener hora de fechahora
	    	$fechahoraarray = explode(" ",$fechahora["value"]);
	    	$hora=$fechahoraarray[1];
	    	//obtener horas disponibles del dia  
	    	$horasdisponibles=self::getavailablehourscopy(intval($oficina["value"]),intval($tramite["value"]),$dia,$mes,$anio);
	    	$data 			= $horasdisponibles->getData();
	    	//obtener horarios y horaejecucion
	    	$horaejecucion  = $data->horaejecucion;
	    	$horarios 		= (array) $data->horas[0]->horarios;
	    	$disponible = 0;
	    	//validamos si la hora seleccionada sigue dentro de las horas disponibles, si se encuentra se marca como 1
	    	foreach($horarios as $elementey => $element){
	    		if($elementey==$hora){
	    			$disponible=1;
	    		}
	    	}
	    	//si esta disponible (disponible mayor a 0)
	    	if($disponible>0){
		    	$folio = self::gen_uuid();
		    	$holdingcita= new Holdingcita();
		    	$holdingcita->tramite_id	= $tramite["value"];			
				$holdingcita->oficina_id	= $oficina["value"];
				$holdingcita->fechahora 	= $fechahora["value"].":00";
				$holdingcita->folio 		= $folio; 							
				$holdingcita->save();

				$errorboolean="false";
				$description="<k>Fecha/hora reservada con éxito</k>"; 
				DB::commit();
			}else{
				$holdingcita=[];
				$errorboolean="true";
				$description="<k>La fecha/hora ya fue reservada por alguien más a ".$horaejecucion.". Intenta con otra fecha/hora.</k>"; 
			}

		} catch (Exception $e) {
			DB::rollback();
			$holdingcita=[];
			$errorboolean="true";
			$description="Ocurrió un error en la base de datos, intenta más tarde. ".$e;

		} 
		return response()->json([
		    'error' => $errorboolean,
		    'description' => $description,
		    'holdingcita' => $holdingcita
		]);
    }





    /**
     * remove holdingcita (eliminar previo cita para no retener fecha) //SERVICIO PUBLICO
     */
    public function removeholdingcita(Request $request)
    {
    	DB::beginTransaction();
    	try {
	    	
	    	$folio = request()->holdingfolio;	 
	    	$holdingcita = Holdingcita::where('folio',$folio)->delete();

			$errorboolean="false";
			$description="<k>Fecha liberada con éxito</k>"; 
			DB::commit();	
		} catch (Exception $e) {
			DB::rollback();
			$errorboolean="true";
			$description="Ocurrió un error en la base de datos, intenta más tarde. ".$e;

		} 
		return response()->json([
		    'error' => $errorboolean,
		    'description' => $description
		]);
    }





    /**
     * Tener confirmacion de registro de cita filtrada por folio   //SERVICIO PUBLICO
     */	
    public function getconfirmacionregistro($folio=false)
    {		
    	if($folio && strlen($folio)==8){//si recibimos folio
    		
    		//$folio = request()->folio;
    		return self::getcitabyfolio($folio,'confirmacion');
			
    	}
    	else{//si no recibimos id tramite
    		return "Falta folio ó Folio esta en formato incorrecto";
    	}
		
    }





    /**
     * Obtener cita de busqueda pagina principal   				  //SERVICIO PUBLICO
     */	
    public function getcita(Request $request)
    {		
    	$folio = request()->folio;

    	if($folio && strlen($folio)==8){//si recibimos folio
    		
    		$response=self::getcitabyfolio($folio,'search');
			
			if($response=="Folio no existe"){
				return Redirect::back()->withErrors(['Folio ingresado inválido, verifica.']); 
			}
			else{
				return $response;
			}

    	}
    	else{//si no recibimos id tramite
    		if($request->exists){
    			return "Falta folio ó Folio esta en formato incorrecto";
    		}	
    		else{
    			return redirect()->route('/');	
    		}
    	}
		
    }



    /**
     * Cancelar cita por folio  				  //SERVICIO PUBLICO
     */	
    public function cancelarcita(Request $request)
    {
    	$folio = request()->folio;
    	if($folio && strlen($folio)==8){//si recibimos folio
    		try{
    			$cita=Cita::where('folio',$folio)->first();
    			$cita->statuscita='cancelada';
    			$cita->save();
    			DB::commit();
    			//$request = new \Illuminate\Http\Request();
    			//$request->replace(['folio' => $folio]);
    			//return Route::post('getcita', array('uses' => 'AppController@getcita'));//redirect()->route('getcita'); //Redirect::back();
    			return Redirect()->route('getcita', ['folio'=>$folio]);//::back()->withInput();
    		}
    		catch (Exception $e) {
				DB::rollback();
				//$errorboolean="true";
				//$description="Ocurrió un error en la base de datos, intenta más tarde. ".$e;
			} 
    	}
    	else{

    	}

    }



    /**
     * Get cita by folio (aux)	//SERVICIO PRIVADO
     */	
    private function getcitabyfolio($folio=false,$tipo=false)
    {
    	$cita = DB::table('citas')
			->leftJoin("tramites",'tramites.id_tramite','=','citas.tramite_id')
			->leftJoin("oficinas",'oficinas.id_oficina','=','citas.oficina_id')
			->where("folio",$folio)
			->select("citas.*","tramites.nombre_tramite","tramites.requisitos","tramites.costo","oficinas.nombre_oficina","oficinas.direccion","oficinas.coords")
			->first();

		$index = 0;
    	if(count($cita)>0){//si la cita existe
							
			$nombre["text"]=$cita->nombre_ciudadano." ".$cita->appaterno_ciudadano." ".$cita->apmaterno_ciudadano;
			$tramite["text"]=$cita->nombre_tramite;
			$oficina["text"]=$cita->nombre_oficina;
			$oficina["direccion"]=$cita->direccion;
			$oficina["coords"]=$cita->coords;
			$fechahoradate =  DateTime::createFromFormat('Y-m-d H:i:s',$cita->fechahora);
			setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
			$fechahora["text"]= strftime("%d %b, %Y @ %H:%M ",$fechahoradate->getTimestamp());;
			$email["value"]=$cita->email;
			$curp["value"]=$cita->curp;
			$tramite["requisitos"]=$cita->requisitos;
			$tramite["costo"]=$cita->costo;

			$googlemapskey = DB::table('configuraciones')
                    ->where('service_name','google_maps')
                    ->first();   

			return view('emails.savedateMail')
					->with('folio',$folio)
					->with('nombre',$nombre)
					->with('tramite',$tramite)
					->with('oficina',$oficina)
					->with('fechahora',$fechahora)
					->with('email',$email)
					->with('curp',$curp)
					->with('print',true)
					->with('googlemapskey',$googlemapskey)
					->with('tipo',$tipo)
					->with('statuscita',$cita->statuscita);
		}
		else{	//si el tramite id no existe				
			return "Folio no existe";
		}
    }



    public function getUserIpAddr(){
       $ipaddress = '';
       if (isset($_SERVER['HTTP_CLIENT_IP']))
           $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
       else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
           $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
       else if(isset($_SERVER['HTTP_X_FORWARDED']))
           $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
       else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
           $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
       else if(isset($_SERVER['HTTP_FORWARDED']))
           $ipaddress = $_SERVER['HTTP_FORWARDED'];
       else if(isset($_SERVER['REMOTE_ADDR']))
           $ipaddress = $_SERVER['REMOTE_ADDR'];
       else
           $ipaddress = 'UNKNOWN';    
       return $ipaddress;
    }
    
    
    
    /**
     * Save date (guardar cita)	//SERVICIO PUBLICO
     */
    public function savedate(Request $request)
    {		

    	$ip=$this->getUserIpAddr();//\Request::ip();//request()->getClientIp(true);//$_SERVER['REMOTE_ADDR'];//$this->getIp(); //request()->ip();//"123";//$_SERVER['REMOTE_ADDR'];
		//validate ip not allow more than 10 requests by hour
		$date = new \DateTime();
		$date->modify('-1 hours');
		$formatted_date = $date->format('Y-m-d H:i:s');
    	$citas = Cita::where("ip",$ip)->where('created_at', '>',$formatted_date)->count();

    	if($citas<100){
			$error=0;
			$errortext="";
			DB::beginTransaction();
			try {
			    
			    //validating info
			    $nombre=request()->nombre;		         
			         $nombrecortado = explode("#", $nombre["value"]);
			         if(count($nombrecortado)<3){$error++;$errortext=$errortext."<br>&bull; No colocaste nombre completo";}
			         else{
			            $nombres=$nombrecortado[0]; 
			                if (!self::valid_name($nombres)){$error++;$errortext=$errortext."<br>&bull; Nombre debe contener solo letras";}
			                else{$nombre["nombre"]=ucwords($nombres);}
			            $apellidopaterno=$nombrecortado[1]; 
			                if (!self::valid_name($apellidopaterno)){$error++;$errortext=$errortext."<br>&bull; Apellido paterno debe contener solo letras";}
			                else{$nombre["apellidopaterno"]=ucwords($apellidopaterno);}
			            $apellidomaterno=$nombrecortado[2];
			                if (!self::valid_name($apellidomaterno)){$error++;$errortext=$errortext."<br>&bull; Apellido materno debe contener solo letras";}
			                else{$nombre["apellidomaterno"]=ucwords($apellidomaterno);}
			            $nombre["text"]=ucwords($nombres." ".$apellidopaterno." ".$apellidomaterno);
			         }
			    $tramite=request()->tramite; 		 
			    	if (!is_numeric ($tramite["value"])){$error++;$errortext=$errortext."<br>&bull; Trámite debe ser número";}
			    	else{
				    	//validate numero de tramite from db, si no, entonces mostrar error and get text from db for tramite 
				    	$tramiteobjeto = Tramite::find($tramite["value"]);
				    	if(count($tramiteobjeto)>0){
				   			$tramite["text"]= $tramiteobjeto->nombre_tramite;
				   			$tramite["requisitos"]= $tramiteobjeto->requisitos;
				   			$tramite["costo"]= $tramiteobjeto->costo;
				   		}	
				   		else{
				   			$error++;$errortext=$errortext."<br>&bull; Trámite no existe";
				   		}
			   		}	        
			    $oficina=request()->oficina;
			    	if (!is_numeric ($oficina["value"])){$error++;$errortext=$errortext."<br>&bull; Oficina debe ser número";}
					else{
				    	//validate numero de oficina from db, si no, entonces mostrar error and get text from db for oficina 
				    	$oficinaobjeto = Oficina::find($oficina["value"]);
				    	if(count($oficinaobjeto)>0){
				   			$oficina["text"]= $oficinaobjeto->nombre_oficina;
				   			$oficina["coords"]=$oficinaobjeto->coords;	
				   			$oficina["direccion"]=$oficinaobjeto->direccion;	
				   		}	
				   		else{
				   			$error++;$errortext=$errortext."<br>&bull; Oficina no existe";
				   		}
			   		}	           
			    $fechahora=request()->fechahora;
			    	if($fechahora["value"]!=null){
				    	if (!self::valid_date($fechahora["value"])){$error++;$errortext=$errortext."<br>&bull; Fecha inválida";}
				    	else{
				    		//validate disponibilidad de fecha/hora, si no, entonces mostrar error
				    		/*$arraygetavailability = [];
				    		$arraygetavailability["tramite"]=$tramite["value"];
				    		$arraygetavailability["oficina"]=$oficina["value"];
				    		$arraygetavailability["fechahora"]=$fechahora["value"];
				    		$requestgetavailability = new Request($arraygetavailability);
				    		$responsefromavailability=self::getavailabledatetime($requestgetavailability);
				    		$datafromresponse = $responsefromavailability->getData();
				    		if($datafromresponse->error=="false"){*/
					    		//convertir fecha/hora a formato humano
				    			$fechahoradate =  DateTime::createFromFormat('Y-m-d H:i:s',$fechahora["value"].":00");
				    			setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');	    					
					        	$fechahora["text"]= strftime("%d %b, %Y @ %H:%M ", $fechahoradate->getTimestamp());
					        /*}else{
					        	$error++;$errortext=$errortext."<br>&bull; Fecha y hora ocupada, elija otra";
					        }*/
				        }	 
			        }  
			        else{
			        	$error++;$errortext=$errortext."<br>&bull; Fecha y hora no seleccionada";
			        }    
			    if(request()->email!=""){     
			    	$email=request()->email;
			    	if($email["value"]!=""){		              		        
			        	$email["value"]=strtolower($email["value"]); 
			        	if (!self::valid_email($email["value"])){$error++;$errortext=$errortext."<br>&bull; Email inválido";}
			        }
			        else{
			        	$email="";
			        }
			    }
			    else{
			    	$email="";
			    }

			    if(request()->telefono!=""){     
			    	$telefono=request()->telefono;
			    	if($telefono["value"]!=""){		              		        
			        	$telefono["value"]=strtolower($telefono["value"]); 
			        	if (!self::valid_phone($telefono["value"])){$error++;$errortext=$errortext."<br>&bull; Teléfono inválido";}
			        }
			        else{
			        	$telefono="";
			        }
			    }
			    else{
			    	$telefono="";
			    }

			    $curp=request()->curp;		        
			        $curp["value"]=strtoupper($curp["value"]);
			        if (self::valid_curp($curp["value"])==0){$error++;$errortext=$errortext."<br>&bull; CURP inválido";}

			    if($error==0){    
					
					//borramos el holding
					$folioholding = request()->holdingfolio;	 
	    			$holdingcita = Holdingcita::where('folio',$folioholding)->delete();		
	    			
	    			//checamos si sigue disponible la fecha
	    			/*$dia    = intval(date("d")); 
               		$mes    = intval(date("m"));
                	$anio   = intval(date("Y"));			
					$fechahoraarray = explode(" ",$fechahora["value"]);
	    			$hora=$fechahoraarray[1];
					$horasdisponibles=self::getavailablehours(intval($oficina["value"]),intval($tramite["value"]),$dia,$mes,$anio);
			    	$data 			= $horasdisponibles->getData();
			    	//obtener horarios y horaejecucion
			    	$horaejecucion  = $data->horaejecucion;
			    	$horarios 		= (array) $data->horas[0]->horarios;
			    	$disponible = 0;
			    	//validamos si la hora seleccionada sigue dentro de las horas disponibles, si se encuentra se marca como 1
			    	foreach($horarios as $elementey => $element){
			    		if($elementey==$hora){
			    			$disponible=1;
			    		}
			    	}
			    	//si no esta disponible (disponible igual a 0),entonces regresamos mensaje que esa hora ya esta ocupada para que busque otra
			    	if($disponible==0){
			    		//DB::rollback();      
			            $errorboolean="true";
						$description="Fecha/hora ocupada, por favor elije otra."; 
						return response()->json([
						    'error' => $errorboolean,
						    'description' => $description
						]);
			    	}*/

			        //generar folio
			    	$folio = self::gen_uuid();//'SC000'.rand(1, 100);

			    	$cita= new Cita();			
			    	$cita->folio				= $folio;	
					$cita->tramite_id			= $tramite["value"];
					$cita->oficina_id			= $oficina["value"];
					$cita->fechahora 			= $fechahora["value"].":00";
					$cita->nombre_ciudadano		= $nombre["nombre"];
					$cita->appaterno_ciudadano	= $nombre["apellidopaterno"];
					$cita->apmaterno_ciudadano	= $nombre["apellidomaterno"];
					if($email!=""){ 
						$cita->email 				= $email["value"];
					}
					if($telefono!=""){
						$cita->telefono 			= $telefono["value"];
					}
					$cita->curp 				= $curp["value"];	
					$cita->ip 					= $ip;								
					$cita->save();
					
					//mail wrote by user, so, send an email
					if($email!=""){ 	
				        //send mail and the status of sending
				        Mail::to($email["value"])->send(new SavedateMail($folio,$nombre,$tramite,$oficina,$fechahora,$email,$curp,false,false));	
				        //retornar json como salida: tipodesalida, descripcion		             
				        if(count(Mail::failures()) == 0){		
				            $errorboolean="false";
							$description="<k>Cita registrada con Folio: <b>".$folio."</b>.<br>Te enviamos un email con la confirmación.<br>Revisa el siguiente link para imprimir la confirmación.<br><a href='".route('getconfirmacionregistro')."/".$folio."'>Imprimir confirmación</a></k>"; 
							DB::commit();
				        }else{ 		     
				        	DB::rollback();      
				            $errorboolean="true";
							$description="Ocurrió un error de envío de mail y la cita no fue registrada, intenta más tarde."; 
				        } 
				    }
				    else{		//user dont give us a mail, so, return a link to print a receipt
				    	$errorboolean="false";
						$description="<k>Cita registrada con Folio: <b>".$folio."</b>.<br>Revisa el siguiente link para imprimir la confirmación.<br><a href='".route('getconfirmacionregistro')."/".$folio."'>Imprimir confirmación</a></k>"; 
						DB::commit();	
				    }
			    }
			    else{
			    	$errorboolean="true";
					$description="Los siguientes campos son incorrectos:".$errortext;
			    }
			} catch (Exception $e) {
				DB::rollback();
				$errorboolean="true";
				$description="Ocurrió un error en la base de datos, intenta más tarde. ".$e;
			} 
		}
		else{
			$errorboolean="true";
			$description="Ya no puedes crear más citas por el momento. Espera 1 hora. ";
		}
        return response()->json([
		    'error' => $errorboolean,
		    'description' => $description
		]);
    }





    /*
     *****Tener lista de disponibilidad por tramite/oficina/fechahora****
    public function getavailabledatetime(Request $request)
    {    	
    	//mejorar validacion, ya que hay que checar la disponibilidad de los tramitadores para ese tramite de esa oficina
		$citas = Cita::where("oficina_id",request()->oficina)
					->where("tramite_id",request()->tramite)
					->where("fechahora",request()->fechahora)
					->get();

		if(count($citas)==0){			
    		$errorboolean="false";
    		$description="";
    	}else{
    		$errorboolean="true";
    		$description="";	
    	}

    	return response()->json([
		    'error' => $errorboolean,
		    'description' => $description
		]);
    }
    */





    /******AUXILIAR FUNCTIONS******/
    /*GENERATE UNIQUE FOLIO*/
    private function gen_uuid($len=8) {
	    $hex = md5("yourSaltHere" . uniqid("", true));
	    $pack = pack('H*', $hex);
	    $tmp =  base64_encode($pack);
	    $uid = preg_replace("#(*UTF8)[^A-Za-z0-9]#", "", $tmp);
	    $len = max(4, min(128, $len));
	    while (strlen($uid) < $len)
	        $uid .= gen_uuid(22);
	    return substr($uid, 0, $len);
	}
    /*VALIDATE FUNCTIONS*/
    private function valid_email(String $str) {
	    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
	}
    private function valid_phone(String $str) {
    	if(is_numeric($str) && strlen($str)==10){
    		return TRUE;
    	}
    	else{
    		return FALSE;
    	}	    
	}
	private function valid_name(String $str){
	    preg_match_all("/^(?![ .]+$)[a-zA-Z .]*$/m", $str,$matches, PREG_SET_ORDER, 0);
	    if(count($matches)==0){return false;}else{return true;}
	}
	private function valid_text(String $str){
	    preg_match_all("/^(?![ .]+$)[a-zA-Z0-9() .]*$/m", $str,$matches, PREG_SET_ORDER, 0);
	    if(count($matches)==0){return false;}else{return true;}
	}
	private function valid_coords(String $str){
	    return preg_match('/^(?<lat>(-?(90|(\d|[1-8]\d)(\.\d{1,20}){0,1})))\,{1}\s?(?<long>(-?(180|(\d|\d\d|1[0-7]\d)(\.\d{1,20}){0,1})))$/', $str);
	}
	public function valid_curp(String $str){
	    //return preg_match('/^[A-ZÑ&]{3,4}\d{6}(?:[A-Z\d]{8})?$/', $str);
		return preg_match('/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/', $str);
	}
	private function valid_date(String $str){
	    $format = 'Y-m-d H:i';
	    $date=$str;
	    $d = DateTime::createFromFormat($format, $date);
	    if($d){return true;}else{return false;}
	}


}