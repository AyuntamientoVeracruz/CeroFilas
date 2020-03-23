<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
use Illuminate\Http\Request;

use App\Pago;

use DateTime;
use Illuminate\Support\Facades\Validator;
use DB;
use Helper;
use Redirect;
use App\Mail\SavelevantamientoMail;
use Illuminate\Support\Facades\Mail;
use Response;
use Illuminate\Support\Str;

class PagoskioskoController extends Controller
{
    
	public function __construct(){ }


    /**
     * listadopagos
     */	
    public function listadopagos(){

    	$pagos = Pago::get();
    	//dd($pagos); 
    	return view('listapagoskiosko')
	    			->with('pagos',$pagos); 

    }


    /**
     * descargarpagos
     */	
    public function descargarpagos(){

    	$headers = array(
	        "Content-type" => "text/csv",
	        "Content-Disposition" => "attachment; filename=listadoPagos.csv",
	        "Pragma" => "no-cache",
	        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
	        "Expires" => "0"
	    );

    	$pagos = Pago::get();
    	
    	$columns = array('Pago ID', 'Clave Catastral', 'ControlNumber', 'Autorizacion','Estatus', 'Monto', 'Nombre', 'Modo','Error Mensaje', 'Creado el');

	    $callback = function() use ($pagos, $columns)
	    {
	        $file = fopen('php://output', 'w');
	        fputcsv($file, $columns);

	        foreach($pagos as $pago) {
	            fputcsv($file, array($pago->id_pago, $pago->clave_catastral, $pago->control_number,$pago->codigo_autorizacion, $pago->status, $pago->monto, $pago->nombre, $pago->modo,$pago->error_mensaje, $pago->created_at));
	        }
	        fclose($file);
	    };
	    return Response::stream($callback, 200, $headers); 

    }

    


}