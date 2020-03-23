<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
use Illuminate\Http\Request;

use App\Evento;
use App\Pregunta;

use DateTime;
use Illuminate\Support\Facades\Validator;
use DB;
use Helper;
use Redirect;
use Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CoronavirusController extends Controller
{
    
	public function __construct(){ }
    
    public function home(){
        $preguntas = Pregunta::orderBy('orden','asc')->get();  
        return view('homecoronavirus')->with('preguntas',$preguntas);
    }
    
    public function infografia(){
        //return view('infografiacoronavirus');
        $preguntas = Pregunta::orderBy('orden','asc')->get();  
        return view('homecoronavirus')->with('preguntas',$preguntas);
    }


    /**
     * Show evento to ciudadano
     */	
    public function crearevento($folioevento=false){

    	if($folioevento!=false){				
    		$evento = Evento::where("folio","=",$folioevento)->first();  
    	}
    	else{
    		$evento =[];
    	}
    	
    	
    	if(count($evento)>0){	    		
	    	//si el evento existe, vamos a mostrar la vista sin el formulario
	    	return view('evento')
	    			->with('evento',$evento)
	    			->with('tipo','show');	
    	}//si no,  vamos a mostrar la vista con el formulario
    	else{
    			return view('evento')
	    			->with('tipo','tosave');	
    	}    	
    }

    /**
     * Show listado eventos
     */	
    public function listadoeventos(){
    				
    	$eventos = Evento::orderBy('categoria','asc')->orderBy('nombre','asc')->get();  
        	    			    	
    	return view('listadoEventos')
    			->with('eventos',$eventos);	
    	   	
    }

    /**
     * Save evento (guardar evento)	//SERVICIO PUBLICO
     */
    public function eventosave(Request $request)
    {

		DB::beginTransaction();
		try {		
				
				//si es nuevo 
				if(request()->typepost=="save"){
					$evento = new Evento();	 
					$evento->folio = self::gen_uuid();
				}
				//si es existente
				else{
					$evento = Evento::where("id_evento","=",request()->id_evento)->first(); 					
				}
				 						    			    	    
			    //getting and setting info		
			    //datos generales
			    $evento->categoria					= request()->categoria;
			    $evento->nombre   					= request()->nombre;
			    $evento->enlace   				    = request()->enlace;
			    

			    if($evento->save()){

			    	$evento->save();
				    //detalles				    				    
				    DB::commit();
				    //return success
				    $errorboolean="false";
				    if(request()->typepost=="save"){
				    	$description='Se almacenó evento correctamente. Folio: '.$evento->folio;
					}
					else{
						$description='Se editó evento correctamente.';
					}

			    }
			    else{
			    	DB::rollback();
					$errorboolean="true";
		    		$description='Ocurrió un error, no se almacenó evento.';
			    }

		
		} catch (Exception $e) {
			DB::rollback();
			$errorboolean="true";
		    $description='Ocurrió un error, no se almacenó evento.';		
		} 
		
		return response()->json([
		    'error' => $errorboolean,
		    'description' => $description,
		    'evento' => $evento
		]);
    	
    	    					
    }







    

    /**
     * Show pregunta to ciudadano
     */	
    public function crearpregunta($foliopregunta=false){

    	if($foliopregunta!=false){				
    		$pregunta = Pregunta::where("folio","=",$foliopregunta)->first();  
    	}
    	else{
    		$pregunta =[];
    	}
    	
    	
    	if(count($pregunta)>0){	    		
	    	//si la pregunta existe, vamos a mostrar la vista sin el formulario
	    	return view('pregunta')
	    			->with('pregunta',$pregunta)
	    			->with('tipo','show');	
    	}//si no,  vamos a mostrar la vista con el formulario
    	else{
    			return view('pregunta')
	    			->with('tipo','tosave');	
    	}    	
    }

    

    /**
     * Save pregunta (guardar pregunta)	//SERVICIO PUBLICO
     */
    public function preguntasave(Request $request)
    {

		DB::beginTransaction();
		try {		
				
				//si es nuevo 
				if(request()->typepost=="save"){
					$pregunta = new Pregunta();	 
					$pregunta->folio = self::gen_uuid();
				}
				//si es existente
				else{
					$pregunta = Pregunta::where("id_pregunta","=",request()->id_pregunta)->first(); 					
				}
				 						    			    	    
			    //getting and setting info		
			    //datos generales
			    $pregunta->orden					= request()->orden;
			    $pregunta->pregunta   				= request()->pregunta;
			    $pregunta->respuesta   				= request()->respuesta;
			    

			    if($pregunta->save()){

			    	$pregunta->save();
				    //detalles				    				    
				    DB::commit();
				    //return success
				    $errorboolean="false";
				    if(request()->typepost=="save"){
				    	$description='Se almacenó pregunta correctamente. Folio: '.$pregunta->folio;
					}
					else{
						$description='Se editó pregunta correctamente.';
					}

			    }
			    else{
			    	DB::rollback();
					$errorboolean="true";
		    		$description='Ocurrió un error, no se almacenó pregunta.';
			    }

		
		} catch (Exception $e) {
			DB::rollback();
			$errorboolean="true";
		    $description='Ocurrió un error, no se almacenó pregunta.';		
		} 
		
		return response()->json([
		    'error' => $errorboolean,
		    'description' => $description,
		    'pregunta' => $pregunta
		]);
    	
    	    					
    }







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
    
	private function valid_name(String $str){
	    preg_match_all("/^(?![ .]+$)[a-zA-Z .]*$/m", $str,$matches, PREG_SET_ORDER, 0);
	    if(count($matches)==0){return false;}else{return true;}
	}
	private function valid_text(String $str){
	    preg_match_all("/^(?![ .]+$)[a-zA-Z0-9() .]*$/m", $str,$matches, PREG_SET_ORDER, 0);
	    if(count($matches)==0){return false;}else{return true;}
	}
	
	private function valid_date(String $str){
	    $format = 'Y-m-d H:i';
	    $date=$str;
	    $d = DateTime::createFromFormat($format, $date);
	    if($d){return true;}else{return false;}
	}


}