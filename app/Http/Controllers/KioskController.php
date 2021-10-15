<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Oficina;
use App\Cita;
use App\Turno;
use App\Tramite;
use DateTime;
use DB;
use Illuminate\Support\Facades\Auth;
use Helper;

class KioskController extends Controller
{
    
	/**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $user;

    public function __construct()
    {

       $this->middleware('auth');

    }





    /**
     * Show the kiosk section
     */
    public function home()
    {		        
        //if(is_numeric($oficina)){
        //$user=Auth::user()->id_user;
        if(Auth::user()){
            $user=Auth::user()->id_user;
            $oficina=Auth::user()->oficina_id;
            //validando oficina
            $oOficina = Oficina::where("id_oficina",$oficina)->first();
            
            $tramites = self::gettramitesbykiosko($oficina);  

            if(count($oOficina)>0){   
                //regresamos oficina y tramites de esa oficina                         
                return view('kiosk', compact("oOficina","tramites"));
            }
            else{
                return __('lblKiskoController1');
            }
        }
        else{
            return __('lblKiskoController1');
        }
    }





    /**
     * Get tramites for kiosko by oficina
     */
    public function gettramitesbykiosko($oficina=false)
    {

        $oTramites = app('App\Http\Controllers\AppController')->gettramites(intval($oficina))->getData();
        $tramites=[];
        $counter=0;
        //obteniendo la siguiente hora disponible del dia para esa oficina y tramite
        foreach($oTramites->tramites as $tramite){
            /*$dia    = intval(date("d")); 
            $mes    = intval(date("m"));
            $anio   = intval(date("Y"));
            $siguienteshorasdisponibles=app('App\Http\Controllers\AppController')->getavailablehours(intval($oficina),intval($tramite->id_tramite),$dia,$mes,$anio); 
            $data   = $siguienteshorasdisponibles->getData(); 
            $horarios = (array) $data->horas[0]->horarios;
            if(count($horarios)>0){*/
                $tramites[$counter]["id_tramite"]=$tramite->id_tramite;
                $tramites[$counter]["nombre_tramite"]=$tramite->nombre_tramite;                
                $counter++;
            //}
        } 
        return $tramites;
    }

    /**
     * Get tramites for kiosko by oficina
     */
    public function gettramitesbykiosko2($oficina=false)
    {

        $oTramites = app('App\Http\Controllers\AppController')->gettramites(intval($oficina))->getData();
        $tramites=[];
        $counter=0;
        $dia    = intval(date("d")); 
        $mes    = intval(date("m"));
        $anio   = intval(date("Y"));

        //obteniendo la siguiente hora disponible del dia para esa oficina y tramite
        foreach($oTramites->tramites as $tramite){
            
            $siguienteshorasdisponibles=app('App\Http\Controllers\AppController')->getavailablehours(intval($oficina),intval($tramite->id_tramite),$dia,$mes,$anio); 
            $data   = $siguienteshorasdisponibles->getData(); 
            //dd($data);
            $horarios = (array) $data->horas[0]->horarios;
            if(count($horarios)>0){
                $tramites[$counter]["id_tramite"]=$tramite->id_tramite;
                $tramites[$counter]["nombre_tramite"]=$tramite->nombre_tramite;                
                $counter++;
            }
        } 
        return $tramites;
    }






    /**
     *  Leer QR de cita para generar turno  //SERVICIO PUBLICO
     */
    public function confirmationqr($oficina=false, $folio=false)
    {	
        dd('confirmationqr');
        //buscando la cita en base al folio leido del qr y la oficina
        $oCita = Cita::where("folio",$folio)->where("oficina_id",$oficina)->first();
        //llamando a funcion privada de validacion de cita
        $response=self::validatecita($oficina,$oCita)->getData();
        return response()->json($response);
    }
    




