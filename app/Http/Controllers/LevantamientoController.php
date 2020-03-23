<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
use Illuminate\Http\Request;

use App\Fichadetalle;
use App\Fichalevantamiento;
use App\Fichasubsistema;
use App\Fichacodigopostal;
use DateTime;
use Illuminate\Support\Facades\Validator;
use DB;
use Helper;
use Redirect;
use App\Mail\SavelevantamientoMail;
use Illuminate\Support\Facades\Mail;
use Response;
use Illuminate\Support\Str;

class LevantamientoController extends Controller
{
    
	public function __construct(){ }


    /**
     * Show levantamiento to ciudadano
     */	
    public function crearlevantamiento($foliolevantamiento=false){

    	$googlemapskey=DB::table('configuraciones')
    					->where('service_name','google_maps')
    					->first();	
    	if($foliolevantamiento!=false){				
    		$levantamiento = Fichalevantamiento::where("folio","=",$foliolevantamiento)->first();  
    	}
    	else{
    		$levantamiento =[];
    	}
    	$subsistemas = Fichasubsistema::select('subsistema')->distinct()->orderBy('subsistema','ASC')->get();  
    	$elementos   = Fichasubsistema::orderBy('subsistema','ASC')->orderBy('elemento','ASC')->get(); 
    	$codigospostales   = Fichacodigopostal::get();  
    	$colonias = $codigospostales->sortBy('d_asenta');
    	$codigospostales = $codigospostales->unique('d_codigo'); 

    	if(count($levantamiento)>0){	    		
	    	//si el levantamiento existe, vamos a mostrar la vista sin el formulario
	    	return view('levantamiento')
	    			->with('levantamiento',$levantamiento)
	    			->with('subsistemas',$subsistemas)
	    			->with('elementos',$elementos)
	    			->with('codigospostales',$codigospostales)
	    			->with('colonias',$colonias)
	    			->with('tipo','show')
	    			->with('googlemapskey',$googlemapskey->service_key);	
    	}//si no,  vamos a mostrar la vista con el formulario
    	else{
    			return view('levantamiento')
    				->with('subsistemas',$subsistemas)
    				->with('elementos',$elementos)
    				->with('codigospostales',$codigospostales)
    				->with('colonias',$colonias)
	    			->with('tipo','tosave')
	    			->with('googlemapskey',$googlemapskey->service_key);	
    	}    	
    }



    /**
     * listadolevantamiento
     */	
    public function listadolevantamiento(){

    	$levantamientos = Fichalevantamiento::orderBy('created_at','asc')->get();
    	//dd($levantamientos); 
    	return view('listalevantamiento')
	    			->with('levantamientos',$levantamientos); 

    }

    /**
     * descargarfotoslevantamiento
     */	
    public function descargarfotoslevantamiento(){

    	$levantamientos = Fichalevantamiento::orderBy('created_at','asc')->get();
    	//dd($levantamientos);    	
	    $zip_file = 'images.zip'; // Name of our archive to download
	    $zip = new \ZipArchive();
	    $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

	    foreach($levantamientos as $levantamiento){

	    	$output_file=Str::slug($levantamiento->nombre, '-').".png";
	    	$base64_string="data:image/png;base64,".$levantamiento->foto_fachada_principal;
	    	$file = fopen($output_file, "wb");
		    $data = explode(',', $base64_string);
		    fwrite($file, base64_decode($data[1]));
		    fclose($file);	    		    	
	    	$zip->addFile($output_file, $output_file);
		}
	    
	    $zip->close();

	    return Response::download($zip_file);    	

    }


