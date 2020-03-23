<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cancion;
use App\Evento;
use App\Pago;
use App\User;
use App\Notificacion;
use Illuminate\Support\Facades\Auth;
use Hash;
use DB;
use Helper;
use File;
use Illuminate\Support\Facades\Storage;
use DateTime;
use Response;

require_once dirname(__FILE__).'/conekta/conektaphp/lib/Conekta.php';

class UsuariosController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


	/***************************************************************************************************************
	******* GENERAL
	/**************************************************************************************************************/
		
		
		 /***************************************************************************************************************
		 ******* VER PERFIL
		 /**************************************************************************************************************/
		 //Open profile view with the data
		public function index()
		{
				$user 				=  Auth::user();
				$nombre 			=  Auth::user()->NOMBRES;
				$nombreartistico 	=  Auth::user()->NOMBREARTISTICO;
				$telefono 			=  Auth::user()->TELEFONO;
				$facebook 			=  Auth::user()->FACEBOOK;
				$nivel 				=  Auth::user()->NIVEL;
				$fnac 				=  Auth::user()->FNAC;
				$email 				=  Auth::user()->EMAIL;
				$name 				=  Auth::user()->NOMBRES. ' - '. Auth::user()->NOMBREARTISTICO;
				
				$gustos 			=  Auth::user()->GUSTOS;
				$canciones 			=  Auth::user()->CANCIONES;
				$generono 			=  Auth::user()->GENERONO;
				$generosi 			=  Auth::user()->GENEROSI;
				
				$fdate = $fnac;
			    $tdate = date('y-m-d');
			    $datetime1 = new DateTime($fdate);
			    $datetime2 = new DateTime($tdate);
			    $interval = $datetime1->diff($datetime2);
			    $edad = $interval->format('%Y');				

				//obtiene las notificaciones y cantidad de pedidos
				$menuData = Helper::getMenuData($user);
				$administrador = 1;
				$usuario = $user->IDUSUARIO;
				
				$mensajes = DB::table("MENSAJES")				
				
				->where(function ($query) use ($administrador, $usuario)  {
						$query->where('EMISOR', '=', $administrador)
							  ->Where('RECEPTOR', '=', $usuario);
					})->orWhere(function ($query) use ($administrador, $usuario) {
						$query->where('EMISOR', '=', $usuario)
							  ->Where('RECEPTOR', '=', $administrador);
					})	
									
				->join('USUARIOS AS RECEPTOR', 'RECEPTOR.IDUSUARIO', '=', 'MENSAJES.RECEPTOR')
				->join('USUARIOS AS EMISOR', 'EMISOR.IDUSUARIO', '=', 'MENSAJES.EMISOR')
				->select('MENSAJES.*','RECEPTOR.NOMBRES AS NOMBRESRECEPTOR','RECEPTOR.NOMBREARTISTICO AS NOMBREARTISTICOEMISOR', 'RECEPTOR.EMAIL AS EMAILEMISOR', 'EMISOR.NOMBRES AS NOMBRESEMISOR','EMISOR.NOMBREARTISTICO AS NOMBREARTISTICOEMISOR', 'EMISOR.EMAIL AS EMAILEMISOR')->orderBy("IDMENSAJE","ASC")->get();
				
				
				$mensajesadmin = DB::table('MENSAJES')													 
											 ->where('EMISOR',1)
											 ->where('RECEPTOR',$user->IDUSUARIO)
											 ->where('LEIDO',0)
											 ->get();	
				$totalmensajesadmin = $mensajesadmin->count();
				
				$mensajescoach = DB::table('MENSAJES')													 
											 ->where('EMISOR','!=',1)
											 ->where('RECEPTOR',$user->IDUSUARIO)
											 ->where('LEIDO',0)
											 ->get();	
				$totalmensajescoach = $mensajescoach->count();
				
				
								
				return view('sistema.perfil')->with('user',$user)->with('nombre',$nombre)
																		->with('nombreartistico',$nombreartistico)
																		->with('facebook',$facebook)
																		->with('nivel',$nivel)
																		->with('telefono',$telefono)
																		->with('edad',$edad)
																		->with('fnac',$fnac)
																		->with('email',$email)
																		->with('name',$name)
																		
																		->with('gustos',$gustos)
																		->with('canciones',$canciones)
																		->with('generono',$generono)
																		->with('generosi',$generosi)
																		
																		->with('menudata',$menuData)
																		->with('iduser',Auth::user()->IDUSUARIO)
																		->with('totalmensajesadmin',$totalmensajesadmin)
																		->with('totalmensajescoach',$totalmensajescoach)
																		->with(compact('mensajes'));
		}
		
		
		
		
		
	/***************************************************************************************************************
	******* PARTICIPANTE
	/**************************************************************************************************************/
		 
		
		/***************************************************************************************************************
		 ******* VER PAGOS DESDE PARTICIPANTE
		 /**************************************************************************************************************/
		 //Open profile view with the data
		public function pagos(Request $request)
		{
				

				$user 				=  Auth::user();
				if($user->ROL!=1){ return redirect('sistema'); }
				$name 				=  Auth::user()->NOMBRES. ' - '. Auth::user()->NOMBREARTISTICO;
				
				if (request()->has('searchPars')){
					$filters = request()->searchPars;
				}else{
					$filters = null;
				}

				if ($filters != null) {
					  	$pagos = Pago::
							where('USER_ID',$user->IDUSUARIO)
							->where(function($query) use ($filters)
        				{
            				$query->where('PAYPALID', 'like',  '%' .$filters. '%');
        				})
							->get();


				}else{
						$pagos = Pago::where('USER_ID',$user->IDUSUARIO)->get();
				}
												
				
				//obtiene las notificaciones y cantidad de pedidos
				$menuData = Helper::getMenuData($user);

				$mensajesadmin = DB::table('MENSAJES')													 
											 ->where('EMISOR',1)
											 ->where('RECEPTOR',$user->IDUSUARIO)
											 ->where('LEIDO',0)
											 ->get();	
				$totalmensajesadmin = $mensajesadmin->count();
				
				$mensajescoach = DB::table('MENSAJES')													 
											 ->where('EMISOR','!=',1)
											 ->where('RECEPTOR',$user->IDUSUARIO)
											 ->where('LEIDO',0)
											 ->get();	
				$totalmensajescoach = $mensajescoach->count();

				return view('sistema.pagos')->with('user',$user)
																		->with('name',$name)
																		->with('filters',$filters)
																		->with('menudata',$menuData)
																		->with(compact('pagos'))
																		->with('totalmensajesadmin',$totalmensajesadmin)
																		->with('totalmensajescoach',$totalmensajescoach);
		}
		
		
		/***************************************************************************************************************
		 ******* NUEVO PAGOS DESDE PARTICIPANTE
		 /**************************************************************************************************************/
		 //Open profile view with the data
		public function newpayment(Request $request)
		{
			
			$user 				=  Auth::user();
			$name 				=  Auth::user()->NOMBRES. ' - '. Auth::user()->NOMBREARTISTICO;	
			
			try {
				
				if(strlen($request->payID)>17){
					$status=1;
				}
				else{
					$status=3;
				}
				
				$pagoUser = Pago::create([
							'USER_ID' => $user->IDUSUARIO,
							'MONTO' => $request->mont,
							'PAYPALID' => $request->payID,
							'STATUS' => $status
						]);
			} catch(\Exception $e){
						
				$error=substr($e->getMessage(),1,50);						
				return redirect()->back()->with('errors', 'Ocurrió un error. '.$e);						
						
			}
	
			return redirect()->back()->with('success','El pago se registró correctamente');
			
		}
		
		
		/***************************************************************************************************************
		 ******* NUEVO PAGOS DESDE ADMINISTRADOR
		 /**************************************************************************************************************/
		 //Open profile view with the data
		public function manualpayment(Request $request)
		{
			
			$user 				=  Auth::user();
			$name 				=  Auth::user()->NOMBRES. ' - '. Auth::user()->NOMBREARTISTICO;	
			
			try {
				$pagoUser = Pago::create([
							'USER_ID' => $request->IDUSUARIO,
							'MONTO' => $request->mont,
							'PAYPALID' => "Pago manual"
						]);
			} catch(\Exception $e){
						
				$error=substr($e->getMessage(),1,50);						
				return redirect()->back()->with('errors', 'Ocurrió un error. '.$e);						
						
			}
	
			return redirect()->back()->with('success','El pago se registró correctamente');
			
		}
		
		
		
		/***************************************************************************************************************
		 ******* CANCELAR PAGOS DESDE ADMINISTRADOR
		 /**************************************************************************************************************/
		 //Open profile view with the data
		public function cancelpayment(Request $request)
		{
			
			 $idpago = $request->get('IDPAGO');
			 $motivo = $request->get('motivo');
				 
			 DB::table('PAGOS')
							 ->where('IDPAGO', $idpago)
							 ->update(['STATUS' => '2', 'MOTIVOCANCELACION' => $motivo ]);	//status 2 cancelado																 

			 return redirect()->back()->with('success','El pago se canceló correctamente.');
			
		}
		
		
		/***************************************************************************************************************
		 ******* EDITAR PAGOS DESDE ADMINISTRADOR
		 /**************************************************************************************************************/
		 //Open profile view with the data
		public function editpayment(Request $request)
		{
			
			 $idpago = $request->get('IDPAGO');
			 $confirmar = $request->get('confirmar');
				 
			 DB::table('PAGOS')
							 ->where('IDPAGO', $idpago)
							 ->update(['STATUS' => '1']);	//status 1 confirmado																 

			 return redirect()->back()->with('success','El pago se confirmó correctamente.');
			
		}
		
												

		/***************************************************************************************************************
		******* ACTUALIZAR PERFIL DESDE PARTICIPANTE
		/**************************************************************************************************************/
    	//ACO: Update the user information, the flow is:
		//In order to update also the Auth object, we will use the standar API
		//We will get the data from GUI and call AUTH save
    	//
		public function update(Request $request)	{
		  $user = Auth::user();
		  //Set values to update.
			if (request()->has('nombres')) {( !empty($request->get('nombres'))  ? $user->NOMBRES = $request->get('nombres') : null );}
			if (request()->has('nombreartistico')) {( !empty($request->get('nombreartistico'))  ? $user->NOMBREARTISTICO = $request->get('nombreartistico') : null );}
			if (request()->has('telefono')) {( !empty($request->get('telefono'))  ? $user->TELEFONO = $request->get('telefono') : null );}
			if (request()->has('facebook')) {( !empty($request->get('facebook'))  ? $user->FACEBOOK = $request->get('facebook') : null );}
			if (request()->has('nivel')) {( !empty($request->get('nivel'))  ? $user->NIVEL = $request->get('nivel') : null );}
			if (request()->has('edad')) {( !empty($request->get('edad'))  ? $user->FNAC = $request->get('edad') : null );}
			if (request()->has('email')) {( !empty($request->get('email'))  ? $user->EMAIL = $request->get('email') : null );}
			
			if (request()->has('gustos')) {( !empty($request->get('gustos'))  ? $user->GUSTOS = $request->get('gustos') : null );}
			if (request()->has('canciones')) {( !empty($request->get('canciones'))  ? $user->CANCIONES = $request->get('canciones') : null );}
			if (request()->has('generono')) {( !empty($request->get('generono'))  ? $user->GENERONO = $request->get('generono') : null );}
			if (request()->has('generosi')) {( !empty($request->get('generosi'))  ? $user->GENEROSI = $request->get('generosi') : null );}
			
			$this->validate($request, [
				'input_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			]);
			
			try {
				
				if ($request->hasFile('input_img')) {
					//removing file if exists
					//$image_path = "/perfiles/".$user->SRCPERFIL;  // Value is not URL but directory file path
					if($user->SRCPERFIL!=""){
						$file_path = 'perfiles/'.$user->SRCPERFIL;
						//Storage::delete('public/'.$file_path);
						unlink($file_path);
					}
					//if(File::exists($file_path)) {
					//	File::delete($file_path);
					//}
					
					$image = $request->file('input_img');
					$name = time().'.'.$image->getClientOriginalExtension();
					$destinationPath = public_path('/perfiles');
					$image->move($destinationPath, $name);
					$user->SRCPERFIL = $name;															
				}
				
		  		$user->save();
					return redirect('perfil')->with('success', 'La información se actualizó correctamente.');
			 }catch(\Illuminate\Database\QueryException $e){
 			 		//dd($e); //DECIDE WHAT TO DO WITH REAL EX
				  return redirect('perfil')->with('errors', 'Hubo un error al actualizar, intente mas tarde.'); 
				 }
		}


		/***************************************************************************************************************
		******* ACTUALIZAR PASSWORD DESDE PARTICIPANTE
		/**************************************************************************************************************/
		//ACO: this is to change the password
		public function changePassword(Request $request){

			if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
				// The passwords matches
				return redirect()->back()->with("errors","El actual password que indico no es correcto. Por favor intente de nuevo.");
			}

			if(strcmp($request->get('current-password'), $request->get('pass')) == 0){
				//Current password and new password are same
				return redirect()->back()->with("errors","Su nuevo password no puede ser igual que el actual. Por favor eliga un nuevo password.");
			}

			$validatedData = $request->validate([
				'current-password' => 'required',
				'pass' => 'required|string|min:6|confirmed',
							'pass_confirmation' => 'required|string|min:6'
			]);

			//Change Password
			$user = Auth::user();
			$user->password = bcrypt($request->get('pass'));
			$user->save();

			return redirect()->back()->with("success","El password fue actualizado correctamente!");

		}
		
	
	/***************************************************************************************************************
	******* ADMINISTRADOR
	/**************************************************************************************************************/
		
		
		/***************************************************************************************************************
		 ******* VER PARTICIPANTES DESDE ADMINISTRADOR
		 /**************************************************************************************************************/
		 //Open profile view with the data
		public function participantes(Request $request)
		{
				

				$user 				=  Auth::user();
				if($user->ROL==1){ return redirect('sistema'); }
				$name 				=  Auth::user()->NOMBRES. ' - '. Auth::user()->NOMBREARTISTICO;
				//obtiene las notificaciones y cantidad de pedidos
				$menuData = Helper::getMenuData($user);
				
				if($user->ROL==2){ 
					if (request()->has('searchPars')){
						$filters = request()->searchPars;
					}else{
						$filters = null;
					}
	
					if ($filters != null) {
							$participantes = User::
								where('ROL', '1' )
								->whereIn('STATUS', [0, 1])
								->where(function($query) use ($filters)
							{
								$query->where('NOMBRES', 'like',  '%' .$filters. '%')
									->orWhere('NOMBREARTISTICO', 'like', '%' .$filters. '%')
									->orWhere('EMAIL', 'like', '%' .$filters. '%')
									->orWhere('TELEFONO', 'like', '%' .$filters. '%');
							})
								->get();
	
	
					}else{
							$participantes = User::where('ROL', '1' )
												->whereIn('STATUS', [0, 1])
																			->get();
					}
					
					$index = 0;
					foreach($participantes as $participante){
						$pagos = DB::table('PAGOS')
													 ->join('USUARIOS', 'PAGOS.USER_ID', '=', 'USUARIOS.IDUSUARIO')
													 ->where('USER_ID',$participante->IDUSUARIO)
													 ->select('PAGOS.*')
													 ->get();					
						$participantes[$index]->TOTALPAGOS = collect($pagos)->where('STATUS',1)->sum('MONTO');
						$participantes[$index]->PAGOS = $pagos;
						
						$mensajes = DB::table('MENSAJES')													 
													 ->where('EMISOR',$participante->IDUSUARIO)
													 ->where('RECEPTOR',1)
													 ->where('LEIDO',0)
													 ->get();	
						$participantes[$index]->TOTALMENSAJES = $mensajes->count();
						
						$index++;
					}												
	
					return view('sistema.participantes')->with('user',$user)
																			->with('name',$name)
																			->with('filters',$filters)
																			->with('menudata',$menuData)
																			->with(compact('participantes'));
				}
				if($user->ROL==3){ 
					
					$eventos = Evento::where('EVENTOS.STATUS',1)->where("EVENTOS.COACH",$user->IDUSUARIO)->join('USUARIOS', 'USUARIOS.IDUSUARIO', '=', 'EVENTOS.COACH')->select('EVENTOS.*','USUARIOS.NOMBRES','USUARIOS.NOMBREARTISTICO','USUARIOS.SRCPERFIL')->orderBy("IDEVENTO","ASC")->get();
					
					foreach($eventos as $evento){
						$participantes = DB::table('PARTICIPANTESXEVENTOS')
													 ->join('USUARIOS', 'PARTICIPANTESXEVENTOS.USER_ID', '=', 'USUARIOS.IDUSUARIO')
													 ->join('EVENTOS', 'EVENTOS.IDEVENTO', '=', 'PARTICIPANTESXEVENTOS.EVENTO_ID')
													 ->where('EVENTO_ID',$evento->IDEVENTO)
													 ->select('USUARIOS.*','PARTICIPANTESXEVENTOS.IDPAREV')
													 ->get();												 
																			
						$index=0;						
						foreach($participantes as $participante){
							
							$canciones = DB::table('CANCIONES')
													 ->where('EVENTO_ID',$evento->IDEVENTO)
													 ->where('USER_ID',$participante->IDUSUARIO)
													 ->get();
							
							$participante->CANCIONES = $canciones;	
							
							$mensajes = DB::table('MENSAJES')													 
													 ->where('EMISOR', $participante->IDUSUARIO)
													 ->where('RECEPTOR', $user->IDUSUARIO)
													 ->where('LEIDO',0)
													 ->get();	
							$participante->TOTALMENSAJES = $mensajes->count();
													
						}
						$evento->PARTICIPANTES = $participantes;
												
					}
					//dd($eventos);
					return view('sistema.participantescoach')->with('user',$user)
																			->with('name',$name)
																			->with('menudata',$menuData)
																			->with(compact('eventos'));
					
				}
		}
		
		
		
		/***************************************************************************************************************
		******* ELIMINAR PARTICIPANTES DESDE ADMINISTRADOR
		/**************************************************************************************************************/
		/* delete the specified resource from storage.
 		*
 		* @param  int  $id
 		* @return \Illuminate\Http\Response
 		*/
		 public function destroy(Request $request)
		 {
				 $idusuario = $request->get('IDUSUARIO');
				 /*$direccion = Direccion::find($iddireccion);
		  		 $direccion->delete();*/
				
				$participantesineventos = DB::table('PARTICIPANTESXEVENTOS')
					->join('USUARIOS', 'USER_ID', '=', 'USUARIOS.IDUSUARIO')					
					->whereIn('USUARIOS.STATUS',[0,1])
					->where('USER_ID',$idusuario)
					->count();	
				$pagosparticipante = DB::table('PAGOS')
				    ->join('USUARIOS', 'USER_ID', '=', 'USUARIOS.IDUSUARIO')					
					->whereIn('USUARIOS.STATUS',[0,1])
					->where('USER_ID',$idusuario)
					->whereIn('PAGOS.STATUS',[1,3])
					->count();
				if($participantesineventos==0 && $pagosparticipante==0){				
					 //DB::table('USUARIOS')
					//		 ->where('IDUSUARIO', $idusuario)
					//		 ->update(['STATUS' => '2']);	//status 2 eliminado
					$usuario = User::find($idusuario);
					 $usuario->delete();
					
					
					 return redirect()->back()->with('success','El participante se eliminó correctamente.');
				}
				else{
				 	 return redirect()->back()->with('errors','El participante esta asignado a otra entidad (pagos/eventos), no se puede eliminar.');
				}
		 }
		
		
		
		/***************************************************************************************************************
		 ******* GUARDAR PARTICIPANTES DESDE ADMINISTRADOR
		 /**************************************************************************************************************/
		 /* Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request  $request
		 * @return \Illuminate\Http\Response
		 */
		 public function store(Request $request)
		 {
			     try {
					 	 $tipoUsuario=1;
						 $status=1;
						 
						 $participante= new User();						 
						 $participante->nombres = $request->get('nombres');
						 $participante->nombreartistico = $request->get('nombreartistico');		
						 $participante->telefono = $request->get('telefono');	
						 $participante->facebook = $request->get('facebook');	
						 $participante->nivel = $request->get('nivel');			 
						 $participante->password = bcrypt($request->get('password'));
						 $participante->fnac = $request->get('edad');
						 $participante->email = $request->get('email');
						 
						 $participante->gustos = $request->get('gustos');
						 $participante->canciones = $request->get('canciones');
						 $participante->generono = $request->get('generono');
						 $participante->generosi = $request->get('generosi');
						 
						 $participante->rol = $tipoUsuario;
						 $participante->status = $status;
						 $participante->save();						 						 						 
	
				 } catch(\Exception $e){
						//if there is an error/exception in the above code before commit, it'll rollback
						//$log= new Log();
						//$log->IDUSUARIO =  Auth::user()->IDUSUARIO;
						//$log->ERROR =  substr($e->getMessage(),1,500);
						$error=substr($e->getMessage(),1,50);
						//$log->save();
						//if (request()->has('from')){
						//	 if ( $request->get('from')=="pedido" ){
						//			 return response()->json($e, 500);
						//	 }
						//}else {
						if($e->getCode()==23000){
							return redirect()->back()->with('errors', 'Ocurrió un error, ya existe un usuario registrado con ese email.');
						}
						else{
							return redirect()->back()->with('errors', 'Ocurrió un error. '.$e);
						}
						//}
				 }
	
				 return redirect()->back()->with('success', 'El participante se insertó correctamente.');
				 
		 }
		
		
		/***************************************************************************************************************
		******* ACTUALIZAR PARTICIPANTE DESDE ADMINISTRADOR
		/**************************************************************************************************************/
    	//ACO: Update the user information, the flow is:
		//In order to update also the Auth object, we will use the standar API
		//We will get the data from GUI and call AUTH save
    	//
		public function updatefadmin(Request $request)	{
			
		   $participante= User::firstOrNew(['IDUSUARIO' => $request->get('IDUSUARIO')]);
		   //$participante->exists = true;
		   //$participante->idusuario = $request->get('IDUSUARIO');
			
			//Set values to update.
			if (request()->has('nombres')) {( !empty($request->get('nombres'))  ? $participante->nombres = $request->get('nombres') : null );}
			if (request()->has('nombreartistico')) {( !empty($request->get('nombreartistico'))  ? $participante->nombreartistico = $request->get('nombreartistico') : null );}
			if (request()->has('telefono')) {( !empty($request->get('telefono'))  ? $participante->telefono = $request->get('telefono') : null );}
			if (request()->has('facebook')) {( !empty($request->get('facebook'))  ? $participante->facebook = $request->get('facebook') : null );}
			if (request()->has('nivel')) {( !empty($request->get('nivel'))  ? $participante->nivel = $request->get('nivel') : null );}
			if (request()->has('edad')) {( !empty($request->get('edad'))  ? $participante->fnac = $request->get('edad') : null );}
			if (request()->has('email')) {( !empty($request->get('email'))  ? $participante->email = $request->get('email') : null );}
			if (request()->has('newpassword')) {( !empty($request->get('newpassword'))  ? $participante->password = bcrypt($request->get('newpassword')) : null );}
			
			if (request()->has('gustos')) {( !empty($request->get('gustos'))  ? $participante->GUSTOS = $request->get('gustos') : null );}
			if (request()->has('canciones')) {( !empty($request->get('canciones'))  ? $participante->CANCIONES = $request->get('canciones') : null );}
			if (request()->has('generono')) {( !empty($request->get('generono'))  ? $participante->GENERONO = $request->get('generono') : null );}
			if (request()->has('generosi')) {( !empty($request->get('generosi'))  ? $participante->GENEROSI = $request->get('generosi') : null );}
			
			//dd(request());
			try {
		  		$participante->save();
					return redirect()->back()->with('success', 'La información se actualizó correctamente.');
			 }catch(\Illuminate\Database\QueryException $e){
				//dd($e); //DECIDE WHAT TO DO WITH REAL EX
			  return redirect()->back()->with('errors', 'Hubo un error al actualizar, intente mas tarde.'.$e);
			 }
		}
		
		
		
		
		
		/***************************************************************************************************************
		 ******* VER COACHES DESDE ADMINISTRADOR
		 /**************************************************************************************************************/
		 //Open profile view with the data
		public function coaches(Request $request)
		{
				
				$user 				=  Auth::user();
				if($user->ROL!=2){ return redirect('sistema'); }
				$name 				=  Auth::user()->NOMBRES. ' - '. Auth::user()->NOMBREARTISTICO;
				
				if (request()->has('searchPars')){
					$filters = request()->searchPars;
				}else{
					$filters = null;
				}

				if ($filters != null) {
					  	$coaches = User::
							where('ROL', '3' )
							->whereIn('STATUS', [0, 1])
							->where(function($query) use ($filters)
        				{
            				$query->where('NOMBRES', 'like',  '%' .$filters. '%')
                  				->orWhere('NOMBREARTISTICO', 'like', '%' .$filters. '%')
								->orWhere('EMAIL', 'like', '%' .$filters. '%')
								->orWhere('TELEFONO', 'like', '%' .$filters. '%');
        				})
							->get();


				}else{
						$coaches = User::where('ROL', '3' )
											->whereIn('STATUS', [0, 1])
																		->get();
				}
				
				$index = 0;
												
				//obtiene las notificaciones y cantidad de pedidos
				$menuData = Helper::getMenuData($user);

				return view('sistema.coaches')->with('user',$user)
																		->with('name',$name)
																		->with('filters',$filters)
																		->with('menudata',$menuData)
																		->with(compact('coaches'));
		}
		
		
		
		/***************************************************************************************************************
		******* ELIMINAR COACHES DESDE ADMINISTRADOR
		/**************************************************************************************************************/
		/* delete the specified resource from storage.
 		*
 		* @param  int  $id
 		* @return \Illuminate\Http\Response
 		*/
		 public function destroycoaches(Request $request)
		 {
				 $idusuario = $request->get('IDUSUARIO');
				 /*$direccion = Direccion::find($iddireccion);
		   $direccion->delete();*/
				
				 $coachesineventos = DB::table('EVENTOS')
				    ->join('USUARIOS', 'COACH', '=', 'USUARIOS.IDUSUARIO')					
					->whereIn('USUARIOS.STATUS',[0,1])				 					
					->whereIn('EVENTOS.STATUS',[1])
					->where('COACH',$idusuario)
					->count();	
				 
				 if($coachesineventos==0){
					 //DB::table('USUARIOS')
					//		 ->where('IDUSUARIO', $idusuario)
					//		 ->update(['STATUS' => '2']);	//status 2 eliminado
					 $usuario = User::find($idusuario);
					 $usuario->delete();	
					 	
					 return redirect()->back()->with('success','El coach se eliminó correctamente.'); 
				 }
				 else{
				 	 return redirect()->back()->with('errors','El coach esta asignado a un evento, no se puede eliminar.');
				 }
		 }
		
		
		
		/***************************************************************************************************************
		 ******* GUARDAR COACHES DESDE ADMINISTRADOR
		 /**************************************************************************************************************/
		 /* Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request  $request
		 * @return \Illuminate\Http\Response
		 */
		 public function storecoaches(Request $request)
		 {
			     try {
					 	 $tipoUsuario=3;
						 $status=1;
						 
						 $coach= new User();						 
						 $coach->nombres = $request->get('nombres');
						 $coach->nombreartistico = $request->get('nombreartistico');		
						 $coach->telefono = $request->get('telefono');				 
						 $coach->password = bcrypt($request->get('password'));
						 $coach->fnac = $request->get('edad');
						 $coach->email = $request->get('email');
						 $coach->rol = $tipoUsuario;
						 $coach->status = $status;
						 $coach->save();						 						 						 
	
				 } catch(\Exception $e){
						//if there is an error/exception in the above code before commit, it'll rollback
						//$log= new Log();
						//$log->IDUSUARIO =  Auth::user()->IDUSUARIO;
						//$log->ERROR =  substr($e->getMessage(),1,500);
						$error=substr($e->getMessage(),1,50);
						//$log->save();
						//if (request()->has('from')){
						//	 if ( $request->get('from')=="pedido" ){
						//			 return response()->json($e, 500);
						//	 }
						//}else {
						if($e->getCode()==23000){
							return redirect()->back()->with('errors', 'Ocurrió un error, ya existe un usuario registrado con ese email.');
						}
						else{
							return redirect()->back()->with('errors', 'Ocurrió un error. '.$e);
						}
						//}
				 }
	
				 return redirect()->back()->with('success', 'El coach se insertó correctamente.');
				 
		 }
		
		
		/***************************************************************************************************************
		******* ACTUALIZAR COACHES DESDE ADMINISTRADOR
		/**************************************************************************************************************/
    	//ACO: Update the user information, the flow is:
		//In order to update also the Auth object, we will use the standar API
		//We will get the data from GUI and call AUTH save
    	//
		public function updatecoaches(Request $request)	{
			
		   $coach= User::firstOrNew(['IDUSUARIO' => $request->get('IDUSUARIO')]);
		   //$participante->exists = true;
		   //$participante->idusuario = $request->get('IDUSUARIO');
			
			//Set values to update.
			if (request()->has('nombres')) {( !empty($request->get('nombres'))  ? $coach->nombres = $request->get('nombres') : null );}
			if (request()->has('nombreartistico')) {( !empty($request->get('nombreartistico'))  ? $coach->nombreartistico = $request->get('nombreartistico') : null );}
			if (request()->has('telefono')) {( !empty($request->get('telefono'))  ? $coach->telefono = $request->get('telefono') : null );}
			if (request()->has('edad')) {( !empty($request->get('edad'))  ? $coach->fnac = $request->get('edad') : null );}
			if (request()->has('email')) {( !empty($request->get('email'))  ? $coach->email = $request->get('email') : null );}
			if (request()->has('newpassword')) {( !empty($request->get('newpassword'))  ? $coach->password = bcrypt($request->get('newpassword')) : null );}
			//dd($participante->idusuario);
			try {
		  		$coach->save();
					return redirect()->back()->with('success', 'La información se actualizó correctamente.');
			 }catch(\Illuminate\Database\QueryException $e){
				//dd($e); //DECIDE WHAT TO DO WITH REAL EX
			  return redirect()->back()->with('errors', 'Hubo un error al actualizar, intente mas tarde.');
			 }
		}
		
		
		/***************************************************************************************************************
		******* VER RECIBO
		/**************************************************************************************************************/
		public function recibo(Request $request)
		{
				
				
				$user 				=  Auth::user();
				
				if(!request()->has('IDPAGO')){ return redirect('sistema'); }
				if($user->ROL==3){ return redirect('sistema'); }
				$name 				=  Auth::user()->NOMBRES. ' - '. Auth::user()->NOMBREARTISTICO;	
				//obtiene las notificaciones y cantidad de pedidos
				$menuData = Helper::getMenuData($user);
				
				$idpago = $request->IDPAGO;
				
				$pago = DB::table("PAGOS")				
				->where('IDPAGO',$idpago)
				->whereIn('PAGOS.STATUS',[1,3])
				->join('USUARIOS', 'USUARIOS.IDUSUARIO', '=', 'PAGOS.USER_ID')
				->select('PAGOS.*','USUARIOS.NOMBRES','USUARIOS.EMAIL')
				->get();
					
				
				//dd($pago);
				return view('sistema.recibo')->with('user',$user)
																		->with('name',$name)
																		->with('menudata',$menuData)
																		//->with('administrador',$administrador)
																		//->with('usuario',$usuario)
																		->with(compact('pago'));
				
				
		}
		
		public function participantescsv(Request $request){
			
			
			$headers = array(
				"Content-type" => "text/csv; charset=utf-8",
				"Content-Disposition" => "attachment; filename=ListadoParticipantes.csv",
				"Pragma" => "no-cache",
				"Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
				"Expires" => "0"
			);
		
			$participantes = User::where('ROL', '1' )
												->whereIn('STATUS', [0, 1])
												->get();
												
			$columns = array('Email', 'Nombre', 'Nombre artistico', 'Telefono', 'Fecha Nac.', 'Nivel', 'Gustos', 'Canciones', 'Genero No', 'Genero Fav.');
		
			$callback = function() use ($participantes, $columns)
			{
				$file = fopen('php://output', 'w');
				fputcsv($file, $columns);
				foreach($participantes as $review) {
					fputcsv($file, array($review->EMAIL, utf8_decode($review->NOMBRES), utf8_decode($review->NOMBREARTISTICO), $review->TELEFONO, $review->FNAC, $review->NIVEL, utf8_decode($review->GUSTOS), utf8_decode($review->CANCIONES), utf8_decode($review->GENERONO), utf8_decode($review->GENEROSI)));
				}
				fclose($file);
			};
			return Response::stream($callback, 200, $headers);
			
			//return redirect()->back();
			
		}
		
		

}