    /**
     *  Buscar cita por texto (nombre, curp o folio) de cita para generar turno  //SERVICIO PUBLICO
     */
    public function searchcitabytext($lang=false,$oficina=false, $text=false)
    {   
     
       
        //buscando la cita en base al texto
        if(strlen($text)==8){      //buscando por folio
            $oCita = Cita::where("folio",$text)->where("oficina_id",$oficina)->first();
            
        }else{
            //en ambos casos si el nombre o rfc es buscado, validar que si ya llego tarde a la primera cita, pueda buscar la segunda
            if(strlen($text)==18 && app('App\Http\Controllers\AppController')->valid_curp(strtoupper($text))!=0){      //buscando por curp                
                $oCita = Cita::where("curp",strtoupper($text))
                        ->where("oficina_id",$oficina)
                        ->whereNotIn('id_cita', function ($query) {
                            $query->select('cita_id')->from('turnos')->where('cita_id','!=','""');
                        })
                        ->whereRaw('Date(fechahora) = CURDATE()')
                        ->orderBy('fechahora','ASC')->first();
                //dd($oCita);     
                /*$query = Cita::where("curp",strtoupper($text))
                        ->where("oficina_id",$oficina)
                        ->whereNotIn('id_cita', function ($query) {
                            $query->select('cita_id')->from('turnos')->where('cita_id','!=','""');
                        })
                        ->whereRaw('Date(fechahora) = CURDATE()');       
                $sql_with_bindings = str_replace_array('?', $query->getBindings(), $query->toSql());    
                dd($sql_with_bindings);
                */
                if(count($oCita)==0){   
                    dd("ccc");
                    $msg=  __('lblKiskoController2');
                    return response()->json([
                        'error' => "true",
                        'errordescription' => $msg
                    ]); 
                }
            }
            else{      //buscando por nombre
                $oCita = Cita::whereRaw("CONCAT(nombre_ciudadano,' ',appaterno_ciudadano,' ',apmaterno_ciudadano) like '".$text."'")
                        ->where("oficina_id",$oficina)
                        ->whereNotIn('id_cita', function ($query) {
                            $query->select('cita_id')->from('turnos')->where('cita_id','!=','""');
                        })
                        ->whereRaw('Date(fechahora) = CURDATE()')
                        ->orderBy('fechahora','ASC')
                        ->first();
                if(count($oCita)==0){   
                    $msg=  __('lblKiskoController3');  
                    return response()->json([
                        'error' => "true",
                        'errordescription' => $msg
                    ]); 
                }
            }
        }
        //llamando a funcion privada de validacion de cita   
     
        $response=self::validatecita($lang,$oficina,$oCita)->getData();
        return response()->json($response);
    }





    /**
     *  Funcion privada para validar cita e invocar a generar turno
     */
    private function validatecita($lang=false,$oficina, $oCita)
    {  
        

        if(count($oCita)>0){ 
           

            $cita_fechahora=$oCita->fechahora;
            $cita_idcita=$oCita->id_cita;
            $cita_idtramite=$oCita->tramite_id;
            $cita_curp=$oCita->curp;
            $cita_nombre=$oCita->nombre_ciudadano.' '.$oCita->appaterno_ciudadano.' '.$oCita->apmaterno_ciudadano;

            //obteniendo estatus de la cita
            $cita_status=$oCita->statuscita;
            if($cita_status!='cancelada'){  //si no esta cancelada seguimos
                //viendo si esta cita es del dia
                $fechahoraactual = new DateTime(date('Y-m-d H:i:s'));
                $fechaactual=$fechahoraactual->format('Y-m-d');
                $fechahoracita = new DateTime($cita_fechahora);
                $fechacita=$fechahoracita->format('Y-m-d');            

                //si la cita es del dia actual, entonces continuamos
                if($fechaactual==$fechacita){ 
                
                    //si la hora de la cita menor a la de la hora actual, entonces continuamos    
                    //if($fechahoracita>=$fechahoraactual){  
                    $tiempo=(strtotime($cita_fechahora)-time())/60;   
                    if($tiempo<=20){    //si la hora actual menos la hora de la cita es menor o igual a 20 minutos
                        if($tiempo>-10){  //si llego maximo 10 minutos despues de su cita
                            //viendo si esta cita ya tiene un turno asignado
                            $oTurno = Turno::where("cita_id",$cita_idcita)->get();

                            //si no tiene turno asignado, le vamos a crear un turno
                            if(count($oTurno)==0){ 
                                
                                //creamos turno a partir de cita, pasando tipocita, idtramite, idoficina y curp/nombre
                                $turn=self::createturn("cita",$cita_idtramite,$oficina,$cita_curp,$cita_idcita,$cita_nombre)->getData();
                                return response()->json($turn);
                            }
                            else{
                                $msg=  __('lblKiskoController4');  
                                return response()->json([
                                    'error' => "true",
                                    'errordescription' => $msg
                                ]);                
                            }
                        }
                        else{
                            $msg=  __('lblKiskoController5'); 
                            return response()->json([
                                'error' => "true",
                                'errordescription' => $msg
                            ]); 
                        }
                    }
                    else{
                        $msg=  __('lblKiskoController6');
                        return response()->json([
                            'error' => "true",
                            'errordescription' => $msg
                        ]); 
                    }
                }else{
                    $msg=  __('lblKiskoController7');
                    return response()->json([
                        'error' => "true",
                        'errordescription' => $msg
                    ]); 
                }
            }
            else{
                $msg=  __('lblKiskoController8');
                return response()->json([
                        'error' => "true",
                        'errordescription' => $msg
                    ]);
            }
        }
        else{
            $msg=  __('lblKiskoController9');
            return response()->json([
                    'error' => "true",
                    'errordescription' => $msg
                ]);
        }
    }





    



    