    /**
     * Save levantamiento (guardar levantamiento)	//SERVICIO PUBLICO
     */
    public function levantamientosave(Request $request)
    {

    	//validate picture
    	$rules = [
		    'foto_fachada' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048'
		];
		$validator = Validator::make($request->all(), $rules);    	
		if ($validator->fails())
        {
            // It failed
        	$errorboolean="true";
			$description=$validator->messages()->first('foto_fachada');
			return response()->json([
			    'error' => $errorboolean,
			    'description' => $description
			]);
        }

		DB::beginTransaction();
		try {		
			
				$levantamiento = new Fichalevantamiento();	  			
			    
			    //getting and setting info
			    //datos generales
			    $levantamiento->folio 						= self::gen_uuid();
			    $levantamiento->fecha_elaboracion			= date("Y-m-d H:i:s");
			    $levantamiento->direccion_elabora 			= ucfirst(request()->direccion_elabora);
			    $levantamiento->nombre_registra_datos		= ucwords(request()->nombre_registra);
			    $levantamiento->cargo 						= ucfirst(request()->cargo);
			    $levantamiento->tel_contacto 				= request()->telefono;
			    //datos equipamiento
			    $levantamiento->clave_catastral				= request()->clave_catastral;
			    $levantamiento->subsistema_id 				= request()->subsistema;
			    $levantamiento->elemento_id 				= request()->elemento;
			    $levantamiento->nombre 						= request()->nombre_equipamiento;
			    $levantamiento->clave_escolar				= request()->clave_escolar;
			    $levantamiento->inicio_actividad 			= request()->inicio_actividades;
			    $levantamiento->fin_actividad	 			= request()->termino_actividades;		    		     	
			    $levantamiento->foto_fachada_principal		= base64_encode(file_get_contents($request->file('foto_fachada')));
			    $levantamiento->ubicacion_croquis_lat_lon	= request()->ubicacion_croquis_lat_lon;
			    $levantamiento->entidad_federal_opera		= request()->entidad_federal_opera;
			    $levantamiento->entidad_federal_mantenimiento= request()->entidad_federal_mantenimiento;
			    //datos de contacto y direccion
			    $levantamiento->tipo_calle					= request()->tipo_vialidad;
			    $levantamiento->nombre_calle 				= request()->nombre_vialidad;
			    $levantamiento->numero_oficial 				= request()->numero_oficial;
			    $levantamiento->referencia_calle1 			= request()->entre_calle1;
			    $levantamiento->referencia_calle2 			= request()->entre_calle2;
			    $levantamiento->colonia_id 					= request()->colonia;
			    $levantamiento->codigo_postal 				= request()->cp;
			    $levantamiento->telefono 					= request()->telefono_contacto;
			    $levantamiento->celular 					= request()->celular_contacto;
			    $levantamiento->correo_electronico 			= request()->email_contacto;
			    //datos de unidad basica servicio
			    $levantamiento->unidad_basica_servicio		= request()->ubs;
			    $levantamiento->numero_ubs					= request()->num_ubs;
			    $levantamiento->numero_usuarios_totales		= request()->num_usuarios;
			    $levantamiento->numero_usuarios_ubs			= request()->num_usuarios_ubs;
			    $levantamiento->radio_cobertura				= request()->radio_cobertura;
			    //datos de conectividad y accesibilidad
			    $levantamiento->conectividad_accesibilidad	= request()->conectividad_accesibilidad;
			    //datos de recubrimiento de vialidad
			    $levantamiento->recubrimiento_vialidad		= request()->recubrimiento_vialidad;
			    $levantamiento->estado_conservacion_vialidad= request()->estado_vialidad;
			    //datos de acceso transporte
			    $levantamiento->acceso_transporte_publico	= request()->acceso_transporte;
			    $levantamiento->nombre_ruta_transporte		= request()->nombre_ruta1;
			    $levantamiento->tiempo_promedio_espera		= request()->tiempo_ruta1;
			    $levantamiento->otra_ruta_menos_200			= request()->nombre_ruta2;
			    $levantamiento->tiempo_promedio_espera_200	= request()->tiempo_ruta2;
			    $levantamiento->otra_ruta_menos_500			= request()->nombre_ruta3;
			    $levantamiento->tiempo_promedio_espera_500	= request()->tiempo_ruta3;
			    $levantamiento->facil_tomar_taxi			= request()->facil_taxi;
			    $levantamiento->tiempo_promedio_tomar_taxi 	= request()->tiempo_taxi;
			    //datos de servicios
			    $levantamiento->servicio_agua_potable 		= request()->servicio_agua_potable;
			    $levantamiento->servicio_continuo_agua 		= request()->servicio_continuo_agua;
			    $levantamiento->calida_servicio_agua 		= request()->calida_servicio_agua;
			    $levantamiento->servico_continuo_agua_no 	= request()->servico_continuo_agua_no;
			    $levantamiento->consumo_promedio_mensual_agua= request()->consumo_promedio_mensual_agua;
			    $levantamiento->forma_abastesimiento_agua 	= request()->forma_abastesimiento_agua;
			    $levantamiento->drenaje_sanitario			= request()->drenaje_sanitario;
			    $levantamiento->calidad_servicio_drenaje 	= request()->calidad_servicio_drenaje;
			    $levantamiento->energia_electica 			= request()->energia_electica;
			    $levantamiento->iluminacion_suficiente 		= request()->iluminacion_suficiente;
			    $levantamiento->calidad_iluminacion		 	= request()->calidad_iluminacion;
			    $levantamiento->energia_electica_no 		= request()->energia_electica_no;
			    $levantamiento->manzana_cuenta_alumbrado_publico= request()->alumbrado_manzana;
			    $levantamiento->cuenta_alumbrado_punto_cercano_tranporte_publico= request()->alumbrado_transporte;
			    $levantamiento->condiciones_alumbrado_publico= request()->alumbrado_condiciones;
			    $levantamiento->cuenta_servicio_telefonia	= request()->telefonia;
			    $levantamiento->cuenta_servicio_internet_area_administrativa	= request()->internet_administrativos;
			    $levantamiento->cuenta_servicio_internet_gratuito	= request()->internet_usuarios;
			    $levantamiento->cuenta_servicio_recoleccion_basura	= request()->recoleccion_basura;
			    $levantamiento->cuenta_servicio_vigilancia_diurna	= request()->vigilancia_diurna;
			    $levantamiento->cuenta_servicio_vigilancia_nocturna	= request()->vigilancia_nocturna;
			    $levantamiento->cuenta_personal_mantenimiento		= request()->personal_mantenimiento;
			    //datos de caracteristicas construccion
			    $levantamiento->caracteristicas_muros		= request()->muros; 
			    $levantamiento->caracteristicas_muros_nota	= request()->muros_nota; 
			    $levantamiento->caracteristicas_pisos		= request()->pisos; 
			    $levantamiento->caracteristicas_pisos_nota	= request()->pisos_nota; 
			    $levantamiento->caracteristicas_techo		= request()->techos; 
			    $levantamiento->caracteristicas_techo_nota	= request()->techos_nota; 
			    //datos de servicios sanitarios
			    $levantamiento->servicios_sanitarios_usuarios= request()->sanitario_usuarios; 
			    $levantamiento->sanitario_separado_genero	= request()->sanitario_generos; 
			    $levantamiento->numero_servicios_wc_mujeres	= request()->wc_mujeres;
			    $levantamiento->numero_servicios_wc_hombres	= request()->wc_hombres; 
			    $levantamiento->numero_servicos_wc_mixtos	= request()->wc_mixtos;
			    $levantamiento->cuenta_servicio_sanitario_administrativo	= request()->sanitario_personal;
			    $levantamiento->cuenta_servicio_sanitario_usuario_inmueble	= request()->sanitario_compartido;
			    $levantamiento->cuantos_wc_administrativo_mujeres	= request()->wc_personal_mujeres;
			    $levantamiento->cuantos_wc_administrativo_hombres	= request()->wc_personal_hombres;
			    $levantamiento->cuantos_wc_administrativo_mixtos	= request()->wc_personal_mixto;
			    //datos de espacios o areas 
			    $levantamiento->metros_cuadrados_predio					= request()->metros_cuadrados_predio; 
			    $levantamiento->numero_cajones_estacionamiento_usuarios	= request()->numero_cajones_estacionamiento_usuarios; 
			    $levantamiento->numero_cajones_estacionamiento_empleados= request()->numero_cajones_estacionamiento_empleados;
			    //datos de areas deportivas
			    $levantamiento->cuenta_areas_deportivas					= request()->cuenta_areas_deportivas; 
			    //datos de areas verdes
			    $levantamiento->cuenta_areas_verdes						= request()->cuenta_areas_verdes;
			    $levantamiento->estado_areas_verdes						= request()->estado_areas_verdes;
			    $levantamiento->arboles_dentro_predio					= request()->arboles_dentro_predio;
			    $levantamiento->cuantos_arboles							= request()->cuantos_arboles;	

			    if($levantamiento->save()){

				    //detalles
				    //datos de areas deportivas	
				    $nombres_areas = request()->nombre_areadeportiva;
				    $cantidad_areas = request()->cantidad_areadeportiva;	
				    $largo_areas = request()->largo_areadeportiva;	
				    $ancho_areas = request()->ancho_areadeportiva;

				    for($i = 0; $i < count($nombres_areas); $i++){
				    	$levantamientodetalle = new Fichadetalle();	 
				    	$levantamientodetalle->ficha_id = $levantamiento->id_ficha;
				    	$levantamientodetalle->tipo = "Espacio";	
				    	$levantamientodetalle->nombre = $nombres_areas[$i];
				    	$levantamientodetalle->cantidad = $cantidad_areas[$i];		
				    	$levantamientodetalle->largo = $largo_areas[$i];
				    	$levantamientodetalle->ancho = $ancho_areas[$i];
				    	$levantamientodetalle->save();	
				    }	

				    //datos de arboles	
				    $nombres_arboles = request()->nombre_arbol;
				    $cantidad_arboles = request()->cantidad_arbol;	
				    $observaciones_arboles = request()->observaciones_arbol;

				    for($i = 0; $i < count($nombres_arboles); $i++){
				    	$levantamientodetalle = new Fichadetalle();	 
				    	$levantamientodetalle->ficha_id = $levantamiento->id_ficha;
				    	$levantamientodetalle->tipo = "Árbol";	
				    	$levantamientodetalle->nombre = $nombres_arboles[$i];
				    	$levantamientodetalle->cantidad = $cantidad_arboles[$i];		
				    	$levantamientodetalle->notas = $observaciones_arboles[$i];
				    	$levantamientodetalle->save();	
				    }
				    
				    DB::commit();
				    Mail::to($levantamiento->correo_electronico)->send(new SavelevantamientoMail($levantamiento));
				    //return success
				    $errorboolean="false";
				    $description='Se almacenó levantamiento correctamente. Folio: '.$levantamiento->folio.'. Consulte el correo electrónico.';

			    }
			    else{
			    	DB::rollback();
					$errorboolean="true";
		    		$description='Ocurrió un error, no se almacenó levantamiento.';
			    }

		
		} catch (Exception $e) {
			DB::rollback();
			$errorboolean="true";
		    $description='Ocurrió un error, no se almacenó levantamiento.';		
		} 
		
		return response()->json([
		    'error' => $errorboolean,
		    'description' => $description,
		    'levantamiento' => $levantamiento
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
    private function valid_email(String $str) {
	    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
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