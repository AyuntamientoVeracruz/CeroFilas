<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
use Illuminate\Http\Request;

use App\Obra;
use App\Fichacodigopostal;
use DateTime;
use Illuminate\Support\Facades\Validator;
use DB;
use Helper;
use Redirect;
//use App\Mail\SaveobraMail;
use Illuminate\Support\Facades\Mail;
use Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ObrasController extends Controller
{
    
	public function __construct(){ }


    /**
     * Show obra to ciudadano
     */	
    public function crearobra($folioobra=false){

    	$googlemapskey=DB::table('configuraciones')
    					->where('service_name','google_maps')
    					->first();	
    	if($folioobra!=false){				
    		$obra = Obra::where("id","=",$folioobra)->first();  
    	}
    	else{
    		$obra =[];
    	}
    	
    	$codigospostales   = Fichacodigopostal::get();  
    	$colonias = $codigospostales->sortBy('d_asenta');

    	if(count($obra)>0){	    		
	    	//si el obra existe, vamos a mostrar la vista sin el formulario
	    	return view('obra')
	    			->with('obra',$obra)
	    			->with('colonias',$colonias)
	    			->with('tipo','show')
	    			->with('googlemapskey',$googlemapskey->service_key);	
    	}//si no,  vamos a mostrar la vista con el formulario
    	else{
    			return view('obra')
    				->with('colonias',$colonias)
	    			->with('tipo','tosave')	    			
	    			->with('googlemapskey',$googlemapskey->service_key);	
    	}    	
    }




    /**
     * Show listado obras
     */	
    public function listadoobras(){
    				
    	$obras = Obra::where('tipo_contenido','Obras')->orderBy('id','desc')->get();  
        	    			    	
    	return view('listadoObras')
    			->with('obras',$obras);	
    	   	
    }



    /**
     * descargarfotosobra
     */	
    public function descargarobrasjson(){


    	header('Content-type: script/javascript');

		// Set your CSV feed
		$feed = 'http://201.116.64.10/dist/data.csv';//route('descargarobras');

		// Arrays we'll use later
		$keys = array();
		$newArray = array();

		// Function to convert CSV into associative array
		function csvToArray($file, $delimiter) { 
		  if (($handle = fopen($file, 'r')) !== FALSE) { 
		    $i = 0; 
		    while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) { 
		      for ($j = 0; $j < count($lineArray); $j++) { 
		        $arr[$i][$j] = $lineArray[$j]; 
		      } 
		      $i++; 
		    } 
		    fclose($handle); 
		  } 
		  return $arr; 
		} 

		// Do it
		$data = csvToArray($feed, ',');

		// Set number of elements (minus 1 because we shift off the first row)
		$count = count($data) - 1;
		  
		//Use first row for names  
		$labels = array_shift($data);  

		foreach ($labels as $label) {
		  $keys[] = $label;
		}

		// Add Ids, just in case we want them later
		$keys[] = 'id';

		for ($i = 0; $i < $count; $i++) {
		  $data[$i][] = $i;
		}
		  
		// Bring it all together
		for ($j = 0; $j < $count; $j++) {
		  $d = @array_combine($keys, $data[$j]); //Æ -- add "@" in from of array combine to surpress warnings.
		  $newArray[$j] = $d;
		}

		// Print it out as JSON
		echo '(' . json_encode($newArray) . ');'; //Æ -- return as a callback for JSONP.

    }


    /**
     * descargarfotosobra
     */	
    public function descargarcsvobras(){

		//header('Access-Control-Allow-Origin: *');
		//header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

    	$headers = array(
	        "Content-type" => "text/csv",
	        "Content-Disposition" => "attachment; filename=dataobras.csv",
	        "Pragma" => "public",
	        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
	        "Expires" => "0",
	    );

    	$obras = Obra::where('tipo_contenido','Obras')->get();
    	
    	$columns = array(
    		'id',
    		'entorno',
    		'nombre',
    		'etapa',
    		'etapa_detalle',
    		'tipo',
    		'area_responsable',
    		'descripcion',
    		'monto_contrato',
    		'comuna',
    		'barrio',
    		'calle_1',
    		'seccion',
    		'manzana',
    		'parcela',
    		'direccion',
    		'lat',
    		'lng',
    		'fecha_inicio',
    		'fecha_fin_inicial',
    		'plazo_meses',
    		'porcentaje_avance',
    		'imagen_1',
    		'imagen_2',
    		'imagen_3',
    		'imagen_4',
    		'licitacion_oferta_empresa',
    		'licitacion_anio',
    		'contratacion_tipo',
    		'nro_contratacion',
    		'cuit_contratista',
    		'benficiarios',
    		'mano_obra',
    		'compromiso',
    		'destacada',
    		'ba_elige',
    		'link_interno',
    		'pliego_descarga',
    		'expediente-numero',
    		'estudio_ambiental_descarga',
    		'financiamiento');
    	
    	/*
    	$output = '';
    	$output .= implode(',', $columns);
      	$output .= "\n"; 
      	$total=count($obras);
      	$i=1;
      	foreach ($obras as $obra) {
        	$output .= implode('.', array($obra->id,
		    		$obra->entorno,
		    		'"'.$obra->nombre'"',
		    		$obra->etapa,
		    		$obra->etapa_detalle,
		    		$obra->tipo,
		    		$obra->area_responsable,
		    		$obra->descripcion,
		    		$obra->monto_contrato,
		    		$obra->comuna,
		    		$obra->barrio,
		    		$obra->calle_1,
		    		$obra->seccion,
		    		$obra->manzana,
		    		$obra->parcela,
		    		$obra->direccion,
		    		$obra->lat,
		    		$obra->lng,
		    		$obra->fecha_inicio,
		    		$obra->fecha_fin_inicial,
            		$obra->plazo_meses,
            		$obra->porcentaje_avance,
		    		$obra->imagen_1,
		    		$obra->imagen_2,
		    		$obra->imagen_3,
		    		$obra->imagen_4,
		    		$obra->licitacion_oferta_empresa,
		    		$obra->licitacion_anio,
		    		$obra->contratacion_tipo,
		    		$obra->nro_contratacion,
		    		$obra->cuit_contratista,
		    		$obra->benficiarios,
		    		$obra->mano_obra,
		    		$obra->compromiso,
		    		"",
		    		"",
		    		$obra->link_interno,
		    		$obra->pliego_descarga,
		    		"",
		    		"",
		    		$obra->financiamiento));
	        $output .= ',';
	      	if($i<$total){
	      		$output .= "\n";
	      	}
	      	$i++;
	    }

    	return Response::make($output, 200, $headers);
		*/

    	

    	
	    $callback = function() use ($obras, $columns)
	    {	   
	    	$total=count($obras);
    		$i=1; 	
	        $file=fopen('php://output','w');	        
	        fputcsv($file, $columns);	        
	        foreach($obras as $obra) {
	            fwrite($file,$obra->id);
	            fwrite($file,',"'.$obra->entorno.'"');
	            fwrite($file,',"'.str_replace('"',"",$obra->nombre).'"');
	            fwrite($file,',"'.$obra->etapa.'"');
	            fwrite($file,',"'.$obra->etapa_detalle.'"');
	            fwrite($file,',"'.$obra->tipo.'"');
	            fwrite($file,',"'.$obra->area_responsable.'"');
	            fwrite($file,',"'.str_replace('"',"",$obra->descripcion).'"');
	            fwrite($file,','.$obra->monto_contrato);
	            fwrite($file,','.$obra->comuna);
	            fwrite($file,',"'.$obra->barrio.'"');
	            fwrite($file,',"'.$obra->calle_1.'"');
	            fwrite($file,',"'.$obra->seccion.'"');
	            fwrite($file,',"'.$obra->manzana.'"');
	            fwrite($file,',"'.$obra->parcela.'"');
	            fwrite($file,',"'.$obra->direccion.'"');
	            fwrite($file,','.$obra->lat);
	            fwrite($file,','.$obra->lng);
	            fwrite($file,',"'.$obra->fecha_inicio.'"');
	            fwrite($file,',"'.$obra->fecha_fin_inicial.'"');
	            fwrite($file,','.$obra->plazo_meses);
	            fwrite($file,','.$obra->porcentaje_avance);
	            fwrite($file,',"'.$obra->imagen_1.'"');
	            fwrite($file,',"'.$obra->imagen_2.'"');
	            fwrite($file,',"'.$obra->imagen_3.'"');
	            fwrite($file,',"'.$obra->imagen_4.'"');
	            fwrite($file,',"'.$obra->licitacion_oferta_empresa.'"');
	            fwrite($file,','.$obra->licitacion_anio);
	            fwrite($file,',"'.$obra->contratacion_tipo.'"'); 
	            fwrite($file,',"'.$obra->nro_contratacion.'"');
	            fwrite($file,',"'.$obra->cuit_contratista.'"');
	            fwrite($file,','.$obra->benficiarios);
	            fwrite($file,','.$obra->mano_obra);
	            fwrite($file,',"'.str_replace('"',"",$obra->compromiso).'"');
	            fwrite($file,',""');
	            fwrite($file,',""');
	            fwrite($file,',"'.$obra->link_interno.'"');
	            fwrite($file,',"'.$obra->pliego_descarga.'"');
	            fwrite($file,',""');
	            fwrite($file,',""');
	            fwrite($file,',"'.str_replace('"',"",$obra->financimiento).'"');
	            fwrite($file,",");
	            if($i<$total){
		      		fwrite($file,"\n");
		      	}
	            $i++;
	            /*fputcsv($file,array($obra->id,
			    		$obra->entorno,
			    		$obra->nombre,
			    		$obra->etapa,
			    		$obra->etapa_detalle,
			    		$obra->tipo,
			    		$obra->area_responsable,
			    		$obra->descripcion,
			    		$obra->monto_contrato,
			    		$obra->comuna,
			    		$obra->barrio,
			    		$obra->calle_1,
			    		$obra->seccion,
			    		$obra->manzana,
			    		$obra->parcela,
			    		$obra->direccion,
			    		$obra->lat,
			    		$obra->lng,
			    		$obra->fecha_inicio,
			    		$obra->fecha_fin_inicial,
	            		$obra->plazo_meses,
	            		$obra->porcentaje_avance,
			    		$obra->imagen_1,
			    		$obra->imagen_2,
			    		$obra->imagen_3,
			    		$obra->imagen_4,
			    		$obra->licitacion_oferta_empresa,
			    		$obra->licitacion_anio,
			    		$obra->contratacion_tipo,
			    		$obra->nro_contratacion,
			    		$obra->cuit_contratista,
			    		$obra->benficiarios,
			    		$obra->mano_obra,
			    		$obra->compromiso,
			    		"",
			    		"",
			    		$obra->link_interno,
			    		$obra->pliego_descarga,
			    		"",
			    		"",
			    		$obra->financiamiento));*/
	        }	        
			fclose($file);			
	    };

		return Response::stream($callback, 200, $headers); 
		



    }


    /**
     * Save obra (guardar obra)	//SERVICIO PUBLICO
     */
    public function obrasave(Request $request)
    {

    	//validate picture
    	$rules = [
		    'imagen_1' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10048',
		    'imagen_2' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10048',
		    'imagen_3' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10048',
		    'imagen_4' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10048'
		];
		$validator = Validator::make($request->all(), $rules);    	
		if ($validator->fails())
        {
        	//dd($validator->messages());
            // It failed
        	$errorboolean="true";
			$description="Imagen(es) inválida(s) en peso o formato";//$validator->messages()->first();
			return response()->json([
			    'error' => $errorboolean,
			    'description' => $description
			]);
        }

        if($request->file('imagen_1')!=""){
        	$urlImageName1= $request->file('imagen_1')->store('/images');
        	$urlImageName1 = asset('storage/'.$urlImageName1);
    	}
        if($request->file('imagen_2')!=""){
        	$urlImageName2= $request->file('imagen_2')->store('/images');
        	$urlImageName2 = asset('storage/'.$urlImageName2);
        }
        if($request->file('imagen_3')!=""){
        	$urlImageName3= $request->file('imagen_3')->store('/images');
        	$urlImageName3 = asset('storage/'.$urlImageName3);
        }
        if($request->file('imagen_4')!=""){
        	$urlImageName4= $request->file('imagen_4')->store('/images');
        	$urlImageName4 = asset('storage/'.$urlImageName4);
        }

		DB::beginTransaction();
		try {		
				
				$lat_lng = explode(",", request()->lat_lng);

				//si es nuevo 
				if(request()->typepost=="save"){
					$obra = new Obra();	 
					$obra->folio = self::gen_uuid();
				}
				//si es existente
				else{
					$obra = Obra::where("id","=",request()->id)->first(); 					
				}
				 						    			    	    
			    //getting and setting info		
			    //$obra->email 						= request()->email;
			    //datos generales
			    $obra->tipo_contenido				= "Obras";
			    $obra->entorno						= "";
			    $obra->nombre						= request()->nombre;
			    $obra->descripcion 					= request()->descripcion;
			    $obra->compromiso 				    = request()->compromiso;
			    $obra->tipo 				    	= request()->tipo;
			    $obra->etapa						= request()->etapa;
			    $obra->comuna						= request()->comuna;
			    $obra->area_responsable				= request()->area_responsable;
			    $obra->porcentaje_avance			= request()->porcentaje_avance;
			    $obra->mano_obra					= request()->mano_obra;
			    $obra->plazo_meses					= request()->plazo_meses;
			    $obra->benficiarios					= request()->benficiarios;
			    $obra->fecha_inicio					= request()->fecha_inicio;
			    $obra->fecha_fin_inicial			= request()->fecha_fin_inicial;
			    //datos financieros y contrato			    
			    $obra->monto_contrato 				= request()->monto_contrato;
			    $obra->nro_contratacion 			= request()->nro_contratacion;
			    $obra->contratacion_tipo			= request()->contratacion_tipo;
			    $obra->licitacion_anio				= request()->licitacion_anio;
			    $obra->contratacion_tipo			= request()->contratacion_tipo;
			    $obra->nro_contratacion				= request()->nro_contratacion;
			    $obra->financiamiento				= request()->financiamiento;
			    //datos direccion y contacto
			    $obra->calle_1	 					= request()->calle_1;		    		     				    
			    $obra->direccion					= request()->direccion;
			    $obra->barrio						= request()->barrio;
			    $obra->lat							= $lat_lng[0];
			    $obra->lng							= $lat_lng[1];


			    if(count($lat_lng)>1){
			    	$obra->lat						= $lat_lng[0];
			    	$obra->lng						= $lat_lng[1];
			    }
			    else{
			    	DB::rollback();
					$errorboolean="true";
		    		$description='Ocurrió un error de ubicacion del mapa, verifique tener la coordenada completa, no se almacenó acción.';
		    		return response()->json([
					    'error' => $errorboolean,
					    'description' => $description,
					    'obra' => $obra
					]);
			    }

			    //fotos de obra
			    if($request->file('imagen_1')!=""){
			    	$obra->imagen_1						= $urlImageName1;
				}
			    if($request->file('imagen_2')!=""){
			    	$obra->imagen_2 					= $urlImageName2;
			    }
			    if($request->file('imagen_3')!=""){
			    	$obra->imagen_3 					= $urlImageName3;
			    }
			    if($request->file('imagen_4')!=""){
			    	$obra->imagen_4 					= $urlImageName4;
			    }
			    //$obra->foto_fachada_principal		= base64_encode(file_get_contents($request->file('foto_fachada')));

			    if($obra->save()){

			    	$obra->link_interno = "http://201.116.64.10/dist/app.html#/obra/".$obra->id;
			    	$obra->save();
				    //detalles				    				    
				    DB::commit();
				    //Mail::to($obra->email)->send(new SaveobraMail($obra));
				    //return success
				    $errorboolean="false";
				    if(request()->typepost=="save"){
				    	$description='Se almacenó obra correctamente. Folio: '.$obra->folio;
					}
					else{
						$description='Se editó obra correctamente.';
					}

			    }
			    else{
			    	DB::rollback();
					$errorboolean="true";
		    		$description='Ocurrió un error, no se almacenó obra.';
			    }

		
		} catch (Exception $e) {
			DB::rollback();
			$errorboolean="true";
		    $description='Ocurrió un error, no se almacenó obra.';		
		} 
		
		return response()->json([
		    'error' => $errorboolean,
		    'description' => $description,
		    'obra' => $obra
		]);
    	
    	    					
    }







    /**
     * edit or create accion
     */	
    public function crearaccion($folioaccion=false){

    	$googlemapskey=DB::table('configuraciones')
    					->where('service_name','google_maps')
    					->first();	
    	if($folioaccion!=false){				
    		$accion = Obra::where("id","=",$folioaccion)->first();  
    	}
    	else{
    		$accion =[];
    	}
    	
    	$codigospostales   = Fichacodigopostal::get();  
    	$colonias = $codigospostales->sortBy('d_asenta');

    	if(count($accion)>0){	    		
	    	//si el obra existe, vamos a mostrar la vista sin el formulario
	    	return view('accion')
	    			->with('accion',$accion)
	    			->with('colonias',$colonias)
	    			->with('tipo','show')
	    			->with('googlemapskey',$googlemapskey->service_key);	
    	}//si no,  vamos a mostrar la vista con el formulario
    	else{
    			return view('accion')
    				->with('colonias',$colonias)
	    			->with('tipo','tosave')	    			
	    			->with('googlemapskey',$googlemapskey->service_key);	
    	}    	
    }




    /**
     * Show listado acciones
     */	
    public function listadoacciones(){
    				
    	$acciones = Obra::where('tipo_contenido','Acciones')->orderBy('id','desc')->get();  
        	    			    	
    	return view('listadoAcciones')
    			->with('acciones',$acciones);	
    	   	
    }



    /**
     * descargar csv acciones
     */	
    public function descargarcsvacciones(){

    	$headers = array(
	        "Content-type" => "text/csv",
	        "Content-Disposition" => "attachment; filename=dataacciones.csv",
	        "Pragma" => "no-cache",
	        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
	        "Expires" => "0"
	    );

    	$obras = Obra::where('tipo_contenido','Acciones')->get();
    	
    	$columns = array(
    		'id',
    		'entorno',
    		'nombre',
    		'etapa',
    		'etapa_detalle',
    		'tipo',
    		'area_responsable',
    		'descripcion',
    		'monto_contrato',
    		'comuna',
    		'barrio',
    		'calle_1',
    		'seccion',
    		'manzana',
    		'parcela',
    		'direccion',
    		'lat',
    		'lng',
    		'fecha_inicio',
    		'fecha_fin_inicial',
    		'plazo_meses',
    		'porcentaje_avance',
    		'imagen_1',
    		'imagen_2',
    		'imagen_3',
    		'imagen_4',
    		'licitacion_oferta_empresa',
    		'licitacion_anio',
    		'contratacion_tipo',
    		'nro_contratacion',
    		'cuit_contratista',
    		'benficiarios',
    		'mano_obra',
    		'compromiso',
    		'destacada',
    		'ba_elige',
    		'link_interno',
    		'pliego_descarga',
    		'expediente-numero',
    		'estudio_ambiental_descarga',
    		'financiamiento'
		);
    	/*
	    $callback = function() use ($acciones, $columns)
	    {
	        $file = fopen('php://output', 'w');
	        fputcsv($file, $columns);

	        foreach($acciones as $accion) {

	            fputcsv($file, 
	            	array(
	            		$accion->id,
			    		$accion->entorno,
			    		$accion->nombre,
			    		$accion->etapa,
			    		$accion->etapa_detalle,
			    		$accion->tipo,
			    		$accion->area_responsable,
			    		$accion->descripcion,
			    		$accion->monto_contrato,
			    		$accion->comuna,
			    		$accion->barrio,
			    		$accion->calle_1,
			    		$accion->seccion,
			    		$accion->manzana,
			    		$accion->parcela,
			    		$accion->direccion,
			    		$accion->lat,
			    		$accion->lng,
			    		$accion->fecha_inicio,
			    		$accion->fecha_fin_inicial,
	            		$accion->plazo_meses,
	            		$accion->porcentaje_avance,
			    		$accion->imagen_1,
			    		$accion->imagen_2,
			    		$accion->imagen_3,
			    		$accion->imagen_4,
			    		$accion->licitacion_oferta_empresa,
			    		$accion->licitacion_anio,
			    		$accion->contratacion_tipo,
			    		$accion->nro_contratacion,
			    		$accion->cuit_contratista,
			    		$accion->benficiarios,
			    		$accion->mano_obra,
			    		$accion->compromiso,
			    		"",
			    		"",
			    		$accion->link_interno,
			    		$accion->pliego_descarga,
			    		"",
			    		"",
			    		$accion->financiamiento
	            	)
	            );
	        }
	        fclose($file);
	    };

		return Response::stream($callback, 200, $headers); 
    	*/
    	$callback = function() use ($obras, $columns)
	    {	   
	    	$total=count($obras);
    		$i=1; 	
	        $file=fopen('php://output','w');	        
	        fputcsv($file, $columns);	        
	        foreach($obras as $obra) {
	            fwrite($file,$obra->id);
	            fwrite($file,',"'.$obra->entorno.'"');
	            fwrite($file,',"'.str_replace('"',"",$obra->nombre).'"');
	            fwrite($file,',"'.$obra->etapa.'"');
	            fwrite($file,',"'.$obra->etapa_detalle.'"');
	            fwrite($file,',"'.$obra->tipo.'"');
	            fwrite($file,',"'.$obra->area_responsable.'"');
	            fwrite($file,',"'.str_replace('"',"",$obra->descripcion).'"');
	            fwrite($file,','.$obra->monto_contrato);
	            fwrite($file,','.$obra->comuna);
	            fwrite($file,',"'.$obra->barrio.'"');
	            fwrite($file,',"'.$obra->calle_1.'"');
	            fwrite($file,',"'.$obra->seccion.'"');
	            fwrite($file,',"'.$obra->manzana.'"');
	            fwrite($file,',"'.$obra->parcela.'"');
	            fwrite($file,',"'.$obra->direccion.'"');
	            fwrite($file,','.$obra->lat);
	            fwrite($file,','.$obra->lng);
	            fwrite($file,',"'.$obra->fecha_inicio.'"');
	            fwrite($file,',"'.$obra->fecha_fin_inicial.'"');
	            fwrite($file,','.$obra->plazo_meses);
	            fwrite($file,','.$obra->porcentaje_avance);
	            fwrite($file,',"'.$obra->imagen_1.'"');
	            fwrite($file,',"'.$obra->imagen_2.'"');
	            fwrite($file,',"'.$obra->imagen_3.'"');
	            fwrite($file,',"'.$obra->imagen_4.'"');
	            fwrite($file,',"'.$obra->licitacion_oferta_empresa.'"');
	            fwrite($file,','.$obra->licitacion_anio);
	            fwrite($file,',"'.$obra->contratacion_tipo.'"'); 
	            fwrite($file,',"'.$obra->nro_contratacion.'"');
	            fwrite($file,',"'.$obra->cuit_contratista.'"');
	            fwrite($file,','.$obra->benficiarios);
	            fwrite($file,','.$obra->mano_obra);
	            fwrite($file,',"'.str_replace('"',"",$obra->compromiso).'"');
	            fwrite($file,',""');
	            fwrite($file,',""');
	            fwrite($file,',"'.$obra->link_interno.'"');
	            fwrite($file,',"'.$obra->pliego_descarga.'"');
	            fwrite($file,',""');
	            fwrite($file,',""');
	            fwrite($file,',"'.str_replace('"',"",$obra->financimiento).'"');
	            fwrite($file,",");
	            if($i<$total){
		      		fwrite($file,"\n");
		      	}
	            $i++;
	            /*fputcsv($file,array($obra->id,
			    		$obra->entorno,
			    		$obra->nombre,
			    		$obra->etapa,
			    		$obra->etapa_detalle,
			    		$obra->tipo,
			    		$obra->area_responsable,
			    		$obra->descripcion,
			    		$obra->monto_contrato,
			    		$obra->comuna,
			    		$obra->barrio,
			    		$obra->calle_1,
			    		$obra->seccion,
			    		$obra->manzana,
			    		$obra->parcela,
			    		$obra->direccion,
			    		$obra->lat,
			    		$obra->lng,
			    		$obra->fecha_inicio,
			    		$obra->fecha_fin_inicial,
	            		$obra->plazo_meses,
	            		$obra->porcentaje_avance,
			    		$obra->imagen_1,
			    		$obra->imagen_2,
			    		$obra->imagen_3,
			    		$obra->imagen_4,
			    		$obra->licitacion_oferta_empresa,
			    		$obra->licitacion_anio,
			    		$obra->contratacion_tipo,
			    		$obra->nro_contratacion,
			    		$obra->cuit_contratista,
			    		$obra->benficiarios,
			    		$obra->mano_obra,
			    		$obra->compromiso,
			    		"",
			    		"",
			    		$obra->link_interno,
			    		$obra->pliego_descarga,
			    		"",
			    		"",
			    		$obra->financiamiento));*/
	        }	        
			fclose($file);			
	    };

		return Response::stream($callback, 200, $headers);
    }


    /**
     * Save accion (guardar accion)	//SERVICIO PUBLICO
     */
    public function accionsave(Request $request)
    {

    	//validate picture
    	$rules = [
		    'imagen_1' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10048',
		    'imagen_2' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10048',
		    'imagen_3' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10048',
		    'imagen_4' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10048'
		];
		$validator = Validator::make($request->all(), $rules);    	
		if ($validator->fails())
        {
        	//dd($validator->messages());
            // It failed
        	$errorboolean="true";
			$description="Imagen(es) inválida(s) en peso o formato";//$validator->messages()->first();
			return response()->json([
			    'error' => $errorboolean,
			    'description' => $description
			]);
        }

        if($request->file('imagen_1')!=""){
        	$urlImageName1= $request->file('imagen_1')->store('/images');
        	$urlImageName1 = asset('storage/'.$urlImageName1);
    	}
        if($request->file('imagen_2')!=""){
        	$urlImageName2= $request->file('imagen_2')->store('/images');
        	$urlImageName2 = asset('storage/'.$urlImageName2);
        }
        if($request->file('imagen_3')!=""){
        	$urlImageName3= $request->file('imagen_3')->store('/images');
        	$urlImageName3 = asset('storage/'.$urlImageName3);
        }
        if($request->file('imagen_4')!=""){
        	$urlImageName4= $request->file('imagen_4')->store('/images');
        	$urlImageName4 = asset('storage/'.$urlImageName4);
        }

		DB::beginTransaction();
		try {		
				
				$lat_lng = explode(",", request()->lat_lng);

				//si es nuevo 
				if(request()->typepost=="save"){
					$accion = new Obra();	 
					$accion->folio = self::gen_uuid();
				}
				//si es existente
				else{
					$accion = Obra::where("id","=",request()->id)->first(); 					
				}
				 						    			    	    
			    //getting and setting info		
			    //$obra->email 						= request()->email;
			    //datos generales
			    $accion->tipo_contenido				= "Acciones";
			    $accion->entorno					= "";
			    $accion->nombre						= request()->nombre;
			    $accion->descripcion 				= request()->descripcion;
			    $accion->compromiso 				= request()->compromiso;
			    $accion->tipo 				    	= request()->tipo;
			    $accion->etapa						= request()->etapa;
			    $accion->comuna						= request()->comuna;
			    $accion->area_responsable			= request()->area_responsable;
			    $accion->porcentaje_avance			= request()->porcentaje_avance;
			    $accion->mano_obra					= request()->mano_obra;
			    $accion->plazo_meses				= request()->plazo_meses;
			    $accion->benficiarios				= request()->benficiarios;
			    $accion->fecha_inicio				= request()->fecha_inicio;
			    $accion->fecha_fin_inicial			= request()->fecha_fin_inicial;
			    //datos financieros y contrato			    
			    $accion->monto_contrato 			= request()->monto_contrato;
			    $accion->nro_contratacion 			= request()->nro_contratacion;
			    $accion->contratacion_tipo			= request()->contratacion_tipo;
			    $accion->licitacion_anio			= request()->licitacion_anio;
			    $accion->contratacion_tipo			= request()->contratacion_tipo;
			    $accion->nro_contratacion			= request()->nro_contratacion;
			    $accion->financiamiento				= request()->financiamiento;
			    //datos direccion y contacto
			    $accion->calle_1	 				= request()->calle_1;		    		     				    
			    $accion->direccion					= request()->direccion;
			    $accion->barrio						= request()->barrio;

			    if(count($lat_lng)>1){
			    	$accion->lat						= $lat_lng[0];
			    	$accion->lng						= $lat_lng[1];
			    }
			    else{
			    	DB::rollback();
					$errorboolean="true";
		    		$description='Ocurrió un error de ubicacion del mapa, verifique tener la coordenada completa, no se almacenó acción.';
		    		return response()->json([
					    'error' => $errorboolean,
					    'description' => $description,
					    'accion' => $accion
					]);
			    }

			    
			    //fotos de obra
			    if($request->file('imagen_1')!=""){
			    	$accion->imagen_1				= $urlImageName1;
				}
			    if($request->file('imagen_2')!=""){
			    	$accion->imagen_2 				= $urlImageName2;
			    }
			    if($request->file('imagen_3')!=""){
			    	$accion->imagen_3 				= $urlImageName3;
			    }
			    if($request->file('imagen_4')!=""){
			    	$accion->imagen_4 				= $urlImageName4;
			    }
			    //$obra->foto_fachada_principal		= base64_encode(file_get_contents($request->file('foto_fachada')));

			    if($accion->save()){

			    	if($accion->imagen_1!=""){
			    		$accion->link_interno = "http://201.116.64.10/dist_alerta/app.html#/obra/".$accion->id;
			    	}
			    	$accion->save();
				    //detalles				    				    
				    DB::commit();
				    //Mail::to($obra->email)->send(new SaveobraMail($obra));
				    //return success
				    $errorboolean="false";
				    if(request()->typepost=="save"){
				    	$description='Se almacenó acción correctamente. Folio: '.$accion->folio;
					}
					else{
						$description='Se editó acción correctamente.';
					}

			    }
			    else{
			    	DB::rollback();
					$errorboolean="true";
		    		$description='Ocurrió un error, no se almacenó acción.';
			    }

		
		} catch (Exception $e) {
			DB::rollback();
			$errorboolean="true";
		    $description='Ocurrió un error, no se almacenó acción.';		
		} 
		
		return response()->json([
		    'error' => $errorboolean,
		    'description' => $description,
		    'accion' => $accion
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