    /**
     * generar turno manual //SERVICIO PUBLICO
     */
    public function manualturn(Request $request)
    {
       
        
        $oficina=request()->oficina;
        $tramite=request()->tramite;
        $curp=strtoupper(request()->curp);
        $nombre=ucwords(request()->nombre);
        if(is_numeric($oficina) && is_numeric($tramite) && $nombre!=""){//app('App\Http\Controllers\AppController')->valid_curp($curp)!=0 ){
            //creamos turno a partir de turno manual, pasando tipocita, idtramite, idoficina y curp
            $turn=self::createturn("manual",$tramite,$oficina,$curp,false,$nombre)->getData();      
            return response()->json($turn);
        }
        else{
            $msg=  __('lblKiskoController10');
            return response()->json([
                'error' => "true",
                'errordescription' => $msg
            ]);   
        }
    }





    /**
     * Funcion de apoyo para crear turno
     */ 
    public function createturn( $turntype,$tramite,$oficina,$curp,$cita=false,$nombre=false)
    {
       

        DB::beginTransaction();
        try {

            //obteniendo tramite para tener codigo de tramite
            $oTramite = Tramite::where("id_tramite", $tramite)->first();

            //obteniendo id maximo de tipo de turno en esa oficina para el dia corriente (hoy)
            $totalturnos = Turno::where("tramite_id", $tramite)
                    ->where("oficina_id",$oficina)
                    ->whereRaw('Date(created_at) = CURDATE()')
                    ->count();

            //generar folio
            $totalturnos=$totalturnos+1;       
            $totalturnos=sprintf('%04d', $totalturnos);
            $folio = $oTramite->codigo.$totalturnos;     //obtener el maximo

            //calcular tiempo aproximado  
            if($turntype=="cita"){ 
                $tiempoaproximado = 0;
            }
            else{
                //obteniendo los turnos del dia de esa oficina que no se han atendido antes de la hora actual (hoy)            
                $turnosantesdelahoraactual = DB::table('turnos')
                            ->select("turnos.*","tramites.tiempo_minutos")
                            ->leftJoin('tramites','tramites.id_tramite', '=', 'turnos.tramite_id')
                            ->where("turnos.oficina_id",$oficina)
                            ->whereRaw('turnos.created_at < NOW()')
                            ->whereRaw('Date(turnos.created_at) = CURDATE()')
                            ->where(function ($q) {
                                $q->where('turnos.estatus','creado')
                                  ->orWhere('turnos.estatus','enproceso');
                            })
                            ->get();
                //obteniendo la siguiente hora disponible del dia para esa oficina y tramite
                $dia    = intval(date("d")); 
                $mes    = intval(date("m"));
                $anio   = intval(date("Y"));
                $siguienteshorasdisponibles=app('App\Http\Controllers\AppController')->getavailablehours(null ,intval($oficina),intval($tramite),$dia,$mes,$anio);
                $data   = $siguienteshorasdisponibles->getData(); 
                
               
                $horarios = (array) $data->horas[0]->horarios;

              ;
               
                $hora=""; 
                //checamos si horarios de la funcion tiene elementos
                foreach($horarios as $elementey => $element){
                    $hora=$elementey;
                    break;
                }

                
                //si hay una hora
                if($hora!=""){
                    $fechahoraactual = new DateTime(date('Y-m-d H:i:s'));               //obtenemos la fechahora actual
                    $fechahoraarmada = new DateTime(date('Y-m-d')." ".$hora);           //armamos la fecha y hora con la hora la hora sin cita mas cercana
                    $since_start = $fechahoraactual->diff($fechahoraarmada);
                    $nextavailabletime=$since_start->i;
                }
                else{
                    $citasdespuesdelahoraactual = DB::table('citas')
                            ->select("citas.*","tramites.tiempo_minutos")
                            ->leftJoin('tramites','tramites.id_tramite', '=', 'citas.tramite_id')
                            ->where("citas.oficina_id",$oficina)
                            ->whereRaw('citas.fechahora > NOW()')
                            ->whereRaw('Date(citas.fechahora) = CURDATE()')
                            ->where('statuscita','!=','cancelada')                            
                            ->get();
                    $nextavailabletime=0;
                }
                                  
                //obteniendo los tramitadores que hacen ese tramite para esa oficina
                $tramitadores=app('App\Http\Controllers\AppController')->gettramitadores($oficina,$tramite);            
                
                //sacando estimacion en base a los tramitadores y turnos (creados y en proceso)
                $totalturnosantes=count($turnosantesdelahoraactual);
                if($hora==""){
                    $totalturnosantes=$totalturnosantes+count($citasdespuesdelahoraactual);
                }
                $totaltramitadores=count($tramitadores);
                if($totaltramitadores==0){$totaltramitadores=1;} 
                //checar calculo de tiempo de turnos antes 
                $tiempoaproximado = intval($totalturnosantes/$totaltramitadores)*app('App\Http\Controllers\AppController')->getmaxtimefortramiteinoficina($oficina)+$nextavailabletime;
            }

            //crear turno en db
            $turno = new Turno();          
            $turno->folio                = $folio;  
            //si el tipo de turno es por cita, agregamos el id de la cita 
            if($turntype=="cita"){ 
                $turno->cita_id          = $cita;                
            }
            $turno->tramite_id           = $tramite;
            $turno->oficina_id           = $oficina;            
            $turno->curp                 = $curp; 
            $turno->nombre_ciudadano     = $nombre;   
            $turno->tiempoaproxmin       = $tiempoaproximado;   
            $turno->estatus              = "creado";                              
            $turno->save(); 
            
           
            //si el tipo de turno es por cita, la confirmacion es por cita
            if($turntype=="cita"){
                $confirmationtype = __('lblKiskoController11');
                $tiempoaproximado = __('lblKiskoController12');
            }   //si no, la confirmacion es por turno
            else{
                $confirmationtype = __('lblKiskoController13');

                $tiempohoras = $tiempoaproximado/60;
                $horas = floor($tiempohoras);
                $minutos = $tiempohoras - $horas;
                $minutos = str_pad(round($minutos*60,0), 2, '0', STR_PAD_LEFT); 
                $tiempoaproximado = __('lblKiskoController14') .str_pad($horas,2,'0',STR_PAD_LEFT).__('lblKiskoController16')." ".$minutos.__('lblKiskoController17');
            }
            DB::commit();
            //dd($arraytiempos); 
            //retornamos el resultado correcto
            return response()->json([
                'folio' => $folio,
                'confirmationtype' => $confirmationtype,
                'tiempoaproximado' => $tiempoaproximado,
                'error' => "false"
            ]);

        } catch (Exception $e) {
            dd($e);
            DB::rollback();
            $msg=__('lblKiskoController15');
            return response()->json([
                'error' => "true",
                'errordescription' => $msg.$e
            ]);

        }

    }    



    /**
     * Show the turnera section
     */
    public function hometurnera()
    {               
        //if(is_numeric($oficina)){
        //$user=Auth::user()->id_user;
        if(Auth::user()){
            $user=Auth::user()->id_user;
            $oficina=Auth::user()->oficina_id;
            //validando oficina
            $oOficina = Oficina::where("id_oficina",$oficina)->first();
            
            $tramites = self::gettramitesbykiosko($oficina);  

            $videos = DB::table('videos')->where("oficina_id",$oficina)->orderBy("orden")->get();
            $marquesinas = DB::table('marquesinas')->where("oficina_id",$oficina)->get();
            
            if(count($oOficina)>0){   
                //regresamos oficina y tramites de esa oficina                         
                return view('turnera', compact("oOficina","tramites","videos","marquesinas"));
            }
            else{
                return __('lblKiskoController1');
            }
        }
        else{
            return __('lblKiskoController1');
        }
    }


}