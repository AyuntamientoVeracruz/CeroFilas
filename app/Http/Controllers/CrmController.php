<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Dependencia;
use App\Oficina;
use App\Ausencia;
use App\User;
use App\Turno;
use App\Cita;
use App\Tramite;
use App\Tramitesxuser;
use App\Tramitesxoficina;
use App\Valoracione;
use DateTime;
use DB;
use Illuminate\Support\Facades\Auth;
use Helper;
use Hash;

class CrmController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

	protected $user;
	const PAGINATOR = 3;

    public function __construct()
    {

       $this->middleware('auth');

    }





    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {				
		$data = Helper::getMenuData();
		if($data["rol"]=="tramitador"){

			//getting dependencias for combo
			$dependenciascombo = DB::table('dependencias')->get();
			$indexdependenciacombo = 0;
			//for each dependencia for combo
			foreach($dependenciascombo as $dependencia){
				$oficinascombo = DB::table('oficinas')
								->where('dependencia_id',$dependencia->id_dependencia)
								->orderBy('nombre_oficina','ASC')->get();
				$dependenciascombo[$indexdependenciacombo]->oficinas = $oficinascombo;	//setting in the dependencias the oficinas array
				$indexdependenciacombo++;
			}

        	return view('sistema.index')
        		->with('data',$data)
        		->with('dependenciascombo',$dependenciascombo);
        }
        if($data["rol"]=="kiosko"){
        	return redirect()->route('kiosk');
        }
        if($data["rol"]=="turnera"){
        	return redirect()->route('turnera');
        }
        if($data["rol"]=="superadmin"){
        	return view('sistema.indexsuperadmin')
        			->with('data',$data);
        }
        if($data["rol"]=="admin_oficina"){

        	return self::displayviewer('admin',$data);
        		
        }
    }





    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewerturnoscitas()
    {
    	$data = Helper::getMenuData();
    	return self::displayviewer('tramitador',$data);
    }


    /*display viewer*/
    private function displayviewer($tipo=false,$data=false){
    	//$filterestatus=request()->filterestatus;
    	$turnos=self::getturnos($data['rol'],$data['oficina'],date('Y-m-d').'@'.date('Y-m-d'),'creado');        	

    	//getting usuarios
    	$usuarios=DB::table('users')
    		->orderBy('nombre','ASC')
    		->select('users.*')
    		->where('disponibleturno','si');
    	//if($data['rol']=='admin_oficina'){
    		$usuarios = $usuarios->where('users.oficina_id',$data['oficina']);
    	//}	
    	$usuarios=$usuarios->get();

    	//returning results
    	return view('sistema.indexadminoficina')
    			->with('data',$data)
    			->with('turnos',$turnos)
    			->with('usuarios',$usuarios)
    			->with('tipo',$tipo)
    			->with('ultimaactualizacion',now());
    }


    /***AJAX FUNCTIONS TO GET/UPDATE TURNOS VIEWER***/
	//getting turnos (aux function)
	public function getturnos($rol=false,$oficina=false,$fecha=false,$status=false)
	{
		//spliting fecha
		$fechas=explode("@", $fecha);
		//getting turnos
		$turnos=DB::table('turnos')
    		->leftJoin('tramites','tramites.id_tramite','=','turnos.tramite_id')
    		->leftJoin('users','users.id_user','=','turnos.user_id')
    		->leftJoin('citas','citas.id_cita','=','turnos.cita_id')
    		->orderBy('created_at','DESC')
    		->select('turnos.*', 'tramites.nombre_tramite', 'users.nombre', 'citas.folio as cita', DB::raw('time_format(time(turnos.created_at),"%H:%i") as creado'),
    			DB::raw('DATE_FORMAT(turnos.created_at, "%d de %b, %Y") as fechacreado'),
    		DB::raw('time_format(time(turnos.fechahora_inicio),"%H:%i") as inicio'), DB::raw('time_format(time(turnos.fechahora_fin),"%H:%i") as fin'))
    		->whereRaw('Date(turnos.created_at) >= "'.$fechas[0].'"')
    		->whereRaw('Date(turnos.created_at) <= "'.$fechas[1].'"');
    	if($status){
    		$turnos=$turnos->where('turnos.estatus',$status);
    	}
    	//if($rol=='admin_oficina'){
    		$turnos = $turnos->where('turnos.oficina_id',$oficina);
    	//}	
    	$turnos=$turnos->get();
    	
    	return $turnos;
	}		
	/***AJAX FUNCTIONS TO GET/UPDATE CITAS VIEWER***/
	//getting citas (aux function)
	public function getcitas($rol=false,$oficina=false,$fecha=false,$status=false)
	{		
		//spliting fecha
		$fechas=explode("@", $fecha);
    	//getting citas
    	$citas=DB::table('citas')
    		->leftJoin('tramites','tramites.id_tramite','=','citas.tramite_id')
    		->orderBy('fechahora','DESC')
    		->orderBy('tramites.nombre_tramite','ASC')
    		->select('citas.*', 'tramites.nombre_tramite',DB::raw('time_format(time(citas.fechahora),"%H:%i") as creado'),
    			DB::raw('DATE_FORMAT(citas.fechahora, "%d de %b, %Y") as fechacreado'),DB::raw('folio as cita'))
    		->whereNull('statuscita')
    		->whereRaw('Date(citas.fechahora) >= "'.$fechas[0].'"')
    		->whereRaw('Date(citas.fechahora) <= "'.$fechas[1].'"');
    	//if($rol=='admin_oficina'){
    		$citas = $citas->where('citas.oficina_id',$oficina);
    	//}	
    	$citas=$citas->get();

    	$indexcitas = 0;
		//for each dependencia for combo
		foreach($citas as $cita){
			$citas[$indexcitas]->estatus = 'creado';
			$turno = DB::table('turnos')
						->leftJoin('users','users.id_user','=','turnos.user_id')
						->select('turnos.*','users.nombre')
						->where('cita_id',$cita->id_cita)->get();
			
			if(count($turno)>0){
				if($turno[0]->estatus=='creado'){
					$citas[$indexcitas]->estatus = 'check-in';
				}
				else{
					$citas[$indexcitas]->estatus = $turno[0]->estatus;	
				}
				if($turno[0]->fechahora_inicio==null){
					$turno[0]->fechahora_inicio="---";
				}
				if($turno[0]->fechahora_fin==null){
					$turno[0]->fechahora_fin="---";
				}
				if($turno[0]->observaciones==null){
					$turno[0]->observaciones="---";
				}
			}
			$citas[$indexcitas]->turno = $turno;	//setting in the cites the turno array
			$indexcitas++;
		}
		
		if($status){
			//filtering by estatus
    		$citas=$citas->where('estatus',$status);    		 		  		
    	} 	
    	else{
    		$citas=$citas->whereNotIn('estatus',['cancelado']);
    	}
    	//creating new citas array
		$citasnew = []; 
		$indexnewcitas = 0;
		//filling newcitas with citas
		foreach($citas as $cita){
			$citasnew[$indexnewcitas]=$cita;
			$indexnewcitas++;
		} 
		//asigning citas with citasnew
		$citas=$citasnew;  

    	//returning citas
		return $citas;	
	}
	//update turnos (aux function)
	public function updateturnos($turno=false,$tramitador=false)
	{

		DB::beginTransaction();
		try {
			$turno=Turno::find($turno);
			//si el turno aun esta como estatus creado, se cambia a en proceso y se asigna
			if($turno->estatus=="creado"){
				$turno->user_id=$tramitador;
				$turno->estatus="enproceso";
				$turno->save();
				DB::commit();
				$errorboolean="false";
				$description="Asignación de tramitador realizada con éxito.";
			}
			else{	//si el turno ya no esta como creado, no hacemos nada y decimos que ya fue asignado
				$errorboolean="true";
				$description="El turno ya había cambiado su estatus, no pudo ser asignado.";
			}	
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
     * Show the perfil.
     *
     * @return \Illuminate\Http\Response
     */
    public function perfil()
    {				
		$data = Helper::getMenuData();
		$profile=self::getprofile($data['user']->id_user,'user',$data);		
		return $profile;        
    }


    /**
     * Show the perfiltramitador.
     *
     * @return \Illuminate\Http\Response
     */
    public function perfiltramitador($tramitador)
    {				
		$data = Helper::getMenuData();
		if($data['rol']=='tramitador'){
			return redirect()->route('perfil');  
		}
		$profile=self::getprofile($tramitador,'tramitador',$data);
        return $profile;
    }


	/**
     * Aux function to get profile by user or by tramitador as admin.
     *
     * @return \Illuminate\Http\Response
     */
    private function getprofile($user=false,$tipo=false,$data=false){

    	$previousvaloraciones=0;		        
        DB::statement("SET lc_time_names = 'es_ES'");
        $valoraciones=collect(self::getevaluaciones($user,$previousvaloraciones)->getData()->valoraciones);    
        $totalvaloraciones=$valoraciones->count();
        if($totalvaloraciones==0){
        	$estrellas = 0;
        }	
        else{
        	$estrellas = round($valoraciones->sum('estrellas')/$totalvaloraciones);
        }	
        
        $valoraciones=$valoraciones->take(self::PAGINATOR);
        $valoracionesreturned=count($valoraciones)+$previousvaloraciones;

        if($tipo=='user'){
        	$user=$data;
        }
        else{
        	$userarray=[];
        	$userarray['user'] = User::find($user);
	        $userarray['rol']  = $userarray['user']->tipo_user;
	        $userarray['name'] = $userarray['user']->nombre;
	        $userarray['estatus'] = $userarray['user']->estatus;
	        $userarray['disponibilidad'] = $userarray['user']->disponibleturno;
	        $userarray['oficina'] = $userarray['user']->oficina_id;    
	        $dependencia = DB::table("oficinas")->where("id_oficina",$userarray['user']->oficina_id)->first();    
	        $userarray['dependencia']  = $dependencia;
	        $user=$userarray;
        }

        return view('sistema.perfil')
        		->with('data',$data)
        		->with('estrellas',$estrellas)
        		->with('totalvaloraciones',$totalvaloraciones)
        		->with('offset',$valoracionesreturned)
        		->with('valoraciones',$valoraciones)
        		->with('tipo',$tipo)
        		->with('user',$user);

    }

    /**
     * Get evaluaciones
     */
    public function getevaluaciones($tramitador=false,$offset=false)
    {
    	try{
	    	$valoraciones=DB::table('valoraciones')
	        			->leftJoin('turnos','turnos.id_turno','=','valoraciones.turno_id')
	        			->leftJoin('users','users.id_user','=','turnos.user_id')
	        			->leftJoin('tramites','tramites.id_tramite','=','turnos.tramite_id')
	        			->select('valoraciones.*','turnos.nombre_ciudadano','tramites.nombre_tramite','turnos.fechahora_inicio',DB::raw('DATE_FORMAT(fechahora_inicio, "%d de %b, %Y @ %H:%i") as fecha'))
	        			->where('id_user',$tramitador)
	        			->where('respuesta1','!=','')
	        			->orderBy('fechahora_inicio','desc');
	        if($offset>0){
	        	$valoraciones=$valoraciones->offset($offset)->take(self::PAGINATOR);
	        }			
	        $valoraciones=$valoraciones->get();
	        $errorboolean="false";
			$description="Evaluaciones obtenidas.";
        }
        catch (Exception $e) {			
			$valoraciones=[];
			$errorboolean="true";
			$description="Ocurrió un error en la base de datos, intenta más tarde. ".$e;
		} 
    	return  response()->json([
    				'valoraciones' => $valoraciones,
    				'offset' => count($valoraciones)+$offset,
    				'error' => $errorboolean,
    				'description' => $description
    			]);
    }




    




    /**
     * updateperfil (actualizar usuario desde perfil)
     */
	public function updateperfil(Request $request)
	{
		$user=Auth::user()->id_user;
		$usuario= User::find($user);
	    		
		//Set values to update.
		if (request()->has('nombre')) {( !empty($request->get('nombre'))  ? $usuario->nombre = $request->get('nombre') : null );}		
		if($request->get('email')!=""){
		 	$usuarioemail = User::where('email',$request->get('email'))->where('id_user','!=',$user)->get();
		 	if(count($usuarioemail)>0){
		 		return redirect()->back()->with('errors', 'Ocurrió un error. Ya existe un usuario registrado con ese email.');		
		 	}
		 	$usuario->email = $request->get('email');
		}
		try {
	  		$usuario->save();
			return redirect()->back()->with('success', 'El usuario ('.$usuario->nombre.') se actualizó correctamente.');
		}catch(\Illuminate\Database\QueryException $e){			
		  	return redirect()->back()->with('errors', 'Hubo un error al actualizar, intenta mas tarde. '.$e);
		}
	}


	/**
     * updatepassword (actualizar password de usuario desde perfil)
     */
	public function updatepassword(Request $request)
	{
		$user=Auth::user()->id_user;
		$usuario= User::find($user);
	    //checking actual password
		if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
			return redirect()->back()->with('errors', 'El password actual no es correcto');
		}
		if(strcmp($request->get('current-password'), $request->get('pass')) == 0){
			//Current password and new password are same
			return redirect()->back()->with("errors","Su nuevo password no puede ser igual que el actual. Por favor elija un nuevo password.");
		}
		//Set values to update.
		if (request()->has('pass')) {( !empty($request->get('pass'))  ? $usuario->password = bcrypt($request->get('pass')) : null );}	
		
		try {
	  		$usuario->save();
			return redirect()->back()->with('success', 'El password del usuario ('.$usuario->nombre.') se actualizó correctamente.');
		}catch(\Illuminate\Database\QueryException $e){			
		  	return redirect()->back()->with('errors', 'Hubo un error al actualizar, intenta mas tarde. '.$e);
		}
	}




    /****USER TRAMITADOR****/	
    /**
     * setavailability (poner disponibleturno a usuario tramitador)
     */
    public function setavailability(Request $request)
    {
    	DB::beginTransaction();
    	try {
			
	    	$user=Auth::user()->id_user;
	    	$disponibleturno=request()->availability;
	    	if($disponibleturno=="on"){
	    		$disponibleturno="si";
	    	}
	    	else{
	    		$disponibleturno="no";
	    	}	    		    		    		    	
	    	$user = User::find($user);
	    	$user->disponibleturno = $disponibleturno;	
	    	$user->save();

			$errorboolean="false";
			$description="Disponibilidad actualizada"; 
			DB::commit();		

		} catch (Exception $e) {
			DB::rollback();
			$user=[];
			$errorboolean="true";
			$description="Ocurrió un error en la base de datos, intenta más tarde. ".$e;

		} 
		return response()->json([
		    'error' => $errorboolean,
		    'description' => $description,
		    'user' => $user
		]);
    }





    /**
     * getassignment (obtener asignacion de usuario tramitador)
     */
    public function getassignment()
    {    	
    	try {
			//creando array asignacion
			$asignacion=[];
			//obteniendo a usuario
	    	$user=Auth::user()->id_user;	    	
	    	//obteniendo turno en proceso del usuario
	    	$turno=Turno::where('estatus','enproceso')->where('user_id',$user)->orderBy('created_at','ASC')->first();
	    	//si hay un turno en proceso del usuario, lo colocamos en el array
	    	if(count($turno)>0){
	    		$asignacion["enproceso"]="si";	    		
	    		//buscando el tramite
	    		$tramite=Tramite::find($turno->tramite_id);
	    		$asignacion["tramite"]=$tramite;	    		
	    		//vemos si este turno trae consigo una cita
	    		if($turno->cita_id!=""){
	    			$cita=Cita::find($turno->cita_id);
	    			$asignacion["cita"]=$cita;
	    		}

	    		$errorboolean="false";
				$description="Búsqueda de asignación ejecutada."; 
	    		//if horainicio isnull, update turno set horainicio=now()
	    		if($turno->fechahora_inicio==""){
	    			DB::beginTransaction();
    				try {
    					$turnoactualizado = Turno::find($turno->id_turno);
				    	$turnoactualizado->fechahora_inicio = now();	
				    	$turnoactualizado->save();
						$errorboolean="false";
						$description="Búsqueda y fecha actualizada"; 
						DB::commit();
						$turno->fechahora_inicio = $turnoactualizado->fechahora_inicio;
					} catch (Exception $e) {
						DB::rollback();
						$errorboolean="true";
						$description="Ocurrió un error en la base de datos actualizando la hora de inicio. ".$e;
					} 	
	    		}	
	    		$asignacion["turno"]=$turno;    		
			}
			else{ //si no hay turno en proceso para el usuario, entonces indicamos que no hay turno en proceso
				$asignacion["enproceso"]="no";
				$errorboolean="false";
				$description="Búsqueda de asignación ejecutada."; 
			}

								

		} catch (Exception $e) {
			DB::rollback();
			$asignacion=[];
			$errorboolean="true";
			$description="Ocurrió un error en la base de datos.".$e;

		} 
		return response()->json([
		    'error' => $errorboolean,
		    'description' => $description,
		    'asignacion' => $asignacion
		]);
    }





    /**
     * attendingturn (atendiendo un turno desde el tramitador)
     */
    public function attendingturn(Request $request)
    {
    	DB::beginTransaction();
    	try {
			
	    	$user    			= Auth::user()->id_user;
	    	$turno   			= request()->turno;
	    	if(request()->curp!=""){
	    		$curp	 			= request()->curp;
	    	}
	    	else{
	    		$curp="";
	    	}
	    	if(request()->email!=""){
	    		$email	 			= request()->email;
	    	}
	    	else{
	    		$email="";
	    	}
	    	$observaciones 		= request()->observaciones;
	    	$estatus	 		= request()->estatus;
	    	$confirmarypausar	= request()->confirmarypausar;
	    	
	    	//updating turno
	    	$turno = Turno::find($turno);
	    	$turno->observaciones = $observaciones;	
	    	$turno->estatus = $estatus;		    	
	    	$turno->curp = $curp;	
	    	$turno->email = $email;    	
	    	$turno->fechahora_fin = now();		
	    	$turno->save();
	    	//si el tramitador confirma y pausa, entonces vamos a ponerlo como no disponible
	    	if($confirmarypausar=="si"){
	    		$user = User::find($user);
	    		$user->disponibleturno = "no";	
	    		$user->save();
	    	}
	    	else{
	    		$user = User::find($user);
	    	}

	    	$errorboolean="false";
			$description="Atención finalizada."; 	
	    	if($email!=""){
	    		//getting full info from turno 	
	    		$turnocompuesto	= DB::table('turnos')
	    					->leftJoin('tramites','tramites.id_tramite','=','turnos.tramite_id')
	    					->leftJoin('oficinas','oficinas.id_oficina','=','turnos.oficina_id')
	    					->leftJoin('users','users.id_user','=','turnos.user_id')
	    					->where('id_turno',$turno->id_turno)
	    					->select('turnos.*','tramites.nombre_tramite','oficinas.nombre_oficina','users.nombre')
	    					->first();
	    		//generating valoracion				
	    		$foliovaloracion = self::gen_uuid();				
	    		$valoracion=new Valoracione();
	    		$valoracion->turno_id = $turnocompuesto->id_turno;
	    		$valoracion->folio = $foliovaloracion;
	    		$valoracion->save();
	    		//send valoracion by mail	
	    		$sendmail = app('App\Http\Controllers\Auth\RegisterController')->requestValoracion($turnocompuesto,$foliovaloracion);
	    		if($sendmail=="true"){
	    			$errorboolean="false";
					$description="Atención finalizada, se envió mail de evaluación."; 
	    		}
	    		else{
	    			$errorboolean="false";
					$description="Atención finalizada, no se envió mail de evaluación.";
	    		}
	    	}	

			
			DB::commit();		

		} catch (Exception $e) {
			DB::rollback();
			$turno=[];
			$errorboolean="true";
			$description="Ocurrió un error en la base de datos, intenta más tarde. ".$e;

		} 
		return response()->json([
		    'error' => $errorboolean,
		    'description' => $description,
		    'turno' => $turno,
		    'user' => $user
		]);
    }
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




	/**
     * gethistorial (obtener historial de atencion del ciudadano a partir del curp)
     */
    public function gethistorial($curp=false, $oficina=false)
    {    	
    	try {
			//creando array historico
			$historico=[];
			//obteniendo a usuario
	    	$user=Auth::user()->id_user;	    		    	
	    	//si existe un usuario autorizado a buscar historial
	    	if($user!=""){	    		
	    		//buscando historial de turnos finalizados
	    		$historico=Turno::where('turnos.estatus','finalizado')
	    			->where('curp',$curp);
	    		if($oficina){
	    			$historico=$historico->where('turnos.oficina_id',$oficina);
	    		}
	    			$historico=$historico->orderBy('turnos.created_at', 'DESC')
	    			->leftJoin('tramites','tramite_id','id_tramite')
	    			->leftJoin('users','user_id','id_user')
	    			->limit(5)
	    			->get();
	    		$errorboolean="false";
				$description="Búsqueda de historial ejecutada."; 
			}
			else{ //si no existe usuario autorizado a buscar historial				
				$errorboolean="true";
				$description="Sin permisos para buscar historial.";
			}						

		} catch (Exception $e) {
			DB::rollback();
			$errorboolean="true";
			$description="Ocurrió un error en la base de datos.".$e;

		} 
		return response()->json([
		    'error' => $errorboolean,
		    'description' => $description,
		    'historico' => $historico
		]);
    }



    /****USUARIOS****/
    /**
     * usuariosListar (obtener historial de usuarios por oficina)
     */
    public function usuariosListar(Request $request)
	{
		
		$data = Helper::getMenuData();

		if($data["rol"]=="tramitador"){ return redirect('sistema'); }
		
		if($data["rol"]=="admin_oficina" || $data["rol"]=="superadmin"){ 
			
			$filterstexto = null;
			if (request()->has('searchPars')){
				$filterstexto = request()->searchPars;
			}
			$filterstipousuario = null;
			if (request()->has('tipousuario')){
				$filterstipousuario = request()->tipousuario;
			}
			$filtersoficina = null;
			if (request()->has('oficina')){
				$filtersoficina = request()->oficina;
			}

			//getting dependencias
			$dependencias = DB::table('dependencias');
			if($data["rol"]=="admin_oficina"){	//if admin oficina, only get the dependencia from oficina from the admin
				$dependencias = $dependencias
								->join('oficinas','dependencias.id_dependencia', '=', 'oficinas.dependencia_id')
								->where('id_oficina', $data["user"]->oficina_id)
								->distinct();
			}				
			$dependencias = $dependencias->get();
			$indexdependencia = 0;	//initializing counter dependencia

			//getting dependencias for combo
			$dependenciascombo = DB::table('dependencias')->get();
			$indexdependenciacombo = 0;
			//for each dependencia for combo
			foreach($dependenciascombo as $dependencia){
				$oficinascombo = DB::table('oficinas')
								->where('dependencia_id',$dependencia->id_dependencia)
								->orderBy('nombre_oficina','ASC')->get();
				$dependenciascombo[$indexdependenciacombo]->oficinas = $oficinascombo;	//setting in the dependencias the oficinas array
				$indexdependenciacombo++;
			}

			//for each dependencia
			foreach($dependencias as $dependencia){

				//getting oficinas from dependencia
				$oficinas = DB::table('oficinas')
								->where('dependencia_id',$dependencia->id_dependencia);
				if($data["rol"]=="admin_oficina"){	//if admin oficina, only get the oficina from the admin
					$oficinas = $oficinas->where('id_oficina', $data["user"]->oficina_id);
				}	
				if ($filtersoficina != null) {	//if get filter search idoficina
					$oficinas = $oficinas->where('id_oficina',$filtersoficina);
				}
				$oficinas = $oficinas->orderBy('nombre_oficina','ASC')->get();				
				$indexoficina = 0; //initializing counter oficina

				//for each oficina
				foreach($oficinas as $oficina){

					//getting tramites from oficina
					$tramitesxoficinas = DB::table('tramitesxoficinas')
									->leftJoin('tramites','tramites.id_tramite','=','tramitesxoficinas.tramite_id')
									->where('oficina_id', $oficina->id_oficina)
									->select('tramites.*')
									->orderBy('nombre_tramite','ASC')
									->get();	

					//getting usuarios from oficina
					$usuarios = User::whereIn('tipo_user', ['tramitador','admin_oficina','kiosko','superadmin'] )
									->whereIn('estatus', ['activo', 'inactivo'])
									->where('oficina_id', $oficina->id_oficina)
									->orderBy('tipo_user','ASC')->orderBy('nombre','ASC');
					if ($filterstexto != null) {	//if get filter search nombre/email
						$usuarios = $usuarios
									->where(function($query) use ($filterstexto)
									{
										$query->where('nombre', 'like',  '%' .$filterstexto. '%')
											->orWhere('email', 'like', '%' .$filterstexto. '%');
									});
					}	
					if ($filterstipousuario != null) {	//if get filter search nombre/email
						$usuarios = $usuarios
									->where('tipo_user',$filterstipousuario);
					}			
					$usuarios = $usuarios->get();					
					$index = 0;	//initializing counter usuarios

					//for each usuarios	
					foreach($usuarios as $usuario){
						//getting tramites from usuario
						$tramites = DB::table('tramitesxusers')
													 ->join('users', 'tramitesxusers.user_id', '=', 'users.id_user')
													 ->join('tramites', 'tramitesxusers.tramite_id', '=', 'tramites.id_tramite')
													 ->where('user_id', $usuario->id_user)
													 ->select('tramitesxusers.*','tramites.nombre_tramite')
													 ->orderBy('nombre_tramite','ASC')
													 ->get();					
						$usuarios[$index]->TRAMITES = $tramites;	//setting in usuarios the tramites array
						$usuarios[$index]->TOTALTRAMITES = collect($tramites)->count();	//setting in usuarios the total tramites								
						$index++;
					}

					$oficinas[$indexoficina]->tramites = $tramitesxoficinas; //setting in the oficinas the tramites from oficina array			
					$oficinas[$indexoficina]->usuarios = $usuarios;	//setting in the oficinas the usuarios array
					$indexoficina++;

				}

				$dependencias[$indexdependencia]->oficinas = $oficinas;	//setting in the dependencias the oficinas array
				$indexdependencia++;

			}
					
			return view('sistema.usuarios')->with('data',$data)
										   ->with('filterstexto',$filterstexto)
										   ->with('filtersoficina',$filtersoficina)
										   ->with('filterstipousuario',$filterstipousuario)
										   ->with('dependencias',$dependencias)
										   ->with('dependenciascombo',$dependenciascombo);
		}		
	}
	/**
     * usuariosDestroy (desactivar/activar usuario)
     */
	public function usuariosDestroy(Request $request)
	{
		$usuario= User::find($request->get('id_user'));
	    $status = $request->get('estatus');		
		if($status=="activo"){
			$status="inactivo";
		}
		else{
			$status="activo";			
		}
		//Set values to update.		
		$usuario->estatus = $status;		

		try {
	  		$usuario->save();
	  		if($status=="activo"){
	  			$status_string="activó";	
	  		}
	  		else{
	  			$status_string="desactivó";
	  		}	
			return redirect()->back()->with('success', 'El usuario ('.$usuario->nombre.') se '.$status_string.' correctamente.');
		}catch(\Illuminate\Database\QueryException $e){			
		  	return redirect()->back()->with('errors', 'Hubo un error, intenta mas tarde. '.$e);
		}
	}
	
	/**
     * usuariosStore (crear usuario)
     */
	public function usuariosStore(Request $request)
	{
		try {		 				 		 
			 $usuario= new User();			
			 $usuario->tipo_user = $request->get('tipousuario');			 		 			  			 
			 if($request->get('email')!=""){
			 	$usuarioemail = User::where('email',$request->get('email'))->get();
			 	if(count($usuarioemail)>0){
			 		return redirect()->back()->with('errors', 'Ocurrió un error. Ya existe un usuario registrado con ese email ('.$request->get('email').').');		
			 	}
			 	$usuario->email = $request->get('email');
			 }
			 if($request->get('password')!=""){
			 	$usuario->password = bcrypt($request->get('password'));
			 }
			 $usuario->nombre = $request->get('nombre');					 
			 $usuario->oficina_id = $request->get('oficina');
			 $usuario->save();						 						 						 
		 } catch(\Exception $e){			
			$error=substr($e->getMessage(),1,50);			
			return redirect()->back()->with('errors', 'Ocurrió un error, intenta mas tarde. '.$error);			
		 }

		 return redirect()->back()->with('success', 'El usuario ('.$usuario->nombre.') se guardó correctamente.');
	}

	/**
     * usuariosUpdate (actualizar usuario)
     */
	public function usuariosUpdate(Request $request)
	{
		$usuario= User::find($request->get('id_user'));
	    		
		//Set values to update.
		if (request()->has('tipousuario')) {( !empty($request->get('tipousuario'))  ? $usuario->tipo_user = $request->get('tipousuario') : null );}
		if (request()->has('email')) {( !empty($request->get('email'))  ? $usuario->email = $request->get('email') : null );}
		if($request->get('email')!=""){
		 	$usuarioemail = User::where('email',$request->get('email'))->where('id_user','!=',$request->get('id_user'))->get();
		 	if(count($usuarioemail)>0){
		 		return redirect()->back()->with('errors', 'Ocurrió un error. Ya existe un usuario registrado con ese email.');		
		 	}
		 	$usuario->email = $request->get('email');
		 }
		if (request()->has('newpassword')) {( !empty($request->get('newpassword'))  ? $usuario->password = bcrypt($request->get('newpassword')) : null );}
		if (request()->has('nombre')) {( !empty($request->get('nombre'))  ? $usuario->nombre = $request->get('nombre') : null );}	
		if (request()->has('oficina')) {( !empty($request->get('oficina'))  ? $usuario->oficina_id = $request->get('oficina') : null );}	

		try {
	  		$usuario->save();
			return redirect()->back()->with('success', 'El usuario ('.$usuario->nombre.') se actualizó correctamente.');
		}catch(\Illuminate\Database\QueryException $e){			
		  	return redirect()->back()->with('errors', 'Hubo un error al actualizar, intenta mas tarde. '.$e);
		}
	}

	/**
     * usuariosDestroyTramitexUser (eliminar tramite del usuario)
     */
	public function usuariosDestroyTramitexUser(Request $request)
	{
		$tramitexuser= Tramitesxuser::find($request->get('id_tramitexuser'));
		try {
			$datostramite=DB::table('tramitesxusers')
				->leftjoin('tramites','tramites.id_tramite','=','tramitesxusers.tramite_id')
				->leftjoin('users','users.id_user','=','tramitesxusers.user_id')
				->where('id_tramitesxusers',$tramitexuser->id_tramitesxusers)->first();
	  		$tramitexuser->delete();	  			
			return redirect()->back()->with('success', 'El trámite ('.$datostramite->nombre_tramite.') del usuario ('.$datostramite->nombre.') se eliminó correctamente.');
		}catch(\Illuminate\Database\QueryException $e){			
		  	return redirect()->back()->with('errors', 'Hubo un error, intenta mas tarde. '.$e);
		}
	}

	/**
     * usuariosStoreTramitexUser (crear tramite x usuario)
     */
	public function usuariosStoreTramitexUser(Request $request)
	{
		try {		 				 		 
			 $tramitesxusers= new Tramitesxuser();			
			 $tramitesxusers->tramite_id = $request->get('tramite');
			 $tramitesxusers->user_id = $request->get('id_user');
			 if (request()->has('lunes_inicio')) {( !empty($request->get('lunes_inicio'))  ? $tramitesxusers->lunes_inicio = $request->get('lunes_inicio') : null );}
			 if (request()->has('lunes_fin')) {( !empty($request->get('lunes_fin'))  ? $tramitesxusers->lunes_fin = $request->get('lunes_fin') : null );}
			 if (request()->has('martes_inicio')) {( !empty($request->get('martes_inicio'))  ? $tramitesxusers->martes_inicio = $request->get('martes_inicio') : null );}
			 if (request()->has('martes_fin')) {( !empty($request->get('martes_fin'))  ? $tramitesxusers->martes_fin = $request->get('martes_fin') : null );}
			 if (request()->has('miercoles_inicio')) {( !empty($request->get('miercoles_inicio'))  ? $tramitesxusers->miercoles_inicio = $request->get('miercoles_inicio') : null );}
			 if (request()->has('miercoles_fin')) {( !empty($request->get('miercoles_fin'))  ? $tramitesxusers->miercoles_fin = $request->get('miercoles_fin') : null );}
			 if (request()->has('jueves_inicio')) {( !empty($request->get('jueves_inicio'))  ? $tramitesxusers->jueves_inicio = $request->get('jueves_inicio') : null );}
			 if (request()->has('jueves_fin')) {( !empty($request->get('jueves_fin'))  ? $tramitesxusers->jueves_fin = $request->get('jueves_fin') : null );}
			 if (request()->has('viernes_inicio')) {( !empty($request->get('viernes_inicio'))  ? $tramitesxusers->viernes_inicio = $request->get('viernes_inicio') : null );}
			 if (request()->has('viernes_fin')) {( !empty($request->get('viernes_fin'))  ? $tramitesxusers->viernes_fin = $request->get('viernes_fin') : null );}
			 if (request()->has('sabado_inicio')) {( !empty($request->get('sabado_inicio'))  ? $tramitesxusers->sabado_inicio = $request->get('sabado_inicio') : null );}
			 if (request()->has('sabado_fin')) {( !empty($request->get('sabado_fin'))  ? $tramitesxusers->sabado_fin = $request->get('sabado_fin') : null );}

			 $tramitedato=Tramite::where("id_tramite",$tramitesxusers->tramite_id)->first();
			 $userdato=User::where("id_user",$tramitesxusers->user_id)->first();

			 $tramiteusuario = Tramitesxuser::where('tramite_id',$request->get('tramite'))->where('user_id',$request->get('id_user'))->get();
		 	 if(count($tramiteusuario)>0){
		 		return redirect()->back()->with('errors', 'Ocurrió un error. Ya existe el trámite ('.$tramitedato->nombre_tramite.') para el usuario ('.$userdato->nombre.').');		
		 	 }	
			 			 		 			  			 
			 $tramitesxusers->save();					 						 						 
		 } catch(\Exception $e){			
			$error=substr($e->getMessage(),1,50);			
			return redirect()->back()->with('errors', 'Ocurrió un error, intenta mas tarde. '.$error);			
		 }

		 return redirect()->back()->with('success', 'El trámite ('.$tramitedato->nombre_tramite.') del usuario ('.$userdato->nombre.') se guardó correctamente.');
	}

	/**
     * usuariosUpdateTramitexUser (actualizar tramite x usuario)
     */
	public function usuariosUpdateTramitexUser(Request $request)
	{		
		 $tramitesxusers= Tramitesxuser::find($request->get('id_tramitexuser'));
		 //Set values to update.			
		 $tramitesxusers->tramite_id = $request->get('tramite');
		 $tramitesxusers->user_id = $request->get('id_user');
		 if (request()->has('lunes_inicio')) {( !empty($request->get('lunes_inicio'))  ? $tramitesxusers->lunes_inicio = $request->get('lunes_inicio') : null );}
		 if (request()->has('lunes_fin')) {( !empty($request->get('lunes_fin'))  ? $tramitesxusers->lunes_fin = $request->get('lunes_fin') : null );}
		 if (request()->has('martes_inicio')) {( !empty($request->get('martes_inicio'))  ? $tramitesxusers->martes_inicio = $request->get('martes_inicio') : null );}
		 if (request()->has('martes_fin')) {( !empty($request->get('martes_fin'))  ? $tramitesxusers->martes_fin = $request->get('martes_fin') : null );}
		 if (request()->has('miercoles_inicio')) {( !empty($request->get('miercoles_inicio'))  ? $tramitesxusers->miercoles_inicio = $request->get('miercoles_inicio') : null );}
		 if (request()->has('miercoles_fin')) {( !empty($request->get('miercoles_fin'))  ? $tramitesxusers->miercoles_fin = $request->get('miercoles_fin') : null );}
		 if (request()->has('jueves_inicio')) {( !empty($request->get('jueves_inicio'))  ? $tramitesxusers->jueves_inicio = $request->get('jueves_inicio') : null );}
		 if (request()->has('jueves_fin')) {( !empty($request->get('jueves_fin'))  ? $tramitesxusers->jueves_fin = $request->get('jueves_fin') : null );}
		 if (request()->has('viernes_inicio')) {( !empty($request->get('viernes_inicio'))  ? $tramitesxusers->viernes_inicio = $request->get('viernes_inicio') : null );}
		 if (request()->has('viernes_fin')) {( !empty($request->get('viernes_fin'))  ? $tramitesxusers->viernes_fin = $request->get('viernes_fin') : null );}
		 if (request()->has('sabado_inicio')) {( !empty($request->get('sabado_inicio'))  ? $tramitesxusers->sabado_inicio = $request->get('sabado_inicio') : null );}
		 if (request()->has('sabado_fin')) {( !empty($request->get('sabado_fin'))  ? $tramitesxusers->sabado_fin = $request->get('sabado_fin') : null );}

		 $tramitedato=Tramite::where("id_tramite",$tramitesxusers->tramite_id)->first();
		 $userdato=User::where("id_user",$tramitesxusers->user_id)->first();

		 $tramiteusuario = Tramitesxuser::where('tramite_id',$request->get('tramite'))
		 		->where('user_id',$request->get('id_user'))
		 		->where('id_tramitesxusers','!=',$request->get('id_tramitexuser'))
		 		->get();
	 	 if(count($tramiteusuario)>0){
	 		return redirect()->back()->with('errors', 'Ocurrió un error. Ya existe el trámite ('.$tramitedato->nombre_tramite.') para el usuario ('.$userdato->nombre.').');		
	 	 }		

		try {
	  		$tramitesxusers->save();
			return redirect()->back()->with('success', 'El trámite ('.$tramitedato->nombre_tramite.') del usuario ('.$userdato->nombre.') se actualizó correctamente.');
		}catch(\Illuminate\Database\QueryException $e){			
		  	return redirect()->back()->with('errors', 'Hubo un error al actualizar, intenta mas tarde. '.$e);
		}
	}

	/**
     * usuariosCsv (descarga de listado de usuarios en csv) PENDING
     */	
	public function usuariosCsv(Request $request)
	{
	}


	/****AUSENCIAS****/
    /**
     * ausenciasusuariosListar (obtener historial de ausencias por usuarios)
     */
    public function ausenciasusuariosListar($usuario=false)
	{
		
		$data = Helper::getMenuData();

		if($data["rol"]=="tramitador"){ return redirect('sistema'); }
		
		if($data["rol"]=="admin_oficina" || $data["rol"]=="superadmin"){ 
			
			//filtros de fecha
			$filtersfecha1 = null;
			if (request()->has('filtersfecha1')){
				$filtersfecha1 = request()->filtersfecha1;
			}
			$filtersfecha2 = null;
			if (request()->has('filtersfecha2')){
				$filtersfecha2 = request()->filtersfecha2;
			}

			//saber si el usuario existe y si este es invocado por admin de oficina y pertenece a su oficina			
			$usuario=User::where('id_user',intval($usuario));
			if($data["rol"]=="admin_oficina"){
				$usuario = $usuario->where("oficina_id",$data['oficina']);
			}
			$usuario= $usuario->first();
			
			//si tenemos el usario
			if(count($usuario)>0){
				//getting ausencias
				$ausencias = DB::table('ausencias')
							->where('user_id',$usuario->id_user);
				if($filtersfecha1 != null){
					$ausencias = $ausencias->whereBetween('fecha_inicio',[$filtersfecha1." 00:00:00",$filtersfecha2." 23:59:59"]);	
				}
				$ausencias = $ausencias->orderBy('fecha_inicio','DESC');
				//$sql = str_replace_array('?', $ausencias->getBindings(), $ausencias->toSql());
				//dd($sql);							
				$ausencias = $ausencias->get();	
				$indexausencia=0;

				foreach($ausencias as $ausencia){

					//to print in table
						$fechainicio =  DateTime::createFromFormat('Y-m-d H:i:s',$ausencia->fecha_inicio);				
						setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
						$fechafin =  DateTime::createFromFormat('Y-m-d H:i:s',$ausencia->fecha_fin);				
						setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
						
					$ausencias[$indexausencia]->fecha_iniciohuman  = strftime("%d %B, %Y - %H:%M",$fechainicio->getTimestamp());
					$ausencias[$indexausencia]->fecha_finhuman     = strftime("%d %B, %Y - %H:%M",$fechafin->getTimestamp());
					//to manage data
						$fechainicioparsed=date("Y-m-d\TH:i",strtotime($ausencia->fecha_inicio));
						$fechafinparsed=date("Y-m-d\TH:i",strtotime($ausencia->fecha_fin));
					$ausencias[$indexausencia]->fecha_inicioparsed = $fechainicioparsed;
					$ausencias[$indexausencia]->fecha_finparsed    = $fechafinparsed;

					$ausencias[$indexausencia]->fecha_iniciotoorder  = strftime("%B %Y",$fechainicio->getTimestamp());

					$indexausencia++;	
				}

				//return the view		
				return view('sistema.ausencias')->with('data',$data)
											   ->with('filtersfecha1',$filtersfecha1)
											   ->with('filtersfecha2',$filtersfecha2)
											   ->with('ausencias',$ausencias)
											   ->with('usuario',$usuario);
			}
			else{
				return redirect()->route('usuarios');
			}
		}		
	}

	/**
     * ausenciasStore (crear ausencia)
     */
	public function ausenciasStore(Request $request)
	{
		DB::beginTransaction();
		try {		 				 		 
			
			$ausencia= new Ausencia();						
			$ausencia->user_id = $request->get('id_usuario');	
			$ausencia->fecha_inicio = $request->get('fechainicio');	
			$ausencia->fecha_fin = $request->get('fechafin');	
			$ausencia->motivo = $request->get('motivo');			
			$ausencia->save();				
			DB::commit();
					
		} catch(\Exception $e){	
			DB::rollback();	
			$error=substr($e->getMessage(),0,50);			
			return redirect()->back()->with('errors', 'Ocurrió un error, intenta mas tarde. '.$error);			
		}

		return redirect()->back()->with('success', 'La ausencia se guardó correctamente.');
	}

	/**
     * ausenciasUpdate (actualizar ausencia)
     */
	public function ausenciasUpdate(Request $request)
	{
		DB::beginTransaction();
		try {		 				 		 
			
			$ausencia= Ausencia::find($request->get('id_ausencia'));						
			$ausencia->fecha_inicio = $request->get('fechainicio');	
			$ausencia->fecha_fin = $request->get('fechafin');		
			$ausencia->motivo = $request->get('motivo');						
			$ausencia->save();
			DB::commit();
			
		} catch(\Exception $e){	
			DB::rollback();	
			$error=substr($e->getMessage(),1,50);			
			return redirect()->back()->with('errors', 'Ocurrió un error, intenta mas tarde. '.$error);			
		}

		return redirect()->back()->with('success', 'La ausencia se actualizó correctamente.');
	}

	/**
     * ausenciasDelete (eliminar ausencia)
     */
	public function ausenciasDelete(Request $request)
	{
		DB::beginTransaction();
		try {		 				 		 												
			$ausencia= Ausencia::find($request->get('id_ausencia'));
			$ausencia->delete();						
			DB::commit();						
		} catch(\Exception $e){	
			DB::rollback();										
			$error=substr($e->getMessage(),1,50);			
			return redirect()->back()->with('errors', 'Ocurrió un error, intenta mas tarde. '.$error);			
		}
		return redirect()->back()->with('success', 'La ausencia se eliminó correctamente.');
	}





	/****TRAMITES****/
    /**
     * tramitesListar (obtener historial de tramites por oficina)
     */
    public function tramitesListar(Request $request)
	{
		
		$data = Helper::getMenuData();

		if($data["rol"]=="tramitador"){ return redirect('sistema'); }
		
		if($data["rol"]=="admin_oficina" || $data["rol"]=="superadmin"){ 
			
			$filterstexto = null;
			if (request()->has('searchPars')){
				$filterstexto = request()->searchPars;
			}
			
			$filtersoficina = null;
			if (request()->has('oficina')){
				$filtersoficina = request()->oficina;
			}

			//getting dependencias
			$dependencias = DB::table('dependencias');
			if($data["rol"]=="admin_oficina"){	//if admin oficina, only get the dependencia from oficina from the admin
				$dependencias = $dependencias
								->join('oficinas','dependencias.id_dependencia', '=', 'oficinas.dependencia_id')
								->where('id_oficina', $data["user"]->oficina_id)
								->distinct();
			}				
			$dependencias = $dependencias->get();
			$indexdependencia = 0;	//initializing counter dependencia

			//getting dependencias for combo
			$dependenciascombo = DB::table('dependencias')->get();
			$indexdependenciacombo = 0;
			//for each dependencia for combo
			foreach($dependenciascombo as $dependencia){
				$oficinascombo = DB::table('oficinas')
								->where('dependencia_id',$dependencia->id_dependencia)
								->orderBy('nombre_oficina','ASC')->get();
				$dependenciascombo[$indexdependenciacombo]->oficinas = $oficinascombo;	//setting in the dependencias the oficinas array
				$indexdependenciacombo++;
			}

			//for each dependencia
			foreach($dependencias as $dependencia){

				//getting oficinas from dependencia
				$oficinas = DB::table('oficinas')
								->where('dependencia_id',$dependencia->id_dependencia);
				if($data["rol"]=="admin_oficina"){	//if admin oficina, only get the oficina from the admin
					$oficinas = $oficinas->where('id_oficina', $data["user"]->oficina_id);
				}	
				if ($filtersoficina != null) {	//if get filter search nombre
					$oficinas = $oficinas->where('id_oficina',$filtersoficina);
				}
				$oficinas = $oficinas->orderBy('nombre_oficina','ASC')->get();				
				$indexoficina = 0; //initializing counter oficina

				//for each oficina
				foreach($oficinas as $oficina){

					//cambiar consulta para traer todos los tramites y solo en los casos de los tramites que hay en la oficina marcarlos como activo e indicar su fecha apply

					//getting tramites from oficina
					/*$tramitesxoficinas = DB::table('tramitesxoficinas')
								->leftJoin('tramites','tramites.id_tramite','=','tramitesxoficinas.tramite_id')
								->where('oficina_id', $oficina->id_oficina)
								->select('tramitesxoficinas.id_tramitesxoficinas','tramitesxoficinas.oficina_id','tramitesxoficinas.apply_date','tramites.*',DB::raw("'activo' as estatus"))
								->orderBy('nombre_tramite','ASC');*/

					$tramitesxoficinas = DB::table('tramites')
								->where('dependencia_id',$dependencia->id_dependencia)
								//->leftJoin('tramitesxoficinas','tramites.id_tramite','=','tramitesxoficinas.tramite_id')
								->orderBy('nombre_tramite','ASC');	

					//dd($tramitesxoficinas->get());

					if ($filterstexto != null) {	//if get filter search nombre/codigo
						$tramitesxoficinas = $tramitesxoficinas
									->where(function($query) use ($filterstexto)
									{
										$query->where('nombre_tramite', 'like',  '%' .$filterstexto. '%')
											->orWhere('codigo', 'like', '%' .$filterstexto. '%');
									});
					}
					$tramitesxoficinas=$tramitesxoficinas->get();
					foreach($tramitesxoficinas as $tramitesxoficina){
						$tramitesxoficinasoficina = DB::table('tramitesxoficinas')->where('oficina_id', $oficina->id_oficina)->where('tramite_id', $tramitesxoficina->id_tramite)->get();
						if(count($tramitesxoficinasoficina)>0){	
							$fechahoradate =  DateTime::createFromFormat('Y-m-d H:i:s',$tramitesxoficinasoficina[0]->apply_date);				
							setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
							$tramitesxoficina->fecha=strftime("%d %b, %Y",$fechahoradate->getTimestamp());
							$tramitesxoficina->apply_date = strftime("%Y-%m-%d",$fechahoradate->getTimestamp());
							$tramitesxoficina->estatus='activo';
							$tramitesxoficina->id_tramitesxoficinas = $tramitesxoficinasoficina[0]->id_tramitesxoficinas;
							$tramitesxoficina->oficina_id = $tramitesxoficinasoficina[0]->oficina_id;
						}
						else{
							$tramitesxoficina->fecha="";
							$tramitesxoficina->apply_date ="";
							$tramitesxoficina->estatus='inactivo';
							$tramitesxoficina->id_tramitesxoficinas = "";
							$tramitesxoficina->oficina_id = $oficina->id_oficina;
						}
					
					}
					$oficinas[$indexoficina]->tramites = $tramitesxoficinas; //setting in the oficinas the tramites from oficina array
					$indexoficina++;

				}

				$dependencias[$indexdependencia]->oficinas = $oficinas;	//setting in the dependencias the oficinas array
				$indexdependencia++;

			}
			//dd($dependencias);			
			return view('sistema.tramites')->with('data',$data)
										   ->with('filterstexto',$filterstexto)
										   ->with('filtersoficina',$filtersoficina)
										   ->with('dependencias',$dependencias)
										   ->with('dependenciascombo',$dependenciascombo);
		}		
	}
	
	/**
     * tramitesStore (crear tramite)
     */
	public function tramitesStore(Request $request)
	{
		DB::beginTransaction();
		try {		 				 		 
			
			$tramites= new Tramite();						
			$tramites->nombre_tramite = $request->get('nombre');
			if($request->get('requisitos')!=""){
				$tramites->requisitos = $request->get('requisitos');
			}
			else{
				$tramites->requisitos = "Sin requisitos";
			}
			$tramites->tiempo_minutos = $request->get('tiempo');
			$tramites->costo = $request->get('costo');	
			$tramites->codigo = strtoupper($request->get('codigo'));		//validate unique codigo
			$tramites->dependencia_id = $request->get('dependencia');	
			$tramites->warning_message = $request->get('warning_message');				
			if($tramites->save()){	
				//si no hay oficina, quiere decir es el superadministrador que creo el tramite, por lo que la asignacion de la oficina es posterior
				if($request->get('id_oficina')!=""){
					$idtramite = $tramites->id_tramite;				
					$tramitesxoficinas= new Tramitesxoficina();			
					$tramitesxoficinas->tramite_id = $idtramite; 
					$tramitesxoficinas->oficina_id = $request->get('id_oficina');	
					$tramitesxoficinas->apply_date = date('Y-m-d',  strtotime("+3 months")); //now();	
					$tramitesxoficinas->save();
				}
				DB::commit();
			}			
		} catch(\Exception $e){	
			DB::rollback();	
			$error=substr($e->getMessage(),0,50);			
			return redirect()->back()->with('errors', 'Ocurrió un error, intenta mas tarde. '.$error);			
		}

		return redirect()->back()->with('success', 'El trámite ('.$tramites->nombre_tramite.') se guardó correctamente.');
	}

	/**
     * tramitesUpdate (actualizar tramite)
     */
	public function tramitesUpdate(Request $request)
	{
		DB::beginTransaction();
		try {		 				 		 
			
			$tramites= Tramite::find($request->get('id_tramite'));						
			$tramites->nombre_tramite = $request->get('nombre');
			//$tramites->requisitos = $request->get('requisitos');

			if($request->get('requisitos')!=""){
				$tramites->requisitos = $request->get('requisitos');
			}
			else{
				$tramites->requisitos = "Sin requisitos";
			}

			$tramites->tiempo_minutos = $request->get('tiempo');
			$tramites->costo = $request->get('costo');	
			$tramites->codigo = strtoupper($request->get('codigo'));		//validate unique codigo
			$tramites->dependencia_id = $request->get('dependencia');	
			$tramites->warning_message = $request->get('warning_message');				
			$tramites->save();
			DB::commit();

		} catch(\Exception $e){	
			DB::rollback();	
			$error=substr($e->getMessage(),1,50);			
			return redirect()->back()->with('errors', 'Ocurrió un error, intenta mas tarde. '.$error);			
		}

		return redirect()->back()->with('success', 'El trámite ('.$tramites->nombre_tramite.') se actualizó correctamente.');
	}

	/**
     * tramitesDelete (eliminar tramite) ADMINISTRADOR
     */
	public function tramitesDelete(Request $request)
	{
		DB::beginTransaction();
		try {		

			try {		 		
				$tramitesxuser= Tramitesxuser::where("tramite_id",$request->get('id_tramite'))->get();
				if(count($tramitesxuser)>0){
					return redirect()->back()->with('errors', 'No se puede borrar este trámite, esta siendo usada en otras entidades.');
				}
				else{
					$tramitesxoficina= Tramitesxoficina::where("tramite_id",$request->get('id_tramite'));
					$tramitesxoficina->delete();						
					DB::commit();				
				}		
			} catch(\Exception $e){	
				DB::rollback();										
				$error=substr($e->getMessage(),1,50);			
				return redirect()->back()->with('errors', 'Ocurrió un error, intenta mas tarde. '.$error);			
			}			

			$tramite= Tramite::find($request->get('id_tramite'));
			$tramite->delete();						
			DB::commit();						
		} catch(\Exception $e){	
			DB::rollback();			
			if($e->getCode()==23000 && $e->errorInfo[1]==1451){
				return redirect()->back()->with('errors', 'No se puede borrar este trámite, esta siendo usada en otras entidades.');
			}				
			$error=substr($e->getMessage(),1,50);			
			return redirect()->back()->with('errors', 'Ocurrió un error, intenta mas tarde. '.$error);			
		}
		return redirect()->back()->with('success', 'El trámite ('.$tramite->nombre_tramite.') se eliminó correctamente.');
	}	

	/**
     * tramitesxOficinaStore (activar tramite x oficina)
     */
	public function tramitesxOficinaStore(Request $request)
	{
		DB::beginTransaction();
		try {		 				 		 
													
			$tramitesxoficinas= new Tramitesxoficina();			
			$tramitesxoficinas->tramite_id = $request->get('id_tramite'); 
			$tramitesxoficinas->oficina_id = $request->get('id_oficina');	
			$tramitesxoficinas->apply_date = $request->get('fecha');	
			$tramitesxoficinas->save();

			$tramites= Tramite::find($request->get('id_tramite'));
			$oficinas= Oficina::find($request->get('id_oficina'));		

			DB::commit();
						
		} catch(\Exception $e){	
			DB::rollback();	
			$error=substr($e->getMessage(),1,50);			
			return redirect()->back()->with('errors', 'Ocurrió un error, intenta mas tarde. '.$error);			
		}

		return redirect()->back()->with('success', 'El trámite ('.$tramites->nombre_tramite.') para la oficina ('.$oficinas->nombre_oficina.') se guardó correctamente.');
	}

	/**
     * tramitesxOficinaUpdate (actualizar tramite x oficina)
     */
	public function tramitesxOficinaUpdate(Request $request)
	{
		DB::beginTransaction();
		try {		 				 		 
													
			$tramitesxoficinas= Tramitesxoficina::find($request->get('id_tramitesxoficinas'));	
			$tramitesxoficinas->apply_date = $request->get('fecha');	
			$tramitesxoficinas->save();

			$tramites= Tramite::find($request->get('id_tramite'));
			$oficinas= Oficina::find($request->get('id_oficina'));		

			DB::commit();
						
		} catch(\Exception $e){	
			DB::rollback();	
			$error=substr($e->getMessage(),1,50);			
			return redirect()->back()->with('errors', 'Ocurrió un error, intenta mas tarde. '.$error);			
		}

		return redirect()->back()->with('success', 'El trámite ('.$tramites->nombre_tramite.') para la oficina ('.$oficinas->nombre_oficina.') se actualizó correctamente.');
	}
	/**
     * Saber si un codigo de tramite esta usado
     */
    public function getcodetramite($code=false)
    {
    	try {	    	
    		$code=Tramite::where('codigo',$code)->get();
    		if(count($code)>0){
    			$error="true";
				$description='El código ya ha sido usado, elige otro';
    		}
    		else{
    			$error="false";
				$description='Código libre';
    		}
		} catch(\Exception $e){	
			$error="false";
			$description='Ocurrió un error, intenta mas tarde. '.$error;
		}
		return response()->json([
		    'error' => $error,
		    'description' => $description
		]);
    }


	/****DEPENDENCIAS Y OFICINAS****/
    /**
     * dependenciasListar (obtener listado de dependencias y oficinas)
     */
    public function dependenciasListar(Request $request)
	{
		
		$data = Helper::getMenuData();

		if($data["rol"]=="tramitador" || $data["rol"]=="admin_oficina"){ return redirect('sistema'); }
		
		if($data["rol"]=="superadmin"){ 
			
			$filterstexto = null;
			if (request()->has('searchPars')){
				$filterstexto = request()->searchPars;
			}
			
			$filtersdependencia = null;
			if (request()->has('dependencia')){
				$filtersdependencia = request()->dependencia;
			}

			//getting dependencias
			$dependencias = DB::table('dependencias');
			if ($filtersdependencia != null) {	//if get filter dependencia
				$dependencias = $dependencias->where('id_dependencia',$filtersdependencia);
			}
			$dependencias = $dependencias->orderBy('nombre_dependencia','ASC')->get();
			$indexdependencia = 0;	//initializing counter dependencia

			//getting dependencias for combo
			$dependenciascombo = DB::table('dependencias')->orderBy('nombre_dependencia','ASC')->get();			

			//for each dependencia
			foreach($dependencias as $dependencia){

				//getting oficinas from dependencia
				$oficinas = DB::table('oficinas')
								->where('dependencia_id',$dependencia->id_dependencia);
									
				if ($filterstexto != null) {	//if get filter search nombre/direccion
					$oficinas = $oficinas
								->where(function($query) use ($filterstexto)
								{
									$query->where('nombre_oficina', 'like',  '%' .$filterstexto. '%')
										->orWhere('direccion', 'like', '%' .$filterstexto. '%');
								});
				}	

				$oficinas = $oficinas->orderBy('nombre_oficina','ASC')->get();				
				$indexoficina = 0; //initializing counter oficina				

				$dependencias[$indexdependencia]->oficinas = $oficinas;	//setting in the dependencias the oficinas array
				$indexdependencia++;

			}
			//dd($dependencias);			
			return view('sistema.dependencias')->with('data',$data)
										   ->with('filterstexto',$filterstexto)
										   ->with('filtersdependencia',$filtersdependencia)
										   ->with('dependencias',$dependencias)
										   ->with('dependenciascombo',$dependenciascombo);
		}		
	}
	
	/**
     * dependenciasStore (crear dependencia)
     */
	public function dependenciasStore(Request $request)
	{
		DB::beginTransaction();
		try {		 				 		 
			
			$dependencia= new Dependencia();						
			$dependencia->nombre_dependencia = $request->get('nombre');			
			$dependencia->save();				
			DB::commit();
					
		} catch(\Exception $e){	
			DB::rollback();	
			$error=substr($e->getMessage(),0,50);			
			return redirect()->back()->with('errors', 'Ocurrió un error, intenta mas tarde. '.$error);			
		}

		return redirect()->back()->with('success', 'La dependencia ('.$dependencia->nombre_dependencia.') se guardó correctamente.');
	}

	/**
     * dependenciasUpdate (actualizar dependencia)
     */
	public function dependenciasUpdate(Request $request)
	{
		DB::beginTransaction();
		try {		 				 		 
			
			$dependencia= Dependencia::find($request->get('id_dependencia'));						
			$dependencia->nombre_dependencia = $request->get('nombre');						
			$dependencia->save();
			DB::commit();
			
		} catch(\Exception $e){	
			DB::rollback();	
			$error=substr($e->getMessage(),1,50);			
			return redirect()->back()->with('errors', 'Ocurrió un error, intenta mas tarde. '.$error);			
		}

		return redirect()->back()->with('success', 'La dependencia ('.$dependencia->nombre_dependencia.') se actualizó correctamente.');
	}

	/**
     * dependenciasDelete (eliminar dependencia)
     */
	public function dependenciasDelete(Request $request)
	{
		DB::beginTransaction();
		try {		 				 		 												
			$dependencia= Dependencia::find($request->get('id_dependencia'));
			$dependencia->delete();						
			DB::commit();						
		} catch(\Exception $e){	
			DB::rollback();			
			if($e->getCode()==23000 && $e->errorInfo[1]==1451){
				return redirect()->back()->with('errors', 'No se puede borrar esta dependencia, esta siendo usada en otras entidades.');
			}				
			$error=substr($e->getMessage(),1,50);			
			return redirect()->back()->with('errors', 'Ocurrió un error, intenta mas tarde. '.$error);			
		}
		return redirect()->back()->with('success', 'La dependencia ('.$dependencia->nombre_dependencia.') se eliminó correctamente.');
	}


	/**
     * oficinasStore (crear oficina)
     */
	public function oficinasStore(Request $request)
	{
		DB::beginTransaction();
		try {		 				 		 
													
			$oficina= new Oficina();			
			$oficina->nombre_oficina = $request->get('nombre');
			$oficina->coords = $request->get('coords');
			$oficina->direccion = $request->get('direccion');
			$oficina->dependencia_id = $request->get('id_dependencia');
			$oficina->save();		

			DB::commit();
					
		} catch(\Exception $e){	
			DB::rollback();	
			$error=substr($e->getMessage(),1,50);			
			return redirect()->back()->with('errors', 'Ocurrió un error, intenta mas tarde. '.$error);			
		}

		return redirect()->back()->with('success', 'La oficina ('.$oficina->nombre_oficina.') se guardó correctamente.');
	}

	/**
     * oficinasUpdate (actualizar oficina)
     */
	public function oficinasUpdate(Request $request)
	{
		DB::beginTransaction();
		try {		 				 		 
												
			$oficina= Oficina::find($request->get('id_oficina'));	
			$oficina->nombre_oficina = $request->get('nombre');
			$oficina->coords = $request->get('coords');
			$oficina->direccion = $request->get('direccion');
			$oficina->save();
						
			DB::commit();
						
		} catch(\Exception $e){	
			DB::rollback();				
			$error=substr($e->getMessage(),1,50);			
			return redirect()->back()->with('errors', 'Ocurrió un error, intenta mas tarde. '.$error);			
		}

		return redirect()->back()->with('success', 'La oficina ('.$oficina->nombre_oficina.') se actualizó correctamente.');
	}

	/**
     * oficinasDelete (eliminar oficina)
     */
	public function oficinasDelete(Request $request)
	{
		DB::beginTransaction();
		try {		 				 		 												
			$oficina= Oficina::find($request->get('id_oficina'));
			$oficina->delete();						
			DB::commit();						
		} catch(\Exception $e){	
			DB::rollback();			
			if($e->getCode()==23000 && $e->errorInfo[1]==1451){
				return redirect()->back()->with('errors', 'No se puede borrar esta oficina, esta siendo usada en otras entidades.');
			}				
			$error=substr($e->getMessage(),1,50);			
			return redirect()->back()->with('errors', 'Ocurrió un error, intenta mas tarde. '.$error);			
		}
		return redirect()->back()->with('success', 'La oficina ('.$oficina->nombre_oficina.') se eliminó correctamente.');
	}



	/****TURNOS***/
	/**
     * turnosUpdate (actualizar turno)
     */
	public function turnosUpdate(Request $request)
	{
		DB::beginTransaction();
		try {		 				 		 
			/*										
			$tramitesxoficinas= Tramitesxoficina::find($request->get('id_tramitesxoficinas'));	
			$tramitesxoficinas->apply_date = $request->get('fecha');	
			$tramitesxoficinas->save();

			$tramites= Tramite::find($request->get('id_tramite'));
			$oficinas= Oficina::find($request->get('id_oficina'));		

			DB::commit();
			*/			
		} catch(\Exception $e){	
			DB::rollback();	
			$error=substr($e->getMessage(),1,50);			
			return redirect()->back()->with('errors', 'Ocurrió un error, intenta mas tarde. '.$error);			
		}

		return redirect()->back()->with('success', 'El turno se actualizó correctamente.');
	}





	/**
     * getassignmentsfromoffice (obtener asignaciones de turnos de oficina)
     */
    public function getassignmentsfromoffice()
    {    	
    	try {
			//creando array asignacion
			$asignacion=[];
			//obteniendo a usuario
	    	$oficina=Auth::user()->oficina_id;	    	
	    	//obteniendo turno en proceso del usuario
	    	$turnos=Turno::where('estatus','enproceso')->where('oficina_id',$oficina)->where('fechahora_inicio',"!=","")->orderBy('fechahora_inicio','DESC')->take(5)->get();
	    	//si hay un turno en proceso del usuario, lo colocamos en el array
	    	if(count($turnos)>0){
	    		$asignacion["enproceso"]="si";	    		
	    		$indexturno = 0;	//initializing counter dependencia
				//for each dependencia
				foreach($turnos as $turno){
					//buscando el user para conocer su ventanilla
	    			$user=User::find($turno->user_id);	
					$turnos[$indexturno]->ventanilla = $user->ventanilla;	//setting in the ventanilla the ventanilla value
					$indexturno++;
				}	    		    			  
	    		$errorboolean="false"; 	    		
	    		$asignacion["turnos"]=$turnos;    		
			}
			else{ //si no hay turno en proceso para el usuario, entonces indicamos que no hay turno en proceso
				$asignacion["enproceso"]="no";
				$asignacion["turnos"]=[];    
				$errorboolean="false"; 
			}							
		} catch (Exception $e) {
			$asignacion=[];
			$errorboolean="true";
		} 
		return response()->json([
		    'error' => $errorboolean,
		    'asignacion' => $asignacion
		]);
    }

}
